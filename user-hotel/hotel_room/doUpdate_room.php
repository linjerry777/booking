<?php
require_once("../../db-connect2.php");
session_start();


if (!isset($_POST["room-type"])) {
    echo "請循正常管道進入";
    exit;
}
$roomType = $_POST["room-type"];
$price = $_POST["price"];
$amount = $_POST["amount"];
$description = $_POST["description"];


isset($_POST["pet"]) ? $pet = 1 : $pet = 0;
isset($_POST["tv"]) ? $tv = 1 : $tv = 0;
isset($_POST["tub"]) ? $tub = 1 : $tub = 0;
isset($_POST["meal"]) ? $meal = 1 : $meal = 0;
isset($_POST["mini-bar"]) ? $miniBar = 1 : $miniBar = 0;
isset($_POST["window"]) ? $window = 1 : $window = 0;
isset($_POST["corner"]) ? $corner = 1 : $corner = 0;
$account = $_SESSION["account"];

if ($_FILES["picture"]["name"] == "") {
    $now = date('Y-m-d H:i:s');
    $sqlRoomList = "UPDATE hotel_room_list SET owner='$account', room_name='$roomType', price='$price', amount='$amount',  description='$description', created_at='$now', valid=1 WHERE room_name='$roomType'";
    $sqlRoomService = "UPDATE room_service_list SET room='$roomType', pet='$pet', tv='$tv', tub='$tub', meal='$meal', mini_bar='$miniBar', window='$window', corner='$corner' WHERE room='$roomType'";
    if ($conn->query($sqlRoomList) && $conn->query($sqlRoomService) === TRUE) {
        $last_id = $conn->insert_id;
        /* echo "新資料輸入成功, id: $last_id"; */
        header("location: ../hotel_room/upload_room.php");
    } else {
        echo "Error: " . $sqlRoomList . $sqlRoomService . "<br>" .
            $conn->error;
    }
} else {
    echo "upload fail!<br>";
}

if ($_FILES["picture"]["error"] == 0) {
    if (move_uploaded_file($_FILES["picture"]["tmp_name"], "../upload/" . $_FILES["picture"]["name"])) {
        echo "upload success!<br>";
        $picture = $_FILES["picture"]["name"];
        $now = date('Y-m-d H:i:s');
        $sqlRoomList = "UPDATE hotel_room_list SET owner='$account', room_name='$roomType', price='$price', amount='$amount', picture='$picture', description='$description', created_at='$now', valid=1 room_name='$roomType'";
        $sqlRoomService = "UPDATE room_service_list SET room='$roomType', pet='$pet', tv='$tv', tub='$tub', meal='$meal', mini_bar='$miniBar', window='$window', corner='$corner' WHERE room='$roomType'";
        if ($conn->query($sqlRoomList) && $conn->query($sqlRoomService) === TRUE) {
            $last_id = $conn->insert_id;
            /* echo "新資料輸入成功, id: $last_id"; */
            header("location: ./room_list.php");
        } else {
            echo "Error: " . $sqlRoomList . $sqlRoomService . "<br>" .
                $conn->error;
        }
    } else {
        echo "upload fail!<br>";
    }
}
