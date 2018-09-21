<?php
session_start();

$pagetitle = 'login';
if (isset($_SESSION['user'])) {
   // header('location:index.php');
}

require 'int.php';

// log in script 
$user = '' ;
$pass = '' ;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

if (isset($_POST['login'])) {
  


 $user =$_POST['name'];
 $pass = $_POST['pwd'];
 $hashedpassword = sha1($pass);


$stmt = $conn->prepare("SELECT UserID , Name , PassWord FROM 
 users WHERE 
  Name = ?
  and
   PassWord = ? ");

$stmt->execute(array($user , $hashedpassword));

$results = $stmt->fetchAll();


// var_dump($results);
// die();

 // print_r($results);
 //   die();


 if (count($results)>0){

 	 $_SESSION['user'] = $user ; 

   $_SESSION['userid'] = $results[0]['UserID'] ;
     
     
 	 header('location:index.php ');

 	 exit();

 	}
  
  }   elseif(isset($_POST['signup'])) {
    $formmsg = array();

  if (isset($_POST['name'])) {

    $filtername = filter_var($_POST['name'] , FILTER_SANITIZE_STRING);

     if (strlen($filtername)<4) {

            $formmsg[] = "<div class='container alert alert-danger'>too short user name , Please enter name more than that</div>" ;

      }

    }

  //validate password
if (isset($_POST['pwd']) && isset($_POST['pwd2'])) {
if (empty($_POST['pwd']) && empty($_POST['pwd2'])) {
  $formmsg[] = "<div class='container alert alert-danger'>passwords can not be empty</div>" ;
 
}

    
     $pass1 = sha1($_POST['pwd']) ;
     $pass2 = sha1($_POST['pwd2']) ;

 if ($pass1 === $pass2) {
       
     }
  elseif($pass1 !== $pass2) { 

 $formmsg[] = "<div class='container alert alert-danger'>passwords is not the same</div>" ;

}

    }
    /// validate email filed input 
if (isset($_POST['email2'])) {


$filtemail = filter_var($_POST['email2'] , FILTER_SANITIZE_EMAIL);

if (filter_var($filtemail,  FILTER_SANITIZE_EMAIL) !=  true) {
  $formmsg[] = "<div class='container alert alert-danger'>it is not email form </div>";
}
   
  }
  ///////////////////////////


   if (empty($formmsg)) {

     $value =$_POST['name'] ;

      $test = check ( "Name","users",$value );
      if ($test == 1) {
        $formmsg = "<div class='alert alert-danger container'>sory this user is already exist </div>";
      }  else {

      $name = $_POST['name'] ;
      $email = $_POST['email2'] ;
      $pass = sha1($_POST['pwd']);
      $pass2 = sha1($_POST['pwd2']);

     $stmt = $conn->prepare("INSERT INTO
           users (Name ,
                  PassWord ,
                  Email ,
                  FullName , RedStatus ,mydate ) VALUES 
                                  (:zname , 
                                  :zpass , 
                                  :zemail ,
                                   :zfull, 
                                   0 , now())") ; 
     $stmt->execute( array(':zname' => $name,
                            ':zpass' => $pass,
                            ':zemail' => $email,
                            ':zfull' => $name));

     $succssmsg = "<div class='container alert alert-success'> adding is done " .count($stmt)."record </div>";
      } 

  }






    /////////
  }

}

	



?>

<div class="container logindiv">
  <h2 class="text-center hactive"> <span class="actv" data-class = "loginform">LOG IN </span>|<span class="disactv" data-class = "signupform"> SIGN UP </span></h2>
  <form class="form-horizontal text-center fform loginform" action=""  method="POST">
    <div class="form-group">
      <label class="control-label col-sm-2" for="name">Name:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" autocomplete="off" required="required">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Password:</label>
      <div class="col-sm-6">          
        <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd"  autocomplete="new-password" required="required">
      </div>
    </div>
      <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-6">
        <button type="submit" class="btn btn-primary" name="login">Submit</button>
      </div>
    </div>
  </form>

  <!-- /////////////////////sign up -->
  <form class="form-horizontal text-center fform signupform" action="" method="POST">
    <div class="form-group">
      <label class="control-label col-sm-2" for="name2">Name:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" id="name2" placeholder="Enter Name" name="name" autocomplete="off" pattern="{4 , 50}"
        title="user name between 4 and 50 char" required="required">
      </div>
    </div>
<div class="form-group">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-6">
        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email2" required="required">
      </div>
    </div>


    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd2.1">Password:</label>
      <div class="col-sm-6">          
        <input type="password" class="form-control" id="pwd2.1" placeholder="Enter password" name="pwd"  autocomplete="new-password" required="required">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd2">confirm password :</label>
      <div class="col-sm-6">          
        <input type="password" class="form-control" id="pwd2" placeholder="confirm password" name="pwd2"  autocomplete="new-password" required="required">
      </div>
    </div>
      <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-6">
        <button type="submit" class="btn btn-primary" name="signup">Submit</button>
      </div>
    </div>
  </form>
</div>
<div class="container formerrors">

<?php 
if (!empty($formmsg)) {

  foreach ($formmsg as $msg) {
    echo $msg;
  }
  
}
if (isset($succssmsg)) {
  echo $succssmsg;
}


 ?>
  
</div>




<?php
require $tmps.'footer.php';
 ?>