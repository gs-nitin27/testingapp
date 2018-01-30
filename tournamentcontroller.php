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
else if($_REQUEST['act'] == "tournament_sports")
{
    $obj = new tournament_service();
    $res = $obj->get_tournament_sports();
    if($res != 0)
    {
      $resp = array('status' =>'1' ,'data'=>$res,'msg'=>'Success');
    }else
    {
      $resp = array('status' =>'0' , 'data'=>[],'msg'=>'Failure');
    }
echo json_encode($resp);

}
else if($_REQUEST['act'] == 'tournament_apply')
{
  $applydata = '[{"applicant_id":"234","tournament_id":"231","fee_amount":"23444","organiser_id":"32","event_schedule":"2018-01-23","category_code":"BL1"},{"applicant_id":"234","tournament_id":"231","fee_amount":"23444","organiser_id":"32","event_schedule":"2018-01-23","category_code":"BL2"}]';
  $cat_data = json_decode($applydata);
  $obj = new tournament_service();
  $res = $obj->apply_tournament($cat_data);
  if($res != 0)
  {
    $response = array('status' =>$res ,'data'=>[],'msg'=>'successfully applied');
  }else
  {
    $response = array('status' =>$res ,'data'=>[],'msg'=>'can not apply');
  }
  echo json_encode($response);
}


else if($_REQUEST['act'] == 'participant_list')
{
$tournament_id = $_REQUEST['id'];
$where  = "WHERE `tournament_id` = '$tournament_id'";
$obj    = new tournament_service();
$resp   = $obj->get_participant_list($where);
if($resp != 0)
  {
  $result = array('status' =>'1','data'=>$resp , 'msg'=>'Success');
  }
  else
  {
  $result = array('status' =>'0','data'=>$resp , 'msg'=>'failure');  
  }
echo json_encode($result);
}
// else if($_REQUEST['act'] == 'get_tour_events')
// {
// $userid  = $_REQUEST['userid'];
// $gender  = $_REQUEST['gender'];
// $dob     = $_REQUEST['dob'];
// $age_obj = new connect_userservice();
// $age = $age_obj->getage($dob);
// $events = '{"category": [
//     {
//       "age": "12",
//       "date": "",
//       "event": "50 metre backstroke",
//       "eventId": "SW1",
//       "fee": "100",
//       "gender": "M",
//       "groupId": "12M0",
//       "time": ""
//     },
//     {
//       "age": "12",
//       "date": "",
//       "event": "100 metre backstroke",
//       "eventId": "SW2",
//       "fee": "100",
//       "gender": "M",
//       "groupId": "12M0",
//       "time": ""
//     },
//     {
//       "age": "14",
//       "date": "",
//       "event": "200 metre backstroke",
//       "eventId": "SW3",
//       "fee": "300",
//       "gender": "F",
//       "groupId": "14F1",
//       "time": ""
//     },
//     {
//       "age": "14",
//       "date": "",
//       "event": "50 metre breaststroke",
//       "eventId": "SW4",
//       "fee": "300",
//       "gender": "F",
//       "groupId": "14F1",
//       "time": ""
//     }
//   ]
// }';
// $events = json_decode($events);





// }


?>
