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
    $name = $request_user['name'];
    $user_data = $userdata->getuserdata($user_responser_id);
    $device_id = $user_data['device_id'];
    $array_data = array('connection_id' => $connection_id, 'title'=> 'New Connection Request', 'msg'=> $name.' wants to connect with you' , 'device_id' => $device_id);
    $json_data = json_encode($array_data);

    if($connection_id)
    {
     $notification = $userdata->sendPushNotificationToGCM($device_id,$array_data);
     $alerts = $req->alerts($user_responser_id ,$user_app ,$json_data); 
     $userresponse = array('status' =>1 ,  'connection_status' => 0 , 'msg' => 'Request is sent');

     echo json_encode($userresponse);
    }
    else
    {
       $userresponse = array('status' =>0 , 'connection_status' => 0 , 'msg' => 'Request is  not sent');
       echo json_encode($userresponse);
    }
}

 else if($_REQUEST['act'] == 'request_response')
 { 
   //$data =  json_decode($_REQUEST['data']); 
   $request_id  = $_REQUEST['id'];
   $req_status  = $_REQUEST['req_status'];
   $user_app    = $_REQUEST['user_app'];

   $req = new connect_userservice();
   $res = $req->connect_user_response($request_id , $req_status);
   if($res == 1){

         $user_id =  $req->getuserid($request_id);
         $userid = $user_id['lite_user_id'];
         $userdata = new userdataservice();
         $request_user = $userdata->getuserdata($userid);
         $response_user = $userdata->getuserdata($user_id['prof_user_id']);
         $response_user_name = $response_user['name'];
         $device_id = $request_user['device_id'];
         $json_data = array('title'=> 'New Connection ', 'msg'=> $response_user_name.' is connected with you' , 'device_id' => $device_id);
         $json_data = json_encode($json_data);
         $notification = $userdata->sendLitePushNotificationToGCM($device_id,$json_data);
         $alerts =$req->alerts($userid ,$user_app , $json_data) ;
         $message_seen = $req->updateseennotification($alerts);
           
         $user = array('status' => 1, 'msg'=>'User Connected' );
         echo json_encode($user);

   }
   else if($res == 2)
   {
    $user = array('status' => 2, 'msg'=>'User Not Connected' );
   echo json_encode($user);
   }
   else if($res == 3)
   {
     $user = array('status' => 3,  'msg' => 'Request is cancelled');
     echo json_encode($user);
   }
   else
   {
     $user = array('status' => 4, 'msg' =>'Request is not cancelled');
   }
}




