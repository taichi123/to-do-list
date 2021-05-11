<?php

if(isset($_POST['id'])){
    require '../db_conn.php';

    $id = $_POST['id'];
    $title = $_POST['title'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];

    if(empty($id)){
        echo 'error';
    }else {

        $stmt = $conn->prepare("UPDATE works SET title=?, start_date=?, end_date=?, status=? WHERE id=?");
        $res = $stmt->execute([$title, $start_date,$end_date, $status,$id]);

        $conn = null;
        header("Location: ../index.php");
        exit();
    }
}else {
    header("Location: ../index.php?mess=error");
}