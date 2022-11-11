<?php
require_once("../db-connect2.php");

if (!isset($_POST["name"])) {
    echo "請循正常管道進入本頁";
    exit;
}
$account = $_POST["account"];
$password = $_POST["password"];
// $company_banner = $_POST["company_banner"];
$name = $_POST["name"];
$company_name = $_POST["company_name"];
$start_date = $_POST["start_date"];
$area = $_POST["area"];
$company_phone = $_POST["company_phone"];
$email = $_POST["email"];
$bank_account = $_POST["bank_account"];
$website = $_POST["website"];
$introduction = $_POST["introduction"];


 
        $sqlSameUser="SELECT * FROM travel_account WHERE account='$account' AND valid=1";
        $resultSameUser = $conn->query($sqlSameUser);
        $sameUserCount = $resultSameUser->num_rows;
        if($sameUserCount>0){
            echo "<script>alert('帳號已存在！');</script>";
            
            header("refresh:0.5;url=admin-add-travel-user.php");
            exit;
        }
       

// date_default_timezone_set("Asia/Taipei");
$now = date('Y-m-d H:i:s');

// echo "$name, $phone, $email, $now";

if($_FILES["company_banner"]["error"]==0){
    if(move_uploaded_file($_FILES["company_banner"]["tmp_name"],"./assets/imgs/".$_FILES["company_banner"]["name"]))
    // move_uploaded_file 移動到指定位置
    // $_FILES["myFile"]["tmp_name"] 暫存的檔名
    // $_FILES["myFile"]["name"] 真實的檔名
    {
        echo "uploaded success! <br>";
        
        $company_banner=$_FILES["company_banner"]["name"]; 
        
        // if ($conn->query($sql) === TRUE) {
        //     $last_id = $conn->insert_id;
        //     // echo "資料表 新增資料完成 id:$last_id";
        //     header("location:admin-travel.php");
        // } else {
        //     echo "資料表 新增圖片錯誤: " . $conn->error;
        // }

    }else{
        echo "uploaded fail ! <br>";
    }
}


$sql = "INSERT INTO travel_account (account,password,company_banner,name,company_name,start_date,area,company_phone, email,bank_account,website,introduction, created_at,valid) VALUES ('$account','$password','$company_banner','$name','$company_name','$start_date','$area','$company_phone', '$email','$bank_account','$website','$introduction', '$now',1)";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "新增資料完成, id: $last_id";
} else {
    echo "新增資料錯誤: " . $conn->error;
}

$conn->close();

header("location: admin-travel.php");
