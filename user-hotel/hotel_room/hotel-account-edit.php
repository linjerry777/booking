<?php

use LDAP\Result;

require_once("../../db-connect2.php");
session_start();
if (!isset($_SESSION["account"])) {
    echo "請循正常管道進入本頁";
    exit;
}
$email = $_SESSION["email"];
$sql = "SELECT * FROM hotel_account WHERE email='$email' AND valid=1";
$result = $conn->query($sql);
$userCount = $result->num_rows;

$row = $result->fetch_assoc();
$sqlUserAccount = "SELECT * FROM hotel_account WHERE hotel_account.email='$email'";
$userAccountResult = $conn->query($sqlUserAccount);
$userAccountRow = $userAccountResult->fetch_assoc();
$account = $userAccountRow["account"];
//$account = $_POST["account"];
//$account = "tangej";/* ---自己的環境時 */
$_SESSION["account"] = $account;/* ---自己的環境時 */
//$sqlHotelAccount = "SELECT hotel_account.*, hotel.service_list ON  WHERE hotel_account.account='$account' AND hotel_account.valid=1";

/* 飯店帳號sql */
$sqlHotelAccount = "SELECT * FROM hotel_account WHERE hotel_account.account='$account' AND hotel_account.valid=1";
$hotelAccountResult = $conn->query($sqlHotelAccount);
$hotelAccounCount = $hotelAccountResult->num_rows;
$hotelAccountRow = $hotelAccountResult->fetch_assoc();

/* 飯店服務清單sql */
$sqlHotelService = "SELECT * FROM hotel_service_list WHERE hotel_service_list.hotel='$account'";
$hotelServiceResult = $conn->query($sqlHotelService);
$hotelServiceRow = $hotelServiceResult->fetch_assoc();

/* 房間清單sql */
/* $sqlRoomList = "SELECT hotel_room_list.*, room_service_list.* FROM hotel_room_list JOIN room_service_list ON hotel_room_list.room_name=room_service_list.room WHERE hotel_room_list.owner='$account' AND valid=1";
$roomListResult = $conn->query($sqlRoomList);
$roomListRows = $roomListResult->fetch_all(MYSQLI_ASSOC); */
//var_dump($roomListRows);


/* 試寫房間清單分頁spl */
if (isset($_GET["search"])) {
    $search = $_GET["search"];
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }
    $per_page = 2;
    $page_start = ($page - 1) * $per_page;
    $sqlRoomListLike = "SELECT hotel_room_list.*, room_service_list.* FROM hotel_room_list JOIN room_service_list ON hotel_room_list.room_name=room_service_list.room WHERE hotel_room_list.owner='$account' AND room_name LIKE '%$search%' AND hotel_room_list.valid=1";
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

    $per_page = 2;
    $page_start = ($page - 1) * $per_page;
    $sqlRoomList = "SELECT hotel_room_list.*, room_service_list.* FROM hotel_room_list JOIN room_service_list ON hotel_room_list.room_name=room_service_list.room WHERE hotel_room_list.owner='$account' AND hotel_room_list.valid=1 ORDER BY created_at DESC LIMIT $page_start, $per_page";
    $roomListResult = $conn->query($sqlRoomList);
    $totalPage = ceil($roomCount / $per_page);
}
$roomListResult = $conn->query($sqlRoomList);
$roomListRows = $roomListResult->fetch_all(MYSQLI_ASSOC);
//var_dump($roomListRows);


/* $sql="SELECT products.*, category.name AS category_name FROM products JOIN category ON products.category_id = category.id WHERE products.price >= $min AND products.price <= $max"; */

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Account</title>
    <!-- ======= Styles ====== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
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

        .details {
            grid-template-columns: 1fr 1fr;
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
                    <form action="hotel-account.php" method="get">
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
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Hotel清單</h2>
                        <!-- <a href="#" class="btn">View All</a> -->
                        <?php if (isset($_GET["search"])) : ?>
                            <div class="py-2">
                                <a class="btn btn-info" href="admin.php">回使用者列表</a>
                            </div>
                            <h1><?= $_GET["search"] ?> 的搜尋結果</h1>
                        <?php endif; ?>
                    </div>
                    <?php if ($userCount == 0) : ?>
                        使用者不存在
                    <?php else : ?>
                        <div class="py-2">
                            <a class="btn btn-info" href="hotel-account.php?id=<?= $row["id"] ?>">回使用者</a>
                        </div>
                        <form action="admin-doUpdate.php" method="post">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                        <td class="text-start">id</td>
                                        <td class="text-start">
                                            <?= $row["id"] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>帳戶</td>
                                        <td class="text-start">
                                        <?= $row["account"] ?>
                                            <input readonly="readonly" type="hidden" class="form-control" value="<?= $row["account"] ?>" name="account">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>密碼</td>
                                        <td>
                                            <input type="password" class="form-control" value="<?= $row["password"] ?>" name="password">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>負責人</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["name"] ?>" name="name">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>地址</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["address"] ?>" name="address">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>公司名</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["company_name"] ?>" name="company_name">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>公司電話</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["company_phone"] ?>" name="company_phone">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>星級</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["stars"] ?>" name="stars">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>地區</td>
                                        <td>
                                            <select class="form-control" name="area" id="area">
                                                <option value="0">北</option>
                                                <option value="1">中</option>
                                                <option value="2">南</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>銀行帳戶</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["bank_account"] ?>" name="bank_account">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>開業日期</td>
                                        <td>
                                            <input type="date" class="form-control" value="<?= $row["start_date"] ?>" name="start_date">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>信箱</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["email"] ?>" name="email">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>官網</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["website"] ?>" name="website">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-info" type="submit">送出</button>
                        </form>
                    <?php endif; ?>

                </div>

                <!-- ================= 房型列表 ================ -->
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>房型列表</h2>
                        <?php if (isset($_GET["search"]) && $_GET["search"] !== "") : ?>
                            <h2>"<?= $_GET["search"] ?>"的收尋結果</h2>
                        <?php endif; ?>
                    </div>

                    <table>
                        <?php foreach ($roomListRows as $room) : ?>
                            <tr>
                                <td width="300px">
                                    <div class="imgBx"><img src="../upload/<?= $room["picture"] ?>" alt=""></div>
                                </td>
                                <td>
                                    <h2 class=""><?= $room["room"] ?> <br>
                                        <button class="btn btn-info roomView">檢視</button>
                                        <a class="btn btn-danger" href="./doDelete2_room.php?room=<?= $room["room"] ?>">下架</a>
                                        <div class=" d-none fs-3 roomDetail">價格: <?= $room["price"] ?> 空房數: <?= $room["amount"] ?>
                                        </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php if (!isset($_GET["search"])) : ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                                    <li class="page-item <?php if ($i == $page) echo "active"; ?>"><a class="page-link" href="hotel-account.php?page=<?= $i ?>"><?= $i ?></a></li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php else : ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                                    <li class="page-item <?php if ($i == $page) echo "active"; ?>"><a class="page-link" href="hotel-account.php?page=<?= $i ?>&&search=<?= $_GET["search"] ?>"><?= $i ?></a></li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script>
        const roomView = document.querySelectorAll(".roomView");
        const roomDetail = document.querySelectorAll(".roomDetail");
        for (let i = 0; i < roomView.length; i++) {
            roomView[i].addEventListener("click", function() {
                if (roomView[i].textContent === "檢視") {
                    roomDetail[i].classList = "fs-3"
                    roomView[i].textContent = "收合"
                } else if (roomView[i].textContent === "收合") {
                    roomDetail[i].classList = "fs-3 d-none"
                    roomView[i].textContent = "檢視"
                }
            })
        }
    </script>
</body>

</html>