<?php 

session_start() ;

$pagetitle = 'new ads' ;

include 'int.php';

if (isset( $_SESSION['user'])) {
     

  if ($_SERVER['REQUEST_METHOD']=='POST') {


    
    $formmsg = array();

    $name = filter_var($_POST['itemname'] , FILTER_SANITIZE_STRING ) ; //string
    $desc =  filter_var($_POST['descrip'] ,FILTER_SANITIZE_STRING); //string
    $price =  filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT ); //int
    $country =  filter_var($_POST['country'] , FILTER_SANITIZE_STRING ); 
    $status =  filter_var($_POST['status'] ,FILTER_SANITIZE_NUMBER_INT) ;
    $category =  filter_var($_POST['category'] ,FILTER_SANITIZE_NUMBER_INT);
    $members = $_SESSION['userid'] ;
    if (strlen($name)< 3) {
      $formmsg[] = "<div class = 'container alert alert-danger'> name must be more than 3 char</div>" ;
    } //desc validation
    if (strlen($desc) < 10 ) {
      $formmsg[] = "<div class = 'container alert alert-danger'>description must be more than 10 char</div>" ;
    } // price validation 
    if (empty($price)) {
       $formmsg[] = "<div class = 'container alert alert-danger'>price is empty</div>" ;
    } // status 
    if (empty($status)) {
       $formmsg[] = "<div class = 'container alert alert-danger'>status is empty</div>" ;
    } // category 
    if (empty($category)) {
       $formmsg[] = "<div class = 'container alert alert-danger'>category is empty</div>" ;
    } //country 
    if (strlen($country)< 2) {
      $formmsg[] = "<div class = 'container alert alert-danger'> name must be more than 2 char</div>" ;
    }
/// ///////////////////////////////////////////////////
    //insret in data base
    if (empty($formmsg)) {
      
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
                            ':zcont' => $country ,
                            ':zstatus' => $status,
                            ':zmembers' => $members ,
                            ':zcategory' => $category));


     if ($stmt) {
       
     

    $message = "<div class = 'container alert alert-success'> ".count($stmt)." Advertise is Added </div>" ;
}
  }






  }


?>

<div class="information adsform">
	<div class="container">
  <h1>Create New Ads</h1>
		<div class="panel panel-primary profile">
  <div class="panel-heading">
  Create New Ad
  </div>
  <div class="panel-body">
 <div class="row">
   <div class="col-md-8">
     <!-- form  -->
  <h2>Add New Item</h2>
  <form class="form-horizontal add pull-right" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
   <div class="form-group-lg col-sm-6 col-md-12">
      <label class="control-label col-sm-2" for="name">Name:</label>
      <div class="col-sm-7">
        <input type="text" class="form-control required live-name" id="name" placeholder="Enter name of Item" name="itemname"  required="required">
      </div>
    </div>

    <!-- discription -->
     <div class="form-group-lg col-sm-6 col-md-12">
      <label class="control-label col-sm-3" for="descrip">Descrption:</label>
      <div class="col-sm-4 col-md-6">
        <input type="text" class="form-control live-desc" id="descrip"
         placeholder="Enter Description of Item"
         name="descrip" 
         required="required">
      </div>
    </div>
 <!-- discription -->
 <!-- price -->
<div class="form-group-lg col-sm-6 col-md-12">
      <label class="control-label col-sm-2" for="price">Price:</label>
      <div class="col-sm-7">
        <input type="text" 
        class="form-control live-price" 
        id="price"
         placeholder="Enter Price of Item"
         name="price" 
         required="required">
      </div>
    </div>
 <!-- price -->
  <!-- country -->
<div class="form-group-lg col-sm-6 col-md-12">
      <label class="control-label col-sm-2" for="country">country:</label>
      <div class="col-sm-7">
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
 <!-- category -->
<div class="form-group-lg select" id="cat">
      <label class="control-label col-sm-3" for="category">category:</label>
      <div class="col-sm-4">
        <select name="category" id="category" class="form-control">
          <option value="0">........</option>
          <?php 
           $statement2 =$conn->prepare("SELECT * FROM categouries ") ;
           $statement2->execute();
           $cats= $statement2->fetchAll();
           foreach ($cats as $cat) {
            
            echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
           }

           ?>
        </select>
      </div>
    </div>
 <!--category -->


        <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10 ">
      <div class="row">
        <button id="adadd" type="submit" class="btn btn-primary">Add Advert</button>
        </div>
      </div>
    </div>
  </form>




     <!-- end of form -->
   </div>
   <div class="col-md-4">
     <div class='thumbnail item-box'>

<span class = 'priceitem'>

0$

</span>
<img src="1.jpg" alt="">
<div class = "caption live-preview">
<h3>ads name</h3>

<p>descrip</p>


</div>

   </div>

 </div>


  </div>

</div>

</div>


<div class="container footer">
<?php 
if (!empty($formmsg)) {
foreach ( $formmsg as $msg) {
  echo $msg;
}
}if (isset($message)){

  echo $message;
}

 ?>


</div>

<?php

}else
{
	header('location:login.php') ;
	exit();
}
include $tmps.'footer.php';
  ?>


