<div class="panelTitle">
	Manage Bank
</div>
<div class="panel">
<form method="post" enctype="multipart/form-data">
	<?php
    if(isset($_POST['save'])){
        $lokasifile 	= $_FILES['file_upload']['tmp_name'];
        $namafile 		= $_FILES['file_upload']['name'];
        $imageFileType 	= strtolower(pathinfo($namafile,PATHINFO_EXTENSION));
        $thumb_size		= 200;

        if($imageFileType != "jpg" && $imageFileType != "jpeg"){
            $p->message("Sorry, only JPG & JPEG files are allowed.");
        }else{
    
            $bankLogoName = 'bank_logo_'.@$location.time().'_'.rand(1000, 9999).".".$imageFileType;

            $data = array(
                'BankName'          => $p->anti_injection($_POST['txtBankName']),
                'BankBranchOffice'  => $p->anti_injection($_POST['txtBranch']),
                'BankAccountName'   => $p->anti_injection($_POST['txtAccountName']),
                'BankAccountNumber' => $p->anti_injection($_POST['txtAccountNumber']),
                'BankLogo'          => $bankLogoName
            );
            $p->UploadImage($bankLogoName, "../assets/images/bank/", $thumb_size);
            $p->save($db, $data, "MsBank", "bank");
        }
	}

	if(isset($_POST['update'])){
        $lokasifile 	= $_FILES['file_upload']['tmp_name'];
        $namafile 		= $_FILES['file_upload']['name'];
        $imageFileType 	= strtolower(pathinfo($namafile,PATHINFO_EXTENSION));
        
        $id = $p->anti_injection($_GET['id']);
    
        if($namafile == ""){
    
            $dataUpdate = array(
                'BankName'          => $p->anti_injection($_POST['txtBankName']),
                'BankBranchOffice'  => $p->anti_injection($_POST['txtBranch']),
                'BankAccountName'   => $p->anti_injection($_POST['txtAccountName']),
                'BankAccountNumber' => $p->anti_injection($_POST['txtAccountNumber'])
            );
    
            $p->message("Data has been updated");	
            $p->update($db, $dataUpdate,"MsBank","BankID",$id, "bank");
        }else{
            if($imageFileType != "jpg" && $imageFileType != "jpeg"){
                $p->message("Sorry, only JPG & JPEG files are allowed.");
            }else{
                $getSQLImage = $db->query("SELECT BankLogo FROM MsBank WHERE BankID = '".$id."'");
                $getImage = $getSQLImage->fetch_assoc();
                $uploadPath = '../assets/images/bank/';
                $thumb_size = 200;
                unlink($uploadPath.$getImage['BankLogo']);
                unlink($uploadPath.'small_'.$getImage['BankLogo']);
    
                $bankLogoName = 'bank_logo_'.@$location.time().'_'.rand(1000, 9999).".".$imageFileType;

                $dataUpdate = array(
                    'BankName'          => $p->anti_injection($_POST['txtBankName']),
                    'BankBranchOffice'  => $p->anti_injection($_POST['txtBranch']),
                    'BankAccountName'   => $p->anti_injection($_POST['txtAccountName']),
                    'BankAccountNumber' => $p->anti_injection($_POST['txtAccountNumber']),
                    'BankLogo'          => $bankLogoName
                );
                
                $p->message("Data has been updated");
                $p->UploadImage($bankLogoName, $uploadPath, $thumb_size);;
    
                $p->update($db, $dataUpdate, "MsBank", "BankID", $id, "bank");
            }
        }
	}

	if(isset($_GET['delete'])){
        $id = $p->anti_injection($_GET['id']);

        $getSQLImage = $db->query("SELECT BankLogo FROM MsBank WHERE BankID = '".$id."'");
        $getImage    = $getSQLImage->fetch_assoc();
        $uploadPath  = '../assets/images/bank/';
    
        unlink($uploadPath.$getImage['BankLogo']);
        unlink($uploadPath.'small_'.$getImage['BankLogo']);
    
        $sql = $db->query("DELETE FROM MsBank WHERE BankID = '".$id."'");
        $p->message('Data has been deleted');
        $p->redirect('bank');
	}
	if(isset($_GET['edit'])){
		$id = $p->anti_injection($_GET['id']);
		$sql = $db->query("SELECT * FROM MsBank WHERE BankID = '$id'");
		$edit = mysqli_fetch_array($sql);
	}
	
	?>
    <table>
    	<tr>
        	<td>Bank Name</td>
            <td><input type="text" value="<?php echo @$edit['BankName'] ?>" name="txtBankName"></td>
        </tr>
    	<tr>
        	<td>Branch</td>
            <td><input type="text" value="<?php echo @$edit['BankBranchOffice'] ?>" name="txtBranch"></td>
        </tr>
    	<tr>
        	<td>Account Name</td>
            <td><input type="text" value="<?php echo @$edit['BankAccountName'] ?>" name="txtAccountName"></td>
        </tr>
    	<tr>
        	<td>Account Number</td>
            <td><input type="text" value="<?php echo @$edit['BankAccountNumber'] ?>" name="txtAccountNumber"></td>
        </tr>
    	<tr>
        	<td>Bank Logo</td>
            <td>
                <input type="file" name="file_upload">
                <p class='note'>Only JPG &amp; JPEG files are allowed</p>
            </td>
        </tr>
        <tr>
        	<td></td>
            <td>
			<?php 
			if(@$_GET['id']){
			?>
			<button type="submit" name="update" class="btn-action"><i class="glyphicon glyphicon-pencil"></i> Update Data</button>
			<a href="bank" class="btn-cancel">Cancel</a>
			<?php
			}else{
			?>
			<button type="submit" name="save" class="btn-action"><i class="glyphicon glyphicon-plus"></i> Add bank</button>
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
				<th colspan="2">Bank Name</th>
                <th>Branch</th>
                <th>Account Name</th>
                <th>Account Number</th>
				<th colspan="2" align="center" ></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$batas = 5;
			$posisi = $p->get_position($batas);
			$sql = mysqli_query($db, "SELECT * FROM MsBank LIMIT $posisi, $batas");

			$no=$posisi;

			$jumlahdata = mysqli_num_rows(mysqli_query($db, "SELECT * FROM MsBank "));
			$jumlahhalaman = $p->total_page($jumlahdata, $batas);

			while($r = mysqli_fetch_array($sql)){
			
			$no++;
			?>
			<tr>
				<td align="right"><?php echo $no.'.'; ?></td>
                <td><img height="20px" src="<?php echo '../assets/images/bank/'.$r['BankLogo']; ; ?>"/></td>
				<td><?php echo $r['BankName']; ?></td>
                <td><?php echo $r['BankBranchOffice']; ?></td>
                <td><?php echo $r['BankAccountName']; ?></td>
                <td><?php echo $r['BankAccountNumber']; ?></td>
				<td width="20" align="center"><a href="<?php echo 'bank.'.$r[0].'.edit' ?>"><i class="glyphicon glyphicon-edit"></i></a></td>
				<td width="20" onclick="return confirm('Are you sure?')" align="center"><a href="delete-bank-<?php echo $r['BankID'] ?>"><i class="glyphicon glyphicon-trash"></i></a></td>
			</tr>
			<?php
			}
			?>
		</tbody>
    </table>
	<div class="boxPagination">
	<?php
		$page = $p->anti_injection($_GET['page']);
		$p->pagination($jumlahhalaman, $page, "bank.");
	?>
	</div>
</form>
</div>