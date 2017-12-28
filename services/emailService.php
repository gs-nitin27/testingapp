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
         {$mail->Subject = $data->athlete_name." wants to join your class";}
         else
         {
          $mail->Subject = $data->prof_name.'  '.$data->athlete_name." has sent you a message";
         }
         $mail->Body = "hello ".$data->coach_name."<br><br>"." a ".$data->prof_name." has sent you a message:"."<br><br>".$data->message."<br>You can view his profile , clicking on the view profile link:<br><a href='http://getsporty.in/profile/index.php?userid=".$data->userid."&prof_id=1'>View Profile</a><br><br>"."Thanks"."<br>"."Team Getsporty"; 
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





} // End  class
