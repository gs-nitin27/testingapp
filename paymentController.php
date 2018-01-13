<?php
include('config1.php');
include('services/emailService.php');
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
	$ino = new emailService();
	$res = $req->payment($paymentdata);

	if($res == '1')
	{
	     	echo json_encode($res);
        $email = $req->findemail($paymentdata->userid);
        $mail = $ino->invoicemail($email,$paymentdata);
	}else
	{
         echo json_encode($res);
	}
}

else if($_REQUEST['act'] == 'creatHash')
{

 $data = (file_get_contents("php://input"));
 $obj  = new paymentServices();
 $resp = $obj->create_hash(json_decode($data));
 echo json_encode($resp);


}





else if($_REQUEST['act'] == "test")
{
	print_r("expression");
}
?>