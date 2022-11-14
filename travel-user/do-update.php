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
// $location = $_POST['location'];
//把陣列拆成 字串 才能放進資料庫
// $location_str = implode(',', $location);

var_dump_pre($_FILES);
$picture = $_FILES['picture']['name'][0];

// $picture_str = implode(",",$picture);

// var_dump_pre($location_str);





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
// $indoor_outdoor = $_POST['indoor_outdoor'];
// $indoor_outdoor_str = implode(',', $indoor_outdoor);
$custom_tag = $_POST['custom_tag'];

$error = array();
$targetDir = "assets/imgs/";
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



$sqlTripEventUpdate="UPDATE trip_event SET trip_name=$name,price=$price,start_date=$start_date,end_date=$end_date,description=$description,guide=$guide,picture='$picture' WHERE trip_event.trip_name = '$unique_trip_name'";

$sqlTripServiceUpdate="UPDATE trip_service_list SET trip=$name,mountain=$mountain,in_water=$in_water,snow=$snow,natural_attraction=$natural_attraction,culture_history=$culture_history,workshop=$workshop,amusement=$amusement,meal=$meal,no_shopping=$no_shopping,family_friendly=$family_friendly,pet=$pet,custom_tag=$custom_tag WHERE trip_service_list.trip = '$unique_trip_name'";

$tripEventUpdateResult=$conn->query($sqlTripEventUpdate);
$tripServiceUpdate=$conn->query($sqlTripServiceUpdate);
var_dump_pre($tripEventUpdateResult); 
var_dump_pre($tripServiceUpdate); 


header("location:trip-list.php");
