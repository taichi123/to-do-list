<?php

if(isset($_POST['title'])){
    require '../db_conn.php';

    $title = $_POST['title'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if(empty($title)){
        header("Location: ../index.php?mess=error");
    }else {
        $stmt = $conn->prepare("INSERT INTO works(title,start_date,end_date) VALUE(?,?,?)");
        $res = $stmt->execute([$title, $start_date,$end_date]);

        if($res){
            header("Location: ../index.php?mess=success");
        }else {
            header("Location: ../index.php");
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: ../index.php?mess=error");
}