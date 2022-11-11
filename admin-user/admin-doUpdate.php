<?php
require_once("../db-connect2.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入本頁";
    exit;
}

$id = $_POST["id"];
$name = $_POST["name"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$account = $_POST["account"];


$identification = $_POST["identification"];
$birthday = $_POST["birthday"];
$gender = $_POST["gender"];
/* if ($gender == 1) {
    $gender = 1;
} else {
    $gender = 0;
} */
// echo "$name, $phone, $email";
$sqlAccount = "SELECT * FROM users WHERE  email='$email'";
$result = $conn->query($sqlAccount);
$userCount = $result->num_rows;
if ($userCount > 0) {
    echo "該帳號及信箱已經存在";
    exit;
}

$sql = "UPDATE users SET name='$name', phone='$phone', email='$email' ,identification='$identification', birthday='$birthday',gender='$gender' WHERE id='$id'";



if ($conn->query($sql) === TRUE) {
    echo "更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}

header("location: admin-user-product.php?account=" . $account);
