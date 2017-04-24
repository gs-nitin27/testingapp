<?php
include('config1.php');
include('services/userdataservice.php');
include('services/searchdataservice.php');
include('services/UserProfileService.php');
include('services/smsOtpService.php');
error_reporting(E_ERROR | E_PARSE);

if($_REQUEST['act'] == 'user_otp')
{
// $data = file_get_contents("php://input");
// //print_r($data);
// $elv  = new stdClass();
// //echo $data->userid;
$data  = json_decode($_POST[ 'data' ]);
$phone = $data->phone_no;
$userid = $data->userid;
$otp_code = mt_rand(1000,10000);
$res1 = save_otp_code($userid,$otp_code);
$msg = $otp_code." + This + is + OTP + code + for + login ";
$res = sendWay2SMS(9528454915,8824784642, $phone, $msg);

//print_r($res);die;
  if ($res)
     { 
     	// if($res[0]['result'] == 1 || $res[0]['result'] == true)
     	// {
       	 $user = array('status' => 1);
         echo json_encode($user);
        }
       else
       {
           $user = array('status' => 0);
           echo json_encode($user);   
      // } 
}
}


else if($_REQUEST['act'] == 'verify_otp')
{
 $data  = json_decode($_POST[ 'data' ]);
 $item    =  new stdClass();
 $item->otp_code_server = $data->otp_code;
 $item->userid = $data->userid;
 $item->phone_no = $data->phone_no;
 $res2 = find_otp_code($item->userid);
 $temp_otp_code = $res2['forget_code'];
 if($temp_otp_code == $item->otp_code_server)
{
    $res = change_forgot_code($item);
    if($res)
    {
      $user = array('status' => 1 ,'data'=>$res2);
      echo json_encode($user);
   
   }else{
   	  $user = array('status' => 0);
      echo json_encode($user);
   }
}
else
{
	  $user = array('status' => 0);
      echo json_encode($user);
}
}
 ?>