<?php
include('config1.php');
include('success_submit.php');

$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$salt="e5iIg1jwi8";




If (isset($_POST["additionalCharges"])) {
       $additionalCharges=$_POST["additionalCharges"];
        $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        
                  }
	else {	  

        $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;

         }
		 $hash = hash("sha512", $retHashSeq);
		 
       if ($hash != $posted_hash) {
	       echo "Invalid Transaction. Please try again";
	}
	else { 
                 $req = new payment();

                $date = date("Y-m-d");
                $date1 = explode('-', $date);
                $monthNum  = $date1[1];
                $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                $monthName = $dateObj->format('F');
                $year = date("y");
                $invoiceid = "GSJ/1/".$year.$date1[1].$date1[2]."/".$_POST["productinfo"];
                $paymentdate = $date1[2]."-" .$monthName."-".$date1[0];
                 
                $item = new stdClass();
                $item->status = $_POST["status"];
                $item->name = $_POST["firstname"];
                $item->amount = $_POST["amount"];
                $item->txnid = $_POST["txnid"];
                $item->hash = $_POST["hash"];
                $item->key = $_POST["key"];
                $item->jobid = $_POST["productinfo"];
                $item->email = $_POST["email"];
                $item->salt = "e5iIg1jwi8";
                $item->invoiceid = $invoiceid;
                $item->date = $paymentdate;
                
               // print_r($jobtitle['title']);
                $getuserid = $req->getuserid($item->email);
                $item->userid = $getuserid['userid'];
                $res = $req->paymentservice($item);
                $jobtitle = $req->getjobtitle($item->jobid);  
                $item->title = $jobtitle['title'];
                $publish = $req->publishjob($item->jobid);
               // $mail = $req->invoicemail($item->email,$item);     
         

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
              window.location = 'http://localhost:4200/#/jobdashboard';
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