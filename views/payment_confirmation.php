<?php
$id = $p->anti_injection($_GET['id']);
$query = $db->query("SELECT * FROM TrHeader WHERE OrderID = ".$id." AND UserID = ".$_SESSION['userID']);
$row = $query->fetch_assoc();
?>
<div class="Cart">
    <div class="CartTitle">Payment Confirmation</div>
    <ul class="progressbar">
        <li class="active prevStep">Shopping Cart</li>
        <li class="active prevStep">Checkout &amp; Payment</li>
        <li class="active">Confirmation</li>
    </ul>
    <p class="CartSubtitle">Thank you for successfully checkout by selecting <strong>Bank Transfer</strong></p>
    <table class="table">
    <tfoot>
        <tr>
            <td class="text-center">Amount that should be paid <br>
            <div class="Amount"><?php echo $p->num_format($row['TotalPrice']); ?></div>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <div class="shipAddress">
                    <h4>In order for your order to be processed by us, follow these steps :</h4>
                    <ol class="paymentProsess">
                        <li>Transfer amount <strong><?php echo $p->num_format($row['TotalPrice']); ?></strong> to one of the DWSmarketplace account numbers below :
                            <ul class="bankList">
                                <?php
                                $sqlBank = "SELECT * FROM MsBank";
                                $execBank = $db->query("SELECT * FROM MsBank");
                                while($rBank = $execBank->fetch_assoc()){
                                ?>
                                <li>
                                    <div class="bank">
                                        <div class="bankLogo">
                                            <img src="assets/images/bank/<?php echo $rBank['BankLogo'] ?>">
                                        </div>
                                        <div class="bankName">
                                            <?php echo $rBank['BankName'] ?>
                                        </div>
                                        <div class="bankKCP">
                                            <?php echo $rBank['BankBranchOffice'] ?>
                                        </div>
                                        <div class="bankAccountNumber">
                                        <?php echo $rBank['BankAccountNumber'] ?>
                                        </div>
                                        <div class="bankAN">
                                        A/N : <?php echo $rBank['BankAccountName'] ?>
                                        </div>
                                    </div>
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <li>After making the transfer, please immediately make a Payment Confirmation. Payment without confirmation can not be processed further. Make sure you fill in the correct data when making payment confirmation.</li>    
                        <li>Orders will be automatically canceled within 1 day if you do not make payment and confirm payment</li>
                    </ol>
                </div>
            </td>
        </tr>
        <tr>
        <form method="post" enctype="multipart/form-data">
            <?php
            if(isset($_POST['confirmation'])){

                $lokasifile 	= $_FILES['file_upload']['tmp_name'];
                $namafile 		= $_FILES['file_upload']['name'];
                $imageFileType 	= strtolower(pathinfo($namafile,PATHINFO_EXTENSION));
                $uploadPath     = 'assets/images/payment_slip/';
                $thumb_size     = 200;

                $id = $p->anti_injection($_GET['id']);
            
                if($namafile == ""){
                    $p->message("Image can't be empty");
                }else{
                    if($imageFileType != "jpg" && $imageFileType != "jpeg"){
                        $p->message("Sorry, only JPG & JPEG files are allowed.");
                    }else{
            
                        $paymentSlipImageName = 'payment_slip_'.$id.'_'.@$location.time().'_'.rand(1000, 9999).".".$imageFileType;

                        $dataConfirmation = array(
                            'PaymentConfirmation' => 'waiting',
                            'PaymentSlipImage'    => $paymentSlipImageName,
                            'updated_at'		  => date('Y-m-d h:i:s'),
                        );

                        $p->message("Thank you for confirming your payment.");
                        $p->UploadImage($paymentSlipImageName, $uploadPath, $thumb_size);
                        $p->update($db, $dataConfirmation, "TrHeader", "OrderID", $id, "");

                    }
                }
            }
            ?>
            <?php
            $getSQL = $db->query("SELECT PaymentConfirmation FROM TrHeader WHERE OrderID = '".$id."'");
            $r_data_conf = $getSQL->fetch_assoc();
            
            if($r_data_conf['PaymentConfirmation'] == 'not yet'){
            ?>
            <tr>
                <td colspan="4">
                    Upload payment slip : <input type="file" name="file_upload" required/>
                    <p class="note">*Only JPG &amp; JPEG files are allowed.</p>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <button type="submit" name="confirmation" class="btnPrimary"><i class="glyphicon glyphicon-ok"></i> Confirmation</button>
                </td>
            </tr>
            <?php
            }else if($r_data_conf['PaymentConfirmation'] == 'waiting'){
            ?>
            <tr>
                <td colspan="4">
                    Waiting for approval
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <a href="my-order" class="btnPrimary"><i class="glyphicon glyphicon-list"></i> My Order</button>
                </td>
            </tr>
            <?php
                }else if($r_data_conf['PaymentConfirmation'] == 'confirmed'){
            ?>
            <tr>
                <td colspan="4">
                   Cofirmed
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <a href="my-order" class="btnPrimary"><i class="glyphicon glyphicon-list"></i> My Order</button>
                </td>
            </tr>
            <?php
                }
            ?>
        </form>
        </tr>
    </tfoot>
    </table>


</div>