<?php
include('config1.php');
include('services/userperformance.php');

if($_REQUEST['act'] == 'get_modules')	
{
   $data 			    =  file_get_contents("php://input");
   $userdata 	    =  json_decode(file_get_contents("php://input"));
  // print_r($userdata);die();
  // $userid      	=  $userdata->userid;
  // $classid 		  =  $userdata->classid;
   $sport         =  $userdata->sport;
   $gender        =  $userdata->gender;
   $dob		        =  $userdata->dob;
   $req           =  new UserPerformanceService();
   $res           =  $req->user_performance($dob,$sport);
        if($res)
        {
          $data = array('status' => 1, 'data'=> $res, 'msg'=>'Success');
                  echo json_encode($data);
        }
        else
        {
            $data = array('status' => 1, 'data'=>$res, 'msg'=>'Failor');
                  echo json_encode($data);
        }          
} // End of Statment




?>