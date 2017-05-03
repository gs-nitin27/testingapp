<?php
include('config1.php');
include('services/parentsUserService.php');
error_reporting(E_ERROR | E_PARSE);


switch ($_REQUEST['act']) 
{

	case 'add_child':
	 $data                     =  file_get_contents("php://input");
	 $decode_data        	   =  json_decode(file_get_contents("php://input"));
     $request           	   =  new parentsUserService();
     $already_child            =  $request->varify_child($decode_data);
     if ($already_child) 
     {
     	 $Result = array('status' => '0','data'=>'0' ,'msg'=>'Child is Already exists ');
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
	            $Result = array('status' => '0','data'=>'0' ,'msg'=>'Not Add Child');
	            echo json_encode($Result);
	 }
	}
	break;
	default:

		$Result = array('status' => '0','data'=>'0' ,'msg'=>'Please Try Again');
	            echo json_encode($Result);
		break;
}

		

  





?>