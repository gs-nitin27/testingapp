<?php
include('config1.php');
include('services/parentsUserService.php');
include('services/emailService.php');
include('services/userdataservice.php');
include('services/generate_code.php');
error_reporting(E_ERROR | E_PARSE);
$nodata = [];
switch($_REQUEST['act']) 
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

		  $parent_id 		= $_REQUEST['parent_id'];

		  $child_id 		= $_REQUEST['child_id'];

		  $child_email		= $_REQUEST['child_email'];

		  $parent_mobile 	= $_REQUEST['mobile_no'];

		  $location 	 	= $_REQUEST['location'];



		  $req       		= new parentsUserService();

		  $activated = $req->activateAccount($parent_id,$child_id,$child_email,$parent_mobile,$location);

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

			  	$msg = 'Success';

			  }else

			  {

			  	$msg =  'Failure';

			  }

			  $Result = array('status' =>$res,'data'=>$res ,'msg'=>$msg);

	            echo json_encode($Result);  

		break;

	    case 'add_parent':  // Api for Adding Parent account by child

			  $child_id 	    = $_REQUEST['child_id'];

			  $parent_email 	= $_REQUEST['parent_email'];

			  $req       		= new userdataservice();

			  $where            = "WHERE `email` =".$parent_email." ";

			  $Verified         = $req->userVarify($where);

			  if($activated == 0)

			  { $Obj  = new parentsUserService();

			  	$create_account = $Obj->add_Parent($parent_email,$child_id); 

			  	$status = $create_account;

			  	$msg = 'success';

			  }

			  else

			  {

			    $status = "0";

			  	$msg = 'failure';

			  }

			  $response = array('status'=>$getcode,'data'=>$getcode,'message'=>$msg);

			        echo json_encode($response); 

		break;

/*

	This act for cheack the child is apply on Job,Event, Tournament and display the All child of 

	particular 

	id = for job Id , event Id, or Tournament Id

	module => 1 for job, 2 for event , 3 for tournament

*/

			case 'get_child_status':

					$parent_id       =  $_REQUEST['parent_id'];

					$id        		 =  $_REQUEST['id'];

					$module      	 =  $_REQUEST['module'];

					$request         =  new parentsUserService();

					$response 		 =  $request->get_all_child($parent_id,$id,$module);

				if($response)

				 {

				             $Result = array('status' => '1','data'=>$response ,'msg'=>'Child List');

				             echo json_encode($Result);

				 }

				 else

				 {                     

				            $Result = array('status' => '0','data'=>$response ,'msg'=>'No  Child List');

				            echo json_encode($Result);

				 }



		break;



			case 'child_apply':

					$child_ids       =  $_REQUEST['child_ids'];  // User id

					$res_id       	 =  $_REQUEST['res_id'];  // jobID OR eventID Or TournamentID

					$module      	 =  $_REQUEST['module'];  // Module 1=Job, 2= Event 3= Tournament

					$parent_name   	 =  $_REQUEST['parent_name'];

					$parent_email  	 =  $_REQUEST['parent_email'];

					$request         =  new parentsUserService();

					$response 		 =  $request->child_apply($child_ids,$res_id,$module,$parent_name,$parent_email);

				if($response)

				 {

				            $Result = array('status' => '1','data'=>$response ,'msg'=>'apply success');

				             echo json_encode($Result);

				 }

				 else

				 {                     

				            $Result = array('status' => '0','data'=>$response ,'msg'=>'Not apply');

				            echo json_encode($Result);

				 }



		break;







	default:



		$Result = array('status' => '0','data'=>'0' ,'msg'=>'Please Try Again');

	            echo json_encode($Result);

		break;
}
?>