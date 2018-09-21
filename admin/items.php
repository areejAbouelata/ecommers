<?php 
ob_start();
session_start();
$pagetitle = 'Items' ;


if (isset($_SESSION['Username'])) {
require 'int.php';//includ initial page
$do = isset($_GET['do'])? $_GET['do'] : "Manage" ; 
// root condition of page
if ($do == "Manage") {
	

$items = [];
 
$stmt = $conn->prepare("SELECT 
						items.* 
						, categouries.Name 
					AS
						 cat_name , users.Name 
					AS
						  username 
					FROM
						   items 
				    INNER JOIN 
						   categouries 
					ON
						    categouries.ID=items.catID 
					INNER JOIN
						     users 
					ON 
						     users.UserID=items.memberID ORDER BY itemID DESC ");

$stmt->execute();

$items = $stmt->fetchAll(PDO::FETCH_ASSOC);


  


    	?>


         <div class="container">
  <h2>All Items </h2>
<?php if (!empty($items)) { ?>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#ID</th>
        <th>Name</th>
        <th>description</th>
        <th>itemPrice</th>
        <th>Register Date</th>
        <th>category name</th>
        <th>user name</th>
        <th>control</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($items as $item): ?>

      <tr>
     <td> <?php  echo $item['itemID']; ?> </td>
     <td><?php  echo $item['itemName']; ?></td>
     <td><?php  echo $item['itemDescription']; ?></td>
     <td><?php  echo $item['itemPrice']; ?></td>
     <td><?php  echo $item['addDate']; ?></td>
     <td><?php  echo $item['cat_name']; ?></td>
     <td><?php  echo $item['username']; ?></td>
     <td>
     <a href="items.php?do=Edit&itemid=<?php echo$item['itemID'] ?>"  class="btn btn-primary">Edit</a>
     <a  href="items.php?do=Delete&itemid=<?php echo$item['itemID'] ?>" class="btn btn-danger confirm"> Delet</a>
    
      <?php 
      if ($item['Aprove'] == 0) {
      	?>
        <a  href="items.php?do=Approve&itemid=<?php echo$item['itemID'] ?>" class="btn btn-info"> Approve</a>
      	<?php

      }

      ?>	 
   

     
     </td>
     

        
      </tr>

<?php endforeach ?>
    
    </tbody>
  </table>

  <?php }else {
    ?>
   <div class="container alert alert-info"><h3>Sorry There Is No Items</h3> </div>
<?php 
}
   ?>
  
<a href="items.php?do=Add" class="btn btn-primary"> Add New Item</a>

</div>
        <?php



}
// add page
elseif ($do == "Add") {
	
	  	?>

        <div class="container">
  <h2>Add New Item</h2>
  <form class="form-horizontal add" action="?do=Insert" method="POST">
   <div class="form-group-lg">
      <label class="control-label col-sm-2" for="name">Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="name" placeholder="Enter name of Item" name="itemname"  required="required">
      </div>
    </div>

    <!-- discription -->
     <div class="form-group-lg">
      <label class="control-label col-sm-2" for="descrip">Descrption:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="descrip"
         placeholder="Enter Description of Item"
         name="descrip" 
         required="required">
      </div>
    </div>
 <!-- discription -->
 <!-- price -->
<div class="form-group-lg">
      <label class="control-label col-sm-2" for="price">Price:</label>
      <div class="col-sm-10">
        <input type="text" 
        class="form-control" 
        id="price"
         placeholder="Enter Price of Item"
         name="price" 
         required="required">
      </div>
    </div>
 <!-- price -->
  <!-- country -->
<div class="form-group-lg">
      <label class="control-label col-sm-2" for="country">country:</label>
      <div class="col-sm-10">
        <input type="text" 
        class="form-control" 
        id="country"
         placeholder="Enter country of Item"
         name="country" 
         required="required">
      </div>
    </div>
 <!-- country country-->
  <!-- status -->
<div class="form-group-lg select">
      <label class="control-label col-sm-2" for="status">status:</label>
      <div class="col-sm-4">
        <select name="status" id="status" class="form-control">
        	<option value="0">........</option>
        	<option value="1">NEW</option>
        	<option value="2">LIKE NEW</option>
        	<option value="3">USED</option>
        	<option value="4">OLD</option>
        </select>
      </div>
    </div>
 <!--status -->
	 <!-- members -->
<div class="form-group-lg select">
      <label class="control-label col-sm-2" for="members">members:</label>
      <div class="col-sm-4">
        <select name="members" id="members" class="form-control">
        	<option value="0">........</option>
        	<?php 
           $statement =$conn->prepare("SELECT * FROM users ") ;
           $statement->execute();
           $users= $statement->fetchAll();
           foreach ($users as $user) {
           	
           	echo "<option value='".$user['UserID']."'>".$user['Name']."</option>";
           }

        	 ?>
        </select>
      </div>
    </div>
 <!--members -->

 <!-- category -->
<div class="form-group-lg select" id="cat">
      <label class="control-label col-sm-2" for="category">category:</label>
      <div class="col-sm-4">
        <select name="category" id="category" class="form-control">
        	<option value="0">........</option>
        	<?php 
           $statement2 =$conn->prepare("SELECT * FROM categouries WHERE parent = 0") ;
           $statement2->execute();
           $cats= $statement2->fetchAll();
           foreach ($cats as $cat) {
           	
           	echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";

 $cts =  getallfrom ( "*" , "categouries" , "WHERE parent ={$cat['ID']} " , "" , "ID" , "ASC") ;
 foreach ($cts as $ct) {
   echo "<option value ='" .$ct['ID']."' >--->".$ct['Name']."</option>" ;
 }

           }

        	 ?>
        </select>
      </div>
    </div>
 <!--category -->


        <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10 ">
      <div class="row" id="itemadd">
        <button type="submit" class="btn btn-primary">Add Item</button>
        </div>
      </div>
    </div>
  </form>
</div>

    	<?php 



}
// insert page
elseif ($do == "Insert") {

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	echo "<h1>";
	echo "Insert Item ";
	echo "</h1>";
    // declear variabs of form
	$name		= $_POST['itemname'];
	$desc		= $_POST['descrip'];
	$price		= $_POST['price'];
	$cont		= $_POST['country'];
	$status		= $_POST['status'];
	$members	= $_POST['members'] ;
	$category	=$_POST['category'] ;

   // validation of form
	$formerror = array();

	if (empty($name)) {
	$formerror[] = "<div class = 'container alert alert-danger'>name of item can not be empty </div>" ;
		
	} if (empty($desc)) {
     $formerror[] = "<div class = 'container alert alert-danger '>description of item can not be empty  </div>" ;
	}
	if (empty($price)) {
		$formerror[] = "<div class ='container alert alert-danger'>price of item can not be empty </div>" ;
	}
	if (empty($cont)) {
		$formerror[] = "<div class = 'container alert alert-danger'> you should enter the name of country</div>" ;
	}if ($status == 0) {
		$formerror[] = "<div class = 'container alert alert-danger'> please clear the statu of item</div>" ;
	}
	if ($members == 0) {
		$formerror[] = "<div class = 'container alert alert-danger'> please clear the member of item</div>" ;
	}
	if ($category == 0) {
		$formerror[] = "<div class = 'container alert alert-danger'> please clear the category of item</div>" ;
	}
	// print errors
	foreach ($formerror as $error) {
		
		redirecthome($error , "back");
	}
	// execute the statement on the items table
	if (empty($formerror)) {
		 $stmt = $conn->prepare("INSERT INTO
           items (itemName ,
          	      itemDescription ,
          	      itemPrice ,
          	      country , status , memberID , catID , addDate ) VALUES 
          	                      (:zname , 
          	                      :zdesc , 
          	                      :zprice , 
          	                      :zcont , :zstatus , :zmembers ,:zcategory ,now())") ; 
     $stmt->execute( array(':zname' => $name,
                            ':zdesc' => $desc,
                            ':zprice' => $price,
                            ':zcont' => $cont ,
                            ':zstatus' => $status,
                            ':zmembers' => $members ,
                            ':zcategory' => $category));

		$message ="<div class = 'container alert alert-success'> ".count($stmt)." recored is inserted </div>" ;
		redirecthome($message , "back") ;

	}



		//end of request post
	}else{
		$message = "<div class= 'container alert alert-danger'> you can not browse this page directly</div>";
		redirecthome($message);
	}


}
// edit page
elseif ($do == "Edit") {
	

	 $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ?intval( $_GET['itemid']) :  "false";
     
    $stmt = $conn->prepare(" SELECT * FROM items WHERE itemID = ? limit 1");
    $stmt->execute([$itemid]) ;

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
   if (count($results)>0) {

      ?>

       <div class="container">
       	<h1>Edit Item </h1>
       	<form class="form-horizontal edit" action="?do=Update" method="POST" >
       	 <div class="form-group-lg">
      <label class="control-label col-sm-2" for="email">item Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="email" placeholder="Enter Name" name="name" value="<?php echo $results[0]['itemName']; ?>" required= "required">
      </div>
      <input type="hidden" name="itemid" value="<?php echo $itemid ;?>">
    </div>
    <div class="form-group-lg">
      <label class="control-label col-sm-2" for="desc">Description:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="desc" placeholder="Enter description" name="desc" value="<?php echo $results[0]['itemDescription']; ?>" required= "required">
      </div>
    </div>


<!-- ////////////////////////////// -->

 <!-- price -->
<div class="form-group-lg">
      <label class="control-label col-sm-2" for="price">Price:</label>
      <div class="col-sm-10">
        <input type="text" 
        class="form-control" 
        id="price"
         placeholder="Enter Price of Item"
         name="price" 
         required="required" value="<?php echo $results[0]['itemPrice']; ?>">
      </div>
    </div>
 <!-- price -->
  <!-- country -->
<div class="form-group-lg">
      <label class="control-label col-sm-2" for="country">country:</label>
      <div class="col-sm-10">
        <input type="text" 
        class="form-control" 
        id="country"
         placeholder="Enter country of Item"
         name="country" 
         required="required" value="<?php echo $results[0]['country']; ?>">
      </div>
    </div>
 <!-- country country-->
  <!-- status -->
<div class="form-group-lg select">
      <label class="control-label col-sm-2" for="status">status:</label>
      <div class="col-sm-4">
        <select name="status" id="status" class="form-control">

 <option value="1" <?php if ($results[0]['status'] == 1) {echo 'selected';} ?> >NEW</option>
 <option value="2" <?php if ($results[0]['status'] == 2) {echo 'selected';} ?> >LIKE NEW</option>
 <option value="3" <?php if ($results[0]['status'] == 3) {echo 'selected';} ?> >USED</option>
 <option value="4" <?php if ($results[0]['status'] == 4) {echo 'selected';} ?> >OLD</option>
        </select>
      </div>
    </div>
 <!--status -->
	 <!-- members -->
<div class="form-group-lg select">
      <label class="control-label col-sm-2" for="members">members:</label>
      <div class="col-sm-4">
        <select name="members" id="members" class="form-control">

        	<?php 
           $statement =$conn->prepare("SELECT * FROM users ") ;
           $statement->execute();
           $users= $statement->fetchAll();
           foreach ($users as $user) {
           	
 			echo "<option value='".$user['UserID']."'" ;
   			

   			if ($results[0]['memberID'] == $user['UserID']) {
   				echo 'selected';} 
 			 

 			 echo ">".$user['Name']."</option>";

           }

        	 ?>
        </select>
      </div>
    </div>
 <!--members -->

 <!-- category -->
<div class="form-group-lg select" id="cat">
      <label class="control-label col-sm-2" for="category">category:</label>
      <div class="col-sm-4">
        <select name="category" id="category" class="form-control">

        	<?php 
           $statement2 =$conn->prepare("SELECT * FROM categouries ") ;
           $statement2->execute();
           $cats= $statement2->fetchAll();
           foreach ($cats as $cat) {
           	
           	echo "<option value='". $cat['ID']."'";

           	if ($results[0]['catID'] == $cat['ID']) {
   				echo 'selected';} 
 			 

           	echo ">".$cat['Name']."</option>";
           }

        	 ?>
        </select>
      </div>
    </div>
 <!--category -->











  <!-- ///////////////////////////////// -->
    <div class="form-group-lg">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary" id="edit">Save</button>
      </div>
    </div>
  </form>
       </div>

<?php


  $rows = [] ;
  
  $stmt = $conn->prepare("SELECT 
                comments.* , users.Name 
              AS 
                username
              FROM 
                comments 
             
              INNER JOIN 
                users 
              ON 
                users.UserID=comments.userid WHERE itemid = ?");

  $stmt->execute([$itemid]);

  $rows = $stmt->fetchAll();

  if (!empty($rows)) {
    
  
  
  ?>

 <div class="container">
  <h2 class="text-center">Manage <?php echo $results[0]['itemName']; ?> comments </h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        
        <th>Comment</th>
        
        <th>User name</th>
        <th>Register Date</th>
        <th>control </th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $row): ?>

      <tr>
     
     <td><?php  echo $row['comment']; ?></td>
     
     <td><?php  echo $row['username']; ?></td>
     <td><?php  echo $row['commdate']; ?></td>
     <td>
     <a href="comments.php?do=Edit&commid=<?php echo$row['commID'] ?>"  class="btn btn-primary">Edit</a>
     <a  href="comments.php?do=Delete&commid=<?php echo$row['commID'] ?>" class="btn btn-danger confirm"> Delet</a>
    
    
     <?php 
      if ($row['status'] == 0) {
        ?>
        <a  href="comments.php?do=Approve&commid=<?php echo$row['commID'] ?>" class="btn btn-info"> Approve</a>
        <?php

      }

      ?>  
      
     </td>
     

        
      </tr>

<?php endforeach ?>
    
    </tbody>
  </table>
</div>
        <?php  
        }

    }  else {
    
   	$message = "<div class = 'alert alert-danger container'> it is rong there is no such id </div>";
   	redirecthome($message );
   }

}
// update page
elseif ($do == "Update") {
	


	?>
<div class="container">
<h1>UPdate item</h1></div>
<!-- name
itemid
desc
price
country
status
members
category -->
<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['itemid'] ;

   	$name = $_POST['name'] ;

   	$desc = $_POST['desc'];

   	$price = $_POST['price'] ;

   	$cont = $_POST['country'] ;

   	$status = $_POST['status'] ;

   	$member = $_POST['members'] ;

   	$cat = $_POST['category'] ;  
$formerror = array();

	if (empty($name)) {
	$formerror[] = "<div class = 'container alert alert-danger'>name of item can not be empty </div>" ;
		
	} if (empty($desc)) {
     $formerror[] = "<div class = 'container alert alert-danger '>description of item can not be empty  </div>" ;
	}
	if (empty($price)) {
		$formerror[] = "<div class ='container alert alert-danger'>price of item can not be empty </div>" ;
	}
	if (empty($cont)) {
		$formerror[] = "<div class = 'container alert alert-danger'> you should enter the name of country</div>" ;
	}if ($status == 0) {
		$formerror[] = "<div class = 'container alert alert-danger'> please clear the statu of item</div>" ;
	}
	if ($member == 0) {
		$formerror[] = "<div class = 'container alert alert-danger'> please clear the member of item</div>" ;
	}
	if ($cat == 0) {
		$formerror[] = "<div class = 'container alert alert-danger'> please clear the category of item</div>" ;
	}
	// print errors
	foreach ($formerror as $error) {
		
		redirecthome($error , "back");
	}

if (empty($formarr)) {
	


  

 $stmt = $conn->prepare('UPDATE
 							 	items
 						 SET 
	 						    itemName 		   	= ?,
	 						    itemDescription 	= ? ,
	 						    itemPrice 		   	= ? ,
	 						    country 		   	= ? ,
	 						    status 		     	= ? ,
	 						    catID 		   	    = ? ,
	 						    memberID 		   	= ?
 						 WHERE 
 						    	itemID = ? ') ;

 $stmt->execute([$name ,$desc , $price  , $cont  , $status ,$cat  ,$member , $id ]) ;

 $message = "<div class='container alert alert-success'> recored updated ". count($stmt) . "</div>";

 redirecthome( $message ,"back") ;
   	
   }


	
}else{


$message = "<div class = 'alert alert-danger container'>you can not browes this page</div>";

redirecthome($message);


}

}
// delete page
elseif ($do == "Delete") {
?>


         <div class="container">
  <h2>Delete Member </h2>

<?php



 $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ?intval( $_GET['itemid']) :  "false";
     
    $stmt = $conn->prepare(" SELECT * FROM items WHERE itemID = ? limit 1");
    $stmt->execute([$itemid]) ;

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
   if (count($results)>0) {

     $stmt = $conn->prepare('DELETE FROM items WHERE itemID = :zzz');
     $stmt->bindParam(':zzz' , $itemid) ;

     $stmt->execute();


   $message = "<div class ='container alert alert-success'> this is the form id waaas exist</div>";
   redirecthome($message , "back");


}else {

	$message = "<div class ='container alert alert-danger'> this id is not exist </div>";

	redirecthome($message);

}

}
// Activate page 
elseif ($do == "Approve") {

?>
  <div class="container">
  <h2>Approve item </h2>

<?php



 $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ?intval( $_GET['itemid']) :  "false";
     
    $stmt = $conn->prepare(" SELECT * FROM items WHERE itemID = ? limit 1");
    $stmt->execute([$itemid]) ;

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
   if (count($results)>0) {

    $stmt = $conn->prepare('UPDATE items SET Aprove = 1 WHERE itemID = ?');

     $stmt->execute([$itemid]);


   $message = "<div class ='container alert alert-success'> this is the form . item is Approved</div>";
   redirecthome($message , "back");


}else {

	$message = "<div class ='container alert alert-danger'> this id is not exist </div>";

	redirecthome($message);

}





}

require $tmps.'footer.php';

//end of manage page	
}
else {
	header('location:index.php') ;
	exit();
}





 ?>