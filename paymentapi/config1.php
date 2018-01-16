<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization, Token, token, TOKEN');
if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){
    exit();
}
$con = mysql_connect('localhost','root','');
if($con)
{
//if($_POST['token_id'] == 'dhs2016')
//{	
  $selected = mysql_select_db('getsport_staging') or die("Could not select databasename");
 //}else
 //{
 //echo "<h1>".'Unauthorized Access!'.'</h1>';die;
 //}


 define('UPLOAD_DIR_JOB','../staging/uploads/job/'); 
 define('UPLOAD_DIR_EVENT','../staging/uploads/event/');
 define('UPLOAD_DIR','../staging/uploads/profile/'); 
 define('IMAGE_URL','http://staging.getsporty.in/uploads/profile/');
 define('CHANGE_PASSWORD','http://getsporty.in/user_var/index.php');
  
 }
else
{
echo "could not connect";
} 

?>