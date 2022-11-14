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
// $location = $_POST['location'];
// $location_str = implode(',', $location);
$picture = $_FILES['picture']['name'][0];
// $picture_str = implode(',', $picture);
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
// $indoor_outdoor = $_POST['indoor_outdoor'];
// $indoor_outdoor_str = implode(',', $indoor_outdoor);
$custom_tag = $_POST['custom_tag'];


$sqlSameName = "SELECT * FROM trip_event WHERE trip_name = $trip_name";
$result = $conn -> query($sqlSameName);
$nameCount = $result -> num_rows;
// var_dump_pre($nameCount);

if($nameCount > 0 ) {
    echo '<script>alert("帳號已存在!");</script>';
    // ???
    header("refresh:1;url=trip-create.php");
    exit;
}
//上傳一或多張圖片
//Multiple Image Upload PHP form with one input StackOverFlow
$error = array();
$targetDir = "assets/imgs/";
$allowTypes = array('jpg', 'jpeg', 'png', 'apng', 'gif', 'webp');
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


//確認連線 執行多個query上傳資料
//目前還沒寫報錯

$stmt = $conn->prepare("INSERT INTO trip_event (owner,trip_name,price,start_date,end_date,description,guide,picture,created_at,valid) VALUES (?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("ssisssissi", $account, $trip_name, $price, $start_date, $end_date, $description, $guide,$picture, $created_at, $valid);
$stmt->execute();
$stmt = $conn->prepare("INSERT INTO trip_service_list (trip,mountain,in_water,snow,natural_attraction,culture_history,workshop,amusement,meal,no_shopping,family_friendly,pet,custom_tag) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("siiiiiiiiiiis", $trip_name, $mountain, $in_water, $snow, $natural_attraction, $culture_history, $workshop, $amusement, $meal, $no_shopping, $family_friendly, $pet,$custom_tag);
$stmt->execute();

$conn->close();

header("location:trip-create.php");
