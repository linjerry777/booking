<?php
require_once("../db-connect2.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入本頁";
    exit;
}

$account = $_POST["account"];
$password = $_POST["password"];
$name = $_POST["name"];
$phone = $_POST["phone"];
$email = $_POST["email"];

$identification = $_POST["identification"];
$birthday = $_POST["birthday"];
$gender = $_POST["gender"];
if ($gender == "男") {
    $gender = 1;
} else {
    $gender = 0;
}
$sqlAccount = "SELECT * FROM users WHERE account='$account' OR email='$email'";
$result = $conn->query($sqlAccount);
$userCount = $result->num_rows;
if ($userCount > 0) {
    echo "該帳號及信箱已經存在";
    exit;
}


// date_default_timezone_set("Asia/Taipei");
$now = date('Y-m-d H:i:s');

// echo "$name, $phone, $email, $now";

$sql = "INSERT INTO users (account,password,name ,phone, email,identification, birthday,gender,created_at,valid)
VALUES ('$account','$password','$name', '$phone', '$email','$identification','$birthday','$gender', '$now',1)";

$result = $conn->query($sql);
$userCount = $result->num_rows;

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "新增資料完成, id: $last_id";
} else {
    echo "新增資料錯誤: " . $conn->error;
}

$conn->close();

// header("location: admin.php");
