<?php
include('config1.php');
include('services/userdataservice.php');
include('services/connect_userservice.php');
include('services/manageSchedulingService.php');
include('services/inventryservice.php');
include('services/smsOtpService.php');
include('services/emailService.php');
include('services/accountingService.php');
 

if($_REQUEST['act'] == 'connect')
{   
    $user_request_id    = $_REQUEST['lite_user_id'];
    $user_responser_id  = $_REQUEST['prof_user_id'];
    $user_app           = $_REQUEST['user_app'];
    $req                = new connect_userservice();
    $response           = $req->getConnect($user_request_id,$user_responser_id);
    if ($response)
    {
      $userresponse = array('status' =>0 , 'msg' => 'already connected');
      echo json_encode($userresponse);
    }
    else
    {
    $req = new connect_userservice();
    $connection_id = $req->connect_user_request($user_request_id , $user_responser_id);
    $userdata = new userdataservice();
    $request_user = $userdata->getuserdata($user_request_id);
    $name      = $request_user['name'];
    $prof_id   = $request_user['prof_id'];
    $sport     = $request_user['sport'];
    $user_data = $userdata->getuserdata($user_responser_id);
    $device_id = $user_data['device_id'];
    $array_data = array('connection_id' => $connection_id,'lite_user_id' => $user_request_id,'sport'=> $sport , 'prof_id' => $prof_id, 'title'=> 'New Connection Request', 'message'=> $name.' wants to connect with you' , 'device_id' => $device_id , 'indicator' => 1);
    $json_data = json_encode($array_data);
     if($connection_id)
    {
     $alerts = $req->alerts($user_responser_id ,$user_app ,$json_data);
     $userresponse = array('status' =>1 ,  'connection_status' => 0 ,'alerts'=>$alerts ,'message' => 'Request is sent');
     echo json_encode($userresponse);
    // $notification = $userdata->sendPushNotificationToGCM($device_id,$array_data);
    }
   else
    {
       $userresponse = array('status' =>0 , 'connection_status' => 0 , 'alerts'=>0 ,'message' => 'Request is  not sent');
       echo json_encode($userresponse);
    }
    $notification = $userdata->sendPushNotificationToGCM($device_id,$array_data);
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
 $userid         =  @$_REQUEST['userid'];   // Lite user id
 $usertype       =  @$_REQUEST['usertype'];
 $request        =  new connect_userservice();
 $response       =  $request->getConnectedUser($userid,$usertype);
 $response       =  $request->getConnectedStatus($response,$userid,$usertype);
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
 $userid         =  @$_REQUEST['userid'];         // this is a User Id whose Create the Class
 $student_id     =  $_REQUEST['student_userid'];  // Student User Id
 $request        =  new connect_userservice();
 $response       =  $request->getClassList($userid);
 if ($response)
 {
  if (!empty($student_id))
  {
    $response       =  $request->getClassJoinStudent($response, $student_id);
  }
    $Result = array('status' => '1','data'=>$response ,'msg'=>'Yes available class ');
        echo json_encode($Result);
 }
else
  {                     
          $Result = array('status' => '0','data'=>$response ,'msg'=>'No available class');
          echo json_encode($Result);
  } 
}


/******************* Display Class Information Created By Coach*************/

else if($_REQUEST['act'] == 'get_classes_info')
 {
 $class_id         =  @$_REQUEST['class_id'];
 $student_id       =  $_REQUEST['student_userid'];
 if(isset($_REQUEST['coach_id']))
 {
 $coach_id         =  $_REQUEST['coach_id'] ;
 }
 else
 {
  $coach_id = '';
 }
 $request          =  new connect_userservice();
 $con_res          =  $request->getConnect($student_id,$coach_id);
 $response         =  $request->getClassInfo($class_id);
 if ($response)
 {
  if (!empty($student_id))
  {
    $response              =  $request->getClassJoinStudent($response, $student_id);
  }
   $con_res                =   $request->getConnect($student_id,$coach_id);
   $response[0]['connection_status']= "$con_res";
   $Result = array('status' => '1','data'=>$response ,'msg'=>'class Information ');
   echo json_encode($Result);
}
   else
   {                     
         $Result = array('status' => '0','data'=>$response ,'msg'=>'class Information Not find');
          echo json_encode($Result);
   } 

}

else if($_REQUEST['act'] == 'get_class_view_status')
{
  $class_id         =  @$_REQUEST['class_id'];
  $student_id       =  $_REQUEST['student_userid'];
  $request          =  new connect_userservice();
  $response         =  $request->getClassInfo($class_id);
  $status = '0';
  if(isset($student_id))
  { 
    $join_status      =  $request->get_class_Join_status($class_id, $student_id);
    $demo_status      = $request->get_class_demo_status($class_id, $student_id);
    if($join_status != 0 )
    {
      if($join_status['status'] == 1)
      {
        $status = '2';
      }else
      {
        $status = '0';
      }
    }
    else if($demo_status != 0)
    {
      $status = '1';
    }else
    {
      $status = '0';
    }
    
  $response[0]['status'] = $status; 
  }
  $resp = array('status' => '1','data'=>$response ,'msg'=>'class Information');
  echo json_encode($resp);
}








/****************************Join the Student**********************************/

 



  else if($_REQUEST['act'] == 'join_student')
  { 
  $data              =  file_get_contents("php://input");
  $userdata          =  json_decode(file_get_contents("php://input"));
  $coach_id          =  $userdata->coach_id ;
  $classid           =  $userdata->classid;
  $student_id        =  $userdata->student_id; 
  $student_name      =  $userdata->student_name;  
  $class_name        =  $userdata->class_name; 
  $date              =  date("F j, Y, g:i a"); 
  $req               =  new inventryservice();
  $sno               =  $req->inventrylastid();
  $s_no              =  $sno['sno'] +1;
  $month             =  date("m");
  $year              =  date("y");
  $invoice           =  "DHS/".$month.$year."/".$s_no;
  $res               =  $req->createinventry($invoice,$userdata,$s_no);
  if($res)
  {
   $pushobj               =   new userdataservice();
   $coach_data            =   $pushobj->getdeviceid($coach_id);
   $coach_id_device_id    =   $coach_data['device_id'];

   $message      = array('message'=>$student_name ." "."has been enrolled for ".$class_name." class " ,'title'=>'New Student Enrolled','date_applied'=>$date,'userid'=>$student_id,'id'=>$classid,'indicator' => 7);
   $jsondata        =   json_encode($message);
   $pushnote        =   $pushobj->sendPushNotificationToGCM($coach_id_device_id, $message);
   $req             =   new connect_userservice();
   $res             =   $req->alerts($coach_id,L,$jsondata);
   $request         =   new connect_userservice();
   $response        =   $request->joinStudentData($userdata);
   if($response)
   {
             $Result = array('status' => '1','data'=>$response ,'msg'=>'Successfuly Insert Record');
             echo json_encode($Result);
   }
   else
   {                     
          $Result = array('status' => '0','data'=>'0' ,'msg'=>'Record is not Inserted');
          echo json_encode($Result);
   } 
}
else
{
          $Result = array('status' => '0','data'=>'0' ,'msg'=>'Inventry Record is not Inserted');
          echo json_encode($Result);
}

} // End Function



/*
Below Section code is for coach to add Athlete to his class 
*/

else if ($_REQUEST['act'] == 'add_athlete_to_class') 
{
    $data = json_decode(file_get_contents("php://input"));
    $student_code      =  $data->coach_id.$data->classid.rand(100,1000);
    $obj               =  new connect_userservice();
    $varify            =  $obj->checkExistingStudent($data);
    if($varify == 0)
    {
    $req               =  $obj->add_athlete($data,$student_code);
    if($req != 0)
    { 
    if ($data->phone != '')
    {
    $msg = "Hi +".$data->student_name."+ , coach + has + added + you + to + his + class,  + Download + our +  App +  From + "."https://goo.gl/8zncfT"." + and + use + code  + ".$student_code." +  to + join + his + class";
    $res = sendWay2SMS(9528454915,8824784642, $data->phone, $msg);
    }
    if($data->email != '')
    {
    $msg = "Hello ".$data->student_name.'<br>'.", Greetings from GetSporty".'<br>'."
coach  has added you to his class. To join and interact with your coach and team-mates, please download GetSporty App from Google play store. Use code ".$student_code." to join his class.
Please click on the link to download the App.".'<br><br>'."https://play.google.com/store/apps/details?id=getsportylite.darkhoprsesport.com.getsportylite&hl=en"; 
    $emailObj = new emailService();
    $send = $emailObj->email_athlete($data,$msg); 
    } 
    $resp = array('status'=>$req,'message'=>'Success');
    }else
    {
      $resp = array('status'=>$req,'message'=>'Failure');
    }
  }else
  {   ///print_r($varify);die;
      $resp = array('status'=>'0','message'=>'Athlete '.$varify['student_name'].' Already added to class');
      if ($data->phone != '')
    {
    $msg = "Hi +".$data->student_name."+ , coach + has + added + you + to + his + class  +  Download + our +  App +  From + "."https://goo.gl/8zncfT"." + and + use + code  + ".$varify['student_code']." +  to + join + his + class"; 
    $res = sendWay2SMS(9528454915,8824784642, $data->phone, $msg);
    }
    if($data->email != '')  
    {
    $msg = "Hello ".$data->student_name.'<br>'.", Greetings from GetSporty".'<br>'."
coach  has added you to his class. To join and interact with your coach and team-mates, please download GetSporty App from Google play store. Use code ".$varify['student_code']." to join his class.
Please click on the link to download the App.".'<br><br>'."https://play.google.com/store/apps/details?id=getsportylite.darkhoprsesport.com.getsportylite&hl=en"; 
    $emailObj = new emailService();
    $send = $emailObj->email_athlete($data,$msg); 
    } 
  }
      echo json_encode($resp);
}
/*END OF SECTION */
/*
Below Section code is for Athlete With code . from Which He could Directly join the class 
*/

else if ($_REQUEST['act'] == 'add_joining_code') 
{
 $data = json_decode(file_get_contents("php://input"));
 $Obj  = new connect_userservice();
 $req  = $Obj->join_class_usingCode($data);
 if($req != 0)
 {
  $resp = array('status'=> $req, 'msg'=>'Success');
  $obj1 =   new userdataservice();
    //echo $data->data[0]->userid;die;
    $data = json_decode($data->user_info);
    $userid = $data->userid;
    $get_id = $obj1->getdeviceid($userid);
    if($get_id != '')
    {
  $message = array('title'=> 'New Joinee', 'message'=>$data->data[0]->userName.' has successfully joined your class'.$data->data[0]->class_title  , 'device_id' => $get_id['device_id'] , 'indicator' =>10);  
    $notify = $obj1->sendPushNotificationToGCM();
    }
 }else
 {
  $resp = array('status'=>$req, 'msg'=>'Failure');
 }
 echo json_encode($resp);
 }

/*END OF SECTION */

/*
Below Section for maintaining demo log for the Athlete
*/

else if($_REQUEST['act'] == 'create_demo_request')
{ 
  $data  =  json_decode(file_get_contents("php://input"));
  $obj   =  new connect_userservice();
  $req   =  $obj->create_demo_request($data);
  $get_id = '';
  if($req != 0)
  { $resp = array('status'=>$req , 'msg'=>'Success');
    $obj1 =   new userdataservice();
    $get_id = $obj1->getdeviceid($data->coach_id);
    
  }
  else
  {
    $resp = array('status' => $req, 'msg'=>'Failure');
  }
  echo json_encode($resp);
  if($get_id != '')
    {
    $message = array('title'=> 'Class Demo Request', 'message'=>$data->userName.' has sent you a demo request for class '.$data->class_title  , 'device_id' => $get_id['device_id'],'id'=>$data->classid ,'indicator' =>10);  
    $notify = $obj1->sendPushNotificationToGCM($get_id['device_id'],$message);
    //print_r($notify);
    }
}




/*END OF SECTION*/


/*
Below section if for Fetching the requested demo students list For coach and Athlete
*/

else if($_REQUEST['act'] == 'demo_request_list')
{
  $coach_id =  $_REQUEST['coach_id'];
  $class_id =  $_REQUEST['class_id'];
  $where  = "`coach_id` ='$coach_id' AND `class_id`  = '$class_id'"; 
  $obj  = new connect_userservice();
  $req  = $obj->fetch_demoRequestlist($coach_id,$class_id);
  //echo $req;die;
  if($req != 0)
  {
  $resp = array('status'=>1,'data'=>$req,'msg'=>'Success');
  }else
  {
  $resp = array('status'=>$req,'data'=>[],'msg'=>'Failure');  
  }
  echo json_encode($resp);
}

/*END OF SECTION*/

/*
Below Section fetches the list of demo class_scheduled
*/

else if($_REQUEST['act'] == 'demo_class_list')
{
  $athlete_id =  $_REQUEST['athlete_id'];
  $where  = "`coach_id` ='$coach_id' AND `class_id`  = '$class_id'"; 
  $obj    = new connect_userservice();
  $req    = $obj->fetch_demoClassList($athlete_id); 
  if($req != 0)
  {
  $resp = array('status'=>1,'data'=>$req,'msg'=>'Success');
  }else
  {
  $resp = array('status'=>$req,'data'=>[],'msg'=>'Failure');  
  }
  echo json_encode($resp);
}
/*
END OF SECTION
*/





/*

When the User is view the All Class Information input our User Id and Get All Class

Student Id and Result is display all Class Information

*/


/*************************Get Join Student Information *******************************/
 else if($_REQUEST['act'] == 'class_info' ) 
{ 
 $student_id           =  $_REQUEST['userid'];
 $phone                =  $_REQUEST['contact_no'];
 $email                =  $_REQUEST['email'];
 $request              =  new connect_userservice();
 $response             =  $request->ClassInfo($student_id,$phone,$email);

   if($response != 0)
   {
              $Result = array('status' => '1','data'=>$response ,'msg'=>'all Class Information ');
              echo json_encode($Result);
   }
   else
   {                     
              $Result = array('status' => '0','data'=>$response ,'msg'=>'No Class Information');
              echo json_encode($Result);
   } 
}
// This Act are used to view all class created By User



/*********************************************************************/
else if($_REQUEST['act'] == 'get_schedule_Class')
{ 
$userid           =  $_REQUEST['userid'];
$schedule_id      =  $_REQUEST['schedule_id']; 
$request        =  new connect_userservice();
$response       =  $request->get_schedule_Class($userid,$schedule_id);
  if($response)
   {
             $Result = array('status' => '1','data'=>$response ,'msg'=>'All Class ');
             echo json_encode($Result);
   }
   else
   {      $response = [];                
          $Result = array('status' => '0','data'=>$response ,'msg'=>'Not any Class');
          echo json_encode($Result);
   } 
}

/*********************************View All Class************************/

else if($_REQUEST['act'] == 'view_class')
{ 
$userid           =  $_REQUEST['userid'];
$request        =  new connect_userservice();
$response       =  $request->getClass($userid);
  if($response)
   {
             $Result = array('status' => '1','data'=>$response ,'msg'=>'All Class ');
             echo json_encode($Result);
   }
   else
   {      $response = [];                
          $Result = array('status' => '0','data'=>$response ,'msg'=>'Not any Class');
          echo json_encode($Result);
   } 

}

/*********************************Daily Log************************/



else if($_REQUEST['act'] == 'daily_log')
{
 $data               =  file_get_contents("php://input");
 $userdata           =  json_decode(file_get_contents("php://input"));
 $request            =  new connect_userservice();
 $response           =  $request->createdDailyLog($userdata);

if($response)

   {

             $Result = array('status' => '1','data'=>$response ,'msg'=>'Create Daily Log ');

             echo json_encode($Result);

   }

   else

   {                     

          $Result = array('status' => '0','data'=>[] ,'msg'=>'Not Create Daily Log');

          echo json_encode($Result);

   } 

}





/*********************************View Daily Log************************/





else if($_REQUEST['act'] == 'view_dailylog')
{
  $userid            =   @$_REQUEST['userid'];
  $request           =  new connect_userservice();
  $response          =  $request->viewDailyLog($userid);
  if($response)
     {     
               $Result = array('status'=>'1','data'=>$response ,'msg'=>'View Daily Log');
               echo json_encode($Result);
     }
     else
     {                     
            $Result = array('status' => '0','data'=>[] ,'msg'=>'No Daily Log');
            echo json_encode($Result);
     } 

  }

/****************************List of paid **********************************/



else if($_REQUEST['act'] == 'get_paidclasslisting')

{

  $coach_id          =  @$_REQUEST['coach_id'];

  $flag              =  @$_REQUEST['flag'];             // flag =1 Paid and and flag =0 for Not Paid

  $request           =  new connect_userservice();

  $response          =  $request->accounting($coach_id,$flag);

  if($response)

     {     
               $Result = array('status'=>'1','data'=>$response ,'msg'=>'Get Paid Listing');
               echo json_encode($Result);
     }

     else

     {                     

            $Result = array('status' => '0','data'=>[] ,'msg'=>'No Paid Listing');

            echo json_encode($Result);

     } 

  }



/**************************************************************/



else if($_REQUEST['act'] == 'get_studentpaidlisting')

{

$class_id                =  @$_REQUEST['class_id'];

$flag                    =  @$_REQUEST['flag'];        // flag =1 Paid and and flag =0 for Not Paid

$request                 =  new connect_userservice();

$response                =  $request->studentPaidListing($class_id,$flag);

if($response)

    {     

               $Result = array('status'=>'1','data'=>$response ,'msg'=>'Student Paid Listing');

               echo json_encode($Result);

     }

     else

     {                     

            $Result = array('status' => '0','data'=>[] ,'msg'=>'No Paid');

            echo json_encode($Result);

     } 

  }



 /****************************create log  **********************************/



 else if ($_REQUEST['act'] == 'create_log_assign') 
{

    $data                          =   json_decode($_POST['data']);
    $item                          =   new stdClass();
    $item->coach_id                =   $data->coach_id; 
    $item->phase                   =   $data->phase;
    $item->activity                =   $data->activity;
    $item->duration                =   $data->duration;
    $item->distance                =   $data->distance;
    $item->time_of_day             =   $data->time_of_day;
    $item->remark                  =   $data->remark;
    $item->repetition              =   $data->repetition;
    $item->performance             =   $data->performance;
    $req                           =   new connect_userservice();
    $res                           =   $req->coach_log_assign($item);
    if($res)
    {
       $result = array('status' => 1);
       echo json_encode($result);
    }
    else
    {
       $result  = array('status' => 0);
       echo json_encode($result);
    }    
} 


/**********************************Edit create_log_assign ***************/

 else if ($_REQUEST['act'] == 'edit_log_assign') 
{
    $data                          =   json_decode($_POST['data']);
    $item                          =   new stdClass();
    $item->assign_id               =   $data->id; 
    $item->coach_id                =   $data->coach_id; 
    $item->phase                   =   $data->phase;
    $item->activity                =   $data->activity;
    $item->duration                =   $data->duration;
    $item->distance                =   $data->distance;
    $item->time_of_day             =   $data->time_of_day;
    $item->remark                  =   $data->remark;
    $item->repetition              =   $data->repetition;
    $item->performance             =   $data->performance;
    $req                           =   new connect_userservice();
    $res                           =   $req->edit_log_assign($item);
    if($res)
    {
       $result = array('status' => 1);
       echo json_encode($result);
    }
    else
    {
       $result  = array('status' => 0);
       echo json_encode($result);
    }    
} 
/**************************************************************************************/

/****************************For  Log list filters   **********************************/

else if($_REQUEST['act'] == 'coach_schedule_student_list')
{
      $data = json_decode($_POST['data']);     
      $req = new  connect_userservice();
      $studentlist = $req->studentschedulelist($data->userid,$data->schedule_id);
        if($studentlist)
          {
            $result = array('status' =>1 , 'data' =>$studentlist);
            echo json_encode($result);
         }
        else
          {
              $result =  array('status' =>0  ,'data' => []);
              echo json_encode($result);
          }
    
}


else if($_REQUEST['act'] == 'view_schedule_assign_list')
{
      $data = json_decode($_REQUEST['data']);     
      $req = new  connect_userservice();

      $studentlist = $req->view_schedule_assign($data->userid,$data->schedule_id);
        if($studentlist)
          {
            $result = array('status' =>1 , 'data' =>$studentlist);
            echo json_encode($result);
         }
        else
          {
              $result =  array('status' =>0  ,'data' => []);
              echo json_encode($result);
          }
    
}

//--------------------------------------------------




else if ($_REQUEST['act'] == 'coach_log_student_list')
{

      $data = json_decode($_POST['data']);
      $req = new  connect_userservice();
      if($data->indicator == 'studentlist')
      {
         $studentlist = $req->studentlist($data->userid,$data->logid);
         if($studentlist)
         {
            $result = array('status' =>1 , 'data' =>$studentlist);
            echo json_encode($result);
         }
         else
         {
            $result =  array('status' =>0  ,'data' => []);
            echo json_encode($result);
         }
      }
      else if($data->indicator == 'class')
      {
        $res = $req->getClass($data->userid);
        $result = array('status' =>1 , 'data' =>$res);
        echo json_encode($result); 
      }
      else if($data->indicator == 'gender')
      {
        $studentlist = $req->studentlistgender($data->userid,$data->parameter,$data->logid);

        if($studentlist){

        $result = array('status' =>1 , 'data' =>$studentlist);

        echo json_encode($result);

         }

         else

         {

           $result = array('status' =>0 , 'data' =>[]);

           echo json_encode($result);

         }

      }

      else if($data->indicator == 'age_group')

      {

        $agegrp =  explode("-",$data->parameter);

        $res = $req->getClass($data->userid);

        if($res)

        {

        $arr=[];

        $temp = [];

        foreach ($res as $key ) {

          $studentlist = $req->studentlist($key['id'],$data->logid);

            $arr[] = $studentlist;

        }

           for ($i=0; $i <sizeof($arr[0]) ; $i++) { 

                 $date_1 = new DateTime($arr[0][$i]['student_dob']);

                 $date_2 = new DateTime( date( 'd-m-Y' ));

                 $difference = $date_2->diff( $date_1 );

                 $year=(string)$difference->y;



                 if($year > $agegrp[0] && $year < $agegrp[1])

                 {

                    $temp[] =  $arr[0][$i];

                 }

           }

         $result = array('status' =>1 , 'data' =>$temp);

         echo json_encode($result);

         }

     else

       {

        $result = array('status' =>0 , 'data' =>[]);

        echo json_encode($result);

     }

      }

}



 /****************************create log list   **********************************/


else if ($_REQUEST['act'] == 'coach_log_list')
{
       $data = json_decode($_POST['data']);
       $req = new  connect_userservice();
       $res = $req->coach_log_list($data->coach_id);
       if($res)
       {
         $result = array('status' => 1, 'data' => $res);
        echo json_encode($result);
       }
       else
       {
        $result = array('status' => 0, 'data' => []);
       echo json_encode($result);
       }
}
 /****************************activity search for autocomplete  **********************************/
else if($_REQUEST['act'] == 'activity_search')
{
       $req = new  connect_userservice();
       $res = $req->search_activity();
       if($res)
       {
          $result = array('status' => 1, 'data' => $res);
          echo json_encode($result);
       }
       else
       {
          $result = array('status' => 0, 'data' => []);
          echo json_encode($result);
       }
}  

 /****************************Log Assign by coach  **********************************/

 else if($_REQUEST['act'] == 'log_assign')
 {
    $data = json_decode($_POST['data']);
    $req = new connect_userservice();
    $log = $req->logdata($data->logid);
    $date = date("Y-m-d ");
    $coach = new userdataservice();
    $coachdata = $coach->userdata($log[0]['coach_id']);
    $student_list = explode(",", $data->student_id_list);
    $value  ="";
    $userid = $student_list;
    $st ="(";
    $phase                =  $log[0]['phase'];
    $activity             =  $log[0]['activity'];
    $remarks              =  $log[0]['remarks'];
    $coach_assignment_id  =  $log[0]['id'];
    $date                 =  date("Y-m-d ");
    $duration             =  0 ;
    $distance             =  0 ;
    $performance          =  0 ;
    $repetition           =  0 ;
    $k  = ")";
for($i=0;$i<sizeof($userid);$i++)
{    
      if($i == 0)
      {
      $value  .=$st.$userid[$i].",'".$phase."','".$activity."','".$remarks."','".$coach_assignment_id."','".$date."',".$duration.",'".$distance."',".$performance.",".$repetition.$k;
      }
      else
      {
        $value  .=",".$st.$userid[$i].",'".$phase."','".$activity."','".$remarks."','".$coach_assignment_id."','".$date."',".$duration.",'".$distance."',".$performance.",".$repetition.$k;
      }  
}
     $res= $req->new_log_assign($value);


  //   print_r($res);die;
   // for ($i=0; $i <sizeof($student_list) ; $i++) 
   // {
         // $res = $req->log_assign($student_list[$i] ,$log);
    // if($res)
    // {
    //   for($i=0;$i<sizeof($userid);$i++)
    //    {
    //   $studentdata = $coach->userdata($userid[$i]);
    //  // print_r($studentdata);//die;
    //   $message      = array('message'=>$coachdata['name']." "." has assigned you a task" ,'title'=>'New Assignment','date_assign'=>$date,'id'=>$log[0]['id'],'indicator' => 6);
    //   $jsondata       = json_encode($message);
    //   $req->alerts(102,'L',$jsondata);
    //   $coach->sendLitePushNotificationToGCM($studentdata['device_id'],$jsondata);
    //    }
    //   }
    if($res)
    {
       $result =  array('status' =>1);
       echo json_encode($result);
       
           $alldevice = $req->alluserdata($data->student_id_list);  
           //print_r($alldevice);
            
            $alertdata = "";
            $k=0;
            foreach ($alldevice as $value) {
              //alldevice
               // print_r($userid[$k]);
              # code...
           // }($i=0;$i<sizeof($userid);$i++)
            //{
              $start = "(";
              $user_id = $userid[$k];
              $end = ")";  
              $message  = array('message'=>$coachdata['name']." "." has assigned you a task" ,'title'=>'New Assignment','date_assign'=>$date,'id'=>$log[0]['id'],'indicator' => 6);
              $jsondata       = json_encode($message);
               if($k==0)
              {
                $k = $k+1;
                $alertdata .=$start.$user_id.",'L','".$jsondata."','".$date."'".$end;
              }
              else
              {
                $k = $k+1;
                $alertdata .=",".$start.$user_id.",'L','".$jsondata."','".$date."'".$end;
              }
               $coach->sendLitePushNotificationToGCM($value['device_id'],$jsondata);
            }
              $req->bulk_alerts_save($alertdata);

           // print_r($alertdata);
         //  die;
      // for($i=0;$i<sizeof($userid);$i++)
     //  {
     //  $studentdata = $coach->userdata($userid[$i]);
    //   $message      = array('message'=>$coachdata['name']." "." has assigned you a task" ,'title'=>'New Assignment','date_assign'=>$date,'id'=>$log[0]['id'],'indicator' => 6);
    //  $jsondata       = json_encode($message);
    //  $req->alerts(102,'L',$jsondata);
   //   $coach->sendLitePushNotificationToGCM($studentdata['device_id'],$jsondata);
   //    }
    }
    else
    {
       $result =  array('status' =>0);
       echo json_encode($result);
    }
 }





/****************************View the Coach Log***************************/





else if($_REQUEST['act'] == "view_coach_log")
{
  $coach_assignment_id    =  @$_REQUEST['coach_assignment_id'];
   $request               =  new connect_userservice();
  $response               =  $request->view_coach_log($coach_assignment_id); 
  if ($response)
  {
    $Result = array('status' => '1','data'=>$response,'msg'=>'view coach log ');
          echo json_encode($Result);      
  }
  else
  {
  $Result = array('status' => '0','data'=>$response ,'msg'=>'Not Any Log ');
          echo json_encode($Result);      
  }
}



else if($_REQUEST['act'] == 'view_log_assign')
{
   $data = json_decode($_POST['data']);
   $req = new connect_userservice();
   $res = $req->view_log_assign($data->userid,$data->logid);
   if($res)
   {
    $result = array('status' =>1 , 'data' =>$res);
    echo json_encode($result);
   }
   else
   {
    $result =  array('status' => 0, 'data' =>[]);
    echo json_encode($result);
   }
}
/******************************** UPDATE THE COACH LOG FILE**************************/
else if($_REQUEST['act'] == 'update_log')
{
  $data               =  file_get_contents("php://input");
  $userdata           =  json_decode(file_get_contents("php://input"));
  $request           =  new connect_userservice();
  $response          =  $request->updatelog($userdata);
if($response)
   {
             $Result = array('status' => '1','data'=>'1' ,'msg'=>'Updated Log');
             echo json_encode($Result);
   }
   else
   {                     
          $Result = array('status' => '0','data'=>'0' ,'msg'=>'Not Updated Log');
          echo json_encode($Result);
   } 
}






/*************************** View Athlete Log by the Athelete *****************************/

else if($_REQUEST['act'] == 'veiw_athlete_log')
{
  $coach_id          =  @$_REQUEST['coach_id'];
  $athlete_id        =  @$_REQUEST['athlete_id'];
  $request           =  new connect_userservice();
  $response          =  $request->veiw_athlete_log($coach_id,$athlete_id);
  if($response)
  {
             $Result = array('status' => '1','data'=>$response ,'msg'=>'view Athlete Log');
             echo json_encode($Result);
  }
  else 
  {                     
             $Result = array('status' => '0','data'=>[] ,'msg'=>'Not seen Athlete Log');
             echo json_encode($Result);
  } 
}



/*************************Create Schedule**********************************/

else if ($_REQUEST['act'] == 'create_schedule') 
{
  $data = json_decode(file_get_contents("php://input"));
  $obj  = new connect_userservice();


  $res  = $obj->create_user_schedule($data);
  

  if($res != 0)
  {  
    if($data->userType =='L')
    {
    $assigned = $obj->save_athlete_schedule($data->userid,$res); 
    if($assigned)
    {
    $msg = 'Success';
    $status = 1;
    }
    else
    {
    $msg = 'Failure';
    $status = 0;
    }
  }
    else
    {
    $msg = 'Success';
    $status = 1;
    }
    
  }
  else
  {
    $msg = 'Failure';
    $status = 0;
  }
    $response = array('status'=>$status,'data'=>$res,'msg'=>$msg);
    echo json_encode($response);

}

/*************************View Schedule**********************************/

  else if($_REQUEST['act'] == 'view_schedule')
  {
      $user_id = $_REQUEST['user_id'];
      $req = new connect_userservice();
      $res = $req->view_user_schedule($user_id);
      if($res != "0")
      {
        $response = array('status' => '1','data'=>$res,'msg'=>'Success' );
        echo json_encode($response);
      }
      else
      {
        $response = array('status' => '0','data'=>[],'msg'=>'Failure' );
        echo json_encode($response);
      }
  }  



/*********************View coach schedule *************************/

  else if($_REQUEST['act'] == 'view_coach_schedule')
  {
      $user_id = $_REQUEST['user_id'];
      $req = new connect_userservice();
      $res = $req->view_coach_schedule($user_id);
      if($res != "0")
      {
        $response = array('status' => '1','data'=>$res,'msg'=>'Success' );
        echo json_encode($response);
      }
      else
      {
        $response = array('status' => '0','data'=>[],'msg'=>'Failure' );
        echo json_encode($response);
      }
  }  



/******************************Edit Schedule*******************/

  else if($_REQUEST['act'] == 'edit_schedule')
  {
      $data     = json_decode(file_get_contents("php://input"));
      $req      = new connect_userservice();
      $res      = $req->edit_schedule($data);
      if($res != "0")
      {
        $response = array('status' => '1','data'=>'1','msg'=>'Edit Success' );
        echo json_encode($response);
      }
      else
      {
        $response = array('status' => '0','data'=>'0','msg'=>'Failure' );
        echo json_encode($response);
      }
  }  

/*****************************Unassign Sechedule***************************/

else if($_REQUEST['act'] == 'schedule_unassign')
{
  $data               =  json_decode(file_get_contents("php://input"));
  $req                =  new connect_userservice();
  $res                =  $req->schedule_unassign($data);
  if($res=='1')
  {
  $status = "1";
  $message = "Success";
  }
  else
  {
  $status = "0";  
  $message = "Failure";  
  }
  $response = array('status' => $status,'data'=>$res,'msg'=>$message );
  echo json_encode($response);
}




/*********************************Update Schedule**************************/

else if($_REQUEST['act'] == 'update_schedule')
{
  $id             = $_REQUEST['id'];
  $time_of_day    = $_REQUEST['time_of_day'];
  $active_status  = $_REQUEST['active_status'];
  $req            = new connect_userservice();
  $res            = $req->update_user_schedule($id,$time_of_day,$active_status);
  if($res=='1')
  {
  $status = "1";
  $message = "Success";
  }
  else
  {
  $status = "0";  
  $message = "Failure";  
  }
  $response = array('status' => $status,'data'=>$res,'msg'=>$message );
  echo json_encode($response);
}
/**************************** Assign Schedule to Athlete**********************/


 else if($_REQUEST['act'] == 'schedule_assign')
 {
    $data = json_decode(file_get_contents("php://input"));

    $coach = new userdataservice();
    $coachdata = $coach->userdata($data->coach_id);
 
    $req = new connect_userservice();
    $date = date("Y-m-d ");
    $athlete_list = explode(",", $data->athlete_id_list);
    $value  ="";
    $athleteid = $athlete_list;
    $st ="(";
    $coach_id             = $data->coach_id;
    $schedule_id          = $data->schedule_id;
    $status               = 1;
    $k  = ")";
for($i=0;$i<sizeof($athleteid);$i++)
{    
    if($i == 0)
    {
    $value  .=$st."'".$athleteid[$i]."','".$coach_id."','".$schedule_id."','".$date."','".$status."'".$k;
    }
    else
    {
    $value  .=",".$st."'".$athleteid[$i]."','".$coach_id."','".$schedule_id."','".$date."','".$status."'".$k;
    }  
}
   
    $res= $req->new_schedule_assign($value);


    if($res)
    {
       $result =  array('status' =>1);
       echo json_encode($result);
       
            $alldevice = $req->alluserdata($data->athlete_id_list);  
            $alertdata = "";
            $k=0;
            foreach ($alldevice as $value) {
              $start = "(";
              $user_id = $athleteid[$k];
              $end = ")";  
              $message  = array('message'=>$coachdata['name']." "." has assigned you a task" ,'title'=>'New Assignment','date_assign'=>$date,'id'=>$schedule_id,'indicator' => 6);
              $jsondata       = json_encode($message);
               if($k==0)
              {
                $k = $k+1;
                $alertdata .=$start.$user_id.",'L','".$jsondata."','".$date."'".$end;
              }
              else
              {
                $k = $k+1;
                $alertdata .=",".$start.$user_id.",'L','".$jsondata."','".$date."'".$end;
              }
               $coach->sendLitePushNotificationToGCM($value['device_id'],$jsondata);
            }
              $req->bulk_alerts_save($alertdata);
    }
    else
    {
       $result =  array('status' =>0);
       echo json_encode($result);
    }
 }


/***************************Un Assign log  By The Coach***********************/

else if($_REQUEST['act'] == 'log_unassign')
{
  $data               =  json_decode(file_get_contents("php://input"));
  $req                =  new connect_userservice();
  $res                =  $req->log_unassign($data);
  if($res=='1')
  {
  $status = "1";
  $message = "Success";
  }
  else
  {
  $status = "0";  
  $message = "Failure";  
  }
  $response = array('status' => $status,'data'=>$res,'msg'=>$message );
  echo json_encode($response);
}



// **************************   ********************************



else if ($_REQUEST['act'] == 'send_sms_to_athelete') {
    $data              = json_decode(file_get_contents("php://input"));
    $athlete_name      = $data->athlete_name;
    $coach_sport       = $data->coach_sport;
    $athlete_no        =  $data->athlete_no;
    $coach_contact_no  =  $data->coach_contact_no;
    $athlete_email     = $data->athlete_email;
    if($coach_contact_no != '')
    {
    $msg = "You +have +received +connection+ request +from +".$athlete_name." +on+ Getsporty+.+ He+ is+ looking +for+ a +".$coach_sport." +Coach+.+You+ can+ reach+ him +on+ ".$athlete_no."+ or+ ".$athlete_email.""; 
    $res = sendWay2SMS(9528454915,8824784642, $coach_contact_no, $msg);
    $resp = array('status'=>1,'message'=>'Success');
      echo json_encode($resp);
    }
    else
    {
      $resp = array('status'=>0,'message'=>'Failure');
      echo json_encode($resp);

    }
    
}
else if($_REQUEST['act'] == 'remove_demo_athlete')
{
  $demo_code = $_REQUEST['demo_code'];
  $obj = new connect_userservice();
  $req = $obj->remove_demo_request($demo_code);
  if($req != 0)
  {
    $resp = array('status' => $req , 'msg'=>'Success' );
  }else
  {
    $resp = array('status'=>$req,'msg'=>'Failure');
  }
  echo json_encode($resp);
}

else if($_REQUEST['act'] == 'decline_coachclass_offer')
{
  $data = json_decode(file_get_contents("php://input"));
  $obj = new connect_userservice();
  $req = $obj->decline_joinclass_offer($data);
  if($req != 0)
  {
    $resp = array('status' => $req , 'msg'=>'Success' );
  }else
  {
    $resp = array('status'=>$req,'msg'=>'Failure');
  }
  echo json_encode($resp);
}






else if ($_REQUEST['act'] == 'athlete_attendance')
{
  $class_id   =  $_REQUEST['class_id'];
  $data       =     file_get_contents("php://input");
  $obj        = new connect_userservice();
  $req        = $obj->athlete_attendance($class_id,$data);
  if($req != 0)
  {
    $resp = array('status' => $req , 'msg'=>'Success' );
  }else
  {
    $resp = array('status'=>$req,'msg'=>'Failure');
  }
  echo json_encode($resp);



}




?>
