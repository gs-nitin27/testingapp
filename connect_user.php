<?php
include('config1.php');
include('services/userdataservice.php');
include('services/connect_userservice.php');
include('services/manageSchedulingService.php');

 
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
 //print_r($response);die();
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
 $response       =  $request->getClass($userid);
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
 $coach_id         =  $_REQUEST['coach_id'] ;
 $request          =  new connect_userservice();
 $con_res          =  $request->getConnect($student_id,$coach_id);
 $response         =  $request->getClassInfo($class_id);
 if ($response)
 {
  	if (!empty($student_id))
 	{
 		$response       =  $request->getClassJoinStudent($response, $student_id);
 	}
  $con_res          =  $request->getConnect($student_id,$coach_id);
  if ($con_res) 
  {
    $response[0]['connection_status']='1';
  }
  else
  {
    $response[0]['connection_status']='0';
  }
           

  
             $Result = array('status' => '1','data'=>$response ,'msg'=>'class Information ');
             echo json_encode($Result);
}
   else
   {                     
          $Result = array('status' => '0','data'=>$response ,'msg'=>'class Information Not find');
          echo json_encode($Result);
   } 
}





/****************************Join the Student**********************************/


  else if($_REQUEST['act'] == 'join_student')
  { 
  $data              =  file_get_contents("php://input");
  $userdata          =  json_decode(file_get_contents("php://input"));
  $coach_id          =  $userdata->coach_id ;
  $classid           =  $userdata->classid;
   //                 =   userdata($coach_id); This code are used to send Notification
  $student_id        =  $userdata->userid;  
  $request           =  new connect_userservice();
  $response          =  $request->alreadyStudent($student_id,$classid);
  if($response)
   {
            $Result = array('status' => '0','data'=>'0' ,'msg'=>'User already exists');
             echo json_encode($Result);
   }
else
{
   $response          =  $request->joinStudentData($userdata);
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

}







/*
When the User is view the All Class Information input our User Id and Get All Class
Student Id and Result is display all Class Information
*/

/*************************Get Join Student Information *******************************/


 else if($_REQUEST['act'] == 'class_info' ) 
 { 
 $student_id           =  $_REQUEST['userid'];
 
 $request              =  new connect_userservice();
 $response             =  $request->ClassInfo($student_id);
   if($response)
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
   {                     
          $Result = array('status' => '0','data'=>$response ,'msg'=>'Not any Class');
          echo json_encode($Result);
   } 
}



/*********************************Daily Log************************/

else if($_REQUEST['act'] == 'daily_log')
{
 
 $data               =  file_get_contents("php://input");
 $userdata           =  json_decode(file_get_contents("php://input"));
  $request           =  new connect_userservice();
  $response          =  $request->createdDailyLog($userdata);
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
    $data   = json_decode($_POST['data']);
    $item    =  new stdClass();
    $item->coach_id                =   $data->coach_id; 
    $item->phase                   =   $data->phase;
    $item->activity                =   $data->activity;
    $item->duration                =   $data->duration;
    $item->distance                =   $data->distance;
    $item->time_of_day             =   $data->time_of_day;
    $item->remark                  =   $data->remark;
    $item->target_repetition       =   $data->repetition;
    $item->performance             =   $data->performance;
    $req                 =  new connect_userservice();
    $res                 =  $req->coach_log_assign($item);

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



/****************************For  Log list filters   **********************************/

else if ($_REQUEST['act'] == 'coach_log_student_list')
{
      $data = json_decode($_POST['data']);
      $req = new  connect_userservice();
      if($data->indicator == 'studentlist')
      {
        $res = $req->getClass($data->userid);
        if($res)
        {
        $arr=[];
        foreach ($res as $key ) 
        {
          $studentlist = $req->studentlist($key['id']);
          array_push($arr,$studentlist);
        }
        $result = array('status' =>1 , 'data' =>$arr);
        echo json_encode($result);
        }
         else
         {
           $result = array('status' =>0 , 'data' =>[]);
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
       $res = $req->getClass($data->userid);
        if($res)
        {
        $arr=[];
        foreach ($res as $key )
         {
          $studentlist = $req->studentlistgender($key['id'],$data->parameter);
          array_push($arr,$studentlist);
        }
        $result = array('status' =>1 , 'data' =>$arr);
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
          $studentlist = $req->studentlist($key['id']);
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
     
     $student_list = explode(",", $data->student_id_list);
     for ($i=0; $i <sizeof($student_list) ; $i++) 
      {
           $res = $req->log_assign($student_list[$i] ,$log);
      }
    if($res)
    {
       $result =  array('status' =>1);
       echo json_encode($result);
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








