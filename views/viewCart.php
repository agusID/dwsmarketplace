<div class="Cart">
    
    <script>
    function updateCartItem(obj,id){
        $.get("cartAction.php", {action:"updateCartItem", id:id, qty:obj.value}, function(data){
            if(data == 'ok'){
                location.reload();
            }else{
                alert('Cart update failed, please try again.');
            }
        });
    }
    </script>

    <div class="CartTitle">Shopping Cart - <span class="PriceColor"><?php echo $p->num_format($cart->total()); ?></span></div>
    <ul class="progressbar">
        <li class="active current">Shopping Cart</li>
        <li>Checkout &amp; Payment</li>
        <li>Confirmation</li>
    </ul>
    <table class="table">
        <thead>
            <tr>
                <th colspan="2">Product</th>
                <th align="right">Price</th>
                <th>Quantity</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if($cart->total_items() > 0){
                $cartItems = $cart->contents();

                foreach($cartItems as $item){
                ?>
                <tr>
                    <td style="width: 100px">
                        <img style="width: 100px" src="assets/images/product/small_<?php echo $item["image"]; ?>" />
                    </td>
                    <td>
                        <?php echo $item["name"]; ?><br>
                        <div class="CartPcs">
                            <span class="CartPrice"><?php echo $p->num_format($item["price"]); ?></span>/pcs
                        </div>
                    </td>
                    <td><div class="CartPrice"><?php echo $p->num_format($item["subtotal"]); ?></div></td>
                    <td><input class="quantity" type="number" min="1" value="<?php echo $item["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $item["rowid"]; ?>')"></td>

                    <td style="width: 50px">
                        <a class="btnRemove" href="cartAction.php?action=removeCartItem&id=<?php echo $item["rowid"]; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="glyphicon glyphicon-remove"></i></a>
                    </td>
                </tr>
            <?php 
                } 
            }else{ 
            ?>
                <tr>
                    <td colspan="3"><p>There are no items in your cart.</p></td>
                </tr>
            <?php 
            } 
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><a href="home" class="btnContinue-invert">Continue Shopping</a></td>
                <?php if($cart->total_items() > 0){ ?>
                <td></td>
                <td colspan="2"><a href="checkout" class="btnContinue">Proceed to checkout</a></td>
                <?php }else{
                ?>
                <td></td>
                <td colspan="2"><a class="btnDisable">Proceed to checkout</a></td>
                <?php
                } ?>
            </tr>
        </tfoot>
    </table>
</div>