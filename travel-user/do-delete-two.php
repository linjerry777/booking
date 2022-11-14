<?php
require_once('var_dump_pre.php');
require_once("../../db-connect2.php");

session_start();

//刪除對象
var_dump_pre($_GET);
//回歸哪裡
$location = $_SESSION['del_location'];
// var_dump_pre($location);


$productName = $_GET["product"];

$sql = "UPDATE trip_event SET valid = 2 WHERE trip_name = '$productName'";

if ($conn->query($sql) === TRUE) {
    echo "刪除成功";
    header("location:$location");
} else {
    echo "刪除資料錯誤: " . $conn->error;
}
