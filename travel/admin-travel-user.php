<?php

// if (!isset($_GET["id"])) {
//     echo "使用者不存在";
//     exit;
// }

$id = $_GET["id"];

require_once("../db-connect2.php");

if (isset($_GET["travelPage"])) {
    $travelPage = $_GET["travelPage"];
} else {
    $travelPage = 1;
}
$per_page = 5;
// $page=1;
$travelPage_start = ($travelPage - 1) * $per_page;
$sqlTravelAll = "SELECT trip_event.*,travel_account.account FROM trip_event JOIN travel_account ON trip_event.owner=travel_account.account WHERE travel_account.id='$id' AND  trip_event.valid=1 ORDER BY created_at DESC";
$resultTravelAll = $conn->query($sqlTravelAll);
$travelCount=$resultTravelAll->num_rows;

$sql = "SELECT * FROM travel_account WHERE id='$id' AND valid=1";
$result = $conn->query($sql);
$userCount = $result->num_rows;

$sqlTripComment = "SELECT trip_comment.*,trip_event.owner,trip_event.id,travel_account.account,travel_account.id AS travel_id,AVG(comment_stars)  FROM trip_comment JOIN trip_event ON trip_event.id=trip_comment.trip JOIN travel_account ON trip_event.owner=travel_account.account  WHERE trip_comment.valid=1 AND travel_account.id = '$id' GROUP BY trip_comment.id ORDER BY created_at";
$resultTripComment = $conn->query($sqlTripComment);
$tripCommentCount = $resultTripComment->num_rows;


$sqlTripforOne = "SELECT trip_event.*,travel_account.account FROM trip_event JOIN travel_account ON trip_event.owner=travel_account.account WHERE travel_account.id='$id' AND  trip_event.valid=1 ORDER BY created_at DESC LIMIT $travelPage_start, $per_page ";
$resultTripforOne = $conn->query($sqlTripforOne);
$totalTravelPage = ceil($travelCount /$per_page);

$sqlTripforService = "SELECT trip_service_list.*,trip_event.trip_name,trip_event.id AS event_id,travel_account.account,travel_account.id AS account_id FROM trip_service_list JOIN trip_event ON trip_service_list.trip=trip_event.trip_name JOIN travel_account ON trip_event.owner=travel_account.account WHERE travel_account.id='$id' AND  trip_event.valid=1  ORDER BY trip_event.created_at DESC ";
$resultTripforService = $conn->query($sqlTripforService);



$row = $result->fetch_assoc();
$rowsTripforOne = $resultTripforOne->fetch_All(MYSQLI_ASSOC);
$rowsTripComment=$resultTripComment->fetch_all(MYSQLI_ASSOC);
$rowsTripforService = $resultTripforService->fetch_All(MYSQLI_ASSOC);
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

        .details .recentOrders table tbody tr a {
            text-decoration: none;
        }

        .details .recentOrders table tbody tr:hover a {
            background: var(--blue);
            color: var(--white);

        }
        dialog{
            border:1px solid transparent;
            border-radius: 10px;
            background: #fefefe;
            box-shadow: 3px 3px 5px #3333;
            padding: 5% 8%;
            margin: 3% auto ;
        }
        .modal{
            height: 100%;
            width: 100%;
            background: rgb(0, 0, 0,0.5);
            display: none;
            position: fixed;
            top:0;
            left: 0;
            z-index: 999;


        }
        .openModal{
            display: block;
        }
        .object-cover{
            width: 100%;
            height: 100%;
            object-fit: cover;
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
                    <a href="#">
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

                <!-- <div class="search">
                    <label>
                        <input type="text" placeholder="solo can't search">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div> -->

                <div class="user">
                    <img src="assets/imgs/customer01.jpg" alt="">
                </div>
            </div>

            <!-- ======================= Cards ================== -->
            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers"><?= $travelCount ?></div>
                        <div class="cardName">已上架行程

                        </div>
                    </div>

                    <div class="iconBx">
                    <ion-icon name="bag-add-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">
                            <?php
                            $avgstars=0;
                            if($tripCommentCount>0){
                                foreach($rowsTripComment as $stars){
                                    $avgstars+=$stars["comment_stars"];
                                }
                                $avgstars=$avgstars/$tripCommentCount;
                            }
                            
                            echo $avgstars."★";
                            ?>
                        </div>
                        <div class="cardName">平均評價(評論)星數</div>
                    </div>

                    <div class="iconBx">
                    <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>
                </div>

                <!-- <div class="card">
                    <div>
                        <div class="numbers">284</div>
                        <div class="cardName">成交量</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">$7,842</div>
                        <div class="cardName">成交額</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cash-outline"></ion-icon>
                    </div>
                </div> -->
            </div>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Travel廠商資料</h2>
                        <a class="btn btn-info" href="admin-travel.php">查看所有Travel廠商</a>
                        <!-- <a href="#" class="btn">View All</a> -->
                    </div>
                    <!-- <div class="py-2">
                        <a class="btn btn-info" href="admin.php">User List</a>
                    </div> -->
                    <?php if ($userCount == 0) : ?>
                        使用者不存在
                    <?php else : ?>
                        <table class="table table-bordered ">
                            <tbody>
                                <!-- <tr>
                                    <td class="text-center p-0" colspan="2">
                                        <img class="object-cover" src="./assets/imgs/<?= $row["company_banner"] ?>" alt="<?= $row["company_banner"] ?>">
                                    </td>
                                </tr> -->
                                <tr>
                                    <td>會員帳號</td>
                                    <td><?= $row["account"] ?></td>
                                </tr>
                                <tr>
                                    <td>會員密碼</td>
                                    <td><?= $row["password"] ?></td>
                                </tr>
                                <tr>
                                    <td>公司信箱</td>
                                    <td><?= $row["email"] ?></td>
                                </tr>

                                <tr>
                                    <td>負責人姓名</td>
                                    <td><?= $row["name"] ?></td>
                                </tr>
                                <tr>
                                    <td>公司名稱</td>
                                    <td><?= $row["company_name"] ?></td>
                                </tr>
                                <tr>
                                    <td>開業日期</td>
                                    <td><?= $row["start_date"] ?></td>
                                </tr>
                                <tr>
                                    <td>地區</td>
                                    <td>
                                        <?php
                                        if ($row["area"] == 0) {
                                            echo "北";
                                        }
                                        if ($row["area"] == 1) {
                                            echo "中";
                                        }
                                        if ($row["area"] == 2) {
                                            echo "南";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>公司電話</td>
                                    <td><?= $row["company_phone"] ?></td>
                                </tr>
                                
                                <tr>
                                    <td>銀行帳戶</td>
                                    <td><?= $row["bank_account"] ?></td>
                                </tr>
                                <tr>
                                    <td>官網</td>
                                    <td><?= $row["website"] ?></td>
                                </tr>
                                <tr>
                                    <td>公司簡介</td>
                                    <td><?= $row["introduction"] ?></td>
                                </tr>
                                <tr>
                                    <td>Cretated At</td>
                                    <td><?= $row["created_at"] ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="py-2">
                            <a class="btn btn-info" href="admin-edit-travel-user.php?id=<?= $row["id"] ?>">編輯使用者</a>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- ================= New Customers ================ -->
                <!-- <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>上架行程列表</h2>
                    </div>

                    no trip

                </div> -->
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2><?=$row["company_name"]?>-上架行程列表</h2>
                    </div>
                    <?php if ($travelCount <= 0) :
                                    echo "目前無上架行程";
                    endif;?>
                    <?php if ($travelCount > 0) :?>
                        <table>
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
                                <?php foreach ($rowsTripforOne as $row) : ?>
                            <tbody>
                                
                                    <tr>
                                        <td><?= $row["owner"] ?></td>
                                        <td><?= $row["trip_name"] ?></td>
                                        <td><?= $row["price"] ?></td>
                                        <td><?= $row["start_date"] ?></td>
                                        <td>
                                            <!-- <a class="btn btn-info" href="admin-travel-user.php?id=<?= $row["account_id"] ?>">查看詳情</a> -->
                                            <button class="btn btn-danger trip_event_detil" id="trip_event_detil" >查看</button>
                                            <!-- <a class="btn btn-danger" href="admin-delete-travel-user.php?id=<?= $row["id"] ?>">刪除</a> -->
                                        </td>
                                    </tr>
                                
                            </tbody>
                            
                                    <?php endforeach; ?>
                            <?php endif; ?>
                        </table>
                        <?php if ($travelCount > 0) : ?>
                                <?php foreach ($rowsTripforOne as $row) : ?>
                                    <div class="modal" id="modal">
                                        <dialog class="dialog  justify-content-center text-center" id="dialog">
                                            <h2><?=$row["trip_name"]?></h2> 
                                            <table class="table table-bordered">
                                          
                                            <!-- <tr>
                                                <td class="text-center p-0" colspan="4">
                                                    <img class="object-cover" src="./assets/imgs/<?=$row["picture"]?>" alt="<?=$row["picture"]?>">
                                                </td>
                                            </tr> -->
                                            <tr>
                                                <td>金額</td>
                                                <td colspan="3">$<?=$row["price"]?></td>
                                            </tr>
                                            <tr>
                                                <td>開團日</td>
                                                <td><?=$row["start_date"]?></td>
                                                <td>截團日</td>
                                                <td><?=$row["end_date"]?></td>
                                            </tr>
                                            <tr>
                                                <td>服務tag</td>
                                                <td colspan="3">
                                                    <?php
                                                    $trip_name=$row["trip_name"];
                                                    $sqlTripforService = "SELECT trip_service_list.*,trip_event.trip_name,trip_event.id AS event_id,travel_account.account,travel_account.id AS account_id FROM trip_service_list JOIN trip_event ON trip_service_list.trip=trip_event.trip_name JOIN travel_account ON trip_event.owner=travel_account.account WHERE travel_account.id='$id' AND  trip_event.valid=1 AND trip_service_list.trip='$trip_name' ORDER BY trip_event.created_at DESC ";
                                                    $resultTripforService = $conn->query($sqlTripforService);
                                                    $rowsTripforService = $resultTripforService->fetch_All(MYSQLI_ASSOC);
                                                    ?>
                                                    <?php foreach($rowsTripforService as $service):?>
                                                        <?php
                                                            if($service["mountain"]==1){
                                                                echo "<span class='badge rounded-pill text-bg-secondary'>登山活動</span>";
                                                            }
                                                            if($service["in_water"]==1){
                                                                echo "<span class='badge rounded-pill text-bg-secondary'>水上活動</span>";
                                                            }
                                                            if($service["snow"]==1){
                                                                echo "<span class='badge rounded-pill text-bg-secondary'>雪上活動</span>";
                                                            }
                                                            if($service["culture_history"]==1){
                                                                echo "<span class='badge rounded-pill text-bg-secondary'>文化歷史</span>";
                                                            }
                                                            if($service["workshop"]==1){
                                                                echo "<span class='badge rounded-pill text-bg-secondary'>工作坊</span>";
                                                            }
                                                            if($service["amusement"]==1){
                                                                echo "<span class='badge rounded-pill text-bg-secondary'>遊樂園</span>";
                                                            }
                                                            if($service["meal"]==1){
                                                                echo "<span class='badge rounded-pill text-bg-secondary'>包餐</span>";
                                                            }
                                                            if($service["no_shopping"]==1){
                                                                echo "<span class='badge rounded-pill text-bg-secondary'>購物行程</span>";
                                                            }
                                                            if($service["family_friendly"]==1){
                                                                echo "<span class='badge rounded-pill text-bg-secondary'>家庭活動</span>";
                                                            }
                                                            if($service["pet"]==1){
                                                                echo "<span class='badge rounded-pill text-bg-secondary'>寵物</span>";
                                                            }
                                                            if($service["indoor_outdoor"]==0){
                                                                echo "<span class='badge rounded-pill text-bg-secondary'>室內</span>";
                                                            }else if($service["indoor_outdoor"]==1){
                                                                echo "<span class='badge rounded-pill text-bg-secondary'>室外</span>";
                                                            }else if($service["indoor_outdoor"]==2){
                                                                echo "<span class='badge rounded-pill text-bg-secondary'>室內外皆有</span>";
                                                            }else{

                                                            }
                                                            ?>
                                                    <?php endforeach;?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>行程介紹</td>
                                                <td colspan="3"><?=$row["description"]?></td>
                                            </tr>
                                            </table>
                                            <div class="text-center">
                                            <button class="btn close btn-danger" id="close">關閉</button>
                                            </div>
                                        </dialog> 
                                    </div>
                                    <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <?php if (!isset($_GET["search"])) : ?>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php for ($i = 1; $i <= $totalTravelPage; $i++) : ?>
                                        <li class="page-item <?php if ($i == $travelPage) echo "active"; ?>"><a class="page-link" href="admin-travel-user.php?id=<?=$id?>&travelPage=<?= $i ?>"><?= $i ?></a></li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>
    <script>
        let trip_event_detil=document.querySelectorAll(".trip_event_detil");
        let dialog=document.querySelectorAll(".dialog");
        let close=document.querySelectorAll(".close")
        let modal=document.querySelectorAll(".modal")
        for(let i=0;i<trip_event_detil.length;i++){

            trip_event_detil[i].addEventListener("click",function(){
                
                // console.log("Hi");
                    modal[i].style.display="block"
                    dialog[i].className="dialog openModal"            
            }) 
            close[i].addEventListener("click",function(){

                dialog[i].className="dialog "
                modal[i].style.display="none"
            })
        }
        
       
       
        
    </script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>