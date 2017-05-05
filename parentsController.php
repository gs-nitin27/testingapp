<?php
include('config1.php');
include('services/parentsUserService.php');
include('services/emailService.php');
error_reporting(E_ERROR | E_PARSE);
$nodata = [];

switch ($_REQUEST['act']) 
{

	case 'view_parent_child':
		$parent_id       =  $_REQUEST['parent_id'];
		$request         =  new parentsUserService();
		$response 		 =  $request->get_parent_child($parent_id);
	if($response)
	 {
	             $Result = array('status' => '1','data'=>$response ,'msg'=>'view Child');
	             echo json_encode($Result);
	 }
	 else
	 {                     
	            $Result = array('status' => '0','data'=>$nodata ,'msg'=>'No  Child');
	            echo json_encode($Result);
	 }
	break;
	case 'add_child':
	 $data                     =  file_get_contents("php://input");
	 $decode_data        	   =  json_decode(file_get_contents("php://input"));
     $request           	   =  new parentsUserService();
     $where = '`name`= '.$decode_data->name.' AND `dob`= '.$decode_data->dob.'';
     $already_child            =  $request->varify_child($where);
    
     if ($already_child != 0) 
     {
     	 $Result = array('status' => '0','data'=>'0' ,'msg'=>'Child is Already exists');
	             echo json_encode($Result);
     }
     else
     {
     $response                 =  $request->add_child($decode_data);
	 if($response)
	 {
	             $Result = array('status' => '1','data'=>$response ,'msg'=>'Add Child');
	             echo json_encode($Result);
	 }
	 else
	 {                     
	            $Result = array('status' => '0','data'=>$nodata ,'msg'=>'Not Add Child');
	            echo json_encode($Result);
	 }
	}
	break;
	case 'activate_child_account':  // Api for activating child account by a parent
		  $parent_id = $_REQUEST['parent_id'];
		  $child_id  = $_REQUEST['child_id'];
		  $child_email = $_REQUEST['child_email'];
		  $req       = new parentsUserService();
		  $activated = $req->activateAccount($parent_id,$child_id,$child_email);
		  if($activated != 0)
		  { $email_req  = new emailService();
		  	$send_email = $email_req->ActivateChildAccount($child_email,$activated); 
		  	$msg = 'Success';
		  	$getcode = 1;
		  }else
		  { $getcode = 0;
		  	$msg = 'failure';
		  }
		  $response = array('status'=>$getcode,'data'=>$getcode,'message'=>$msg);
		        echo json_encode($response); 
		break;
		case 'child_athlete_login':
			  $code  = $_REQUEST['code'];
			  $email = $_REQUEST['email'];
			  $req = new parentsUserService();
			  $res = $req->child_account_verify($code,$email);
			  if($res != 0)
			  {
			  	$msg = 'Success'
			  }else
			  {
			  	$msg =  'Failure';
			  }
			  $Result = array('status' =>$res,'data'=>$res ,'msg'=>$msg);
	            echo json_encode($Result);  
			break;
	default:

		$Result = array('status' => '0','data'=>'0' ,'msg'=>'Please Try Again');
	            echo json_encode($Result);
		break;
}

		

  





?>