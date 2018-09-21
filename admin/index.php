<?php 

session_start();

$nonavbar = '' ;

$pagetitle = 'login';

if (isset($_SESSION['Username'])) {
   // header('location:dashbord.php');
}

include 'int.php';



// log in script 
$username = '' ;
$password = '' ;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

if (isset($_POST['user']) && isset($_POST['pass']) && $_POST['pass'] != '' && $_POST['user'] != '' ) {
	

 $username =$_POST['user'];
 $password = $_POST['pass'];
 $hashedpass = sha1($password);

$stmt = $conn->prepare("SELECT UserID , Name , PassWord FROM 
 users WHERE 
  Name = ?
  and
   PassWord = ? 
 and
  GroupID = 1
   limit 1");
$stmt->execute([$username,$hashedpass]);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($results);
// die();

 // print_r($results);
 //   die();


 if (count($results)>0){

 	 $_SESSION['Username'] = $username ;

 	 
     $_SESSION['ID'] = $results[0]['UserID'];	 

     
 	 header('location:dashbord.php ');

 	}
}

	
}



 ?>
<form action="" method="POST" class="login">
 <h3> ADMIN LOG IN</h3>
	<input type="text" class="form-control input-lg" name="user" placeholder="USER NAME">
	<input type="password" class="form-control  input-lg" name="pass" placeholder="PASSWORD">
	<input type="submit" class="form-control btn btn-primary input-lg" value="log in">

</form>

 <?php 

include $tmps.'footer.php';
  ?>