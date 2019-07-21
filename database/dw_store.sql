-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 27, 2018 at 10:48 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dw_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `APIs`
--

CREATE TABLE `APIs` (
  `id` int(11) NOT NULL,
  `api_name` varchar(100) NOT NULL,
  `api_key` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `APIs`
--

INSERT INTO `APIs` (`id`, `api_name`, `api_key`, `created_at`) VALUES
(1, 'dwsmarketplace', 'AIzaSyDDmI1OLJfpzhprJACpBpXbkVg1oGoHlKc', '2018-01-02 12:55:10'),
(10, 'My test Api', 'XcArESXNHNtyTOCnWtKBpOt1a9M5ECEw4tBhdR1I', '2018-01-03 13:15:10'),
(11, 'my api', 'wGwHtJ0kK9zVUjp9RcEUlIBGzoSOvaguNrReW5h0', '2018-01-03 15:57:37'),
(12, 'example', 'qVpwnjEoYqzNt4Nq98D88dDD60DpVqmzzMnt8ByR', '2018-01-15 09:29:06'),
(13, 'test', 'I8BeBSrFZRSTcz2u3jL9o1M0whDyTBY1A3QXNxzR', '2018-01-15 17:37:37');

-- --------------------------------------------------------

--
-- Table structure for table `MsBank`
--

CREATE TABLE `MsBank` (
  `BankID` int(11) NOT NULL,
  `BankName` varchar(100) NOT NULL,
  `BankBranchOffice` varchar(100) NOT NULL,
  `BankAccountNumber` varchar(100) NOT NULL,
  `BankAccountName` varchar(100) NOT NULL,
  `BankLogo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MsBank`
--

INSERT INTO `MsBank` (`BankID`, `BankName`, `BankBranchOffice`, `BankAccountNumber`, `BankAccountName`, `BankLogo`) VALUES
(1, 'Bank Central Asia', 'Branch Bina Nusantara', '527 154 2888', 'PT. Panda Technologies', 'bca.png'),
(2, 'Bank Mandiri', 'Branch Bina Nusantara', '507 254 2813', 'PT. Panda Technologies', 'mandiri.png');

-- --------------------------------------------------------

--
-- Table structure for table `MsCategory`
--

CREATE TABLE `MsCategory` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MsCategory`
--

INSERT INTO `MsCategory` (`CategoryID`, `CategoryName`) VALUES
(1, 'Handphone &amp; Tablet'),
(2, 'Computer & Accessories'),
(3, 'Men\'s Fashion'),
(4, 'Women\'s Fashion'),
(5, 'Gaming'),
(6, 'Electronic'),
(7, 'Camera'),
(8, 'Laptop & Accessories'),
(9, 'Book'),
(10, 'Sport'),
(11, 'Automotif'),
(12, 'Food & Drink'),
(13, 'Office & Stationery'),
(14, 'Health');

-- --------------------------------------------------------

--
-- Table structure for table `MsDiscount`
--

CREATE TABLE `MsDiscount` (
  `DiscountID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MsDiscount`
--

INSERT INTO `MsDiscount` (`DiscountID`, `ProductID`, `Discount`) VALUES
(1, 1, 29),
(2, 2, 12);

-- --------------------------------------------------------

--
-- Table structure for table `MsGallery`
--

CREATE TABLE `MsGallery` (
  `GalleryID` int(11) NOT NULL,
  `GalleryTitle` varchar(100) NOT NULL,
  `GallerySection` enum('main','right top','right bottom') NOT NULL,
  `GalleryImage` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MsGallery`
--

INSERT INTO `MsGallery` (`GalleryID`, `GalleryTitle`, `GallerySection`, `GalleryImage`) VALUES
(1, 'Slide 1', 'main', 'slide_1.jpg'),
(2, 'Slide 2', 'main', 'slide_2.jpg'),
(3, 'Slide 3', 'main', 'slide_3.png'),
(10, 'Promo 1', 'right top', 'slide_1514719961_2617.jpg'),
(11, 'Promo 2', 'right top', 'slide_1514719980_9706.jpg'),
(13, 'Promo 3', 'right top', 'slide_1514720072_1150.jpg'),
(15, 'Promo 5', 'right bottom', 'slide_1514720311_9061.jpg'),
(16, 'Promo 6', 'right bottom', 'slide_1514745720_8507.jpg'),
(17, 'Promo 7', 'right bottom', 'slide_1514745754_1606.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `MsProduct`
--

CREATE TABLE `MsProduct` (
  `ProductID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `ProductName` varchar(100) NOT NULL,
  `ProductPrice` int(11) NOT NULL,
  `ProductWeight` double NOT NULL DEFAULT '0',
  `ProductDescription` text NOT NULL,
  `ProductImage` varchar(100) NOT NULL,
  `DateIn` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Stock` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MsProduct`
--

INSERT INTO `MsProduct` (`ProductID`, `CategoryID`, `ProductName`, `ProductPrice`, `ProductWeight`, `ProductDescription`, `ProductImage`, `DateIn`, `Stock`) VALUES
(1, 2, 'Apple MacBookPro MF839 - 8GB RAM - Intel - 13.3Inch - Putih', 25599000, 0, 'Laptop Type ASUS X441UA\r\nProcessor Type Intel Core i3 6100U \r\nProcessor Speed 2.3 GHz\r\nChipset Intel H 110\r\nScreen Size 14.0&quot; 16:9 LED Backlit HD 1366 x 768 Glare Panel with 45% NTSC\r\nRAM 4 GB DDR4 1600BUS\r\nHard Disk 1TB 5400RPM SATA HDD\r\nOptical Drive Super-Multi DVD (Optional)\r\nGraphics Card Intel HD Graphics\r\nAudio/Speaker Asus SonicMaster Technology\r\nNetworking Wi-Fi Integrated 802.11b/g/n, Bluetooth V4.0\r\nWebcam VGA Web Camera\r\nCard Reader Multi-format Card Reader\r\nBattery 3 Cells 36 Whrs Battery\r\nOther Features 1 x Combo aAudio Jack, 1 x VGA, 1 x USB 3.1 TYPE C, 1 x USB 3.0, 1 x USB 2.0,,1 x RJ45 LAN Jack, 1 x HDMI, 1 x Smart Card, 1 x AC Adapter Plug\r\nOS WINDOWS10 ORIGINAL', 'p_1514476854_6597.jpg', '2017-12-28 00:00:00', 100),
(2, 2, 'Apple Macbook Pro Retina MF841 8GB RAM - Intel Core i5 - 13', 23000000, 0, 'Memperkenalkan MacBook Pro 13&quot;. Dengan prosesor Intel Core i5 memberikan performa yang jauh lebih cepat dari generasi sebelumnya. Lakukan semua pekerjaan komputasi Anda dengan mudah dan tanpa jeda dengan prosesor yang lebih cepat serta tampilan grafis yang memukau. Dengan desain yang ramping dan ringan, kini Anda tak perlu khawatir untuk membawanya kemanapun Anda membutuhkannya. MacBook Pro seri ini hadir dengan berbagai spesifikasi sesuai dengan kebutuhan Anda yang tak perlu diragukan lagi performanya. Desain Elegan &amp; Unibody Alumunium MacBook Pro menampilkan presisi casing unibody crafted dari satu blok dari aluminium. Desainnya tipis dan ringan dari generasi sebelumnya, serta lebih kuat dan lebih tahan lama. Dilengkapi juga dengan layar berukuran 13&quot; beresolusi 1280 x 800 pixel dan dengan lampu berteknologi LED yang dapat menampilkan gambar dengan sangat terang. Anda juga tak perlu khawatir untuk bepergian karena daya tahan baterainya dapat bertahan hingga 7 jam. Performa Mengagumkan Pada MacBook seri ini, didukung dengan prosesor Intel Core i5, 2.7 GHz berteknologi chipset Broadwell dengan memori RAM DDR3 8 GB serta SSD 512GB yang memberikan kecepatan dan kelancaran dalam kegiatan komputasi tanpa hambatan. Untuk memori grafisnya, dikemas prosesor grafis yaitu Intel Iris Graphics yang memberikan Anda tampilan grafis menawan ketika bermain games ataupun mengedit video. Untuk urusan konektivitas, seluruh MacBook Pro seri ini telah dibekali dengan Wi-Fi 802.11n, Bluetooth 4.0, SDXC card slot, 2 port USB 3.0 serta port FireWire 800. Anda pun dapat melakukan video chatting ataupun Skype dengan kerabat Anda menggunakan 720p FaceTime HD camera. Teknologi Hyper-Threading Teknologi Hyper-Threading Intel memungkinkan setiap inti prosesor untuk bekerja pada dua tugas pada saat yang sama, memberikan kinerja yang Anda butuhkan untuk melakukan multitasking. Anda juga dapat menikmati serangkaian fitur-fitur baru untuk pengalaman visual yang menakjubkan dan mulus tanpa hardware tambahan. Prosesor grafis juga secara otomatis meningkatkan kecepatan clock untuk beban kerja yang lebih tinggi, dan baterai yang tahan lama ketika Anda sedang menonton DVD atau film. Teknologi Multi-Touch Terbaik Teknologi multi-touch merupakan bagian tak terpisahkan dari hampir setiap produk Apple. Merupakan cara terbaik dan paling pribadi untuk berinteraksi dengan perangkat Anda. Cara yang optimal untuk menggunakan multi-touch adalah melalui trackpad. Trackpad pada MacBook Pro sangat luas, terbuat dari lapisan glass tanpa tombol. Dengan multi-touch gestures, Anda bisa berinteraksi dengan dengan MacBook Pro dengan cara yang lebih intuitif dan responsif dari sebelumnya. Teknologi Thunderbolt Teknologi baru Thunderbolt memungkinkan Anda untuk mentransfer data melalui port dengan kecepatan sangat tinggi, bahkan hingga 10Gbps atau dua kali lebih baik dari USB 3.0. Thunderbolt juga dapat dikoneksikan melalui Mini Display Port. Hal ini memungkinkan Anda untuk melakukan transfer file video dengan performa tinggi, dan tampilan beresolusi tinggi menggunakan DisplayPort, DVI, HDMI, atau koneksi VGA dengan adaptor yang tersedia. iCloud iCloud menyimpan musik, foto, dan dokumen secara nirkabel. Jadi bila Anda membeli lagu, membeli foto, atau mengedit kalender pada iPad Anda. iCloud akan secara otomatis menampilkan pada Mac Anda, iPhone, atau iPod touch juga tanpa Anda perlu menekan apapun.', 'p_1514476746_6678.jpg', '2017-12-28 00:00:00', 50),
(5, 1, 'Apple iPhone 8 256 GB Smartphone - Space Gray', 13323000, 0, 'berat minimum pengiriman yang disyaratkan adalah 1 kilo, HP dan gadget elektronik wajib asuransi dan paking kayu, biaya paking kayu sama dengan ongkos kirim, jadi total minimal 2 kilo. \r\n2. Penginputan resi JNE dilakukan 1 hari sejak kami terima order, lacak lewat system tracking JNE dan silahkan komplain ke CS JNE jika belum diterima sebelum 6 hari. \r\n3. Offline store kami alamat liat di profile toko. Lokasi, Stok dan harganya berbeda dengan online store, jadi silahkan cek langsung ke offline store jika mau COD. \r\n\r\nIPHONE 8 ROM 64GB GARANSI RESMI TAM / IBOX / APPLE INDONESIA\r\n\r\nKapasitas 64 GB\r\nBerat: 148 gram \r\nLayar Retina HD\r\nLayar lebar LCD Multi-Touch 4,7 inci (diagonal) dengan teknologi IPS\r\nRasio kontras 1400:1 (umum)\r\nMemiliki level IP67 menurut standar IEC 60529\r\nKamera 12 MP, Bukaan /1.8, Zoom digital hingga 5x\r\nMampu merekam video 4K pada kecepatan 24 fps, 30 fps, atau 60 fps\r\nSecondary Camera 7 MP, Mampu merekam video HD 1080p, Retina Flash, Bukaan /2.2\r\nSensor sidik jari terpasang di tombol Home\r\niOS 11\r\nNano-SIM\r\nNon-removable Li-Ion 1821 mAh battery (6.96 Wh)', 'p_1514479192_2422.jpg', '2017-12-28 00:00:00', 50),
(6, 1, 'Apple iPhone X 64 GB Smartphone - Space Gray', 17900000, 0, 'Apple Iphone X merupakan satu-satunya Smartphone terbaru Apple yang menggunakan tipe Layar Full Screen, sehingga penggunanya akan merasakan keleluasaan tanpa batas diatas layar iPhone X. Layar Super Retina iPhone X dirancang dengan teknologi terbaru Apple yang sangat presisi, sehingga setiap sudut dan lekukan Iphone X melengkung dengan mulus. Meski ukurannya layarnya hanya 5.8 inch, tapi layar iPhone X mempunyai jumlah pixel dan resolusi layar yang cukup menjanjikan. ', 'p_1514479384_5815.jpg', '2017-12-28 00:00:00', 10),
(7, 1, 'Apple iPhone 7 Plus 128 GB Smartphone - Red', 13200000, 0, 'Produk iPhone 7 Plus Red Edition ini merupakan bentuk kerja sama antara Apple dan RED. Bagi Anda yang belum tahu, RED merupakan organisasi amal yang menggalang dana untuk konseling, riset, dan pengobatan pada HIV/AIDS. Jadi, setiap pembelian produk iPhone 7 Plus Red Edition berkontribusi untuk mencapai generasi bebas AIDS. Karena sebagian hasil penjualan produk ini akan disumbangkan ke RED.', 'p_1514479599_7740.jpg', '2017-12-28 00:00:00', 60),
(8, 1, 'Samsung Galaxy Note8 Smartphone - Midnight Black [B]', 12999000, 0, 'Samsung kembali mengguncang pasaran dunia dengan menghadirkan Samsung Galaxy Note 8 yang telah ditunggu-tunggu oleh para pencintanya. Samsung Galaxy Note 8 hadir dengan layar super AMOLED berukuran 6.3 inch yang beresolusi 2960x1440 pixels untuk membuat aktivitas mobile Anda semakin mudah di pandang mata. Bahkan menonton film favorit akan jauh lebih menyenangkan dengan aspek rasio Infinity Display 18.5 : 9. Dalam mode landscape pun,  Samsung Galaxy Note 8 menawarkan area tampilan 14% lebih besar untuk menjadikan pengalaman Anda lebih kaya dan mendalam.', 'p_1514479874_1790.jpg', '2017-12-28 00:00:00', 79),
(10, 1, 'Samsung Galaxy S8 Smartphone - Midnight Black [B]', 10176000, 0, 'Samsung Galaxy S8, Hadir dengan layar 5.8 Inch Quad HD+ Super AMOLED yang hampir tanpa sisi serta prosesor Octa-core (4x2.3 GHz &amp; 4x1.7 GHz) yang di dukung 4GB RAM dan 64GB memory internal. Dilengkapi juga dengan kamera depan Dual Pixel 12MP F1.7 &amp; belakang 8MP F1.7, WLAN, Bluetooth v5.0, GPS, NFC &amp; USB.', 'p_1514481010_4997.jpg', '2017-12-28 00:00:00', 90),
(11, 1, 'Xiaomi Mi Mix 2 Smartphone - Black [128GB/ 6GB]', 9199900, 0, 'Tahun 2017 ini Xiaomi banyak sekali memperkenalkan smartphone terbarunya, salah satunya yaitu Xiaomi Mi Mix 2 yang dirilis belum lama ini. Kehadirannya kali ini Xiaomi membekali ponsel terbarunya dengan sistem operasi Android 7.1 (Nougat). Untuk kinerja dapur pacunya Xiaomi Mi Mix 2 dipersenjatai dengan chipset baru yang lebih bertenaga. Selain didukung dengan kinerja chipset yang lebih baik, tentunya yang tak ketinggalan yaitu kamera. Berbekal kamera depan 5MP, dan kamera belakang 12MP maka bukan hanya hasil fotonya saja yang lebih bening, namun kualitas videonya pun mampu menghasilkan resolusi video yang lebih tinggi. ', 'p_1514481183_8596.jpg', '2017-12-28 00:00:00', 40),
(12, 5, 'Fantech K10 Hunter Backlight Pro USB Gaming Keyboard', 105000, 0, 'hadir dengan desain stylish yang dapat memenuhi kebutuhan dasar gaming dan multimedia Anda. Keyboard ini mempunyai tombol yang dioptimasi dan aksi cepat linier yang didesain untuk memaksimalkan kecepatan tombol tekan dan ergonomis sehingga Anda bisa bermain dan bekerja berjam-jam dengan nyaman. Keyboard ini secara ekstrim mempunyai daya tahan 5 juta klik dengan tambahan stand pada bagian belakang dan anti selip, dimana memberikan dudukan yang kokoh dan pergerakan yang tepat selama pemakaian.', 'p_1514516197_5936.jpg', '2017-12-29 00:00:00', 70);

-- --------------------------------------------------------

--
-- Table structure for table `MsReview`
--

CREATE TABLE `MsReview` (
  `ReviewID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Review` text NOT NULL,
  `ReviewDate` datetime NOT NULL,
  `ReviewStar` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MsReview`
--

INSERT INTO `MsReview` (`ReviewID`, `ProductID`, `UserID`, `Review`, `ReviewDate`, `ReviewStar`) VALUES
(1, 1, 4, 'Belanja pertama di DWSMarketplace dan puas! Sampe sebelum estimasi, 12 hari. Packing rapi, mouse berfungsi dengan baik. Kliknya gak ribut juga. Keren pokoknya.', '2017-12-22 16:13:00', 4),
(36, 1, 4, 'test', '2017-12-24 02:32:55', 2),
(37, 1, 4, 'yeahh', '2017-12-24 02:37:31', 5),
(38, 1, 4, 'yeah', '2017-12-24 12:41:15', 5),
(39, 2, 5, 'barangnya bagus', '2017-12-27 09:10:27', 5),
(40, 1, 5, 'Menarik', '2017-12-29 02:29:55', 5),
(41, 12, 5, 'Good', '2017-12-29 23:26:10', 5),
(42, 8, 5, '', '2018-01-02 09:45:49', 5),
(43, 11, 4, 'barangnya bagus.', '2018-01-03 04:55:29', 5),
(44, 11, 4, 'barang keluaran baru, sangat recommended', '2018-01-03 04:56:00', 4),
(45, 11, 4, 'test', '2018-01-03 10:01:17', 5),
(46, 11, 25, 'barangnya jelek :D', '2018-01-04 03:24:04', 1),
(47, 8, 4, 'barangnya sangat bagus, pengemasan nya sangat rapi.', '2018-01-15 03:54:35', 5);

-- --------------------------------------------------------

--
-- Table structure for table `MsUser`
--

CREATE TABLE `MsUser` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `UserEmail` varchar(150) NOT NULL,
  `UserPassword` varchar(50) NOT NULL,
  `UserPhone` varchar(20) NOT NULL,
  `UserAddress` text,
  `UserRole` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `MsUser`
--

INSERT INTO `MsUser` (`UserID`, `UserName`, `UserEmail`, `UserPassword`, `UserPhone`, `UserAddress`, `UserRole`, `created_at`, `updated_at`) VALUES
(5, 'Test', 'test@gmail.com', '2e3b95f861f9685e1734bb2c356831b7', '082234031070', NULL, 'Admin', '2017-12-15 07:21:28', '2017-12-15 07:21:28'),

-- --------------------------------------------------------

--
-- Table structure for table `TrDetail`
--

CREATE TABLE `TrDetail` (
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TrDetail`
--

INSERT INTO `TrDetail` (`OrderID`, `ProductID`, `Quantity`) VALUES
(30, 2, 2),
(30, 10, 1),
(30, 5, 2),
(30, 7, 6),
(31, 2, 1),
(32, 2, 2),
(33, 10, 1),
(33, 11, 1),
(33, 2, 1),
(34, 5, 1),
(34, 2, 2),
(35, 11, 1),
(35, 6, 1),
(36, 2, 1),
(37, 2, 1),
(38, 2, 4),
(39, 2, 10),
(40, 2, 2),
(41, 7, 2),
(41, 6, 1),
(42, 8, 1),
(42, 2, 1),
(43, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `TrHeader`
--

CREATE TABLE `TrHeader` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `TotalPrice` int(11) NOT NULL,
  `OrderStatus` enum('Pending','Sending','Delivery') NOT NULL DEFAULT 'Pending',
  `PaymentConfirmation` enum('not yet','waiting','confirmed') NOT NULL DEFAULT 'not yet',
  `PaymentSlipImage` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `TrHeader`
--

INSERT INTO `TrHeader` (`OrderID`, `UserID`, `TotalPrice`, `OrderStatus`, `PaymentConfirmation`, `PaymentSlipImage`, `created_at`, `updated_at`) VALUES
(30, 4, 156502000, 'Pending', 'not yet', '', '2018-01-08 19:24:58', '2018-01-08 19:24:58'),
(31, 4, 20240000, 'Pending', 'not yet', '', '2018-01-08 19:27:18', '2018-01-08 19:27:18'),
(32, 4, 40480000, 'Pending', 'confirmed', 'payment_slip_32_1516180736_9962.jpg', '2018-01-08 19:30:31', '2018-01-17 10:45:54'),
(33, 4, 39615900, 'Pending', 'not yet', '', '2018-01-08 19:55:17', '2018-01-08 19:55:17'),
(34, 4, 53803000, 'Pending', 'not yet', '', '2018-01-13 18:17:09', '2018-01-13 18:17:09'),
(35, 4, 27099900, 'Pending', 'not yet', '', '2018-01-14 19:25:01', '2018-01-14 19:25:01'),
(36, 4, 20240000, 'Pending', 'not yet', '', '2018-01-15 11:08:04', '2018-01-15 11:08:04'),
(37, 4, 20240000, 'Pending', 'not yet', '', '2018-01-17 10:32:30', '2018-01-17 10:32:30'),
(38, 4, 80960000, 'Pending', 'not yet', '', '2018-01-17 10:42:02', '2018-01-17 10:42:02'),
(39, 4, 202400000, 'Pending', 'not yet', '', '2018-01-18 06:24:53', '2018-01-18 06:24:53'),
(40, 4, 40480000, 'Pending', 'not yet', '', '2018-01-18 17:54:19', '2018-01-18 17:54:19'),
(41, 20, 44300000, 'Pending', 'not yet', '', '2018-01-20 10:12:06', '2018-01-20 10:12:06'),
(42, 4, 33239000, 'Pending', 'not yet', '', '2018-01-26 13:11:29', '2018-01-26 13:11:29'),
(43, 4, 20240000, 'Pending', 'not yet', '', '2018-01-27 01:28:39', '2018-01-27 01:28:39');

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewcategorycount`
-- (See below for the actual view)
--
CREATE TABLE `viewcategorycount` (
`CategoryID` int(11)
,`CategoryName` varchar(100)
,`ProductCount` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure for view `viewcategorycount`
--
DROP TABLE IF EXISTS `viewcategorycount`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewcategorycount`  AS  select `mscategory`.`CategoryID` AS `CategoryID`,`mscategory`.`CategoryName` AS `CategoryName`,count(`msproduct`.`ProductID`) AS `ProductCount` from (`mscategory` left join `msproduct` on((`msproduct`.`CategoryID` = `mscategory`.`CategoryID`))) group by `mscategory`.`CategoryID` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `APIs`
--
ALTER TABLE `APIs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `MsBank`
--
ALTER TABLE `MsBank`
  ADD PRIMARY KEY (`BankID`);

--
-- Indexes for table `MsCategory`
--
ALTER TABLE `MsCategory`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `MsDiscount`
--
ALTER TABLE `MsDiscount`
  ADD PRIMARY KEY (`DiscountID`);

--
-- Indexes for table `MsGallery`
--
ALTER TABLE `MsGallery`
  ADD PRIMARY KEY (`GalleryID`);

--
-- Indexes for table `MsProduct`
--
ALTER TABLE `MsProduct`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `MsReview`
--
ALTER TABLE `MsReview`
  ADD PRIMARY KEY (`ReviewID`);

--
-- Indexes for table `MsUser`
--
ALTER TABLE `MsUser`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `TrHeader`
--
ALTER TABLE `TrHeader`
  ADD PRIMARY KEY (`OrderID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `APIs`
--
ALTER TABLE `APIs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `MsBank`
--
ALTER TABLE `MsBank`
  MODIFY `BankID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `MsCategory`
--
ALTER TABLE `MsCategory`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `MsDiscount`
--
ALTER TABLE `MsDiscount`
  MODIFY `DiscountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `MsGallery`
--
ALTER TABLE `MsGallery`
  MODIFY `GalleryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `MsProduct`
--
ALTER TABLE `MsProduct`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `MsReview`
--
ALTER TABLE `MsReview`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `MsUser`
--
ALTER TABLE `MsUser`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `TrHeader`
--
ALTER TABLE `TrHeader`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
