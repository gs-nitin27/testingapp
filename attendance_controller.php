<?php
include('config1.php');
include('services/attendanceService.php');
include('services/userdataservice.php');




error_reporting(E_ERROR | E_PARSE);

// if($_REQUEST['act'] == "student_list1")
// {
// 	$classid  = $_REQUEST['classid'];
// 	$date     = $_REQUEST['date'];
//     $req 	  = new attendanceService();
// 	$res 	  = $req->student_listing($classid);
// 	if($res != 0)
// 	{
// 	$data = array('status' => '1','data'=>$res ,'msg'=>'student listing');
// 	}
// 	else
// 	{
// 	$data = array('status' => '0','data'=>[] ,'msg'=>'no student in listing');
// 	}
// 		echo json_encode($data);
// }



if($_REQUEST['act'] == "student_list")
{
  $dateclause = '';
  if(isset($_REQUEST['date']))
  {
  $date       = $_REQUEST['date'];  
  $dateclause = "AND `date_created` = '$date'";
  }
  $class_id = $_REQUEST['class_id'];
  $where = "WHERE `class_id` = '$class_id'".$dateclause;
  $obj = new attendanceService();
  $res = $obj->get_attendence_data($where);
  if($res != '0')
  { 
  	$data = array('status' => '1','data'=>$res ,'msg'=>'attendance view');
    echo json_encode($data);
  }
  else
  {
    $obj1 = new attendanceService();
    $resp = $obj1->student_listing($class_id);
   $data = array('status' => '2','data'=>$resp ,'msg'=>'student listing');
    echo json_encode($data );
  } 
}




else if ($_REQUEST['act'] == 'athlete_attendance')
{



$data       =    file_get_contents("php://input");




//$data          	 = 		$_POST['data'];
$classid         = 		$_REQUEST['classid'];
$req       		 =   new attendanceService();
$req       		 =   $req->athlete_attendance($data,$classid );
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