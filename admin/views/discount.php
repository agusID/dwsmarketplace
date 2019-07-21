
<div class="panelTitle">
	Discount
</div>
<div class="panel">
<form method="post">
	<?php
    if(isset($_POST['save'])){        

        $productID = $p->anti_injection($_POST['product']);

        $getSQLDiscount = $db->query("SELECT ProductID FROM MsDiscount WHERE DiscountID = '".$productID."'");
        $getDiscount = $getSQLDiscount->fetch_assoc();

        if(mysqli_num_rows($getSQLDiscount) > 0){
            $p->message("Product is aleardy exists");
            $p->redirect("discount");
        }else{
            $data = array(
                'ProductID'    => $p->anti_injection($_POST['product']),
                'Discount'     => $p->anti_injection($_POST['txtDiscount'])
            );
            
            $p->save($db, $data, "MsDiscount", "discount");
        }
	}

	if(isset($_GET['delete'])){
        $id = $p->anti_injection($_GET['id']);

		$sql = "DELETE FROM MsDiscount WHERE DiscountID = '".$id."'";
		$db->query($sql);
		$p->message('Data has been deleted');
		$p->redirect('discount');
	}

	?>
    
    <table>
    	<tr>
        	<td>Select Product</td>
            <td>
                <select name="product">
                <?php
                $sql_product = $db->query("SELECT MsProduct.ProductID, ProductName FROM MsProduct 
    
                ");
                while($r_product = $sql_product->fetch_assoc()){
                ?>
                    <option value="<?php echo $r_product['ProductID']; ?>"><?php echo $r_product['ProductName']; ?></option>
                <?php
                }
                ?>
                </select>
            </td>
        </tr>
    	<tr>
        	<td>Discount (%)</td>
            <td><input type="text" name="txtDiscount" required></td>
        </tr>
        <tr>
        	<td></td>
            <td>
			<button type="submit" name="save" class="btn-action"><i class="glyphicon glyphicon-plus"></i> Add Discount</button>
			</td>
        </tr>
    </table>
    
    <table class='table'>
        <thead>
            <tr>
                <th colspan="5">List Discount</th>
            </tr>
            <tr>
                <th>No.</th>
                <th>Product Name</th>
                <th>Discount</th>
                <th>Price<p class="note" style="margin:0">Before discount</p></th>
                <th>Price<p class="note" style="margin:0">After discount</p></th>
                <th align="center"></th>
            </tr>
        </thead>
        <tbody>
        <?php
        $batas = 5;
        $posisi = $p->get_position($batas);
        $sql = $db->query("SELECT MsDiscount .*, 
        ProductPrice, 
        ProductName, 
        MsProduct.CategoryID, 
        CategoryName,
        (ProductPrice - (ProductPrice * MsDiscount.Discount / 100)) AS PriceAfterDiscount
        FROM MsDiscount
        INNER JOIN MsProduct ON MsProduct.ProductID = MsDiscount.ProductID
        INNER JOIN MsCategory ON MsCategory.CategoryID = MsProduct.CategoryID
        
        LIMIT $posisi, $batas
        ");
        $jumlahdata = mysqli_num_rows(mysqli_query($db, "SELECT MsDiscount .*, 
        ProductPrice, 
        ProductName, 
        MsProduct.CategoryID, 
        CategoryName,
        (ProductPrice - (ProductPrice * MsDiscount.Discount / 100)) AS PriceAfterDiscount
        FROM MsDiscount
        INNER JOIN MsProduct ON MsProduct.ProductID = MsDiscount.ProductID
        INNER JOIN MsCategory ON MsCategory.CategoryID = MsProduct.CategoryID"));
        
        $jumlahhalaman = $p->total_page($jumlahdata, $batas);
        $no = $posisi;

        if($jumlahdata > 0){
            while($r = mysqli_fetch_array($sql)){
            
            $no++;
            ?>

            <tr>
                <td><?php echo $no; ?></td>
                <td>
                <?php echo $r['ProductName'].'<br>'; ?>
                <font color="#0066CC"><?php echo $r['CategoryName'] ?></font>
                </td>
                <td><?php echo $r['Discount'].'%' ?></td>
                <td><?php echo $p->num_format($r['ProductPrice'])?></td>
                <td><?php echo $p->num_format($r['PriceAfterDiscount'])?></td>
                <td align="center"><a style="margin:0" onclick="return confirm('Are you sure?')" href="<?php echo 'remove-discount-'.$r[0].'' ?>"><i class="glyphicon glyphicon-remove"></i></a></td>
            </tr>
            <?php
            }
        }else{
		?>
            <tr>
                <td colspan="6">Data is empty</td>
            </tr>
		<?php
	    }
		?>
        </tbody>
    </table>
	<div class="boxPagination">
	<?php
		$page = $p->anti_injection($_GET['page']);
		$p->pagination($jumlahhalaman, $page, "discount.");
	?>
	</div>
</form>
</div>