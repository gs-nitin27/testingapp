<?php
class emailtemplateService
{
public function job_apply_template($email,$userid,$prof_id,$username,$prof_name,$contact_no,$image_url)
{

  $profile_link = "https://getsporty.in/web/#/allProfile/$userid/$prof_id";
 

 $job_template = '<div> <!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.card {
  box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  margin: auto;
  text-align: center;
  font-family: arial;
}

.title {
  color: grey;
  font-size: 18px;
}

button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

a {
  text-decoration: none;
  font-size: 22px;
  color: black;
}

button:hover, a:hover {
  opacity: 0.7;
}
</style>
</head>
<body>

<div class="card">
  <img height="180" width="300" src="'.$image_url.'">
  <h1>'.ucwords($username).'</h1>
  <p class="title">'.ucwords($prof_name).'</p>
  <p>'.$contact_no.'</p>
  
 <p><a href = "'.$profile_link.' " > <button>View Profile</button></a></p>
</div>

</body>
</html>


</div>';

return $this->main_template($job_template);

}

public function job_subject($username)
{
  return ucwords($username). ' is apply this job';
}

public function main_template($template)
{
  return '<html lang="en">
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
                    '.$template.'
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
}

}
?>