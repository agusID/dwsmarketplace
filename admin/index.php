<?php
@session_start();
	include "../config/dbConfig.php";
	include "../controllers/MyController.php";
	$p = new MyController();

	if(@$_SESSION['role'] == 'Admin'){
		$p->redirect('home');
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Dwi Agustianto">
	<link rel="shorcut icon" href="../assets/images/pavicon.png" />
	<link rel="stylesheet" href="../assets/css/agus.css" />

	<title>DWSMarketplace | Login Administrator</title>

</head>

<body>

<div class="popup-wrapper">
	<div class="popup-container">
	
		<form method="post" class="popup-form">
			<div class="LoginImage">
				<img src="../assets/images/brand.png"/>	
			</div>
			<h3>Sign in </h3>
			<?php
			if(isset($_POST['login'])){
				$username = $_POST['txtEmail'];
				$password = md5($_POST['txtPassword']);
				$table = 'MsUser';
				$p->doLogin($db, $table, $username, $password, 'home', 'Admin');
			}
			?>
			<div class="input-group">
				<div class="col-input">
					<input type="text" autofocus="" class="txtEmail border-effect" required="required" name="txtEmail" placeholder="E-mail">
					<span class="border-focus"></span>
				</div>
                <div class="col-input">
					<input type="password" class="txtPassword border-effect" required="required" name="txtPassword" placeholder="Password">
					<span class="border-focus"></span>
				</div>
				<div>
				<button type="submit" name="login" class="btnPopUpLogin btnRipple">Sign in</button>
				</div>
			</div>
			<a class="popup-close" href="#">X</a>
		</form>
	</div>
</div>
</body>
</html>