<?php
include('config1.php');
include('services/userdataservice.php');
include('services/searchdataservice.php');
include('services/UserProfileService.php');
include('services/emailService.php');
include('services/event_service.php');
include('getSportyLite/liteservice.php');
include('services/connect_userservice.php');
include('services/paymentServices.php');
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
  $applydata = json_decode(file_get_contents("php://input"));

  $cat_data = $applydata->ApplyTournament;
  $billingdata = json_decode($applydata->response_data);
  $savebillingdata =  $billingdata->result; 
  $userdata  = $applydata->userdata;
  

  $date = date("Y-m-d");
  $date1 = explode('-', $date);
  $monthNum  = $date1[1];
  $dateObj   = DateTime::createFromFormat('!m', $monthNum);
  $monthName = $dateObj->format('F');
  $year = date("y");
  $invoiceid = "GSTN/1/".$year.$date1[1].$date1[2]."/".$savebillingdata->productinfo;
  $paymentdate = $date1[2]."-" .$monthName."-".$date1[0];

  $savebillingdata->invoice_id =  $invoiceid;
  $savebillingdata->transaction_data = $applydata->response_data;
  $savebillingdata->userid = $cat_data[0]->applicant_id;
  $savebillingdata->date = $paymentdate;


  $obj = new tournament_service();
  $res = $obj->apply_tournament($cat_data);

  //$res = 1;

  if($res != 0)
  { 
    $req = new paymentServices();
    $billing_status = $req->billing_data_save($savebillingdata);
    $response = array('status' =>$res ,'data'=>[],'msg'=>'successfully applied');
    $emailres = new emailService();
    $eres = $emailres->tournament_apply_email($cat_data, $savebillingdata,$userdata);
  }
  else
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



else if($_REQUEST['act'] == "tournament_appy_catogery")
{
   $tournament_id = $_REQUEST['tournament_id'];
   $userid = $_REQUEST['userid'];

   $req = new tournament_service();


   $res = $req->tournament_apply_catogery($tournament_id,$userid);


   if($res)
   {
      $data = array('status' => '1','data' =>$res ,'msg'=>'Success');
     
   }
   else
   {
    $data = array('status' => '0','data' =>[] ,'msg'=>'failure');
   }
    echo json_encode($data);
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
