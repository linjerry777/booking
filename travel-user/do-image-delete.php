<?php
require_once('var_dump_pre.php');
require_once("../../db-connect2.php");

session_start();

var_dump_pre($_GET);

$location = $_SESSION['del_location'];
$account = $_SESSION['account'];    
// var_dump_pre($location);
$imageName = $_GET["image"];
$TSL_id = $_GET["TSL_id"];
$trip_name = $_GET['name'];
$pictureIndex = $_GET['pictureIndex'];
//用sql 找尋需要的變數→圖片位置(str)
$sqlJoinAll = "SELECT TE.*,TSL.* FROM trip_event AS TE JOIN trip_service_list AS TSL ON TE.trip_name = TSL.trip AND TE.id = TSL.id AND owner='$account' AND TE.valid = 1 AND TSL.id =$TSL_id";
$resultJoin = $conn->query($sqlJoinAll);
$rowsJoinAll = $resultJoin->fetch_assoc();

var_dump_pre($rowsJoinAll);


//從網址獲得要移動檔案的確切名字


//刪除檔案
//所在地
echo "./assets/imgs/{$account}/{$imageName}";
// var_dump_pre($rowsJoinAll);


$imgError = unlink("assets/imgs/{$account}/$imageName");

if ($imgError) {
    echo "刪除成功";
    
} else {
    echo "刪除資料錯誤:";
}

//把移走的圖片網址從資料庫中清除
//先取得陣列 $rowsJoinAll

$pictureArr = explode(',',$rowsJoinAll['picture']);
var_dump_pre($pictureArr);
array_splice($pictureArr,$pictureIndex,1);
$finalPictureArr = $pictureArr;
var_dump_pre($finalPictureArr);
$finalPictureString = implode(',',$finalPictureArr);
var_dump_pre($finalPictureString);


// $picture_str = $rowsJoinAll[$product_index]['picture'];
// var_dump($picture_str);
// $picture_arr = explode(',',$picture_str);
// var_dump_pre($picture_arr);
// //用array_splice 刪除特定元素
// $targetIndex = array_search("$imageName",$picture_arr);
// var_dump_pre($targetIndex);
// array_splice($picture_arr,$targetIndex,1);
// $finalPictureArr = $picture_arr;
// var_dump_pre($finalPictureArr);
// $finalPictureString = implode(',',$finalPictureArr);
// var_dump_pre($finalPictureString);
// // var_dump_pre($id);

//
$sqlIMG = "UPDATE trip_event SET picture = '$finalPictureString'  WHERE owner = $account AND valid = 1 AND trip_name = '$trip_name' ";

if ($conn->query($sqlIMG) === TRUE) {
    echo "資料庫更新成功";
    header("location:$location");
} else {
    echo "資料庫更新錯誤: " . $conn->error;
}
