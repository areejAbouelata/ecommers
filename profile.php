<?php 

session_start() ;

$pagetitle = 'Profile' ;

include 'int.php';

if (isset( $_SESSION['user'])) {
  $usersprofile = $conn->prepare("SELECT * FROM users WHERE Name = ?") ;

  $usersprofile->execute([$_SESSION['user']]) ;
  
  $getusers = $usersprofile->fetch();

  $items = $conn->prepare("SELECT * FROM items WHERE memberID=?");
  $items->execute([$getusers['UserID']]);
  $ads = $items->fetch() ;

  $comments = $conn->prepare("SELECT * FROM  comments WHERE userid =?") ;
  $comments->execute([$getusers['UserID']]) ;
  $comms = $comments->fetch();


?>

<div class="information">
	<div class="container">
		<div class="panel panel-primary profile">
  <div class="panel-heading">
  My information
  </div>
  <div class="panel-body">
  <span> User Name		:</span> <?php echo $getusers['Name']; ?> <br>
  <span> email			:</span><?php echo $getusers['Email']; ?><br>
  <span> FUll-Name		:</span><?php echo $getusers['FullName']; ?><br>
  <span> Date oF log in :</span><?php echo $getusers['mydate']; ?><br>
  <span> Favourit category:</span>

  </div>
<a href="" class="btn btn-info" style="margin: 10px;">Edit Information</a>
</div>


<div class="panel panel-primary profile" id="myads">
  <div class="panel-heading">My Items</div>
  <div class="panel-body">
     <?php if (!empty($ads)) { ?>
  	


<?php 

foreach (getitems( 'memberID' ,$getusers['UserID'] , 1) as $item) {


echo "<div class='col-sm-6 col-md-3'>";

echo "<div class='thumbnail item-box'>";

echo "<span class = 'priceitem'>";

echo $item['itemPrice'];

echo "</span>";
if ($item['Aprove'] == 0) {
  echo "<span id = 'approve'> not approved </span>";
}

echo '<img src="1.jpg" alt="">';
echo "<div class = 'caption'>";
echo "<a href='items.php?itemid=".$item['itemID']."'> <h3>".$item['itemName']."</h3> </a>";

echo "<p>".$item['itemDescription']."</p>";
echo "<div>".$item['addDate']."</div>";

echo "</div>";
echo "</div>";
echo "</div>";

}




 ?>





   <?php } else{
    echo "<div class='alert alert-info'>NO ADVER FOR YOU</div>";
    } ?>


  </div>
</div>


<div class="panel panel-primary profile">
  <div class="panel-heading">comments</div>
  <div class="panel-body">

  <?php if (!empty($comms)) { ?>

  <div class='col-sm-6 col-md-3'>
  	
  <span>Comment :</span><p style="background: #EEE"><?php echo  $comms['comment']; ?></p><br>
  <span>Date :</span><?php echo  $comms['commdate']; ?>
  </div>

<?php   }else{
    echo "<div class='alert alert-info'>NO COMMENTS FOR THIS ITEM </div>";

  } ?>
  </div>
</div>

	</div>
</div>






<?php

}else
{
	header('location:login.php') ;
	exit();
}
include $tmps.'footer.php';
  ?>


