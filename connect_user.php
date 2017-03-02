<?php
include('config1.php');
include('services/userdataservice.php');
include('services/connect_userservice.php');

 
if($_REQUEST['act'] == 'connect')
{
    $user_request_id = $_REQUEST['lite_user_id'];
    $user_responser_id = $_REQUEST['prof_user_id'];
    $user_app = $_REQUEST['user_app'];
    $req = new connect_userservice();
    $connection_id = $req->connect_user_request($user_request_id , $user_responser_id);
    $userdata = new userdataservice();
    $request_user = $userdata->getuserdata($user_request_id);
    $name      = $request_user['name'];
    $prof_id   = $request_user['prof_id'];
    $user_data = $userdata->getuserdata($user_responser_id);
    $device_id = $user_data['device_id'];
    $array_data = array('connection_id' => $connection_id,'lite_user_id' => $user_request_id, 'prof_id' => $prof_id, 'title'=> 'New Connection Request', 'message'=> $name.' wants to connect with you' , 'device_id' => $device_id , 'indicator' => 1);
    $json_data = json_encode($array_data);
    if($connection_id)
    {
     $notification = $userdata->sendPushNotificationToGCM($device_id,$array_data);
     $alerts = $req->alerts($user_responser_id ,$user_app ,$json_data); 
     $userresponse = array('status' =>1 ,  'connection_status' => 0 , 'message' => 'Request is sent');

     echo json_encode($userresponse);
    }
    else
    {
       $userresponse = array('status' =>0 , 'connection_status' => 0 , 'message' => 'Request is  not sent');
       echo json_encode($userresponse);
    }
}



 else if($_REQUEST['act'] == 'request_response')
 { 

   $request_id  = $_REQUEST['id'];
   $req_status  = $_REQUEST['req_status'];
   $user_app    = $_REQUEST['user_app'];
   $req = new connect_userservice();
   $res = $req->connect_user_response($request_id , $req_status);
   if($res == 1)
   {
         $user_id       =  $req->getuserid($request_id);
         $lite_user_id  =$user_id[0]['lite_user_id'];
         $userdata      = new userdataservice();
         $request_user  = $userdata->getuserdata($lite_user_id);
         $response_user  = $userdata->getuserdata($user_id[0]['prof_user_id']);
         $response_user_name = $response_user['name'];
         $device_id = $request_user['device_id'];
         $array_data = array('title'=> 'New Connection ', 'message'=> $response_user_name.' is connected with you' , 'device_id' => $device_id , 'indicator' =>2);
         $json_data = json_encode($array_data);
         $notification = $userdata->sendLitePushNotificationToGCM($device_id,$array_data);
         $alerts =$req->alerts($lite_user_id ,$user_app , $json_data) ;
         $message_seen = $req->updateseennotification($alerts);
         $user = array('status' => 1, 'message'=>'User Connected' );
         echo json_encode($user);


   }
   else if($res == 2)
   {
    $user = array('status' => 0, 'message'=>'User Not Connected' );
   echo json_encode($user);
   }
   else if($res == 3)
   {
     $user = array('status' => 2,  'message' => 'Request is cancelled');
     echo json_encode($user);
   }
   else
   {
     $user = array('status' => 0, 'message' =>'Request is not cancelled');
   }
}







/*****************************Get All Connected Users*******************************/

 else if($_REQUEST['act'] == 'get_connected_users')
 { 
 $userid         =  @$_REQUEST['userid'];
 $usertype       =  @$_REQUEST['usertype'];
 $request        =  new connect_userservice();
 $response       =  $request->getConnectedUser($userid,$usertype);
 $response       =  $request->getConnectedStatus($response, $userid);
   if($response)
   {

             $Result = array('status' => '1','data'=>$response ,'msg'=>'All Connected user');
             echo json_encode($Result);
   }
   else
   {                     
          $Result = array('status' => '0','data'=>$response ,'msg'=>'User is Not Connected');
          echo json_encode($Result);
   } 
}



/********************************Get All Requested Users************************/


 else if($_REQUEST['act'] == 'get_requested_users')
 { 
 $userid         =  @$_REQUEST['userid'];
 $usertype       =  @$_REQUEST['usertype'];
 $request        =  new connect_userservice();
 $response       =  $request->getRequestedUser($userid,$usertype);
   if($response)
   {
             $Result = array('status' => '1','data'=>$response ,'msg'=>'All Connected user');
             echo json_encode($Result);
   }
   else
   {                     
          $Result = array('status' => '0','data'=>$response ,'msg'=>'No User is Connected');
          echo json_encode($Result);
   } 
}



/******************display Coach Profile and Total Student *******************/

else if($_REQUEST['act'] == 'get_organized_classes')
 { 

 $userid         =  @$_REQUEST['userid'];
 $request        =  new connect_userservice();
 $response       =  $request->getClass($userid);
   if($response)
   {
             $Result = array('status' => '1','data'=>$response ,'msg'=>'Yes available class ');
             echo json_encode($Result);
   }
   else
   {                     
          $Result = array('status' => '0','data'=>$response ,'msg'=>'No available class');
          echo json_encode($Result);
   } 
}
