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
   $res1 = $req->total_rate($entity_id,$entity_type);
   $res = $req->view_rate($userid,$entity_id,$entity_type);
  
   // print_r($res1);die;

   $avg=0;
   if($res1){
   for ($i=0; $i <sizeof($res1); $i++) 
   { 
        $avg = $avg +$res1[$i]['total_rating'];
   }
  $total_avg =  $avg/sizeof($res1);
  $res[0]['total_avg'] = $total_avg;
  $res[0]['total_users'] = sizeof($res1);
  $res[0]['name'] = $res1[0]['name'];
  $res[0]['image'] = $res1[0]['user_image'];

  }
   if($res)
   {
   	  $result =  array('status' =>"1" ,'data' =>$res[0] ,'msg' =>"rating");
   	  echo json_encode($result);
   }
   else
   {
   	$result =  array('status' =>"0" ,'data'=>$res,'msg'=>"Not Find any rating");
   	echo json_encode($result);
   }

}

?>