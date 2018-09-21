<?php 
ob_start();
session_start();
 
 

  if (isset($_SESSION['Username'])) {
    

    $pagetitle = 'dashbord';

    include 'int.php';
	$latestusers = 5;
	$last = getlast("*", "users" , "UserID" ,$latestusers );
	$itemlimet = 6 ;
    $lastitems = getlast( "*" , "items" , "itemID" , $itemlimet);

  ?>
  

  <div class="container home text-center">
  		<div class="row">
  			<div class="col-md-3">
  				<div class="stat">Total Members 
  				    <span> <a href="members.php"><?php echo countitem('UserID' ,'users') ;?></a></span>
  				</div>
  			</div>
  			<div class="col-md-3">
  				<div class="stat">pending Members 
  				    <span>
  				    	<a href="members.php?do=Manage&page=pending">
  				    		<?php echo check ( "RedStatus" , "users" ,  0); ?>
  				    	</a>
  				    </span>
  				</div>
  			</div>
  			<div class="col-md-3">
  				<div class="stat">Total Items 
  				    <span><a href="items.php"><?php echo countitem('itemID' ,'items') ;?></a></span>
  				</div>
  			</div>
  			<div class="col-md-3">
  				<div class="stat">Total comments 
  				    <span> <a href="comments.php"><?php echo countitem('commID' ,'comments') ;?></a></span>
  				</div>
  			</div>
  		</div>
  	</div>	
<div class="container latest">
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading">
				
					<h2>latest register users</h2>
				</div>
				<div class="panel-body">
				<ul class="list-unstyled listlast">
					<?php 
					if (!empty($last)) {
						
					

			foreach ($last as $user) {
			echo '<li>';		
			echo  $user['Name'] ;
			echo'<a href="members.php?do=Edit&userid='. $user['UserID'].' ">';
			echo "<button class ='btn btn-success pull-right'>";
			echo "Edit";
			echo "</button>";
			echo  '</a>';
			 if ($user['RedStatus'] == 0) {
      	?>
        <a  href="members.php?do=Activate&userid=<?php echo$user['UserID'] ?>" class="btn btn-info pull-right" id = "act"> Activate</a>
      	<?php

      }
			echo '</li>' ;
						    } }
		            ?>
		            </ul>
				</div>
			</div>
		</div>

		<div class="col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>latest  Items</h2>
				</div>
				<div class="panel-body">
					<ul class="list-unstyled listlast">
					<?php 
					if (!empty($lastitems)) {
						
					

			foreach ($lastitems as $item) {
			echo '<li>';		
			echo  $item['itemName'] ;
			echo'<a href="items.php?do=Edit&itemid='. $item['itemID'].' ">';
			echo "<button class ='btn btn-success pull-right'>";
			echo "Edit";
			echo "</button>";
			echo  '</a>';
			 if ($item['Aprove'] == 0) {
      	?>
        <a  href="items.php?do=Approve&itemid=<?php echo$item['itemID'] ?>" class="btn btn-info pull-right" id = "act"> Approve</a>
      	<?php

      }
			echo '</li>' ;
						    }

						    }else {

?>
<div class="alert alert-info"><h4>NO Items here</h4></div>
<?php


						    }
		            ?>
		            </ul>

				</div>
			</div>
		</div>

<div class="col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading">
				
					<h2>latest register Comment</h2>
				</div>
				<div class="panel-body">
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
                users.UserID=comments.userid ORDER BY commID DESC limit 3");

  $stmt->execute();

  $rows = $stmt->fetchAll();


  if (!empty($rows)) {
  	
  

  foreach ($rows as $row) {
  	
  	echo "<div class = 'container'>";
     echo "<h3>";
     echo $row['username'] . "<span class = 'said'> Say </span>";
      echo "</h3>";
 echo "<div class = 'parastyle'>";
 echo "<p>";
 echo $row['comment'];
 echo "</p>";
  	echo "</div>" ;
  	echo "</div>" ;
  }
} else {
 ?>
<div class="alert alert-info">Sorry There Is No Items </div>

<?php } ?>
				
				</div>
			</div>
		</div>






	</div>
</div>

<?php
 include  $tmps.'footer.php';
  } 
  else {
    header('location:index.php');
    exit(); 
  }

ob_end_flush();

 ?>