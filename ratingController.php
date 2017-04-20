<?php
include('config1.php');
include('services/ratingservice.php');


if($_REQUEST['act'] == "rate_coach")
{

	 $ratedata        =  json_decode(file_get_contents("php://input"));
	 $req = new ratingservice();

	 $res = $req->createrating($ratedata);

	 if($res)
	 {
        $result =  array('status' =>"1" ,'data'=>"",'msg' =>'rating has been created');
	    echo json_encode($result); 
	 }
	 else
	 {
	 	$result =  array('status' =>"0" ,'data' =>"",'msg'=>'rating has not been created');
        echo json_encode($result);
	 }
}

else if($_REQUEST['act'] == "view_rate")
{
    $userid =   $_REQUEST['userid'];
    $entity_id =  $_REQUEST['entity_id'];
    $entity_type = $_REQUEST['entity_type'];


   $req = new ratingservice();
   $user = $req->userdata($entity_id);
   $res1 = $req->total_rate($entity_id,$entity_type);
   $res = $req->view_rate($userid,$entity_id,$entity_type);
  
  
   $finalarray['name'] = $user[0][0];
   $finalarray['image'] = $user[0][1];

   $avg=0;
   if($res1)
   {
   for ($i=0; $i <sizeof($res1); $i++) 
   { 
        $avg = $avg +$res1[$i][0];
   }
  $total_avg =  $avg/sizeof($res1);
  $finalarray['total_avg'] = $total_avg;
  $finalarray['total_users'] = sizeof($res1);
  }
  else
  {
  $finalarray['total_avg'] = 0;
  $finalarray['total_users'] = 0;
  }

 if($res)
  {
 $finalarray['id'] = $res[0]['id'];
 $finalarray['userid'] = $res[0]['userid'];
 $finalarray['entity_type'] =$res[0]['entity_type'];
 $finalarray['entity_id']  = $res[0]['entity_id'];
 $finalarray['q1'] = $res[0]['q1'];
 $finalarray['q2'] = $res[0]['q2'];
 $finalarray['q3'] = $res[0]['q3'];
 $finalarray['q4'] = $res[0]['q4'];
 $finalarray['q5'] = $res[0]['q5'];
 $finalarray['total_rating']  =$res[0]['total_rating'];
 
 }
 else
 {
 $finalarray['id'] = "0";
 $finalarray['userid'] = "0";
 $finalarray['entity_type'] ="0";
 $finalarray['entity_id']  = "0";
 $finalarray['q1'] = "0";
 $finalarray['q2'] = "0";
 $finalarray['q3'] = "0";
 $finalarray['q4'] = "0";
 $finalarray['q5'] = "0";
 $finalarray['total_rating']  =0;
 


 }

if($user)
{

   $result =  array('status' =>"1" ,'data' =>$finalarray ,'msg' =>"rating");
   echo json_encode($result);
}
else
{
	$result =  array('status' =>"0" ,'data' =>$res[0] ,'msg' =>"rating not found");
   echo json_encode($result);
}
}
?>