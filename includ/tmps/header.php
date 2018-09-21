<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php gettitle() ?></title>
</head>
<link rel="stylesheet" href="<?php echo $css ;?>bootstrap.min.css">

<link rel="stylesheet" href="<?php echo $css ;?>style.css">

<body>
	<div class="upperbar">
   <div class="container">

   <?php if (isset($_SESSION['user'])) {
?>

<div class="btn-group"><span class="btn dropdown-toggle" data-toggle = "dropdown">
  <?php echo  $_SESSION['user']; ?><img src="1.jpg" class="img-circle img-thumbnail ">
  <span class="caret"></span>
</span>
<ul class="dropdown-menu">
  <li><a href="profile.php">MY Profile</a></li>
  <li><a href="profile.php#myads">My Ads</a></li>
  <li><a href="ads.php"> new Item</a></li>
  <li><a href="logout.php">Log Out</a></li>
</ul>
</div>

<?php

        if (checkstatus($_SESSION['user']) == 1) {

       echo  " sorry sir you are not activated";


       // user is not active
          
        }

      }

   else {?>
      <a href="login.php">

      <span class="pull-right">LOG IN | SINGN UP</span></a>

      <?php } ?>
   </div> 
  </div>
 
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
<!--       <a class="navbar-brand" href="#"><?php// echo lang('brand'); ?></a>



 --> 

      <a href="index.php" class="navbar-brand">HOME PAGE</a>
    </div>
    <ul class="nav navbar-nav pull-right">
<?php 


$cats = getallfrom ( "*" , "categouries" , "WHERE parent = 0 " , "", "ID", "ASC");

foreach ($cats as $cat) {
echo "<li> ";
echo "<a href='categories.php?pageid=".$cat['ID']."'> ";	
  echo $cat['Name'];
  echo "</a>";
  echo "</li>";
}




 ?>

        </ul>
      </li>
    </ul>
  </div>
</nav>