<?php
/*========================
get all function 
===============================
lass v
*/
function getallfrom ( $filed , $table , $where = null , $and = null , $orderfiled , $order = "DESC") {
  global $conn ;

  $getall = $conn->prepare("SELECT $filed FROM $table $where $and ORDER BY $orderfiled $order") ;
  $getall ->execute(); 

  $all = $getall->fetchAll();

  return $all;
}

 
/*
==========================================
function to get all from 
any table of database
=================================
*/

function getall ($tablename , $where = null) {
  global $conn ; 

if ($where == null ) {
  $sql2 = "AND Aprove = 1 " ;
}
else{
  $sql2 = null ;
}

  $stmt = $conn->prepare("SELECT * FROM $tablename  $sql ORDER BY itemID DESC ");
  $stmt ->execute();

   $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

   return $results ;
}
/*=============================================*/

// title function 

function gettitle () {

  global $pagetitle ;

  if (isset($pagetitle)) {

    echo $pagetitle ;

  }
  else {

    echo "Default";

  }
}
// title function 
/*
==========================================
function to get categories from 
categories table of database
=================================
*/

function getcat () {
  global $conn ;

  $stmt = $conn->prepare("SELECT * FROM categouries ORDER BY ID ASC ");
  $stmt ->execute();

   $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

   return $results ;
}

/*
==========================================
function to get items from 
items table of database
=================================
*/

function getitems ($where , $value , $approve = null) {
  global $conn ;

  if ($approve == null) {
    
    $sql = "AND Aprove = 1 " ;
  }
  else {
    $sql = null ;
  }

  $stmt = $conn->prepare("SELECT * FROM items Where $where = ?  $sql ORDER BY itemID DESC");
  $stmt ->execute([$value]);

   $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

   return $items ;
}




// dump and die 
function dd($param)
{
	var_dump($param);die();
}

/////////redirect function 


function redirecthome ($message ,$url = null) {


 echo "<div class='alert alert-info container'>you will be redirect to home page after 5 seconds </div> ";
   
  echo $message;

  if ($url === null) {

  $url = 'index.php' ;


 } else {


$url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $_SESSION['previous_url'];

 }

 header("Refresh:5 ; $url");

 exit();
}
/*
*****************************

dynamic function to create check 
on if item is exist befor in te database
*/
function check ( $select , $from , $value) {
  global $conn ;

  $statment = $conn->prepare("SELECT $select FROM $from WHERE $select =	?");

  $statment->execute(array($value));
  $results = $statment->fetchAll(PDO::FETCH_ASSOC);

  
   return count($results); 

}
/*
**the function of  items
**numbers of items
**column of the item
** the table 
*/
function countitem ( $filed , $table ){
   global  $conn ;
    $stmt2 = $conn->prepare("SELECT COUNT($filed) FROM $table") ;
    $stmt2->execute();
    return $stmt2->fetchColumn();

}
/*
** function v1 to get latest mrmbers from database 
** selected filed
**table required
**order 
**limite
*/ 
function getlast ($select , $table , $orderby, $limite=5 ) {
  global $conn ;

  $stmt = $conn->prepare("SELECT $select FROM $table ORDER BY $orderby DESC LIMIT $limite");
  $stmt ->execute();

   $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

   return $results ;



}



/*/
==================================

check redstatus in databse table user

===========================
 */
function checkstatus ($user) {
global $conn ;

$stmtx = $conn->prepare("SELECT 
                           Name ,RedStatus  
                        FROM 
                          users
                       WHERE 
                            Name = ?
                        and
                           RedStatus = 0 ");

         $stmtx->execute(array($user));
         $status = $stmtx->rowCount();

        return $status ;
}



 
 ?>