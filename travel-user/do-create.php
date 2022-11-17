<?php
require_once('var_dump_pre.php');
require_once("../../db-connect2.php");

session_start();
$account = $_SESSION["account"];


$trip_name = $_POST['trip_name'];
$price = $_POST['price'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$description = $_POST['description'];
$guide = $_POST['guide'];
$location = $_POST['location'];
$location_str = implode(',', $location);

//圖片檔名 = 元檔名+行程名稱+副檔名 參考70
// $picture = $_FILES['picture']['name'];
// $picture_str = implode(',', $picture);

$picture = $_FILES['picture'];
//預防空陣列
$pictureCleanArr = array_filter($picture["name"]); //不會有空字串,null,false 但會留下0
$picture_str = "";
for ($i = 0; $i < count($pictureCleanArr); $i++) {
    $file_name = $pictureCleanArr[$i];
    $fileType = pathinfo($pictureCleanArr[$i], PATHINFO_EXTENSION);
    $file_name_noEX = basename($file_name, $fileType);
    $picture_str .= $file_name_noEX . $trip_name . "." . $fileType . ",";
}

var_dump_pre($pictureCleanArr);
var_dump_pre(count($pictureCleanArr));
var_dump_pre($picture);
var_dump_pre($fileType);
var_dump_pre($file_name_noEX);
var_dump_pre($picture_str);

$created_at = date('Y-m-d H:i:s');
$valid = $_POST['valid'];
// var_dump_pre($location);

//加上isset 讓沒勾選的值回傳0
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

$pre_custom_tag = $_POST['custom_tag'];
//加上過濾html
$custom_tag = htmlspecialchars($pre_custom_tag, ENT_QUOTES);


$sqlSameName = "SELECT * FROM trip_event WHERE trip_name = '$trip_name' AND owner = '$account' AND valid=1";
$result = $conn->query($sqlSameName);
$nameCount = $result->num_rows;
echo "同業者底下有多少同名行程。";
var_dump_pre($nameCount);


if ($nameCount > 0) {
    echo '<script>alert("行程名稱已存在!");</script>';
    // ???
    // header("refresh:.5;url=trip-create.php");
    // exit;
}
//上傳一或多張圖片
//Multiple Image Upload PHP form with one input StackOverFlow
$error = array();
//設定目標資料夾
$targetDir = "assets/imgs/{$account}";
echo "target-dir";
var_dump_pre($targetDir);
//若無資料夾便新增資料夾
if (!is_dir($targetDir)) {
    mkdir($targetDir);
}
//允許的副檔名
$allowTypes = array('jpg', 'jpeg', 'png', 'apng', 'gif', 'webp');
foreach ($_FILES['picture']['tmp_name'] as $key => $value) {
    $file_name = $_FILES['picture']['name'][$key];
    /*tmp_name 裏頭會有 [0]第一張圖[1]第二張圖
      所以每一個[tmp_name]底下的key，對應著暫存圖名
      foreach xx as $key => value 是對應xx陣列裏頭的 key & value */
    $file_tmp = $_FILES['picture']['tmp_name'][$key];
    var_dump_pre($file_tmp);
    $fileType = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_name_noEX = basename($file_name, $fileType); 
    var_dump_pre($fileType);
    //如果上傳的檔案種類是允許的值
    if (in_array($fileType, $allowTypes)) {
        //確認檔案是否存在
        //新圖
        if (!file_exists($targetDir . "/" . $file_name_noEX . $trip_name . "." . $fileType)) {
            move_uploaded_file($file_tmp, $targetDir . "/" . $file_name_noEX . $trip_name . "." . $fileType);
        }
        //舊圖
        else {
            $FILENAME = basename($file_name, $fileType); //取得$file_name 但砍掉 $fileType的部分
            $newFILENAME = $FILENAME . time() . $trip_name . "." . $fileType;
            move_uploaded_file($file_tmp = $_FILES['picture']['tmp_name'][$key], $targetDir . "/" . $newFILENAME);
        }
    } else {
        array_push($error, "$file_name,檔案格式不符合");
    }
}



//確認連線 執行多個query上傳資料

$stmt = $conn->prepare("INSERT INTO trip_event (owner,trip_name,price,start_date,end_date,description,guide,location,picture,created_at,valid) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("ssisssisssi", $account, $trip_name, $price, $start_date, $end_date, $description, $guide, $location_str, $picture_str, $created_at, $valid);
$stmt->execute();
$stmt = $conn->prepare("INSERT INTO trip_service_list (trip,mountain,in_water,snow,natural_attraction,culture_history,workshop,amusement,meal,no_shopping,family_friendly,pet,indoor_outdoor,custom_tag) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("siiiiiiiiiiiss", $trip_name, $mountain, $in_water, $snow, $natural_attraction, $culture_history, $workshop, $amusement, $meal, $no_shopping, $family_friendly, $pet, $indoor_outdoor_str, $custom_tag);
$stmt->execute();

$conn->close();

// header("location:trip-list.php");
