<?php

/**
 * WAY2SMSClient
 * @author Kingster
 * @author SuyashBansal
 * @category SMS
 * Please use this code on your own risk. The author is no way responsible for the outcome arising out of this
 * Good Luck!
 **/
// class WAY2SMSClient
// {
//     var $curl;
//     var $timeout = 30;
//     var $jsToken;
//     var $way2smsHost;
//     var $refurl;
//     /**
//      * @param $username
//      * @param $password
//      * @return bool|string
//      */
//     function login($username, $password)
//     {

//         $this->curl = curl_init();
//         $uid = urlencode($username);
//         $pwd = urlencode($password);

//         // Go where the server takes you :P
//         curl_setopt($this->curl, CURLOPT_URL, "http://way2sms.com");
//         curl_setopt($this->curl, CURLOPT_HEADER, true);
//         curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, false);
//         curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, TRUE);
//         $a = curl_exec($this->curl);
//         if (preg_match('#Location: (.*)#', $a, $r))
//             $this->way2smsHost = trim($r[1]);

//         // Setup for login
//         curl_setopt($this->curl, CURLOPT_URL, $this->way2smsHost . "Login1.action");
//         curl_setopt($this->curl, CURLOPT_POST, 1);
//         curl_setopt($this->curl, CURLOPT_POSTFIELDS, "username=" . $uid . "&password=" . $pwd . "&button=Login");
//         curl_setopt($this->curl, CURLOPT_COOKIESESSION, 1);
//         curl_setopt($this->curl, CURLOPT_COOKIEFILE, "cookie_way2sms");
//         curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, 1);
//         curl_setopt($this->curl, CURLOPT_MAXREDIRS, 20);
//         curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
//         curl_setopt($this->curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5");
//         curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
//         curl_setopt($this->curl, CURLOPT_REFERER, $this->way2smsHost);
//         $text = curl_exec($this->curl);

//         // Check if any error occured
//         if (curl_errno($this->curl))
//             return "access error : " . curl_error($this->curl);

//         // Check for proper login
//         $pos = stripos(curl_getinfo($this->curl, CURLINFO_EFFECTIVE_URL), "ebrdg.action");
//         if ($pos === "FALSE" || $pos == 0 || $pos == "")
//             return "invalid login";

//         // Set the home page from where we can send message
//         $this->refurl = curl_getinfo($this->curl, CURLINFO_EFFECTIVE_URL);
//         $newurl = str_replace("ebrdg.action?id=", "main.action?section=s&Token=", $this->refurl);
//         curl_setopt($this->curl, CURLOPT_URL, $newurl);

//         // Extract the token from the URL
//         $this->jstoken = substr($newurl, 50, -41);
//         //Go to the homepage
//         $text = curl_exec($this->curl);

//         return true;
//     }


//     /**
//      * @param $phone
//      * @param $msg
//      * @return array
//      */
//     function send($phone, $msg)
//     {
//         $result = array();

//         // Check the message
//         if (trim($msg) == "" || strlen($msg) == 0)
//             return "invalid message";

//         // Take only the first 140 characters of the message
//         $msg = substr($msg, 0, 140);
//         // Store the numbers from the string to an array
//         $pharr = explode(",", $phone);

//         // Send SMS to each number
//         foreach ($pharr as $p) {
//             // Check the mobile number
//             if (strlen($p) != 10 || !is_numeric($p) || strpos($p, ".") != false) {
//                 $result[] = array('phone' => $p, 'msg' => $msg, 'result' => "invalid number");
//                 continue;
//             }

//             // Setup to send SMS
            //curl_setopt($this->curl, CURLOPT_URL, $this->way2smsHost . 'smstoss.action');
            // curl_setopt($this->curl, CURLOPT_REFERER, curl_getinfo($this->curl, CURLINFO_EFFECTIVE_URL));
             //curl_setopt($this->curl, CURLOPT_POST, 1);

//             curl_setopt($this->curl, CURLOPT_POSTFIELDS, "ssaction=ss&Token=" . $this->jstoken . "&mobile=" . $p . "&message=" . $msg . "&button=Login");
//             $contents = curl_exec($this->curl);

//             //Check Message Status
//             $pos = strpos($contents, 'Message has been submitted successfully');
//             $res = ($pos !== false) ? true : false;
//             $result[] = array('phone' => $p, 'msg' => $msg, 'result' => $res);
//         }
//         return $result;
//     }


//     /**
//      * logout of current session.
//      */
//     function logout()
//     {
//         curl_setopt($this->curl, CURLOPT_URL, $this->way2smsHost . "LogOut");
//         curl_setopt($this->curl, CURLOPT_REFERER, $this->refurl);
//         $text = curl_exec($this->curl);
//         curl_close($this->curl);
//     }

// }

// /**
//  * Helper Function to send to sms to single/multiple people via way2sms
//  * @example sendWay2SMS ( '9000012345' , 'password' , '987654321,9876501234' , 'Hello World')
//  */

// function sendWay2SMS($uid, $pwd, $phone, $msg)
// {
//    // print_r($phone); die();
//     $client = new WAY2SMSClient();
//     $client->login($uid, $pwd);
//    // print_r($client);
//     $result = $client->send($phone, $msg);
//     $client->logout();
//    // print_r($result);die;
//     return $result;
// }

function change_forgot_code($item)
{
      $query = mysql_query(" UPDATE `user` SET  `forget_code`='' ,`contact_no`='$item->phone_no', `date_updated`=CURDATE()  WHERE `userid`='$item->userid'");
      if($query)
      {
        return 1;
      }
      else {
          return 0;
      }
}

 function save_otp_code($userid,$forget_code)
 {
       $query = mysql_query(" UPDATE `user` SET  `forget_code`='$forget_code'   WHERE `userid`='$userid'");
     if($query)
       {
        return 1;
       }
       else {
         return 0;
      }
 }

function find_otp_code($userid)
{
   // print_r($userid);die;
    $query = mysql_query("SELECT *FROM `user` WHERE `userid`= '$userid'");
   
    if($query)
          {
            while($row = mysql_fetch_assoc($query))
            {   
               $data1= $row; 
               return $data1;
             }
           }
            else
            {
               return 0;
            }
          }

function sendWay2SMS($uid, $pwd, $phone, $msg)
{
$varUserName='t1ntnagarwalsms';
$varPWD='44824769';
$varSenderID='GSCORT';  
$varPhNo=$phone;
$varMSG= $msg;//"message to send";
$url="http://nimbusit.co.in/api/swsendSingle.asp";
$data="username=".$varUserName."&password=".$varPWD."&sender=".$varSenderID."&sendto=".$varPhNo."&message=".$varMSG;
$result =  postData($url,$data); 

if($result)
{
return '1';
}
else
{
return '0';
}
}

function postdata($url,$data)
{
 
     // curl_setopt($this->curl, CURLOPT_URL, $this->way2smsHost . 'smstoss.action');
     //         curl_setopt($this->curl, CURLOPT_REFERER, curl_getinfo($this->curl, CURLINFO_EFFECTIVE_URL));
     //         curl_setopt($this->curl, CURLOPT_POST, 1);



//The function uses CURL for posting data to server 
$objURL = curl_init($url);
curl_setopt($objURL, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($objURL,CURLOPT_POST,1);
curl_setopt($objURL, CURLOPT_POSTFIELDS,$data);



$retval = curl_exec($objURL); 
curl_close($objURL);

 //print_r($retval);

return $retval;

}



