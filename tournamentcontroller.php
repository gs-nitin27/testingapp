<?php
include('config1.php');
include('services/userdataservice.php');
include('services/searchdataservice.php');
include('services/UserProfileService.php');
include('services/emailService.php');
include('services/event_service.php');
include('getSportyLite/liteservice.php');
include('services/connect_userservice.php');
include('services/tournament_service.php');


error_reporting(E_ERROR | E_PARSE);

if($_REQUEST['act'] == "tournament_participants_list")
{
   $userid  = urldecode($_REQUEST['user_id']);
   $tournament_id = urldecode($_REQUEST['tournament_id']);
   $req     = new tournament_service();
   $res     = $req->tournament_participants_list($tournament_id);
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





?>
