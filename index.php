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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="main-section">
    <div class="add-section">
        <form action="app/add.php" method="POST" autocomplete="off">
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
    <div class="show-todo-section">
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
                        class="edit-to-do">Edit</button>

            </div>
        <?php } ?>
    </div>
</div>

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery.redirect.js"></script>


<script>
    $(document).ready(function(){
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