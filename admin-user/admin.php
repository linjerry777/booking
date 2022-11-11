<?php
require_once("../db-connect2.php");

/* if(!isset($_POST["email"])){
    header("location:../index.php");
} */

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT * FROM users WHERE account LIKE '%$search%' AND valid=1 ORDER BY created_at DESC";
    $resultAll = $conn->query($sql);
    $userCount = $resultAll->num_rows;

    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }

    $per_page = 5;
    // $page=1;
    $page_start = ($page - 1) * $per_page;
    /* echo $page_start;
    exit; */
    $sqlpage = "SELECT * FROM users WHERE  account LIKE '%$search%' AND valid=1  LIMIT $page_start, $per_page";
    $result = $conn->query($sqlpage);


    // var_dump($rows2);
    //計算頁數
    $totalPage = ceil($userCount / $per_page);

    // $rows = $result->fetch_all(MYSQLI_ASSOC);





    $account = $_GET["search"];
    $sqlorderlist = "SELECT * FROM total_order_list INNER JOIN total_order_list_detail ON total_order_list.product_id = total_order_list_detail.product_id AND total_order_list.user = '$account' ";
    $resultsqlorderlist = $conn->query($sqlorderlist);
    $product = $resultsqlorderlist->fetch_all(MYSQLI_ASSOC);
} else {
    if (isset($_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }

    $sqlAll = "SELECT * FROM users WHERE valid=1 ";
    $resultAll = $conn->query($sqlAll);
    $userCount = $resultAll->num_rows;

    $per_page = 5;
    // $page=1;
    $page_start = ($page - 1) * $per_page;

    $sql = "SELECT * FROM users WHERE valid=1 ORDER BY created_at DESC LIMIT $page_start, $per_page";

    $result = $conn->query($sql);


    //計算頁數
    $totalPage = ceil($userCount / $per_page);
    //計算近期商品列表頁數
    $sqlProductlist = "SELECT * FROM users INNER JOIN total_order_list ON users.account = total_order_list.user";
    $resultProductlist = $conn->query($sqlProductlist);
    $productCount = $resultProductlist->num_rows;

    $per_page = 5;
    // $page=1;
    $page_start = ($page - 1) * $per_page;

    $productPage = ceil($productCount / $per_page);


    // 計算年齡
    $nowday = date('Y-m-d');
    $sqlbirthday = "SELECT * FROM users WHERE birthday";
    $resultBirthday = $conn->query($sqlbirthday);
    // $rows = $resultBirthday->fetch_all();
    // $birthdayCount =array_column($rows,'birthday');

    $rows2 = $resultBirthday->fetch_all(MYSQLI_ASSOC);
    foreach ($rows2 as $row) {
        // echo $row["birthday"]."<br>";
    }
    $personAge = array_column($rows2, "birthday", "id");
    // echo $personAge["1"];
    $totalAge = 0;
    for ($i = 1; $i < $userCount; $i++) {
        // echo $personAge[$i];
        $age = date('Y', time()) - date('Y', strtotime($personAge[$i])) - 1;
        if (date('m', time()) == date('m', strtotime($personAge[$i]))) {
            if (date('d', time()) > date('d', strtotime($personAge[$i]))) {
                $age++;
            }
        } elseif (date('m', time()) > date('m', strtotime($personAge[$i]))) {
            $age++;
        }
        // echo $age."<br>";
        $totalAge = $totalAge + $age;
    }
    // echo $totalAge."zz";

    /*  $age = date('Y', time()) - date('Y', strtotime($row)) - 1;
        if (date('m', time()) == date('m', strtotime($row))) {
            if (date('d', time()) > date('d', strtotime($row))) {
                $age++;
            }
        } elseif (date('m', time()) > date('m', strtotime($row))) {
            $age++;
        }
        echo $age; */



    $aveageAge = ceil($totalAge / $userCount);
    // echo $aveageAge;
    // exit;
    //男女比
    $sqlMale = "SELECT * FROM users WHERE gender=1 AND valid=1";
    $resultMale = $conn->query($sqlMale);
    $maleCount = $resultMale->num_rows;

    $sqlFemale = "SELECT * FROM users WHERE gender=0 AND valid=1";
    $resultfeMale = $conn->query($sqlFemale);
    $femaleCount = $resultfeMale->num_rows;
    //近期會員
    $nowsevenday = date("Y-m-d", strtotime("-1 month"));
    // echo $nowsevenday;
    $sqlrecentMembers = "SELECT * FROM users WHERE created_at >= '$nowsevenday' ";
    $resultrecentMembers = $conn->query($sqlrecentMembers);
    $recentMembers = $resultrecentMembers->num_rows;
    //近期訂購商品
    $sqlorderlist = "SELECT * FROM users INNER JOIN total_order_list ON users.account = total_order_list.user";
    $resultsqlorderlist = $conn->query($sqlorderlist);
    $product = $resultsqlorderlist->fetch_all(MYSQLI_ASSOC);
    // echo $product;
    // exit;
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
                    <a href="admin.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">會員</span>
                    </a>
                </li>

                <li>
                    <a href="../hotel/admin.php">
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
                            <input type="text" placeholder="輸入帳戶後搜尋" class="form-control" name="search">
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


                        <div class="numbers">
                            <?php if (isset($_GET["search"])) {
                                echo "未定";
                            } else {
                                echo $aveageAge;
                            }
                            ?>

                        </div>
                        <div class="cardName">平均年齡</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">
                            <?php if (isset($_GET["search"])) {
                                echo "未定";
                            } else {
                                echo $maleCount . ":" . $femaleCount;
                            }
                            ?>
                            <!-- <?= $maleCount ?>:<?= $femaleCount ?> -->
                        </div>
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
                                echo $recentMembers . "人";
                            }
                            ?>
                            <!-- <?= $recentMembers ?>人 -->
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
                        <h2>會員清單</h2>
                        <!-- <a href="#" class="btn">View All</a> -->
                        <?php if (isset($_GET["search"])) : ?>
                            <div class="py-2">
                                <a class="btn btn-info" href="admin.php">回使用者列表</a>
                            </div>
                            <h1><?= $_GET["search"] ?> 的搜尋結果</h1>
                        <?php endif; ?>

                        <div class="py-2 d-flex justify-content-end">
                            <a class="btn btn-info" href="admin-add-user.php">新增會員</a>
                        </div>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>id</td>
                                <td>帳戶</td>
                                <td>姓名</td>
                                <td>電話</td>
                                <td>信箱</td>

                                <td>身分證</td>
                                <td>生日</td>
                                <td>性別</td>
                                <td>黑名單</td>


                                <td>操作</td>
                            </tr>
                        </thead>
                        <?php if ($userCount > 0) : ?>
                            <tbody>
                                <?php foreach ($rows as $row) : ?>
                                    <tr>

                                        <td><?= $row["id"] ?></td>
                                        <td><?= $row["account"] ?></td>
                                        <td><?= $row["name"] ?></td>
                                        <td><?= $row["phone"] ?></td>
                                        <td><?= $row["email"] ?></td>
                                        <td><?= $row["identification"] ?></td>
                                        <td><?= $row["birthday"] ?></td>
                                        <td>
                                            <?php if ($row["gender"] == 0) {
                                                echo "女";
                                            } else {
                                                echo "男";
                                            }

                                            ?>
                                        </td>
                                        <td><?php if ($row["valid"] == 0) {
                                                echo "是";
                                            } else {
                                                echo "否";
                                            }

                                            ?> </td>

                                        <td>
                                            <a class="btn btn-info" href="admin-user-product.php?account=<?= $row["account"] ?>">檢視</a>
                                            <a class="btn btn-danger" href="admin-delete-user.php?id=<?= $row["id"] ?>">刪除</a>
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
                    <?php else : ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                                    <li class="page-item <?php if ($i == $page) echo "active"; ?>"><a class="page-link" href="admin.php?page=<?= $i ?>&&search=<?= $_GET["search"] ?>"><?= $i ?></a></li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>

                <!-- ================= New Customers ================ -->
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>近期訂購商品</h2>
                        <!-- <a href="#" class="btn">View All</a> -->
                        <?php if (isset($_GET["search"])) : ?>
                            <div class="py-2">
                                <a class="btn btn-info" href="admin.php">回使用者列表</a>
                            </div>
                            <h1><?= $_GET["search"] ?> 的搜尋結果</h1>
                        <?php endif; ?>

                        <!--  <div class="py-2 d-flex justify-content-end">
                            <a class="btn btn-info" href="admin-add-user.php">新增會員</a>
                        </div> -->
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <!-- <td>id</td> -->
                                <td>帳戶</td>
                                <td>姓名</td>
                                <td>電話</td>
                                <td>商品</td>
                                <td>操作</td>
                            </tr>
                        </thead>
                        <?php if ($userCount > 0) : ?>
                            <tbody>
                                <?php foreach ($product as $row) : ?>
                                    <tr>

                                        <td><?= $row["user"] ?></td>
                                        <td><?= $row["company_id"] ?></td>
                                        <td><?= $row["product_id"] ?></td>
                                        <td><?= $row["status"] ?></td>

                                        <td>
                                            <a class="btn btn-info" href="admin-user-product.php?account=<?= $row["account"] ?>">檢視</a>
                                            <!-- <a class="btn btn-danger" href="admin-delete-user.php?id=<?= $row["id"] ?>">刪除</a> -->
                                        </td>
                                    </tr>

                                    <!--  <tr>
                                        <td>Star Refrigerator</td>
                                        <td>$1200</td>
                                        <td>Paid</td>
                                        <td><span class="status delivered">Delivered</span></td>
                                    </tr>

                                    <tr>
                                        <td>Dell Laptop</td>
                                        <td>$110</td>
                                        <td>Due</td>
                                        <td><span class="status pending">Pending</span></td>
                                    </tr>

                                    <tr>
                                        <td>Apple Watch</td>
                                        <td>$1200</td>
                                        <td>Paid</td>
                                        <td><span class="status return">Return</span></td>
                                    </tr>

                                    <tr>
                                        <td>Addidas Shoes</td>
                                        <td>$620</td>
                                        <td>Due</td>
                                        <td><span class="status inProgress">In Progress</span></td>
                                    </tr>

                                    <tr>
                                        <td>Star Refrigerator</td>
                                        <td>$1200</td>
                                        <td>Paid</td>
                                        <td><span class="status delivered">Delivered</span></td>
                                    </tr>

                                    <tr>
                                        <td>Dell Laptop</td>
                                        <td>$110</td>
                                        <td>Due</td>
                                        <td><span class="status pending">Pending</span></td>
                                    </tr>

                                    <tr>
                                        <td>Apple Watch</td>
                                        <td>$1200</td>
                                        <td>Paid</td>
                                        <td><span class="status return">Return</span></td>
                                    </tr>

                                    <tr>
                                        <td>Addidas Shoes</td>
                                        <td>$620</td>
                                        <td>Due</td>
                                        <td><span class="status inProgress">In Progress</span></td>
                                    </tr> -->
                                <?php endforeach; ?>
                            </tbody>
                        <?php endif; ?>
                    </table>
                    <?php if (!isset($_GET["search"])) : ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $productPage; $i++) : ?>
                                    <li class="page-item <?php if ($i == $page) echo "active"; ?>"><a class="page-link" href="admin.php?page=<?= $i ?>"><?= $i ?></a></li>
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