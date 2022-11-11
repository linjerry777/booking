<?php
require_once("../db-connect2.php");

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT * FROM hotel_account WHERE account LIKE '%$search%' AND valid=1 ORDER BY created_at DESC";
    $result = $conn->query($sql);
    $userCount = $result->num_rows;
} else {
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }

    $sqlAll = "SELECT * FROM hotel_account WHERE valid=1 ";
    $resultAll = $conn->query($sqlAll);
    $userCount = $resultAll->num_rows;

    $per_page = 5;
    // $page=1;
    $page_start = ($page - 1) * $per_page;

    $sql = "SELECT * FROM hotel_account WHERE valid=1 ORDER BY created_at DESC LIMIT $page_start, $per_page";

    $result = $conn->query($sql);


    //計算頁數
    $totalPage = ceil($userCount / $per_page);
    // 計算人數

}


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
                        <h2>HOTEL清單</h2>
                        <!-- <a href="#" class="btn">View All</a> -->
                    </div>
                    <div class="py-2">
                        <a class="btn btn-info" href="admin.php">查看所有HOTEL</a>
                    </div>
                    <form action="admin-doInsert-hotel.php" method="post">
                        <div class="mb-2">
                            <label for="account">帳戶</label>
                            <input type="text" class="form-control" id="account" name="account" required>
                        </div>
                        <div class="mb-2">
                            <label for="password">密碼</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-2">
                            <label for="name">負責人</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-2">
                            <label for="address">地址</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="mb-2">
                            <label for="company_name">公司名</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" required>
                        </div>
                        <div class="mb-2">
                            <label for="company_phone">公司電話</label>
                            <input type="text" class="form-control" id="company_phone" name="company_phone" required>
                        </div>
                        <div class="mb-2">
                            <label for="stars">星級</label>
                            <input type="text" class="form-control" id="stars" name="stars" required>
                        </div>
                        <div class="mb-2">
                            <label for="area">地區</label>
                            <select class="form-control" name="area" id="area">
                                <option value="0">北</option>
                                <option value="1">中</option>
                                <option value="2">南</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="bank_account">銀行帳戶</label>
                            <input type="text" class="form-control" id="bank_account" name="bank_account" required>
                        </div>
                        <div class="mb-2">
                            <label for="start_date">開業日期</label>
                            <input type="date" class="form-control" id="start_date" name="start_date">
                        </div>
                        <div class="mb-2">
                            <label for="email">信箱</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-2">
                            <label for="website">官網</label>
                            <input type="text" class="form-control" id="website" name="website" required>
                        </div>
                        <button class="btn btn-info" type="submit">送出</button>
                    </form>


                </div>

                <!-- ================= New Customers ================ -->
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Hotel清單</h2>
                        <?php if (isset($_GET["search"])) : ?>
                            <div class="py-2">
                                <a class="btn btn-info" href="admin.php">回使用者列表</a>
                            </div>
                            <h1><?= $_GET["search"] ?> 的搜尋結果</h1>
                        <?php endif; ?>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>公司名稱</td>
                                <td>負責人</td>
                                <td>地址</td>
                                <td>電話</td>
                                <td>星級</td>
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
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        <?php endif; ?>
                    </table>
                    <?php if (!isset($_GET["search"])) : ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                                    <li class="page-item <?php if ($i == $page) echo "active"; ?>"><a class="page-link" href="admin-add-hotel.php?page=<?= $i ?>"><?= $i ?></a></li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
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