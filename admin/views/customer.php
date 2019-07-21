<div class="panelTitle">Manage Customer</div>
<div class="panel">
<form method="post" enctype="multipart/form-data">

<?php
$batas = 5;
$posisi = $p->get_position($batas);
$sql = $db->query("SELECT * FROM MsUser WHERE UserRole = 'Customer' LIMIT $posisi, $batas
");
$jumlahdata = mysqli_num_rows(mysqli_query($db, "SELECT * FROM MsUser WHERE UserRole = 'Customer' "));
$jumlahhalaman = $p->total_page($jumlahdata, $batas);
$no = $posisi;
        
if(isset($_GET['hapus'])){

	$id = $p->anti_injection($_GET['id']);
	$sql = $db->query("DELETE FROM MsUser WHERE UserID = '".$id."' AND UserRole = 'Customer' ");
	$p->message('User has been deleted');
	$p->redirect('customer');
}

?>    
    <h4 class="title">Number of customer(s) : <?php echo $jumlahdata; ?></h4>
	<table class="table" style="margin: 0">
		<thead>
    	<tr>
        	<th>No.</th>
        	<th>Name</th>
            <th>E-mail</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Join date</th>
            <th align="center"></th>
		</tr>
		</thead>
		<tbody>
        <?php

		while($r = mysqli_fetch_array($sql)){
		 
		 $no++;
		 ?>

        <tr>
        	<td><?php echo $no; ?></td>
        	<td><?php echo $r['UserName']; ?></td>
        	<td><font color="#0066CC"><?php echo $r['UserEmail']; ?></font></td>
 			<td><?php echo $r['UserPhone']; ?></td>
            <td><?php echo substr($r['UserAddress'], 0, 50).'...'; ?></td>
            <td>
            <?php 
                $date = new DateTime($r['created_at']);
				echo $date->format('F d Y,').' '.$date->format('h:i');  ?>
            </td>
            
            <td align="center"><a onclick="return confirm('Are you sure?')" href="<?php echo 'delete-customer-'.$r[0] ?>"><i class="glyphicon glyphicon-trash"></i></a></td>
        </tr>
        <?php
		}
		?>
		</tbody>
	</table>
	<div class="boxPagination">
	<?php
		$page = $p->anti_injection($_GET['page']);
		$p->pagination($jumlahhalaman, $page, "customer.");
	?>
	</div>
</form>
</div>