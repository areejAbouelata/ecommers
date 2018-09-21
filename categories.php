<?php 

include 'int.php';?>

<div class="container">
	
	<div class="row">

<h1 class="text-center">Category</h1>




<?php 

foreach (getitems( 'catID' ,$_GET['pageid']) as $item) {


echo "<div class='col-sm-6 col-md-3'>";

echo "<div class='thumbnail item-box'>";

echo "<span class = 'priceitem'>";

echo $item['itemPrice'];

echo "</span>";
echo '<img src="1.jpg" alt="">';
echo "<div class = 'caption'>";
echo "<a href='items.php?itemid=".$item['itemID']."'> <h3>".$item['itemName']."</h3> </a>";

echo "<p>".$item['itemDescription']."</p>";
echo "<div class = 'text-right'>". $item['addDate']."</div>";

echo "</div>";
echo "</div>";
echo "</div>";

}




 ?>

</div>

</div>
<?php

include $tmps.'footer.php';
  ?>