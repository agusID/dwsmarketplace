<?php
// initialize shopping cart class
include 'controllers/Cart.php';
$cart = new Cart;

// include database configuration file
include 'config/dbConfig.php';

if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){
        $productID = $_REQUEST['id'];
        // get product details
        
        //check discount
        $checkDiscount = $db->query("SELECT ProductID FROM MsDiscount WHERE ProductID = ".$productID);

        if(mysqli_num_rows($checkDiscount) > 0){
            $query = $db->query("SELECT MsDiscount .*, MsProduct.ProductID, ProductName, ProductImage, 
            (ProductPrice - (ProductPrice * MsDiscount.Discount / 100)) AS ProductPrice
            FROM MsDiscount
            INNER JOIN MsProduct ON MsProduct.ProductID = MsDiscount.ProductID
            WHERE MsProduct.ProductID = ".$productID);
        }else{
            $query = $db->query("SELECT ProductID, ProductName, ProductPrice, ProductImage FROM MsProduct WHERE ProductID = ".$productID);
        }
        $row = $query->fetch_assoc();

        $itemData = array(
            'id'    => $row['ProductID'],
            'name'  => $row['ProductName'],
            'price' => $row['ProductPrice'],
            'image' => $row['ProductImage'],
            'qty'   => 1
        );
        
        $insertItem = $cart->insert($itemData);
        $redirectLoc = $insertItem?'cart':'home';
        header("Location: ".$redirectLoc);
    }elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])){
        $itemData = array(
            'rowid' => $_REQUEST['id'],
            'qty'   => $_REQUEST['qty']
        );
        $updateItem = $cart->update($itemData);
        echo $updateItem?'ok':'err';die;
    }elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])){
        $deleteItem = $cart->remove($_REQUEST['id']);
        header("Location: cart");
    }elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0 && !empty($_SESSION['userID'])){
        // insert order details into database
        $insertOrder = $db->query("INSERT INTO TrHeader (UserID, TotalPrice, created_at, updated_at) VALUES ('".$_SESSION['userID']."', '".$cart->total()."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')");
        
        if($insertOrder){
            $orderID = $db->insert_id;
            $sql = '';
            // get cart items
            $cartItems = $cart->contents();
            foreach($cartItems as $item){
                $sql .= "INSERT INTO TrDetail (OrderID, ProductID, Quantity) VALUES ('".$orderID."', '".$item['id']."', '".$item['qty']."');";
            }
            // insert order items into database
            $insertOrderItems = $db->multi_query($sql);
            
            if($insertOrderItems){
                $cart->destroy();
                header("Location: payment-confirmation-$orderID");
            }else{
                header("Location: checkout");
            }
        }else{
            header("Location: checkout");
        }
    }else{
        header("Location: home");
    }
}else{
    header("Location: home");
}