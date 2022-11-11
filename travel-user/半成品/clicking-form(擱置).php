<?php

require_once("./db-connect.php");
require_once('var_dump_pre.php');



$sqlJoin = "SELECT TE.*,TSL.* FROM trip_event AS TE JOIN trip_service_list AS TSL ON TE.trip_name = TSL.trip AND TE.valid = 1";
$resultJoin = $conn -> query($sqlJoin);

// $rowsJoin = $resultJoin->fetch_all(MYSQLI_ASSOC);
$rowsJoin = $resultJoin->fetch_all(MYSQLI_ASSOC);
// $rowsNum = $resultJoin ->fetch_all(MYSQLI_NUM);
// var_dump_pre($rowsNum);
// mysql_data_seek($sql,0);
// var_dump_pre($rowsJoin);


// var_dump_pre($rowsJoin); 
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
    <link rel="stylesheet" href="assets/css/clicking-form.css">
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
                    <a href="create-trip.php">
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
            <!-- ================ DETAILS ================= -->
            <div class="details">
            <?php foreach ($rowsJoin as $product) : ?>
            <?php $location = explode(',',($product['location']));?>
                <?php $pictureArr = explode(',',$product['picture']); ?>
                        <div class="products-items my-2">
                            <div class="titlecard">
                                <div class="products-control">
                                    <h4><?= $product["trip_name"] ?></h4>
                                </div>
                                <img class="titlecard-banner" src="./assets/imgs/<?=$pictureArr[0]?>" alt="">
                            </div>
                            <div class="products-summary">
                                <div class="product-data">
                                    <div class="price-date">
                                        <p class="price">價格：<?=$product['price']?></p>
                                        <p class="start-date">開始販賣日期：<?=$product['start_date']?></p>
                                        <p class="end-date">結束販賣日期：<?=$product['end_date']?></p>
                                    </div>
                                    <div class="guide-location">
                                        <p class="guide">有無導遊：<?php if($product['guide']==1){echo '有';}else{echo '無';}?></p>
                                        <p class="location">地點：<?php 
                                            for($i=0;$i<count($location);$i++){
                                                switch ($location[$i]){
                                                case 'northern':
                                                echo '北部';
                                                break;
                                                case 'central' :
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
                                            }}?>
                                        </p>
                                        <p>平均評價：5</p>
                                    </div>
                                    <div class="des">
                                        <p class="description">行程介紹：<?=$product['description']?></p>
                                    </div>
                                    <div class="imgs">
                                        <p class="picture">目前上傳圖片：</p>
                                        <?php for($i=0;$i<count($pictureArr);$i++): ?>
                                        <img src="./assets//imgs/<?=$pictureArr[$i]?>" alt="">
                                        <?php endfor; ?>
                                    </div>
                                    <div class="tags">
                                        <?php $indoor_outdoor = explode(',',$product['indoor_outdoor'])?>
                                        <?php $customTag = explode('/',$product['custom_tag'])?>
                                        <?php foreach($product as $testKey => $testValue):?>
                                            <?php if($testValue==1 && $testKey == "in_mountain"){
                                                echo "<div class='tags'>登山踏青</div>";
                                                }elseif($testValue==1 && $testKey == "in_water"){
                                                echo "<div class='tags'>水上活動</div>";}
                                                elseif($testValue==1 && $testKey == "snow"){
                                                echo "<div class='tags'>雪上活動</div>";}
                                                elseif($testValue==1 && $testKey == "natural_attraction"){
                                                echo "<div class='tags'>大自然</div>";}
                                                elseif($testValue==1 && $testKey == "culture_history"){
                                                echo "<div class='tags'>歷史人文</div>";}
                                                elseif($testValue==1 && $testKey == "workshop"){
                                                echo "<div class='tags'>工作坊，課程體驗</div>";}
                                                elseif($testValue==1 && $testKey == "amusement"){
                                                echo "<div class='tags'>遊樂園，特殊節慶</div>";}
                                                elseif($testValue==1 && $testKey == "meal"){
                                                echo "<div class='tags'>供餐</div>";}
                                                elseif($testValue==1 && $testKey == "no_shopping"){
                                                echo "<div class='tags'>無購物行程</div>";}
                                                elseif($testValue==1 && $testKey == "family-friendly"){
                                                echo "<div class='tags'>適合全家出遊</div>";}
                                                elseif($testValue==1 && $testKey == "pet"){
                                                echo "<div class='tags'>寵物ok</div>";} ?>
                                                <!--處理不同的indoor_outdoor-->
                                                <?php if(in_array('0',$indoor_outdoor) && $testKey=="indoor_outdoor"){echo "<div class='tags'>室內活動為主</div>";}?>
                                                <?php if(in_array('1',$indoor_outdoor) && $testKey=="indoor_outdoor"){echo "<div class='tags'>室外活動為主</div>";}?>
                                                <?php if(in_array('2',$indoor_outdoor) && $testKey=="indoor_outdoor"){echo "<div class='tags'>室內室外活動比例平均</div>";}?>
                                                <?php if($testKey=="custom_tag" && isset($customTag)){
                                                    for($i=0;$i<count($customTag);$i++) {
                                                        echo "<div class='tags'>".$customTag[$i]."</div>";
                                                    }
                                                }?>       
                                                <?php endforeach; ?>
                                    </div>    
                                </div>
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
                                    <button class="Ubtn">修改</button>
                                    <button class="Dbtn">下架</button>
                                </div>
                            </div>
                            <!-- <a class="btn btn-danger" href="javascript:void(0)">刪除</a> -->
                        </div>
                    <?php endforeach; ?>

            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->



<script src="assets/js/clicking-form.js"></script>
<script src="assets/js/main2.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>