<?php
include('config1.php');
include('services/parentsUserService.php');
include('services/emailService.php');
include('services/userdataservice.php');
include('services/generate_code.php');
error_reporting(E_ERROR | E_PARSE);
$nodata = [];
//print_r($_REQUEST);die;
switch($_REQUEST['act']) 
{
	case 'view_parent_child':
		$parent_id       =  $_REQUEST['parent_id'];
		$request         =  new parentsUserService();
		$response['child_data'] =  $request->get_parent_child($parent_id);
	if($response['child_data'] != 0)
	 {          
                 $response['split_age'] = '12';
                 $response['payment_age'] = '15';
	             $Result = array('status' => '1','data'=>$response ,'msg'=>'view Child');
	             echo json_encode($Result);
	 }
	 else
	 {                     
	            $Result = array('status' => '0','data'=>(object)[] ,'msg'=>'No  Child');
	            echo json_encode($Result);
	 }

	break;

	case 'add_child':
	 $data                     =  file_get_contents("php://input");
	 $decode_data        	   =  json_decode(file_get_contents("php://input"));
     $request           	   =  new userdataservice();
     $age                      =  date_diff(date_create($decode_data->dob), date_create('today'))->y;
     if($age > 12 || $age == 12)
     {
     $where = "WHERE `email` ='".$decode_data->email."'";
     $status = '1';
     //echo  $where;die;
     }
     else
     {//echo 'no';die;
      $where = "WHERE `name`= '".$decode_data->name."' AND `dob`= '".$decode_data->dob."'";
      $status = '0';
     }
     $already_child            =  $request->userVarify($where);
     if($already_child != 0) 
     {  
     	$getcodeObj = new parentsUserService();
        $email_req  = new emailService();
        $getcode = $getcodeObj->get_association_data($decode_data->userid,$already_child['userid']);
        if($getcode == 0)
        {
        $unique_code = rand();
        $create_assoc = $getcodeObj->insert_association($decode_data->userid,$already_child['userid'],$unique_code,$status);
        $getcode = $getcodeObj->get_association_data($decode_data->userid,$already_child['userid']);
        $send_email = $email_req->ActivateChildAccount($decode_data->email,$getcode['unique_code']);
        }
        else
        {
          $send_email = $email_req->ActivateChildAccount($decode_data->email,$getcode['unique_code']);
        }
         //$status = "1";
         if($create_assoc == 1)
         {
         	$Result = array('status' => '1','data'=>'already added'/*$already_child*/ ,'msg'=>'Child is Already exists as user');
	        $message = array('title'=> "your guardian ".$decode_data->parent_name." has sent you a connection request", 'message'=>'they can review your performance and daily activities','parentId'=>$already_child['userid'],'parent_image'=>$decode_data->parent_image,'parentName'=>$decode_data->parent_name,'device_id' => $already_child['device_id'] , 'indicator' =>12); 
			    $obj1 =   new userdataservice(); 
			    $notify = $obj1->sendLitePushNotificationToGCM($already_child['device_id'],$message);
	     }else
	     {
	     	$Result = array('status' => '0','data'=>'0' ,'msg'=>'Child is Already exists, unable to add');
	     }
	     echo json_encode($Result);
	    
	 }
     else
     {//echo "test2";die;
     $request1                 = new parentsUserService();
     $response                 =  $request1->add_child($decode_data,$status);
	 if($response)
	 {
	             $Result = array('status' => '1','data'=>'child added' ,'msg'=>'Child added');
	             echo json_encode($Result);
	 }
	 else
	 {                     
	            $Result = array('status' => '0','data'=>"no data" ,'msg'=>'Child not added');
                echo json_encode($Result);
     }

	}

	break;

	case 'activate_child_account':  // Api for activating child account by a parent

		  $parent_id 		= $_REQUEST['parent_id'];

		  $child_id 		= $_REQUEST['child_id'];

		  $child_email		= $_REQUEST['child_email'];

		  $parent_mobile 	= $_REQUEST['mobile_no'];
          //$location 	 	= $_REQUEST['location'];
          $req       		= new parentsUserService();

		  $activated = $req->activateAccount($parent_id,$child_id,$child_email,$parent_mobile/*$location*/);

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

			  //$email = $_REQUEST['email'];

			  $req = new parentsUserService();

			  $res = $req->child_account_verify($code/*,$email*/);

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
//               print_r($_REQUEST);
			  $child_id 	    = $_REQUEST['child_id'];

			  $parent_email 	= $_REQUEST['parent_email'];

              $mobile           = $_REQUEST['mobile_no'];
 
			  $req       		= new userdataservice();

			  $where            = "WHERE `email` ='".$parent_email."'";//  Check if user is registered as parent
             // echo $where;die;
			  $Verified         = $req->userVarify($where);
              //print_r($Verified);die;
              if($Verified == '0')

			  { 
                $Obj  = new parentsUserService();
                $create_account = $Obj->add_Parent($parent_email,$child_id); 
                $status = "1";
                $msg = 'success';
                $email_req  = new emailService();
                $send_email = $email_req->ActivateChildAccount($parent_email,$create_account);
              }

			  else

			  {
			    if($Verified['prof_name'] == 'Parent')
			    {   
                    $getcodeObj = new parentsUserService();
                    $email_req  = new emailService();
	                $getcode = $getcodeObj->get_association_data($Verified['userid'],$child_id);
                    if($getcode == 0)
                    {
                    $unique_code = rand();
                    $create_assoc = $getcodeObj->insert_association($Verified['userid'],$child_id,$unique_code,'-1');
                    $getcode = $getcodeObj->get_association_data($Verified['userid'],$child_id);
                    $send_email = $email_req->ActivateChildAccount($parent_email,$getcode['unique_code'],$Verified['name']);
                    }else
                    {
                      $send_email = $email_req->ActivateChildAccount($parent_email,$getcode['unique_code'],$Verified['name']);
                    }
                $status = "1";
                $msg = 'Account already exist as parent, connection request sent';
                $message = array('title'=> "your child ".$_REQUEST['child_name']." has sent you a connection request", 'message'=>'get daily updates and review his performance and activities daily on app','parentId'=>$Verified['userid'],'user_image'=>$Verified['user_image'],'parentName'=>$Verified['name'], 'device_id' => $Verified['device_id'] , 'indicator' =>11); 
			    $obj1 =   new userdataservice(); 
			    $notify = $obj1->sendLitePushNotificationToGCM($Verified['device_id'],$message);
                }else
                {
			    $status = "0";
                $msg = 'Account already exist as '.$Verified['prof_name'];
                }/*$getcodeObj = new parentsUserService();
                $getcode = $getcodeObj->get_association_data($Verified['userid'],$child_id)*/
               /* $email_req  = new emailService();
                ;*/

			  }
              $response = array('status'=>$status,/*'data'=>$getcode,*/'msg'=>$msg);
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
                case 'get_parent_info':
           $child_id = $_REQUEST['child_id'];
           $request  = new parentsUserService($child_id);
           $response = $request->getParentInfo($child_id);
           {
           	if(!empty($response))
           	{
           		$data = array('status' =>'1' ,'data'=>$response );
           	}else
           	{
           		$data = array('status' =>'0' ,'data'=>$response );
           	}
           echo json_encode($data);
           }
         break;
        default:
        $Result = array('status' => '0','data'=>'0' ,'msg'=>'Please Try Again');

	    echo json_encode($Result);
        break;
}
?>