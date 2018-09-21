<?php 
ob_start() ;

session_start() ;

$pagetitle = 'comments';

if (isset($_SESSION['Username'])) {
	require 'int.php';

$do = isset($_GET['do']) ? $_GET['do'] : "Manage" ;

if ($do == "Manage") {

	$rows = [] ;
	
	$stmt = $conn->prepare("SELECT 
								comments.* , items.itemName 
							AS 
							  	item_name , users.Name 
							AS 
								username
							FROM 
								comments 
							INNER JOIN 
								items 
							ON 
								items.itemID=comments.itemid 
							INNER JOIN 
								users 
							ON 
								users.UserID=comments.userid  ORDER BY commID DESC ");

	$stmt->execute();

	$rows = $stmt->fetchAll();
	
	?>

 <div class="container">
 <?php if (!empty($rows)) { ?>
  <h2 class="text-center">Manage comments </h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#ID</th>
        <th>Comment</th>
        <th>Item name</th>
        <th>User name</th>
        <th>Register Date</th>
        <th>control </th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $row): ?>

      <tr>
     <td>  <?php  echo $row['commID']; ?> </td>
     <td class="lgcomm"> <div ><?php  echo $row['comment']; ?></div></td>
     <td><?php  echo $row['item_name']; ?></td>
     <td><?php  echo $row['username']; ?></td>
     <td><?php  echo $row['commdate']; ?></td>
     <td>
     <a href="comments.php?do=Edit&commid=<?php echo$row['commID'] ?>"  class="btn btn-primary">Edit</a>
     <a  href="comments.php?do=Delete&commid=<?php echo$row['commID'] ?>" class="btn btn-danger confirm"> Delet</a>
    
    
     <?php 
      if ($row['status'] == 0) {
      	?>
        <a  href="comments.php?do=Approve&commid=<?php  echo $row['commID']; ?>" class="btn btn-info"> Approve</a>
      	<?php

      }

      ?>	
      
     </td>
     

        
      </tr>

<?php endforeach ?>
    
    </tbody>
  </table>

  <?php }else { ?>

<div class="alert alert-info container"> There Is NO Comments About Items</div>
  <?php	} ?>
</div>
        <?php  


	
}
elseif ( $do == "Edit") {

$commid = isset($_GET['commid']) && is_numeric($_GET['commid']) ?intval( $_GET['commid']) :  "false";
     
    $stmt = $conn->prepare(" SELECT * FROM comments WHERE commID = ? limit 1");
    $stmt->execute([$commid]) ;

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
   if (count($results)>0) {

 

      ?>

       <div class="container">
       	<h1 class="text-center">Edit comment</h1>
       	<form class="form-horizontal edit" action="?do=Update" method="POST" >
       	 <div class="form-group-lg">
      <label class="control-label col-sm-2" for="email">COMMENT:</label>
      <div class="col-sm-10">
        <textarea class="form-control" name="comment"><?php echo $results[0]['comment']; ?></textarea>




        	      </div>
      <input type="hidden" name="commid" value="<?php echo $commid ;?>">
    </div>
   
    <div class="form-group-lg">        
      <div class="col-sm-offset-2 col-sm-10 pull-left"><br>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </div>
  </form>
       </div>




      <?php     }  else {
    
   	$message = "<div class = 'alert alert-danger container'> it is rong there is no such id </div>";
   	redirecthome($message );
   }

	// end of edit page
}
elseif ($do == "Update"){
   ?>
<div class="container">
<h1>UPdate comment</h1></div>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
  $comm = $_POST['comment'] ;
  $commid = $_POST['commid'] ;



	$query_update = "UPDATE `comments`
          SET comment = '$comm'
           WHERE commID = '$commid'";
$conn->exec($query_update);

 $message = "<div class='container alert alert-success'> comment updated </div>";

 redirecthome( $message ,"back") ;
   	


}
	
else{


$message = "<div class = 'alert alert-danger container'>you can not browes this page</div>";

redirecthome($message);


}



	//end of update
}elseif ( $do == 'Approve') { //activate pinding users
    	?>


         <div class="container">
  <h2 class="text-center">Approve comment </h2>

<?php



 $commid = isset($_GET['commid']) && is_numeric($_GET['commid']) ?intval( $_GET['commid']) :  "false";
     
    $stmt = $conn->prepare(" SELECT * FROM comments WHERE commID = ? limit 1");
    $stmt->execute([$commid]) ;

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
   if (count($results)>0) {

    $stmt = $conn->prepare('UPDATE comments SET status = 1 WHERE commID = ?');

     $stmt->execute([$commid]);


   $message = "<div class ='container alert alert-success'> this is the form .  Comment  Activated</div>";
   redirecthome($message , "back");


}else {

	$message = "<div class ='container alert alert-danger'> this id is not exist </div>";

	redirecthome($message);

}


}


elseif ($do == "Delete") {

	

?>


         <div class="container">
  <h2 class="text-center">Delete Comment </h2>

<?php



 $commid = isset($_GET['commid']) && is_numeric($_GET['commid']) ?intval( $_GET['commid']) :  "false";
     
    $stmt = $conn->prepare(" SELECT * FROM comments WHERE commID = ? limit 1");
    $stmt->execute([$commid]) ;

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
   if (count($results)>0) {

     $stmt = $conn->prepare('DELETE FROM comments WHERE commID = :zzz');
     $stmt->bindParam(':zzz' , $commid) ;

     $stmt->execute();


   $message = "<div class ='container alert alert-danger'> this is the form id waaas exist</div>";
   redirecthome($message , "back");


}

   




else {

	$message = "<div class ='container alert alert-danger'> this id is not exist </div>";

	redirecthome($message);

}




	// delete page

} 



	require $tmps.'footer.php';
}

else{
	header('location:index.php') ;

	exit();
}


 ?>