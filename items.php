<?php 
ob_start();

session_start() ;

$pagetitle = 'show items' ;

include 'int.php';




$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ?intval( $_GET['itemid']) :  "false";
     
    $stmt = $conn->prepare(" SELECT 
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
                 users.UserID=items.memberID where itemID = ? AND Aprove = 1");
    $stmt->execute([$_GET['itemid']]) ;

    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
   if (count($items)>0) {




?>

<div class="information">
	<div class="container">
  <div class="row">
    <div class="col-md-3">
      <img class="img-responsive img-thumbnail" src="1.jpg" alt="">
    </div>
    <div class="col-md-9">
      
      <h3><?php echo $items[0]['itemName']; ?></h3>
        <p><br><?php echo $items[0]['itemDescription']; ?></p>
        <span><?php echo $items[0]['addDate']; ?></span>
        <div><br> The Price <? :php echo $items[0]['itemPrice']; ?></div>
       <div><br>Made in :<?php echo $items[0]['country']; ?></div>
       <div> <br> category Name: <a href="categories.php?pageid=<?php echo $items[0]['catID']; ?>"><?php echo $items[0]['cat_name']; ?></a></div>

<div> <br> User Name: <a href=""> <?php echo $items[0]['username']; ?></a></div>

    </div>

  </div>

  </div>
  </div>
  <hr>
<?php if (isset( $_SESSION['user'])) {?>
  <!-- comment -->
  <div class="container">
    <div class="row">
      <div class="col-md-offset-3">
        <h3>add your comment</h3>
        <form action="<?php echo $_SERVER['PHP_SELF'].'?itemid='.$items[0]['itemID'] ?>" method = 'POST'>
          <textarea class="col-md-6" style="height: 100px;display: block;" name="comm" required="required">
            
          </textarea>
          <input type="submit" value="add comment" class="btn btn-primary" style="margin-left: 8%; margin-top: 70px;">
        </form>
      <?php 
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      
      $comment = filter_var($_POST['comm'] , FILTER_SANITIZE_STRING) ;
       $itemid = $items[0]['itemID'];
        $user    = $_SESSION['userid'];


      if (! empty($comment)) {

        $stmt = $conn->prepare("INSERT INTO 
                         comments
                          (comment ,
                           status ,
                           commdate ,
                            itemid ,
                             userid ) 
                          values
                                (:zcomm ,
                                0 , 
                                  NOW() ,
                                :zitem ,
                                 :zuser)");

        $stmt->execute(['zcomm'=>$comment ,
                        'zitem'=> $itemid ,
                          'zuser'=> $user ]) ;

        if ($stmt) {
        echo "<div class='container alert alert-success col-md-6'><h4> comment Add </h4></div>";
        }

        
      }
      
      }

       ?>


      </div>
  
    </div>
  <hr>
  </div>
  <!-- statement of the comments -->
     <?php 
    $rows = [] ;
  
  $stmt = $conn->prepare("SELECT 
                comments.*  , users.Name 
              AS 
                username
              FROM 
                comments 
             
              INNER JOIN 
                users 
              ON 
                users.UserID=comments.userid WHERE itemid = ? AND status=1 ORDER BY commID DESC ");

  $stmt->execute([$items[0]['itemID']]);

  $rows = $stmt->fetchAll();
  
  

      ?>




<!-- end  -->

<div class="container">
  <div class="row">
    <?php 
    foreach ($rows as $row) {
      echo "<div class='col-md-4'>";
      ?>
  <img src="1.jpg" alt="" class="img-responsive img-thumbnail img-circle">
      <?php
       echo "<span> user :   <a href='profile.php'> ".$row['username']."</a><br></span> <br>";
     echo "<p>comment :". $row['comment']."</p><br>";
        echo "<span>date :".$row['commdate']."<br> </span> <br>";
       
        echo "</div>";
   }

     ?>


  </div>
</div>
  <!-- comment -->

		<?php
    }else{



echo "<div class= 'container alert alert-danger'>log in or register</div>";

echo "<div class= 'container alert alert-info'>";
echo "<a href='login.php'>LOG IN </a>";
echo "</div>";
    }



    } 




     else {
 echo "<div class= 'container alert alert-danger'> Ther is no such id or item is waiting to be Approve </div>";

}

include $tmps.'footer.php';
ob_end_flush();
  ?>


