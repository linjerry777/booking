<?php
require_once('var_dump_pre.php');
require_once("../../db-connect2.php");

session_start();
// var_dump_pre($_SESSION);
if (!isset($_SESSION["account"])) {
    echo "請循正常管道進入本頁";
    exit;
}


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

// var_dump_pre($account);
$sqlJoin = "SELECT TE.*,TSL.* FROM trip_event AS TE JOIN trip_service_list AS TSL ON TE.trip_name = TSL.trip AND TE.valid = 1 AND TE.owner='$account' AND TE.id = TSL.id";
$resultJoin = $conn->query($sqlJoin);
$rowsJoin = $resultJoin->fetch_all(MYSQLI_ASSOC);
$productCount = count($rowsJoin); //有幾個上架商品


// var_dump_pre($rowsJoin);
// var_dump_pre($productCount);
// echo "<hr style='color:red'>";

$sqlJoinOld = "SELECT TE.*,TSL.* FROM trip_event AS TE JOIN trip_service_list AS TSL ON TE.trip_name = TSL.trip AND TE.valid = 0 AND TE.owner='$account' AND TE.id = TSL.id";
$resultJoinOld = $conn->query($sqlJoinOld);
$rowsJoinOld = $resultJoinOld->fetch_all(MYSQLI_ASSOC);

// var_dump_pre($rowsJoinOld[0]);
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
    <link rel="stylesheet" href="assets/css/trip-list.css">
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
                    <a href="trip-create.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">上架</span>
                    </a>
                </li>

                <li>
                    <a href="#">
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

                <div class="user">
                    <img src="assets/imgs/customer01.jpg" alt="">
                </div>
            </div>
            <!-- ================ DETAILS ================= -->
            <div class="details">
                <div class="current-trips">
                    <h2>上架中行程</h2>
                    <?php foreach ($rowsJoin as $product) : ?>
                        <!--把資料庫中的字串 用explode化為陣列-->
                        <?php if(!empty($product['picture'])){ $pictureArr = explode(',', $product['picture']);}
                        else{ $pictureArr =[];} ?>
                        <?php $location = explode(',', ($product['location'])); ?>
                        <div class="products-items my-2">
                            <div class="titlecard">
                                <div class="products-control">
                                    <h4><?= $product["trip_name"] ?></h4>
                                </div>
                                <img class="titlecard-banner" src="./assets/imgs/<?= $account ?>/<?= $pictureArr[0] ?>" alt="">
                            </div>
                            <div class="products-summary">
                                <table class="product-data table table-bordered">
                                    <tr class="price-date">
                                        <td>價格：</td>
                                        <td colspan="2"><?= $product['price'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>開始販賣日期：</td>
                                        <td><?= $product['start_date'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>結束販賣日期：</td>
                                        <td><?= $product['end_date'] ?></td>
                                    </tr>
                                    <tr class="guide">
                                        <td>有無導遊：</td>
                                        <td>
                                            <?php if ($product['guide'] == 1) {
                                                echo '有';
                                            } else {
                                                echo '無';
                                            } ?>
                                        </td>
                                    </tr>
                                    <tr class="location">
                                        <td>地點：</td>
                                        <td>
                                            <?php
                                            for ($i = 0; $i < count($location); $i++) {
                                                switch ($location[$i]) {
                                                    case 'northern':
                                                        echo '北部';
                                                        break;
                                                    case 'central':
                                                        echo '中部';
                                                        break;
                                                    case 'southern':
                                                        echo '南部';
                                                        break;
                                                    case 'eastern':
                                                        echo '東部';
                                                        break;
                                                    case  'oversea';
                                                        echo '海外';
                                                }
                                            } ?>
                                        </td>
                                    </tr>
                                    <tr class="des">
                                        <td>行程介紹：</td>
                                        <td><?= $product['description'] ?></td>
                                    </tr>
                                    <tr class="star">
                                        <td>平均評價：</td>
                                        <td>5</td>
                                    </tr>
                                    <tr class="imgs">
                                        <td>目前上傳圖片：<br><span>※可點擊後刪除</span></td>
                                        <td>
                                            <?php 
                                            if(!empty($product['picture'])) {$pictureArrClean = array_filter($pictureArr);}
                                            else{$pictureArrClean = [] ; }
                                            // var_dump_pre($pictureArrClean);
                                            // var_dump_pre(count($pictureArrClean));
                                            ?>
                                            <?php for ($i = 0; $i < count($pictureArrClean); $i++) : ?>
                                                <a href="do-image-delete.php?image=<?= $pictureArrClean[$i] ?>&TSL_id=<?= $product['id'] ?>&name=<?=$product["trip_name"]?>&pictureIndex=<?=$i?>">
                                                    <img src="./assets/imgs/<?= $account ?>/<?= $pictureArrClean[$i] ?>" alt="<?= $pictureArrClean[$i] ?>" title="<?= $pictureArr[$i] ?>">
                                                </a>
                                            <?php endfor; ?>
                                        </td>
                                    </tr>
                                    <tr class="tags">
                                        <td>
                                            標籤一覽：
                                        </td>
                                        <td>
                                            <?php $indoor_outdoor = explode(',', $product['indoor_outdoor']) ?>
                                            <?php $customTag = explode('/', $product['custom_tag']) ?>
                                            <?php foreach ($product as $testKey => $testValue) : ?>
                                                <?php if ($testValue == 1 && $testKey == "in_mountain") {
                                                    echo "<div class='tags'>登山踏青</div>";
                                                } elseif ($testValue == 1 && $testKey == "in_water") {
                                                    echo "<div class='tags'>水上活動</div>";
                                                } elseif ($testValue == 1 && $testKey == "snow") {
                                                    echo "<div class='tags'>雪上活動</div>";
                                                } elseif ($testValue == 1 && $testKey == "natural_attraction") {
                                                    echo "<div class='tags'>大自然</div>";
                                                } elseif ($testValue == 1 && $testKey == "culture_history") {
                                                    echo "<div class='tags'>歷史人文</div>";
                                                } elseif ($testValue == 1 && $testKey == "workshop") {
                                                    echo "<div class='tags'>工作坊，課程體驗</div>";
                                                } elseif ($testValue == 1 && $testKey == "amusement") {
                                                    echo "<div class='tags'>遊樂園，特殊節慶</div>";
                                                } elseif ($testValue == 1 && $testKey == "meal") {
                                                    echo "<div class='tags'>供餐</div>";
                                                } elseif ($testValue == 1 && $testKey == "no_shopping") {
                                                    echo "<div class='tags'>無購物行程</div>";
                                                } elseif ($testValue == 1 && $testKey == "family-friendly") {
                                                    echo "<div class='tags'>適合全家出遊</div>";
                                                } elseif ($testValue == 1 && $testKey == "pet") {
                                                    echo "<div class='tags'>寵物ok</div>";
                                                } ?>
                                                <?php if (in_array('0', $indoor_outdoor) && $testKey == "indoor_outdoor") {
                                                    echo "<div class='tags'>室內活動為主</div>";
                                                } ?>
                                                <?php if (in_array('1', $indoor_outdoor) && $testKey == "indoor_outdoor") {
                                                    echo "<div class='tags'>室外活動為主</div>";
                                                } ?>
                                                <?php if (in_array('2', $indoor_outdoor) && $testKey == "indoor_outdoor") {
                                                    echo "<div class='tags'>室內室外活動比例平均</div>";
                                                } ?>
                                                <?php if ($testKey == "custom_tag" && isset($customTag)) {
                                                    for ($i = 0; $i < count($customTag); $i++) {
                                                        echo "<div class='tags'>" . $customTag[$i] . "</div>";
                                                    }
                                                } ?>
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>
                                </table>
                                <div class="users-data">
                                    <div class="users-items">
                                        <div class="users-titlecard">
                                            <div class="users-control">
                                                <h4>顧客名字</h4>
                                            </div>
                                            <img src="" alt="顧客照片">
                                        </div>
                                        <div class="users-comment">
                                            <h5 class="comment">評語：很好玩</h5>
                                            <h5 class="comment-star">評價：5</h5>
                                        </div>

                                        <div class="user-card-banner"></div>
                                    </div>
                                </div>
                                <div class="crudBtns">
                                    <a role="button" class="btn text-bg-primary Ubtn" href="trip-update.php?product=<?= $product["trip_name"] ?>">修改</a>
                                    <a role="button" class="btn text-bg-danger Dbtn" href="do-delete.php?product=<?= $product["trip_name"] ?>">下架</a>
                                </div>
                            </div>
                            <!-- <a class="btn btn-danger" href="javascript:void(0)">刪除</a> -->
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="old-trips">
                    <h2>已下架行程</h2>
                    <?php foreach ($rowsJoinOld as $productOld) : ?>
                        <?php $pictureArr = explode(',', $productOld['picture']); ?>
                        <?php $location = explode(',', ($productOld['location'])); ?>
                        <div class="products-items my-2">
                            <div class="titlecard">
                                <div class="products-control">
                                    <h4><?= $productOld["trip_name"] ?></h4>
                                </div>
                                <img class="titlecard-banner" src="./assets/imgs/<?= $account ?>/<?= $pictureArr[0] ?>" alt="">
                            </div>
                            <div class="products-summary">
                                <table class="product-data table table-bordered">
                                    <tr class="price-date">
                                        <td>價格：</td>
                                        <td colspan="2"><?= $productOld['price'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>開始販賣日期：</td>
                                        <td><?= $productOld['start_date'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>結束販賣日期：</td>
                                        <td><?= $productOld['end_date'] ?></td>
                                    </tr>
                                    <tr class="guide">
                                        <td>有無導遊：</td>
                                        <td>
                                            <?php if ($productOld['guide'] == 1) {
                                                echo '有';
                                            } else {
                                                echo '無';
                                            } ?>
                                        </td>
                                    </tr>
                                    <tr class="location">
                                        <td>地點：</td>
                                        <td>
                                            <?php
                                            for ($i = 0; $i < count($location); $i++) {
                                                switch ($location[$i]) {
                                                    case 'northern':
                                                        echo '北部';
                                                        break;
                                                    case 'central':
                                                        echo '中部';
                                                        break;
                                                    case 'southern':
                                                        echo '南部';
                                                        break;
                                                    case 'eastern':
                                                        echo '東部';
                                                        break;
                                                    case  'oversea';
                                                        echo '海外';
                                                }
                                            } ?>
                                        </td>
                                    </tr>
                                    <tr class="des">
                                        <td>行程介紹：</td>
                                        <td><?= $productOld['description'] ?></td>
                                    </tr>
                                    <tr class="star">
                                        <td>平均評價：</td>
                                        <td>5</td>
                                    </tr>
                                    <tr class="imgs">
                                        <td>目前上傳圖片：</td>
                                        <td>
                                            <?php $pictureArrClean = array_filter($pictureArr); ?>
                                            <?php for ($i = 0; $i < count($pictureArrClean); $i++) : ?>
                                                <img src="./assets/imgs/<?= $account ?>/<?= $pictureArrClean[$i] ?>" alt="<?= $pictureArrClean[$i] ?>" title="<?= $pictureArr[$i] ?>">
                                            <?php endfor; ?>
                                        </td>
                                    </tr>
                                    <tr class="tags">
                                        <td>
                                            標籤一覽：
                                        </td>
                                        <td>
                                            <?php $indoor_outdoor = explode(',', $productOld['indoor_outdoor']) ?>
                                            <?php $customTag = explode('/', $productOld['custom_tag']) ?>
                                            <?php foreach ($productOld as $testKey => $testValue) : ?>
                                                <?php if ($testValue == 1 && $testKey == "in_mountain") {
                                                    echo "<div class='tags'>登山踏青</div>";
                                                } elseif ($testValue == 1 && $testKey == "in_water") {
                                                    echo "<div class='tags'>水上活動</div>";
                                                } elseif ($testValue == 1 && $testKey == "snow") {
                                                    echo "<div class='tags'>雪上活動</div>";
                                                } elseif ($testValue == 1 && $testKey == "natural_attraction") {
                                                    echo "<div class='tags'>大自然</div>";
                                                } elseif ($testValue == 1 && $testKey == "culture_history") {
                                                    echo "<div class='tags'>歷史人文</div>";
                                                } elseif ($testValue == 1 && $testKey == "workshop") {
                                                    echo "<div class='tags'>工作坊，課程體驗</div>";
                                                } elseif ($testValue == 1 && $testKey == "amusement") {
                                                    echo "<div class='tags'>遊樂園，特殊節慶</div>";
                                                } elseif ($testValue == 1 && $testKey == "meal") {
                                                    echo "<div class='tags'>供餐</div>";
                                                } elseif ($testValue == 1 && $testKey == "no_shopping") {
                                                    echo "<div class='tags'>無購物行程</div>";
                                                } elseif ($testValue == 1 && $testKey == "family-friendly") {
                                                    echo "<div class='tags'>適合全家出遊</div>";
                                                } elseif ($testValue == 1 && $testKey == "pet") {
                                                    echo "<div class='tags'>寵物ok</div>";
                                                } ?>
                                                <?php if (in_array('0', $indoor_outdoor) && $testKey == "indoor_outdoor") {
                                                    echo "<div class='tags'>室內活動為主</div>";
                                                } ?>
                                                <?php if (in_array('1', $indoor_outdoor) && $testKey == "indoor_outdoor") {
                                                    echo "<div class='tags'>室外活動為主</div>";
                                                } ?>
                                                <?php if (in_array('2', $indoor_outdoor) && $testKey == "indoor_outdoor") {
                                                    echo "<div class='tags'>室內室外活動比例平均</div>";
                                                } ?>
                                                <?php if ($testKey == "custom_tag" && isset($customTag)) {
                                                    for ($i = 0; $i < count($customTag); $i++) {
                                                        echo "<div class='tags'>" . $customTag[$i] . "</div>";
                                                    }
                                                } ?>
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>
                                </table>
                                <div class="users-data">
                                    <div class="users-items">
                                        <div class="users-titlecard">
                                            <div class="users-control">
                                                <h4>顧客名字</h4>
                                            </div>
                                            <img src="" alt="顧客照片">
                                        </div>
                                        <div class="users-comment">
                                            <h5 class="comment">評語：很好玩</h5>
                                            <h5 class="comment-star">評價：5</h5>
                                        </div>

                                        <div class="user-card-banner"></div>
                                    </div>
                                </div>
                                <div class="crudBtns">
                                    <a role="button" class="btn text-bg-danger Dbtn" href="do-delete-two.php?product=<?= $productOld["trip_name"] ?>">刪除</a>
                                </div>
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