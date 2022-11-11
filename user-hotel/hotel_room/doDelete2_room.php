<?php
require_once("../../db-connect2.php");
session_start();

$roomType = $_GET["room"];
$account = $_SESSION["account"];


$sqlRoomList = "UPDATE hotel_room_list SET valid=0 WHERE room_name='$roomType'";
$sqlRoomService = "UPDATE room_service_list SET valid=0 WHERE room='$roomType'";
if ($conn->query($sqlRoomList) === TRUE) {
    $last_id = $conn->insert_id;
    /* echo "新資料輸入成功, id: $last_id"; */
    header("location: ./hotel-account.php");
} else {
    echo "Error: " . $sqlRoomList . "<br>" .
        $conn->error;
}
