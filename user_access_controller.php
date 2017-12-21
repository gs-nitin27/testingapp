<?php
include('config1.php');
include('services/user_access_service.php');
include('services/userdataservice.php');
include('services/UserProfileService.php');


if($_REQUEST['act'] == 'gs_login')
{
$data = file_get_contents("php://input");           //json_decode($_REQUEST['data']);
$data = json_decode($data);
$login_type  = $data->loginType;                    // Login Via Facebook Or Google
if(isset($data->data->email))
{
	$email = $data->data->email;
}
else
{
	$email = '';
}
$obj = new User_access_service();
$req = new userdataservice();
  if($login_type == '1'){                            // Login From Facebook
  $app_type = $data->app;                            // L=liteapp , M=manageapp 
  $fb_id = $data->data->id;
  if($email != '')
  {
   $where = "`email` = '".$email."' ";
   $obj_var = $obj->find_user_data($where);
	  if($obj_var != 0)
	  {
	  	if($obj_var[$app_type.'_fb_id'] == '' || $obj_var[$app_type.'_fb_id'] == 0)
		{
		$update = "`".$app_type."_fb_id` = '".$fb_id."'";
		$where  = "`userid`= '".$obj_var['userid']."'"; 
		$updt_obj = $obj->update_user_data($update,$where); //update Facebook Id for the particular email for a app
		}
		 if($obj_var['prof_name'] == 'Athletes')
	      {
	        $obj_var['classes'] = $req->connected_class($obj_var['userid']);  // To get connected classes
	      }
	        $obj_var['profile'] = $req->checkprofile($obj_var['userid']);  // To get profile completion percentage
	    $resp = array('status' => '1','data'=>$obj_var,'msg'=>'login successfull'); //
	  }
	  else  // No Record found from email value
	  {
		  $where = "`".$app_type."_fb_id` = '".$fb_id."' ";
		  $obj_var = $obj->find_user_data($where);
		  if($obj_var != 0)
		  {
		   $resp = array('status' =>'2' ,'data'=>$obj_var , 'msg'=>'please update your info'); // To get email id from user verify and update
		  }
	   else
	     {
	   // $resp = array('status' =>'3' ,'data'=>[] , 'msg'=>'please sign up to proceed');
         $create_obj = 	$obj->create_user($data);
         if($create_obj != 0)
         {
         $resp = array('status' =>'3' ,'data'=>$create_obj , 'msg'=>'record created');
         }
	     else
	     {
	     $resp = array('status' =>'4' ,'data'=>[] , 'msg'=>'unable to create record');
	     }
		}  
	  }
   }
  else  // No Record found from email value
  {
	  $where = "`".$app_type."_fb_id` = '".$fb_id."' ";
	  $obj_var = $obj->find_user_data($where);
	  if($obj_var != 0)
	  {

		 // if($obj_var['prof_name'] == 'Athletes')
	  //     {
	  //       $obj_var['classes'] = $req->connected_class($obj_var['userid']);  // To get connected classes
	  //     }
	  //       $obj_var['profile'] = $req->checkprofile($obj_var['userid']);  // To get 	
	   $resp = array('status' =>'2' ,'data'=>$obj_var , 'msg'=>'please update your info'); // To get email id from user verify and update
	  }
	   else
	  {
	  
         $create_obj = 	$obj->create_user($data);
         if($create_obj != 0)
         {
         $resp = array('status' =>'3' ,'data'=>$create_obj , 'msg'=>'record created');
         }
	     else
	     {
	     $resp = array('status' =>'4' ,'data'=>[] , 'msg'=>'unable to create record');
	     }

	   // $resp = array('status' =>'3' ,'data'=>[] , 'msg'=>'please sign up to proceed');  //to get details from user validate email id and create a new record;
	  }  
    } 
  }
   else if($login_type == 2)  {                             // Login From Google
   $google_id = $data->data->id;	
   $where = "`email` = '".$data->email."'";
   $obj_var = $obj->find_user_data($where);
   //print_r($obj_var);die;
   if($obj_var != 0)
    {
    if($obj_var['google_id'] == '')
		{
	     $update_clause  = "`google_id` = '".$data->data->id."'";// google id updation on successfull login from google
	     $where = "`userid` = '".$obj_var['userid']."'";
	     $updt_obj = $obj->update_user_data($update_clause,$where); 
	      // To get email id from user verify and update
	     }
	     if($obj_var['prof_name'] == 'Athletes')
	      {
	        $obj_var['classes'] = $req->connected_class($obj_var['userid']);   // to get connected classes 
	      }
	     $obj_var['profile'] = $req->checkprofile($obj_var['userid']);      // to get profile completion percentage 
	     $resp = array('status' =>'1' ,'data'=>$obj_var , 'msg'=>'Successfully logged In');
	}
	else
    {

   // $resp = array('status' =>'3' ,'data'=>[] , 'msg'=>'please sign up to proceed'); 
     $create_obj = 	$obj->create_user($data);
     if($create_obj != 0)
     {
     $resp = array('status' =>'3' ,'data'=>$create_obj , 'msg'=>'record created');
     }
     else
     {
     $resp = array('status' =>'4' ,'data'=>[] , 'msg'=>'unable to create record');
     }
     //  to get details from user validate email id and create a new record;
    }
  }
  echo json_encode($resp);
 }


else if($_REQUEST['act'] = 'gs_signup')
{

$data1 = json_decode(file_get_contents("php://input"));
$item                 =  new stdClass();
$item->app            =  $data1->app;
$item->loginType      =  $data1->loginType;
$item->id             =  $data1->data->id;
$item->name           =  $data1->data->name;
$item->email          =  $data1->data->email;
$item->image          =  $data1->data->image;
$item->phone_no       =  $data1->phone_no;
$item->prof_name      =  $data1->prof_name;
$item->sport          =  $data1->sport;
$item->login_status   =  $data1->login_status;
$item->gender         =  $data1->gender;
$item->dob            =  $data1->dob;
$item->userType       =  103;
$item->location       =  $data1->location;
//$item->forget_code    =  $forgot_code;
$item->prof_id        =  $data1->prof_id;
$item->device_id      =  $data1->device_id;
$obj_var = new User_access_service();
$where = "`email` = '".$item->email."'";
$resp = $obj_var->find_user_data($where);
if($resp != 0)
{
if($item->loginType == '1')
	{
		$column = $item->app."_fb_id";

	}
else
	{
		$column = "google_id";
	}
	//print_r($resp);die;
if($resp[$column] == $item->id && $resp['status'] == '1')
{

  	$update = "`email`= '".$item->email."',`name` = '".$item->name."',`contact_no` = '".$item->phone_no."',`prof_name` = '".$item->prof_name."',`prof_id` = '".$item->prof_id."',`sport` = '".$item->sport."',`gender` = '".$item->gender."',`dob` = '".$item->dob."',`location` = '".$item->location."',`device_id` = '".$item->device_id."'";
	$where  = "`email` = '".$item->email."'";
	$resp   = $obj_var->update_user_data($update,$where);
	$resp = array('status' =>'1' ,'data'=>$resp , 'msg'=>'user info successfully updated');


}
else
{
  $resp = array('status' =>'0' ,'data'=>$resp , 'msg'=>'user already exist with same email id');
}

}
else
{
$update = "`email`= '".$item->email."',`name` = '".$item->name."',`contact_no` = '".$item->phone_no."',`prof_name` = '".$item->prof_name."',`prof_id` = '".$item->prof_id."',`sport` = '".$item->sport."',`gender` = '".$item->gender."',`dob` = '".$item->dob."',`location` = '".$item->location."',`device_id` = '".$item->device_id."'";
	$where  = "`".$item->app."_fb_id` = '".$item->id."'";
	$resp   = $obj_var->update_user_data($update,$where);
	$resp = array('status' =>'1' ,'data'=>$resp , 'msg'=>'user info successfully updated');
}

// if($item->login_status == '2' && $item->loginType == '1')
// {   
	
// 	if($resp != 0)
// 	{
// 	$array = array('status' =>'1' ,'data'=>$resp , 'msg'=>'user already exist with same email id');	
// 	}
// 	else
// 	{
// 	$update = "`email`= '".$item->email."',`name` = '".$item->name."',`contact_no` = '".$item->phone_no."',`prof_name` = '".$item->prof_name."',`prof_id` = '".$item->prof_id."',`sport` = '".$item->sport."',`gender` = '".$item->gender."',`dob` = '".$item->dob."',`location` = '".$item->location."',`device_id` = '".$item->device_id."'";
// 	$where  = "`".$app_type."_fb_id` = '".$app_id."'";
// 	$resp   = $obj_var->update_user_data($update,$where);
// 	$array = array('status' =>'1' ,'data'=>$resp , 'msg'=>'user info successfully updated');	
// 	}
// 	//$update_info =  
// }
// else if($item->login_status == '3')
// 	{ 

//       $create = $obj_var->create_new_user($item);
//       if($create !=0)
//       { 
//       	if($item->app == 'L')
//       	{
//          {
// 	        $obj_var['classes'] = $req->connected_class($create['userid']);  // To get connected classes
// 	     }
// 	        $obj_var['profile'] = $req->checkprofile($create['userid']);  // To get 

//       	}
//       	$resp = array('status' => 1, 'data'=>$create ,  'msg'=>'record created');

//       }
//       else
//       {
//       	$resp = array('status' => 0, 'data'=>[] ,  'msg'=>'record not created');
//       }
//       echo json_encode($resp);
// 	}
echo json_encode($resp);
}

// Response status parameter Indication  
// 
// Login API
// 1 = Successfull Login
// 2 = asking user for email/Phone for Updation and verification 
// 3 = Creating a new user record
// 
// 
// Signup API
// 
// 1 = Record created and updated user logs in
// 0 = not created 
// 
// 
// 


 ?>