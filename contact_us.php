<?php
include('config1.php');
include('services/parentsUserService.php');
include('services/emailService.php');
include('services/visitorService.php');
switch ($_REQUEST['act']) 
{
case 'contact_us':
	$user_info   =  json_decode(file_get_contents("php://input"));
      $obj         = new emailService();
      $email       = $obj->contact_us_App($user_info);
      $obj1        = new visitorService();
      $usermessage = $obj1->visitor_message($user_info);
      if($email == true && $usermessage == "1")
      { 
      	$msg = 'message successfully sent';
      }
      else
      {
      	$msg = 'message not sent';
      }
      $result = array('status'=>$usermessage,'msg'=>$msg);
      echo json_encode($result);
	break;

	
	default:
		$Result = array('status' => '0','msg'=>'Please Try Again');
	            echo json_encode($Result);
		break;
}
?>