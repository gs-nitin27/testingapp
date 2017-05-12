<?php
include('config1.php');
include('services/userdataservice.php');
include('services/searchdataservice.php');
include('services/UserProfileService.php');
include('services/emailService.php');
include('services/event_service.php');
include('getSportyLite/liteservice.php');
include('services/connect_userservice.php');
error_reporting(E_ERROR | E_PARSE);

if($_REQUEST['act'] == "event_participants_list")
{
   $userid  = urldecode($_REQUEST['user_id']);
   $eventid = urldecode($_REQUEST['id']);
   $req = new event_service();
   $res = $req->event_participants_list($eventid);
   if($res)
   {
   	$data = array('data'=>$res,'status'=>'1');
   	echo json_encode($data);
   }
   else
   {
   	$data = array('data'=>[],'status'=>'0');
    	echo json_encode($data);
   }
}


/*******************Check The Pass Code ********************/


if($_REQUEST['act'] == 'check_passcode')  
{ 
   $data         =  file_get_contents("php://input");
   $userdata     =  json_decode(file_get_contents("php://input"));
   $req          =  new event_service();
   $res          =  $req->check_entry_passcode($userdata);
   if($res)
        {
          $data = array('status' => 1, 'data'=> $res  , 'msg'=>'valid pass code');
                  echo json_encode($data);
        }
        else
        {
            $data = array('status' => 0, 'data'=>$res, 'msg'=>'Not valid pass code');
                    echo json_encode($data);
        }  
}







?>
