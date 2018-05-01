<?php
include('../config1.php');
include('../services/attendanceService.php');
include('../services/userdataservice.php');
include('../services/cron_service/visitor_cron_service.php');
include('../services/emailService.php');
//echo "ddsdsdsd";
$obj = new visitor_cron_service();
$obj_var = $obj->get_subscriber_data(); 
//echo json_encode($obj_var);die;
$emailObj = new emailService();

if($obj_var != 0)
{
	foreach ($obj_var as $key => $value) {
		if($key != null)
		{
        $email = $emailObj->create_subscribe_body($value,$key);
		}
	}
}


 ?>