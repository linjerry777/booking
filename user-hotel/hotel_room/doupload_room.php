<?php
require_once("../../db-connect2.php");
session_start();

if (!isset($_SESSION["account"])) {
    echo "請循正常管道進入本頁";
    exit;
}
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
isset($_POST["mini_bar"]) ? $mini_bar = 1 : $mini_bar = 0;
isset($_POST["window"]) ? $window = 1 : $window = 0;
isset($_POST["corner"]) ? $corner = 1 : $corner = 0;
$account = $_SESSION["account"];

$sqlCheckRoom = "SELECT hotel_room_list.*, room_service_list.* FROM hotel_room_list JOIN room_service_list ON hotel_room_list.room_name=room_service_list.room WHERE hotel_room_list.owner='$account' AND room_name='$roomType' AND hotel_room_list.valid=1";
$checkRoomeResult = $conn->query($sqlCheckRoom);
$roomCount = $checkRoomeResult->num_rows;
if ($roomCount > 0) {
    echo "該房型已建立";
    exit;
}

if ($_FILES["picture"]["error"] == 0) {
    if (move_uploaded_file($_FILES["picture"]["tmp_name"], "../upload/" . $_FILES["picture"]["name"])) {
        echo "upload success!<br>";
        $picture = $_FILES["picture"]["name"];
        $now = date('Y-m-d H:i:s');
        $sqlRoomList = "INSERT INTO hotel_room_list (owner, room_name, price, amount, picture, description, created_at, valid)
        VALUES ('$account', '$roomType', $price ,$amount, '$picture', '$description', '$now', '1')";
        $sqlRoomService = "INSERT INTO room_service_list (room, pet, tv, tub, meal, mini_bar, window, corner, valid)
        VALUES ('$roomType', '$pet', '$tv', '$tub', '$meal', '$mini_bar', '$window', '$corner', '1')";
        if ($conn->query($sqlRoomList) && $conn->query($sqlRoomService) === TRUE) {
            $last_id = $conn->insert_id;
            /* echo "新資料輸入成功, id: $last_id"; */
            header("location: ../hotel_room/room_list.php");
        } else {
            echo "Error: " . $sqlRoomList . $sqlRoomService . "<br>" .
                $conn->error;
        }
    } else {
        echo "upload fail!<br>";
    }
}
