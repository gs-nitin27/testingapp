<?php
include('config1.php');
include('services/paymentServices.php');

if($_REQUEST['act'] == "paymentPlan")
{

	$req = new paymentServices();
	$res = $req->paymentPlan();
	echo json_encode($res);
}

else if($_REQUEST['act'] == "payment")
{

	$paymentdata  =  json_decode(file_get_contents("php://input"));

	$req = new paymentServices();
	$res = $req->payment($paymentdata);
	echo json_encode($res);

}

?>