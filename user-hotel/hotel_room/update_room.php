<?php

require_once("../../db-connect2.php");

session_start();
$account = $_SESSION["account"];
$roomType = $_GET['room'];

$sqlRoomList = "SELECT hotel_room_list.*, room_service_list.* FROM hotel_room_list JOIN room_service_list ON hotel_room_list.room_name=room_service_list.room WHERE hotel_room_list.owner='$account' AND room='$roomType' AND VALID=1";
$roomListResult = $conn->query($sqlRoomList);
$roomListCount = $roomListResult->num_rows;
$roomListrow = $roomListResult->fetch_assoc();
//var_dump($roomListrow);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Room</title>
    <!-- ======= Styles ====== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <style>
        .search label ion-icon {
            position: absolute;
            top: 11px;
            left: 10px;
            font-size: 1.2rem;
        }

        .main.active {
            width: calc(100% - 110px);
            left: 110px;
        }

        .navigation.active {
            width: 110px;
        }

        .details {
            grid-template-columns: 1fr 1fr;
        }

        @media (max-width: 768px) {
            .details {
                grid-template-columns: 1fr;
            }
        }


        .details .recentOrders table tbody tr a {
            text-decoration: none;
        }

        .details .recentOrders table tbody tr:hover a {
            background: var(--blue);
            color: var(--white);

        }
    </style>
</head>

<body>
    <!-- =============== Navigation ================ -->
    <div class="crud-container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="logo-apple"></ion-icon>
                        </span>
                        <span class="title">Brand Name</span>
                    </a>
                </li>

                <li>
                    <a href="./hotel-account.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">會員資料</span>
                    </a>
                </li>

                <li>
                    <a href="./update_room.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">飯店資料修改</span>
                    </a>
                </li>

                <li>
                    <a href="./upload_room.php">
                        <span class="icon">
                            <ion-icon name="chatbubble-outline"></ion-icon>
                        </span>
                        <span class="title">上架</span>
                    </a>
                </li>
                <li>
                    <a href="./room_list.php">
                        <span class="icon">
                            <ion-icon name="chatbubble-outline"></ion-icon>
                        </span>
                        <span class="title">產品一覽</span>
                    </a>
                </li>

                <li>
                    <a href="../../doSignout.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="user">
                    <img src="assets/imgs/customer01.jpg" alt="">
                </div>
            </div>

            <!-- ======================= Cards ================== -->
            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers"></div>
                        <div class="cardName">空房率 </div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">80</div>
                        <div class="cardName">評價</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">284</div>
                        <div class="cardName">成交量</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">$7,842</div>
                        <div class="cardName">營利</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cash-outline"></ion-icon>
                    </div>
                </div>
            </div>

            <div class="container">
                <h2><?= $roomListrow["room_name"] ?></h2>
                <form action="./doupdate_room.php" method="post" enctype="multipart/form-data">
                    <div class="mb-2">
                        <input type="hidden" class="form-control" name="room-type" readonly="readonly" value="<?= $roomListrow["room_name"] ?>">
                    </div>
                    <div class="mb-2">
                        <label for="amount" class="mb-2">間數</label>
                        <input type="number" class="form-control" name="amount" placeholder="請輸入該房型間數" value="<?= $roomListrow["amount"] ?>">
                    </div>
                    <div class="mb-2">
                        <label for="price" class="mb-2">房費</label>
                        <input type="text" class="form-control" name="price" placeholder="請輸入房型費用" value="<?= $roomListrow["price"] ?>">
                    </div>
                    <div class="mb-2">
                        <label for="description" class="mb-2">房間簡述</label>
                        <input type="text" class="form-control" name="description" placeholder="房間簡述" value="<?= $roomListrow["description"] ?>">
                    </div>
                    <div class="mb-2">
                        <label for="picture" class="mb-2">上傳房間圖片</label>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" name="picture">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="service" class="mb-2">房型服務</label>
                        <div class="row">
                            <div class="form-check col-lg-4 col-md-6">
                                <input class="form-check-input" type="checkbox" value="1" name="pet" <?php if ($roomListrow["pet"] == 1) echo 'checked' ?>>
                                <label class="form-check-label" for="pet">
                                    寵物友善房
                                </label>
                            </div>
                            <div class="form-check col-lg-4 col-md-6">
                                <input class="form-check-input" type="checkbox" value="1" name="tv" <?php if ($roomListrow["tv"] == 1) echo 'checked' ?>>
                                <label class="form-check-label" for="tv">
                                    電視房
                                </label>
                            </div>
                            <div class="form-check col-lg-4 col-md-6">
                                <input class="form-check-input" type="checkbox" value="1" name="tub" <?php if ($roomListrow["tub"] == 1) echo 'checked' ?>>
                                <label class="form-check-label" for="tub">
                                    浴缸房
                                </label>
                            </div>
                            <div class="form-check col-lg-4 col-md-6">
                                <input class="form-check-input" type="checkbox" value="1" name="meal" <?php if ($roomListrow["meal"] == 1) echo 'checked' ?>>
                                <label class="form-check-label" for="meal">
                                    供餐
                                </label>
                            </div>
                            <div class="form-check col-lg-4 col-md-6">
                                <input class="form-check-input" type="checkbox" value="1" name="mini-bar" <?php if ($roomListrow["mini_bar"] == 1) echo 'checked' ?>>
                                <label class="form-check-label" for="minibar">
                                    mini-bar
                                </label>
                            </div>
                            <div class="form-check col-lg-4 col-md-6">
                                <input class="form-check-input" type="checkbox" value="1" name="window" <?php if ($roomListrow["window"] == 1) echo 'checked' ?>>
                                <label class="form-check-label" for="window">
                                    有窗戶
                                </label>
                            </div>
                            <div class="form-check col-lg-4 col-md-6">
                                <input class="form-check-input" type="checkbox" value="1" name="corner" <?php if ($roomListrow["corner"] == 1) echo 'checked' ?>>
                                <label class="form-check-label" for="coner">
                                    邊間
                                </label>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-info" type="submit">送出</button>
                </form>
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>