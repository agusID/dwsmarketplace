<div class="Order">
    <div class="OrderTitle">My Order</div>	

	    <?php
		$sql = $db->query("SELECT TrHeader .*, UserName FROM TrHeader
		INNER JOIN MsUser ON MsUser.UserID = TrHeader.UserID
        WHERE MsUser.UserID = '".$_SESSION['userID']."'
		");
		$no = 0;
		while($r = mysqli_fetch_array($sql)){
		
		 ?>
		<table class="table OrderList">
			<thead>
				<tr>
					<th><div class="">Order ID : <?php echo $r['OrderID']?></div></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="OrderContent">
						Transaction Date : <?php 
						$date = new DateTime($r['created_at']);
						echo "<span>".$date->format('F d, Y').', '.$date->format('h:i')."</span>"; 
						?> - <?php echo $r['OrderStatus'] ?><br>Total : <?php echo "<span class='PriceColor'>".$p->num_format($r['TotalPrice'])."</span>";?>
						</div> 
					</td>
				</tr>
				<tr>
					<td>
						<?php 
						if($r['PaymentConfirmation'] == 'not yet'){
						?>
							<a onclick="return confirm('Are you sure?')" 
							class="btnCancelOrder" href="<?php echo $r[0] ?>">
						Cancel Order</a>
							<a href="payment-confirmation-<?php echo $r[0]; ?>" 
								class="btnConfirmOrder">Confirm</a>
							
						<?php
						}else if($r['PaymentConfirmation'] == 'waiting'){
						?>
							<a onclick="return confirm('Are you sure?')" 
							class="btnCancelOrder" href="<?php echo $r[0] ?>">
						Cancel Order</a>
							<a class="btnWaitingOrder" href="#">Waiting for approval</a>
							
						<?php
						}else{
						?>
							<a class="btnConfirmedOrder" href="#">Confirmed</a>
						<?php
						}
						?>

					</td>
				</tr>
				<tr>
					<td>
						<button class="toggle btnView">View Details <i class="glyphicon glyphicon-chevron-down"></i></button>
					</td>
				</tr>
				<tr class="tableOrderDetail hide">
					<td>
						<table>
							<thead>
								<tr>
									<th colspan="4">List Product</th>
								</tr>
								<tr>
									<th colspan="2">Product</th>
									<th>Sub Total</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$sqlDetailOrder = $db->query("SELECT TrDetail .*, ProductImage,ProductName, ProductPrice FROM TrDetail 
								INNER JOIN MsProduct ON MsProduct.ProductID = TrDetail.ProductID
								WHERE OrderID = '".$r['OrderID']."' ");
								while($rDetail = mysqli_fetch_array($sqlDetailOrder)){
								?>
								<tr>
									<td width="50px"><img width="50px" src="assets/images/product/small_<?php echo $rDetail['ProductImage']; ?>"></td>
									<td>
										<?php echo '<strong>'.$rDetail['ProductName'].'</strong>'; ?><br>
										<?php echo '('.$p->num_format($rDetail['ProductPrice']); ?> x <?php echo $rDetail['Quantity'].')'; ?>
									</td>
									<td><?php echo $p->num_format($rDetail['ProductPrice']*$rDetail['Quantity']); ?></td>
								</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
    	</table>
        <?php
		}
		?>
</div>