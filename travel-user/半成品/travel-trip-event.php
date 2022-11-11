<?php
//需要session account name 作為上傳者
require_once("./db-connect.php");
require_once('var_dump_pre.php');

$sqlTrip = "SELECT * FROM trip_event";
$result = $conn->query($sqlTrip);
$rows = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>產品一覽</title>
    <!-- ======= Styles ====== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/trip-event.css">
    <style>
        .main.active {
            width: calc(100% - 110px);
            left: 110px;
        }

        .navigation.active {
            width: 110px;
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
                    <a href="travel-user.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">概要</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">上架</span>
                    </a>
                </li>

                <li>
                    <a href="travel-trip-event-grid-test.php">
                        <span class="icon">
                            <ion-icon name="chatbubble-outline"></ion-icon>
                        </span>
                        <span class="title">產品一覽</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="help-outline"></ion-icon>
                        </span>
                        <span class="title">公司資料修改</span>
                    </a>
                </li>

                <li>
                    <a href="#">
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

                <div class="user">
                    <img src="assets/imgs/customer01.jpg" alt="">
                </div>
            </div>
            <!-- ================ Form ================= -->
            <div class="details">
            <?php foreach ($rows as $product) : ?>
                <?php $pictureArr = explode(',',$product['picture']); ?>
                        <div class="products-items my-2">
                            <div class="titlecard">
                                <div class="products-control">
                                    <h4><?= $product["trip_name"] ?></h4>
                                </div>
                                <img src="./assets/imgs/<?=$pictureArr[0]?>" alt="">
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
                                <a class="bg-danger" href="javascript:void(0)">刪除</a>
                            </div>
                            <!-- <a class="btn btn-danger" href="javascript:void(0)">刪除</a> -->
                        </div>
                    <?php endforeach; ?>

            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="./assets/js/main2.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>