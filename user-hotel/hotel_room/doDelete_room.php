<?php
require_once("../../db-connect2.php");
session_start();
if (!isset($_SESSION["account"])) {
    echo "請循正常管道進入本頁";
    exit;
}
$roomType = $_GET["room"];
$account = $_SESSION["account"];


$sqlRoomList = "UPDATE hotel_room_list SET valid=0 WHERE room_name='$roomType'";
$sqlRoomService = "UPDATE room_service_list SET valid=0 WHERE room='$roomType'";
if ($conn->query($sqlRoomList) === TRUE && $conn->query($sqlRoomService)===TRUE) {
    //$last_id = $conn->insert_id;
    /* echo "新資料輸入成功, id: $last_id"; */
    header("location: ./room_list.php");
} else {
    echo "Error: " . $sqlRoomList . "<br>" .
        $conn->error;
}
