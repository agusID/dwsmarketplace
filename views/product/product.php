<?php
$CategorySQL = "SELECT * FROM viewcategorycount WHERE ProductCount != 0 ";
$ListCategory = $db->query($CategorySQL);

$colors = ['#2ecc71', '#3498db', '#2c3e50', '#d35400', '#e74c3c'];
$random_keys = array_rand($colors,3);

$incrementColor = 0;
	
?>

<div class="CategoryLabel">

Our <strong>Products</strong>
</div>
<div class="ProductContainer" style="margin-left:-15px;margin-right:-8px;">  

	<div id="listProduct"></div>

</div>
<?php

?>