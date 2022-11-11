<?php
require_once("../db-connect2.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入本頁";
    exit;
}
$id = $_POST["id"];
$name = $_POST["name"];
$code = $_POST["code"];
$description = $_POST["description"];
$expire_date = $_POST["expire_date"];
$discount = $_POST["discount"];


$sql = "UPDATE coupon SET name='$name', code='$code', description='$description' ,expire_date='$expire_date', discount='$discount' WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}

header("location: admin.php");
