<?php 
ob_start();
session_start();
 $pagetitle = 'categories' ;
if (isset($_SESSION['Username'])) {

	  include 'int.php';
	  $do = isset($_GET['do']) ? $_GET['do'] :"Manage" ;

//pages insert = add , update=edit , delete
if ($do == "Manage") {
	$sort = 'ASC';
	$sort_arr = array('ASC' , 'DESC') ;
	if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_arr)) {
		$sort = $_GET['sort'] ;
	}
    $stmt3 = $conn->prepare("SELECT * FROM categouries WHERE parent = 0  ORDER BY Ordering $sort");
    $stmt3 ->execute();
    $cats	=	$stmt3->fetchAll();

    ?>  
    <!-- shoow categories in panel -->
    
    <div class="container">
    <h1>Manage Categories</h1>
    	<div class="panel panel-default">
    		<div class="panel-heading">Manade Categories 
    		 <div class="pull-right">
    		 	<a href="?sort=ASC">ASC</a>
    		 	<a href="?sort=DESC">DESC</a>
    		 </div></div>
    		<div class="panel-body">
    			<?php 

          if (!empty($cats)) {
            
          
    			foreach ($cats as $cat) {
    				echo "<div class ='category'>";
    				echo "<div class ='buttons' id  ='cat-btn'>";
            echo "<a href='category.php?do=Edit&catid=".$cat['ID']."  '  id ='cat-btn1' class = 'btn btn-primary'>Edit </a>";
    				echo "<a href='category.php?do=Delete&catid=".$cat['ID']."' id ='cat-btn2' class = 'confirm btn btn-danger'>Delete </a>";
    				echo "</div>";
    			   echo "<h3>".$cat['Name'] ;
             if ($cat['Descrip'] == '') { 
              echo "";
             } else {echo "<small> ".$cat['Descrip']." </small>";} 
             echo "</h3>";
    			   // echo "<p>" ;

    			   //  if ($cat['Descrip'] == '') {	
    			   // 	echo "this category has no discription";
    			   // } else {echo $cat['Descrip'];} 

    			   // echo"</p>";
    			   
    			   if ($cat['Visability'] == 1) {
    			   	echo "<span id ='vis'>" ;
    			   	echo "visability disabled";
    			   	echo "</span>" ;
    			   }
    			   
    			   
    			  if ( $cat['allowComm'] == 1) {
    			  	echo "<span id ='comm'> "; 
    			  	echo "comment disabled";
    			  	echo "</span>";
    			  }
    			   
    			   
    			   if ($cat['allowAdds'] == 1) {
    			   	echo "<span id ='add'>" ; 
    			   	echo "Adds is disabled";
    			   	 echo "</span>";
    			   }

    			   echo "</div>";
      

              $id = $cat['ID'] ;
 
$chiledcats = getallfrom ( "*" , "categouries" , "WHERE parent = $id" , "" , "ID" , "ASC") ;
if (!empty($chiledcats)) {
  

?>

<ul class="list-unstyled">
<?php
  foreach ($chiledcats as $ccate) {
echo "<li> <h4 class = 'subheader'>";
echo "-".$ccate['Name']; 
echo "</h4> ";
echo "<div class ='category'>";
            echo "<div class ='buttons' id  ='cat-btn'>";
            echo "<a href='category.php?do=Edit&catid=".$ccate['ID']."  '  id ='cat-btn1' class = 'btn btn-primary cat-btn3'>Edit </a>";
            echo "<a href='category.php?do=Delete&catid=".$ccate['ID']."' id ='cat-btn2' class = 'confirm btn btn-danger cat-btn3'>Delete </a>";
            echo "</div>";



              if ($ccate['Descrip'] == '') {  
              echo "this category has no discription";
             } else {echo $cat['Descrip'];} 

             echo"</p>";
             
             if ($ccate['Visability'] == 1) {
              echo "<span id ='vis'>" ;
              echo "visability disabled";
              echo "</span>" ;
             }
             
             
            if ( $ccate['allowComm'] == 1) {
              echo "<span id ='comm'> "; 
              echo "comment disabled";
              echo "</span>";
            }
             
             
             if ($ccate['allowAdds'] == 1) {
              echo "<span id ='add'>" ; 
              echo "Adds is disabled";
               echo "</span>";
             }

echo"</li>";
  }
  echo "</ul>";

  }
    			   echo "<hr>";
   

            

    			 } 

 


            }else {
              ?>
<div class="container alert alert-info">There Is No Categories Registered </div>
              <?php
            }


    			 ?>
    		</div>
    	</div>
    	<a href="category.php?do=Add" class="btn btn-primary">Add New Category </a>
    </div>
     

    <?php
	 
/// end of manage page of categories
	  }
 elseif ($do == "Add") {


	  	?>

        <div class="container">
  <h2>Add Category</h2>
  <form class="form-horizontal add" action="?do=Insert" method="POST">
   <div class="form-group-lg">
      <label class="control-label col-sm-2" for="name">Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="name" placeholder="Enter name of category" name="name"  required="required">
      </div>
    </div>

    <div class="form-group-lg">
      <label class="control-label col-sm-2" for="desc">Description:</label>
      <div class="col-sm-10">          
        <input type="text" class="form-control" id="desc" placeholder="Enter Description" name="desc">
      </div>
    </div>
    <div class="form-group-lg">
      <label class="control-label col-sm-2" for="order">Order:</label>
      <div class="col-sm-10">
        <input type="number" class="form-control" id="order" placeholder="Enter order" name="order">
      </div>
    </div>
   <!-- select box for parent -->

    <div class="form-group-lg">
    <div class="">
      <label class="control-label col-sm-2" for="parent">parent?</label>
      <div class="col-sm-10 parent">
        <select name="parent" id="parent">
          <option value="0">None</option>
          <?php 
          $cats =  getallfrom ( "*" , "categouries" , "WHERE parent = 0" , "" , "ID" , "ASC") ;

          foreach ($cats as $cat) {
            echo "<option value = '".$cat['ID']."'>";
            echo $cat['Name'];
            echo "</option>";

          }


           ?>
        </select>
        </div>
      </div>
    </div>

<!-- select box for parent -->    
      <div class="form-group-lg">
      <label class="control-label col-sm-2">Visablity </label>
      <div class="col-sm-2">
       <label for="visable">Yes</label>
        <input type="radio" name="visable" value="0" checked id="visable-yes"><br>
        <label for="visable-no">No</label>
        <input type="radio" name="visable" value="1"  id="visable-no">
      </div>
    </div>

    <div class="form-group-lg">
      <label class="control-label col-sm-2">Allow Comment </label>
      <div class="col-sm-2">
       <label for="visable">Yes</label>
        <input type="radio" name="comm" value="0" checked id="comm-yes"><br>
        <label for="visable-no">No</label>
        <input type="radio" name="comm" value="1"  id="comm-no">
      </div>
    </div>
    <div class="form-group-lg col-sm-4">
      <label class="control-label col-sm-2">Allow adds </label>
      <div class="col-sm-10">
       <label for="adds-yes"> Yes</label>
        <input type="radio" name="adds" value="0" checked id="adds-yes"><br>
        <label for="adds-no"> No</label>
        <input type="radio" name="adds" value="1"  id="adds-no">
      </div>
    </div>
     

    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary">Add Category</button>
      </div>
    </div>
  </form>
</div>

    	<?php 


	  }
 elseif ($do == "Insert") {// insert in database
 	$name ='';
 	$desc = '' ;
 	$order = '' ;
 	$visable = '' ;
 	$comm = '';
 	$adds ='';
 	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 		echo "<h1>";
 		echo "insert catecorey";
 		echo "</h1>";
 	$name 		=	$_POST['name'];
 	$desc 		=  	$_POST['desc'];
  $parent   =   $_POST['parent'] ;
 	$order 		=  	$_POST['order'];
 	$visable 	=  	$_POST['visable'];
 	$comm 		=  	$_POST['comm'];
 	$adds 		= 	$_POST['adds'];

 	 $value =$_POST['name'] ;
     $test = check ( "Name","categouries",$value );
     if ($test == 1) {
    $message = "<div class='alert alert-danger container'>sory this category is already exist </div>";
    redirecthome($message ,"back");

    }else {
    	 $stmt = $conn->prepare("INSERT INTO
           categouries (Name ,
          	      Descrip ,
                  parent,
          	      Ordering ,
          	      Visability , allowComm ,allowAdds ) VALUES 
          	                      (:zname , 
          	                      :zdesc , 
                                  :zparent, 
          	                      :zorder, 
          	                      :zvis ,
          	                       :zcomm ,
          	                       :zadds)") ; 
     $stmt->execute( array(':zname' => $name ,
                            ':zdesc' => $desc,
                            ':zparent' => $parent,
                            ':zorder' => $order,
                            ':zvis' =>$visable, 
                            ':zcomm' => $comm ,
                            ':zadds' => $adds));

     $message = "<div class='container alert alert-success'> adding is done " .count($stmt)."record </div>";
     redirecthome($message , "back");
      


	}

 	

 	}


	  	// echo "welcome to insert" ;
 	 else {
     	$message = "<div class='alert alert-danger container' > not valide asking page directly";
     	// $seconds = "30";
     	redirecthome($message);
     }

	  }
 elseif ($do == "Edit") {
  $catid  = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0 ;
  // select all data depends on id
  $stmt = $conn->prepare("SELECT * FROM categouries where ID = ?");
  //execute stmt 
  $stmt->execute([$catid]) ;

  //fech data 
  $cat = $stmt->fetchAll();
  // if there is such id 
  $count =$stmt->rowCount();

  if ($count > 0) {

	  	?>

        <div class="container">
  <h2>Edit Category</h2>
  <form class="form-horizontal add" action="?do=Update" method="POST">
   <div class="form-group-lg">
      <label class="control-label col-sm-2" for="name">Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="name" placeholder="Enter name of category" name="name"  required="required" value="<?php echo $cat[0]['Name']; ?>">
      </div>
    </div>
    <!-- very important value id from http request -->
<input type="hidden" name="catid" value="<?php echo $catid ;?>">
    <div class="form-group-lg">
      <label class="control-label col-sm-2" for="desc">Description:</label>
      <div class="col-sm-10">          
        <input type="text" class="form-control" id="desc" placeholder="Enter Description" name="desc" value="<?php echo $cat[0]['Descrip']; ?>">
      </div>
    </div>
    <div class="form-group-lg">
      <label class="control-label col-sm-2" for="order">Order:</label>
      <div class="col-sm-10">
        <input type="number" class="form-control" id="order" placeholder="Enter order" name="order" value="<?php echo $cat[0]['Ordering']; ?>">
      </div>
    </div>
    <!-- select box for parent -->

    <div class="form-group-lg">
    <div class="">
      <label class="control-label col-sm-2" for="parent">parent?</label>
      <div class="col-sm-10 parent">
        <select name="parent" id="parent">
          <option value="0">None</option>
          <?php 
          $cts =  getallfrom ( "*" , "categouries" , "WHERE parent = 0" , "" , "ID" , "ASC") ;

          foreach ($cts as $ct) {
            echo "<option value = '".$ct['ID']."'";
            if ($cat[0]['parent'] == $ct['ID']) {
              echo "selected = 'selected'";
            }

            echo ">";
            echo $ct['Name'];
            echo "</option>";

          }


           ?>
        </select>
        </div>
      </div>
    </div>

<!-- select box for parent -->    
    
      <div class="form-group-lg">
      <label class="control-label col-sm-2">Visablity </label>
      <div class="col-sm-2">
       <label for="visable">Yes</label>
        <input type="radio" name="visable" value="0" checked id="visable-yes"
        <?php if ($cat[0]['Visability'] == 0) {echo 'checked'; } ?> ><br>
        <label for="visable-no">No</label>
        <input type="radio" name="visable" value="1"  id="visable-no"  
        <?php if ($cat[0]['Visability'] == 1) {echo 'checked'; } ?>>
      </div>
    </div>

    <div class="form-group-lg">
      <label class="control-label col-sm-2">Allow Comment </label>
      <div class="col-sm-2">
       <label for="visable">Yes</label>
        <input type="radio" name="comm" value="0" checked id="comm-yes" <?php if ($cat[0]['allowComm'] == 0) {echo 'checked'; } ?>><br>
        <label for="visable-no">No</label>
        <input type="radio" name="comm" value="1"  id="comm-no" <?php if ($cat[0]['allowComm'] == 1) {echo 'checked'; } ?>>
      </div>
    </div>
    <div class="form-group-lg col-sm-4">
      <label class="control-label col-sm-2">Allow adds </label>
      <div class="col-sm-10">
       <label for="adds-yes"> Yes</label>
        <input type="radio" name="adds" value="0" checked id="adds-yes"
        <?php if ($cat[0]['allowAdds'] == 0) {echo 'checked'; } ?>><br>
        <label for="adds-no"> No</label>
        <input type="radio" name="adds" value="1"  id="adds-no"
        <?php if ($cat[0]['allowAdds'] == 1) {echo 'checked'; } ?>>
      </div>
    </div>

     

    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary">save Category</button>
      </div>
    </div>
  </form>
</div>

    	<?php 





  
   }else {
  $message = "<div class = 'alert alert-danger container'>No Such ID </div>"; 
  redirecthome($message);
  }
	  	

	  }
 elseif ($do == "Update") {
 	echo "<h1 class = 'text-center'>Update Category</h1>";
 	
 	$name ='';
 	$desc = '' ;
 	$order = '' ;
 	$visable = '' ;
 	$comm = '';
 	$adds ='';

 	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     $id 		=	$_POST['catid'];
 	$name 	    =	$_POST['name'];
 	$desc 		=  	$_POST['desc'];
 	$order 		=  	$_POST['order'];
  $parent    =   $_POST['parent'];
 	$visable 	=  	$_POST['visable'];
 	$comm 		=  	$_POST['comm'];
 	$adds 		= 	$_POST['adds'];
 	 	$stmt = $conn->prepare("UPDATE
 	 								categouries 
 	 									SET 
 	 									Name =? ,
 	 									Descrip = ? ,
 	 									Ordering = ? ,
                    parent = ?  ,
 	 									Visability = ? ,
 	 									allowComm = ? ,
 	 									allowAdds = ?  	WHERE ID = ? 
 	 									");
 $stmt->execute([$name , $desc  , $order ,$parent , $visable , $comm , $adds , $id]);

 $message = "<div class = 'alert alert-success container'>".$stmt->rowCount() . "  Recored updated </div>" ;

 redirecthome($message , "back");
	
 	}else {

 		$message = "<div class = 'alert alert-danger container' > you cant brows this page directly </div>" ;
 		redirecthome($message );
 	}



      


	  	
// end of update page
	  } 
 elseif ($do == "Delete") {
echo "<h1> Delete category</h1>";
$catid = isset($_GET['catid'])&& is_numeric($_GET['catid']) ? intval($_GET['catid']):"false" ;
$checked = check("ID" , "categouries" ,$catid) ;


if ($checked > 0) {
	$stmt = $conn-> prepare("DELETE FROM categouries WHERE ID = ?") ;
	$stmt->execute([$catid]) ;
	$message = "<div class = 'alert alert-success container '> recored has been deleted </div>";
	redirecthome($message , "back") ;

}else {

	$message = "<div class = 'container alert alert-danger'>you cannot browes this page directly </div>";

	redirecthome($message) ;
}



	  	

	  }







  include $tmps .'footer.php';
}
else {
header('location:index.php');
exit();
}