<?php
require_once("../db-connect2.php");

session_start();
$_SESSION["email"] = $_POST["email"];

$accessRight = $_POST["accessRight"];
$email = $_POST["email"];
$password = $_POST["password"];

if ($accessRight == 1) {
    $sql = "SELECT * FROM admin WHERE email='$email' AND  password='$password'";
    $result = $conn->query($sql);
    $userCount = $result->num_rows;
    if ($userCount > 0) {
        header("location: admin-user/admin.php");
    } else {
        echo "該帳號不存在";
        exit;
    }
} else if ($accessRight == 2){
    $sql = "SELECT * FROM hotel_account WHERE email='$email' AND  password='$password'";
    $result = $conn->query($sql);
    $userCount = $result->num_rows;
    if ($userCount > 0) {
        header("location: user-hotel/hotel_room/hotel-account.php");
    } else {
        echo "該帳號不存在";
        exit;
    }
} else if ($accessRight == 3){
    $sql = "SELECT * FROM travel_account WHERE email='$email' AND  password='$password'";
    $result = $conn->query($sql);
    $userCount = $result->num_rows;
    if ($userCount > 0) {
        header("location:travel-user/travel-user.php");
    } else {
        echo "該帳號不存在";
        exit;
    }
}else{
    header("location: index.php");
}


/* $sql = "SELECT * FROM users WHERE password='$password' ";
$result = $conn->query($sql);
$userCount = $result->num_rows;
if ($userCount > 0) {
    header("location: users.php");
} else {
    echo "該密碼不存在";
    exit;
} */