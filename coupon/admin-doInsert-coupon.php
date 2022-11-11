<?php
require_once("../db-connect2.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入本頁";
    exit;
}
$name = $_POST["name"];
$code = $_POST["code"];
$description = $_POST["description"];
$expire_date = $_POST["expire_date"];
$discount = $_POST["discount"];




// date_default_timezone_set("Asia/Taipei");
$now = date('Y-m-d H:i:s');

// echo "$name, $phone, $email, $now";

$sql = "INSERT INTO coupon (name,code,description,expire_date, discount,created_at,valid)
VALUES ('$name','$code','$description', '$expire_date', '$discount', '$now',1)";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "新增資料完成, id: $last_id";
} else {
    echo "新增資料錯誤: " . $conn->error;
}

$conn->close();

header("location: admin.php");
