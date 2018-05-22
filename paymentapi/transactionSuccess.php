<?php
include('../config1.php');
include('success_submit.php');

$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$udf1=$_POST["udf1"];
$salt="e5iIg1jwi8";


//print_r(json_encode($_POST));die;

If (isset($_POST["additionalCharges"])) {
       $additionalCharges=$_POST["additionalCharges"];
        $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||'.$udf1.'|'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        
                  }
	else {	  

        $retHashSeq = $salt.'|'.$status.'||||||||||'.$udf1.'|'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;

         }
         //echo $retHashSeq;die;
		 $hash = hash("sha512", $retHashSeq);
		 
       if ($hash != $posted_hash) {
        echo "Invalid Transaction. Please try again";
       // echo $retHashSeq;echo '------'.$posted_hash;die;
	}
	else { 
                $req = new payment();

                $date = date("Y-m-d");
                $date1 = explode('-', $date);
                $monthNum  = $date1[1];
                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                $monthName = $dateObj->format('F');
                $year = date("y");
                $count = $req->getCount();
                $invoiceid = "GSJB/1/".$year.$date1[1].$date1[2]."/".$_POST["productinfo"]."/".$count['sale'];
                $paymentdate = $date1[2]."-" .$monthName."-".$date1[0];
                 
                $item                    = new stdClass();
                $item->status            = $_POST["status"];
                $item->name              = $_POST["firstname"];
                $item->amount            = $_POST["amount"];
                $item->txnid             = $_POST["txnid"];
                $item->hash              = $_POST["hash"];
                $item->key               = $_POST["key"];
                $item->jobid             = $_POST["productinfo"];
                $item->email             = $_POST["email"];
                $item->userid            = $_POST["udf1"];
                $item->salt              = "e5iIg1jwi8";
                $item->invoiceid         = $invoiceid;
                $item->date              = $paymentdate;
                // $data = $_POST;
                // $data['j_title'] =
                $item->transaction_data  = json_encode($_POST);
                
                
                $jobtitle = $req->getjobtitle($item->jobid);  
                $item->title = $jobtitle['title'];
                $publish = $req->publishjob($item->jobid,'1');
                $tr_data = $_POST;
                $tr_data['j_title'] = $item->title;
                $tr_data['invoiceid'] = $item->invoiceid;
                $tr_data['date'] = $item->date;
                $tr_data['userid'] = $item->userid;
                $tr_data['jobid']  = $item->jobid;
                $tr_data['module'] = '1';
                $res = $req->paymentservice(json_encode($tr_data));
                $mail = $req->invoicemail($item->email,$item);     
         

                echo "<h3>Thank You. Your order status is ". $status .".</h3>";
                echo "<h4>Your Transaction ID for this transaction is ".$txnid.".</h4>";
                echo "<h4>We have received a payment of Rs. " . $amount . ". Your order will soon be shipped.</h4>";     
                echo ''; 
      
      ?>
<!--       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
      <link rel="stylesheet" href="style.css" type="text/css">
      <!-- <div class="circle-loader"><div class="checkmark draw"></div></div>  -->

      <svg class="checkmark" viewBox="0 0 52 52">
<circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
<path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/></svg>
<script> 

        setTimeout(function() {
              window.location = '<?php echo PAYU_SUCCESS_URL; ?>'+'manage/job/transaction_list';

        }, 3000);       
</script> 





                <!-- echo $productinfo;
          echo "<h3>Thank You. Your order status is ". $status .".</h3>";
          echo "<h4>Your Transaction ID for this transaction is ".$txnid.".</h4>";
          echo "<h4>We have received a payment of Rs. " . $amount . ". Your order will soon be shipped.</h4>";
          --> 
          <?php 
	}         
?>	