<?php 
function lang ($phrase) {

static $lang  = array(
                       'brand'=>'Admin Area'
                       ,'home'=>'HOME PAGE'
                       ,'cat'=>'catigoures' 
                       ,'item'=>'items' 
                       ,'con'=>'anther'
                       ,'pro'=>'EDIT PROFIEL'
                       ,'stat'=>'Statistics'
                       ,'log'=>'LOG OUT'
                       ,'mem'=> 'Members'
                       ,'comm'=> 'Comments' );


return  $lang[$phrase];


}



 ?>