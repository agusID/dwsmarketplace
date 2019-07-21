<div class="panelTitle">
	Manage Category
</div>
<div class="panel">
<form method="post">
	<?php
    if(isset($_POST['save'])){
		if(empty($_POST['txtCategory'])){
			$p->message("Date can't empty");
			$p->redirect("category");	
		}else{

			$data = array(
				'CategoryName' => $p->anti_injection($_POST['txtCategory'])
			);
			$p->save($db, $data, "MsCategory", "category");
		}
	}

	if(isset($_POST['update'])){
		$id = $p->anti_injection($_GET['id']);
		$data = array(
			'CategoryName' => $p->anti_injection($_POST['txtCategory'])
		);
		$p->update($db, $data, "MsCategory", "CategoryID", $id, "category");
	}

	if(isset($_GET['delete'])){
		$id = $p->anti_injection($_GET['id']);
		$sql = "DELETE FROM MsCategory WHERE CategoryID = '".$id."'";
		$db->query($sql);
		$p->message('Data has been deleted');
		$p->redirect('category');
	}

	if(isset($_GET['edit'])){
		$id = $p->anti_injection($_GET['id']);
		$sql = $db->query("SELECT * FROM MsCategory WHERE CategoryID = '$id'");
		$edit = mysqli_fetch_array($sql);
	}
	
	?>
    <table>
    	<tr>
        	<td>Category Name</td>
            <td><input type="text" value="<?php echo @$edit['CategoryName'] ?>" required name="txtCategory"></td>
        </tr>
        <tr>
        	<td></td>
            <td>
			<?php 
			if(@$_GET['id']){
			?>
			<button type="submit" name="update" class="btn-action"><i class="glyphicon glyphicon-pencil"></i> Update Data</button>
			<a href="category" class="btn-cancel">Cancel</a>
			<?php
			}else{
			?>
			<button type="submit" name="save" class="btn-action"><i class="glyphicon glyphicon-plus"></i> Add Category</button>
			<?php
			}
			?>
			</td>
        </tr>
    </table>
    <table class='table'>
		<thead>
			<tr>
				<th width="20">No.</th>
				<th>Category Name</th>
				<th colspan="2" align="center" ></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$batas = 5;
			$posisi = $p->get_position($batas);
			$sql = mysqli_query($db, "SELECT * FROM MsCategory LIMIT $posisi, $batas");

			$no=$posisi;

			$jumlahdata = mysqli_num_rows(mysqli_query($db, "SELECT * FROM MsCategory "));
			$jumlahhalaman = $p->total_page($jumlahdata, $batas);

			while($r = mysqli_fetch_array($sql)){
			
			$no++;
			?>
			<tr>
				<td align="right"><?php echo $no.'.'; ?></td>
				<td><?php echo $r['CategoryName'] ?></td>
				<td width="20" align="center"><a href="<?php echo 'category.'.$r[0].'.edit' ?>"><i class="glyphicon glyphicon-edit"></i></a></td>
				<td width="20" align="center"><a onclick="return confirm('Are you sure?')" href="delete-category-<?php echo $r[0]; ?>"><i class="glyphicon glyphicon-trash"></i></a></td>
			</tr>
			<?php
			}
			?>
		</tbody>
    </table>
	<div class="boxPagination">
	<?php
		$page = $p->anti_injection($_GET['page']);
		$p->pagination($jumlahhalaman, $page, "category.");
	?>
	</div>
</form>
</div>