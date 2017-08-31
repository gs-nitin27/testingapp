<?php 
include('../config1.php');
include('configservice.php');
include('../services/userdataservice.php');

$req = new ConfigService();
$res = $req->log_diet();
if($res == 1)
{
$message = 'log diet assign';
}
else
{  
$message = 'log diet not assigned';
}
$response =  array('status' => $res, 'message' => $message);
echo json_encode($response);
?>





