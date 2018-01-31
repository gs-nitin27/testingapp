<?php
include('config1.php');
include('success_submit.php');



if($_REQUEST['act'] == "mobilePaymentSuccess")
{   

        $paymentdata  =  json_decode(file_get_contents("php://input"));
      
        $req = new payment();

        $date = date("Y-m-d");
        $date1 = explode('-', $date);
        $monthNum  = $date1[1];
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $monthName = $dateObj->format('F');
        $year = date("y");
        $invoiceid = "GSJB/1/".$year.$date1[1].$date1[2]."/".$paymentdata->productinfo;
        $paymentdate = $date1[2]."-" .$monthName."-".$date1[0];

         
        $item = new stdClass();

        $item->status = $paymentdata->status;
        $item->name = $paymentdata->firstname;
        $item->amount = $paymentdata->amount;
        $item->txnid = $paymentdata->txnid;
        $item->hash = $paymentdata->hash;
        $item->key = $paymentdata->key;
        $item->jobid = $paymentdata->productinfo;
        $item->email = $paymentdata->email;
        $item->salt = "e5iIg1jwi8";
        $item->invoiceid = $invoiceid;
        $item->date = $paymentdate;
        $item->transaction_data = json_encode($paymentdata);
                
	    $getuserid = $req->getuserid($item->email);
	    $item->userid = $getuserid['userid'];
	    $res = $req->paymentservice($item);
	    $jobtitle = $req->getjobtitle($item->jobid);  
	    $item->title = $jobtitle['title'];
	    $publish = $req->publishjob($item->jobid);


        $data = array('status' => "1", "data" => []);
	    echo json_encode($data);


}
?>