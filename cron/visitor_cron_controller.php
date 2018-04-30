<?php
include('../config1.php');
include('../services/attendanceService.php');
include('../services/userdataservice.php');
include('../services/cron_service/visitor_cron_service.php');

$obj = new visitor_cron_service();
$obj_var = $obj->get_subscriber_data(); 
echo json_encode($obj_var);


 ?>