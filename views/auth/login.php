<div class="popup-wrapper" id="login">
	<div class="popup-container">
	
		<form method="post" class="popup-form">
			<div class="LoginImage">
				<img src="assets/images/brand.png"/>	
			</div>
			<h3>Sign in </h3>
			<?php
			if(isset($_POST['login'])){
				$username = $_POST['txtEmail'];
				$password = md5($_POST['txtPassword']);
				$table = 'MsUser';
				$p->doLogin($db, $table, $username, $password, 'home', 'Customer');
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
				<a href="#register">
					<button type="button" class="btnPopUpCancel btnRipple">Join Free</button>
				</a>
				</div>
			</div>
			<a class="popup-close" href="#">X</a>
		</form>
	</div>
</div>