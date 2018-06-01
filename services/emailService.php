<?php

class emailService 
{

/* 
|  This Function are used to sending the Email for Email- Varification 
*/

/**************************Function for Email Sending *******************/

public function emailVarification($email)
{
              require('class.phpmailer.php');
              $mail = new PHPMailer();
              $to=$email;
              $from="info@getsporty.in";
              $from_name="Getsporty Lite";
              $subject="Email varification ";
              $emailconform="getsporty.in/testingactivation.php?email=";
              $mail = new PHPMailer();  // create a new object
              $mail->IsSMTP(); // enable SMTP
              $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
              $mail->SMTPAuth = true;  // authentication enabled
              $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
              //$mail->Host = 'dezire.websitewelcome.com';
              $mail->Host = 'smtp.gmail.com';
              $mail->Port = 465; 
              $mail->Username ="info@darkhorsesports.in";  
              $mail->Password = "2016Darkhorse";           
              $mail->SetFrom($from, $from_name);
              $mail->Subject = $subject;
              $mail->Body = '<div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#5666be;">

 <table align="center" border="4" cellpadding="4" cellspacing="3" style="max-width:440px" width="100%" class="" >
<tbody><tr>
<td align="center" valign="top">
<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="background-color:#ffffff;  border-bottom:2px solid #e5e5e5;border-radius:4px" width="100%">
<tbody><tr>

<td align="center" style="padding-right:20px;padding-left:20px" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td align="left" valign="top" style="padding-top:40px;padding-bottom:30px">
</td>
</tr>
<tr>
<td style="padding-bottom:20px" valign="top">
<h1 style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:28px;font-style:normal;font-weight:600;line-height:36px;letter-spacing:normal;margin:0;padding:0;text-align:left">Please verify your email Address.</h1>
</td>
</tr>
<tr>
<td style="padding-bottom:20px" valign="top">
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left">To validate Your email Address, you MUST click the link below.<strong><br><h1> Click activate to login</br> <a href="'.$emailconform.''.$email.'">Activate<br></strong>
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left"><br>Note:- If clicking the link does not work, you can copy and paste the link into your browser address window,or retype it there.<br><br><br><br><br>Thanks you for visiting</p></br><p>GetSporty Team</p> 

</td>
</tr>
<tr>
<td align="center" style="padding-bottom:60px" valign="top">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td align="center" valign="middle">
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</div>'; 
               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $mail->Send();
          return 1;
   
          } // End Function
   
          
/**************************************Send Email for Interview*************************/  

public function email_for_interview($applicant_id,$employer_name,$title,$date,$msg,$organisation_name,$venue,$employer_email)
{
      $query  = mysql_query("SELECT `email`,`name`,`device_id` FROM `user` WHERE `userid` IN ($applicant_id) ");
      $num    = mysql_num_rows($query);
      if($num) 
      {
       require('class.phpmailer.php');
       while ($row=mysql_fetch_assoc($query))
        {
         $to             = $row['email'];
         $user           = $row['name'];
         $device_id      = $row['device_id'];
         $message        = array('date' =>$date ,'summary'=>$msg);
         $jsondata       = json_encode($message);
         $pushobj        = new userdataservice();
         $pushnote       = $pushobj->sendPushNotificationToGCM($row1['device_id'], $message);
         $from           = "info@darkhorsesports.in";
         $from_name      = $employer_name;
         $subject        = "Regarding Interview at ".$organisation_name;
         //global $error;
         $mail = new PHPMailer();  // create a new object
         $mail->IsSMTP(); // enable SMTP
         $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
         $mail->SMTPAuth = true;  // authentication enabled
         $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
         //$mail->Host = 'dezire.websitewelcome.com';
         $mail->Host = 'smtp.gmail.com';
         $mail->Port = 465; 
         $mail->Username =$from;  
         $mail->Password = "2016Darkhorse";
         $mail->AddReplyTo($employer_email, $employer_name);
         $mail->SetFrom($from, $from_name);
         $mail->Subject = $subject;
         $mail->Body = '<head>
  <meta charset="utf-8"> 
  <meta name="viewport" content="width=device-width"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="x-apple-disable-message-reformatting">  
  <title></title> 
    <style>
        html,
        body {
          margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        div[style*="margin: 16px 0"] {
            margin:0 !important;
        }
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
        }
        table table table {
            table-layout: auto;
        }
        img {
            -ms-interpolation-mode:bicubic;
        }
        *[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
        }
        .x-gmail-data-detectors,
        .x-gmail-data-detectors *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
        }
        .a6S {
          display: none !important;
          opacity: 0.01 !important;
        }
        img.g-img + div {
          display:none !important;
      }
        .button-link {
            text-decoration: none !important;
        }       
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) { 
            .email-container {
                min-width: 375px !important;
            }
        }
    </style>
    <style>
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }
        @media screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                margin: auto !important;
            }
            .fluid {
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            .stack-column-center {
                text-align: center !important;
            }
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }
            table.center-on-narrow {
                display: inline-block !important;
            }
      .email-container p {
        font-size: 17px !important;
        line-height: 22px !important;
      }
        }
    </style>
</head>
<body width="100%" bgcolor="#fff" style="margin: 0; mso-line-height-rule: exactly;">
    <center style="width: 100%; text-align: left;">
        <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container">
          <tr>
        <td bgcolor="#03a9f4">
          <img src="http://getsporty.in/img/logo.png" aria-hidden="true" width="180" height="" alt="alt_text" border="0" align="center" style="margin:0 0 0 15px;height: auto; background: #03a9f4; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;" class="g-img">
        </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="padding: 40px 40px 20px;">
                    <h1 style="margin: 0; font-family: sans-serif; font-size: 24px; line-height: 27px; color: #333333; font-weight: normal;">Hi,Greetings!</h1>
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="padding: 0 40px 10px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                    <p style="margin: 0;">You have an interview call for the post of <b> '.$title.'</b> at <b>'.$organisation_name.'</b>
                    <br>'.$msg.'
                    <br><b>Date of interview:</b>  '.date("M jS, Y", strtotime($date)).'
                    </p>
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="padding: 0 40px 40px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                    <p style="margin: 0;"></p>
                </td>
            </tr>
            <tr>
                <td bgcolor="#000000" align="center" valign="top" style="padding: 10px;">
                    <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <!-- Column : BEGIN -->
                            <td class="stack-column-center">
                                <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0">
                                   
                                    <tr>
                                        <td style="font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow">
                                            <img src="http://getsporty.in/img/logo.png" aria-hidden="true" width="120" height="" alt="alt_text" border="0" align="center" style="margin:0 0 0 15px;height: auto; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;" class="g-img">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                            <!-- Column : BEGIN -->
                            <td class="stack-column-center">
                                <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0"  style="float: right;padding-right: 10px;display: inline-block;">
                                    
                                    <tr>
                                        <td style="font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow">
                                            <ul>
                                                <li style="list-style:none;display:inline-block;"><a href=""><img style="width:30px" src="http://getsporty.in/emailimages/f.png"></a></li>
                                                <li style="list-style:none;display:inline-block;"><a href=""><img style="width:30px" src="https://getsporty.in/emailimages/go.png"></a></li>
                                                <li style="list-style:none;display:inline-block;"><a href=""><img style="width:30px" src="http://getsporty.in/emailimages/ln.png"></a></li>
                                                <li style="list-style:none;display:inline-block;"><a href=""><img style="width:30px" src="http://getsporty.in/emailimages/t.png"></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                        </tr>

                    </table><hr style="width: 90%;margin-top:0">
                </td>
            </tr>
            <!-- 2 Even Columns : END -->
            


        <!-- Email Footer : BEGIN -->
        <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container">
            <tr>
                <td style="background:#000000;padding: 10px 10px;width: 100%;font-size: 12px; font-family: sans-serif; line-height:18px; text-align: center; color: #888888;" class="x-gmail-data-detectors">
                    <webversion style="color:#cccccc; text-decoration:underline; font-weight: bold;"></webversion>
                </td>
            </tr>
        </table>
        <!-- Email Footer : END -->

    </center>
</body>
'; 
               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $mail->Send();
   } 
    return 1;
   }
   else
   {
    return  0;
   }  



}  // End of Function

public function ActivateChildAccount($child_email,$code)
{
       require('class.phpmailer.php');
         $to             = $child_email;
         $from           = "info@darkhorsesports.in";
         $from_name      = 'Getsporty';
         $subject        = "Welcome to Getsporty";
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
         $mail->Body = '<div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#5666be;">

 <table align="center" border="4" cellpadding="4" cellspacing="3" style="max-width:480px" width="100%" class="" >
<tbody><tr>
<td align="center" valign="top">
<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="background-color:#ffffff;  border-bottom:2px solid #e5e5e5;border-radius:4px" width="100%">
<tbody><tr>
<td align="center" style="padding-right:20px;padding-left:20px" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td align="left" valign="top" style="padding-top:40px;padding-bottom:30px">
</td>
</tr>
<tr>
<td style="padding-bottom:10px" valign="top">
<h3 style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:28px;font-style:normal;font-weight:600;line-height:36px;letter-spacing:normal;margin:0;padding:0;text-align:left"></h1>
</td>
</tr>
<tr>
<td style="padding-bottom:20px" valign="top">
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left">Dear Mr. /Ms., <strong><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ' . $user . '</strong></p>
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left">
Hi user your login code is<br>'.$code.'
<br><br><br><br><br>Please login with your current google account with the code and access all your info </p> 

</td>
</tr>
<tr>
<td align="center" style="padding-bottom:60px" valign="top">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
</tr>
</table>
</div>'; 
               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $mail->Send();
}   
          
public function contact_us_App($user_info)
{
         // require('class.phpmailer.php');
         // $to             =  "info@darkhorsesports.in";
         // $from           =  "info@darkhorsesports.in";
         // $from_name      =  $user_info->name;
         // $subject        =  $user_info->name." has sent a message";
         // $mail = new PHPMailer();  // create a new object
         // $mail->IsSMTP(); // enable SMTP
         // $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
         // $mail->SMTPAuth = true;  // authentication enabled
         // $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
         // $mail->Host = 'smtp.gmail.com';
         // $mail->Port = 465; 
         // $mail->Username =$from;  
         // $mail->Password = "2016Darkhorse";
         // $mail->SetFrom($from, $from_name);
         // $mail->Subject = $subject;
         // $mail->Body = $user_info->message; 
         //       $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
         //       $mail->AltBody = $txt; 
         //       $mail->AddAddress($to);
         //       $mail->Send();
         //       $this->visitor_Acknowlege($user_info);
         //       return $mail->Send();
         require('class.phpmailer.php');
         $to             =  "info@darkhorsesports.in";
         $from           =  $user_info->email;//"info@darkhorsesports.in";
         $from_name      =  $user_info->name;
         $subject        =  "New message from visitor";//$user_info->name." has sent a message";
         $mail = new PHPMailer();  // create a new object
         $mail->IsSMTP(); // enable SMTP
         $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
         //$mail->SMTPAuth = true;  // authentication enabled
        // $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
         $mail->Host = 'mail.getsporty.in';
         $mail->Port = 587; 
         $mail->Username =$from;  
         //$mail->Password = "2016Darkhorse";
         $mail->SetFrom($from, $from_name);
         $mail->Subject = $subject;
         $mail->Body = "<!DOCTYPE html>
                        <html>
                        <body>
                        <p><b>Name:</b>".$user_info->name."</p>
                        <p><b>Email:</b>".$user_info->email."</p>
                        <p><b>Subject:</b>".$user_info->subject."</p>
                        <p><b>Message:</b>".$user_info->message."</p><br>
                        </body>
                        </html>";//$user_info->message; 
               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $requ = $this->visitor_Acknowlege($user_info);
               if($requ == 1)
               {
               $mail->Send(); 
               return $requ; 
               }else
               {
               return 0;
               }

}
public function visitor_Acknowlege($user_info)
{
       //  require('class.phpmailer.php');
         $to             =  $user_info->email;
         $from           =  "info@darkhorsesports.in";
         $from_name      =  "Getsporty";
         $subject        =  "Thanks for contacting us";
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
         $mail->Body = "We have recieve your message our team will contact you soon"; 
               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $mail->Send();
               
               //return $mail->Send();
}        
       






/*****************Function for Send The Email to Athelte ***************/

public function send_email_athlete($email,$name,$request_type)
{
  if($request_type==1)
  {
     $request_name  = "Online";
  }
   if($request_type==2)
  {
     $request_name  = "Offline";
  }   
          require('class.phpmailer.php');
              $mail = new PHPMailer();
              $info_mail = "info@darkhorsesports.in";
              $to=$email;
              $from="info@getsporty.in";
              $from_name="Getsporty Lite";
              $subject="Request for Assesment";
              $mail = new PHPMailer();  // create a new object
              $mail->IsSMTP(); // enable SMTP
              $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
              $mail->SMTPAuth = true;  // authentication enabled
              $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
              //$mail->Host = 'dezire.websitewelcome.com';
              $mail->Host = 'smtp.gmail.com';
              $mail->Port = 465; 
              $mail->Username ="info@darkhorsesports.in";  
              $mail->Password = "2016Darkhorse";           
              $mail->SetFrom($from, $from_name);
              $mail->Subject = $subject;
              $mail->Body = '<div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#5666be;">
 <table align="center" border="4" cellpadding="4" cellspacing="3" style="max-width:440px" width="100%" class="" ><tbody><tr><td align="center" valign="top"><table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="background-color:#ffffff;  border-bottom:2px solid #e5e5e5;border-radius:4px" width="100%"><tbody><tr>
<td align="center" style="padding-right:20px;padding-left:20px" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td align="left" valign="top" style="padding-top:40px;padding-bottom:30px">
</td></tr><tr><td style="padding-bottom:20px" valign="top">
<h1 style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:28px;font-style:normal;font-weight:600;line-height:36px;letter-spacing:normal;margin:0;padding:0;text-align:left">
</td></tr><tr><td style="padding-bottom:20px" valign="top">
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:30px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left"> Hi   ' . $name . '</br> </p>
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left"><br>Your request for performance assessment has been received and it is under process......<br><br><br><br><br>Thanks you for Request</br><p>GetSporty Team</p> 
</td>
</tr>
<tr>
<td align="center" style="padding-bottom:60px" valign="top">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td align="center" valign="middle">
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</div>'; 
               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $mail->Send();
                $res = $this->send_email_info($info_mail,$name,$request_name);
             // return 1;
          
   
          } // End Function
   


public function send_email_info($info_mail,$name,$request_name)
{
         $from           =  "info@darkhorsesports.in";
         $from_name      =  "Getsporty";
         $subject        =  "Request for Assesment";
         $mail           = new PHPMailer();  // create a new object
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
         $mail->Body = $mail->Body = '<div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#5666be;">
 <table align="center" border="4" cellpadding="4" cellspacing="3" style="max-width:440px" width="100%" class="" ><tbody><tr><td align="center" valign="top"><table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="background-color:#ffffff;  border-bottom:2px solid #e5e5e5;border-radius:4px" width="100%"><tbody><tr>
<td align="center" style="padding-right:20px;padding-left:20px" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td align="left" valign="top" style="padding-top:40px;padding-bottom:30px">
</td></tr><tr><td style="padding-bottom:20px" valign="top">
<h1 style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:28px;font-style:normal;font-weight:600;line-height:36px;letter-spacing:normal;margin:0;padding:0;text-align:left">
</td></tr><tr><td style="padding-bottom:20px" valign="top">
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:30px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left"> Hi   ' . $name . '</br> </p>
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left"><br>Has sent request for ' . $request_name . ' assessment ........<br><br><br><br><br>Thanks you for Request</br><p>GetSporty Team</p> 
</td>
</tr>
<tr>
<td align="center" style="padding-bottom:60px" valign="top">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td align="center" valign="middle">
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</div>'; 
               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($info_mail);
               $mail->Send();
              // return 1;
         
          } // End Function
   



public function email_athlete($data,$msg)
{
        require('class.phpmailer.php');
         $to             =  $data->email;
         $from           =  "info@darkhorsesports.in";
         $from_name      =  "Getsporty";
         $subject        =  "Join your coach class";
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


public function contact_coach($data)
{
        require('class.phpmailer.php');
         $to             =  $data->coach_email;
         $from           =  "info@darkhorsesports.in";
         $from_name      =  "Getsporty";
         $subject        =  "Join your coach class";
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
         if($data->prof_id == '1')
         {
          $mail->Subject = $data->athlete_name." wants to join your class";
         }
         else
         {
          $mail->Subject = $data->prof_name.'  '.$data->athlete_name." has sent you a message";
         }
         if($data->prof_id == '1')
         {
          $msg = $mail->Body = "hello ".$data->coach_name."<br><br>"." a ".$data->prof_name." has sent you a message:"."<br><br>".$data->message."<br>You can view his profile , clicking on the view profile link:<br><a href='http://getsporty.in/profile/index.php?userid=".$data->userid."&prof_id=1'>View Profile</a><br><br>"."Thanks"."<br>"."Team Getsporty";
         }
         else
         {
          $msg = "hello ".$data->coach_name."<br><br>"." a ".$data->prof_name." has sent you a message:"."<br><br>".$data->message."<br>"."Thanks"."<br>"."Team Getsporty";
         }
               $mail->Body = $msg;
               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $mail->Send();
               
               //return $mail->Send();
}

public function email_varify($confirm)
{
    $email =   $confirm['email'];//$data->email;$confirm
              require('class.phpmailer.php');
              $mail = new PHPMailer(true);
              $to=$email;
              $from="info@darkhorsesports.in";
              $from_name="Getsporty";
              $subject="Email varification ";

             // $emailconform="http://staging.getsporty.in/index.php/forms/forgotpassword?email=";
              //$emailconform  =  site_url().'/forms/forgotpassword?email=';
              $emailconfirm = 'https://localhost/verification?userid='.$confirm['userid'].'&email='.$confirm['email'];
              //global $error;
               // create a new object
              $mail->IsSMTP(); // enable SMTP
             // $mail->addReplyTo("reply@yourdomain.com", "Reply");

              $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
              $mail->SMTPAuth = true;  // authentication enabled
              $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
              $mail->Host = 'smtp.gmail.com';
              //$mail->Host = 'smtp.gmail.com';
              $mail->Port = 465; 
              $mail->Username ="info@darkhorsesports.in";  
              $mail->Password = "2016Darkhorse";           
              $mail->SetFrom($from, $from_name);
              $mail->Subject = $subject;
              $mail->Body = '<html lang="en">
<head>
  <meta charset="utf-8"> 
  <meta name="viewport" content="width=device-width"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="x-apple-disable-message-reformatting">  
  <title></title> 
    <style>
        html,
        body {
          margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        div[style*="margin: 16px 0"] {
            margin:0 !important;
        }
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
        
        }
        table table table {
            table-layout: auto;
        }
        img {
            -ms-interpolation-mode:bicubic;
        }
        *[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
        }
        .x-gmail-data-detectors,
        .x-gmail-data-detectors *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
        }
        .a6S {
          display: none !important;
          opacity: 0.01 !important;
        }
        img.g-img + div {
          display:none !important;
      }
        .button-link {
            text-decoration: none !important;
        }

       
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) { 
            .email-container {
                min-width: 375px !important;
            }
        }

    </style>

    <style>
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }
        @media screen and (max-width: 600px) {

            .email-container {
                width: 100% !important;
                margin: auto !important;
            }
            .fluid {
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            .stack-column-center {
                text-align: center !important;
            }
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }
            table.center-on-narrow {
                display: inline-block !important;
            }
      .email-container p {
        font-size: 17px !important;
        line-height: 22px !important;
      }
        }
    </style>
</head>
<body width="100%" bgcolor="#fff" style="margin: 0; mso-line-height-rule: exactly;">
    <center style="width: 100%; text-align: left;">
        <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container">
          <tr>
        <td bgcolor="#03a9f4">
          <img src="http://getsporty.in/emailimages/logo.png" aria-hidden="true" width="180" height="" alt="alt_text" border="0" align="center" style="margin:0 0 0 15px;height: auto; background: #03a9f4; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;" class="g-img">
        </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="padding: 40px 40px 20px;">
                    <h1 style="margin: 0; font-family: sans-serif; font-size: 24px; line-height: 27px; color: #333333; font-weight: normal;">Hello</h1>
                </td>
            </tr>
            <tr><td bgcolor="#ffffff" style="padding: 0 40px 10px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                <p style="margin: 0;">Hi,Greetings! You are just a step away from accessing your getsporty account.Just click on the link below to complete your verification process.
                     </p>
                '.
                // <td bgcolor="#ffffff" style="padding: 0 40px 10px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                //     <p style="margin: 0;">Hi,Greetings! You are just a step away from accessing your getsporty account.Just click on the link below to reset your password.
                //     </p>
                    '
                </td>
            </tr>
      <tr><td bgcolor="#ffffff" style="padding: 0 40px 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                     <p style="margin: 0;"><a style="color:#03a9f4;" href="'.$emailconfirm.'">Validate</a></p>
                </td>'
                // <td bgcolor="#ffffff" style="padding: 0 40px 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                //     <p style="margin: 0;"><a style="color:#03a9f4;" href="'.$emailconform.''.$email.'">Reset Your Password</a></p>
                // </td>'
            .'</tr>
            <tr>
                <td bgcolor="#ffffff" style="padding: 0 40px 40px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                    <p style="margin: 0;"></p>
                </td>
            </tr>
            <tr>
                <td bgcolor="#000000" align="center" valign="top" style="padding: 10px;">
                    <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <!-- Column : BEGIN -->
                            <td class="stack-column-center">
                                <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0">
                                   
                                    <tr>
                                        <td style="font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow">
                                            <img src="http://getsporty.in/emailimages/logo.png" aria-hidden="true" width="120" height="" alt="alt_text" border="0" align="center" style="margin:0 0 0 15px;height: auto; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;" class="g-img">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                            <!-- Column : BEGIN -->
                            <td class="stack-column-center">
                                <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0"  style="float: right;padding-right: 10px;display: inline-block;">
                                    
                                    <tr>
                                        <td style="font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow">
                                            <ul>
                                                <li style="list-style:none;display:inline-block;"><a href=""><img style="width:30px" src="http://getsporty.in/emailimages/f.png"></a></li>
                                                <li style="list-style:none;display:inline-block;"><a href=""><img style="width:30px" src="http://getsporty.in/emailimages/go.png"></a></li>
                                                <li style="list-style:none;display:inline-block;"><a href=""><img style="width:30px" src="http://getsporty.in/emailimages/ln.png"></a></li>
                                                <li style="list-style:none;display:inline-block;"><a href=""><img style="width:30px" src="http://getsporty.in/emailimages/t.png"></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                        </tr>

                    </table><hr style="width: 90%;margin-top:0">
                </td>
            </tr>
            <!-- 2 Even Columns : END -->
            


        <!-- Email Footer : BEGIN -->
        <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container">
            <tr>
                <td style="background:#000000;padding: 10px 10px;width: 100%;font-size: 12px; font-family: sans-serif; line-height:18px; text-align: center; color: #888888;" class="x-gmail-data-detectors">
                    <webversion style="color:#cccccc; text-decoration:underline; font-weight: bold;">Lorem ipsum dolor sit amet</webversion>
                    <br><br>
                    Company Name<br>consectetur adipiscing elit. In quis fermentum<br>(123) 456-7890
                    <br><br>
                    <unsubscribe style="color:#888888; text-decoration:underline;">unsubscribe</unsubscribe>
                </td>
            </tr>
        </table>
        <!-- Email Footer : END -->

    </center>
</body>
</html>'; 
               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $mail->Send();
          return 1;




  }


public function invoicemail($data,$paymentdata)
{
  
    $email = $data['email'];
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
                                <strong>Invoice Number:</strong> <span>'.$paymentdata->invoice_id.'</span>
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
                              <p>'.$data["name"].'</p>
                              <p>'.$data["contact_no"].'</p>
                              <p>'.$data["email"].'</p>
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
                
                <td>
                    0D034569918
                </td>
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
<td>'.$paymentdata->duration.'</td>
<td>'.$paymentdata->amount.'</td>
<td>'.$paymentdata->amount.'</td>
            </tr>
        </table>
    </div>
</body>
</html>';


        require('class.phpmailer.php');
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





public function email_job_apply($email,$userid,$prof_id,$username,$prof_name,$contact_no,$image_url)
{

$req = new emailtemplateService();
$body = $req->job_apply_template($email,$userid,$prof_id,$username,$prof_name,$contact_no,$image_url);
$subject = $req->job_subject($username);
$this->email_send($email,$body,$subject);
} // End Function


public function email_send($email,$body,$subject)
{
              if(isset($mail))
              {
                unset($mail);
              }
              require_once('class.phpmailer.php');
              include_once('../email/emailtemplateService.php');
              $mail = new PHPMailer();
              $req = new emailtemplateService();
              $to=$email;
              $from="info@getsporty.in";
              $from_name="Getsporty";
              $mail = new PHPMailer();  // create a new object
              $mail->IsSMTP(); // enable SMTP
              $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
              $mail->SMTPAuth = true;  // authentication enabled
              $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
              //$mail->Host = 'dezire.websitewelcome.com';
              $mail->Host = 'smtp.gmail.com';
              $mail->Port = 465; 
              $mail->Username ="info@darkhorsesports.in";  
              $mail->Password = "2016Darkhorse";           
              $mail->SetFrom($from, $from_name);
              $mail->Subject = ''.$subject.'';;
              $mail->Body = ''.$body.''; 
              $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $mail->Send();
          return 1;
   
}


public function tournament_apply_email($cat_data, $billingdata,$userdata,$emailtemp)
{
     $Basic_Taxable_Amount = $billingdata->amount / 1.18;
     $taxamount = $billingdata->amount - $Basic_Taxable_Amount; 
 
    $msg ='<html> <head> <title></title> </head> <body> <div style="width:auto;height:auto;background:none repeat scroll 0 0 #ffffff;float:left" id=""> <table width="100%" style="height:70px;border-bottom:1px solid #ccc"> <tbody><tr> <td align="left" colspan="2" style="padding-left:10px"> <img src="https://getsporty.in/img/logo.png" alt="TMM" height="95" class="CToWUd"></td></tr></tbody></table><div style="padding:10px;font-weight:bold"><label style="text-align:left;width:100%;color:#d39a12">Welcome '.$userdata->name.',</label></div><p style="padding:10px">Thank you. We have received your entry for the '.$userdata->tournament_title.'.</p><p style="padding:10px">Your online entry transaction number is <b>'.$billingdata->txnid.'</b>. Please note this is NOT YOUR RUNNING NUMBER. Your participation in the Event is subject to entry confirmation and rules &amp; guidelines. You are required to check your application status online at <a href="">adhm.procamrunning.in</a> post 15 working days of closure of registration.</p> <div style="padding:10px;background:none repeat scroll 0 0 #ffffff"> <label style="text-align:left;width:100%;font-weight:bold;font-size:17px;color:#d39a12;padding:6px 3px">Transaction Details</label> <table width="100%" style="border:1px solid #ccc"> <tbody><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Transaction Date </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>'.$billingdata->date.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Gender </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>'.$userdata->gender.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Date of Birth </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>'.$userdata->dob.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Nationality </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Indian</label></td></tr></tbody></table>'.$emailtemp.'<div style="background:none repeat scroll 0 0 #ffffff;margin-top:20px"><div style="background:none repeat scroll 0 0 #ffffff;margin-top:20px"><label style="text-align:left;width:100%;font-weight:bold;font-size:17px;color:#d39a12;padding:6px 3px">Billing Contact Details</label> <table width="100%" style="border:1px solid #ccc"><tbody><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Name </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:left;padding-right:10px"><label>'.$userdata->name.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Address </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:left;padding-right:10px"><label>'.$userdata->addressdetails.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Email Address </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:left;padding-right:10px"><label><a href="mailto:'.$billingdata->email.'" target="_blank">'.$billingdata->email.'</a> <small>(All communications would be sent to this address)</small></label></td></tr></tbody></table></div><div style="background:none repeat scroll 0 0 #ffffff;margin-top:20px"> <label style="text-align:left;width:100%;font-weight:bold;font-size:17px;color:#d39a12;padding:6px 3px">Payment Details</label> <table width="100%" style="border:1px solid #ccc"><tbody><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Gross Total Amount </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Rs.'. $billingdata->amount.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> &nbsp;&nbsp;&nbsp;&nbsp;Basic Taxable Amount </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Rs.'.number_format((float)$Basic_Taxable_Amount, 2, ".", "").'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp; IGST  (18.00%)</label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Rs.'.number_format((float)$taxamount, 2, ".", "").'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Amount Paid </label> </td> <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>(-) Rs.'.$billingdata->amount.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Balance Due </label> </td><td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Rs.0.00</label></td></tr></tbody></table></div><p style="padding-top:10px"><b>Please Note:</b> The charges will be billed to your credit or debit card as <a href="">www.getsporty.in</a></p><p style="padding-top:10px">For event related query, you can contact us by e-mail at <b><a href="mailto:info@darkhorsesports.in" target="_blank">info@darkhorsesports.in</a></b>. Kindly include your transaction number, e-mail address, name and dates of the event in all future correspondence.</p><p style="padding-top:10px">For further information about '.$userdata->tournament_title.', Call us at +91 120 4511807</p><p style="padding-top:10px">Thank you for registering for <b>'.$userdata->tournament_title.'</b>. We hope you have a wonderful time. </p><p style="padding-top:10px">Best Regards,<br><b>Team Getsporty</b><br>Event helpline: +91 120 4511807 (<span class="aBn" data-term="goog_22569914" tabindex="0"><span class="aQJ">Monday</span></span> to <span class="aBn" data-term="goog_22569915" tabindex="0"><span class="aQJ">Saturday</span></span>, <span class="aBn" data-term="goog_22569916" tabindex="0"><span class="aQJ">10 am to 7 pm</span></span>)</p></div></div></body> </html>';

     require('class.phpmailer.php');
     $to             =  $billingdata->email;
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

}



/*************************************Send Invoice Email To Event Participate*************************/

public function event_apply_email($cat_data, $billingdata,$userdata,$emailtemp)
{
     $Basic_Taxable_Amount = $billingdata->amount / 1.18;
     $taxamount = $billingdata->amount - $Basic_Taxable_Amount; 
 
    $msg ='<html> <head> <title></title> </head> <body> <div style="width:auto;height:auto;background:none repeat scroll 0 0 #ffffff;float:left" id=""> <table width="100%" style="height:70px;border-bottom:1px solid #ccc"> <tbody><tr> <td align="left" colspan="2" style="padding-left:10px"> <img src="https://getsporty.in/img/logo.png" alt="TMM" height="95" class="CToWUd"></td></tr></tbody></table><div style="padding:10px;font-weight:bold"><label style="text-align:left;width:100%;color:#d39a12">Welcome '.$userdata->name.',</label></div><p style="padding:10px">Thank you. We have received your entry for the '.$userdata->event_title.'.</p>Your participation in the Event is subject to entry confirmation and rules &amp; guidelines. <div style="padding:10px;background:none repeat scroll 0 0 #ffffff"> <label style="text-align:left;width:100%;font-weight:bold;font-size:17px;color:#d39a12;padding:6px 3px">Transaction Details</label> <table width="100%" style="border:1px solid #ccc"> <tbody><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Gender </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>'.$userdata->gender.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Date of Birth </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>'.$userdata->dob.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Nationality </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Indian</label></td></tr></tbody></table>'.$emailtemp.'<div style="background:none repeat scroll 0 0 #ffffff;margin-top:20px"><div style="background:none repeat scroll 0 0 #ffffff;margin-top:20px"><label style="text-align:left;width:100%;font-weight:bold;font-size:17px;color:#d39a12;padding:6px 3px">Billing Contact Details</label> <table width="100%" style="border:1px solid #ccc"><tbody><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Name </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:left;padding-right:10px"><label>'.$userdata->name.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Address </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:left;padding-right:10px"><label>'.$userdata->addressdetails.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Email Address </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:left;padding-right:10px"><label><a href="mailto:'.'info@darkhorsesports.in'.'" target="_blank">'.'info@darkhorsesports.in'.'</a> <small>(All communications would be sent to this address)</small></label></td></tr></tbody></table></div><div style="background:none repeat scroll 0 0 #ffffff;margin-top:20px"> <label style="text-align:left;width:100%;font-weight:bold;font-size:17px;color:#d39a12;padding:6px 3px">Payment Details</label> <table width="100%" style="border:1px solid #ccc"><tbody><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Gross Total Amount </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Rs.'. $billingdata->amount.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> &nbsp;&nbsp;&nbsp;&nbsp;Basic Taxable Amount </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Rs.'.number_format((float)$Basic_Taxable_Amount, 2, ".", "").'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp; IGST  (18.00%)</label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Rs.'.number_format((float)$taxamount, 2, ".", "").'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Amount Paid </label> </td> <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>(-) Rs.'.$billingdata->amount.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Balance Due </label> </td><td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Rs.0.00</label></td></tr></tbody></table></div><p style="padding-top:10px"><b>Please Note:</b> The charges will be billed to your credit or debit card as <a href="">www.getsporty.in</a></p><p style="padding-top:10px">For event related query, you can contact us by e-mail at <b><a href="mailto:info@darkhorsesports.in" target="_blank">info@darkhorsesports.in</a></b>. Kindly include your transaction number, e-mail address, name and dates of the event in all future correspondence.</p><p style="padding-top:10px">For further information about '.$userdata->event_title.', Call us at +91 120 4511807</p><p style="padding-top:10px">Thank you for registering for <b>'.$userdata->event_title.'</b>. We hope you have a wonderful time. </p><p style="padding-top:10px">Best Regards,<br><b>Team Getsporty</b><br>Event helpline: +91 120 4511807 (<span class="aBn" data-term="goog_22569914" tabindex="0"><span class="aQJ">Monday</span></span> to <span class="aBn" data-term="goog_22569915" tabindex="0"><span class="aQJ">Saturday</span></span>, <span class="aBn" data-term="goog_22569916" tabindex="0"><span class="aQJ">10 am to 7 pm</span></span>)</p></div></div></body> </html>';

     require('class.phpmailer.php');
     $to             =  $userdata->email;
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
     $mail->AddAttachment("QrCodeImage/qr-code.png");
     $mail->Body = $msg; 
     $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
     $mail->AltBody = $txt; 
     $mail->AddAddress($to);
     return $mail->Send();

}


/**************************************Send Email for Job Offer *************************/  

public function email_for_joboffer($applicant_email,$joining_date,$salary,$job_id,$emp_email,$emp_name)
{
    $query  = mysql_query("SELECT `title`,`organisation_name` FROM `gs_jobInfo` WHERE `id`= '$job_id'");
      $num    = mysql_num_rows($query);
      if($num) 
      {
       require('class.phpmailer.php');
       while ($row=mysql_fetch_assoc($query))
        {
         $to                     = $applicant_email;
         $title                  = $row['title'];
         $organisation_name      = $row['organisation_name'];
      
         $from           = "info@darkhorsesports.in";
         $subject        = "Offer from  ".$organisation_name;
         //global $error;
         $mail = new PHPMailer();  // create a new object
         $mail->IsSMTP(); // enable SMTP
         $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
         $mail->SMTPAuth = true;  // authentication enabled
         $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
         //$mail->Host = 'dezire.websitewelcome.com';
         $mail->Host = 'smtp.gmail.com';
         $mail->Port = 465; 
         $mail->Username =$from;  
         $mail->Password = "2016Darkhorse";
         $mail->AddReplyTo($emp_email, $emp_name);
         $mail->SetFrom($from);
         $mail->Subject = $subject;
         $mail->Body = '<head>
  <meta charset="utf-8"> 
  <meta name="viewport" content="width=device-width"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="x-apple-disable-message-reformatting">  
  <title></title> 
    <style>
        html,
        body {
          margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }
        div[style*="margin: 16px 0"] {
            margin:0 !important;
        }
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
        }
        table table table {
            table-layout: auto;
        }
        img {
            -ms-interpolation-mode:bicubic;
        }
        *[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
        }
        .x-gmail-data-detectors,
        .x-gmail-data-detectors *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
        }
        .a6S {
          display: none !important;
          opacity: 0.01 !important;
        }
        img.g-img + div {
          display:none !important;
      }
        .button-link {
            text-decoration: none !important;
        }       
        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) { 
            .email-container {
                min-width: 375px !important;
            }
        }
    </style>
    <style>
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }
        @media screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                margin: auto !important;
            }
            .fluid {
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            .stack-column-center {
                text-align: center !important;
            }
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }
            table.center-on-narrow {
                display: inline-block !important;
            }
      .email-container p {
        font-size: 17px !important;
        line-height: 22px !important;
      }
        }
    </style>
</head>
<body width="100%" bgcolor="#fff" style="margin: 0; mso-line-height-rule: exactly;">
    <center style="width: 100%; text-align: left;">
        <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container">
          <tr>
        <td bgcolor="#03a9f4">
          <img src="http://getsporty.in/img/logo.png" aria-hidden="true" width="180" height="" alt="alt_text" border="0" align="center" style="margin:0 0 0 15px;height: auto; background: #03a9f4; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;" class="g-img">
        </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="padding: 40px 40px 20px;">
                    <h1 style="margin: 0; font-family: sans-serif; font-size: 24px; line-height: 27px; color: #333333; font-weight: normal;">Hi,Greetings!</h1>
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="padding: 0 40px 10px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                    <p style="margin: 0;">You got offer  for the post of <b>'.$title.'</b> at <b>'.$organisation_name.'</b>
                     <br><b>Salary:</b>  '.$salary.'
                    <br><b>Date of Joining:</b>  '.date("M jS, Y", strtotime($joining_date)).'
                    </p>
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="padding: 0 40px 40px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                    <p style="margin: 0;"></p>
                </td>
            </tr>
            <tr>
                <td bgcolor="#000000" align="center" valign="top" style="padding: 10px;">
                    <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <!-- Column : BEGIN -->
                            <td class="stack-column-center">
                                <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0">
                                   
                                    <tr>
                                        <td style="font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow">
                                            <img src="http://getsporty.in/img/logo.png" aria-hidden="true" width="120" height="" alt="alt_text" border="0" align="center" style="margin:0 0 0 15px;height: auto; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;" class="g-img">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                            <!-- Column : BEGIN -->
                            <td class="stack-column-center">
                                <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0"  style="float: right;padding-right: 10px;display: inline-block;">
                                    
                                    <tr>
                                        <td style="font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow">
                                            <ul>
                                                <li style="list-style:none;display:inline-block;"><a href=""><img style="width:30px" src="http://getsporty.in/emailimages/f.png"></a></li>
                                                <li style="list-style:none;display:inline-block;"><a href=""><img style="width:30px" src="https://getsporty.in/emailimages/go.png"></a></li>
                                                <li style="list-style:none;display:inline-block;"><a href=""><img style="width:30px" src="http://getsporty.in/emailimages/ln.png"></a></li>
                                                <li style="list-style:none;display:inline-block;"><a href=""><img style="width:30px" src="http://getsporty.in/emailimages/t.png"></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                        </tr>

                    </table><hr style="width: 90%;margin-top:0">
                </td>
            </tr>
            <!-- 2 Even Columns : END -->
            


        <!-- Email Footer : BEGIN -->
        <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container">
            <tr>
                <td style="background:#000000;padding: 10px 10px;width: 100%;font-size: 12px; font-family: sans-serif; line-height:18px; text-align: center; color: #888888;" class="x-gmail-data-detectors">
                    <webversion style="color:#cccccc; text-decoration:underline; font-weight: bold;"></webversion>
                </td>
            </tr>
        </table>
        <!-- Email Footer : END -->

    </center>
</body>
'; 

               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $mail->Send();
   } 
    return 1;
   }
   else
   {
    return  0;
   }  



}

public function email_for_update($userinfo,$id)
{
  if($userinfo['email'] != '' && $id != '')
  {
    $t_data = $userinfo['email']."|".$id;
    $t_data = base64_encode($t_data);
    $body = '<a href ="http://localhost/gs_newsite/manage/login/'.$t_data.'">www.example.com</a>';
    //echo $body;die;
    $subject = "Create updates for tournament";
    $this->email_send($userinfo['email'],$body,$subject);
  }
  //echo "nitin".$t_data;die;
}


 // End Function


// public function email_invoice_to_participant($applydata);
// {

// require('class.phpmailer.php');
//               $mail = new PHPMailer();
//               $req = new emailtemplateService();
//               $to=$email;
//               $from="info@getsporty.in";
//               $from_name="Getsporty";
//               $mail = new PHPMailer();  // create a new object
//               $mail->IsSMTP(); // enable SMTP
//               $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
//               $mail->SMTPAuth = true;  // authentication enabled
//               $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
//               //$mail->Host = 'dezire.websitewelcome.com';
//               $mail->Host = 'smtp.gmail.com';
//               $mail->Port = 465; 
//               $mail->Username ="info@darkhorsesports.in";  
//               $mail->Password = "2016Darkhorse";           
//               $mail->SetFrom($from, $from_name);
//               $mail->Subject = ''.$subject.'';;
//               $mail->Body = '<html> <head> <title></title> </head> <body> <div style="width:auto;height:auto;background:none repeat scroll 0 0 #ffffff;float:left" id=""> <table width="100%" style="height:70px;border-bottom:1px solid #ccc"> <tbody><tr> <td align="left" colspan="2" style="padding-left:10px"> <img src="https://getsporty.in/img/logo.png" alt="TMM" height="95" class="CToWUd"><img src="https://getsporty.in/portal/uploads/tournament/tournament_1498471430.jpg" alt="TMM" height="95" class="CToWUd"> </td> </tr> </tbody></table> <div style="padding:10px;font-weight:bold"> <label style="text-align:left;width:100%;color:#d39a12">Welcome Anirudh Singh,</label></div><p style="padding:10px">Thank you. We have received your entry for the TOURNAMENT TITLE.</p> <p style="padding:10px">Your online entry transaction number is <b>13532ADHM172583211956</b>. Please note this is NOT YOUR RUNNING NUMBER. Your participation in the Event is subject to entry confirmation and rules &amp; guidelines. You are required to check your application status online at <a href="">adhm.procamrunning.in</a> post 15 working days of closure of registration.</p> <div style="padding:10px;background:none repeat scroll 0 0 #ffffff"> <label style="text-align:left;width:100%;font-weight:bold;font-size:17px;color:#d39a12;padding:6px 3px">Transaction Details</label> <table width="100%" style="border:1px solid #ccc"> <tbody><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Transaction Date </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>17 Sep, 2017 10:12 AM</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Gender </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Male</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Date of Birth </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>16-07-1977</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Nationality </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Indian</label></td></tr></tbody></table><div style="background:none repeat scroll 0 0 #ffffff;margin-top:20px"> <label style="text-align:left;width:100%;font-weight:bold;font-size:17px;color:#d39a12;padding:6px 3px">Details</label> <table width="100%" style="border:1px solid #ccc;border-collapse:collapse"> <tbody><tr align="left"> <th style="border:1px solid #ccc">Attendee ID</th> <th style="border:1px solid #ccc">Name</th> <th style="border:1px solid #ccc">Email ID</th> </tr><tr align="left"> <td style="border:1px solid #ccc">PRCM013532</td> <td style="border:1px solid #ccc">Anirudh Singh</td> <td style="border:1px solid #ccc"><a href="mailto:anirudhsingh16@gmail.com" target="_blank">anirudhsingh16@gmail.com</a></td> </tr></tbody></table></div><p style="padding-top:10px"><b>Registration for Airtel Delhi Half Marathon 2017 Half Marathon (21.097 KM)</b></p><div style="background:none repeat scroll 0 0 #ffffff"><label style="text-align:left;width:100%;font-weight:bold;font-size:17px;color:#d39a12;padding:6px 3px">Charges for Agenda Items and Other Fees</label> <table width="100%" style="border:1px solid #ccc;border-collapse:collapse"> <tbody><tr align="left"> <th style="border:1px solid #ccc">Item</th> <th style="border:1px solid #ccc;text-align:right">Rate (INR)</th> <th style="border:1px solid #ccc">Quantity</th> <th style="border:1px solid #ccc;text-align:right">Amount (INR)</th> </tr><tr align="left"> <td style="border:1px solid #ccc">Registration for Airtel Delhi Half Marathon 2017 Half Marathon (21.097 KM)</td><td style="border:1px solid #ccc;text-align:right">Rs.1,800.00</td> <td style="border:1px solid #ccc">1</td> <td style="border:1px solid #ccc;text-align:right">Rs.1,800.00</td></tr><tr align="left"> <td colspan="3" style="border:1px solid #ccc;text-align:right"><b>Total</b></td> <td style="border:1px solid #ccc;text-align:right">Rs.1,800.00</td> </tr></tbody></table></div><div style="background:none repeat scroll 0 0 #ffffff;margin-top:20px"> <label style="text-align:left;width:100%;font-weight:bold;font-size:17px;color:#d39a12;padding:6px 3px">Billing Contact Details</label> <table width="100%" style="border:1px solid #ccc"><tbody><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Name </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:left;padding-right:10px"><label>Anirudh Singh</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Address </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:left;padding-right:10px"><label>102, SPA-5, Spa Court, Jaypee Greens, Greater Noida</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Email Address </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:left;padding-right:10px"><label><a href="mailto:anirudhsingh16@gmail.com" target="_blank">anirudhsingh16@gmail.com</a> <small>(All communications would be sent to this address)</small></label></td></tr></tbody></table></div><div style="background:none repeat scroll 0 0 #ffffff;margin-top:20px"> <label style="text-align:left;width:100%;font-weight:bold;font-size:17px;color:#d39a12;padding:6px 3px">Payment Details</label> <table width="100%" style="border:1px solid #ccc"><tbody><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Gross Total Amount </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Rs.1,800.00</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> &nbsp;&nbsp;&nbsp;&nbsp;Basic Taxable Amount </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Rs.1,525.42</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp; IGST  (18.00%)</label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Rs.274.58</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Amount Paid </label> </td> <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>(-) Rs.1,800.00</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Balance Due </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Rs.0.00</label></td></tr></tbody></table></div><p style="padding-top:10px"><b>Please Note:</b> The charges will be billed to your credit or debit card as <a href="">www.getsporty.in</a></p><p style="padding-top:10px">ON YOUR MARK, 20% OFF, GO! "Enjoy a 20% discount on Running and Training Products at select PUMA Stores from <span class="aBn" data-term="goog_22569913" tabindex="0"><span class="aQJ">13th Sept to 17th Nov</span></span> and also at <a href="#">Click here</a> to read about how to redeem this coupon.</p><p style="padding-top:10px">For event related query, you can contact us by e-mail at <b><a href="mailto:info@darkhorsesports.in" target="_blank">info@darkhorsesports.in</a></b>. Kindly include your transaction number, e-mail address, name and dates of the event in all future correspondence.</p><p style="padding-top:10px">For further information about TOURNAMENT TITLE, Call us at<a href="#">http://adhm.procamrunning.in/</a></p><p style="padding-top:10px">Thank you for registering for <b>TournamentTitle</b>. We hope you have a wonderful time. </p><p style="padding-top:10px">Best Regards,<br><b>Team Getsporty</b><br>Event helpline: +91 96500 33333 (<span class="aBn" data-term="goog_22569914" tabindex="0"><span class="aQJ">Monday</span></span> to <span class="aBn" data-term="goog_22569915" tabindex="0"><span class="aQJ">Saturday</span></span>, <span class="aBn" data-term="goog_22569916" tabindex="0"><span class="aQJ">10 am to 7 pm</span></span>)</p></div></div></body> </html>'; 
//               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
//                $mail->AltBody = $txt; 
//                $mail->AddAddress($to);
//                $mail->Send();
//           return 1;





// }

public function create_subscribe_body($info,$module)
{ //print_r($info);die;  
  if(isset($info['data']))
    {
     $sent=[];
     $sent_id = ''; 
    $email = $info['user_info'];//die;
    $subject = '';
    if($module == '1')
    { 
      $subject = 'Sports Jobs Updates From Getsporty';
      foreach ($info['data'] as $key => $value) {
         $temp = '';
         foreach ($value as $key => $value1) {
          $temp .='
         <div class="slide-content">
                <h4><a href="'.VIEW_PROFILE.'job-detail/'.$value1['id'].' target="_blank">'.$value1['title'].'</a></h4>
                <p>'.substr(strip_tags($value1['description']),0,300).'..<a href="'.VIEW_PROFILE.'job-detail/'.$value1['id'].' target="_blank">Know More..</a>
                </p>
            </div><br>';
            $sent[] = $value1['id'];
         }
       }
        $sent_id = implode(',', $sent);

    }
    if($module == '2')
    { 
      $subject = 'Sports events Updates From Getsporty';
      foreach ($info['data'] as $key => $value) {
         $temp = '';
         foreach ($value as $key => $value1) {
          $temp .='
         <div class="slide-content">
                <h4><a href="'.VIEW_PROFILE.'event-detail/'.$value1['id'].' target="_blank">'.$value1['name'].'</a></h4>
                <p>'.substr(strip_tags($value1['description']),0,300).'..<a href="'.VIEW_PROFILE.'job-detail/'.$value1['id'].' target="_blank">Know More..</a>
                </p>
            </div><br>';
            $sent[] = $value1['id'];
         }
       }
        $sent_id = implode(',', $sent);
    }
    if($module == '3')
    { 
      $subject = 'Tournaments Updates From Getsporty';
      foreach ($info['data'] as $key => $value) {
         $temp = '';
         foreach ($value as $key => $value1) {
          $temp .='
         <div class="slide-content">
                <h4><a href="'.VIEW_PROFILE.'tournament-detail/'.$value1['id'].' target="_blank">'.$value1['name'].'</a></h4>
                <p>'.substr(strip_tags($value1['description']),0,300).'..<a href="'.VIEW_PROFILE.'job-detail/'.$value1['id'].' target="_blank">Know More..</a>
                </p>
            </div><br>';
            $sent[] = $value1['id'];
         }
       }
        $sent_id = implode(',', $sent);
    }
    if($module == '4')
    { 
      $subject = 'Sports Trials Updates From Getsporty';
      foreach ($info['data'] as $key => $value) {
         $temp = '';
         foreach ($value as $key => $value1) {
          $temp .='
         <div class="slide-content">
                <h4><a href="'.VIEW_PROFILE.'event-detail/'.$value1['id'].' target="_blank">'.$value1['name'].'</a></h4>
                <p>'.substr(strip_tags($value1['description']),0,300).'..<a href="'.VIEW_PROFILE.'job-detail/'.$value1['id'].' target="_blank">Know More..</a>
                </p>
            </div><br>';
            $sent[] = $value1['id'];
         }
         
       }
       $sent_id = implode(',', $sent);
    }
    
    if($module == '6')
    { 
      $subject = 'Sports article Updates From Getsporty';
      foreach ($info['data'] as $key => $value) {
         $temp = '';
         foreach ($value as $key => $value1) {
          $temp .='
         <div class="slide-content">
                <h4><a href="'.VIEW_PROFILE.'article-detail/'.$value1['id'].' target="_blank">'.$value1['title'].'</a></h4>
                <p>'.substr(strip_tags($value1['summary']),0,300).'..<a href="'.VIEW_PROFILE.'job-detail/'.$value1['id'].' target="_blank">Know More..</a>
                </p>
            </div><br>';
            $sent[] = $value1['id'];

         }
       }
       $sent_id = implode(',', $sent);
      }
         $body = '<head> <meta charset="utf-8"> <meta name="viewport" content="width=device-width"> <meta http-equiv="X-UA-Compatible" content="IE=edge"> <meta name="x-apple-disable-message-reformatting"> <title></title> <style> html, body {margin: 0 auto !important; padding: 0 !important; height: 100% !important; width: 100% !important; } * {-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; } div[style*="margin: 16px 0"] {margin:0 !important; } table, td {mso-table-lspace: 0pt !important; mso-table-rspace: 0pt !important; } table {border-spacing: 0 !important; border-collapse: collapse !important; table-layout: fixed !important; } table table table {table-layout: auto; } img {-ms-interpolation-mode:bicubic; } *[x-apple-data-detectors] {color: inherit !important; text-decoration: none !important; } .x-gmail-data-detectors, .x-gmail-data-detectors *, .aBn {border-bottom: 0 !important; cursor: default !important; } .a6S {display: none !important; opacity: 0.01 !important; } img.g-img + div {display:none !important; } .button-link {text-decoration: none !important; } @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {.email-container {min-width: 375px !important; } } </style> <style> .button-td, .button-a {transition: all 100ms ease-in; } .button-td:hover, .button-a:hover {background: #555555 !important; border-color: #555555 !important; } @media screen and (max-width: 600px) {.email-container {width: 100% !important; margin: auto !important; } .fluid {max-width: 100% !important; height: auto !important; margin-left: auto !important; margin-right: auto !important; } .stack-column, .stack-column-center {display: block !important; width: 100% !important; max-width: 100% !important; direction: ltr !important; } .stack-column-center {text-align: center !important; } .center-on-narrow {text-align: center !important; display: block !important; margin-left: auto !important; margin-right: auto !important; float: none !important; } table.center-on-narrow {display: inline-block !important; } .email-container p {font-size: 17px !important; line-height: 22px !important; } } </style> </head> <body width="100%" bgcolor="#fff" style="margin: 0; mso-line-height-rule: exactly;"> <center style="width: 100%; text-align: left;"> <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container"> <tr> <td bgcolor="#03a9f4"> <img src="http://getsporty.in/img/logo.png" aria-hidden="true" width="180" height="" alt="alt_text" border="0" align="center" style="margin:0 0 0 15px;height: auto; background: #03a9f4; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;" class="g-img"> </td> </tr> <tr> <td bgcolor="#ffffff" style="padding: 40px 40px 20px;"> <h1 style="margin: 0; font-family: sans-serif; font-size: 24px; line-height: 27px; color: #333333; font-weight: normal;">Hi,Greetings!</h1> </td> </tr><tr><td bgcolor="#ffffff" style="padding: 0 40px 10px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;"><h3>New updates List for your Subscription</h3>'.$temp.'</tr></td><td bgcolor="#ffffff" style="padding: 0 40px 40px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;"> <p style="margin: 0;"></p> </td> </tr> <tr> <td bgcolor="#000000" align="center" valign="top" style="padding: 10px;"> <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" width="100%"> <tr> <!-- Column : BEGIN --> <td class="stack-column-center"> <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0"> <tr> <td style="font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow"> <img src="http://getsporty.in/img/logo.png" aria-hidden="true" width="120" height="" alt="alt_text" border="0" align="center" style="margin:0 0 0 15px;height: auto; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;" class="g-img"> </td> </tr> </table> </td> <!-- Column : END --> <!-- Column : BEGIN --> <td class="stack-column-center"> <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0"  style="float: right;padding-right: 10px;display: inline-block;"> <tr> <td style="font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; padding: 0 10px 10px; text-align: left;" class="center-on-narrow"> <ul> <li style="list-style:none;display:inline-block;"><a href=""><img style="width:30px" src="http://getsporty.in/emailimages/f.png"></a></li> <li style="list-style:none;display:inline-block;"><a href=""><img style="width:30px" src="https://getsporty.in/emailimages/go.png"></a></li> <li style="list-style:none;display:inline-block;"><a href=""><img style="width:30px" src="http://getsporty.in/emailimages/ln.png"></a></li> <li style="list-style:none;display:inline-block;"><a href=""><img style="width:30px" src="http://getsporty.in/emailimages/t.png"></a></li> </ul> </td> </tr> </table> </td> <!-- Column : END --> </tr> </table><hr style="width: 90%;margin-top:0"> </td> </tr> <!-- 2 Even Columns : END --> <!-- Email Footer : BEGIN --> <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container"> <tr> <td style="background:#000000;padding: 10px 10px;width: 100%;font-size: 12px; font-family: sans-serif; line-height:18px; text-align: center; color: #888888;" class="x-gmail-data-detectors"> <webversion style="color:#cccccc; text-decoration:underline; font-weight: bold;"></webversion> </td> </tr> </table> <!-- Email Footer : END --> </center> </body>'; 
         //echo $body;
         if($this->email_send($email,$body,$subject)){
          return $sent_id;
         }else
         {
          return 0;
         } 

    }
          
}

public function quick_event_apply_email($cat_data, $billingdata,$userdata,$emailtemp)
{
     $Basic_Taxable_Amount = $billingdata->amount / 1.18;
     $taxamount = $billingdata->amount - $Basic_Taxable_Amount; 
 
    $msg ='<html> <head> <title></title> </head> <body> <div style="width:auto;height:auto;background:none repeat scroll 0 0 #ffffff;float:left" id=""> <table width="100%" style="height:70px;border-bottom:1px solid #ccc"> <tbody><tr> <td align="left" colspan="2" style="padding-left:10px"> <img src="https://getsporty.in/img/logo.png" alt="TMM" height="95" class="CToWUd"></td></tr></tbody></table><div style="padding:10px;font-weight:bold"><label style="text-align:left;width:100%;color:#d39a12">Welcome '.$userdata->name.',</label></div><p style="padding:10px">Thank you. We have received your entry for the '.$userdata->event_title.'.</p>Your participation in the Event is subject to entry confirmation and rules &amp; guidelines. <div style="padding:10px;background:none repeat scroll 0 0 #ffffff"> <label style="text-align:left;width:100%;font-weight:bold;font-size:17px;color:#d39a12;padding:6px 3px">Transaction Details</label> <table width="100%" style="border:1px solid #ccc"> <tbody><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Gender </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>'.$userdata->gender.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Date of Birth </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>'.$userdata->dob.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Nationality </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Indian</label></td></tr></tbody></table>'.$emailtemp.'<div style="background:none repeat scroll 0 0 #ffffff;margin-top:20px"><div style="background:none repeat scroll 0 0 #ffffff;margin-top:20px"><label style="text-align:left;width:100%;font-weight:bold;font-size:17px;color:#d39a12;padding:6px 3px">Billing Contact Details</label> <table width="100%" style="border:1px solid #ccc"><tbody><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Name </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:left;padding-right:10px"><label>'.$userdata->name.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Address </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:left;padding-right:10px"><label>'.$userdata->addressdetails.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Email Address </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:left;padding-right:10px"><label><a href="mailto:'.'info@darkhorsesports.in'.'" target="_blank">'.'info@darkhorsesports.in'.'</a> <small>(All communications would be sent to this address)</small></label></td></tr></tbody></table></div><div style="background:none repeat scroll 0 0 #ffffff;margin-top:20px"> <label style="text-align:left;width:100%;font-weight:bold;font-size:17px;color:#d39a12;padding:6px 3px">Payment Details</label> <table width="100%" style="border:1px solid #ccc"><tbody><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Gross Total Amount </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Rs.'. $billingdata->amount.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> &nbsp;&nbsp;&nbsp;&nbsp;Basic Taxable Amount </label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Rs.'.number_format((float)$Basic_Taxable_Amount, 2, ".", "").'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp; IGST  (18.00%)</label> </td>  <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Rs.'.number_format((float)$taxamount, 2, ".", "").'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Amount Paid </label> </td> <td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>(-) Rs.'.$billingdata->amount.'</label></td></tr><tr><td width="50%" style="border-bottom:1px solid #eaeaea"><label style="font-weight:bold"> Balance Due </label> </td><td width="50%" style="border-bottom:1px solid #eaeaea;text-align:right;padding-right:10px"><label>Rs.0.00</label></td></tr></tbody></table></div><p style="padding-top:10px"><b>Please Note:</b> The charges will be billed to your credit or debit card as <a href="">www.getsporty.in</a></p><p style="padding-top:10px">For event related query, you can contact us by e-mail at <b><a href="mailto:info@darkhorsesports.in" target="_blank">info@darkhorsesports.in</a></b>. Kindly include your transaction number, e-mail address, name and dates of the event in all future correspondence.</p><p style="padding-top:10px">For further information about '.$userdata->event_title.', Call us at +91 120 4511807</p><p style="padding-top:10px">Thank you for registering for <b>'.$userdata->event_title.'</b>. We hope you have a wonderful time. </p><p style="padding-top:10px">Best Regards,<br><b>Team Getsporty</b><br>Event helpline: +91 120 4511807 (<span class="aBn" data-term="goog_22569914" tabindex="0"><span class="aQJ">Monday</span></span> to <span class="aBn" data-term="goog_22569915" tabindex="0"><span class="aQJ">Saturday</span></span>, <span class="aBn" data-term="goog_22569916" tabindex="0"><span class="aQJ">10 am to 7 pm</span></span>)</p></div></div></body> </html>';

     require('class.phpmailer.php');
     $to             =  $userdata->email;
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
     $mail->AddAttachment("QrCodeImage/qr-code.png");
     $mail->Body = $msg; 
     $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
     $mail->AltBody = $txt; 
     $mail->AddAddress($to);
     return $mail->Send();

}






} // End  class
