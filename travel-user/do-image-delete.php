<?php
require_once('var_dump_pre.php');
require_once("../../db-connect2.php");

session_start();

var_dump_pre($_GET);

$location = $_SESSION['del_location'];
$account = $_SESSION['account'];    
// var_dump_pre($location);
$imageName = $_GET["image"];
$id = $_GET["id"];

//用sql 找尋需要的變數→圖片位置(str)
$sqlJoinAll = "SELECT TE.*,TSL.* FROM trip_event AS TE JOIN trip_service_list AS TSL ON TE.trip_name = TSL.trip AND owner='$account'";
$resultJoin = $conn->query($sqlJoinAll);
$rowsJoinAll = $resultJoin->fetch_all(MYSQLI_ASSOC);


//從網址獲得要移動檔案的確切名字


//刪除檔案
//所在地
echo "./assets/imgs/{$account}/{$imageName}";


$imgError = unlink("assets/imgs/{$account}/$imageName");

if ($imgError) {
    echo "刪除成功";
    
} else {
    echo "刪除資料錯誤:";
}

//把移走的圖片網址從資料庫中清除
//先取得陣列
$trip_index = $id-1;
// var_dump_pre($id);
$picture_str = $rowsJoinAll[$trip_index]['picture'];
var_dump($picture_str);
$picture_arr = explode(',',$picture_str);
//用array_splice 刪除特定元素
$targetIndex = array_search("$imageName",$picture_arr);
array_splice($picture_arr,$targetIndex,1);
$finalPictureArr = $picture_arr;
$finalPictureSting = implode(',',$finalPictureArr);

var_dump_pre($picture_arr);
var_dump_pre($targetIndex);
var_dump_pre($finalPictureArr);
var_dump_pre($finalPictureSting);

$sqlIMG = "UPDATE trip_event SET picture = '$finalPictureSting'  WHERE trip_event.id = '$id' ";

if ($conn->query($sqlIMG) === TRUE) {
    echo "資料庫更新成功";
    header("location:$location");
} else {
    echo "資料庫更新錯誤: " . $conn->error;
}

?>