<?php
include('config1.php');
include('services/userperformance.php');

if($_REQUEST['act'] == 'get_modules')	
{  //print_r($_POST);
   $data 			    =  file_get_contents("php://input");
   $userdata 	    =  json_decode(file_get_contents("php://input"));
   $sport         =  $userdata->sport;
   $gender        =  $userdata->gender;
   $dob		        =  $userdata->dob;
   $coachid       =  $userdata->coachid;
   $athleteid     =  $userdata->athleteid;
   $req           =  new UserPerformanceService();
   $id            =  $req->save($coachid,$athleteid);
   $age           =  $req->ageGropup($dob,$gender);
   $res           =  $req->userPerformance($id,$age,$sport,$gender);
        if($res)
        {
          $data = array('status' => 1, 'data'=> $res  , 'msg'=>'Success');
                  echo json_encode($data);
        }
        else
        {
            $data = array('status' => 1, 'data'=>$res, 'msg'=>'Failure');
                    echo json_encode($data);
        }  

} // End of Statment


else if($_REQUEST['act'] == 'save_performance') 
{
   $data          =  file_get_contents("php://input");
   $userdata      =  json_decode(file_get_contents("php://input"));
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
   if ($assessment==0)
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






?>