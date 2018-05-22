<?php
ini_set('display_errors', '0');

// header("Access-Control-Allow-Origin: *");
// header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization, Token, token, TOKEN');
$http_origin = $_SERVER['HTTP_ORIGIN'];

if ($http_origin == "http://www.getsporty.in" || $http_origin == "http://demo.getsporty.in" || $http_origin == "http://staging.getsporty.in" || $http_origin == "http://portal.getsporty.in")
{  
    header("Access-Control-Allow-Origin: $http_origin");
}
// if(isset($_SERVER["HTTP_ORIGIN"]))
// {
//     // You can decide if the origin in $_SERVER['HTTP_ORIGIN'] is something you want to allow, or as we do here, just allow all
//    // header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
// }
// else
// {
//     //No HTTP_ORIGIN set, so we allow any. You can disallow if needed here
//     header("Access-Control-Allow-Origin: *");
// }

//header("Access-Control-Allow-Credentials: true");
//header("Access-Control-Max-Age: 600");    // cache for 10 minutes

if($_SERVER["REQUEST_METHOD"] == "OPTIONS")
{
    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT"); //Make sure you remove those you do not want to support

    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    //Just exit with 200 OK with the above headers for OPTIONS method
    exit(0);
}
$con = mysql_connect('localhost','getsport_gs','ySfT.pf9n~mj');
if($con)
{
//if($_POST['token_id'] == 'dhs2016')
//{	
  $selected = mysql_select_db('getsport_gs') or die("Could not select databasename");
 //}else
 //{
 //echo "<h1>".'Unauthorized Access!'.'</h1>';die;
 //}


 define('UPLOAD_DIR_JOB','../portal/uploads/job/'); 
 define('UPLOAD_DIR_EVENT','../portal/uploads/event/');
 define('UPLOAD_DIR','../portal/uploads/profile/'); 
 define('IMAGE_URL','http://portal.getsporty.in/uploads/profile/');
 define('CHANGE_PASSWORD','http://getsporty.in/user_var/index.php');
 define('PAYU_SUCCESS_URL','https://getsporty.in/');
  
 }
else
{
echo "could not connect";
} 

?>