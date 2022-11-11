<?php
require_once("../db-connect2.php");

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sql = "SELECT * FROM travel_account WHERE account LIKE '%$search%' AND valid=1 ORDER BY created_at DESC";
    $result = $conn->query($sql);
    $userCount = $result->num_rows;
    $sqlTravel = "SELECT * FROM trip_event WHERE valid=1 ORDER BY created_at DESC LIMIT  $per_page ";
    $resultTravel = $conn->query($sqlTravel);
    $travelCount=$resultTravel->num_rows;
} else {
    if (isset($_GET["userPage"])) {
        $userPage = $_GET["userPage"];
    } else {
        $userPage = 1;
    }
    if (isset($_GET["travelPage"])) {
        $travelPage = $_GET["travelPage"];
    } else {
        $travelPage = 1;
    }
  

    $sqlAll = "SELECT * FROM travel_account WHERE valid=1 ";
    $resultAll = $conn->query($sqlAll);
    $userCount = $resultAll->num_rows;
    $sqlTravelAll = "SELECT * FROM trip_event WHERE valid=1 ORDER BY created_at DESC";
    $resultTravelAll = $conn->query($sqlTravelAll);
    $travelCount=$resultTravelAll->num_rows;

    $per_page = 5;
    // $page=1;
    $userPage_start = ($userPage - 1) * $per_page;
    $travelPage_start = ($travelPage - 1) * $per_page;

    $sqlTravel = "SELECT trip_event.*,travel_account.account,travel_account.id as account_id FROM trip_event JOIN travel_account ON trip_event.owner=travel_account.account WHERE  trip_event.valid=1 ORDER BY created_at DESC LIMIT $travelPage_start, $per_page ";

    $resultTravel = $conn->query($sqlTravel);
    $totalTravelPage = ceil($travelCount /$per_page);

}


// $rows = $result->fetch_all(MYSQLI_ASSOC);
$rowsTravel=$resultTravel->fetch_all(MYSQLI_ASSOC);

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
            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers"><?= $userCount ?></div>
                        <div class="cardName">Travel人數

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
                        <h2>Travel清單</h2>
                        <!-- <a href="#" class="btn">View All</a> -->
                    </div>
                    <div class="py-2">
                        <a class="btn btn-info" href="admin-travel.php">查看所有Travel廠商</a>
                    </div>
                    <form action="admin-doInsert-travel-user.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col mb-2">
                                <label for="account">帳號</label>
                                <input type="text" class="form-control" id="account" name="account" required>
                            </div>
                            <div class="col mb-2">
                                <label for="password">密碼</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="company_banner">上傳圖片</label>
                            <input type="file" class="form-control" id="company_banner" name="company_banner" required>
                        </div>

                        <div class="mb-2">
                            <label for="name">負責人姓名</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-2">
                            <label for="company_name">公司名稱</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" required>
                        </div>
                        <div class="mb-2">
                            <label for="start_date">開業日期</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="mb-2">
                            <label for="area">地區</label>
                            <select name="area" id="area" class="form-select">
                                <option value="0" selected>北</option>
                                <option value="1">中</option>
                                <option value="2">南</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="company_phone">公司電話</label>
                            <input type="tel" class="form-control" id="company_phone" name="company_phone" required>
                        </div>

                        <div class="mb-2">
                            <label for="email">公司信箱</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-2">
                            <label for="bank_account">銀行帳戶</label>
                            <input type="text" class="form-control" id="bank_account" name="bank_account" required>
                        </div>
                        <div class="mb-2">
                            <label for="website">官網</label>
                            <input type="text" class="form-control" id="website" name="website" required>
                        </div>
                        <div class="mb-2">
                            <label for="introduction">公司簡介</label>
                            <input type="text" class="form-control" id="introduction" name="introduction" required>
                        </div>
                        <button class="btn btn-info" type="submit">送出</button>
                    </form>


                </div>

                <!-- ================= New Customers ================ -->
                <div class="recentCustomers ">
                    <div class="cardHeader">
                        <h2>最新上架行程清單</h2>
                    </div>
                    <?php if ($travelCount <= 0) :
                                    echo "目前無上架行程";
                    endif;?>
                    <table>
                        <thead>
                            <tr>
                                <td>id</td>
                                <td>Travel業者</td>
                                <td>行程名稱</td>
                                <td>價格</td>
                                <td>開團日</td>
                                <td>操作</td>
                                
                            </tr>
                        </thead>
                        <?php if ($travelCount > 0) : ?>
                            <tbody>
                                <?php foreach ($rowsTravel as $row) : ?>
                                    <tr>

                                        <td><?= $row["id"] ?></td>
                                        <td><?= $row["owner"] ?></td>
                                        <td><?= $row["trip_name"] ?></td>
                                        <td><?= $row["price"] ?></td>
                                        <td><?= $row["start_date"] ?></td>
                                        <td>
                                            <a class="btn btn-info" href="admin-travel-user.php?id=<?= $row["account_id"] ?>">查看業者</a>
                                            <!-- <a class="btn btn-danger" href="admin-delete-travel-user.php?id=<?= $row["id"] ?>">刪除</a> -->
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        <?php endif; ?>
                    </table>
                    <?php if (!isset($_GET["search"])) : ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalTravelPage; $i++) : ?>
                                    <li class="page-item <?php if ($i == $travelPage) echo "active"; ?>"><a class="page-link" href="admin-add-travel-user.php?travelPage=<?= $i ?>"><?= $i ?></a></li>
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