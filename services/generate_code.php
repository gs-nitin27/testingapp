<?php 
class generate_code 
{
public function qr_code($entry_passcode,$user_name,$email,$row)
{
$evnet_name      =    $row[0]['name'];
$organizer_name  =    $row[0]['organizer_name'];
$sport_name      =    $row[0]['sport_name'];
$start_date      =    $row[0]['start_date'];
require('BarcodeQR.php');
$qr = new BarcodeQR(); 
$qr->text($entry_passcode); 
$qr->draw(150, "QrCodeImage/qr-code.png");
require('class.phpmailer.php');
$mail = new PHPMailer();
              $to=$email;
              $from="info@getsporty.in";
              $from_name="Getsporty Lite";
              $subject="Pass code for New User ";
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
              $mail->AddAttachment("QrCodeImage/qr-code.png"); 

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
        <td bgcolor="#5766BE">
          <img src="http://getsporty.in/emailimages/logo.png" aria-hidden="true" width="180" height="" alt="alt_text" border="0" align="center" style="margin:0 0 0 15px;height: auto; background: #5766BE; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;" class="g-img">
        </td>
            </tr>

            <tr><td> <img width = "100%" height = "200px"  src ="http://getsporty.in/staging/uploads/event/res_1494850039.jpg" > </td> </tr>
            <tr>
                <td bgcolor="#ffffff" style="padding: 40px 40px 20px;">
                    <h1 style="margin: 0; font-family: sans-serif; font-size: 24px; line-height: 27px; color: #333333; font-weight: normal;">Hi '.$user_name.'</h1>
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="padding: 0 40px 10px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                    <p style="margin: 0;">Greetings from GetSporty,<br>Thanks for showing interest in participating in the <b>'.$evnet_name.'</b> which is scheduled for 4 pm kick-off on <b>'.$start_date.' .</b>
                     Please find the attached PDF file to download the event <b>QR Code </b> as you will need it to enter the event<vr>
                    </p>
                </td>
            </tr>
      <tr>
                <td bgcolor="#ffffff" style="padding: 0 40px 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                    <p style="margin: 0>Please not that these are just precautionary steps to ensure that the event remains free from unwanted intruders and the safety of our participants remains as our utmost priority.</p>
                </td>
            </tr>
            
                  <tr><td align ="center "><img width="200px"  src= "http://getsporty.in/emailimages/qr-code.png"  </td> </tr>
                  <br><br>
<tr>
                <td bgcolor="#ffffff" style="padding: 0 40px 40px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                    <p style="margin: 0;">Thanks and Regards</p>
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
</html>
'; 






















               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $mail->Send();

         // return 1;
return 1;

}
}// End Class
?>