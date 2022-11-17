<?php
require_once("../db-connect2.php");

if (isset($_GET["search"])) {
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
    if(isset($_GET["area"])){
        $area=$_GET["area"];
    }else{
        $area=3;
    }
    $per_page = 5;
    $userPage_start = ($userPage - 1) * $per_page;
    $travelPage_start = ($travelPage - 1) * $per_page;
    $search = $_GET["search"];

    if($area==0||$area==1||$area==2){
        $sqlAll = "SELECT * FROM travel_account WHERE account LIKE '%$search%' AND valid=1 AND area='$area' ORDER BY created_at DESC";
        $sql = "SELECT * FROM travel_account WHERE account LIKE '%$search%' AND valid=1 AND area='$area' ORDER BY created_at DESC  LIMIT $userPage_start, $per_page";
    }else{
        $sqlAll = "SELECT * FROM travel_account WHERE account LIKE '%$search%' AND valid=1 ORDER BY created_at DESC";
        $sql = "SELECT * FROM travel_account WHERE account LIKE '%$search%' AND valid=1 ORDER BY created_at DESC  LIMIT $userPage_start, $per_page";
    }
   
    
    $resultAll = $conn->query($sqlAll);
    $result = $conn->query($sql);
    
    $userCount = $resultAll->num_rows;
    $sqlTripComment = "SELECT trip_comment.*,trip_event.owner,trip_event.id,travel_account.account,travel_account.id FROM trip_comment JOIN trip_event ON trip_event.id=trip_comment.trip JOIN travel_account ON trip_event.owner=travel_account.account  WHERE trip_comment.valid=1 ORDER BY created_at";
    $resultTripComment = $conn->query($sqlTripComment);
    $tripCommentCount = $resultTripComment->num_rows;
    // $sqlTravel = "SELECT trip_event.*,travel_account.account FROM trip_event JOIN travel_account ON trip_event.owner=travel_account.account WHERE travel_account.account LIKE '%$search%' AND  trip_event.valid=1";
    // $resultTravel = $conn->query($sqlTravel);
    // $travelCount=$resultTravel->num_rows;
    // $page=1;
    $sqlTravelAll = "SELECT * FROM trip_event WHERE valid=1 ORDER BY created_at DESC";
    $sqlTravel = "SELECT trip_event.*,travel_account.account,travel_account.id as account_id FROM trip_event JOIN travel_account ON trip_event.owner=travel_account.account WHERE  trip_event.valid=1  ORDER BY created_at DESC LIMIT $travelPage_start, $per_page ";
    $resultTravel = $conn->query($sqlTravel);
    $resultTravelAll = $conn->query($sqlTravelAll);
    $travelCount=$resultTravelAll->num_rows;

    $totalPage = ceil($userCount / $per_page);
   
    $totalTravelPage = ceil($travelCount /$per_page);

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
    if(isset($_GET["area"])){
        $area=$_GET["area"];
    }else{
        $area=3;
    }
    $per_page = 5;
    // $page=1;
    $userPage_start = ($userPage - 1) * $per_page;
    $travelPage_start = ($travelPage - 1) * $per_page;
    if($area==0||$area==1||$area==2){
        $sqlAll = "SELECT * FROM travel_account WHERE valid=1 AND area='$area'";
        $sql="SELECT * FROM travel_account WHERE valid=1 AND area='$area' ORDER BY created_at DESC LIMIT  $userPage_start,$per_page ";  
    }else{
        $sqlAll = "SELECT * FROM travel_account WHERE valid=1 ";
        $sql = "SELECT * FROM travel_account WHERE valid=1 ORDER BY created_at DESC LIMIT $userPage_start, $per_page";
    }
   
    $sqlTravelAll = "SELECT * FROM trip_event WHERE valid=1 ORDER BY created_at DESC";
    $resultAll = $conn->query($sqlAll);
    $userCount = $resultAll->num_rows;
    $resultTravelAll = $conn->query($sqlTravelAll);
    $travelCount=$resultTravelAll->num_rows;

    

   
    $sqlTravel = "SELECT trip_event.*,travel_account.account,travel_account.id as account_id FROM trip_event JOIN travel_account ON trip_event.owner=travel_account.account WHERE  trip_event.valid=1  ORDER BY created_at DESC LIMIT $travelPage_start, $per_page ";
    
    
    $result = $conn->query($sql);
    $resultTravel = $conn->query($sqlTravel);
    //計算頁數
     $totalPage = ceil($userCount / $per_page);
   
    $totalTravelPage = ceil($travelCount /$per_page);
    // var_dump($travelCount);
    // exit;
    // 計算人數
    $sqlTripComment = "SELECT trip_comment.*,trip_event.owner,trip_event.id,travel_account.account,travel_account.id FROM trip_comment JOIN trip_event ON trip_event.id=trip_comment.trip JOIN travel_account ON trip_event.owner=travel_account.account  WHERE trip_comment.valid=1 ORDER BY created_at";
    $resultTripComment = $conn->query($sqlTripComment);
    $tripCommentCount = $resultTripComment->num_rows;
    
    
}


$rowsTripComment=$resultTripComment->fetch_all(MYSQLI_ASSOC);

$rowsTravel=$resultTravel->fetch_all(MYSQLI_ASSOC);
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
    <link rel="stylesheet" href="./assets/css/trip_eventStyle2.css">
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
        .active{
            background: var(--blue);
            color: var(--white);
        }
    </style>
</head>

<body>
    
    <div class="crud-container">
        <!-- =============== Navigation ================ -->
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
                    <form action="admin-travel.php" method="get">
                        <label>
                            <input type="text" placeholder="Search account here" class="form-control" name="search">
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
                        <div class="cardName">Travel廠商人數

                        </div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="people-circle-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"><?=$tripCommentCount?></div>
                        <div class="cardName">Travel總評論數</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers"><?=$travelCount?></div>
                        <div class="cardName">Travel總上架行程數</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>

                <!-- <div class="card">
                    <div>
                        <div class="numbers">$7,842</div>
                        <div class="cardName">Travel總成交額</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cash-outline"></ion-icon>
                    </div>
                </div> -->
            </div>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader row">
                        <h2 class="col-4">Travel清單</h2>
                        <!-- <a href="#" class="btn">View All</a> -->
                        <div class="row col-8 justify-content-start">
                        <?php if (isset($_GET["search"])) : ?>
                            <h1 class="col-8"><?= $_GET["search"] ?> 的搜尋結果</h1>
                            <div class="py-2 col-4">
                                <a class="btn btn-info" href="admin-travel.php">回使用者列表</a>
                            </div>
                            
                        <?php endif; ?>
                        </div>
                        
                        <div class=" d-flex justify-content-end">
                            <div class=" area-radio mx-2  d-flex justify-content-end">
                                <?php if(isset($_GET["search"])):?>
                                <a class=" p-2 mx-1 rounded border-none border border-0 text-decoration-none <?php if($area==0){ echo 'active';}?>" href="admin-travel.php?search=<?=$_GET["search"]?>&&area=0">北</a><!--0 -->
                                <a class="p-2 mx-1 rounded border-none border border-0 text-decoration-none <?php if($area==1){ echo 'active';}?>" href="admin-travel.php?search=<?=$_GET["search"]?>&&area=1">中</a><!-- 1 -->
                                <a class="p-2 mx-1 rounded border-none border border-0 text-decoration-none <?php if($area==2){ echo 'active';}?>" href="admin-travel.php?search=<?=$_GET["search"]?>&&area=2">南</a><!-- 2 -->
                                <a class=" p-2 mx-1 rounded border-none border border-0 text-decoration-none <?php if($area==3){ echo 'active';}?>" href="admin-travel.php?search=<?=$_GET["search"]?>">All</a><!-- 3 -->
                                <?php else:?>
                                    <a class=" p-2 mx-1 rounded border-none border border-0 text-decoration-none <?php if($area==0){ echo 'active';}?>" href="admin-travel.php?area=0">北</a><!--0 -->
                                    <a class="p-2 mx-1 rounded border-none border border-0 text-decoration-none <?php if($area==1){ echo 'active';}?>" href="admin-travel.php?area=1">中</a><!-- 1 -->
                                    <a class="p-2 mx-1 rounded border-none border border-0 text-decoration-none <?php if($area==2){ echo 'active';}?>" href="admin-travel.php?area=2">南</a><!-- 2 -->
                                    <a class=" p-2 mx-1 rounded border-none border border-0 text-decoration-none <?php if($area==3){ echo 'active';}?>" href="admin-travel.php">All</a><!-- 3 -->
                                <?php endif;?>

                            </div>
                            <a class="btn btn-info" href="admin-add-travel-user.php">新增Travel廠商</a>
                        </div>
                        
                    </div>
                    

                    <table>
                        <thead>
                            <tr>
                                <td>公司名稱</td>
                                <td>帳戶</td>
                                <td>負責人</td>
                                <td>電話</td>
                                <td>信箱</td>
                                <td>操作</td>
                            </tr>
                        </thead>
                        <?php if ($userCount > 0) : ?>
                            <tbody style="height:290px;">
                                <?php foreach ($rows as $row) : ?>
                                    <tr >

                                        <td><?=$row["company_name"]  ?></td>
                                        <td><?= $row["account"] ?></td>
                                        <td><?= $row["name"] ?></td>
                                        <td><?= $row["company_phone"] ?></td>
                                        <td><?= $row["email"] ?></td>
                                        <td>
                                            <a class="btn btn-info" href="admin-travel-user.php?id=<?= $row["id"] ?>">檢視</a>
                                            <a class="btn btn-danger" href="admin-delete-travel-user.php?id=<?= $row["id"] ?>">刪除</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <?php else:?>
                                <tbody style="height:290px;">
                                    <tr>
                                        <td class="text-center" colspan="6">無合作業者</td>
                                    
                                    </tr>
                                </tbody>
                        <?php endif; ?>
                    </table>
                    <?php if (isset($_GET["search"])) : ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                                    <li class="page-item <?php if ($i == $userPage) echo "active"; ?>"><a class="page-link"<?php if($area==0||$area==1||$area==2):?>href="admin-travel.php?search=<?=$_GET["search"]?>&&area=<?=$area?>&&userPage=<?=$i?>"<?php else:?> href="admin-travel.php?search=<?=$_GET["search"]?>&&userPage=<?=$i?><?php endif; ?>"><?= $i ?></a></li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    <?php else:?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                                    <li class="page-item <?php if ($i == $userPage) echo "active"; ?>"><a class="page-link"<?php if($area==0||$area==1||$area==2){ echo "href='admin-travel.php?area=$area&&userPage=$i'";}else{echo "href='admin-travel.php?userPage=$i'";}?>><?= $i ?></a></li>
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
                    <table class="">
                        <thead>
                            <tr>
                                
                                <td>Travel業者</td>
                                <td>行程名稱</td>
                                <td>價格</td>
                                <td>開團日</td>
                                <td>操作</td>
                                
                            </tr>
                        </thead>
                        <?php if ($travelCount > 0) : ?>
                            <tbody style="height:290px;">
                                <?php foreach ($rowsTravel as $row) : ?>
                                    <tr>

                                        
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
                            <?php else:?>
                                <tbody style="height:290px;">
                                    <tr>
                                        <td class="text-center" colspan="6">無上架行程</td>
                                    
                                    </tr>
                                </tbody>
                        <?php endif; ?>
                    </table>
                    <?php if (isset($_GET["search"])) : ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalTravelPage; $i++) : ?>
                                    <li class="page-item <?php if ($i == $travelPage) echo "active"; ?>"><a class="page-link" href="admin-travel.php?search=<?=$_GET["search"]?>&&travelPage=<?= $i ?>"><?= $i ?></a></li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                        <?php else:?>
                            <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalTravelPage; $i++) : ?>
                                    <li class="page-item <?php if ($i == $travelPage) echo "active"; ?>"><a class="page-link" href="admin-travel.php?travelPage=<?= $i ?>"><?= $i ?></a></li>
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
    <script>
        // trip_event card.js
        let titlecard = document.querySelectorAll(".titlecard");
// let productSummary = document.querySelectorAll(".products-summary");



for (i=0;i<titlecard.length;i++) {
  titlecard[i].addEventListener("click",function(){
    this.nextElementSibling.classList.toggle("open");
  })
  }

let startDate = document.querySelectorAll(".start-date");
let price = document.querySelectorAll(".price");
let commentStar = document.querySelectorAll(".comment-star");
    </script>
                        
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>