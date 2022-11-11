<?php

use LDAP\Result;

require_once("../../db-connect2.php");
session_start();

//$account = $_POST["account"];
$account = $_SESSION["account"];
isset($_GET["pet"]) ? $pet = 1 : $pet = 0;
isset($_GET["tv"]) ? $tv = 1 : $tv = 0;
isset($_GET["tub"]) ? $tub = 1 : $tub = 0;
isset($_GET["meal"]) ? $meal = 1 : $meal = 0;
isset($_GET["mini-bar"]) ? $miniBar = 1 : $miniBar = 0;
isset($_GET["window"]) ? $window = 1 : $window = 0;
isset($_GET["corner"]) ? $corner = 1 : $corner = 0;

//$sqlHotelAccount = "SELECT hotel_account.*, hotel.service_list ON  WHERE hotel_account.account='$account' AND hotel_account.valid=1";
/* $sqlRoomList = "SELECT hotel_room_list.*, room_service_list.* FROM hotel_room_list JOIN room_service_list ON hotel_room_list.room_name=room_service_list.room WHERE hotel_room_list.owner='$account' AND valid=1";
$roomListResult = $conn->query($sqlRoomList);
$roomListRows = $roomListResult->fetch_all(MYSQLI_ASSOC); */
//var_dump($roomListRows);
$sqlOrderList = "SELECT total_order_list.*, total_order_list_detail.* FROM total_order_list JOIN total_order_list_detail ON total_order_list.product_id = total_order_list_detail.product_id WHERE total_order_list.company_id='tangej' AND total_order_list.valid=1";
$orderListResult = $conn->query($sqlOrderList);
$orderListRows = $orderListResult->fetch_all(MYSQLI_ASSOC);
//var_dump($orderListRows);
if (isset($_GET["search"])) {
    $search = $_GET["search"];
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }
    $per_page = 5;
    $page_start = ($page - 1) * $per_page;
    $sqlRoomListLike = "SELECT hotel_room_list.*, room_service_list.* FROM hotel_room_list JOIN room_service_list ON hotel_room_list.room_name=room_service_list.room WHERE hotel_room_list.owner='$account' AND room_name LIKE '%$search%' AND hotel_room_list.valid=1 OR pet LIKE $pet";
    $roomListLikeResult = $conn->query($sqlRoomListLike);
    //$roomListLikeRows = $roomListLikeResult->fetch_all(MYSQLI_ASSOC);
    //var_dump($roomListLikeRows);
    $roomCount = $roomListLikeResult->num_rows;
    $totalPage = ceil($roomCount / $per_page);
    $sqlRoomList = "SELECT hotel_room_list.*, room_service_list.* FROM hotel_room_list JOIN room_service_list ON hotel_room_list.room_name=room_service_list.room WHERE hotel_room_list.owner='$account' AND room_name LIKE '%$search%' AND hotel_room_list.valid=1 ORDER BY created_at DESC LIMIT $page_start, $per_page";
    $roomListResult = $conn->query($sqlRoomList);
    //var_dump($roomListResult);
} else {
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }
    $sqlRoomListAll = "SELECT hotel_room_list.*, room_service_list.* FROM hotel_room_list JOIN room_service_list ON hotel_room_list.room_name=room_service_list.room WHERE hotel_room_list.owner='$account' AND hotel_room_list.valid=1";
    $sqlRoomListResultAll = $conn->query($sqlRoomListAll);
    $roomCount = $sqlRoomListResultAll->num_rows;

    $per_page = 5;
    $page_start = ($page - 1) * $per_page;
    $sqlRoomList = "SELECT hotel_room_list.*, room_service_list.* FROM hotel_room_list JOIN room_service_list ON hotel_room_list.room_name=room_service_list.room WHERE hotel_room_list.owner='$account' AND hotel_room_list.valid=1 ORDER BY created_at DESC LIMIT $page_start, $per_page";
    $roomListResult = $conn->query($sqlRoomList);
    $totalPage = ceil($roomCount / $per_page);
}
$roomListResult = $conn->query($sqlRoomList);
$roomListRows = $roomListResult->fetch_all(MYSQLI_ASSOC);




/* $sql="SELECT products.*, category.name AS category_name FROM products JOIN category ON products.category_id = category.id WHERE products.price >= $min AND products.price <= $max"; */

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Room List</title>
    <!-- ======= Styles ====== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="./style-room-list.css">
    <link rel="stylesheet" href="../css/mycss.css">
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

        .details .recentOrders table tbody tr a {
            text-decoration: none;
        }

        .details .recentOrders table tbody tr:hover a {
            background: var(--blue);
            color: var(--white);

        }

        .position-relative {
            position: relative;
        }

        .position-absolute {
            position: absolute;
            bottom: 0;
            left: calc(50% - 30px);
        }

        .big-font-size {
            font-size: 30px;
        }

        .pointer {
            cursor: pointer;
        }

        /*         div {
            border: 1px solid red;
        } */
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

                <div class="search">
                    <form action="room_list.php" method="get">
                        <label>
                            <input type="text" placeholder="Search here" name="search">
                            <ion-icon name="search-outline"></ion-icon>
                        </label>
                    </form>
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
                        <div class="cardName">會員人數

                        </div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">80</div>
                        <div class="cardName">未定</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">284</div>
                        <div class="cardName">未定</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">$7,842</div>
                        <div class="cardName">未定</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cash-outline"></ion-icon>
                    </div>
                </div>
            </div>

            <!-- ================ 飯店帳號 Details List ================= -->
            <div class="details">

                <!-- ================= 房型列表 ================ -->
                <div class="recentCustomers">
                    <div class="mb-2">
                        <form action="room_list" method="get">
                            <label for="service" class="mb-2">房型服務</label>
                            <div class="row">
                                <div class="form-check col-lg-4 col-md-6">
                                    <input class="form-check-input" type="checkbox" value="1" name="pet">
                                    <label class="form-check-label" for="pet">
                                        寵物友善房
                                    </label>
                                </div>
                                <div class="form-check col-lg-4 col-md-6">
                                    <input class="form-check-input" type="checkbox" value="1" name="tv">
                                    <label class="form-check-label" for="tv">
                                        電視房
                                    </label>
                                </div>
                                <div class="form-check col-lg-4 col-md-6">
                                    <input class="form-check-input" type="checkbox" value="1" name="tub">
                                    <label class="form-check-label" for="tub">
                                        浴缸房
                                    </label>
                                </div>
                                <div class="form-check col-lg-4 col-md-6">
                                    <input class="form-check-input" type="checkbox" value="1" name="meal">
                                    <label class="form-check-label" for="meal">
                                        供餐
                                    </label>
                                </div>
                                <div class="form-check col-lg-4 col-md-6">
                                    <input class="form-check-input" type="checkbox" value="1" name="mini-bar">
                                    <label class="form-check-label" for="minibar">
                                        mini-bar
                                    </label>
                                </div>
                                <div class="form-check col-lg-4 col-md-6">
                                    <input class="form-check-input" type="checkbox" value="1" name="window">
                                    <label class="form-check-label" for="window">
                                        有窗戶
                                    </label>
                                </div>
                                <div class="form-check col-lg-4 col-md-6">
                                    <input class="form-check-input" type="checkbox" value="1" name="coner">
                                    <label class="form-check-label" for="coner">
                                        邊間
                                    </label>
                        </form>
                    </div>
                </div>
            </div>
            <div class="cardHeader">
                <h2>房型列表</h2>
                <?php if (isset($_GET["search"]) && $_GET["search"] !== "") : ?>
                    <h2>"<?= $_GET["search"] ?>"的收尋結果</h2>
                <?php endif; ?>
            </div>
            <?php foreach ($roomListRows as $serviceOfRoom) : ?>
                <div class="position-relative d-flex m-2">
                    <div width="300px col-3 m-2">
                        <div class="imgBx"><img src="../upload/<?= $serviceOfRoom["picture"] ?>" alt=""></div>
                    </div>
                    <div class="col-6 m-2">
                        <h2 class="m-1"><?= $serviceOfRoom["room"] ?></h2> <br>
                        <?php foreach ($serviceOfRoom as $serviceList => $service) : ?>
                            <?php if ($service == "1" && $serviceList !== "valid" && $serviceList !== "id" && $serviceList !== "amount") : ?>
                                <button class="btn btn-info"><?= $serviceList ?></button>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-3 m-2">
                        <a class="btn btn-info roomView" href="./update_room.php?room=<?= $serviceOfRoom["room_name"] ?>">修改</a>
                        <a class="btn btn-danger" href="./doDelete_room.php?room=<?= $serviceOfRoom["room_name"] ?>">下架</a>
                    </div>
                    <div class="position-absolute pointer arrow-btn"><i class="fa-solid fa-square-caret-down big-font-size arrow"></i></div>
                </div>
                <div class="row d-none room-details position-relative">
                    <div class="col-lg-4 col-md">

                        <table class="table table-bordered">

                            <tbody>
                                <tr>
                                    <td>房型名稱</td>
                                    <td><?= $serviceOfRoom["room"] ?></td>
                                </tr>
                                <tr>
                                    <td>房費</td>
                                    <td><?= $serviceOfRoom["price"] ?></td>
                                </tr>
                                <tr>
                                    <td>間數</td>
                                    <td><?= $serviceOfRoom["amount"] ?></td>
                                </tr>
                                <tr>
                                    <td>房間介紹</td>
                                    <td><?= $serviceOfRoom["description"] ?></td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                    <div class="col-lg-8 col-md">

                        <table class="table table-bordered">
                            <thead>
                                <td>房型名稱</td>
                                <td>訂房代表</td>
                                <td>間數</td>
                                <td>入住日期</td>
                                <td>是否付款</td>
                                <td>訂房日期</td>
                                <td>金額</td>
                            </thead>
                            <?php foreach ($orderListRows as $orderList) : ?>
                                <?php if ($orderList["product_id"] === $serviceOfRoom["room"]) : ?>
                                    <tbody>
                                        <td><?= $serviceOfRoom["room"] ?></td>
                                        <td><?= $orderList["user"] ?></td>
                                        <td><?= $orderList["amount"] ?></td>
                                        <td><?= $orderList["date"] ?></td>
                                        <?php if ($orderList["status"] == 1) : ?>
                                            <td> 已付款 </td>
                                        <?php else : ?>
                                            <td> 未付款 </td>
                                        <?php endif; ?>
                                        <td><?= $orderList["order_date"] ?></td>
                                        <td><?= $serviceOfRoom["price"] * $orderList["amount"] ?></td>
                                    </tbody>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </table>

                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (!isset($_GET["search"])) : ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                            <li class="page-item <?php if ($i == $page) echo "active"; ?>"><a class="page-link" href="room_list.php?page=<?= $i ?>"><?= $i ?></a></li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php else : ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                            <li class="page-item <?php if ($i == $page) echo "active"; ?>"><a class="page-link" href="room_list.php?page=<?= $i ?>&&search=<?= $_GET["search"] ?>"><?= $i ?></a></li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        const arrowBtns = document.querySelectorAll(".arrow-btn");
        const roomDetails = document.querySelectorAll(".room-details");
        const arrow = document.querySelectorAll(".arrow");
        for (let i = 0; i < arrowBtns.length; i++) {
            arrowBtns[i].addEventListener("click", function() {
                if (!roomDetails[i].classList.contains("d-none")) {
                    roomDetails[i].classList = "row room-details d-none"
                    arrow[i].classList = "fa-solid fa-square-caret-down big-font-size"
                } else {
                    roomDetails[i].classList = "row room-details"
                    arrow[i].classList = "fa-solid fa-square-caret-up big-font-size"
                }
            })
        }
    </script>
</body>

</html>