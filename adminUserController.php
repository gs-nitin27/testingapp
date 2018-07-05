<?php
include('config1.php');
include('services/adminUserService.php');

if($_REQUEST['act'] == 'admin_login')
{
	$data = json_decode(file_get_contents('php://input'));
	$obj = new AdminUserService();
	$pwd = mysql_real_escape_string(md5($data->password));
	$obj_var = $obj->admin_login($data->email,$pwd);
	if($obj_var != 0)
	{
		$resp = array('status' =>'1' ,'data'=>$obj_var,'message'=>'success');
	}
	else
	{
	   $resp = array('status' =>'0' ,'data'=>[],'message'=>'failure');	
	}
	echo json_encode($resp);
}

?>