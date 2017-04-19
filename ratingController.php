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
   
   $req = new ratingservice();
   $res1 = $req->total_rate($entity_id);
   $res = $req->view_rate($userid,$entity_id);
   $avg=0;
   for ($i=0; $i <sizeof($res1); $i++) 
   { 
        $avg = $avg +$res1[$i][0];
   }
  $total_avg =  $avg/sizeof($res1);
  $res[0]['total_avg'] = $total_avg;
  $res[0]['total_users'] = sizeof($res1);

   if($res)
   {
   	  $result =  array('status' =>1 ,'data' =>$res[0] ,'msg' =>"rating");
   	  echo json_encode($result);
   }
   else
   {
   	$result =  array('status' =>0 ,'data'=>$res,'msg'=>"Not Find any rating");
   	echo json_encode($result);
   }

}

?>