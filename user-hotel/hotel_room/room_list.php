<?php

use LDAP\Result;

require_once("../../db-connect2.php");
session_start();
if (!isset($_SESSION["account"])) {
    echo "請循正常管道進入本頁";
    exit;
}
//$account = $_POST["account"];
$account = $_SESSION["account"];

$petSelected = isset($_GET['pet']);
$tvSelected = isset($_GET['tv']);
$tubSelected = isset($_GET['tub']);
$mealSelected = isset($_GET['meal']);
$mini_barSelected = isset($_GET['mini_bar']);
$windowSelected = isset($_GET['window']);
$cornerSelected = isset($_GET['corner']);
$serviceListTagGet = [];

$serviceListTag = ["pet" => "$petSelected", "tv" => "$tvSelected", "tub" => "$tubSelected", "meal" => "$mealSelected", "mini_bar" => "$mini_barSelected", "window" => "$windowSelected", "corner" => "$cornerSelected"];
//var_dump($serviceListTag);
foreach ($serviceListTag as $serviceTag => $ifIsset) {
    if ($ifIsset) {
        array_push($serviceListTagGet, $serviceTag);
    }
}


$sqlOrderList = "SELECT total_order_list.*, total_order_list_detail.* FROM total_order_list JOIN total_order_list_detail ON total_order_list.product_id = total_order_list_detail.product_id_detail WHERE total_order_list.company_id='$account' AND total_order_list.valid=1";
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
    $sqlRoomListLike = "SELECT hotel_room_list.*, room_service_list.* FROM hotel_room_list JOIN room_service_list ON hotel_room_list.room_name=room_service_list.room WHERE hotel_room_list.owner='$account' AND room_name LIKE '%$search%' AND hotel_room_list.valid=1 AND room_service_list.valid=1";
    $roomListLikeResult = $conn->query($sqlRoomListLike);
    //$roomListLikeRows = $roomListLikeResult->fetch_all(MYSQLI_ASSOC);
    //var_dump($roomListLikeRows);
    $roomCount = $roomListLikeResult->num_rows;
    $totalPage = ceil($roomCount / $per_page);
    $sqlRoomList = "SELECT hotel_room_list.*, room_service_list.* FROM hotel_room_list JOIN room_service_list ON hotel_room_list.room_name=room_service_list.room WHERE hotel_room_list.owner='$account' AND room_name LIKE '%$search%' AND hotel_room_list.valid=1 AND room_service_list.valid=1 ORDER BY created_at DESC LIMIT $page_start, $per_page";
    $roomListResult = $conn->query($sqlRoomList);
    //var_dump($roomListResult);
} else if (isset($_GET["pet"]) || isset($_GET["tv"]) || isset($_GET["tub"]) || isset($_GET["meal"]) || isset($_GET["mini_bar"]) || isset($_GET["window"]) || isset($_GET["corner"])) {
    //$select = $_GET["select"];
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }

    $conditionAll = "room_service_list.";
    foreach ($serviceListTagGet as $serviceTag) {
        $conditionAll .= $serviceTag . "= 1 AND ";
        //echo $conditionAll;
    }
    //echo $conditionAll;
    $sqlRoomSelect = "SELECT hotel_room_list.*, room_service_list.* FROM hotel_room_list JOIN room_service_list ON hotel_room_list.room_name=room_service_list.room WHERE hotel_room_list.owner='$account' AND ";
    $sqlValid = "hotel_room_list.valid=1 AND room_service_list.valid=1";
    $sqlRoomSelect .= $conditionAll;
    $sqlRoomSelect .= $sqlValid;
    //$conditionAll = "room_service_list.$select=1";
    //echo $condition;
    //echo $sqlRoomSelect;
    $sqlRoomSelectResult = $conn->query($sqlRoomSelect);
    $per_page = 5;
    $page_start = ($page - 1) * $per_page;
    $roomCount = $sqlRoomSelectResult->num_rows;
    $totalPage = ceil($roomCount / $per_page);


    $sqlRoomList = "SELECT hotel_room_list.*, room_service_list.* FROM hotel_room_list JOIN room_service_list ON hotel_room_list.room_name=room_service_list.room WHERE hotel_room_list.owner='$account' AND ";
    //echo $condition;
    $sqlPage = "hotel_room_list.valid=1 AND room_service_list.valid=1 ORDER BY created_at DESC LIMIT $page_start, $per_page";
    $sqlRoomList .= $conditionAll;
    $sqlRoomList .= $sqlPage;
    $roomListResult = $conn->query($sqlRoomList);
} else {
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }
    $sqlRoomListAll = "SELECT hotel_room_list.*, room_service_list.* FROM hotel_room_list JOIN room_service_list ON hotel_room_list.room_name=room_service_list.room WHERE hotel_room_list.owner='$account' AND hotel_room_list.valid=1 AND room_service_list.valid=1";
    $sqlRoomListResultAll = $conn->query($sqlRoomListAll);
    $roomCount = $sqlRoomListResultAll->num_rows;

    $per_page = 5;
    $page_start = ($page - 1) * $per_page;
    $sqlRoomList = "SELECT hotel_room_list.*, room_service_list.* FROM hotel_room_list JOIN room_service_list ON hotel_room_list.room_name=room_service_list.room WHERE hotel_room_list.owner='$account' AND hotel_room_list.valid=1 AND room_service_list.valid=1 ORDER BY created_at DESC LIMIT $page_start, $per_page";
    $roomListResult = $conn->query($sqlRoomList);
    $totalPage = ceil($roomCount / $per_page);
}
$roomListResult = $conn->query($sqlRoomList);
$roomListRows = $roomListResult->fetch_all(MYSQLI_ASSOC);
/* var_dump($roomListRows); */



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
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
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
                        <form action="room_list.php" method="get">
                            <label for="service" class="mb-2">房型服務</label>
                            <button class="btn btn-info" type="submit">篩選</button>
                            <a class="btn btn-danger" href="room_list.php">清除篩選</a>
                            <div class=" row">
                                <div class="form-check col-lg-4 col-md-6">
                                    <input class="form-check-input" type="checkbox" value="pet" name="pet" <?php if (isset($_GET["pet"]) && $_GET["pet"] == "pet") echo "checked"; ?>>
                                    <label class="form-check-label" for="pet">
                                        寵物友善房
                                    </label>
                                </div>
                                <div class="form-check col-lg-4 col-md-6">
                                    <input class="form-check-input" type="checkbox" value="tv" name="tv" <?php if (isset($_GET["tv"]) && $_GET["tv"] == "tv") echo "checked"; ?>>
                                    <label class="form-check-label" for="tv">
                                        電視房
                                    </label>
                                </div>
                                <div class="form-check col-lg-4 col-md-6">
                                    <input class="form-check-input" type="checkbox" value="tub" name="tub" <?php if (isset($_GET["tub"]) && $_GET["tub"] == "tub") echo "checked"; ?>>
                                    <label class="form-check-label" for="tub">
                                        浴缸房
                                    </label>
                                </div>
                                <div class="form-check col-lg-4 col-md-6">
                                    <input class="form-check-input" type="checkbox" value="meal" name="meal" <?php if (isset($_GET["meal"]) && $_GET["meal"] == "meal") echo "checked"; ?>>
                                    <label class="form-check-label" for="meal">
                                        供餐
                                    </label>
                                </div>
                                <div class="form-check col-lg-4 col-md-6">
                                    <input class="form-check-input" type="checkbox" value="mini_bar" name="mini_bar" <?php if (isset($_GET["mini_bar"]) && $_GET["mini_bar"] == "mini_bar") echo "checked"; ?>>
                                    <label class="form-check-label" for="mini_bar">
                                        mini_bar
                                    </label>
                                </div>
                                <div class="form-check col-lg-4 col-md-6">
                                    <input class="form-check-input" type="checkbox" value="window" name="window" <?php if (isset($_GET["window"]) && $_GET["window"] == "window") echo "checked"; ?>>
                                    <label class="form-check-label" for="window">
                                        有窗戶
                                    </label>
                                </div>
                                <div class="form-check col-lg-4 col-md-6">
                                    <input class="form-check-input" type="checkbox" value="corner" name="corner" <?php if (isset($_GET["corner"]) && $_GET["corner"] == "corner") echo "checked"; ?>>
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
                    <div class="position-absolute pointer arrow-btn" style="font-size: 36px;">
                        <div class="arrow-down">
                            <ion-icon name="caret-down-circle-outline"></ion-icon>
                        </div>
                        <div class="d-none arrow-up">
                            <ion-icon name="caret-up-circle-outline"></ion-icon>
                        </div>
                    </div>
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
                                <tbody>
                                    <?php if ($orderList["product_id"] === $serviceOfRoom["room"] && $orderList["user"] === $orderList["user_detail"]) : ?>
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
                                    <?php endif; ?>
                                </tbody>
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
            <?php elseif (isset($_GET["select"])) : ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                            <li class="page-item <?php if ($i == $page) echo "active"; ?>"><a class="page-link" href="room_list.php?page=<?= $i ?>&&select=<?= $_GET["select"] ?>"><?= $i ?></a></li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php else : ?>
                <nav aria-label=" Page navigation example">
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
        const arrowDown = document.querySelectorAll(".arrow-down");
        const arrowUp = document.querySelectorAll(".arrow-up");
        for (let i = 0; i < arrowBtns.length; i++) {
            arrowBtns[i].addEventListener("click", function() {
                if (!roomDetails[i].classList.contains("d-none")) {
                    roomDetails[i].classList = "row room-details d-none"
                    arrowUp[i].classList = "arrow-up d-none"
                    arrowDown[i].classList = "arrow-down"
                } else {
                    roomDetails[i].classList = "row room-details"
                    arrowUp[i].classList = "arrow-up"
                    arrowDown[i].classList = "arrow-down d-none"
                }
            })
        }
    </script>
</body>

</html>