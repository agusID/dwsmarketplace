<div class="popup-wrapper" style="" id="register">
	<div class="popup-container">
	
		<form method="post" class="popup-form">
            <?php
                if(isset($_POST['register'])){
                    $data = array(
                        'UserName' 		=> $p->anti_injection($_POST['txtUser']),
                        'UserEmail' 	=> $p->anti_injection($_POST['txtEmail']),
						'UserPassword' 	=> $p->anti_injection(md5($_POST['txtPassword'])),
						'UserPhone' 	=> $p->anti_injection($_POST['txtPhone']),
                        'UserRole' 		=> 'Customer'
                    );
                    $p->save($db, $data, 'MsUser' , 'home#login');
                }
            ?>
			<div class="LoginImage">
				<img src="assets/images/brand.png"/>	
			</div>
			<h3>Join Free</h3>
			
			<div class="input-group">
				<div class="col-input">
					<input type="text" autofocus="" class="txtUser border-effect" required="required" name="txtUser" placeholder="Full Name">
					<span class="border-focus"></span>
				</div>
				<div class="col-input">
					<input type="text" autofocus="" class="txtEmail border-effect" required="required" name="txtEmail" placeholder="E-mail">
					<span class="border-focus"></span>
				</div>
                <div class="col-input">
					<input type="tel" class="txtPhone border-effect" required="required" name="txtPhone" placeholder="Phone Number">
					<span class="border-focus"></span>
				</div>
                <div class="col-input">
					<input type="password" class="txtPassword border-effect" required="required" name="txtPassword" placeholder="Password">
					<span class="border-focus"></span>
				</div>

				<div>
				<div class="alreadyHaveAnAccount">
				Already have an account? Sign in <a href="#login">here</a>
				</div>

				<button type="submit" name="register" class="btnPopUpLogin btnRipple">Register Account</button>
				<p class="agreement">By clicking Register Account, I confirm I have agreed to Terms &amp; Condition, and Security Privacy of dwsmarketplace.</p>
				<!-- <button type="button" class="btnPopUpCancel btnRipple">C</button> -->
				</div>
			</div>
			<a class="popup-close" href="#">X</a>
		</form>
	</div>
</div>