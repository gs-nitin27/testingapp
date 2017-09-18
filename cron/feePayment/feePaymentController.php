<?php 
include('../../config1.php');
include('feePaymentServices.php');


$req = new feePaymentServices();
$res = $req->feePaymentCount();
if($res == 1)
{
$message = 'Row Inserted';
}
else
{  
$message = 'Row Not Inserted';
}
$response =  array('status' => $res, 'message' => $message);
echo json_encode($response);
?>