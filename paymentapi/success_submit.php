<?php 
Class payment
{
    public function paymentservice($paymentdata)
    {

    $query = mysql_query("INSERT INTO `gs_billing`(`userid`,`invoice_id`,`user_item`,`module`,`amount`,`date`,`billing_status`,`transaction_id`,`date_created`,`date_updated`,`transaction_data`) VALUES('$paymentdata->userid','$paymentdata->invoiceid','$paymentdata->jobid','1','$paymentdata->amount',CURDATE(),'1','$paymentdata->txnid',CURDATE(),CURDATE(),'$paymentdata->transaction_data') ");
    if($query)
    {
        return 1;
    } 
    else
    {
        return 0;
    }
    }

public function getjobtitle($jobid)
{
 $query = mysql_query("SELECT `title` FROM `gs_jobInfo` WHERE `id` = '$jobid'");
 if(mysql_num_rows($query))
 {
    while ($row = mysql_fetch_assoc($query)) 
    {
        $rows = $row;
    }
    return $rows;
 }else
 {
 return 0;
}
}

public function publishjob($jobid)
{
  $insert = mysql_query("UPDATE  `gs_jobInfo` SET `publish` = '1' WHERE `id` = '$jobid'");
  $tes = mysql_affected_rows();

  if($tes)
  {
    return $tes;

  }else{
    return 0;
  }

}

public function getuserid($email)
{
  $query = mysql_query("SELECT `userid` FROM `user` WHERE `email` = '$email'");
  if(mysql_num_rows($query))
  {
    while ($row = mysql_fetch_assoc($query)) 
    {
        $rows = $row;
    }
    return $rows;
  }else
  {
    return 0;
  }

}

public function invoicemail($email,$paymentdata)
{
  
    // $email = $data['email'];
    $msg = '<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>A simple, clean, and responsive HTML invoice template</title>
    
<style>
.title h1 {
        font-size: 50px;
    color: #fff;
    font-weight: bold;
    text-shadow: 3px 1px 9px #666;
    letter-spacing: -5px;
}

    .title p strong{
        font-size: 28px;
        color: #555;
    }
    strong{
        font-size: 16px;
    }
    .billy p,.title p{
        margin: 5px 0;
    }
    .invoice-box{
        max-width:1000px;
        margin:auto;
        padding:20px;
        border:1px solid #eee;
        font-size:15px;
        line-height:18px;
        font-family:"Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
        color:#555;
    }
    
    .invoice-box table{
        width:100%;
        line-height:inherit;
        text-align:left;
    }
    
    .invoice-box table td{
        padding:5px;
        vertical-align:top;
    }
    
    td.billy-lft {
        width: 54.6%;
    }
    
    .invoice-box table tr.top table td{
       /* padding-bottom:20px;*/
    }
    
    .invoice-box table tr.top table td.title{
        font-size:28px!important;
        color:#555;
    }
    
    .invoice-box table tr.information table td{
        /*padding-bottom:40px;*/
    }
    
    .invoice-box table tr.heading td{
        background:#eee;
        border-bottom:1px solid #ddd;
        font-weight:bold;
    }
    
    .invoice-box table tr.details td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom:1px solid #eee;
    }
    
    .invoice-box table tr.item.last td{
        border-bottom:none;
    }
    
    .invoice-box table tr.total td:nth-child(2){
        border-top:2px solid #eee;
        font-weight:bold;
    }
    td.billy-lft {
    min-width: 180px;
    }
    tr.heading td,tr.details td {
    padding-left: 12px;
}
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td{
            width:100%;
            display:block;
            text-align:center;
        }
        
        .invoice-box table tr.information table td{
            width:100%;
            display:block;
            text-align:center;
        }
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <h1>getsporty</h1>
                                <p><strong>Invoice</strong></p>
                            </td>
                            
                            <td>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>Invoice Number:</strong> <span>'.$paymentdata->invoiceid.'</span>
                            </td>
                            
                            <td>
                                <strong>Invoice Date:</strong> <span>'.$paymentdata->date.'</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

              <tr class="billy">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="billy-lft">
                                <strong>Bill From:</strong>
                                <p>Getsporty</p>
                                <p>Darkhorsesports PVT.LTD.</p>
                                <p>A-20 Sector-35</p>
                                <p>Noida</p>
                                <p>pin- 201003</p>
                            </td>
                            
                            <td class="billy-rht">
                              <strong>Bill To:</strong>
                              <p>'.$paymentdata->name.'</p>
                              <p>'.$paymentdata->name.'</p>
                              <p>'.$email.'</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    Mode Of Payment
                </td>
                
                <td>
                    Online
                </td>
            </tr>
            
            <tr class="details">
                <td>
                    Transaction Id
                </td>
                
                <td>'.$paymentdata->txnid.'</td>
            </tr>

        </table>
        <table>
<tr class="heading">
<td>Description</td>
<td>Duration</td>
<td>Ammount</td>
<td>Total</td>
</tr>
<tr class="details">
<td>'.$paymentdata->title.'</td>
<td>30 days</td>
<td>'.$paymentdata->amount.'</td>
<td>'.$paymentdata->amount.'</td>
            </tr>
        </table>
    </div>
</body>
</html>';


        require('..\class.phpmailer.php');
         $to             =  $email;
         $from           =  "info@darkhorsesports.in";
         $from_name      =  "Getsporty";
         $subject        =  "Invoice"; 
         $mail = new PHPMailer();  // create a new object
         $mail->IsSMTP(); // enable SMTP
         $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
         $mail->SMTPAuth = true;  // authentication enabled
         $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
         $mail->Host = 'smtp.gmail.com';
         $mail->Port = 465; 
         $mail->Username =$from;  
         $mail->Password = "2016Darkhorse";
         $mail->SetFrom($from, $from_name);
         $mail->Subject = $subject;
         $mail->Body = $msg; 
               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $mail->Send();
               
               //return $mail->Send();
}   

}
?>

<!-- Array ( 
    [mihpayid] => 403993715517131452 
    [mode] => CC 
    [status] => success 
    [unmappedstatus] => captured 
    [key] => rjQUPktU 
    [txnid] => e0add3eb19b35909e881 
    [amount] => 700.0 
    [addedon] => 2018-01-15 18:14:51 
    [productinfo] => 182 
    [firstname] => Nitin Agarwal 
    [lastname] => 
    [address1] => 
    [address2] => 
    [city] => 
    [state] => 
    [country] => 
    [zipcode] => 
    [email] => dhsnitin@gmail.com 
    [phone] => 9876543210 
    [udf1] =>
    [udf2] =>
    [udf3] => 
    [udf4] => 
    [udf5] => 
    [udf6] => 
    [udf7] => 
    [udf8] => 
    [udf9] => 
    [udf10] => 
    [hash] => 711d902845d88321bd3bf14160e32a2c6ab872e1d9ed5f2b56dd9e8cfc1204f146c41f533c6a6d0e93415526c8c0fe7af1e3e4db8de09b055d2fc2eab3bc2d59 
    [field1] => 339648 
    [field2] => 903825 
    [field3] => 20180115 
    [field4] => MC 
    [field5] => 309527196071 
    [field6] => 00 
    [field7] => 0 
    [field8] => 3DS 
    [field9] => Verification of Secure Hash Failed: E700 -- Approved -- Transaction Successful -- Unable to be determined--E000 [PG_TYPE] => AXISPG 
    [encryptedPaymentId] => DF8A05559D15420DAB7DC11706F7E1EA 
    [bank_ref_num] => 339648 
    [bankcode] => CC 
    [error] => E000 
    [error_Message] => No Error 
    [name_on_card] => payu 
    [cardnum] => 512345XXXXXX2346 
    [cardhash] => This field is no longer supported in postback params. 
    [amount_split] => {"PAYU":"700.0"} 
    [payuMoneyId] => 1111554202 
    [discount] => 0.00 
    [net_amount_debit] => 700 
    
    ) -->