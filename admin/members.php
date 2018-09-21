<?php 

session_start();
 

$pagetitle = 'members';

  if (isset($_SESSION['Username'])) {

    include 'int.php';
   
    $do = isset($_GET['do']) ? $_GET['do'] :"Manage" ;

    if ($do == "Manage") {  //start of manage page


    $query = '' ;
     if (isset($_GET['page']) && $_GET['page'] == 'pending') {
     	$query = 'AND RedStatus = 0' ;
      	
      } 

    	
$results = [];
 
$stmt = $conn->prepare("SELECT * FROM  users WHERE  GroupID != 1 $query ORDER BY UserID DESC");

$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (!empty($results)) {
  


    	?>


         <div class="container">
  <h2>All users </h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#ID</th>
        <th>image</th>
        <th>UserName</th>
        <th>Email</th>
        <th>Full Name</th>
        <th>Register Date</th>
        <th>control</th>
      </tr>
    </thead>
    <tbody class="member-table">
    <?php foreach ($results as $row): ?>

      <tr>
     
     <td> <?php  echo $row['UserID']; ?> </td>
     <td> <img src="upload/imgs/<?php if (!empty($row['img'])) {
       echo $row['img'];
     } else{echo "1.jpg";}?>" alt=""></td>
     <td><?php  echo $row['Name']; ?></td>
     <td><?php  echo $row['Email']; ?></td>
     <td><?php  echo $row['FullName']; ?></td>
     <td><?php  echo $row['mydate']; ?></td>
     <td>
     <a href="members.php?do=Edit&userid=<?php echo$row['UserID'] ?>"  class="btn btn-primary">Edit</a>
     <a  href="members.php?do=Delete&userid=<?php echo$row['UserID'] ?>" class="btn btn-danger confirm"> Delet</a>
    
    
     <?php 
      if ($row['RedStatus'] == 0) {
      	?>
        <a  href="members.php?do=Activate&userid=<?php echo$row['UserID'] ?>" class="btn btn-info"> Activate</a>
      	<?php

      }

      ?>	
      
     </td>
     

        
      </tr>

<?php endforeach ?>
    
    </tbody>
  </table>

</div> 
        <?php } else {

          ?>
           <div class=" container alert alert-info"><h2>There is no recordes </h2></div>
          <?php
        }  
        ?>
        <div class="container">

        <a href="members.php?do=Add" class="btn btn-primary"> Add New Member</a>
       </div>
        <?php

    } elseif ($do == 'Delete') {
    	?>


         <div class="container">
  <h2>Delete Member </h2>

<?php



 $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ?intval( $_GET['userid']) :  "false";
     
    $stmt = $conn->prepare(" SELECT * FROM users WHERE UserID = ? limit 1");
    $stmt->execute([$userid]) ;

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
   if (count($results)>0) {

     $stmt = $conn->prepare('DELETE FROM users WHERE UserID = :zzz');
     $stmt->bindParam(':zzz' , $userid) ;

     $stmt->execute();


   $message = "<div class ='container alert alert-danger'> this is the form id waaas exist</div>";
   redirecthome($message , "back");


}else {

	$message = "<div class ='container alert alert-danger'> this id is not exist </div>";

	redirecthome($message);

}



    	
    }
    elseif ($do == "Add") {
    	?>

        <div class="container">
  <h2>Add user</h2>
  <form class="form-horizontal add" action="?do=Insert" method="POST" enctype="multipart/form-data">
   <div class="form-group-lg">
      <label class="control-label col-sm-2" for="name">Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="name" placeholder="Enter name" name="name"  required="required">
      </div>
    </div>

    <div class="form-group-lg">
      <label class="control-label col-sm-2" for="pwd">Password:</label>
      <div class="col-sm-10">          
        <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" required="required">
      </div>
    </div>
    <div class="form-group-lg">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required="required">
      </div>
    </div>
    
      <div class="form-group-lg">
      <label class="control-label col-sm-2" for="full">FullName:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="full" placeholder="Enter fullname" name="full" required="required">
      </div>
    </div>
    <!--img  upload -->

    
      <div class="form-group-lg">
      <label class="control-label col-sm-2" for="full">User img:</label>
      <div class="col-sm-10">
        <input type="file" class="form-control" id="full" placeholder="Enter fullname" name="img">
      </div>
    </div>
    <!--img  upload -->
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary">Add Member</button>
      </div>
    </div>
  </form>
</div>

    	<?php 
    }elseif ($do == "Insert" ) {

    	$name = '';
    	$email = '';
    	$pass = '';
    	$full = '';


     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     	?>
<div class="container">
<h1>Add Member</h1></div>
<?php
// upload variables
$img = $_FILES['img'];
$imgname = $_FILES['img']['name'] ;
$imgsize = $_FILES['img']['size'] ;
$imgnametmp = $_FILES['img']['tmp_name'] ;

// allawed file types of img
$imgallawedExtention = array("jpg" ,"jepg" ,"png","gif") ;
// chech extention of the  img

$end = end(explode('.', $imgname));
$imgextention =  strtolower($end) ;

// if ( in_array( $imgextention, $imgallawedExtention)) {

//   echo "exist";
// }



// print_r($img) ;
// die();

     $formarr = array();

if (empty($_POST['name'])) {
	$formarr[] ="<div class='container alert alert-danger'> name is requered </div>"; 
} 
if (empty( $_POST['email'])) {
	$formarr[] = "<div class='container alert alert-danger'>email is requered </div>" ;
}
if (empty( $_POST['full'])) {
	$formarr[] = "<div class='container alert alert-danger'>full name is requered filed </div>";
}
if (empty($_POST['pwd'])) {
	$formarr[] = "<div class='container alert alert-danger'>full password is requered filed </div>";
	
}
if (strlen($_POST['pwd']) <= 1) {
	$formarr[]= "<div class='container alert alert-danger'>short password </div>";
		
}

if (!empty($imgname) &&!in_array($imgextention, $imgallawedExtention)) {
  $formarr[]= "<div class='container alert alert-danger'>not exist extention</div>";

} 

if (empty($imgname) ) {
  $formarr[]= "<div class='container alert alert-danger'>name of img is required</div>";

}
if ($imgsize > 4194304 ) {
  $formarr[]= "<div class='container alert alert-danger'>bid size for the image</div>";

}

foreach ($formarr as $error) {
  	echo $error .'<br>';
  }  
  if (empty($formarr)) {

    $image = rand(0 , 1000000).'_'.$imgname ;

    $folder ="upload/imgs/";

   $path = $folder.$image ;

   move_uploaded_file( $imgnametmp , $path );


  	 $value =$_POST['name'] ;

    	$test = check ( "Name","users",$value );
    	if ($test == 1) {
    		echo "<div class='alert alert-danger container'>sory this user is already exist </div>";
    	}  else {

     	$name = $_POST['name'] ;
     	$email = $_POST['email'] ;
     	$pass = sha1($_POST['pwd']);
     	$full = $_POST['full'] ;
     $stmt = $conn->prepare("INSERT INTO
           users (Name ,
          	      PassWord ,
          	      Email ,
          	      FullName , img, RedStatus ,mydate ) VALUES 
          	                      (:zname , 
          	                      :zpass , 
          	                      :zemail , 
          	                      :zfull ,:zimg , 1 , now())") ; 
     $stmt->execute( array(':zname' => $name,
                            ':zpass' => $pass,
                            ':zemail' => $email,
                            ':zfull' => $full ,
                            ':zimg' => $image));

     $message = "<div class='container alert alert-success'> adding is done " .count($stmt)."record </div>";
     redirecthome($message , "back");
  	  } 

	}

  }
     else {
     	$message = "not valide asking page directly";
     	// $seconds = "30";
     	redirecthome($message);
     }
    	
    }elseif ($do == 'Activate') { //activate pinding users
    	?>


         <div class="container">
  <h2>Activate Member </h2>

<?php



 $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ?intval( $_GET['userid']) :  "false";
     
    $stmt = $conn->prepare(" SELECT * FROM users WHERE UserID = ? limit 1");
    $stmt->execute([$userid]) ;

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
   if (count($results)>0) {

    $stmt = $conn->prepare('UPDATE users SET RedStatus = 1 WHERE UserID = ?');

     $stmt->execute([$userid]);


   $message = "<div class ='container alert alert-success'> this is the form . id  UPDATED</div>";
   redirecthome($message , "back");


}else {

	$message = "<div class ='container alert alert-danger'> this id is not exist </div>";

	redirecthome($message);

}


    	
    }


     elseif( $do == 'Edit') {  //// start of Edit page
         
 $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ?intval( $_GET['userid']) :  "false";
     
    $stmt = $conn->prepare(" SELECT * FROM users WHERE UserID = ? limit 1");
    $stmt->execute([$userid]) ;

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
   if (count($results)>0) {

   echo "this is the form";

      ?>

       <div class="container">
       	<h1>Edit Members </h1>
       	<form class="form-horizontal edit" action="?do=Update" method="POST" >
       	 <div class="form-group-lg">
      <label class="control-label col-sm-2" for="email">User Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="email" placeholder="Enter Name" name="name" value="<?php echo $results[0]['Name']; ?>" required= "required">
      </div>
      <input type="hidden" name="userid" value="<?php echo $userid ;?>">
    </div>
    <div class="form-group-lg">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo $results[0]['Email']; ?>" required= "required">
      </div>
    </div>
    <div class="form-group-lg">
      <label class="control-label col-sm-2" for="pwd">Password:</label>
      <div class="col-sm-10"> 
      <input type="hidden" value="<?php echo $results[0]['PassWord']; ?>" name = "oldpass">         
        <input type="password" class="form-control" id="pwd" placeholder="Enter password or leave it blank" name="newpass">
      </div>
    </div>
     <div class="form-group-lg">
      <label class="control-label col-sm-2" for="full">Fullname:</label>
      <div class="col-sm-10">          
        <input type="text" class="form-control" id="full" placeholder="Enter Fullname" name="full" value="<?php echo $results[0]['FullName']; ?>" required= "required">
      </div>
    </div>
    <div class="form-group-lg">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </div>
  </form>
       </div>




      <?php     }  else {
    
   	$message = "<div class = 'alert alert-danger container'> it is rong there is no such id </div>";
   	redirecthome($message );
   }

}  elseif ($do == 'Update') {
?>
<div class="container">
<h1>UPdate Member</h1></div>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $id = $_POST['userid'] ;

    $user = $_POST['name'] ;

    $email = $_POST['email'];

    $full = $_POST['full'] ;

     



$pass = empty($_POST['newpass']) ? $_POST['oldpass']:  sha1($_POST['newpass']) ;

$formarr = array();

if (empty($_POST['name'])) {
	$formarr[] ="<div class='container alert alert-danger'> name is requered </div>"; 
} 
if (empty( $_POST['email'])) {
	$formarr[] = "<div class='container alert alert-danger'>email is requered </div>" ;
}
if (empty( $_POST['full'])) {
	$formarr[] = "<div class='container alert alert-danger'>full name is requered filed </div>";
}
if (strlen($_POST['newpass']) <= 1 && strlen($_POST['oldpass']) <= 1) {
	$formarr[]= "<div class='container alert alert-danger'>short password </div>";
		
}
foreach ($formarr as $error) {
  	echo $error .'<br>';
  }  

if (empty($formarr)) {

  $stmtcheck = $conn->prepare("SELECT * FROM users WHERE   Name = ? AND UserID != ?");
  $stmtcheck->execute(array($user ,$id));

  $count =  $stmtcheck->rowCount();

  if ($count == 1) {

    echo "<div class= 'container alert alert-danger'>";
    echo "<h3> Sorry exist UserName </h3>";
    echo "</div>";
     $message = " " ;
    redirecthome($message , "back");

  }else{

 $stmt = $conn->prepare('UPDATE users SET Name = ?,PassWord =? , Email =? ,FullName = ? WHERE UserID = ? ') ;


 $stmt->execute([$user, $pass , $email , $full , $id ]) ;


 $message = "<div class='container alert alert-success'> recored updated ". count($stmt) . "</div>";


 redirecthome( $message ,"back") ;
  }

   



   
 
   	
   }
	
}else{


$message = "<div class = 'alert alert-danger container'>you can not browes this page</div>";

redirecthome($message);


}


} 




 include  $tmps.'footer.php';



  } 
  else {
    header('location:index.php');
    exit(); 
  }













 ?>