<?php

if (!isset($_GET["id"])) {
    echo "使用者不存在";
    exit;
}

$id = $_GET["id"];

require_once("../db-connect2.php");

$sql = "SELECT * FROM hotel_account WHERE id='$id' AND valid=1";
$result = $conn->query($sql);
$userCount = $result->num_rows;
//本日壽星

$sqlHotellist = "SELECT hotel_room_list.*,hotel_account.account FROM hotel_room_list JOIN hotel_account ON hotel_room_list.owner=hotel_account.account WHERE hotel_account.id='$id' AND  hotel_room_list.valid=1 ORDER BY created_at DESC";
$resultHotellist = $conn->query($sqlHotellist);
//$totalTravelPage = ceil($travelCount /$per_page);

$row = $result->fetch_assoc();
$rowsHotellist = $resultHotellist->fetch_All(MYSQLI_ASSOC);
$nowsevenday = date("Y-m-d", strtotime("-1 month"));
$sqlrecentHotel = "SELECT * FROM hotel_account WHERE created_at >= '$nowsevenday' ";
$resultrecentHotel = $conn->query($sqlrecentHotel);
$recentHotel = $resultrecentHotel->num_rows;
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
                    <label>
                        <input type="text" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>

                <div class="user">
                    <img src="assets/imgs/customer01.jpg" alt="">
                </div>
            </div>

            <!-- ======================= Cards ================== -->
            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers"><?= $row["account"] ?></div>
                        <div class="cardName">會員

                        </div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="person-circle-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"><?= $row["address"] ?></div>
                        <div class="cardName">地址</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="compass-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">   
                            <?php
                            if ($row["area"] == 0) {
                                echo "北";
                            } else if ($row["area"] == 1) {
                                echo "中";
                            } else if ($row["area"] == 2) {
                                echo "南";
                            } ?>
                        </div>
                        <div class="cardName">地區</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="locate-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"><?= $row["start_date"] ?></div>
                        <div class="cardName">開業日期</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="today-outline"></ion-icon>
                    </div>
                </div>


            </div>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>HOTEL資料</h2>
                        <a class="btn btn-info" href="admin.php">查看所有HOTEL</a>
                        <!-- <a href="#" class="btn">View All</a> -->
                    </div>
                    <!-- <div class="py-2">
                        <a class="btn btn-info" href="admin.php">User List</a>
                    </div> -->
                    <?php if ($userCount == 0) : ?>
                        使用者不存在
                    <?php else : ?>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>開業日期</td>
                                    <td><?= $row["start_date"] ?></td>
                                </tr>
                                <tr>
                                    <td>官網</td>
                                    <td><?= $row["website"] ?></td>
                                </tr>
                                <tr>
                                    <td>信箱</td>
                                    <td><?= $row["email"] ?></td>
                                </tr>
                                <tr>
                                    <td>銀行帳戶</td>
                                    <td><?= $row["bank_account"] ?></td>
                                </tr>
                                <tr>
                                    <td>飯店服務</td>
                                    <td><?= $row["email"] ?></td>
                                </tr>
                                <!-- <tr>
                                    <td>Phone</td>
                                    <td><?= $row["phone"] ?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><?= $row["email"] ?></td>
                                </tr>
                                <tr>
                                    <td>Cretated At</td>
                                    <td><?= $row["created_at"] ?></td>
                                </tr> -->
                            </tbody>
                        </table>
                        <div class="py-2">
                            <a class="btn btn-info" href="admin-edit-hotel.php?id=<?= $row["id"] ?>">編輯使用者</a>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- ================= New Customers ================ -->
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2><?= $row["account"] ?>-上架房型列表</h2>
                    </div>
                    <?php foreach ($rowsHotellist as $product) : ?>
                        <div class="products-items my-2">
                            <div class="titlecard">
                                <div class="products-control">
                                    <h4><?= $product["room_name"] ?></h4>
                                </div>
                                <img src="<?= $product["picture"] ?>" alt="">
                            </div>
                            <div class="products-summary">
                                <h5 class="price">價格：
                                    <span>NT$<?= $product["price"] ?></span>
                                </h5>
                                <a class="btn btn-danger" href="javascript:void(0)">查看</a>
                            </div>
                            <!-- <a class="btn btn-danger" href="javascript:void(0)">刪除</a> -->
                        </div>
                    <?php endforeach; ?>

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