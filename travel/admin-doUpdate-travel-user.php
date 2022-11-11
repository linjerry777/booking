<?php
require_once("../db-connect2.php");

if(!isset($_POST["name"])){
    echo "請循正常管道進入本頁";
    exit;
}

$id=$_POST["id"];
$name=$_POST["name"];
$company_name=$_POST["company_name"];
$company_phone=$_POST["company_phone"];
$company_banner=$_FILES["company_banner"]["name"];
$start_date=$_POST["start_date"];
$area=$_POST["area"];
$email=$_POST["email"];
$bank_account=$_POST["bank_account"];
$website=$_POST["website"];
$introduction=$_POST["introduction"];
if($area=="北"){
    $area=0;
}
if($area=="中"){
    $area=1;
}
if($area=="南"){
    $area=2;
}
// var_dump($company_banner);
// exit;

if($_FILES["company_banner"]["error"]==0){
    
    if(move_uploaded_file($_FILES["company_banner"]["tmp_name"],"./assets/imgs/".$_FILES["company_banner"]["name"]))
    {
        echo "uploaded success! <br>";
        $company_banner=$_FILES["company_banner"]["name"];
    }else{
        echo "uploaded fail ! <br>";
    }
}

if($_FILES["company_banner"]["name"]==""){
    $sql="UPDATE travel_account SET name='$name',company_name='$company_name', company_phone='$company_phone',start_date='$start_date',area='$area',bank_account='$bank_account',website='$website',introduction='$introduction', email='$email' WHERE id='$id'";
}else{
    $sql="UPDATE travel_account SET name='$name',company_name='$company_name', company_phone='$company_phone',company_banner='$company_banner',start_date='$start_date',area='$area',bank_account='$bank_account',website='$website',introduction='$introduction', email='$email' WHERE id='$id'";
}

// echo "$name, $phone, $email";


if ($conn->query($sql) === TRUE) {
    echo "更新成功";

} else {
    echo "更新資料錯誤: " . $conn->error;
}

header("location: admin-travel-user.php?id=".$id);

