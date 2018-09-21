<?php 



require 'connect.php';
//routs
$tmps = 'includ/tmps/';

$css ='design/css/';

$js ='design/js/';  

$language = 'includ/lang/';

$fun = 'includ/function/';

  //// including of important files 

include $fun .'fun.php';
 
include $language.'eng.php';
  
include $tmps.'header.php';




if (!isset($nonavbar)) {
	include $tmps. 'navbar.php' ;
}

if (isset($_SESSION['current_url'])) {
	$_SESSION['previous_url'] = $_SESSION['current_url'];
}

if (isset($_SERVER['PHP_SELF'])) {
	$_SESSION['current_url'] = $_SERVER['PHP_SELF'];
}


 
 ?>