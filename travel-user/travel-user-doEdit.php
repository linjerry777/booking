<?php
require_once('var_dump_pre.php');
require_once("../../db-connect2.php");

session_start();


$id = $_POST['id'];
$bannerSql = "SELECT * FROM travel_account WHERE travel_account.id = '$id' AND valid=1";
$result = $conn->query($bannerSql);
$rows = $result->fetch_assoc();

var_dump_pre($_POST); //看post
var_dump_pre($_FILES); //看圖片

$account = $_SESSION['account'];


//移動相片
$error = array();
$targetDir = "assets/imgs/";
$allowTypes = array('jpg', 'jpeg', 'png', 'apng', 'gif', 'webp', 'tmp');


//送出時有送出'負責人名稱'
if (!isset($_POST["name"])) {
    echo "請循正常管道進入本頁";
    exit;
}

/* $company_banner=$_FILES["company_banner"]["name"]; */
$travel_account = isset($_POST['account'])?$_POST['account']:$rows['account'];
$password = isset($_POST['password'])?$_POST['password']:$rows['password'];
$name = $_POST['name'];
$company_name = $_POST['company_name'];
$area = $_POST['area'];
$company_phone = $_POST['company_phone'];
$email = $_POST['email'];
$bank_account = $_POST['bank_account'];
$website = $_POST['website'];
$introduction = $_POST['introduction'];
$start_date = $_POST['start_date'];

// echo "$name, $phone, $email";
var_dump_pre($travel_account);
var_dump_pre($password);


$sql = "UPDATE travel_account SET account='$travel_account', password='$password',name='$name',start_date='$start_date',company_name='$company_name',area='$area',company_phone='$company_phone',email='$email',bank_account='$bank_account',website='$website',introduction='$introduction' WHERE id='$id'";
$sqlTrip = "UPDATE trip_event SET owner = $travel_account WHERE trip_event.owner = '$account'";


/* if($_FILES["company_banner"]["error"]==0){
    
    if(move_uploaded_file($_FILES["company_banner"]["tmp_name"],"./assets/imgs/".$_FILES["company_banner"]["name"]))
    {
        echo "圖片上傳成功! <br>";
        $company_banner=$_FILES["company_banner"]["name"];
    }else{
        echo "圖片上傳失敗 ! <br>";
    }
} */
if ($conn->query($sql) === TRUE) {
    echo "帳號資料更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
}
header("location: travel-user.php");
/* if ($conn->query($sqlTrip) === TRUE) {
    echo "行程資料更新成功";
} else {
    echo "更新資料錯誤: " . $conn->error;
} */

// header("location:travel-user.php#account");
