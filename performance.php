<?php
include('config1.php');
include('services/userperformance.php');
include('services/emailService.php');

if($_REQUEST['act'] == 'get_modules')	
{ 
   $data 			    =  file_get_contents("php://input");
   $userdata 	    =  json_decode(file_get_contents("php://input"));
   $sport         =  $userdata->sport;
   $gender        =  $userdata->gender;
   $dob		        =  $userdata->dob;
   $coachid       =  $userdata->coachid;
   $athleteid     =  $userdata->athleteid;
   $req_age       =  new UserPerformanceService();
   $age           =  $req_age->ageGropup($dob,$gender);
   $cheak         =  $req_age->cheackPerformance($age,$sport,$gender);
   $res = 0;
   if($cheak != 0)
   { 
     $id          =  $req_age->save($coachid,$athleteid);
     $req           =  new UserPerformanceService();
     $res           =  $req->userPerformance($id,$age,$sport,$gender);
   }
   if($res != 0)
        {
          $data = array('status' => 1, 'data'=> $res  , 'msg'=>'Success');
                  echo json_encode($data);
        }
        else
        {
            $data = array('status' => 0, 'data'=>$res, 'msg'=>'Failure');
                    echo json_encode($data);
        }  

} // End of Statment



else if($_REQUEST['act'] == 'save_performance') 
{
   $data          =  file_get_contents("php://input");
   $userdata      =  json_decode(file_get_contents("php://input"));

   //print_r($userdata);  die();
   
   $req           =  new UserPerformanceService();
   $res           =  $req->savePerformance($userdata);

        if($res)
        {
          $data = array('status' => 1, 'data'=> $res, 'msg'=>'Save Success');
                  echo json_encode($data);
        }
        else
        {
            $data = array('status' => 0, 'data'=>$res, 'msg'=>'Not Save');
                    echo json_encode($data);
        }  

} // End of Statment





else if($_REQUEST['act'] == 'publish_performance') 
{
   $data          =  file_get_contents("php://input");
   $userdata      =  json_decode(file_get_contents("php://input"));
   $req           =  new UserPerformanceService();
   $res           =  $req->publishPerformance($userdata);
        if($res)
        {
          $data = array('status' => 1, 'data'=> $res, 'msg'=>'Publish Success');
                  echo json_encode($data);
        }
        else
        {
            $data = array('status' => 0, 'data'=>$res, 'msg'=>'Not Publish');
                    echo json_encode($data);
        }  

} // End of Statment








/***********************View Performance*******************************/

else if($_REQUEST['act'] == 'view_performance') 
{
  $data          =  file_get_contents("php://input");
  $userdata      =  json_decode(file_get_contents("php://input"));
  $athleteid     =  $userdata->athleteid;
  $assessment     =  $userdata->assessment;
  $req           =  new UserPerformanceService();
  $res           =  $req->viewPerformance($athleteid,$assessment);
   if($assessment==0)
   {
    $day =-1;
   }
   else
   {
     $day           =  $res[0]['next_assessment'];
   }
        if($res)
        {
          $data = array('status' => 1, 'data'=> $res, 'msg'=>'View Athlete Profile','next_assessment'=>$day);
                  echo json_encode($data);
        }
        else
        {
            $data = array('status' => 0, 'data'=>$res, 'msg'=>'Not Record');
                    echo json_encode($data);
        }  

} // End of Statment

/************************* View Guidelines ************************/

else if ($_REQUEST['act'] == 'view_guidelines') 
{         
          $data      =  json_decode(file_get_contents("php://input"));
          $req       =  new UserPerformanceService();
          $age       =  $req->ageGropup($data->dob,$data->gender);
          $res       =  $req->viewPerformanceguide($data,$age);
          if($res)
          {
              $array = array('status' => 1, 'data'=>$res, 'msg'=>'Success');
              echo json_encode($array);
          }
          else 
          {
              $array = array('status' => 0, 'data'=>$res, 'msg'=>'failure');
              echo json_encode($array);
          }
}




/******************* Suggestion  gs_suggestion ******************/

else if($_REQUEST['act'] == 'save_suggestion') 
{         $data          =  file_get_contents("php://input");
          $userdata      =  json_decode(file_get_contents("php://input")); 

          $req           =  new UserPerformanceService();
          $res           =  $req->suggestion($userdata);
          if($res)
          {
             $result = array('status' => 1, 'data'=>$res, 'msg'=>'Your suggestion is successfully sent') ;
              echo json_encode($result);
          }
          else 
          {
              $result = array('status' => 0, 'data'=>$res, 'msg'=>'Suggestion not send');
              echo json_encode($result);
          }
}



/***********************Request Assessment  by Athlete******************************/

else if($_REQUEST['act'] == 'request_assessment') 
{
   //$data              =  file_get_contents("php://input");
   $userdata          =  json_decode(file_get_contents("php://input"));
   $email             =  $userdata->email;
   $name              =  $userdata->name;
   $request_type      =  $userdata->request_type;
   $video_link        =  $userdata->video_link;
   $req1              =  new emailService();
   $res1              =  $req1->send_email_athlete($email,$name,$request_type,$video_link,$userdata);
   $req               =  new UserPerformanceService();
   $res               =  $req->save_request_assessment($userdata);
        if($res)
        {
          $data = array('status' => 1, 'data'=> $res, 'msg'=>'Request Assessment send');
                  echo json_encode($data);
        }
        else
        {
            $data = array('status' => 0, 'data'=>$res, 'msg'=>'Request Assessment not send');
                    echo json_encode($data);
        }  

} // End of Statment




/***********************Request Assessment  by Athlete******************************/

else if($_REQUEST['act'] == 'view_request_assessment') 
{
   $data              =  file_get_contents("php://input");
   $userdata          =  json_decode(file_get_contents("php://input"));
   $athlete_id        =  $userdata->athlete_id ;
   $req               =  new UserPerformanceService();
   $res               =  $req->view_request_assessment($athlete_id);
     if($res)
     {
       $data = array('status' => 1, 'data'=> $res, 'msg'=>'view request Assessment');
            echo json_encode($data);
     }
     else
     {
       $data = array('status' => 0, 'data'=>$res, 'msg'=>'No Assessment Requested');
           echo json_encode($data);
     } 
}
   



/***********************class_listing******************************/

else if($_REQUEST['act'] == 'coach_class_listing') 
{
   $coach_id          = $_REQUEST['coach_id'];
   $class_id          = $_REQUEST['class_id'];
   $req               =  new UserPerformanceService();
   $res               =  $req->class_show($coach_id,$class_id);
     if($res)
     {
       $data = array('status' => 1, 'data'=> $res, 'msg'=>'class list ');
            echo json_encode($data);
     }
     else
     {
       $data = array('status' => 0, 'data'=>$res, 'msg'=>'No class');
           echo json_encode($data);
     } 
}




else if($_REQUEST['act'] == 'get_catagories_info')
{

$scenario_data = json_decode(file_get_contents(USER_ASSETS.'/uploads/json/assessment_scenario.json'));
//print_r($scenario_data);die;
$dob = $_REQUEST['dob'];
$sport = $_REQUEST['sport'];
$age = date_diff(date_create($dob), date_create('today'))->y;
$screnario ='';
foreach ($scenario_data as $key => $value) {
           if($key == $sport)
           {  //echo $key;die;
             foreach ($value as $ageGropup => $data) {
               if($age <= $ageGropup)
               {
                $screnario = $data;
                break;
               }
             }
           }
        }
if($screnario != '')
{
  $resp = array('data' =>$screnario ,'status' => '1' , 'msg'=> 'Success');
}
else
{
   $resp = array('data' =>'0' ,'status' => '0' , 'msg'=> 'Failure');
}
echo json_encode($resp);
}


else if($_REQUEST['act'] == 'submit_assessment_request')
{
  $data = json_decode(file_get_contents('php://input'));
  $obj = new UserPerformanceService();
  $resp = $obj->submit_assessment_request($data);
  if($resp == 1)
  {
    $resp = array('status' =>$resp ,'message'=>'Success');
  }
  else
  {
    $resp = array('status' =>$resp ,'message'=>'Failure');
  }
  echo json_encode($resp);
}

else if($_REQUEST['act'] == 'get_assessement_list')
{ 
  $sport = $_REQUEST['sport'];
  $obj = new UserPerformanceService();
  $user_var = $obj->get_assessement_list($sport);
  if($user_var != 0)
  {
    $resp = array('status' => '1','data'=>$user_var,'msg'=>'success' );
  }else
  {
    $resp = array('status' => '0','data'=>[],'msg'=>'failure' );
  }
echo json_encode($resp);
}



?>