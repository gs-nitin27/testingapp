<?php
include('config1.php');
include('services/emailService.php');
include('services/paymentServices.php');

if($_REQUEST['act'] == "paymentPlan")
{
	$req = new paymentServices();
	$res = $req->paymentPlan();

	if($res)
	{
		$data = array('data' => $res, 'status' => '1');
	    echo json_encode($data);
    }else
    {
        $data = array('data' => [], 'status' => '0');
	    echo json_encode($data);
    }
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

else if($_REQUEST['act'] == "useremaildata")
{
  $userid = $_REQUEST['userid'];
   $obj  = new paymentServices();
  $res = $obj->useremaildata($userid);
  echo json_encode($res);
}


else if($_REQUEST['act'] == "getTransactionList")
{
	$userid = $_REQUEST['userid'];

	$req = new paymentServices();
	$res = $req->getTransactionList($userid);
    if($res != 0)
	  {
	   $res = array('status' =>'1' , 'data'=>$res ,'msg' => 'Success');
	  }
  else
	  {
	   $res = array('status' =>'0' , 'data'=>[] ,'msg' => 'Failure');
	  }
    echo json_encode($res);
}

else if($_REQUEST['act'] == "getInvoiceData")
{
	$invoiceid = $_REQUEST['invoiceid'];

	$req = new paymentServices();
	$res = $req->getInvoiceData($invoiceid);
	echo json_encode($res);
}
?>