<?php
require_once("../db-connect2.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入本頁";
    exit;
}

if (!isset($_POST["account"])) {
    echo "請循正常管道進入本頁";
    exit;
}
$id = $_POST["id"];
$account = $_POST["account"];
$password = $_POST["password"];
$name = $_POST["name"];
$address = $_POST["address"];
$company_name = $_POST["company_name"];
$company_phone = $_POST["company_phone"];
$stars = $_POST["stars"];
$area = $_POST["area"];
$bank_account = $_POST["bank_account"];
$start_date = $_POST["start_date"];
$email = $_POST["email"];
$website = $_POST["website"];

if ($area == "北") {
    $area = 0;
} else if ($area == "中") {
    $area = 1;
} else {
    $area = 2;
}

$sql = "UPDATE hotel_account SET account = '$account', password = '$password', name='$name', address='$address', company_name='$company_name' ,company_phone='$company_phone', stars='$stars',area='$area', bank_account= '$bank_account', start_date = '$start_date',email = '$email',website = '$website' WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}

header("location: hotel-account.php?id=" . $id);
