<?php
require 'db_conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To-Do List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="main-section">
    <div class="add-section">
        <form action="app/add.php" method="POST" autocomplete="off">
            <a data-toggle="collapse" class="btn btn-primary" href="#works">Show/Hide Works</a>
            <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                <input type="text"
                       name="title"
                       style="border-color: #ff6666"
                       placeholder="This field is required" />

            <?php }else{ ?>
                <input type="text"
                       name="title"
                       placeholder="What do you need to do?" />
                <input name="start_date" type="datetime-local"
                       placeholder="Start date">
                <input name="end_date" type="datetime-local"
                       placeholder="End date">
            <?php } ?>
            <button type="submit">Add &nbsp; <span>&#43;</span></button>
        </form>
    </div>
    <?php
    $todos = $conn->query("SELECT * FROM works ORDER BY id DESC");
    ?>
    <div id="works" class="show-todo-section collapses">
        <?php if($todos->rowCount() <= 0){ ?>
            <div class="todo-item">
                <div class="empty">
                    <img src="img/f.png" width="100%" />
                    <img src="img/Ellipsis.gif" width="80px">
                </div>
            </div>
        <?php } ?>

        <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
        <?php  ?>
            <!-- cần hằng số hóa status: 0:planning, 1:doing, 2:complete -->
            <div class="todo-item
            <?php if ($todo['status'] == 0) {?>
            bRed
             <?php } elseif ($todo['status'] == 1) {?>
            bYellow
            <?php } else { ?>
            bGreen
            <?php }?>" >
                    <span id="<?php echo $todo['id']; ?>"
                          class="remove-to-do">x</span>

                <h2><?php echo $todo['title'] ?></h2>
                <br>
                <small>start date: <?php echo $todo['start_date'] ?></small>
                <br>
                <small>end date: <?php echo $todo['end_date'] ?></small>

                <button id="edit<?php echo $todo['id']; ?>"
                        class="edit-to-do">&#8594;</button>

            </div>
        <?php } ?>
    </div>
    <div id="holder" class="row" ></div>
</div>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery.redirect.js"></script>

<script type="text/tmpl" id="tmpl">
  {{
  var date = date || new Date(),
      month = date.getMonth(),
      year = date.getFullYear(),
      first = new Date(year, month, 1),
      last = new Date(year, month + 1, 0),
      startingDay = first.getDay(),
      thedate = new Date(year, month, 1 - startingDay),
      dayclass = lastmonthcss,
      today = new Date(),
      i, j;
  if (mode === 'week') {
    thedate = new Date(date);
    thedate.setDate(date.getDate() - date.getDay());
    first = new Date(thedate);
    last = new Date(thedate);
    last.setDate(last.getDate()+6);
  } else if (mode === 'day') {
    thedate = new Date(date);
    first = new Date(thedate);
    last = new Date(thedate);
    last.setDate(thedate.getDate() + 1);
  }

  }}
  <table class="calendar-table table table-condensed table-tight" style="background:white">
    <thead>
      <tr>
        <td colspan="7" style="text-align: center">
          <table style="white-space: nowrap; width: 100%">
            <tr>
              <td style="text-align: left;">
                <span class="btn-group">
                  <button class="js-cal-prev btn btn-default"><</button>
                  <button class="js-cal-next btn btn-default">></button>
                </span>
                <button class="js-cal-option btn btn-default {{: first.toDateInt() <= today.toDateInt() && today.toDateInt() <= last.toDateInt() ? 'active':'' }}" data-date="{{: today.toISOString()}}" data-mode="month">{{: todayname }}</button>
              </td>
              <td>
                <span class="btn-group btn-group-lg">
                  {{ if (mode !== 'day') { }}
                    {{ if (mode === 'month') { }}<button class="js-cal-option btn btn-link" data-mode="year">{{: months[month] }}</button>{{ } }}
                    {{ if (mode ==='week') { }}
                      <button class="btn btn-link disabled">{{: shortMonths[first.getMonth()] }} {{: first.getDate() }} - {{: shortMonths[last.getMonth()] }} {{: last.getDate() }}</button>
                    {{ } }}
                    <button class="js-cal-years btn btn-link">{{: year}}</button>
                  {{ } else { }}
                    <button class="btn btn-link disabled">{{: date.toDateString() }}</button>
                  {{ } }}
                </span>
              </td>
              <td style="text-align: right">
                <span class="btn-group">
                  <button class="js-cal-option btn btn-default {{: mode==='year'? 'active':'' }}" data-mode="year">Year</button>
                  <button class="js-cal-option btn btn-default {{: mode==='month'? 'active':'' }}" data-mode="month">Month</button>
                  <button class="js-cal-option btn btn-default {{: mode==='week'? 'active':'' }}" data-mode="week">Week</button>
                  <button class="js-cal-option btn btn-default {{: mode==='day'? 'active':'' }}" data-mode="day">Day</button>
                </span>
              </td>
            </tr>
          </table>

        </td>
      </tr>
    </thead>
    {{ if (mode ==='year') {
      month = 0;
    }}
    <tbody>
      {{ for (j = 0; j < 3; j++) { }}
      <tr>
        {{ for (i = 0; i < 4; i++) { }}
        <td class="calendar-month month-{{:month}} js-cal-option" data-date="{{: new Date(year, month, 1).toISOString() }}" data-mode="month">
          {{: months[month] }}
          {{ month++;}}
        </td>
        {{ } }}
      </tr>
      {{ } }}
    </tbody>
    {{ } }}
    {{ if (mode ==='month' || mode ==='week') { }}
    <thead>
      <tr class="c-weeks">
        {{ for (i = 0; i < 7; i++) { }}
          <th class="c-name">
            {{: days[i] }}
          </th>
        {{ } }}
      </tr>
    </thead>
    <tbody>
      {{ for (j = 0; j < 6 && (j < 1 || mode === 'month'); j++) { }}
      <tr>
        {{ for (i = 0; i < 7; i++) { }}
        {{ if (thedate > last) { dayclass = nextmonthcss; } else if (thedate >= first) { dayclass = thismonthcss; } }}
        <td class="calendar-day {{: dayclass }} {{: thedate.toDateCssClass() }} {{: date.toDateCssClass() === thedate.toDateCssClass() ? 'selected':'' }} {{: daycss[i] }} js-cal-option" data-date="{{: thedate.toISOString() }}">
          <div class="date">{{: thedate.getDate() }}</div>
          {{ thedate.setDate(thedate.getDate() + 1);}}
        </td>
        {{ } }}
      </tr>
      {{ } }}
    </tbody>
    {{ } }}
    {{ if (mode ==='day') { }}
    <tbody>
      <tr>
        <td colspan="7">
          <table class="table table-striped table-condensed table-tight-vert" >
            <thead>
              <tr>
                <th> </th>
                <th style="text-align: center; width: 100%">{{: days[date.getDay()] }}</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th class="timetitle" >All Day</th>
                <td class="{{: date.toDateCssClass() }}">  </td>
              </tr>
              <tr>
                <th class="timetitle" >Before 6 AM</th>
                <td class="time-0-0"> </td>
              </tr>
              {{for (i = 6; i < 22; i++) { }}
              <tr>
                <th class="timetitle" >{{: i <= 12 ? i : i - 12 }} {{: i < 12 ? "AM" : "PM"}}</th>
                <td class="time-{{: i}}-0"> </td>
              </tr>
              <tr>
                <th class="timetitle" >{{: i <= 12 ? i : i - 12 }}:30 {{: i < 12 ? "AM" : "PM"}}</th>
                <td class="time-{{: i}}-30"> </td>
              </tr>
              {{ } }}
              <tr>
                <th class="timetitle" >After 10 PM</th>
                <td class="time-22-0"> </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
    {{ } }}
  </table>
</script>
<script src="js/main.js"></script>
<script>
    $(document).ready(function(){

        ////////////////////
        var data = [];
        var request = $.ajax({
            url: "app/select_all.php",
            method: "GET",
        });

        request.done(function(response){
            //if (response.success == true) {
            if (true) {
                var result = JSON.parse(response);
                for(i = 0; i < result.length; i ++ ) {
                    var work = result[i];
                    // dateStartParts = work.start_date.split('-');
                    //var dateEndParts = work.end_date.split('-');
                    data.push({ title: work.title,
                        start: new Date(work.start_date),
                        end: new Date(work.end_date),
                        allDay: false,
                        text: work.text_status,
                        status: work.text_status.toLowerCase()
                    });
                }
                data.sort(function(a,b) { return (+a.start) - (+b.start); });
                $('#holder').calendar({
                    data: data
                });
            }
        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
        //////////////////////////////////////

        $('.remove-to-do').click(function(){
            const id = $(this).attr('id');

            $.post("app/remove.php",
                {
                    id: id
                },
                (data)  => {
                    if(data){
                        $(this).parent().hide(600);
                    }
                }
            );
        });

        $('.edit-to-do').click(function(){
            const editId = $(this).attr('id');
            const id = editId.substr(4);
            $.redirect('app/redirect_edit.php', {'id': id},"POST","");
        });
    });
</script>
</body>
</html>