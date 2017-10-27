<?php
include('config1.php');
include('services/attendanceService.php');
include('services/userdataservice.php');

error_reporting(E_ERROR | E_PARSE);


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
  if($res == '0')
  { $obj1 = new attendanceService();
    $resp = $obj1->student_listing($class_id);
    $data = array('status' => '1','data'=>$resp ,'msg'=>'student listing');
    echo json_encode($data );
  }
  else
  { 
    $data = array('status' => '2','data'=>$res ,'msg'=>'attendance view');
    echo json_encode($data);
  } 
}




else if ($_REQUEST['act'] == 'athlete_attendance')
{
$classid       =    $_REQUEST['classid'];
$date          =    $_REQUEST['date'];
$data      		 =    file_get_contents("php://input");
$req       		 =   new attendanceService();
$req       		 =   $req->athlete_attendance($data,$classid,$date);
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







else if ($_REQUEST['act'] == 'check_attendance')
{
$data          =   json_decode(file_get_contents("php://input"));
$req           =   new attendanceService();
$res           =   $req->check_attendance($data);
if($res != 0)
{
  $data = array('status' => '1','data'=>$res ,'msg'=>'check attendance list');
}
else
{
  $data = array('status' => '0','data'=>[] ,'msg'=>'no data');
}
  echo json_encode($data);

}




else if ($_REQUEST['act'] == 'cancel_class')
{
$data          =   json_decode(file_get_contents("php://input"));
$req           =   new attendanceService();
$res           =   $req->cancel_class($data);
if($res != 0)
{
  $data = array('status' => '1','data'=>$res ,'msg'=>'class is cancel');
}
else
{
  $data = array('status' => '0','data'=>[] ,'msg'=>'class is not cancel');
}
  echo json_encode($data);

}









?>