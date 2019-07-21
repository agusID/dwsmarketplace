<html>
<head>
	<title>Laporan</title>
	<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<span class="judul">Laporan Penjualan</span>

<table>
<form method="post" action="mod/hasil_laporan.php">
	<tr>
    	<td>Dari Tgl.</td>
        <td>:</td>
        <td><input type="date" name="tgl1"></td>
    </tr>
	<tr>
    	<td>s/d Tgl.</td>
        <td>:</td>
        <td><input type="date" name="tgl2"></td>
    </tr>

    <tr>
    	<td>Pilih Status</td>
        <td>:</td>
    	<td>
        <select name="status">
        	<option value="all">Semua Status</option>
        	<option >Pending</option>
            <option >Sending</option>
            <option >Delivered</option>
        </select>	
        </td>
    </tr>
    <tr>
    	<td></td>
        <td></td>
        <td><input type="submit" value="cetak"></td>
    </tr>
</form>

<form method="post" action="mod/different_sell.php">

<?php
	$nama_bulan = array("","Januari","Febuari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Novermber","Desember");
 ?>
	<table>
    	<tr>
        	<td>Pilih Bulan 1</td>
            <td>:</td>
            <td>
            <select name="bln1">
            <?php for($i==1;$i<=12;$i++){ ?>
            	<option value="<?php echo $i ?>"><?php echo $nama_bulan[(int)$i]; ?></option>	
            <?php } ?>
            </select>
            </td>
        </tr>
    	<tr>
        	<td>Pilih Bulan 2</td>
            <td>:</td>
            <td>
            <select name="bln2">
            <?php 
			for($k==1;$k<=12;$k++){ 
				if($k<10){
					$k = "0".$k;	
				}
			?>
            	
            	<option value="<?php echo $k ?>"><?php echo $nama_bulan[(int)$k]; ?> </option>	
            <?php } ?>
            </select>
            </td>
        </tr>
        <tr>
    		<td></td>
        	<td></td>
        	<td><input type="submit" value="cetak"></td>
    	</tr>
    </table>
	
</form>
</table>
</html>