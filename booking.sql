-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2022-11-15 10:53:56
-- 伺服器版本： 10.4.25-MariaDB
-- PHP 版本： 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `booking`
--

-- --------------------------------------------------------

--
-- 資料表結構 `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `admin`
--

INSERT INTO `admin` (`id`, `account`, `password`, `email`) VALUES
(1, 'admin', '12345', 'admin@gmail.com');

-- --------------------------------------------------------

--
-- 資料表結構 `coupon`
--

CREATE TABLE `coupon` (
  `id` int(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '優惠券名稱',
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '優惠券序號',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '優惠券描述',
  `expire_date` datetime NOT NULL COMMENT '優惠券期限',
  `discount` int(20) NOT NULL COMMENT '優惠券折數',
  `created_at` datetime NOT NULL,
  `valid` int(20) NOT NULL COMMENT '軟刪除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `coupon`
--

INSERT INTO `coupon` (`id`, `name`, `code`, `description`, `expire_date`, `discount`, `created_at`, `valid`) VALUES
(1, 'member1', '1111', '1111', '2022-11-07 00:00:00', 74, '2022-11-07 14:04:52', 1),
(2, 'member1', '1111', '1111', '0000-00-00 00:00:00', 2486, '2022-11-07 14:05:10', 0),
(3, 'member2', '2222', '2222', '2222-02-22 00:00:00', 2222, '2022-11-07 14:41:57', 1),
(4, '777', '777', '777', '0000-00-00 00:00:00', 777, '2022-11-07 14:44:49', 1),
(5, '', '', '', '0000-00-00 00:00:00', 0, '2022-11-07 14:57:54', 0),
(6, '12345', '12345', '12345', '2022-06-10 00:00:00', 6, '2022-11-10 14:11:50', 1),
(7, '', '', '', '0000-00-00 00:00:00', 0, '2022-11-10 15:44:48', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `hotel_account`
--

CREATE TABLE `hotel_account` (
  `id` int(20) UNSIGNED NOT NULL,
  `account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '飯店帳號',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '飯店密碼',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '負責人',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '地址',
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公司名',
  `company_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公司電話',
  `stars` int(20) NOT NULL COMMENT '星級',
  `company_banner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公司橫幅圖',
  `area` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '地區',
  `created_at` datetime NOT NULL COMMENT '建立帳號日期',
  `bank_account` int(20) NOT NULL COMMENT '銀行帳戶',
  `start_date` date NOT NULL COMMENT '開業日期',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公司信箱',
  `website` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '官網',
  `introduction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公司簡介',
  `valid` int(20) NOT NULL COMMENT '軟刪除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `hotel_account`
--

INSERT INTO `hotel_account` (`id`, `account`, `password`, `name`, `address`, `company_name`, `company_phone`, `stars`, `company_banner`, `area`, `created_at`, `bank_account`, `start_date`, `email`, `website`, `introduction`, `valid`) VALUES
(1, 'Tom', '12345', 'Tom', '800 高雄市新興區中山橫路5號', '聖德', '0923541233', 3, '', '2', '2022-11-04 14:22:06', 123456789, '2018-06-12', 'tom@hotel.com', 'tom.com.tw', '', 1),
(2, 'Curry', '12345', 'Curry', '600 嘉義市西區永利二街32號', '雅瑪哈', '0956321542', 5, '', '2', '2022-11-04 14:27:39', 2147483647, '2004-07-13', 'curry@hotel.com', 'curry.com.tw', '', 1),
(3, 'Jay', '12345', 'Jay', '224 新北市瑞芳區中央路9號', '傑可', '0978236462', 5, '', '2', '2022-11-04 15:21:54', 2147483647, '2003-12-21', 'jay@test.com', 'jay.com.tw', '', 1),
(4, 'Timmy', '12345', 'Timmy', '351 苗栗縣頭份市新生街19號', '時中表', '0952123666', 4, '', '2', '2022-11-04 00:00:00', 2147483647, '2009-05-18', 'timmy@hotel.com', 'timmy.com.tw', '', 1),
(5, 'Fred', '12345', 'Fred', '204 基隆市安樂區定國街25號', '佛誕', '0955369111', 4, '', '2', '1997-11-04 19:01:10', 2147483647, '1999-10-10', 'fred@hotel.com', 'fred.com.tw', '', 1),
(6, 'Pllo', '12345', 'Pllo', '269 宜蘭縣冬山鄉寶慶一路30號', '皮帶股', '0955396966', 5, '', '2', '2022-06-16 14:18:00', 963111222, '2003-11-17', 'pllo@hotel.com', 'pllo.com.tw', '', 1),
(7, 'Poole', '12345', 'Poole', '651 雲林縣北港鎮光復二路11號', '皮娜可', '098845236', 5, '', '2', '2022-11-04 16:10:29', 1254836912, '1997-03-16', 'poole@gmail.com', 'poole.com.tw', '', 1),
(8, 'Denny', '12345', 'Denny', '640 雲林縣斗六市萬年東路11號', '斗斗雞', '0936124598', 2, '', '2', '2022-11-04 16:15:49', 2147483647, '1995-03-03', 'denny@hotel.com', 'denny.com.tw', '', 1),
(9, 'May', '12345', 'May', '908 屏東縣長治鄉瑞源二街7號', '馬力雅', '0954217455', 4, '', '2', '2022-11-07 09:56:29', 2147483647, '1983-06-12', 'may@test.com', 'may.com.tw', '', 1),
(10, 'Toyz', '12345', 'Toyz', '227 新北市雙溪區四分子12號', '良藥毒口', '0955777413', 5, '', '2', '2022-11-07 15:13:44', 2031298730, '2011-07-20', 'toyz@hotel.com', 'toyz.com.tw', '', 1),
(11, 'Jenny', '12345', 'Jenny', '310 新竹縣竹東鎮榮華街22號', '美妹梅', '0958147368', 3, '', '1', '2022-11-08 14:25:59', 1249531456, '1998-11-17', 'jenny@hotel.com', 'jenny.com.tw', '', 1),
(12, 'Tank', '12345', 'Tank', '500 彰化縣彰化市埔巿街7號', '璋彰包', '0922123423', 5, '', '2', '2022-11-08 16:14:09', 221215481, '1988-12-03', 'tank@hotal.com', 'tank.com.tw', '', 1),
(13, 'pigg', '12345', '株株株', '800 高雄市新興區球庭路9號', '株大胖', '095532622', 3, '', '2', '2022-11-15 10:02:40', 2147483647, '2018-05-21', 'pigg@test.com', 'pigg.test.com', '', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `hotel_comment`
--

CREATE TABLE `hotel_comment` (
  `id` int(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'user.account',
  `hotel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'hotel_account.id',
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '評論',
  `comment_stars` int(20) NOT NULL COMMENT '評論星數',
  `created_at` datetime NOT NULL COMMENT '留言時間',
  `valid` int(20) NOT NULL COMMENT '軟刪除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `hotel_room_list`
--

CREATE TABLE `hotel_room_list` (
  `id` int(20) NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'hotel_account.account',
  `room_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '房間名稱',
  `price` int(20) NOT NULL COMMENT '價格',
  `service` int(20) NOT NULL,
  `amount` int(20) NOT NULL COMMENT '賣多少份',
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '宣傳照片',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '房間說明',
  `created_at` datetime NOT NULL,
  `valid` int(20) NOT NULL COMMENT '軟刪除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `hotel_room_list`
--

INSERT INTO `hotel_room_list` (`id`, `owner`, `room_name`, `price`, `service`, `amount`, `picture`, `description`, `created_at`, `valid`) VALUES
(1, 'Tom', '寵物VIP房1', 3000, 0, 2, 'vip1-pet.jpg', '寵物VIP房', '2014-11-27 10:32:55', 1),
(2, 'Tom', '雙床房', 1500, 0, 3, 'twin.jpg', '雙床房型', '2006-12-21 06:33:13', 1),
(6, 'Tom', '一大床雙人房', 2000, 0, 3, 'dbl.jpg', '一大床雙人房123', '2022-11-10 14:03:40', 1),
(7, 'Curry', '豪華大床房', 3000, 0, 1, 'delux-dbl.jpg', '豪華大床房', '2022-11-07 10:50:29', 1),
(8, 'Curry', '豪華浴缸大床房', 3500, 0, 1, 'delux-tub-dbl.jpg', '豪華浴缸大床房', '2022-11-08 11:42:39', 1),
(9, 'Toyz', '豪華大床房', 6000, 0, 12, 'banner.jpg', '豪華大床房', '2022-11-08 16:24:31', 1),
(10, 'Toyz', '豪華浴缸大床房', 8000, 0, 7, 'dbl.jpg', '豪華浴缸大床房', '2022-11-08 16:25:03', 1),
(11, 'May', '寵物VIP房1', 5000, 0, 6, 'dbl.jpg', '寵物VIP房1', '2022-11-10 15:45:49', 1),
(12, 'May', '雙床房', 1200, 0, 1, 'delux-tub-dbl.jpg', '雙床房', '2022-11-10 15:45:14', 1),
(18, 'Tom', '海景雙人房', 1200, 0, 1, 'seaview-dbl.jpg', '海景雙人房', '2022-11-14 13:20:40', 1),
(19, 'Tom', '家庭四人房', 3000, 0, 2, 'family-forth.jpg', '家庭四人房', '2022-11-14 13:21:06', 1),
(20, 'Tank', '雙床房', 4500, 0, 5, 'delux-tub-dbl.jpg', '雙床房', '2022-11-14 14:20:31', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `hotel_service_list`
--

CREATE TABLE `hotel_service_list` (
  `id` int(20) UNSIGNED NOT NULL,
  `hotel` varchar(255) NOT NULL COMMENT '飯店名',
  `wifi` int(20) NOT NULL,
  `pool` int(20) NOT NULL,
  `gym` int(20) NOT NULL,
  `restaurant` int(20) NOT NULL,
  `bar` int(20) NOT NULL,
  `parking` int(20) NOT NULL,
  `laundry` int(20) NOT NULL,
  `meeting_room` int(20) NOT NULL,
  `arcade` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `hotel_service_list`
--

INSERT INTO `hotel_service_list` (`id`, `hotel`, `wifi`, `pool`, `gym`, `restaurant`, `bar`, `parking`, `laundry`, `meeting_room`, `arcade`) VALUES
(1, 'Tom', 1, 1, 1, 1, 1, 0, 0, 0, 1),
(2, 'tommy', 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'pigg', 1, 1, 0, 1, 1, 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `room_service_list`
--

CREATE TABLE `room_service_list` (
  `id` int(20) NOT NULL,
  `room` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'hotel_room_list.room_name',
  `pet` int(20) NOT NULL COMMENT '寵物',
  `tv` int(20) NOT NULL COMMENT '電視',
  `tub` int(20) NOT NULL COMMENT '浴缸',
  `meal` int(20) NOT NULL COMMENT '供餐',
  `mini_bar` int(20) NOT NULL COMMENT 'mini Bar',
  `window` int(20) NOT NULL COMMENT '有窗戶',
  `corner` int(20) NOT NULL COMMENT '邊間',
  `valid` int(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `room_service_list`
--

INSERT INTO `room_service_list` (`id`, `room`, `pet`, `tv`, `tub`, `meal`, `mini_bar`, `window`, `corner`, `valid`) VALUES
(1, '寵物VIP房1', 1, 1, 0, 1, 1, 1, 0, 1),
(2, '雙床房', 0, 1, 0, 1, 1, 1, 0, 1),
(3, '一大床雙人房', 1, 0, 0, 0, 0, 0, 0, 1),
(4, '豪華大床房', 1, 1, 1, 1, 1, 1, 0, 1),
(5, '豪華浴缸大床房', 1, 0, 0, 1, 0, 0, 1, 1),
(6, '大床房', 1, 0, 0, 1, 0, 0, 1, 1),
(7, '海景雙人房', 0, 1, 1, 0, 1, 1, 0, 1),
(8, '家庭四人房', 1, 0, 0, 1, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `total_order_list`
--

CREATE TABLE `total_order_list` (
  `id` int(20) UNSIGNED NOT NULL,
  `user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'users.account',
  `company_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'hotel_room_list.room_name / trip_event.trip_name',
  `status` int(20) NOT NULL COMMENT '是否付費',
  `order_date` datetime(6) NOT NULL COMMENT '訂購日期',
  `amount` int(20) NOT NULL COMMENT '訂單數',
  `valid` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `total_order_list`
--

INSERT INTO `total_order_list` (`id`, `user`, `company_id`, `product_id`, `status`, `order_date`, `amount`, `valid`) VALUES
(1, 'Jerry', 'Tom', '寵物VIP房1', 1, '2022-11-08 13:27:07.000000', 1, 1),
(2, 'tangej', 'Tom', '雙床房', 0, '2022-10-22 14:27:12.000000', 2, 1),
(3, 'Tom', 'Tom', '寵物VIP房1', 1, '2022-11-01 15:54:24.000000', 2, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `total_order_list_detail`
--

CREATE TABLE `total_order_list_detail` (
  `id` int(20) UNSIGNED NOT NULL,
  `user_detail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id_detail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'total_order_list.product_id',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '地址',
  `price` int(20) NOT NULL COMMENT '價格',
  `date` datetime NOT NULL COMMENT '行程日期',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '行程描述',
  `valid` int(20) NOT NULL COMMENT '軟刪除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `total_order_list_detail`
--

INSERT INTO `total_order_list_detail` (`id`, `user_detail`, `product_id_detail`, `address`, `price`, `date`, `description`, `valid`) VALUES
(1, 'Tom', '寵物VIP房1', '桃園市XX區XX街XX號', 3600, '2022-11-08 13:29:55', 'TEST訂單', 1),
(2, 'tangej', '雙床房', '桃園市XX區XX街XX號', 1600, '2022-11-10 14:29:43', 'TEST2', 1),
(3, 'Jerry', '寵物VIP房1', '桃園市XX區XX號', 0, '2022-11-08 15:53:32', 'aaba', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `travel_account`
--

CREATE TABLE `travel_account` (
  `id` int(20) UNSIGNED NOT NULL,
  `account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '飯店帳號',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '飯店密碼',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '負責人',
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公司名',
  `company_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公司電話',
  `company_banner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公司橫幅圖',
  `area` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '地區',
  `created_at` datetime NOT NULL COMMENT '建立帳號日期',
  `bank_account` int(20) NOT NULL COMMENT '銀行帳戶',
  `start_date` date NOT NULL COMMENT '開業日期',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公司信箱',
  `website` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '官網',
  `introduction` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '公司簡介',
  `valid` int(20) NOT NULL COMMENT '軟刪除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `travel_account`
--

INSERT INTO `travel_account` (`id`, `account`, `password`, `name`, `company_name`, `company_phone`, `company_banner`, `area`, `created_at`, `bank_account`, `start_date`, `email`, `website`, `introduction`, `valid`) VALUES
(1, 'Moon123', 'Moon123', '樂月月', '月亮旅團', '0912345678', 'Momo', '0', '2022-11-04 10:37:23', 1231456464, '2022-11-04', 'moon123@moon.com.tw', 'https://moon123.com.tw', '月亮月亮', 1),
(2, 'Kitty321', 'Kitty321', 'Kitty', '無嘴喵旅行社', '0976482462', 'Kitty', '0', '2022-11-04 10:59:02', 156455, '2022-10-10', 'Kitty321@kkity.com.tw', 'https://Kitty456.com.tw', 'KItttttty', 1),
(3, 'Momo123', 'Momo123', 'Momo', 'Momo trip', '0912345646', 'Momo', '0', '2022-11-04 13:53:15', 111254681, '2022-11-22', 'Momo123@momo.com.tw', 'https://Momo123.com.tw', 'Momo GOGO', 1),
(4, 'test123', '12345', 'Jerry', 'Jerry', '0987654123', 'test', '1', '2022-11-10 14:00:00', 2147483647, '2022-11-09', '12345@2', 'test.com.tw', 'test123', 1),
(5, 'adobe', '12345', '機一機', '雞雞雞', '0965236456', '', '0', '2022-11-15 10:37:23', 1243698523, '2022-11-14', 'adobe@test.com', 'adobe.test.com', 'adobe.sadasd', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `trip_comment`
--

CREATE TABLE `trip_comment` (
  `id` int(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'user.account',
  `trip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'trip_event.id',
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '評論',
  `comment_stars` int(20) NOT NULL COMMENT '評論星數',
  `created_at` datetime NOT NULL COMMENT '留言時間',
  `valid` int(20) NOT NULL COMMENT '軟刪除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `trip_comment`
--

INSERT INTO `trip_comment` (`id`, `name`, `trip`, `comment`, `comment_stars`, `created_at`, `valid`) VALUES
(1, 'admin', '1', 'good!', 4, '2022-11-10 13:26:56', 1),
(2, 'admin', '2', 'good!', 5, '2022-11-10 13:26:56', 1),
(3, 'admin', '3', 'good!', 5, '2022-11-10 13:26:56', 1),
(4, 'admin2', '1', 'good!', 5, '2022-11-10 13:26:56', 1),
(5, 'admin2', '2', 'good!', 2, '2022-11-10 13:26:56', 1),
(6, 'admin', '5', 'good!', 5, '2022-11-10 13:26:56', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `trip_event`
--

CREATE TABLE `trip_event` (
  `id` int(20) NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'travel_account.account',
  `trip_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '行程名稱',
  `price` int(20) NOT NULL COMMENT '價格',
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '宣傳照片',
  `guide` int(20) NOT NULL COMMENT '有無導遊',
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '行程說明',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` datetime NOT NULL,
  `valid` int(20) NOT NULL COMMENT '軟刪除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `trip_event`
--

INSERT INTO `trip_event` (`id`, `owner`, `trip_name`, `price`, `picture`, `guide`, `location`, `description`, `start_date`, `end_date`, `created_at`, `valid`) VALUES
(1, 'test123', '77777777', 7777777, 'family-forth.jpg', 1, '', '123', '2000-01-08', '0000-00-00', '2022-11-14 17:14:41', 1),
(2, 'test123', '7777777', 777777, 'seaview-dbl.jpg', 1, '', '777', '0000-00-00', '0000-00-00', '2022-11-14 17:28:29', 2),
(3, 'test123', '123456', 123456, 'delux-tub-dbl.jpg', 1, '', '123', '2022-11-04', '2022-11-25', '2022-11-14 17:32:40', 2),
(4, 'adobe', 'adfagawrg', 1500, 'delux-tub-dbl.jpg', 0, '', 'agraegre', '2022-11-25', '2022-12-29', '2022-11-15 10:41:46', 2),
(5, 'adobe', 'afsasf', 0, 'family-forth.jpg', 0, '', 'asfasf', '2022-11-02', '2022-11-18', '2022-11-15 10:45:49', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `trip_service_list`
--

CREATE TABLE `trip_service_list` (
  `id` int(20) NOT NULL,
  `trip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'trip_event.trip_name',
  `mountain` int(20) NOT NULL COMMENT '登山踏青',
  `in_water` int(20) NOT NULL COMMENT '海邊、溪邊...',
  `snow` int(20) NOT NULL COMMENT '滑雪、雪上運動',
  `natural_attraction` int(20) NOT NULL COMMENT '自然景點:\r\n山，峽谷、瀑布..自然景觀',
  `culture_history` int(20) NOT NULL COMMENT '文化、歷史景點',
  `workshop` int(20) NOT NULL COMMENT '工作訪、手作體驗...',
  `amusement` int(20) NOT NULL COMMENT '遊樂園、童玩節...',
  `meal` int(20) NOT NULL COMMENT '包餐',
  `no_shopping` int(20) NOT NULL COMMENT '有無購物行程',
  `family_friendly` int(20) NOT NULL COMMENT '家庭活動',
  `pet` int(20) NOT NULL COMMENT '能帶寵物嗎',
  `indoor_outdoor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '0:室內\r\n1:室外\r\n2:both',
  `custom_tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '以 comma (,)\r\n分隔，自定義的標籤'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `trip_service_list`
--

INSERT INTO `trip_service_list` (`id`, `trip`, `mountain`, `in_water`, `snow`, `natural_attraction`, `culture_history`, `workshop`, `amusement`, `meal`, `no_shopping`, `family_friendly`, `pet`, `indoor_outdoor`, `custom_tag`) VALUES
(1, '77777777', 1, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, '', '132'),
(2, '7777777', 1, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, '', '123'),
(3, '123456', 1, 0, 0, 0, 1, 0, 0, 0, 1, 0, 0, '', '123'),
(4, 'adfagawrg', 1, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, '', 'er/5'),
(5, 'afsasf', 1, 1, 0, 1, 0, 1, 0, 0, 1, 0, 0, '', 'asf/dgfh');

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(20) UNSIGNED NOT NULL,
  `account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '帳戶',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密碼',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '姓名',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '電話',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '信箱',
  `identification` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '身分證',
  `birthday` date NOT NULL COMMENT '生日',
  `gender` int(20) NOT NULL COMMENT '性別',
  `created_at` datetime NOT NULL COMMENT '創建時間',
  `points` int(20) NOT NULL COMMENT '點數',
  `level` int(20) NOT NULL COMMENT '等級',
  `coupon` int(20) NOT NULL COMMENT '優惠券',
  `valid` int(20) NOT NULL COMMENT '軟刪除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `account`, `password`, `name`, `phone`, `email`, `identification`, `birthday`, `gender`, `created_at`, `points`, `level`, `coupon`, `valid`) VALUES
(1, 'admin', '12345', 'Tom', '123456789', 'god@777', 'T123456789', '1992-12-31', 0, '2022-08-03 16:00:26', 0, 0, 0, 1),
(2, 'admin2', '1234', 'Jerry', '90454646', 'godd@77', 'J123456789', '1999-08-27', 0, '1900-01-01 16:06:34', 0, 0, 0, 1),
(3, 'admin3', '12345', 'ej', '123456789', 'god@777', 'e123456789', '2022-11-03', 1, '1899-11-01 09:48:18', 99, 110000, 0, 1),
(4, 'admin4', '12345', 'jj', '912345678', 'god@777', 'j123456789', '2022-11-02', 0, '2022-11-04 09:49:50', 55, 11, 0, 1),
(5, 'admin5', '12345', 'ovo', '912345678', 'pp@pp', 'e123456789', '2022-09-07', 0, '2022-11-04 10:18:02', 0, 0, 0, 1),
(6, 'admin6', '12345', 'op', '0', 'god@777', '554545534', '2022-10-06', 0, '2022-09-07 10:23:00', 0, 0, 0, 1),
(7, 'David', '12345', 'David', '98745621', 'god@777', 'D123456789', '2022-11-04', 0, '2022-11-04 13:33:49', 0, 0, 0, 1),
(8, '12345', '12345', '', '0', '12345@2', '', '1998-04-16', 0, '2022-11-07 09:48:32', 0, 0, 0, 1),
(9, '123456', '12345', '', '0', '12345@2', '', '1998-04-16', 1, '2022-11-07 09:51:06', 0, 0, 0, 1),
(10, '1234567', '123456', 'member1', '937512654', '12345@2', 'T122136985', '2022-11-07', 1, '2022-11-07 09:51:37', 0, 0, 0, 1),
(11, '12345678', '12345', 'member1', '937512654', '12345@2', 'T122136985', '2018-02-07', 1, '2022-11-07 09:52:08', 0, 0, 0, 1),
(12, 'member1', '12345', 'member1', '937512654', '1@q', 'T122136985', '1900-11-07', 1, '2022-11-07 10:40:58', 0, 0, 0, 1),
(13, '', '', '', '0', '', '', '1998-04-16', 0, '2022-11-07 10:54:54', 0, 0, 0, 0),
(14, 'tom123', '12345', 'lin', '2147483647', 't7777@7', 't77777777', '1900-11-07', 1, '2022-11-07 11:16:38', 0, 0, 0, 1),
(15, '', '', 'gggaa', '0', '', '', '1982-02-07', 1, '2022-11-07 11:47:55', 0, 0, 0, 1),
(16, '', '', '', '0', '', '', '1998-04-16', 0, '2022-11-07 13:18:55', 0, 0, 0, 0),
(17, 'Tom', '12345', 'Tom', '944786235', 'tom@test.com', 't124357555', '2001-01-31', 1, '2022-11-08 14:24:33', 0, 0, 0, 1),
(18, 'tangej', '12345', 'tangej', '968452789', 'tangej@test.com', 'S254876248', '1993-08-02', 0, '2022-11-08 14:26:29', 0, 0, 0, 1),
(19, 'Jerry', '12345', 'Jerry', '966475125', 'jerry@test.com', 'P123456888', '1983-10-12', 1, '2022-11-08 15:47:38', 0, 0, 0, 1),
(25, 'aka', '12345', 'aka', '955666444', 'aka@test.com', 'S123333554', '1975-12-01', 1, '2022-11-10 13:35:42', 0, 0, 0, 1),
(30, 'kevin', '12345', 'kevin', '911111111', 'kevin@test.com', 'O125486555', '1995-10-15', 1, '2022-11-10 15:43:21', 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- 資料表結構 `user_coupon`
--

CREATE TABLE `user_coupon` (
  `id` int(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'users.account',
  `coupon_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'coupon.name',
  `amount` int(20) NOT NULL COMMENT '優惠券數量',
  `expire_date` datetime NOT NULL COMMENT 'coupon.expire_date',
  `discount` int(20) NOT NULL COMMENT 'coupon.discount',
  `valid` int(20) NOT NULL COMMENT '軟刪除'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `user_order`
--

CREATE TABLE `user_order` (
  `id` int(6) UNSIGNED NOT NULL,
  `product_hotel_id` int(6) UNSIGNED NOT NULL COMMENT '對應product-hotel的id',
  `product-travel-id` int(6) NOT NULL COMMENT '對應product-travel的id',
  `amount` int(4) UNSIGNED NOT NULL,
  `buyer_id` int(3) NOT NULL COMMENT '對應一般使用者的id',
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `hotel_account`
--
ALTER TABLE `hotel_account`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `hotel_comment`
--
ALTER TABLE `hotel_comment`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `hotel_room_list`
--
ALTER TABLE `hotel_room_list`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `hotel_service_list`
--
ALTER TABLE `hotel_service_list`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `room_service_list`
--
ALTER TABLE `room_service_list`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `total_order_list`
--
ALTER TABLE `total_order_list`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `total_order_list_detail`
--
ALTER TABLE `total_order_list_detail`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `travel_account`
--
ALTER TABLE `travel_account`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `trip_comment`
--
ALTER TABLE `trip_comment`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `trip_event`
--
ALTER TABLE `trip_event`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `trip_service_list`
--
ALTER TABLE `trip_service_list`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `user_coupon`
--
ALTER TABLE `user_coupon`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `user_order`
--
ALTER TABLE `user_order`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `coupon`
--
ALTER TABLE `coupon`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `hotel_account`
--
ALTER TABLE `hotel_account`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `hotel_comment`
--
ALTER TABLE `hotel_comment`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `hotel_room_list`
--
ALTER TABLE `hotel_room_list`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `hotel_service_list`
--
ALTER TABLE `hotel_service_list`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `room_service_list`
--
ALTER TABLE `room_service_list`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `total_order_list`
--
ALTER TABLE `total_order_list`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `total_order_list_detail`
--
ALTER TABLE `total_order_list_detail`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `travel_account`
--
ALTER TABLE `travel_account`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `trip_comment`
--
ALTER TABLE `trip_comment`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `trip_event`
--
ALTER TABLE `trip_event`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `trip_service_list`
--
ALTER TABLE `trip_service_list`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_coupon`
--
ALTER TABLE `user_coupon`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_order`
--
ALTER TABLE `user_order`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
