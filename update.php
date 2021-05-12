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
        <form action="app/edit.php" method="POST" autocomplete="off">
            <?php
            $todos = $conn->query("SELECT * FROM works WHERE id=".$_GET['id']);
            ?>
            <?php while($todo = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                <input type="hidden" name="id" value="<?php echo $todo['id'] ?>" >
                <input type="text"
                       name="title"
                       value="<?php echo $todo['title'] ?>"
                       placeholder="What do you need to do?" />
                <input name="start_date"
                       value="<?php echo strftime('%Y-%m-%dT%H:%M:%S', strtotime($todo['start_date'])) ?>"
                       type="datetime-local"
                       placeholder="Start date?">
                <input name="end_date"
                       value="<?php echo strftime('%Y-%m-%dT%H:%M:%S', strtotime($todo['end_date'])) ?>"
                       type="datetime-local"
                       placeholder="End date?">

                <div class="box">
                    <select name="status" class="box">
                        <option value="0" <?php if ($todo['status'] === '0'){ ?> selected="selected" <?php } ?>>Planning</option>
                        <option value="1" <?php if ($todo['status'] === '1'){ ?> selected="selected" <?php } ?>>Doing</option>
                        <option value="2" <?php if ($todo['status'] === '2'){ ?> selected="selected" <?php } ?>>Complete</option>
                    </select>
                </div>
                <br>
                <button type="submit">Update</button>
            <?php } ?>
        </form>
    </div>
</div>

<script src="js/jquery-3.2.1.min.js"></script>
</body>
</html>