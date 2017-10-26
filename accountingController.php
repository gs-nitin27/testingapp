<?php
include('config1.php');
include('services/accountingService.php');
include('services/connect_userservice.php');


if($_REQUEST['act'] == 'classlist')
{
   $userid = $_REQUEST['userid'];
   $req = new accountingServices();
   $res = $req->classlist($userid);
   if($res)
   {
   	echo json_encode($res);
   }
   else 
   {
   	echo json_encode($res);
   }
}
else if($_REQUEST['act'] == 'viewClass')
{
  $classid = $_REQUEST['classid'];
  $req = new accountingServices();
  $res = $req->viewClass($classid);
  echo json_encode($res);
}

else if($_REQUEST['act'] == "getClassFeeList")
{
  $classid = $_REQUEST['classid'];
  $student_id = $_REQUEST['student_id'];
  $req = new accountingServices();
  $res = $req->getClassFeeList($classid,$student_id);
   echo json_encode($res);
}

else if($_REQUEST['act'] == "ViewClassData")
{
   $classid = $_REQUEST['classid'];
   $student_id  = $_REQUEST['student_id'];
   $req = new accountingServices();
   $res = $req->ViewClassData($classid,$student_id);
   echo json_encode($res);

}
else if($_REQUEST['act'] == "getStudent_due")
{
    $coach_id = $_REQUEST['coach_id'];
    $obj1 = new connect_userservice();
    $get_due = $obj1->getAllDues($coach_id);
    if($get_due != 0)
    {
     $resp =  array('status' => 1,'data'=>$get_due );
    }else
    {
      $resp = array('status'=> 0, 'data'=>[]);
    }
    echo json_encode($resp);
}

?>