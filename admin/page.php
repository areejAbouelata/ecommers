<?php 


$do = isset($_GET['do'])? $_GET['do'] : "Manage" ;


   
 if ($do == "Manage") {

 	echo "welcome you are in Manage page";

 }	
 		elseif ($do == 'Add') {

 	echo "you are in add page";

 }	
       else {
 	      echo "Error request ";
 }


 ?>