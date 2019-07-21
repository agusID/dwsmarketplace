
<div class="panelTitle">
	Slideshow
</div>
<div class="panel">
<form method="post" enctype="multipart/form-data">
	<?php
    if(isset($_POST['save'])){        

        $lokasifile 	= $_FILES['file_upload']['tmp_name'];
        $namafile 		= $_FILES['file_upload']['name'];
        $imageFileType 	= strtolower(pathinfo($namafile,PATHINFO_EXTENSION));

        if( $_POST['section'] == 'right top' || 
            $_POST['section'] == 'right bottom') 
            
            $thumb_size  = 350;
        else 
            $thumb_size = 800;

        if($imageFileType != "jpg" && $imageFileType != "jpeg"){
            $p->message("Sorry, only JPG, JPEG files are allowed.");
        }else{
    
            $productImageName = 'slide_'.@$location.time().'_'.rand(1000, 9999).".".$imageFileType;

            $data = array(
                'GalleryTitle'      => $p->anti_injection($_POST['txtTitle']),
                'GallerySection'    => $p->anti_injection($_POST['section']),
                'GalleryImage'      => $p->anti_injection($productImageName)
            );
            
            $p->UploadImage($productImageName, "../assets/images/slider/", $thumb_size);
            $p->save($db, $data, "MsGallery", "slideshow");
        }
	}

	if(isset($_GET['delete'])){
        $id = $p->anti_injection($_GET['id']);

        $getSQLImage = $db->query("SELECT GalleryImage FROM MsGallery WHERE GalleryID = '".$id."'");
        $getImage = $getSQLImage->fetch_assoc();
        $uploadPath = '../assets/images/slider/';
        echo $getImage['GalleryImage'];
        
        unlink($uploadPath.$getImage['GalleryImage']);
        unlink($uploadPath.'small_'.$getImage['GalleryImage']);

		$sql = "DELETE FROM MsGallery WHERE GalleryID = '".$id."'";
		$db->query($sql);
		$p->message('Data has been deleted');
		$p->redirect('slideshow');
	}

	?>
    <table>
    	<tr>
        	<td>Slider Name</td>
            <td><input type="text" name="txtTitle" required></td>
        </tr>
    	<tr>
        	<td>Upload Image</td>
            <td>
                <input type="file" name="file_upload" required />
                <p class="note">Only JPG &amp; JPEG files are allowed.</p>
            </td>
        </tr>
    	<tr>
        	<td>Section</td>
            <td>
                <select name="section" style="width: 200px">
                    <option value="main">Main Slider</option>
                    <option value="right top">Right Top Slider</option>
                    <option value="right bottom">Right Bottom Slider</option>
                </select>
            </td>
        </tr>
        <tr>
        	<td></td>
            <td>
			<button type="submit" name="save" class="btn-action"><i class="glyphicon glyphicon-plus"></i> Add Slider</button>
			</td>
        </tr>
    </table>
    <table class='table'>
		<thead>
			<tr>
				<th width="20">No.</th>
				<th>Title</th>
                <th>Image</th>
                <th>Section</th>
				<th align="center" ></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$batas = 5;
            $posisi = $p->get_position($batas);
            $pathGallery = '../assets/images/slider/';
			$sql = mysqli_query($db, "SELECT * FROM MsGallery LIMIT $posisi, $batas");
			$no = $posisi;

			$jumlahdata = mysqli_num_rows(mysqli_query($db, "SELECT * FROM MsGallery "));
			$jumlahhalaman = $p->total_page($jumlahdata, $batas);

			while($r = mysqli_fetch_array($sql)){
			
			$no++;
			?>
			<tr>
				<td align="right"><?php echo $no.'.'; ?></td>
				<td><?php echo $r['GalleryTitle'] ?></td>
                <td><img width="300px" height="158px" src="<?php echo $pathGallery.$r['GalleryImage']; ?>" /></td>
                <td>
                    <div class="slider_section">
                        <span class="main <?php echo $r['GallerySection'] == 'main' ? 'active' : ''  ?>">&nbsp;</span>
                        <span class="right_top <?php echo $r['GallerySection'] == 'right top' ? 'active' : ''  ?>"></span>
                        <span class="right_bottom <?php echo $r['GallerySection'] == 'right bottom' ? 'active' : ''  ?>"></span>
                    </div>
                </td>
				<td width="20" align="center"><a href="delete-slide-<?php echo $r[0] ?>"><i class="glyphicon glyphicon-trash"></i></a></td>
			</tr>
			<?php
			}
			?>
		</tbody>
    </table>
	<div class="boxPagination">
	<?php
		$page = $p->anti_injection($_GET['page']);
		$p->pagination($jumlahhalaman, $page, "slideshow.");
	?>
	</div>
</form>
</div>