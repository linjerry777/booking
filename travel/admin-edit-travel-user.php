<?php

if (!isset($_GET["id"])) {
    echo "使用者不存在";
    exit;
}

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

$sqlTripforOne = "SELECT trip_event.*,travel_account.account FROM trip_event JOIN travel_account ON trip_event.owner=travel_account.account WHERE travel_account.id='$id' AND  trip_event.valid=1 ORDER BY created_at DESC LIMIT $travelPage_start, $per_page ";
$resultTripforOne = $conn->query($sqlTripforOne);
$totalTravelPage = ceil($travelCount /$per_page);

$sqlTripComment = "SELECT trip_comment.*,trip_event.owner,trip_event.id,travel_account.account,travel_account.id AS travel_id,AVG(comment_stars)  FROM trip_comment JOIN trip_event ON trip_event.id=trip_comment.trip JOIN travel_account ON trip_event.owner=travel_account.account  WHERE trip_comment.valid=1 AND travel_account.id = '$id' GROUP BY trip_comment.id ORDER BY created_at";
$resultTripComment = $conn->query($sqlTripComment);
$tripCommentCount = $resultTripComment->num_rows;


$row = $result->fetch_assoc();
$rowsTripforOne = $resultTripforOne->fetch_All(MYSQLI_ASSOC);
$rowsTripComment=$resultTripComment->fetch_all(MYSQLI_ASSOC);
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

        dialog{
            border:1px solid transparent;
            border-radius: 10px;
            background: #fefefe;
            box-shadow: 3px 3px 5px #3333;
            padding: 5% 10%;
            margin: 10% auto ;
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

                <div class="search">
                    <form action="admin-travel.php" method="get">
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
                        <div class="cardName">Travel廠商成交額排行

                        </div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="eye-outline"></ion-icon>
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

                <div class="card">
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
                </div>
            </div>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Travel廠商清單</h2>
                        <!-- <a href="#" class="btn">View All</a> -->
                        <?php if (isset($_GET["search"])) : ?>
                            <div class="py-2">
                                <a class="btn btn-info" href="admin-travel.php">回全部使用者列表</a>
                            </div>
                            <h1><?= $_GET["search"] ?> 的搜尋結果</h1>
                        <?php endif; ?>

                        <div class="py-2 d-flex justify-content-end">
                            <a class="btn btn-info" href="admin-add-travel-user.php">新增Travel廠商</a>
                        </div>
                    </div>
                    <?php if ($userCount == 0) : ?>
                        使用者不存在
                    <?php else : ?>
                        <div class="py-2">
                            <a class="btn btn-info" href="admin-travel-user.php?id=<?= $row["id"] ?>">回使用者</a>
                        </div>
                        <form action="admin-doUpdate-travel-user.php" method="post" enctype="multipart/form-data">
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
                                        <input type="hidden" name="account" value="<?= $row["account"] ?>">
                                        <td>會員帳號</td>
                                        <td>
                                            <?= $row["account"] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <input type="hidden" name="password" value="<?= $row["password"] ?>">
                                        <td>會員密碼</td>
                                        <td>
                                            <?= $row["password"] ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <img src="./assets/imgs/<?= $row["company_banner"] ?>" alt="<?= $row["company_banner"] ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>上傳圖片</td>
                                        <td>
                                            <input type="file" class="form-control" name="company_banner">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>負責人姓名</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["name"] ?>" name="name">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>公司名稱</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["company_name"] ?>" name="company_name">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>開業日期</td>
                                        <td>
                                            <input type="date" class="form-control" value="<?= $row["start_date"] ?>" name="start_date">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>地區</td>
                                        <td>
                                            <select name="area" id="area" class="form-select">

                                                <option value="0" <?php if ($row["area"] == 0) : echo "selected";
                                                                    endif; ?>>北</option>
                                                <option value="1" <?php if ($row["area"] == 1) : echo "selected";
                                                                    endif; ?>>中</option>
                                                <option value="2" <?php if ($row["area"] == 2) : echo "selected";
                                                                    endif; ?>>南</option>

                                            </select>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>公司電話</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["company_phone"] ?>" name="company_phone">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>公司信箱</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["email"] ?>" name="email">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>銀行帳戶</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["bank_account"] ?>" name="bank_account">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>官網</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["website"] ?>" name="website">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>公司簡介</td>
                                        <td>
                                            <input type="text" class="form-control" value="<?= $row["introduction"] ?>" name="introduction">
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
                        <h2><?=$row["company_name"]?>-上架行程列表</h2>
                    </div>
                    <?php if ($travelCount <= 0) :
                                    echo "目前無上架行程";
                    endif;?>
                    <?php if ($travelCount > 0) :?>
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
                                <?php foreach ($rowsTripforOne as $row) : ?>
                            <tbody>
                                
                                    <tr>

                                        <td><?= $row["id"] ?></td>
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
                                        <dialog class="dialog" id="dialog">
                                        <h2><?=$row["trip_name"]?></h2> 
                                        <table class="table table-bordered">
                                           <tr>
                                            <td>id</td>
                                            <td><?=$row["id"]?></td>
                                           </tr>
                                           <tr>
                                            <td>行程圖片</td>
                                            <td><?=$row["picture"]?></td>
                                           </tr>
                                           <tr>
                                            <td>行程名稱</td>
                                            <td><?=$row["trip_name"]?></td>
                                           </tr>
                                           <tr>
                                            <td>最大參團人數</td>
                                            <td><?=$row["amount"]?></td>
                                           </tr>
                                           <tr>
                                            <td>金額</td>
                                            <td><?=$row["price"]?></td>
                                           </tr>
                                           <tr>
                                            <td>注意事項</td>
                                            <td><?=$row["description"]?></td>
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
                                        <li class="page-item <?php if ($i == $travelPage) echo "active"; ?>"><a class="page-link" href="admin-edit-travel-user.php?id=<?=$id?>&travelPage=<?= $i ?>"><?= $i ?></a></li>
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
                    console.log("click")
                    modal[i].style.display="block"
                    dialog[i].className="dialog openModal"            
            }) 
            close[i].addEventListener("click",function(){
                console.log("click")
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