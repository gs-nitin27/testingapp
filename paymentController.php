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
        $mail = $ino->invoicemail($email['email']);
	}else
	{
         echo json_encode($res);
	}
	

}

else if($_REQUEST['act'] == 'creatHash')
{
   $posted = json_decode(file_get_contents("php://input"));
   //print_r($posted->txnid);die;
   $SALT = "eCwWELxi";
   $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
  //print_r($txnid);die;
   $hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted->hash) && sizeof($posted) > 0) {
  if(
       empty($posted->key)
          || empty($posted->amount)
          || empty($posted->firstname)
          || empty($posted->email)
          || empty($posted->phone)
          || empty($posted->productinfo)
          || empty($posted->surl)
          || empty($posted->furl)
  ) {
    $formError = 1;
  } else {
    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
	$hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';	

   // print_r($hashVarsSeq);die;

	foreach($hashVarsSeq as $hash_var) {
		//print_r($hash_var);die;
      $hash_string .= isset($posted->hash_var) ? $posted->hash_var : '';
      $hash_string .= '|';
    }
    $hash_string .= $SALT;
    $hash = strtolower(hash('sha512', $hash_string));
    $data = array('hashkey' => $hash,'taxid' => $txnid);
    echo json_encode($data);



}
}
}



else if($_REQUEST['act'] == "test")
{
	print_r("expression");
}
?>