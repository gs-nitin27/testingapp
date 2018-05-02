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
{
   foreach ($obj_var as $key => $value) {
   	   if($value != null)
   	   {
   	   	foreach ($value as $key1 => $value1) {
   	   		$resp  = $emailObj->create_subscribe_body($value1,$key);
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
}


 ?>