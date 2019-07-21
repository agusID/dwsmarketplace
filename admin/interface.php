<?php
	session_start();
	include "../config/dbConfig.php";
	include "../controllers/MyController.php";
	$p = new MyController;
	// echo $_SESSION['role'];
	if(@$_SESSION['login'] == FALSE || @$_SESSION['role'] != 'Admin'){
		$p->redirect('login');
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Administrator Page</title>
	<link rel="shorcut icon" href="../assets/images/pavicon.png" />
	<link rel="stylesheet" href="../assets/css/glyphicon.css" />
	<link rel="stylesheet" href="css/admin.css" />
	<script src="../assets/js/jquery-3.2.1.min.js"></script>
	<script src="js/admin.js"></script>
	<link href="css/logo.css"/>
</head>

<body>

<nav>
	<ul>
		<li><a href=""><i class="glyphicon glyphicon-user"></i> Hi, <?php echo $_SESSION['username'] ?></a>
			<ul>
				<span class="arrow-top"></span>
				<span class="arrow"></span>
				<li><a href="logout">My Profile</a></li>
				<li><a href="logout" onclick="return confirm('Do you really want to log out?')">Sign Out</a></li>
			</ul>
		</li>
    	<li class="brandLogo">
			<a href="home">
				<img onmousedown="return false;" src="../assets/images/brand.png" />
			</a>
		</li>
    </ul>
</nav>
<div class="sidebar">
	<ul class="navSidebar">
		<li><a class="<?php echo $_GET['go'] == ''? 'active' : '' ?>" href="home"><i class="glyphicon glyphicon-home"></i> &nbsp;Dashboard</a></li>
		<li><a class="<?php echo $_GET['go'] == 'customer'? 'active' : '' ?>" href="customer"><i class="glyphicon glyphicon-user"></i> &nbsp;Customer</a></li>
		<li><a class="<?php echo $_GET['go'] == 'category'? 'active' : '' ?>" href="category"><i class="glyphicon glyphicon-list-alt"></i> &nbsp;Category</a></li>
        <li><a class="<?php echo $_GET['go'] == 'product'? 'active' : '' ?>" href="product"><i class="glyphicon glyphicon-gift"></i> &nbsp;Product</a></li>
		<li><a class="<?php echo $_GET['go'] == 'discount'? 'active' : '' ?>" href="discount"><i class="glyphicon glyphicon-thumbs-up"></i> &nbsp;Discount</a></li>
        <li><a class="<?php echo $_GET['go'] == 'order'? 'active' : '' ?>" href="order"><i class="glyphicon glyphicon-send"></i> &nbsp;Order</a></li>
        <li><a class="<?php echo $_GET['go'] == 'bank'? 'active' : '' ?>" href="bank"><i class="glyphicon glyphicon-briefcase"></i> &nbsp;Bank</a></li>
		<li><a class="<?php echo $_GET['go'] == 'slideshow'? 'active' : '' ?>" href="slideshow"><i class="glyphicon glyphicon-picture"></i> &nbsp;Slideshow</a></li>
		<li><a class="<?php echo $_GET['go'] == 'api'? 'active' : '' ?>" href="api"><i class="glyphicon glyphicon-fire"></i> &nbsp;APIs &amp; Services</a></li>
	</ul>
</div>
<div class="mainContent">
<div class="container">
<?php

	switch((isset($_GET['go']) ? $_GET['go'] : '')){
	
	default:
	include "views/dashboard.php";
	break;
  
  	case "category";
	include "views/category.php";
	break;

	case "bank";
	include "views/bank.php";
	break;

	case "product";
	include "views/product.php";
	break;
	
	case "order";
	include "views/order.php";
	break;
	
	case "customer";
	include "views/customer.php";
	break;
	
	case "order_detail";
	include "views/order_detail.php";
	break;

	case "slideshow";
	include "views/slideshow.php";
	break;

	case "discount";
	include "views/discount.php";
	break;

	case "api";
	include "views/api.php";
	break;

	case "logout";
	session_unset();
	session_destroy();
	
	$p->redirect('login');

	break;
	}
?>
</div>
</div>

</body>
</html>