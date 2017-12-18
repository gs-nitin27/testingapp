<?php
include('config1.php');
include('services/user_access_service.php');

if($_REQUEST['act'] == 'gs_login')
{
$data = json_decode($_REQUEST['data']);
$email = $data->email;
$login_type  = $data->loginType;                     // Login Via Facebook Or Google

$obj = new User_access_service();
  if($login_type == '1') {                           // Login From Facebook
	       
  $app_type = $data->app;                            // L=liteapp , M=manage app 
  $fb_id = $data->data->id;
  if($email != '')
  {
   $where = "`email` = '".$email."' ";
   
   $obj_var = $obj->find_user_data($where);
	  if($obj_var != 0)
	  {
	  	if($obj_var[$app_type.'_fb_id'] == '')
		{
		$update = "`".$app_type."_fb_id` = '".$fb_id."'";
		$where  = "`userid`= '".$obj_var['userid']."'"; 
		$updt_obj = $obj->update_user_data($update,$where); //update Facebook Id for the particular email for a app
		}
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
		   $resp = array('status' =>'3' ,'data'=>[] , 'msg'=>'please sign up to proceed');  //to get details from user validate email id and create a new record;
		  }  
	  }
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
	  
	   $resp = array('status' =>'3' ,'data'=>[] , 'msg'=>'please sign up to proceed');  //to get details from user validate email id and create a new record;
	  }  
    } 
  }
  else if($login_type == 2)  {                             // Login From Google
   $google_id = $data->data->id;	
   $where = "`email` = '".$data->email."'";
   $obj_var = $obj->find_user_data($where);
   if($obj_var != 0)
    {
    if($obj_var['google_id'] == '')
		{
	     $update_clause  = "`google_id` = '".$data->data->id."'";// google id updation on successfull login from google
	     $where = "`userid` = '".$obj_var['userid']."'";
	     $updt_obj = $obj->update_user_data($update_clause,$where); 
	     $resp = array('status' =>'1' ,'data'=>$obj_var , 'msg'=>'Successfully logged In'); // To get email id from user verify and update
	    }else
	    {
	  $resp = array('status' =>'3' ,'data'=>[] , 'msg'=>'please sign up to proceed');  //to get details from user validate email id and create a new record;

	    }
   
    }
   }
  echo json_encode($resp);
 }
else if($_REQUEST['act'] = 'gs_signup')
{

$email        = $_REQUEST['email'];
$loginType    = $_REQUEST['login'];
$app_type     = $_REQUEST['app'];  
$login_status = $_REQUEST['status']; // login status got in response basis on which the updation or new record creation process will be carried out;
$app_id       = $_REQUEST['app_id'];
$obj_var = new User_access_service();
if($login_status == '2' && $loginType == '1')
{
	$where = "`email` = '".$email."'";
	$resp = $obj_var->find_user_data($where);
	if($resp != 0)
	{
	$array = array('status' =>'0' ,'data'=>$resp , 'msg'=>'user already exist with same email id');	
	}
	else
	{
	$update = "`email`= '".$_REQUEST['email']."'";
	$where  = "`".$app_type."_fb_id` = '".$app_id."'";
	$resp   = $obj_var->update_user_data($update,$where);
	$array = array('status' =>'0' ,'data'=>$resp , 'msg'=>'user info successfully updated');	
	}
}
else if($login_status == '3')
	{
      $create = $obj_var->create_new_user($_REQUEST);
      if($create !=0)
      {
      	$resp = array('status' => 1, 'data'=>$create ,  'msg'=>'record created');
      }
      else
      {
      	$resp = array('status' => 0, 'data'=>[] ,  'msg'=>'record not created');
      }
      echo json_encode($resp);
	}
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