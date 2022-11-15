<?php
require_once('var_dump_pre.php');
require_once("../../db-connect2.php");

session_start();
$account = $_SESSION['account'];


$id_tsl = $_POST['id_trip_service_list'];
$unique_trip_name = $_POST['unique_trip_name'];

// var_dump_pre($id_tsl);
// var_dump_pre($unique_trip_name);


$sqlJoin = "SELECT TE.*,TSL.* FROM trip_event AS TE JOIN trip_service_list AS TSL ON TE.trip_name = TSL.trip AND TE.valid = 1 AND TE.owner='$account' AND TSL.id='$id_tsl'";
$resultJoin = $conn->query($sqlJoin);
$rowsJoin = $resultJoin->fetch_all(MYSQLI_ASSOC);



$name = $_POST['trip_name'];
$price = $_POST['price'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$description = $_POST['description'];
$guide = $_POST['guide'];
$location = $_POST['location'];
//把陣列拆成 字串 才能放進資料庫
$location_str = implode(',', $location);


/*圖片有幾種狀態 
    1.有上傳圖片，原本就有圖片→加上comma 和新增內容
    2.有上傳圖片，原本沒有圖片->直接取用新增內容
    3.沒上傳圖片，原本就有圖片->直接採用舊內容
    4.沒上傳圖片，原本沒有圖片->出示提醒
    var_dump_pre($_FILES) // array(1){['picture']->['name']->[0]"圖一.jpg",[1]"圖二.jpg"}
*/

// var_dump_pre($_FILES['picture']['name']);
// var_dump_pre($rowsJoin[0]['picture']);

$origin = $rowsJoin[0]['picture'];
$newImage = $_FILES['picture']['name'];
/*
echo empty($newImage[0]); //1 沒有上傳東西
echo empty($origin); //1 沒有上傳東西
*/ 
// var_dump_pre($newImage);
// echo empty($origin); //1 檔案欄沒東西

if (empty($origin) && empty($newImage[0])) {
    // 沒圖 也沒上船
    echo "<script>alert('請至少上傳封面圖片');</script>";
    header("refresh:1;url=trip-list.php");
    exit;
}else if (empty($origin) && !empty($newImage[0])) {
    //沒圖 有上傳
    $newImage_str = implode(',',$newImage);
    $picture_str = $newImage_str;
}else if (!empty($origin) && empty($newImage[0])) {
    //有圖 沒上傳
    $picture_str = $origin;
}else if (!empty($origin) && !empty($newImage[0])) {
    //有圖 有上傳
    $newImage_str = implode(',',$newImage);
    $picture_str = "$origin";
    $picture_str .= ",";
    $picture_str .= $newImage_str;
}

// var_dump_pre($_FILES);
// is_array($origin);
// echo is_array($newImage);
// echo "$picture_str";
// var_dump_pre($picture_str);






$mountain = isset($_POST['mountain']) ? $_POST['mountain'] : 0;

$in_water = isset($_POST['in_water']) ? $_POST['in_water'] : 0;
$snow = isset($_POST['snow']) ? $_POST['snow'] : 0;
$natural_attraction = isset($_POST['natural_attraction']) ? $_POST['natural_attraction'] : 0;
$culture_history = isset($_POST['culture_history']) ? $_POST['culture_history'] : 0;
$workshop = isset($_POST['workshop']) ? $_POST['workshop'] : 0;
$amusement = isset($_POST['amusement']) ? $_POST['amusement'] : 0;
$meal = isset($_POST['meal']) ? $_POST['meal'] : 0;
$no_shopping = isset($_POST['no_shopping']) ? $_POST['no_shopping'] : 0;
$family_friendly = isset($_POST['family_friendly']) ? $_POST['family_friendly'] : 0;
$pet = isset($_POST['pet']) ? $_POST['pet'] : 0;
$indoor_outdoor = $_POST['indoor_outdoor'];
$indoor_outdoor_str = implode(',', $indoor_outdoor);
$custom_tag = $_POST['custom_tag'];

// var_dump_pre($name);
// var_dump_pre($mountain);
// var_dump_pre($in_water);
// var_dump_pre($snow);
// var_dump_pre($natural_attraction);
// var_dump_pre($culture_history);
// var_dump_pre($workshop);
// var_dump_pre($amusement);
// var_dump_pre($meal);
// var_dump_pre($no_shopping);
// var_dump_pre($family_friendly);
// var_dump_pre($pet);
// var_dump_pre($indoor_outdoor_str);
// var_dump_pre($custom_tag);
// var_dump_pre($unique_trip_name);


$error = array();
$targetDir = "assets/imgs/{$account}/";
$allowTypes = array('jpg', 'jpeg', 'png', 'apng', 'gif', 'webp', 'tmp');

foreach ($_FILES['picture']['tmp_name'] as $key => $tmp_name) {
    $file_name = $_FILES['picture']['name'][$key];
    $file_tmp = $_FILES['picture']['tmp_name'][$key];
    $fileType = pathinfo($file_name, PATHINFO_EXTENSION);
    //如果上傳的檔案種類是允許的值
    if (in_array($fileType, $allowTypes)) {
        //確認檔案是否存在
        if (!file_exists($targetDir . "/" . $file_name)) {
            move_uploaded_file($file_tmp, $targetDir . "/" . $file_name);
        } else {
            $FILENAME = basename($file_name, $fileType);
            $newFILENAME = $file_name . time() . "." . $fileType;
            move_uploaded_file($file_tmp = $_FILES['picture']['tmp_name'][$key], $targetDir . "/" . $newFILENAME);
        }
    } else {
        array_push($error, "$file_name, ");
    }
}

$stmt = $conn->prepare("UPDATE trip_service_list SET trip=?,mountain=?,in_water=?,snow=?,natural_attraction=?,culture_history=?,workshop=?,amusement=?,meal=?,no_shopping=?,family_friendly=?,pet=?,indoor_outdoor=?,custom_tag=? WHERE trip_service_list.trip = '$unique_trip_name' ");
$stmt->bind_param("siiiiiiiiiiiss",$name, $mountain, $in_water, $snow, $natural_attraction, $culture_history, $workshop, $amusement, $meal, $no_shopping, $family_friendly, $pet, $indoor_outdoor_str, $custom_tag);
$stmt->execute();
$stmt = $conn->prepare("UPDATE trip_event SET trip_name=?,price=?,start_date=?,end_date=?,description=?,guide=?,location=?,picture=? WHERE trip_event.trip_name = '$unique_trip_name' ");
$stmt->bind_param('sisssiss', $name, $price, $start_date, $end_date, $description, $guide, $location_str, $picture_str);
$stmt->execute();


$conn->close();
header("location:trip-list.php");
