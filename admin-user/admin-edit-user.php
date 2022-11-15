<?php

/* if (!isset($_GET["id"])) {
    echo "使用者不存在";
    exit;
} */

if (!isset($_GET["account"])) {
    echo "使用者不存在";
    exit;
}
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}

$account = $_GET["account"];

//  $account="SELECT users.account FROM users WHERE id='$id'";

require_once("../db-connect2.php");

$sql = "SELECT * FROM users WHERE account='$account' AND valid=1";
$result = $conn->query($sql);
$userCount = $result->num_rows;
$nowsevenday = date("Y-m-d");
$sqlbirthday = "SELECT * FROM users WHERE birthday = '$nowsevenday' ";
$resultBirthday = $conn->query($sqlbirthday);
$birthdayCount = $resultBirthday->num_rows;

$sqlorderlist = "SELECT * FROM total_order_list INNER JOIN total_order_list_detail ON total_order_list.product_id = total_order_list_detail.product_id_detail AND total_order_list.user = '$account' ";
$resultsqlorderlist = $conn->query($sqlorderlist);
$product = $resultsqlorderlist->fetch_all(MYSQLI_ASSOC);

//計算近期商品列表頁數
$sqlProductlist = "SELECT * FROM users INNER JOIN total_order_list ON users.account = total_order_list.user";
$resultProductlist = $conn->query($sqlProductlist);
$productCount = $resultProductlist->num_rows;

$per_page = 5;
// $page=1;
$page_start = ($page - 1) * $per_page;

$productPage = ceil($productCount / $per_page);
$row = $result->fetch_assoc();

// var_dump($row);
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
            <!-- <div class="cardBox">
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
            </div> -->
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
                        <div class="cardName">未定</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">
                            <?php echo $birthdayCount ?>
                        </div>
                        <div class="cardName">當日壽星</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">
                            <?php if ($row["level"] >= 0 && $row["level"] <= 99) {
                                echo "銅牌";
                            } else if ($row["level"] >= 100 && $row["level"] <= 999) {
                                echo "銀牌";
                            } else if ($row["level"] >= 1000 && $row["level"] <= 9999) {
                                echo "金牌";
                            } else if ($row["level"] >= 10000 && $row["level"] <= 99999) {
                                echo "鑽石";
                            } else if ($row["level"] >= 100000 && $row["level"] <= 999999) {
                                echo "光";
                            }
                            ?>
                        </div>
                        <div class="cardName">會員等級</div>
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
                    <?php if ($userCount == 0) : ?>
                        使用者不存在
                    <?php else : ?>
                        <div class="py-2">
                            <a class="btn btn-info" href="admin-user-product.php?account=<?= $row["account"] ?>">回使用者</a>
                        </div>
                        <form action="admin-doUpdate.php" method="post">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr style="display:none ;">
                                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                        <td>account</td>
                                        <td>
                                            <?= $row["id"] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <input type="hidden" name="account" value="<?= $row["account"] ?>">
                                        <td>account</td>
                                        <td>
                                            <?= $row["account"] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>密碼</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["password"] ?>" name="password">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>姓名</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["name"] ?>" name="name">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>電話</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["phone"] ?>" name="phone">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>信箱</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["email"] ?>" name="email">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>身分證</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["identification"] ?>" name="identification">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>生日</td>
                                        <td>
                                            <input type="date" class="form-control" value="<?= $row["birthday"] ?>" name="birthday">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>性別</td>
                                        <td>
                                            <!-- <input type="text" class="form-control" value="<?= $row["gender"] ?>" name="gender"> -->
                                            <select class="form-control" id="gender" name="gender">
                                                <option value="1">男</option>
                                                <option value="0">女</option>
                                            </select>
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
                        <h2>訂購商品</h2>
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