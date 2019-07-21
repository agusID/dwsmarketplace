<?php

if($cart->total_items() <= 0){
    header("Location: home");
}

$query = $db->query("SELECT * FROM MsUser WHERE UserID = ".$_SESSION['userID']);
$custRow = $query->fetch_assoc();
?>
<div class="Cart">
    <div class="CartTitle">Checkout &amp; Payment</div>
    <ul class="progressbar">
        <li class="active prevStep">Shopping Cart</li>
        <li class="active">Checkout &amp; Payment</li>
        <li>Confirmation</li>
    </ul>
    <table class="table">
    <thead>
        <tr>
            <th colspan="2">Product</th>
            <th align="right">Price</th>
            <th align="center">Quantity</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if($cart->total_items() > 0){
            $cartItems = $cart->contents();
            foreach($cartItems as $item){
        ?>

        <tr>
            <td style="width: 100px"><img style="width: 100px" src="assets/images/product/small_<?php echo $item["image"]; ?>" /></td>
            <td><?php echo $item["name"]; ?><br>
                <div class="CartPcs">
                    <span class="CartPrice"><?php echo $p->num_format($item["price"]); ?></span>/pcs
                </div>
            </td>
            <td><div class="CartPrice"><?php echo $p->num_format($item["subtotal"]); ?></div></td>
            <td align="center"><?php echo $item["qty"]; ?></td>

        </tr>
        <?php } }else{ ?>
        <tr><td colspan="4"><p>No items in your cart ...</p></td>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3"></td>
            <?php if($cart->total_items() > 0){ ?>
            <td class="text-center"><strong>Total <?php echo $p->num_format($cart->total()); ?></strong></td>
            <?php } ?>
        </tr>
        <tr>
            <td colspan="4">
                <div class="shipAddress">
                    <h4>Shipping Details</h4>
                    <p><?php echo $custRow['UserName']; ?></p>
                    <p><?php echo $custRow['UserEmail']; ?></p>
                    <p><?php echo $custRow['UserPhone']; ?></p>
                    <p><?php echo $custRow['UserAddress']; ?></p>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div class="shipAddress">
                    <h4>Choose a method of payment :</h4>
                    <p><input class="option-input radio" id="PaymentMethod1" name="PaymentMethod" type="radio"/> <label for="PaymentMethod1">Bank Transfer</label></p>
                    <p><input class="option-input radio" id="PaymentMethod2" name="PaymentMethod" disabled="" type="radio"/> <label for="PaymentMethod2">Credit Card</label></p>
                    <p><input class="option-input radio" id="PaymentMethod3" name="PaymentMethod" disabled="" type="radio"/> <label for="PaymentMethod3">Paypal</label></p>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div class="footBtn">
                    <a href="home" class="btnContinue-invert">Continue Shopping</a>
                    <a href="cartAction.php?action=placeOrder" class="btnCheckOut"><i class="glyphicon glyphicon-lock"></i> Checkout </a>
                </div>
            </td>
        </tr>
    </tfoot>
    </table>


</div>