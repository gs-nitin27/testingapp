<?php
include('../config1.php');
include('../services/attendanceService.php');
include('../services/userdataservice.php');
include('../services/cron_service/visitor_cron_service.php');
include('../services/emailService.php');
//echo "ddsdsdsd";
$obj = new visitor_cron_service();
$obj_var = $obj->get_subscriber_data(); 
$emailObj = new emailService();

if($obj_var != 0)
{  $filterArray = array_filter($obj_var);

if(!count($filterArray) == 0){
//    return false;
   foreach ($obj_var as $key => $value) {
   	   if($value != null)
   	   {
   	   	foreach ($value as $key1 => $value1) {
   	   	 //  echo $value1['unique_code'];die;

   	   		$resp  = $emailObj->create_subscribe_body($value1,$key);
   	   	    if($resp != 0)
   	   	    {   //echo $resp.'-------'.$value1['unique_code'];die;
   	   	    	$update = $obj->update_sent_item($resp,$value1['unique_code'],$key);
   	   	    	if($update == '1')
   	   	    	{
   	   	    		$response = array('status' =>'1' , 'message'=>'Success','data'=>$value1['unique_code']);
   	   	    	}else
   	   	    	{
   	   	    		$response = array('status' =>'0' , 'message'=>'Failure','data'=>$value1['unique_code']);
   	   	    	}
   	   	    echo json_encode($response);
   	   	    }
    	   	}
   	   }
   }

	// $job = $obj_var[1];
	// if($job != null)
	// {
	// 	echo "dsdsdsds";
	// }else
	// {
	// 	echo "oh! no!";
	// }
 //   $event = $obj_var[2];
	// if($event != null)
	// {
	// 	echo "dsdsdsds";
	// }else
	// {
	// 	echo "oh! no!";
	// }
}else{
	$resp = array('status' =>'0' ,'msg'=>'No records Found' );
	echo json_encode($resp);
}
}

 ?>