<?php
 class SendEmail
 {
   public function SendToEmail($to,$subject,$body)
   {
              require('class.phpmailer.php');
              $mail = new PHPMailer();
              $to=$email;
              $from="info@getsporty.in";
              $from_name="Getsporty Lite";
              $subject="Offer letter";
             // $user=$user_name;
              //$otp  =$code;
              //global $error;
              $mail = new PHPMailer();  // create a new object
              $mail->IsSMTP(); // enable SMTP
              $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
              $mail->SMTPAuth = true;  // authentication enabled
              $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
              $mail->Host = 'dezire.websitewelcome.com';
              //$mail->Host = 'smtp.gmail.com';
              $mail->Port = 465; 
              $mail->Username ="info@getsporty.in";  
              $mail->Password = "%leq?xgq;D?v";           
              $mail->SetFrom($from, $from_name);
              $mail->Subject = $subject;
              $mail->Body =$body; 
               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
              $mail->AltBody = $txt; 
              $mail->AddAddress($to);
              $abc=$mail->Send()
              if($abc)
              {
               //$mail->Send();
               return 1;
              }
              else
              {
               return 0;
              }
      }       
      
//    }



