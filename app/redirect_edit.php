<?php

if(isset($_POST['id'])){
    require '../db_conn.php';

    $id = $_POST['id'];
    header("Location: ../update.php?id=".$id);

}else {
    header("Location: ../index.php?mess=error");
}