<?php

require_once('var_dump_pre.php');
require_once("../../db-connect2.php");

session_start();

//設計sql 從session['email']得值取得account名

$email = $_SESSION["email"];
$sqlUserAccount = "SELECT * FROM travel_account WHERE travel_account.email='$email' AND valid=1";
$result = $conn->query($sqlUserAccount);
//設置userCount 看看帳號存不存在
$userCount = $result->num_rows;
$rows = $result->fetch_assoc();
//設定按下刪除鍵的網址
$_SESSION['del_location'] = $_SERVER['PHP_SELF'];
// var_dump_pre($_SESSION['location']);


//將變數$account的值設為 account實際名稱
$_SESSION['account'] = $rows['account'];
$account = $_SESSION['account'];
// var_dump_pre($rows);

if (!isset($_SESSION["email"])) {
    echo "請循正常管道進入本頁";
    exit;
}
if (!isset($_SESSION["email"])) {
    echo "請循正常管道進入本頁";
    exit;
}
//從資料庫找尋此公司擁有的行程
$sqlTrip = "SELECT * FROM trip_event WHERE valid=1 AND owner='$account'";
$result = $conn->query($sqlTrip);
$trips = $result->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RWD後台</title>
    <!-- ======= Styles ====== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/travel-user.css">
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
                        <span class="title">Booking</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">概要</span>
                    </a>
                </li>

                <li>
                    <a href="trip-create.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">上架</span>
                    </a>
                </li>

                <li>
                    <a href="trip-list.php">
                        <span class="icon">
                            <ion-icon name="chatbubble-outline"></ion-icon>
                        </span>
                        <span class="title">產品一覽</span>
                    </a>
                </li>
                <li>
                    <a href="../doSignout.php">
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

                <!-- <div class="search">
                    <form action="admin.php" method="get">
                        <label>
                            <input type="text" placeholder="Search here" class="form-control" name="search">
                            <ion-icon name="search-outline"></ion-icon>
                            <button type="submit" class="btn btn-info">搜尋</button>
                        </label>
                    </form>
                </div>   -->
                <div class="user">
                    <img src="assets/imgs/customer01.jpg" alt="">
                </div>
            </div>

            <!-- ======================= Cards ================== -->
            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers">12</div>
                        <div class="cardName">本周團數</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="accessibility-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div class="omote">
                        <div class="numbers">80</div>
                        <div class="cardName">客人評論數</div>
                    </div>

                    <!-- <div class="ura">
                        <div class="numbers">80</div>
                        <div class="cardName">平均評論等級</div>
                    </div> -->

                    <div class="iconBx">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>

                </div>

                <div class="card">
                    <div class="omote">
                        <div class="numbers">284</div>
                        <div class="cardName">線上成交量</div>
                    </div>
                    <!-- <div class="ura">
                        <div class="numbers">284</div>
                        <div class="cardName">上個月成交量</div>
                    </div> -->
                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div class="omote">
                        <div class="numbers">$7,842</div>
                        <div class="cardName">成交額</div>
                    </div>
                    <!-- <div class="ura">
                        <div class="numbers">$7,842</div>
                        <div class="cardName">稅後淨利</div>
                    </div> -->

                    <div class="iconBx">
                        <ion-icon name="cash-outline"></ion-icon>
                    </div>
                </div>
            </div>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="companyDetail">
                    <h2 id="account">帳號資料</h2>
                    <?php if ($userCount == 0) : ?>
                        使用者不存在
                    <?php else : ?>
                        <table class="table table-bordered ">
                            <tbody>
                                <tr>
                                    <td colspan="2">
                                        <img class="company-banner" src="./assets/imgs/<?=$account?>/<?= $rows["company_banner"] ?>" alt="<?= $rows["company_banner"] ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>會員帳號</td>
                                    <td><?= $rows["account"] ?></td>
                                </tr>
                                <tr>
                                    <td>會員密碼</td>
                                    <td><?= $rows["password"] ?></td>
                                </tr>


                                <tr>
                                    <td>負責人姓名</td>
                                    <td><?= $rows["name"] ?></td>
                                </tr>
                                <tr>
                                    <td>公司名稱</td>
                                    <td><?= $rows["company_name"] ?></td>
                                </tr>
                                <tr>
                                    <td>開業日期</td>
                                    <td><?= $rows["start_date"] ?></td>
                                </tr>
                                <tr>
                                    <td>地區</td>
                                    <td>
                                        <?php
                                        if ($rows["area"] == 0) {
                                            echo "北";
                                        }
                                        if ($rows["area"] == 1) {
                                            echo "中";
                                        }
                                        if ($rows["area"] == 2) {
                                            echo "南";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>公司電話</td>
                                    <td><?= $rows["company_phone"] ?></td>
                                </tr>
                                <tr>
                                    <td>公司信箱</td>
                                    <td><?= $rows["email"] ?></td>
                                </tr>
                                <tr>
                                    <td>銀行帳戶</td>
                                    <td><?= $rows["bank_account"] ?></td>
                                </tr>
                                <tr>
                                    <td>官網</td>
                                    <td><?= $rows["website"] ?></td>
                                </tr>
                                <tr>
                                    <td>公司簡介</td>
                                    <td><?= $rows["introduction"] ?></td>
                                </tr>
                                <tr>
                                    <td>加入會員時間</td>
                                    <td><?= $rows["created_at"] ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="py-2">
                            <a class="btn btn-info" href="travel-user-edit.php#account">編輯使用者</a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- ================= New Customers ================ -->
                <div class="products">
                    <div class="cardHeader">
                        <h2>現有行程</h2>
                    </div>
                    <?php foreach ($trips as $product) : ?>
                        <?php $pictureArr = explode(',', $product['picture']); ?>
                        <div class="products-items my-2">
                            <div class="titlecard">
                                <div class="products-control">
                                    <h4><?= $product["trip_name"] ?></h4>
                                </div>
                                <img src="./assets/imgs/<?=$account?>/<?= $pictureArr[0] ?>" alt="">
                            </div>
                            <div class="products-summary">
                                <h5 class="start-date">上架日：
                                    <span><?= $product["start_date"] ?></span>
                                </h5>
                                <h5 class="price">價格：
                                    <span>NT$<?= $product["price"] ?></span>
                                </h5>
                                <h5 class="comment-star">評價：
                                    <span>5</span>
                                </h5>
                                <a class="bg-danger" href="do-delete.php?product=<?= $product["trip_name"] ?>">刪除</a>
                            </div>
                            <!-- <a class="btn btn-danger" href="javascript:void(0)">刪除</a> -->
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="./assets/js/travel-user.js"></script>


    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>