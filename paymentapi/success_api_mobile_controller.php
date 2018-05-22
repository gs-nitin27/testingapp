<?php
include('config1.php');
include('success_submit.php');

if($_REQUEST['act'] == 'mobilePaymentSuccess')
{   

        $fulldata  =  json_decode(file_get_contents("php://input"));
        
        $paymentdata1 =  json_decode($fulldata->payuData);  
        $paymentdata  =  $paymentdata1->result;
              
        $req = new payment();
        $date = date("Y-m-d");
        $date1 = explode('-', $date);
        $monthNum  = $date1[1];
        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
        $count = $req->getCount();
        $monthName = $dateObj->format('F');
        $year = date("y");
        if($fulldata->module == '1')
        {
        $invoiceid = "GSJB/1/".$year.$date1[1].$date1[2]."/".$paymentdata->productinfo."/".$count['sale'];        
        }
        else if ($fulldata->module == '2') 
        {
        $invoiceid = "GSEV/2/".$year.$date1[1].$date1[2]."/".$paymentdata->productinfo."/".$count['sale'];
        }
        
        $paymentdate = $date1[2]."-".$monthName."-".$date1[0];
         
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
        $item->module = $fulldata->module;
        $item->transaction_data = json_encode($paymentdata);

        $item->userid = $fulldata->userid;
	$res = $req->paymentservice(json_encode($item));
	$item->title = $fulldata->title;
	$publish = $req->publishjob($fulldata->id,$fulldata->module);
        $mail = $req->invoicemail($item->email,$item);     

        $data = array('status' => "1", "data" => []);

	echo json_encode($data);
}

?>