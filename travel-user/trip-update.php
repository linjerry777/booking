<?php
require_once('var_dump_pre.php');
require_once("../../db-connect2.php");
session_start();


$productName = $_GET['product'];
if (!isset($_SESSION["account"])) {
    echo "請循正常管道進入本頁(account)";
    exit;
}

if (!isset($_GET['product'])) {
    echo "請依照正常管道進入(product)";
};

$sqlJoin = "SELECT TE.*,TSL.* FROM trip_event AS TE JOIN trip_service_list AS TSL ON TE.trip_name = TSL.trip AND TSL.trip = '$productName'";
$resultJoin = $conn->query($sqlJoin);
$rowsJoin = $resultJoin->fetch_assoc();



// var_dump_pre($productName);
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
    <link rel="stylesheet" href="assets/css/trip-create.css">
    <style>
        .main.active {
            width: calc(100% - 110px);
            left: 110px;
        }

        .navigation.active {
            width: 110px;
        }

        img {
            width: 200px;
            height: 200px;
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

                <div class="user">
                    <img src="assets/imgs/customer01.jpg" alt="">
                </div>
            </div>
            <!-- ================ DETAILS ================= -->
            <div class="details">
                <div class="trip-event-form">
                    <form action="do-update.php" method="post" enctype="multipart/form-data">
                        <fieldset class="name-price">
                            <!--Join 時 ON在 trip_event上頭的 trip_service_list 的 id 覆蓋了 TE的id-->
                            <input type="hidden" name="id_trip_service_list" value="<?= $rowsJoin['id'] ?>">
                            <!--TE的trip_name 和 TSL 的 trip 應該要是一樣的-->
                            <input type="hidden" name="unique_trip_name" value="<?= $rowsJoin['trip_name'] ?>">
                            <legend class="h2">基本資料<span>*</span><small class="h6">星號(*)代表資料必填</small></legend>
                            <label class="form-label" for="trip_name">行程名稱</label><small class="h6">※無法更改</small></label>
                            <input readonly="readonly" class="form-control" name="trip_name" id="trip_name" value="<?= $rowsJoin['trip_name'] ?>" required>
                            <div>
                                <label class="form-label" for="price">價格</label>
                                <input class="form-control" type="text" name="price" id="price" value="<?= $rowsJoin['price'] ?>" required>
                            </div>
                        </fieldset>
                        <fieldset class="sell-date">
                            <legend>開放購買日期<span>*</span></legend>
                            <label class="form-label" for="start_date">開放日期</label>
                            <input class="form-control" type="date" name="start_date" id="start_date" value="<?= $rowsJoin['start_date'] ?>" required>

                            <label class="form-label" for="end_date">截止日期</label>
                            <input class="form-control" type="date" name="end_date" id="end_date" value="<?= $rowsJoin['end_date'] ?>" required>
                        </fieldset>

                        <!--radio name屬性值得相同-->
                        <fieldset class="guide">
                            <legend>自助旅遊/團體旅遊<span>*</span></legend>
                            <input class="form-check-input" type="radio" name="guide" id="guideless" value="0" <?php echo ($rowsJoin['guide'] == 0 ? 'checked' : ""); ?> required>
                            <label class="form-check-label" for="guideless">自助</label>
                            <input class="form-check-input" type="radio" name="guide" id="guide" <?php echo ($rowsJoin['guide'] == 1 ? 'checked' : ""); ?> value="1">
                            <label class="form-check-label" for="guide">導遊帶隊</label>
                        </fieldset>
                        <fieldset class="location">
                            <legend>行程地點<span>*</span></legend>
                            <label class="form-check-label" for="northern">北部</label>
                            <?php $location_str = $rowsJoin['location'] //strpos 會回傳index值 反之false
                            ?>
                            <input class="form-check-input groupLocation" type="checkbox" id="northern" name="location[]" value="northern" <?php echo ((strpos("$location_str", "northern") === false) ? " " : "checked"); ?>>
                            <label class="form-check-label" for="central">中部</label>
                            <input class="form-check-input groupLocation" type="checkbox" id="central" name="location[]" value="central" <?php echo ((strpos("$location_str", "central") === false) ? " " : "checked"); ?>>
                            <label class="form-check-label" for="southern">南部</label>
                            <input class="form-check-input groupLocation" type="checkbox" id="southern" name="location[]" value="southern" <?php echo ((strpos("$location_str", "southern") === false) ? " " : "checked"); ?>>
                            <label class="form-check-label" for="eastern">東部</label>
                            <input class="form-check-input groupLocation" type="checkbox" id="eastern" name="location[]" value="eastern" <?php echo ((strpos("$location_str", "eastern") === false) ? " " : "checked"); ?>>
                            <label class="form-check-label" for="oversea">海外</label>
                            <input class="form-check-input groupLocation" type="checkbox" id="oversea" name="location[]" value="oversea" <?php echo ((strpos("$location_str", "oversea") === false) ? " " : "checked"); ?>>
                        </fieldset>

                        <fieldset class="picture">
                            <legend>宣傳照上傳<span>*</span><small class="h6">請注意檔名不能重複</small></legend>
                            <input class="form-control" type="file" name="picture[]" id="picture" accept=".jpg,.jpeg,.png,.apng,.gif,.webp" multiple>
                        </fieldset>

                        <fieldset class="description">
                            <legend>行程介紹文案<span>*</span></legend>
                            <label class="form-label" for="description">文案內容</label>
                            <textarea class="form-control" name="description" id="description" required><?php echo $rowsJoin['description']; ?></textarea>
                        </fieldset>
                        <!---->
                        <input class="form-control" type="valid" name="valid" id="valid" value="1" style="display:none;">
                </div>
                <!--行程特色表單-->
                <div class="trip-service-list-form">
                    <!--說明-->
                    <h2>行程特色設定<small class="h6">※設定屬性以供使用者篩選；至少選填一項</small></h2>
                    <fieldset class="major-tag">
                        <legend>熱門屬性</legend>
                        <div class="checkboxes">
                            <label class="form-check-label" for="mountain">登山踏青</label>
                            <input class="form-check-input groupTag" type="checkbox" name="mountain" id="mountain" value="1" <?php echo ($rowsJoin['mountain'] == 1 ? 'checked' : ""); ?> value="1">
                            <label class="form-check-label" for="in_water">水上活動</label>
                            <input class="form-check-input groupTag" type="checkbox" name="in_water" id="in_water" value="1" <?php echo ($rowsJoin['in_water'] == 1 ? 'checked' : ""); ?> value="1">
                            <label class="form-check-label" for="snow">雪上活動</label>
                            <input class="form-check-input groupTag" type="checkbox" name="snow" id="snow" value="1" <?php echo ($rowsJoin['snow'] == 1 ? 'checked' : ""); ?> value="1">
                        </div>
                    </fieldset>
                    <fieldset class="normal-tag">
                        <legend>行程內容</legend>
                        <div class="checkboxes">
                            <label class="form-check-label" for="natural_attraction">大自然</label>
                            <input class="form-check-input groupTag" type="checkbox" name="natural_attraction" id="natural_attraction" value="1" <?php echo ($rowsJoin['natural_attraction'] == 1 ? 'checked' : ""); ?> value="1">
                            <label class="form-check-label" for="culture_history">歷史人文</label>
                            <input class="form-check-input groupTag" type="checkbox" name="culture_history" id="culture_history" value="1" <?php echo ($rowsJoin['culture_history'] == 1 ? 'checked' : ""); ?> value="1">
                            <label class="form-check-label" for="workshop">工作坊/活動體驗</label>
                            <input class="form-check-input groupTag" type="checkbox" name="workshop" id="workshop" value="1" <?php echo ($rowsJoin['workshop'] == 1 ? 'checked' : ""); ?> value="1">
                            <label class="form-check-label" for="amusement">遊樂園、特殊節慶</label>
                            <input class="form-check-input groupTag" type="checkbox" name="amusement" id="amusement" value="1" <?php echo ($rowsJoin['amusement'] == 1 ? 'checked' : ""); ?> value="1">
                        </div>
                    </fieldset>
                    <fieldset class="other-tag">
                        <legend>其他屬性</legend>
                        <div class="checkboxes">
                            <label class="form-check-label" for="meal">包餐</label>
                            <input class="form-check-input groupTag" type="checkbox" name="meal" id="meal" value="1" <?php echo ($rowsJoin['meal'] == 1 ? 'checked' : ""); ?> value="1">

                            <label class="form-check-label" for="no_shopping">無購物行程</label>
                            <input class="form-check-input groupTag" type="checkbox" name="no_shopping" id="no_shopping" value="1" <?php echo ($rowsJoin['no_shopping'] == 1 ? 'checked' : ""); ?>>

                            <label class="form-check-label" for="family-friendly">適合全家出遊</label>
                            <input class="form-check-input groupTag" type="checkbox" name="family-friendly" id="family-friendly" value="1" <?php echo ($rowsJoin['family_friendly'] == 1 ? 'checked' : ""); ?>>

                            <label class="form-check-label" for="pet">寵物ok</label>
                            <input class="form-check-input groupTag" type="checkbox" name="pet" id="pet" value="1" <?php echo ($rowsJoin['pet'] == 1 ? 'checked' : ""); ?>>
                        </div>
                    </fieldset>
                    <fieldset class="indoor-outdoor">
                        <legend>室內室外<span>*</span></legend>
                        <div class="checkboxes">
                            <?php $indoor_str = $rowsJoin['indoor_outdoor']; ?>
                            <label class="form-check-label" for="indoor">室內</label>
                            <input class="form-check-input indoorTag" type="checkbox" name="indoor_outdoor[]" id="indoor" value="0" <?php echo ((strpos("$indoor_str", "0") === false) ? " " : "checked"); ?>>
                            <label class="form-check-label" for="outdoor">室外</label>
                            <input class="form-check-input indoorTag" type="checkbox" name="indoor_outdoor[]" id="outdoor" value="1" <?php echo ((strpos("$indoor_str", "1") === false) ? " " : "checked"); ?>>
                            <label class="form-check-label" for="both">都有</label>
                            <input class="form-check-input indoorTag" type="checkbox" name="indoor_outdoor[]" id="both" value="2" <?php echo ((strpos("$indoor_str", "2") === false) ? " " : "checked"); ?>>
                        </div>
                    </fieldset>
                    <fieldset class="custom-tag">
                        <legend>自定義屬性<small class="h6">※選填</small></legend>
                        <p>顯示在介紹文中<small>※以半形斜線(/)隔開</small></p>
                        <label class="form-label" for="custom_tag">請輸入</label>
                        <input class="form-control" type="text" name="custom_tag" id="custom_tag" value=<?= $rowsJoin['custom_tag'] ?>>
                    </fieldset>
                    <button class="btn btn-secondary" type="submit">送出</button>
                </div>
                </form>
                <!--表單結束-->
            </div>
        </div>
    </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="./assets/js/travel-user.js"></script>
    <script src="./assets/js/validation.js"></script>
    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>