<?php
include('config1.php');
include('services/attendanceService.php');
include('services/userdataservice.php');
error_reporting(E_ERROR | E_PARSE);

if($_REQUEST['act'] == "student_list")
{
	$classid  = $_REQUEST['classid'];
    $req 	  = new attendanceService();
	$res 	  = $req->student_listing($classid);
	if($res != 0)
	{
	$data = array('status' => '1','data'=>$res ,'msg'=>'student listing');
	}
	else
	{
	$data = array('status' => '0','data'=>[] ,'msg'=>'no student in listing');
	}
		echo json_encode($data);
}








else if ($_REQUEST['act'] == 'athlete_attendance')
{



//$data       =    json_decode(file_get_contents("php://input"));


$data        = 		$_POST['data'];

$classid        = 		$_REQUEST['classid'];

//echo $classid;

//print_r($data); die();


//print_r($data);

//print_r($data);

$req        =   new attendanceService();
$req        =   $req->athlete_attendance($data,$classid );
if($req != 0)
{
  $data = array('status' => '1','data'=>'1' ,'msg'=>'Success');
}
else
{
  $data = array('status' => '0','data'=>'0' ,'msg'=>'Failure');
}
  echo json_encode($data);

}







?>