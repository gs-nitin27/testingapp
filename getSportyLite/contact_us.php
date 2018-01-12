<?php
include('../config.php');
include('emailService.php');
include('visitorService.php');
switch ($_REQUEST['act']) {
case 'contact_us':
	  $user_info   =  json_decode(file_get_contents("php://input"));
            $obj = new emailService();
            $email = $obj->contact_us_App($user_info);
            $obj1 = new visitorService();
            $usermessage = $obj1->visitor_message($user_info);
            if($email == 1 && $usermessage == "1")
            { 
            	$msg = 'message successfully sent';
            }else{
            	$msg = 'Invalid Email';
            }
            $result = array('status'=>$email,'msg'=>$msg);
            echo json_encode($result);
      	break;

	
	default:
		$Result = array('status' => '0','msg'=>'Please Try Again');
	            echo json_encode($Result);
		break;
}
?>