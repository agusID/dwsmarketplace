<div class="panelTitle">Manage Order</div>
<div class="panel">
	<form method="post">
	<?php
	if(isset($_GET['approve'])){
		$id = $p->anti_injection($_GET['id']);
		$dataUpdate = array(
			'PaymentConfirmation' => 'confirmed',
			'updated_at'		  => date('Y-m-d h:i:s')
		);
		$p->message("Order number ".$id." has been successfully confirmed");
		$p->update($db, $dataUpdate, "TrHeader", "OrderID", $id, "order");
	}

	if(isset($_GET['hapus'])){
		$id = $p->anti_injection($_GET['id']);
		
		$getSQL = $db->query("SELECT PaymentSlipImage FROM TrHeader WHERE OrderID = '".$id."'");
        $r_data_conf = $getSQL->fetch_assoc();

		$uploadPath = '../assets/images/payment_slip/';

		if($r_data_conf['PaymentSlipImage'] != ''){
			unlink($uploadPath.$r_data_conf['PaymentSlipImage']);
			unlink($uploadPath.'small_'.$r_data_conf['PaymentSlipImage']);
		}

		$db->query("DELETE FROM TrHeader WHERE OrderID ='".$id."' ");
		$db->query("DELETE FROM TrDetail WHERE OrderID ='".$id."' ");
		$p->message("Order number ".$id." has been successfully deleted");
		$p->redirect('order');
	}

	?>
    <table class="table">
		<thead>
    	<tr>
        	<th>No.</th>
        	<th>Order ID</th>
            <th>Customer Name</th>
            <th>Date Order</th>
            <th>Total Price</th>
			<th>Order Status</th>
			<th align="center">Payment Confirmation</th>
            <th align="center"></th>
        </tr>
		</thead>
		<tbody>
        <?php
		$batas = 10;
		$posisi = $p->get_position($batas);
		
		$sql = $db->query("SELECT TrHeader .*, UserName FROM TrHeader
		INNER JOIN MsUser ON MsUser.UserID = TrHeader.UserID
		LIMIT $posisi, $batas
		");
		$jumlahdata = mysqli_num_rows(mysqli_query($db, "SELECT * FROM TrHeader"));
		$jumlahhalaman = $p->total_page($jumlahdata, $batas);
		$no = $posisi;
		if($jumlahdata > 0){
		while($r = mysqli_fetch_array($sql)){
		
		 $no++;
		 ?>
        <tr>
        	<td><?php echo $no; ?></td>
        	<td><?php echo $r['OrderID']?></td>
        	<td><font color="#0066CC"><?php echo $r['UserName'] ?></font></td>
			<td>
				<?php 
				$date = new DateTime($r['created_at']);
				echo $date->format('F d, Y').'<br> at '.$date->format('h:i'); 
				?>
			</td>
            
            <td><?php echo $p->num_format($r['TotalPrice'])?></td>
			<td><?php echo $r['OrderStatus'] ?></td>
			<td align="center"><?php echo $r['PaymentConfirmation'] == 'waiting' ? 'waiting for approval' : $r['PaymentConfirmation']; ?></td>
			<td align="center"><span class="toggle btnView">View Details</span> <span class="separator"></span> <a onclick="return confirm('Are you sure?')" class="btnRemove" href="delete-order-<?php echo $r[0] ?>"><i class="glyphicon glyphicon-trash"></i></a></td>
        </tr>
		<tr class="tableOrderDetail hide">
			<td colspan='8'>
				<table>
					<thead>
						<tr>
							<th colspan="4">Order Details</th>
						</tr>
						<tr>
							<th>Product Name</th>
							<th>Product Price</th>
							<th align="center">Quantity</th>
							<th>Sub Total</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sqlDetailOrder = $db->query("SELECT TrDetail .*, ProductName, ProductPrice FROM TrDetail 
						INNER JOIN MsProduct ON MsProduct.ProductID = TrDetail.ProductID
						WHERE OrderID = '".$r['OrderID']."' ");
						while($rDetail = mysqli_fetch_array($sqlDetailOrder)){
						?>
						<tr>
							<td><?php echo $rDetail['ProductName']; ?></td>
							<td><?php echo $p->num_format($rDetail['ProductPrice']); ?></td>
							<td align="center"><?php echo $rDetail['Quantity']; ?></td>
							<td><?php echo $p->num_format($rDetail['ProductPrice']*$rDetail['Quantity']); ?></td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
				<?php
				if($r['PaymentConfirmation'] == 'waiting'){
				?>
				<table>
					<tr>
						<td><strong>Payment Slip</strong></td>
					</tr>
					<tr>
						<td><img width="300px" src="<?php echo '../assets/images/payment_slip/'.$r['PaymentSlipImage']; ?>"/></td>
					</tr>

					<tr>
						<td><a href="approve-<?php echo $r[0]; ?>" class="btn-action" style="margin-left: 0px"><i class="glyphicon glyphicon-ok"></i> Approve</a></td>
					</tr>

				</table>
				<?php
				}
				?>
			</td>
		</tr>
        <?php
		}
	}else{
		?>
		<tr>
			<td colspan="7">Data is empty</td>
		</tr>
		<?php
	}
		?>
		</tbody>
    </table>
	<div class="boxPagination">
	<?php
		$page = $p->anti_injection($_GET['page']);
		$p->pagination($jumlahhalaman, $page, "order.");
	?>
	</div>
	</form>
</div>
