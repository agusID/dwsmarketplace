<header>
        <div class="wrapper">
			<div class="SearchContainer">
            <form method="post">
				<div class="brandLogo">
					<a href="home">
					<img onmousedown="return false;" src="assets/images/brand.png" height="40px" />
					</a>
				</div>
				<div class="searchBox">
					<i class="search_icon"></i>
					<input type="text" class="txtSearch" title="Pencarian" required="required" placeholder="What are you looking for..." name="pencarian" />
					<span class="CategoryBox"><select name="kategori" class="cmbSearch">
					<option value="">All Categories</option>
					<?php 
					$sql_category = "SELECT * FROM MsCategory";
					$query_category = $db->query($sql_category);
					
					while($row_category = $query_category->fetch_assoc()){
					?>
					<option value="<?php echo $row_category['CategoryID'] ?>"><?php echo $row_category['CategoryName']; ?></option>
					<?php 
					} 
					?>
				</select></span>
				</div><input type="submit" name="txtSearch" class="btnSearch" value="Search" />
				<div class="cart">
					<a href="cart">
					<div class="cartImage">
						<span class="cartItem"><?php echo $cart->total_items() ?></span>
					</div>
					<div class="cartLabel">Cart</div>
					</a>

					<div class="cartList">
						<div class="header">Your Shopping Cart</div>
						<ul>
							<?php 
							if($cart->total_items() > 0){
							?>
								<li>
									<table>
										<?php 
										$cartItems = $cart->contents();
										foreach($cartItems as $item){ 
										?>
										<tr>
											<td>
												<img class="ProductCartImage" src="assets/images/product/small_<?php echo $item["image"]; ?>" />
											</td>
											<td>
												<div class="ProductCartName"><?php echo $item['name'] ?> <span class="primaryColor">(<?php echo $item["qty"].' items'; ?>)</span></div>
											</td>
										</tr>
										<?php } ?>
									</table>
								</li>
								<li><div class="TotalItem">Total items in cart <span class="right"><?php echo $cart->total_items() ?> Item(s)</span></div></li>
								<li><div class="TotalPrice">Total Price <span class="right"><?php echo $p->num_format($cart->total()); ?></span></div></li>
								<li><a class="btnViewCart btnRipple" href="cart">VIEW SHOPPING CART</a></li>	
								<li><a class="btnCheckOutCart btnRipple" href="checkout">CHECKOUT</a></li>
							<?php

							 }else{
								echo '<li><div class="center">There are no items in your cart.</div></li>';
							 }
							  ?>
						</ul>
					</div>
				</div>
				<?php if(isset($_SESSION['login']) && $_SESSION['login'] == TRUE && $_SESSION['role'] == 'Customer'){ ?>
				<div class="Profile">
					<div class="ProfilePicture">
						<img src="https://lh3.googleusercontent.com/-snVi9ddhxGQ/AAAAAAAAAAI/AAAAAAAAAAA/AA6ZPT5Wo8CjFOQlvpcFPY-tdX7nbJW-bA/s64-c-mo/photo.jpg"/>
					</div>
					<ul class="ProfileMenu">
						<li>
							<a href="#">
								<div class="MyProfileLabel">My Profile</div>	
								<div class="ProfileName"><?php echo '<strong>'.$_SESSION['username'].'</strong>' ?></div>
							</a>
						</li>
						<li><a href="my-order">My Order</a></li>
						<li>					
							<?php
							if(isset($_POST['logout'])){
								$p->doLogout();
							}
							?>
							<a href="logout" onclick="return confirm('Are you sure?')" name="logout">Sign Out</a>
						</li>
					</ul>
				</div>
				<?php }else{ ?>
					<div class="auth">
						<a href="#login" id="btnLogin">Sign In</a><a href="#register" id="btnRegister">Join Free</a></a>
					</div>
				<?php } ?>
            </form>
			</div>
             
        <nav>
        	<ul>
            	<!-- <input type="checkbox" id="nav-switcher" class="switchbox">
			<label class="switch" for="nav-switcher">Menu</label> -->
				<li>
					<a  href="index.php" class="categoryMenu">Categories</a>
					<ul class="categoryList">
						<?php 
						$sql_mi_category = "SELECT * FROM ViewCategoryCount";
						$query_mi_category = mysqli_query($db, $sql_mi_category);
						
						while($row_mi_category = mysqli_fetch_array($query_mi_category)){
						?>
						<li><a href="produk"><?php echo $row_mi_category[1].' ('.$row_mi_category['ProductCount'].')' ?></a></li>
						<?php
						}
						?>
					</ul>	
				</li>
				<?php 
				$sql_m_category = "SELECT * FROM ViewCategoryCount WHERE ProductCount > 0 ORDER BY RAND() LIMIT 4";
				$query_m_category = mysqli_query($db, $sql_m_category);
				
				while($row_m_category = mysqli_fetch_array($query_m_category)){
				?>
            	
				<li><a href="produk"><?php echo $row_m_category[1] ?></a></li>
				<?php
				}
				?>
            </ul>
        </nav>
        </div>
    </header>