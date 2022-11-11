<?php
require_once("../db-connect2.php");

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT * FROM hotel_account WHERE account LIKE '%$search%' AND valid=1 ORDER BY created_at DESC";
    $result = $conn->query($sql);
    $userCount = $result->num_rows;

    $per_page = 5;

    $sqlHotel = "SELECT * FROM hotel_room_list WHERE valid=1 ORDER BY created_at DESC LIMIT $per_page";
    $resultHotel = $conn->query($sqlHotel);
    $HotelCount = $resultHotel->num_rows;
} else {
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }
    if (isset($_GET["HotelPage"])) {
        $HotelPage = $_GET["HotelPage"];
    } else {
        $HotelPage = 1;
    }

    $sqlAll = "SELECT * FROM hotel_account WHERE valid=1 ";
    $resultAll = $conn->query($sqlAll);
    $userCount = $resultAll->num_rows;
    $per_page = 5;

    $HotelPage_start = ($HotelPage - 1) * $per_page;

    $sqlHotelAll = "SELECT * FROM hotel_room_list WHERE valid=1 ORDER BY created_at DESC";
    $resultHotelAll = $conn->query($sqlHotelAll);
    $HotelCount = $resultHotelAll->num_rows;


    $sqlHotel = "SELECT hotel_room_list.*,hotel_account.account,hotel_account.id as account_id FROM hotel_room_list JOIN hotel_account ON hotel_room_list.owner=hotel_account.account WHERE  hotel_room_list.valid=1 ORDER BY created_at DESC LIMIT $HotelPage_start, $per_page ";
    $resultHotel = $conn->query($sqlHotel);
    // $page=1;
    $page_start = ($page - 1) * $per_page;


    $sql = "SELECT * FROM hotel_account WHERE valid=1 ORDER BY created_at DESC LIMIT $page_start, $per_page";

    $result = $conn->query($sql);


    //計算頁數
    $totalPage = ceil($userCount / $per_page);
    $totalHotelPage = ceil($HotelCount / $per_page);

    $nowsevenday = date("Y-m-d", strtotime("-1 month"));
    $sqlrecentHotel = "SELECT * FROM hotel_account WHERE created_at >= '$nowsevenday' ";
    $resultrecentHotel = $conn->query($sqlrecentHotel);
    $recentHotel = $resultrecentHotel->num_rows;
}

$rowsHotel = $resultHotel->fetch_all(MYSQLI_ASSOC);
$rows = $result->fetch_all(MYSQLI_ASSOC);

// $rows2=$result->fetch_all(MYSQLI_NUM);

// var_dump($rows);
// exit;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Admin Dashboard | Korsat X Parmaga</title>
    <!-- ======= Styles ====== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
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
                    <a href="../home/admin.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">概要</span>
                    </a>
                </li>

                <li>
                    <a href="../admin-user/admin.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">會員</span>
                    </a>
                </li>

                <li>
                    <a href="admin.php">
                        <span class="icon">
                            <ion-icon name="chatbubble-outline"></ion-icon>
                        </span>
                        <span class="title">HOTEL</span>
                    </a>
                </li>

                <li>
                    <a href="../travel/admin-travel.php">
                        <span class="icon">
                            <ion-icon name="help-outline"></ion-icon>
                        </span>
                        <span class="title">TRAVEL</span>
                    </a>
                </li>

                <li>
                    <a href="../coupon/admin.php">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">優惠卷</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                        </span>
                        <span class="title">Password</span>
                    </a>
                </li>

                <li>
                    <a href="../index.php">
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
                    <form action="admin.php" method="get">
                        <label>
                            <input type="text" placeholder="Search here" class="form-control" name="search">
                            <ion-icon name="search-outline"></ion-icon>
                            <!-- <button type="submit" class="btn btn-info">搜尋</button> -->
                        </label>
                    </form>
                </div>
                <!-- <?php if (isset($_GET["search"])) : ?>
                    <div class="py-2">
                        <a class="btn btn-info" href="admin.php">回使用者列表</a>
                    </div>
                    <h1><?= $_GET["search"] ?> 的搜尋結果</h1>
                <?php endif; ?> -->

                <div class="user">
                    <img src="assets/imgs/customer01.jpg" alt="">
                </div>
            </div>

            <!-- ======================= Cards ================== -->
            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers"><?= $userCount ?></div>
                        <div class="cardName">HOTEL數

                        </div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"></div>
                        <div class="cardName">平均年齡</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"></div>
                        <div class="cardName">男女比</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">
                            <?php if (isset($_GET["search"])) {
                                echo "未定";
                            } else {
                                echo $recentHotel . "家";
                            }
                            ?>
                        </div>
                        <div class="cardName">近一個月新增會員</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cash-outline"></ion-icon>
                    </div>
                </div>
            </div>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>HOTEL清單</h2>
                        <!-- <a href="#" class="btn">View All</a> -->
                        <?php if (isset($_GET["search"])) : ?>
                            <div class="py-2">
                                <a class="btn btn-info" href="admin.php">回使用者列表</a>
                            </div>
                            <h1><?= $_GET["search"] ?> 的搜尋結果</h1>
                        <?php endif; ?>

                        <div class="py-2 d-flex justify-content-end">
                            <a class="btn btn-info" href="admin-add-hotel.php">新增HOTEL</a>
                        </div>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>公司名稱</td>
                                <td>負責人</td>
                                <td>地址</td>
                                <td>電話</td>
                                <td>星級</td>
                                <td>操作</td>
                            </tr>
                        </thead>
                        <?php if ($userCount > 0) : ?>
                            <tbody>
                                <?php foreach ($rows as $row) : ?>
                                    <tr>

                                        <td><?= $row["company_name"] ?></td>
                                        <td><?= $row["name"] ?></td>
                                        <td><?= $row["address"] ?></td>
                                        <td><?= $row["company_phone"] ?></td>
                                        <td><?= $row["stars"] ?></td>
                                        <td>
                                            <a class="btn btn-info" href="admin-hotel.php?id=<?= $row["id"] ?>">檢視</a>
                                            <a class="btn btn-danger" href="admin-delete-hotel.php?id=<?= $row["id"] ?>">刪除</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        <?php endif; ?>
                    </table>
                    <?php if (!isset($_GET["search"])) : ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                                    <li class="page-item <?php if ($i == $page) echo "active"; ?>"><a class="page-link" href="admin.php?page=<?= $i ?>"><?= $i ?></a></li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>

                <!-- ================= New Customers ================ -->
                <div class="recentCustomers ">
                    <div class="cardHeader">
                        <h2>最新上架行程清單</h2>
                    </div>
                    <!-- 目前無上架行程 -->
                    <table>
                        <thead>
                            <tr>
                                <td>id</td>
                                <td>Hotel業者</td>
                                <td>行程名稱</td>
                                <td>價格</td>
                                <td>房間說明</td>
                                <td>操作</td>

                            </tr>
                        </thead>
                        <?php if ($HotelCount > 0) : ?>
                            <tbody>
                                <?php foreach ($rowsHotel as $row) : ?>
                                    <tr>

                                        <td><?= $row["id"] ?></td>
                                        <td><?= $row["owner"] ?></td>
                                        <td><?= $row["room_name"] ?></td>
                                        <td><?= $row["price"] ?></td>
                                        <td><?= $row["description"] ?></td>
                                        <td>
                                            <a class="btn btn-info" href="admin-hotel.php?id=<?= $row["account_id"] ?>">查看業者</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        <?php endif; ?>
                    </table>
                    <?php if (!isset($_GET["search"])) : ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalHotelPage; $i++) : ?>
                                    <li class="page-item <?php if ($i == $HotelPage) echo "active"; ?>"><a class="page-link" href="admin.php?HotelPage=<?= $i ?>"><?= $i ?></a></li>
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
</body>

</html>