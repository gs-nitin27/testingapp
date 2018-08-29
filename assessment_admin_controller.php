<?php
include('config1.php');
include('services/userperformance.php');
include('services/emailService.php');
include('services/assessment_admin_service.php');

if($_REQUEST['act'] == 'add_assessment'){
	$data = json_decode(file_get_contents(('php://input')));
	$obj  = new Assessment_admin_service();
	$objVar = $obj->add_assessment($data); 
	if($objVar != 0)
	{
		$resp = array('status' => '1','msg'=>'Success');
	}
	else
	{
		$resp = array('status' => '0','msg'=>'Failure');
	} 
	echo json_encode($resp);
}
else if($_REQUEST['act'] == 'assessment_list'){
$institute = $_REQUEST['institute_id'];
$obj = new Assessment_admin_service();
$objVar = $obj->get_assessment_list($institute);
if($objVar != 0)
{
	$resp = array('status' => '1','data'=>$objVar,'msg'=>'Success' );
}else
{
	$resp = array('status' => '0','data'=>[],'msg'=>'failure' );
}
echo json_encode($resp);
}


?>