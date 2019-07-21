<?php
header('Content-Type: application/json');
require_once('../config/dbConfig.php');
require_once('../controllers/MyController.php');

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);

mysqli_set_charset($db,'utf8');

$data = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
$id = array_shift($request)+0;

if(isset($_GET['auth'])){
    $auth = $_GET['auth'];
}else{
    $auth = '';
}
$error_message = ['Missing API key', 'Invalid API key', 'URL Access Denied' ];

$key = MyController::anti_injection($auth);
$getKey = mysqli_fetch_array(mysqli_query($db, "SELECT api_key FROM APIs WHERE api_key = '".$key."'"));

if (strcmp($data, 'register') == 0){
    if ($method == 'POST') {

        $table      = 'MsUser';

        $name       = MyController::anti_injection($_REQUEST['name']);
        $email      = MyController::anti_injection($_REQUEST['email']);
        $password   = md5($_REQUEST['password']);
        $phone      = MyController::anti_injection($_REQUEST['phone']);
        $address    = MyController::anti_injection($_REQUEST['address'])    ;

        $data = array(
            'UserName'      => $name,
            'UserEmail'     => $email,
            'UserPassword'  => $password,
            'UserPhone'     => $phone,
            'UserAddress'   => $address,
            'UserRole'      => 'Customer'
        );
        
		$sql = "INSERT INTO $table SET ";

		foreach($data as $key => $value){
			$sql.="".$key."='".mysqli_real_escape_string($db, $value)."', ";
		}

        $sql = rtrim($sql, ", ");
        if($auth == ''){
            $hasil1 = array(
                'status'    => false, 
                'message'   => $error_message[0]
            );
        }else if(!$getKey){
            $hasil1 = array(
                'status'    => false, 
                'message'   => $error_message[1]
            );
        }else{
            $run = mysqli_query($db, $sql);

            if($run > 0){
                $hasil1 = array(
                    'status'    => true, 
                    'message'   => 'data has been saved'
                );
            }else{
                $hasil1 = array(
                    'status'    => false, 
                    'message'   => 'Invalid to save the data'
                );
                
            } 
        }
        echo json_encode($hasil1);
    }
}elseif (strcmp($data, 'product') == 0) {
    switch ($method) {
        case 'GET':
        $sql = "SELECT MsProduct .*, Discount FROM MsProduct 
                LEFT JOIN MsDiscount ON MsDiscount.ProductID = MsProduct.ProductID".($id?" WHERE MsProduct.ProductID=$id":''); 
        break;
    }
    $result = mysqli_query($db,$sql);

    if (!$result) {
        http_response_code(404);
        die(mysqli_error($db));
    }

    if ($method == 'GET') {
        $hasil = array();


        if(empty($key)){
            $hasil1 = array(
                'status'    => false, 
                'message'   => $error_message[0]
            );
        }else if(!$getKey){
            $hasil1 = array(
                'status'    => false, 
                'message'   => $error_message[1]
            );
        }else{
            while($row = mysqli_fetch_array($result)){

                array_push($hasil,array(
                    'product_id'	        => $row['ProductID'],
                    'category_id'	        => $row['CategoryID'],
                    'product_name'	        => $row['ProductName'],
                    'product_price'     	=> $row['ProductPrice'],
                    'product_description'	=> $row['ProductDescription'],
                    'discount'	            => $row['Discount'],
                    'stock'	                => $row['Stock'],
                    'product_image'     	=> $row['ProductImage'],
                    'clean_url'             => MyController::cleanURL($row['ProductName']).'-'.$row['ProductID'].'.html'
                ));
            } 
            $hasil1 = array(
                'status'    => true, 
                'message'   => 'success', 
                'data'      => $hasil
            );
        }
        
        echo json_encode($hasil1);

    } elseif ($method == 'POST') {
        echo mysqli_insert_id($db);
    } else {
        echo mysqli_affected_rows($db);
    }
}elseif(strcmp($data, 'category') == 0){
    switch ($method) {
        case 'GET':
        $sql = "SELECT * FROM MsCategory".($id?" WHERE MsCategory.CategoryID=$id":''); 
        break;
    }
    $result = mysqli_query($db,$sql);

    if (!$result) {
        http_response_code(404);
        die(mysqli_error($db));
    }

    if ($method == 'GET') {
        $hasil = array();
        while($row = mysqli_fetch_array($result)){
            array_push($hasil,array(
                'category_id'	        => $row['CategoryID'],
                'category_name'	        => $row['CategoryName']
            ));
        } 
        
        $hasil1 = array(
            'status'    => true, 
            'message'   => 'success', 
            'data'      => $hasil
        );
        echo json_encode($hasil1);

    } elseif ($method == 'POST') {
        echo mysqli_insert_id($db);
    } else {
        echo mysqli_affected_rows($db);
    }
}elseif(strcmp($data, 'gallery') == 0){
    switch ($method) {
        case 'GET':
        $sql = "SELECT * FROM MsGallery".($id?" WHERE MsGallery.GallerySection=$id":''); 
        break;
    }
    $result = mysqli_query($db,$sql);

    if (!$result) {
        http_response_code(404);
        die(mysqli_error($db));
    }

    if ($method == 'GET') {
        $hasil = array();
        while($row = mysqli_fetch_array($result)){
            array_push($hasil,array(
                'id'	        => $row['GalleryID'],
                'title'	        => $row['GalleryTitle'],
                'section'	    => $row['GallerySection'],
                'image'	        => $row['GalleryImage']

            ));
        } 
        
        $hasil1 = array(
            'status'    => true, 
            'message'   => 'success', 
            'data'      => $hasil
        );
        echo json_encode($hasil1);

    } elseif ($method == 'POST') {
        echo mysqli_insert_id($db);
    } else {
        echo mysqli_affected_rows($db);
    }
}elseif(strcmp($data, 'bank') == 0){
    switch ($method) {
        case 'GET':
        $sql = "SELECT * FROM MsBank".($id?" WHERE MsBank.BankID=$id":''); 
        break;
    }
    $result = mysqli_query($db,$sql);

    if (!$result) {
        http_response_code(404);
        die(mysqli_error($db));
    }

    if ($method == 'GET') {
        $hasil = array();
        while($row = mysqli_fetch_array($result)){
            array_push($hasil,array(
                'id'	         => $row['BankID'],
                'bank_name'	     => $row['BankName'],
                'branch'	     => $row['BankBranchOffice'],
                'account_number' => $row['BankAccountNumber'],
                'account_name'	 => $row['BankAccountName'],
                'logo'	         => $row['BankLogo']
            ));
        } 
        
        $hasil1 = array(
            'status'    => true, 
            'message'   => 'success', 
            'data'      => $hasil
        );
        echo json_encode($hasil1);

    } elseif ($method == 'POST') {
        echo mysqli_insert_id($db);
    } else {
        echo mysqli_affected_rows($db);
    }
}elseif(strcmp($data, 'discount') == 0){
    switch ($method) {
        case 'GET':
        $sql = "SELECT MsProduct .*,DiscountID, Discount FROM MsProduct 
        INNER JOIN MsDiscount ON MsDiscount.ProductID = MsProduct.ProductID"; 
        break;
    }
    $result = mysqli_query($db,$sql);

    if (!$result) {
        http_response_code(404);
        die(mysqli_error($db));
    }

    if ($method == 'GET') {
        $hasil = array();
        while($row = mysqli_fetch_array($result)){
            array_push($hasil,array(
                'dicount_id'	 => $row['DiscountID'],
                'product_id'	 => $row['ProductID'],
                'discount'	     => $row['Discount'],
                'price_before'   => (integer)$row['ProductPrice'],
                'price_after'    => MyController::discountPrice($row['ProductPrice'],  $row['Discount'])
            ));
        } 
        
        $hasil1 = array(
            'status'    => true, 
            'message'   => 'success', 
            'data'      => $hasil
        );
        echo json_encode($hasil1);

    } elseif ($method == 'POST') {
        echo mysqli_insert_id($db);
    } else {
        echo mysqli_affected_rows($db);
    }
}else{
    $hasil1 = array(
        'status'    => false, 
        'message'   => $error_message[2]
    );
    echo json_encode($hasil1);
}

mysqli_close($db);

?>