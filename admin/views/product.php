<div class="panelTitle">Manage Product</div>
<div class="panel">
<form method="post" enctype="multipart/form-data">
<?php
if(isset($_GET['hapus'])){
	$id = $p->anti_injection($_GET['id']);

	$getSQLImage = $db->query("SELECT ProductImage FROM MsProduct WHERE ProductID = '".$id."'");
	$getImage = $getSQLImage->fetch_assoc();
	$uploadPath = '../assets/images/product/';

	unlink($uploadPath.$getImage['ProductImage']);
	unlink($uploadPath.'small_'.$getImage['ProductImage']);

	$sql = $db->query("DELETE FROM MsProduct WHERE ProductID = '".$id."'");
	$p->message('Data has been deleted');
	$p->redirect('product');
}

if(isset($_GET['edit'])){
	$id = $p->anti_injection($_GET['id']);
	$sql = $db->query("SELECT * FROM MsProduct WHERE ProductID = '$id'");
	$edit = mysqli_fetch_array($sql);
}

if(isset($_POST['simpan'])){
	$lokasifile 	= $_FILES['file_upload']['tmp_name'];
	$namafile 		= $_FILES['file_upload']['name'];
	$imageFileType 	= strtolower(pathinfo($namafile,PATHINFO_EXTENSION));
	$thumb_size		= 200;
	if($imageFileType != "jpg" && $imageFileType != "jpeg"){
		$p->message("Sorry, only JPG & JPEG files are allowed.");
	}else{

		$productImageName = 'p_'.@$location.time().'_'.rand(1000, 9999).".".$imageFileType;
		$data = array(
			'CategoryID'		=> $p->anti_injection($_POST['kategori']),
			'ProductName'		=> $p->anti_injection($_POST['nama_produk']), 
			'ProductPrice'		=> $p->anti_injection($_POST['harga']),
			'ProductWeight'		=> $p->anti_injection($_POST['berat']),
			'ProductDescription'=> $p->anti_injection($_POST['ket']),
			'ProductImage'		=> $p->anti_injection($productImageName),
			'DateIn'			=> date('Ymd'),
			'Stock'				=> $p->anti_injection((integer)$_POST['stok'])
		);

		$p->UploadImage($productImageName, "../assets/images/product/", $thumb_size);
		$p->save($db, $data,"MsProduct", "product");
	}
}

if(isset($_POST['update'])){
	$lokasifile 	= $_FILES['file_upload']['tmp_name'];
	$namafile 		= $_FILES['file_upload']['name'];
	$imageFileType 	= strtolower(pathinfo($namafile,PATHINFO_EXTENSION));
	
	$id = $p->anti_injection($_GET['id']);

	if($namafile == ""){

		$dataUpdate = array(
			'CategoryID'		=> $p->anti_injection($_POST['kategori']),
			'ProductName'		=> $p->anti_injection($_POST['nama_produk']), 
			'ProductPrice'		=> $p->anti_injection($_POST['harga']),
			'ProductWeight'		=> $p->anti_injection($_POST['berat']),
			'ProductDescription'=> $p->anti_injection($_POST['ket']),
			'DateIn'			=> date('Ymd'),
			'Stock'				=> $p->anti_injection((integer)$_POST['stok'])
		);

		$p->message("Data has been updated");	
		$p->update($db, $dataUpdate,"MsProduct","ProductID",$id, "product");
	}else{
		if($imageFileType != "jpg" && $imageFileType != "jpeg"){
			$p->message("Sorry, only JPG & JPEG files are allowed.");
		}else{
			$getSQLImage = $db->query("SELECT ProductImage FROM MsProduct WHERE ProductID = '".$id."'");
			$getImage = $getSQLImage->fetch_assoc();
			$uploadPath = '../assets/images/product/';
			$thumb_size = 200;
			unlink($uploadPath.$getImage['ProductImage']);
			unlink($uploadPath.'small_'.$getImage['ProductImage']);

			$productImageName = 'p_'.@$location.time().'_'.rand(1000, 9999).".".$imageFileType;
			$dataUpdate = array(
				'CategoryID'		=> $p->anti_injection($_POST['kategori']),
				'ProductName'		=> $p->anti_injection($_POST['nama_produk']), 
				'ProductPrice'		=> $p->anti_injection($_POST['harga']),
				'ProductWeight'		=> $p->anti_injection($_POST['berat']),
				'ProductDescription'=> $p->anti_injection($_POST['ket']),
				'ProductImage'		=> $p->anti_injection($productImageName),
				'DateIn'			=> date('Ymd'),
				'Stock'				=> $p->anti_injection((integer)$_POST['stok'])
			);
			
			$p->message("Data has been updated");
			$p->UploadImage($productImageName, $uploadPath, $thumb_size);;

			$p->update($db, $dataUpdate, "MsProduct", "ProductID", $id, "product");
		}
	}
}
?>    
    <table>
    	<tr>
        	<td width="200px">Product Name</td>
            <td>:</td>
            <td><input type="text" value="<?php echo @$edit['ProductName'] ?>" name="nama_produk" placeholder="Product Name" /></td>
        </tr>
		<tr>
        	<td>Category</td>
            <td>:</td>
            <td>
            <select name="kategori" style="width:520px;">
				<?php
					$kategori = mysqli_query($db, "SELECT * FROM MsCategory");
					while($tk = mysqli_fetch_array($kategori)){
				?>
            	<option value="<?php echo $tk[0] ?>"><?php echo $tk['CategoryName'] ?></option>
				<?php 
				}
				?>
            </select>
            
            </td>
        </tr>
        <tr>
        	<td>Price</td>
            <td>:</td>
            <td>
				<input type="text" value="<?php echo @$edit['ProductPrice']; ?>" name="harga" placeholder="Product Price" />
			</td>
        </tr>
		<tr>
        	<td>Weight</td>
            <td>:</td>
            <td><input type="text" value="<?php echo @$edit['ProductWeight']; ?>" name="berat" placeholder="Weight" /></td>
        </tr>
        <tr>
        	<td>Description</td>
            <td>:</td>
            <td><textarea name="ket"><?php echo @$edit['ProductDescription']; ?></textarea></td>
        </tr>
        <tr>
        	<td>Product Image</td>
            <td>:</td>
            <td>
				<input type="file" name="file_upload" />
				<p class="note">Only JPG &amp; JPEG files are allowed.</p>
			</td>
        </tr>
		<tr>
        	<td>Stock</td>
            <td>:</td>
            <td><input type="text" value="<?php echo @$edit['Stock'] ?>" name="stok" placeholder="Stock" /></td>
        </tr>
        <tr>
        	<td></td>
            <td></td>
            <td>
            <?php 
			if(@$_GET['id']){
			?>
				<button type="submit" name="update" class="btn-action"><i class="glyphicon glyphicon-pencil"></i> Update Data</button>
				<a href="product" class="btn-cancel">Cancel</a>
            <?php
			}else{
			?>
				<button type="submit" name="simpan" class="btn-action"><i class="glyphicon glyphicon-plus"></i> Add Product</button>
            <?php
			}
			?>
            </td>
        </tr>
    </table>
	<table class="table">
		<thead>
    	<tr>
        	<th>No.</th>
        	<th>Product Name</th>
            <th>Category</th>
            <th>Stock</th>
            <th>Price</th>
            <th colspan="2" colspan="2" align="center"></th>
		</tr>
		</thead>
		<tbody>
        <?php
		$batas = 5;
		$posisi = $p->get_position($batas);
		$sql = mysqli_query($db, "SELECT MsProduct .*, CategoryName FROM MsProduct
		INNER JOIN MsCategory ON MsCategory.CategoryID = MsProduct.CategoryID
		
		LIMIT $posisi, $batas
		");
		$jumlahdata = mysqli_num_rows(mysqli_query($db, "SELECT * FROM MsProduct "));
		$jumlahhalaman = $p->total_page($jumlahdata, $batas);
		$no = $posisi;
		while($r = mysqli_fetch_array($sql)){
		 
		 $no++;
		 ?>

        <tr>
        	<td><?php echo $no; ?></td>
        	<td><?php echo $r['ProductName']?></td>
        	<td><font color="#0066CC"><?php echo $r['CategoryName'] ?></font></td>
 			<td><?php echo $r['Stock']?></td>
            <td> <?php echo $p->num_format($r['ProductPrice'])?></td>
			<td align="center"><a href="<?php echo 'product.'.$r[0].'.edit' ?>"><i class="glyphicon glyphicon-edit"></i></a></td>
            <td align="center"><a onclick="return confirm('Are you sure?')" href="<?php echo 'delete-product-'.$r[0] ?>"><i class="glyphicon glyphicon-trash"></i></a></td>
        </tr>
        <?php
		}
		?>
		</tbody>
	</table>
	<div class="boxPagination">
	<?php
		$page = $p->anti_injection($_GET['page']);
		$p->pagination($jumlahhalaman, $page, "product.");
	?>
	</div>
</form>
</div>