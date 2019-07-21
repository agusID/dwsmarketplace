<div class="ProductDetail">
	<div class="ProductDetailContainer">
		<?php
		$id = $p->anti_injection(@$_GET['product_id']);
		$clean_url = $p->anti_injection(@$_GET['product_name']);
		// echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		$DiscountSQL = $db->query("SELECT DiscountID FROM MsDiscount WHERE ProductID = '".$id."' ");
		$checkDiscount = mysqli_num_rows($DiscountSQL);
		
		if($checkDiscount > 0){
			$sql = "SELECT MsProduct .*, CategoryName, Discount FROM MsProduct
			INNER JOIN MsCategory ON MsCategory.CategoryID = MsProduct.CategoryID
			INNER JOIN MsDiscount ON MsDiscount.ProductID = MsProduct.ProductID
			WHERE MsProduct.ProductID = '".$id."' ";
		}else{
			$sql = "SELECT MsProduct .*, CategoryName FROM MsProduct
			INNER JOIN MsCategory ON MsCategory.CategoryID = MsProduct.CategoryID
			WHERE MsProduct.ProductID = '".$id."' ";
		}

		$execSQL = $db->query($sql);
		$rows = $execSQL->fetch_assoc();
		if($clean_url != $p->cleanURL($rows['ProductName'])) 
			return die('Oops, Product Not Found');
		$sqlReview = "SELECT AVG(ReviewStar) as avg, COUNT(ReviewID) as reviewCount FROM MsReview WHERE ProductID = '".$id."'";
		$execReviewSQL = $db->query($sqlReview);
		$setReview = $execReviewSQL->fetch_assoc();
		?>
		<div class="detail_produk_wrapper">

			<div class="ProductDetailImage">
				<img src="assets/images/product/<?php echo $rows['ProductImage'] ?>">
			</div>

			<div class="detail_info">
				<div class="ProductDetailTitle"><?php echo $rows['ProductName'] ?></div>
				<div class="ProductDetailCategory"><a href=""><?php echo $rows['CategoryName'] ?></a></div>
				<table>
					<tr>
						<td>
						<span class="rating-back">
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
						</span>	
						<span class="rating">
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
							<i class="glyphicon glyphicon-star"></i>
						</span>
			
						<span class="resultReview"></span> 
						<span class="greyColor">
						
						<?php 
						if(empty($setReview['reviewCount'])){
							echo '(0)';
						}else{
							echo '('.$setReview['reviewCount'].')'; 
						}
						?></span>
						</td>
					</tr>
					<?php
					if($checkDiscount > 0){
					?>
					<tr>
						<?php $hargadiskon = $rows['ProductPrice'] - ($rows['ProductPrice']*($rows['Discount']/100));
							$potongan = $rows['ProductPrice']*($rows['Discount']/100);
						?>
						<td><div class="ProductDetailPrice"><?php echo $p->num_format($hargadiskon); ?></div></td>
					</tr>
					<tr>
						<td style="color:#555;">Price before <font style="text-decoration:line-through"><?php echo $p->num_format($rows['ProductPrice']) ?></font></td>
					</tr>
					<tr>
						<td><div class="ProductDetailDiscount"><?php echo 'Discount <strong>'.$rows['Discount'].'%<strong>' ?></div></td>
					</tr>
					<?php
					}else{
					?>
					<tr>
						<td><div class="ProductDetailPrice"><?php echo $p->num_format($rows['ProductPrice']) ?></div></td>
					</tr>
					<?php
					}
					?>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<?php
					if($rows['Stock'] == '0'){
					?>
					<tr>
						<td>Sold Out</td>
					</tr>
					<?php
					}
					?>
		
					<tr>
						<td>
						<a href="addToCart.<?php echo $rows["ProductID"]; ?>"><button type="button" class="btnCart btnRipple"><i class="glyphicon glyphicon-shopping-cart"></i>&nbsp;&nbsp;Add to Cart</button></a>	
						</td>
					</tr>

				</table>
			</div>

		</div>
		
	</div>
	<div class="ProductInfo">
		<div class="ProductDescription">
			<table>
				<tr>
					<td colspan="2">
						<div class="ProductDescriptionTitle">Description</div>
					</td>
				</tr>
				<tr>
					<td style="padding:10px; line-height:20px; color:#555; text-align:justify;" colspan="2">
						<?php echo $rows['ProductDescription'] ?>
					</td>
				</tr>
			</table>
		</div>
		<div class="ProductReview">
			<div class="ProductReviewTitle">Customer Reviews</div>
			<div class="ProductReviewInfo">
				<div class="">Average Rating: <?php echo number_format(($setReview['avg'] == '') ? 0 : $setReview['avg'], 1, '.', ''); ?></div>
				<div class="">Based on <?php echo "<strong>".$setReview['reviewCount']."</strong>" ?> Review(s)</div>
			</div>
			<?php
				$sqlReview = "SELECT MsReview .*, UserName, UserRole FROM MsReview 
				INNER JOIN MsUser ON MsUser.UserID = MsReview.UserID
				WHERE ProductID = '".$id."' 
				ORDER BY ReviewDate DESC
				";

				$execReview = $db->query($sqlReview);
			?>
			<div class="ReviewContainer">
				<div class="ReviewListItem">
				<?php 
				if($execReview->num_rows > 0){
					while($rReview = $execReview->fetch_assoc()){ 
				?>
					<div class="ReviewItem">
						<div class="ReviewHeader">
							<div class="ReviewRating">
								<span class="ReviewStar">
									<?php 
									for($i = 0; $i < 5; $i++){
										if($i < $rReview['ReviewStar']) echo '<i class="glyphicon glyphicon-star enable"></i>';
										else echo '<i class="glyphicon glyphicon-star disable"></i>';
									}
									?>
								</span>	
							</div><div class="ReviewDate"> 
								<?php 
									$date = new DateTime($rReview['ReviewDate']);
									echo $date->format('F d Y, h:i'); 
								?> 
							</div>
							<div class="ReviewBy">
								<?php echo 'By '.$rReview['UserName']; ?> <span class="<?php echo $rReview['UserRole'] == 'Admin'? 'ReviewRoleAdmin':'ReviewRole';?>"><?php echo $rReview['UserRole']; ?></span>
							</div>
						</div>
						<div class="ReviewText"><?php echo $rReview['Review']; ?></div>
					</div> <!-- end ReviewItem-->
				<?php 
					}
				}else echo 'Review(s) not found.'; 

				?>
				</div> <!-- end ReviewListItem-->
					<div class="ReviewBox">
						<form method="post">
							<?php
							if(isset($_POST['giveReview'])){

								if($_POST['cmbStar'] > 5) $p->message('Oops!, Star lu kebanyakan bro');
								else if($_POST['cmbStar'] == 1 || $_POST['cmbStar'] == 2 || $_POST['cmbStar'] == 3 || $_POST['cmbStar'] == 4 || $_POST['cmbStar'] == 5){
									$data = array(
										'ProductID' => $id,
										'UserID' => $_SESSION['userID'],
										'Review' => $p->anti_injection($_POST['txtReview']),
										'ReviewDate' => date("Y-m-d H:i:s"),
										'ReviewStar' => $p->anti_injection($_POST['cmbStar'])
									);
									$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
									$p->save($db, $data, 'MsReview' , '');
									echo "<script>document.location.href='".$actual_link."'</script>";
								}	
							}
							?>
							<?php if(isset($_SESSION['login']) && $_SESSION['login'] == TRUE){ ?>
							<div class="GiveReviewTitle">Give your review :</div>
							<textarea name="txtReview" class="txtReview"></textarea>

							<button type="submit" class="btnReview" name="giveReview">Give Review</button>
							<div class="cmbBoxStar">
								<select name="cmbStar" class="cmbStar">
									<option value="5">5 Stars</option>
									<option value="4">4 Stars</option>
									<option value="3">3 Stars</option>
									<option value="2">2 Stars</option>
									<option value="1">1 Star</option>
								</select>
							</div>
							<?php } ?>
						</form>
					</div> <!-- end ReviewBox-->

			</div>
		</div> <!-- end ProductReview-->
	</div> <!-- end ProductInfo-->
</div>

<script>
function setReviewRating(container, value) {
	var floor = Math.floor(value),
  	ceil = Math.ceil(value),
  	star = container.children[floor],
    slice = Array.prototype.slice,
    children = slice.call(container.children),
    visible = slice.call(children, 0, ceil),
    hidden = slice.call(children, ceil),
  	size,
    width,
    portion;
  
  visible.forEach(function(star) {
  	star.style.visibility = 'visible';
  	star.style.width = '';
  });
  hidden.forEach(function(star) {
  	star.style.visibility = 'hidden';
  	star.style.width = '';
  });

  size = star && star.getBoundingClientRect();
  width = size && size.width;
  portion = value - floor;

  if (star && portion !== 0)
  	star.style.width = (width * portion) + 'px';
}

var check = <?php echo ($setReview['avg'] == '') ? 0 : $setReview['avg']; ?>, 
debug = document.querySelector('.resultReview');
debug.appendChild(document.createTextNode(''));

debug.firstChild.nodeValue = check.toFixed(1);
setReviewRating(document.querySelector('.rating'), check);

</script>