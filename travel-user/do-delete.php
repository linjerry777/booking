<?php 

require_once ('./db-connect.php');
require_once ('./var_dump_pre.php');

var_dump_pre($_GET);

$productName = $_GET["product"];

$sql = "UPDATE trip_event SET valid = 0 WHERE trip_name = '$productName'";

if ($conn->query($sql) === TRUE) {
    echo "刪除成功";
    // header("location: travel-trip-event-grid-test.php");
} else {
    echo "刪除資料錯誤: " . $conn->error;
}


?>