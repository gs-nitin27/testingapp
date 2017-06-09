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
         $from           =  "info@darkhorsesports.in";
         $from_name      =  $user_info->name;
         $subject        =  $user_info->name." has sent a message";
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
         $mail->Body = $user_info->message; 
               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $mail->Send();
               $this->visitor_Acknowlege($user_info);
               return $mail->Send();

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
   














} // End  class
