<?php

$host = 'localhost';
$dbuser = 'root';
$dbpassword = '';
$dbname = 'booking';
$conn = mysqli_connect($host, $dbuser, $dbpassword, $dbname);
if ($conn) {
    mysqli_query($conn, 'SET NAMES utf8');
} else {
    echo "連接資料庫失敗" . mysqli_connect_error();
}
