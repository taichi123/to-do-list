<?php

require '../db_conn.php';

$sql = "SELECT id, title, status, start_date, end_date, CASE
     WHEN status=0  THEN 'Planing'
     WHEN status=1  THEN 'Doing'
     WHEN status=2  THEN 'Complete'
     ELSE 'Undefined'
     END as text_status FROM works";

$result = $conn->query($sql);

$rows = array();
while($res = $result->fetch(PDO::FETCH_ASSOC)){
    if(!isset($res['id'])) continue;
    $rows[$res['id']] = $res;
}
$conn = null;
echo json_encode(array_values($rows));
exit();


