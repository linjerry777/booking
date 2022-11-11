<?php

if (!isset($_GET["id"])) {
    echo "使用者不存在";
    exit;
}

$id = $_GET["id"];

require_once("../db-connect2.php");

$per_page = 5;

$sql = "SELECT * FROM hotel_account WHERE id='$id' AND valid=1";
$result = $conn->query($sql);
$userCount = $result->num_rows;

$row = $result->fetch_assoc();




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
                        <div class="cardName">廠商人數</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">284</div>
                        <div class="cardName">產品數量</div>
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

            <!-- ================ Order Details List ================= -->
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

                        <div class="py-2 d-flex justify-content-end">
                            <a class="btn btn-info" href="admin-add-hotel.php">新增HOTEL</a>
                        </div>
                    </div>
                    <?php if ($userCount == 0) : ?>
                        使用者不存在
                    <?php else : ?>
                        <div class="py-2">
                            <a class="btn btn-info" href="admin-hotel.php?id=<?= $row["id"] ?>">回使用者</a>
                        </div>
                        <form action="admin-doUpdate.php" method="post">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                        <td>id</td>
                                        <td>
                                            <?= $row["id"] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>帳戶</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["account"] ?>" name="account">
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

                <!-- ================= New Customers ================ -->
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Hotel資料</h2>
                    </div>
                    <table class="table table-bordered py-2 bg-light">
                        <tbody>
                            <tr>
                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                <td>id</td>
                                <td>
                                    <?= $row["id"] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>帳戶</td>
                                <td>
                                    <?= $row["account"] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>密碼</td>
                                <td>
                                    <?= $row["password"] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>負責人</td>
                                <td>
                                    <?= $row["name"] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>地址</td>
                                <td>
                                    <?= $row["address"] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>公司名</td>
                                <td>
                                    <?= $row["company_name"] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>公司電話</td>
                                <td>
                                    <?= $row["company_phone"] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>星級</td>
                                <td>
                                    <?= $row["stars"] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>地區</td>
                                <td>
                                    <?php
                                        if ($row["area"] == 0) {
                                            echo "北";
                                        } else if ($row["area"] == 1) {
                                            echo "中";
                                        } else if ($row["area"] == 2) {
                                            echo "南";
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>銀行帳戶</td>
                                <td>
                                    <?= $row["bank_account"] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>開業日期</td>
                                <td>
                                    <?= $row["start_date"] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>信箱</td>
                                <td>
                                    <?= $row["email"] ?>
                                </td>
                            </tr>
                            <tr>
                                <td>官網</td>
                                <td>
                                    <?= $row["website"] ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


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