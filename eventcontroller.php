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
include('services/generate_code.php');

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
else if($_REQUEST['act'] == 'event_apply')
{
  $applydata = json_decode(file_get_contents("php://input"));
  $cat_data = $applydata->ApplyEvent;
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

  $emailtemp = '<div style="background:none repeat scroll 0 0 #ffffff;margin-top:20px"> <label style="text-align:left;width:100%;font-weight:bold;font-size:17px;color:#d39a12;padding:6px 3px">Details</label> <table width="100%" style="border:1px solid #ccc;border-collapse:collapse"> <tbody><tr align="left"> <th style="border:1px solid #ccc">Attendee ID</th> <th style="border:1px solid #ccc">Name</th> <th style="border:1px solid #ccc">Email ID</th> </tr>'; 

    foreach($cat_data as $key => $value) {
        $id = $value->event_id.$value->applicant_id;
        $event_id = $value->event_id;
        $applicant_id = $value->applicant_id;
        $data = json_encode($value);
        $query_data[] =  "('$id','$value->applicant_id','$value->event_id',CURDATE(),'$value->fee_amount','$data','$value->organiser_id','1')";           
        
        $emailtemp .= '<tr align="left"> <td style="border:1px solid #ccc">'.$id.'</td> <td style="border:1px solid #ccc">'.$userdata->name.'</td> <td style="border:1px solid #ccc"><a href="mailto:'.$savebillingdata->email.'" target="_blank">'.$savebillingdata->email.'</a></td> </tr>';     
        }
        $emailtemp .= '</tbody></table></div>';

      $obj = new event_service();
      $res = $obj->apply_event($query_data);
     
  if($res != 0)
  { 
    $req = new paymentServices();
    $billing_status = $req->billing_data_save($savebillingdata,'2');
    $response = array('status' =>$res ,'data'=>[],'msg'=>'successfully applied');
    $emailres = new emailService();
    $code_obj = new generate_code();
    $athlete_code = $code_obj->get_code($id);
    if($athlete_code == true)
    {
    $res = $emailres->event_apply_email($cat_data, $savebillingdata,$userdata,$emailtemp);  
    }
    
  }
  else
  {
    $response = array('status' =>$res ,'data'=>[],'msg'=>'can not apply');
  }
  echo json_encode($response);
}






?>
