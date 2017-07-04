<?php 
include('../config1.php');
include('config_service.php');



$req = new ConfigService();
$res = $req->assign_a_day_log();
if($res == 1)
{
$message = 'log assigned';
}
else
{  
$message = 'log not assigned';
}
$response =  array('status' => $res, 'message' => $message);
echo json_encode($response);
?>