<?php

class MyController{
	
	public function __construct(){
		
	}

	public function redirect($location){
		echo "<script>document.location.href='".$location."'</script>";
	}

	public function message($msg){
		echo "<script>alert('$msg');</script>";	
	}

	public function anti_injection($data){
		$filter = stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES)));
		return $filter;
	}

	public function doLogin($db, $table, $username, $password, $to, $userRole){
		$user = $this->anti_injection($username);
		$pass = $this->anti_injection($password);

		if($userRole == 'Admin'){
			$sql = "SELECT * FROM $table WHERE UserEmail = '$user' AND UserPassword = '$pass' AND UserRole = 'Admin' ";
		}else if($userRole == 'Customer'){
			$sql = "SELECT * FROM $table WHERE UserEmail = '$user' AND UserPassword = '$pass' AND UserRole = 'Customer' ";
		}

		$run = $db->query($sql);
		$check = mysqli_num_rows($run);

		if($check > 0){
			$rows = mysqli_fetch_array($run);
			$_SESSION['userID']		= $rows['UserID'];
			$_SESSION['username'] 	= $rows['UserName'];
			$_SESSION['role']		= $rows['UserRole'];
			$_SESSION['login'] 		= TRUE;

			$this->message('Welcome back, '.$_SESSION['username']);
			$this->redirect($to);
		}else
			$this->message('Incorrect Email or Password!');
	}
	
	public function doLogout(){
		// session_start();
		session_unset();
		session_destroy();
		
		$this->redirect('home');
		exit();
	
	}
	
	public function save($db, array $data, $table, $to){
		$sql = "INSERT INTO $table SET ";

		foreach($data as $key => $value){
			$sql.="".$key."='".mysqli_real_escape_string($db, $value)."', ";
		}

		$sql = rtrim($sql, ", ");
		$run = mysqli_query($db, $sql);

		if($run > 0 && !empty($to))
			$this->redirect($to);
		else
			$this->message('Invalid to save the data');
	}

	function update($db, array $data, $table, $id, $get,  $to){
		$sql = "UPDATE $table SET ";

		foreach($data as $key => $value){
			$sql.="".$key."='".mysqli_real_escape_string($db, $value)."', ";
		}

		$sql = rtrim($sql, ", ");
		$sql = $sql." WHERE $id = '$get'";
		$run = mysqli_query($db, $sql);
		if($run > 0)
			$this->redirect($to);
		else
			$this->message('Invalid to update the data');
	}

	public function delete($db, $table, $id, $get, $to){
		
		$get = $this->anti_injection($get);

		$sql = mysqli_query($db, "DELETE FROM $table WHERE $id = '$get'");
		$this->redirect($to);
	}

	public function num_format($value){
		$result = number_format($value, 0, ",",".");
		return $result.' IDR';
	}
	
	public function discountPrice($price, $discount){
		$priceDiscount = $price - ($price * $discount / 100);
		return $priceDiscount;
	}
	
	public function productLength($str, $length){
		$str = substr($str, 0, $length) . '...';
		return $str;
	}

	public function cleanURL($url){
		$characters = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
		$sentence = str_replace([' ', '/'], '-',str_replace('   ', ' ',str_replace($characters, ' ',strtolower($url))));
		
		$limit = 4;

		if(str_word_count($url) > $limit)
			$result = implode("-", array_slice(explode("-", $sentence), 0, $limit));
		else $result = $sentence;
		
		return $result;
	}


	public function get_position($limit){
		if(@$_GET['page']==""){
			$position = 0;
			$_GET['page'] = 1;
		}else
			$position = ($_GET['page'] - 1) * $limit;
		
		return $position;	
	}

	public function total_page($total_data, $limit){
		$total_page = ceil($total_data / $limit);
		return $total_page;
	}

	public function pagination($total_page, $active_page, $file){
		echo "<div class='paging'>";
		if($active_page > 1){
			$prev = $active_page-1;
			echo "<span class=prevnext><a href=".$file."page=$prev><i class='glyphicon glyphicon-chevron-left'></i> Prev</a></span>";	
		}else{
			echo "<span class=disabled><i class='glyphicon glyphicon-chevron-left'></i> Prev</span>";
		}

		for($i = 1; $i <= $total_page; $i++){
			if($i != $active_page){
				echo "<span class='current_aktif'><a href=".$file."page=$i>$i</a></span>";	
			}else{
				echo "<span class=current>$i</span>";
			}
		}
		
		if($active_page < $total_page){
			$next = $active_page + 1;
			echo "<span class=prevnext><a href=".$file."page=$next>Next <i class='glyphicon glyphicon-chevron-right'></i></a></span>";	
		}else{
			echo "<span class=disabled>Next <i class='glyphicon glyphicon-chevron-right'></i></span>";
		}
		
		echo "</div>";
	}

	function UploadImage($fupload_name, $dirUpload, $thumb_size){
		//direktori gambar
		$vfile_upload = $dirUpload . $fupload_name;
	  
		//Simpan gambar dalam ukuran sebenarnya
		move_uploaded_file($_FILES["file_upload"]["tmp_name"], $vfile_upload);
	  
		//identitas file asli
		$im_src = imagecreatefromjpeg($vfile_upload);
		$src_width = imageSX($im_src);
		$src_height = imageSY($im_src);
	  
		//Simpan dalam versi small 200 pixel
		//Set ukuran gambar hasil perubahan
		if($thumb_size == ''){
			$thumb_size = 200;
		}
		$dst_width = $thumb_size;
		$dst_height = ($dst_width/$src_width)*$src_height;
	  
		//proses perubahan ukuran
		$im = imagecreatetruecolor($dst_width,$dst_height);
		imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
	  
		//Simpan gambar
		imagejpeg($im,$dirUpload . "small_" . $fupload_name);
		
		//Hapus gambar di memori komputer
		imagedestroy($im_src);
		imagedestroy($im);
	  }

}


?>