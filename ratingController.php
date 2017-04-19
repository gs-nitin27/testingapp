<?php
include('config1.php');
include('services/ratingservice.php');


if($_REQUEST['act'] = "rate_coach")
{

	 $ratedata        =  json_decode(file_get_contents("php://input"));
	 $req = new ratingservice();

	 $res = $req->createrating($ratedata);

	 if($res)
	 {
        $result =  array('status' =>1 ,'data'=>$res,'msg' =>'rating has been created');
	    echo json_encode($result); 
	 }
	 else
	 {
	 	$result =  array('status' =>0 ,'data' =>[],'msg'=>'rating has not been created');
        echo json_encode($result);
	 }
}

?>