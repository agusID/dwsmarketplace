<?php

	require_once "config/dbConfig.php";
	include "controllers/MyController.php";
	include "controllers/Cart.php";
	
	$p = new MyController;
	$cart = new Cart;
?>
<!DOCTYPE html>
<html>
<head>

	<title>Belanja Online Aman, Nyaman, Terpercaya | DWSMarketplace</title>
	<meta name="robots" content="noindex">
	<link rel="shorcut icon" href="assets/images/pavicon.png" />
	<link rel="stylesheet" href="assets/css/agus.css" />
	<link rel="stylesheet" href="assets/css/glyphicon.css" />
	
	<script src="assets/js/jquery-3.2.1.min.js"></script>
	<script src="assets/js/august.js"></script>

</head>

<body>

<?php
	// POP UP
	include "views/auth/login.php";
	include "views/auth/register.php";
?>
<div class="headerContainer">
<?php
	include "views/header/navigation.php";
?>
</div>
<div class="container">
<div class="wrapper">
	<div class="kotak">
<?php
	switch((isset($_GET['view']) ? $_GET['view'] : '')){
	default:
	include 'views/interface.php';
	break;
	
	// case "produk";
	// include "mod/mod_produk.php";
	// break;
	
	case 'product_detail';
	include 'views/product/product_detail.php';
	break;

	case 'my_order';
	if(isset($_SESSION['login']) && $_SESSION['login'] == TRUE && $_SESSION['role'] == 'Customer'){
		include 'views/my_order.php';
	}else{
		include 'views/auth/notAuthorized.php';
	}
	
	break;
	
	case 'cart';
	include 'views/viewCart.php';
	break;
	
	case 'checkout';

	if(isset($_SESSION['login']) && $_SESSION['login'] == TRUE && $_SESSION['role'] == 'Customer'){
		include 'views/checkout.php';
	}else{
		include 'views/auth/notAuthorized.php';
	}

	break;
	
	case "payment_confirmation";

	if(isset($_SESSION['login']) && $_SESSION['login'] == TRUE && $_SESSION['role'] == 'Customer'){
		include "views/payment_confirmation.php";
	}else{
		include 'views/auth/notAuthorized.php';
	}

	break;
	
	case 'logout';
	$p->doLogout();
	//include "views/logout.php";
	break;
	
	}
?>
	</div>
    </div>
</div>
<?php
	include "views/footer/footer.php";
?>
</body>
</html>	