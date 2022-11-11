<?php
require_once("../db-connect2.php");
$id=$_GET["id"];
$sql="UPDATE travel_account SET valid=0 WHERE id='$id'"; //軟刪除
// $sql="DELETE FROM users WHERE id='$id'"; 真刪除
if ($conn->query($sql) === TRUE) {
    echo "刪除成功";
    header("location: admin-travel.php");
} else {
    echo "刪除資料錯誤: " . $conn->error;
}
