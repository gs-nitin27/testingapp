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


public function email_for_interview($applicant_id,$employer_name,$title,$date,$msg,$organisation_name,$venue)
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
         $subject        = "Regarding Interview ";
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
<h3 style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:28px;font-style:normal;font-weight:600;line-height:36px;letter-spacing:normal;margin:0;padding:0;text-align:left">Subject  </h1><h3> Interview with &nbsp;&nbsp;'.$organisation_name.'&nbsp;for&nbsp;'.$title.'&nbsp;position</h3>
</td>
</tr>
<tr>
<td style="padding-bottom:20px" valign="top">
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left">Dear Mr. /Ms., <strong><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ' . $user . '</strong></p>
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left">
'.$msg.'<br>
<br><br><br><br><br>Please let me know which of the following times work for you, and I can send over a confirmation and details </p> 

</td>
</tr>
<tr>
<td align="center" style="padding-bottom:60px" valign="top">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td align="left" valign="middle">'.$venue.'
</td>
</tr>
</table>
</div>'; 
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
Hi user Your Login code is<br>'.$code.'
<br><br><br><br><br>Please Login with you current google account with the code and access all your info </p> 

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
         $mail->Body = '<!DOCTYPE html> <html lang="en"> <head> <meta charset="utf-8"><meta name="viewport" content="width=device-width"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="x-apple-disable-message-reformatting"><script src="https://use.fontawesome.com/ba25f40016.js"></script> <link href="https://fonts.googleapis.com/css?family=Amatic+SC|Dosis|Bubbler+One|Open+Sans+Condensed:300" rel="stylesheet"> <title></title><style>html, body {margin: 0 auto !important; padding: 0 !important; height: 100% !important; width: 100% !important; }{-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; }div[style*="margin: 16px 0"] {margin:0 !important; }table, td {mso-table-lspace: 0pt !important; mso-table-rspace: 0pt !important; }table {border-spacing: 0 !important; border-collapse: collapse !important; table-layout: fixed !important;} table table table {table-layout: auto; }img {-ms-interpolation-mode:bicubic; }*[x-apple-data-detectors] {color: inherit !important; text-decoration: none !important; }.x-gmail-data-detectors, .x-gmail-data-detectors *, .aBn {border-bottom: 0 !important; cursor: default !important; }.a6S {display: none !important; opacity: 0.01 !important; }img.g-img + div {display:none !important; }.button-link {text-decoration: none !important; }.email-container {min-width: 375px !important; } } </style> <style>.button-td, .button-a {transition: all 100ms ease-in; } .button-td:hover, .button-a:hover {background: #555555 !important; border-color: #555555 !important; }@media screen and (max-width: 600px) {.email-container {width: 100% !important; margin: auto !important; }.fluid {max-width: 100% !important; height: auto !important; margin-left: auto !important; margin-right: auto !important; } /* What it does: Forces table cells into full-width rows. */ .stack-column, .stack-column-center {display: block !important; width: 100% !important; max-width: 100% !important; direction: ltr !important; } /* And center justify these ones. */ .stack-column-center {text-align: center !important; } /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */ /* .center-on-narrow {text-align: center !important; display: block !important; margin-left: auto !important; margin-right: auto !important; float: none !important; } table.center-on-narrow {display: inline-block !important; } */ /* What it does: Adjust typography on small screens to improve readability */ .email-container p {font-size: 17px !important; line-height: 22px !important; } } .sizecolor{font-size: 22px; color:rgba(255,255,255,.3); } #icons>li>a:hover>i{color:white; } </style> </head> <body width="100%" bgcolor="#fff" style="margin: 0; mso-line-height-rule: exactly;"> <center style="width: 100%; text-align: left;"> <!-- Email Body : BEGIN --> <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container"> <!-- Hero Image, Flush : BEGIN --> <tr> <td bgcolor="#03a9f4" style="text-align: center; height:75px;"> <!-- <img src="<img src="http://getsporty.in/emailimages/logo_1.png aria-hidden="true" width="180" height="" alt="alt_text" border="0" align="center" style="margin:0 0 0 15px;height: auto; background: #03a9f4; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;" class="g-img"> --> </td> </tr> <!-- Hero Image, Flush : END --> <!-- 1 Column Text + Button : BEGIN --> <tr> <td bgcolor="#ffffff" style="padding: 40px 40px 20px;"> <h1 style="margin: 0; font-family: sans-serif; font-size: 24px; line-height: 27px; color: #333333; font-weight: normal;"></h1> </td> </tr> <tr> <td bgcolor="#ffffff" style="padding: 0 40px 10px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;"> <p style="margin: 0;">Thanks for Contacting us , Our team will contact you soon</p> </td> </tr> <tr> <td bgcolor="#ffffff" style="padding: 0 40px 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;"><tr> <td bgcolor="#222"  valign="top" style="font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;  text-align:center;padding: 10px 0px 0px 0px;" class="center-on-narrow"> <!-- Column : BEGIN --> <img src="http://getsporty.in/emailimages/logo_2.png" aria-hidden="true" width="120" height="" alt="alt_text" border="0" align="center" style="width: 80px;height: auto; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;" class="g-img"> </td> </tr> <!-- Column : END --> <!-- Column : BEGIN --> <tr> <td bgcolor="#222"   class="stack-column-center" style="text-align:center;"> <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0"  style="padding-right: 10px;display: inline-block;"> <tr> <td style="font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; padding: 0 0px 0px; text-align: center;" class="center-on-narrow"> <ul id="icons" style="padding: 0"> <li style="  width: 30px;display: inline-block; list-style:none;"><a href=""><i class="fa fa-facebook sizecolor" aria-hidden="true"></i></a></li> <li style=" width: 30px;display: inline-block;list-style:none;"><a href=""><i class="fa fa-google-plus sizecolor" aria-hidden="true"></i></a></li> <li style="   width: 30px;display: inline-block;list-style:none;"><a href=""><i class="fa fa-linkedin sizecolor" aria-hidden="true"></i></a></li> <li style="  width: 30px;display: inline-block;list-style:none;"><a href=""><i class="fa fa-twitter sizecolor" aria-hidden="true"></i></a></li> </ul> </td> </tr> </table> </td> </tr> <!-- Column : END --> </table> <!-- 2 Even Columns : END --> <!-- Email Footer : BEGIN --> <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container"> <tr> <td style="background:#222;padding: 5px 0px 0px 0px;width: 100%;font-size: 12px; font-family: sans-serif; line-height:18px; text-align: center; color: #888888;" class="x-gmail-data-detectors"> <webversion style="    font-family: "Amatic SC", cursive;color:#cccccc;  font-weight: 100; font-size: 30px;">Dark Horse Sports</webversion> <span style="font-family: "Dosis", sans-serif; font-size: 15px;"> <br><br> A 20, Sector 35 <br>Noida, India, 201301. <br><br></span></td> </tr> <tr> <td style="background:#1b1b1b;padding: 10px 10px;width: 100%;font-size: 12px; font-family: sans-serif; line-height:18px; text-align: center; color: #888888;" class="x-gmail-data-detectors"> <unsubscribe style="font-family: "Open Sans Condensed", sans-serif;color:#888888;font-size: 18px;">Unsubscribe</unsubscribe> </td> </tr> </table> <!-- Email Footer : END --> </center> </body> </html>'; 
               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $mail->Send();
               if($mail->Send() == 1)
               {
                return 1;
               }
               else
               {
                return 0; 
               }
}        
       
public function careers_apply($user_info)
{       
         require('class.phpmailer.php');
         $to             =  "info@darkhorsesports.in";
         $from           =  $user_info['email'];//"info@darkhorsesports.in";
         $from_name      =  $user_info['name'];
         $subject        =  "New message from visitor";//$user_info->name." has sent a message";
         $mail = new PHPMailer();  // create a new object
         $mail->IsSMTP(); // enable SMTP
         $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
         $mail->Host = 'mail.getsporty.in';
         $attachments = $_FILES['doc'];
         $mail->Port = 587; 
         $mail->Username =$from;  
        
         $mail->SetFrom($from, $from_name);
                $mail->Subject = $subject;
                //$attachments = $FILES['doc'];
                $file_name = $attachments['name'];
                $file_size = $attachments['size'];
                $file_type = $attachments['type'];
                
                //read file 
                $handle = fopen($attachments['tmp_name'], "r");
                $content = fread($handle, $file_size);
                fclose($handle);
                $encoded_content = chunk_split(base64_encode($content)); //split into sm

         $mail->Body = "<!DOCTYPE html>
                        <html>
                        <body>
                        <p><b>Name:</b>".$user_info['name']."</p>
                        <p><b>Email:</b>".$user_info['email']."</p>";
        $mail->Body .= "--boundary\r\n";
        $mail->Body .="Content-Type: $file_type; name=".$file_name."\r\n";
        $mail->Body .="Content-Disposition: attachment; filename=".$file_name."\r\n";
        $mail->Body .="Content-Transfer-Encoding: base64\r\n";
        $mail->Body .="X-Attachment-Id: ".rand(1000,99999)."\r\n\r\n"; 
        $mail->Body .= $encoded_content;
        $mail->Body .=  "</body>
                        </html>";//$user_info->message; 
               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $requ = $this->visitor_Acknowlege((object)$user_info);
               if($requ == 1)
               {
               $mail->Send(); 
               return $requ; 
               }else
               {
               return 0;
               }
               
               
               

}



} // End  class
