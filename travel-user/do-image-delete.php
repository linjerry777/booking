<?php
require_once('var_dump_pre.php');
require_once("../../db-connect2.php");

session_start();

//刪除對象
var_dump_pre($_GET);
//回歸哪裡
$location = $_SESSION['del_location'];
$account = $_SESSION['account'];    
// var_dump_pre($location);

//用sql 找尋需要的變數→(str)圖片位置
$sqlJoinAll = "SELECT TE.*,TSL.* FROM trip_event AS TE JOIN trip_service_list AS TSL ON TE.trip_name = TSL.trip AND owner='$account'";
$resultJoin = $conn->query($sqlJoinAll);
$rowsJoinAll = $resultJoin->fetch_all(MYSQLI_ASSOC);


//從網址獲得要移動檔案的確切名字
$imageName = $_GET["image"];
$id = $_GET["id"];


//移動檔案
echo "./assets/imgs/".$imageName."<br>";
echo "./assets/trash-can/".$imageName."<br>";
var_dump_pre($_GET);
var_dump_pre($id);
$imgError = rename("assets/imgs/$imageName","./assets/trash-can/$imageName");

if ($imgError) {
    echo "移動成功";
    // header("location:$location");
} else {
    echo "移動資料錯誤:";
}

//把移走的圖片網址從資料庫中清除
// var_dump_pre($rowsJoinAll);
$picture_str = $rowsJoinAll[0]['picture'];
//用str_replace ('關鍵字''取代''目標字串') 取代字串內容
$finalPictureSting= str_replace($imageName,"",$picture_str);
var_dump_pre($finalPictureSting);

$sqlIMG = "UPDATE trip_event SET picture = '$finalPictureSting'  WHERE trip_event.id = '$id' ";

if ($conn->query($sqlIMG) === TRUE) {
    echo "刪除成功";
    header("location:$location");
} else {
    echo "刪除資料錯誤: " . $conn->error;
}

?>