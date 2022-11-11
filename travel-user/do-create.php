<?php
require_once('var_dump_pre.php');

//我找來的var_dump函式
require_once('db-connect.php');
// $testArr = [];
// $testArr = $_POST;
// var_dump_pre($testArr);

//暫時先用一個假的account名帶進去，還沒寫session
session_start();

$account = $_SESSION["account"];
//上傳資料到 trip_event 的語法$
$trip_name = $_POST['trip_name'];
$price = $_POST['price'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$description = $_POST['description'];
$guide = $_POST['guide'];
$location = $_POST['location'];
$location_str = implode(',', $location);
$picture = $_FILES['picture']['name'];
$picture_str = implode(',',$picture);
$created_at = date('Y-m-d H:i:s');
$valid = $_POST['valid'];
// var_dump_pre($location);
// var_dump_pre($location_str);
// var_dump_pre($picture);
// var_dump_pre($picture_str);
// var_dump_pre($_FILES);
// $sql1 = "INSERT INTO trip_event (owner,trip_name,price,start_date,end_date,description,guide,location,picture,created_at,valid) VALUES ($account,$trip_name,$price,$start_date,$end_date,$description,$guide,$location_str,$picture_str,$created_at,$valid);";

//上傳資料到trip_service_list 的語法
//加上isset 讓沒勾選的值回傳0
$mountain = isset($_POST['mountain'])?$_POST['mountain']:0;
$in_water = isset($_POST['in_water'])?$_POST['in_water']:0;
$snow = isset($_POST['snow'])?$_POST['snow']:0;
$natural_attraction = isset($_POST['natural_attraction'])?$_POST['natural_attraction']:0;
$culture_history = isset($_POST['culture_history'])?$_POST['culture_history']:0;
$workshop = isset($_POST['workshop'])?$_POST['workshop']:0;
$amusement = isset($_POST['amusement'])?$_POST['amusement']:0;
$meal = isset($_POST['meal'])?$_POST['meal']:0;
$no_shopping = isset($_POST['no_shopping'])?$_POST['no_shopping']:0;
$family_friendly = isset($_POST['family_friendly'])?$_POST['family_friendly']:0;
$pet = isset($_POST['pet'])?$_POST['pet']:0;
$indoor_outdoor = $_POST['indoor_outdoor'];
$indoor_outdoor_str = implode(',',$indoor_outdoor);
$custom_tag = $_POST['custom_tag'];
// var_dump_pre($trip_name);
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
// var_dump_pre($indoor_outdoor);
// var_dump_pre($indoor_outdoor_str);
// var_dump_pre($custom_tag);

// .= 內容添加到上一個sql 下方
// $sql2 = "INSERT INTO trip_service_list (trip,mountain,in_water,snow,natural_attraction,culture_history,workshop,amusement,meal,no_shopping,family_friendly,pet,indoor_outdoor,custom_tag) VALUES ($trip_name,$mountain,$in_water,$snow,$natural_attraction,$culture_history,$workshop,$amusement,$meal,$no_shopping,$family_friendly,$pet,$indoor_outdoor_str,$custom_tag);";


//上傳一或多張圖片
//Multiple Image Upload PHP form with one input StackOverFlow
$error = array();
$targetDir = "assets/imgs/";
$allowTypes = array('jpg','jpeg','png','apng','gif','webp');
foreach($_FILES['picture']['tmp_name'] as $key=>$tmp_name) {
    $file_name = $_FILES['picture']['name'][$key];
    $file_tmp= $_FILES['picture']['tmp_name'][$key];
    $fileType=pathinfo($file_name,PATHINFO_EXTENSION);
    //如果上傳的檔案種類是允許的值
    if(in_array($fileType,$allowTypes)) {
        //確認檔案是否存在
        if(!file_exists($targetDir."/".$file_name)) {
            move_uploaded_file($file_tmp,$targetDir."/".$file_name);
        }else{
            $FILENAME = basename($file_name,$fileType);
            $newFILENAME = $file_name.time().".".$fileType;
            move_uploaded_file($file_tmp=$_FILES['picture']['tmp_name'][$key],$targetDir."/".$newFILENAME);
        }
    }
    else {
        array_push($error,"$file_name, ");
    }
}

//確認連線 執行多個query上傳資料

//目前還沒寫報錯

$stmt = $conn->prepare("INSERT INTO trip_event (owner,trip_name,price,start_date,end_date,description,guide,location,picture,created_at,valid) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
$stmt ->bind_param("ssisssisssi",$account,$trip_name,$price,$start_date,$end_date,$description,$guide,$location_str,$picture_str,$created_at,$valid);
$stmt ->execute();
$stmt =$conn->prepare("INSERT INTO trip_service_list (trip,mountain,in_water,snow,natural_attraction,culture_history,workshop,amusement,meal,no_shopping,family_friendly,pet,indoor_outdoor,custom_tag) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$stmt ->bind_param("siiiiiiiiiiiss",$trip_name,$mountain,$in_water,$snow,$natural_attraction,$culture_history,$workshop,$amusement,$meal,$no_shopping,$family_friendly,$pet,$indoor_outdoor_str,$custom_tag);
$stmt -> execute();

$conn->close();

// header("location:create-trip.php");
