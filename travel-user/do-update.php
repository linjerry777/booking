<?php 
require_once('./db-connect.php');

$product = $_GET['product'];


$price = $_POST['price'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$description = $_POST['description'];
$guide = $_POST['guide'];
$location = $_POST['location'];
$location_str = implode(',', $location);
$picture = $_FILES['picture']['name'];
$picture_str = implode(',',$picture);

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

$stmt = $conn->prepare("UPDATE trip_event SET price=?,start_date=?,end_date=?,description=?,guide=?,location=?,picture=? WHERE trip_event.trip_name ='$product'");
$stmt ->bind_param('isssiss',$price,$start_date,$end_date,$description,$guide,$location_str,$picture_str);
$stmt ->execute();
$stmt =$conn->prepare("UPDATE trip_service_list SET mountain=?,in_water=?,snow=?,natural_attraction=?,culture_history=?,workshop=?,amusement=?,meal=?,no_shopping=?,family_friendly=?,pet=?,indoor_outdoor=?,custom_tag=? WHERE trip_service_list.trip = '$product'");
$stmt ->bind_param("iiiiiiiiiiiss",$mountain,$in_water,$snow,$natural_attraction,$culture_history,$workshop,$amusement,$meal,$no_shopping,$family_friendly,$pet,$indoor_outdoor_str,$custom_tag);
$stmt -> execute();

// $trip_eventSQL = "UPDATE trip_event SET price = '$price',start_date ='$start_date',end_date = '$end_date',descriptoin = '$description',guide = '$guide',location = '$location_str',picture = $picture_str";
// $tags_SQL = "UPDATE trip_service_list SET mountain = '$mountain', in_water = '$in_water', snow = '$snow', natural_attraction = '$natural_attraction',culture_history = '$culture_history',workshop = '$workshop', amusement = '$amusement',meal ='$meal',no_shopping='$no_shopping',family_friendly='$family_friendly',pet = '$pet',indoor_outdoor='$indoor_outdoor_str',$custom_tag='$custom_tag'";
$conn->close();

?>