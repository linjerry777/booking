<?php
require_once("../db-connect2.php");

if (!isset($_POST["account"])) {
    echo "請循正常管道進入本頁";
    exit;
}
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



// date_default_timezone_set("Asia/Taipei");
$now = date('Y-m-d H:i:s');


// echo "$name, $phone, $email, $now";

$sql = "INSERT INTO hotel_account (account,password,name, address, company_name,company_phone, stars,area,created_at,bank_account,start_date,email,website,valid)
VALUES ('$account','$password','$name', '$address', '$company_name','$company_phone','$stars','$area', '$now','$bank_account','$start_date','$email','$website',1)";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "新增資料完成, id: $last_id";
} else {
    echo "新增資料錯誤: " . $conn->error;
}

$conn->close();

header("location: admin.php");
