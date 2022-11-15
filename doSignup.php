<?php
require_once("../db-connect2.php");
session_start();

$_SESSION["email"] = $_POST["email"];
$accessRight = $_POST["accessRight"];

$account = $_POST["account"];
$email = $_POST["email"];
$password = $_POST["password"];
$repassword = $_POST["repassword"];
$valid = $_POST["valid"];
$now = date('Y-m-d H:i:s');


if (empty($account)) {
    echo "請輸入帳號";
    exit;
}
$accountLength = strlen($account);

if ($accountLength < 4 || $accountLength > 20) {
    echo "請輸入4~20字元長度的帳號";
    exit;
}

if (empty($password)) {
    echo "請輸入密碼";
    exit;
}
if ($password != $repassword) {
    echo "密碼前後不一致";
    exit;
}


if ($accessRight == 1) {
    $sql = "SELECT * FROM users WHERE account='$account' OR email='$email'";
    $result = $conn->query($sql);
    $userCount = $result->num_rows;
    if ($userCount > 0) {
        echo "該帳號或信箱已經存在";
        exit;
    }
    // $password = md5($password);
    $sqlCreate = "INSERT INTO users (account,email,password,created_at,valid)
VALUES ('$account','$email','$password','$now','$valid')";

    if ($conn->query($sqlCreate) === TRUE) {
        $last_id = $conn->insert_id;
        echo "新增資料完成, id: $last_id";
    } else {
        echo "新增資料錯誤: " . $conn->error;
    }
    $conn->close();
    header("location: index.php");
} else if ($accessRight == 2) {
    $sql = "SELECT * FROM hotel_account WHERE account='$account' OR email='$email'";
    $result = $conn->query($sql);
    $userCount = $result->num_rows;
    if ($userCount > 0) {
        echo "該帳號或信箱已經存在";
        exit;
    }
    // $password = md5($password);
    $sqlCreate = "INSERT INTO hotel_account (account,email,password,created_at,valid) VALUES ('$account','$email','$password','$now','$valid')";
    $sqlservicelist = "INSERT INTO hotel_service_list (hotel) VALUES ('$account')";
    if ($conn->query($sqlCreate) === TRUE && $conn->query($sqlservicelist)) {
        $last_id = $conn->insert_id;
        echo "新增資料完成, id: $last_id";
    } else {
        echo "新增資料錯誤: " . $conn->error;
    }
    $conn->close();
    header("location: user-hotel/hotel_room/hotel-account.php");
} else if ($accessRight == 3) {
    $sql = "SELECT * FROM travel_account WHERE account='$account' OR email='$email'";
    $result = $conn->query($sql);
    $userCount = $result->num_rows;
    if ($userCount > 0) {
        echo "該帳號或信箱已經存在";
        exit;
    }
    // $password = md5($password);
    $sqlCreate = "INSERT INTO travel_account (account,email,password,created_at,valid) VALUES ('$account','$email','$password','$now','$valid')";
    if ($conn->query($sqlCreate) === TRUE) {
        $last_id = $conn->insert_id;
        echo "新增資料完成, id: $last_id";
    } else {
        echo "新增資料錯誤: " . $conn->error;
    }
    $conn->close();
    header("location: travel-user/travel-user.php");
}



/* $sql = "SELECT * FROM users WHERE account='$account'";
$result = $conn->query($sql);
$userCount = $result->num_rows;
if ($userCount > 0) {
    echo "該帳號已經存在";
    exit;
}
$password = md5($password);
$sqlCreate = "INSERT INTO users (account,email,password,created_at,valid)
VALUES ('$account','$email','$password','$now','$valid')";

if ($conn->query($sqlCreate) === TRUE) {
    $last_id = $conn->insert_id;
    echo "新增資料完成, id: $last_id";
} else {
    echo "新增資料錯誤: " . $conn->error;
}
$conn->close();
header("location: users.php"); */
