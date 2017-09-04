<?php
include('config1.php');
include('services/MydietPlanService.php');
include('services/userdataservice.php');
include('cron/ConfigService.php');


/*****************************Create My Diet Plan**************************/

if($_REQUEST['act'] == 'my_diet_plan')
{
  $userdata       =   (file_get_contents("php://input"));
  $userid         =   $_REQUEST['userid'];
  $userid         =   $_REQUEST['usertype'];
  $req            =   new MydietPlanService();
  $res            =   $req->diet_plan($userdata,$userid,$usertype);
  if($res)
        {
          $data = array('status' => '1', 'data'=> $res, 'msg'=>'Create diet plan');
                  echo json_encode($data);
        }
        else
        {
            $data = array('status' => '0', 'data'=>$res, 'msg'=>'not created');
                  echo json_encode($data);
        }   

}




/***********************Listing Diet Plan********************************/



else if($_REQUEST['act'] == 'list_diet_plan')
{
 $userid         =   $_REQUEST['userid'];
 $req            =   new MydietPlanService();
 $res            =   $req->list_plan($userid);
  if($res)
        {
          $data = array('status' => '1', 'data'=> $res, 'msg'=>'List diet plan');
                  echo json_encode($data);
        }
        else
        {
            $data = array('status' => '0', 'data'=>[], 'msg'=>'not list');
                  echo json_encode($data);
        }   

}

/***********************Listing Diet Plan********************************/



else if($_REQUEST['act'] == 'edit_diet_plan')
{
  $my_diet_plan   =   (file_get_contents("php://input"));
  $id             =   $_REQUEST['id'];
  $req            =   new MydietPlanService();
  $res            =   $req->edit_plan($id,$my_diet_plan);
        if($res)
        {
            $data = array('status' => '1', 'data'=> "$res", 'msg'=>'Updated diet plan');
                        echo json_encode($data);
        }
        else
        {
            $data = array('status' => '0', 'data'=>"0", 'msg'=>'not updated diet plan');
                  echo json_encode($data);
        }   

}


else if($_REQUEST['act']=='find_diet_log') 
{
  $userid            =   $_REQUEST['userid'];
  $req               =   new MydietPlanService();
  $res               =   $req->list_ashin_log($userid); 

  if($res)
  {
    $data = array('status' => '1', 'data'=>$res, 'msg'=>'ashin diet plan log');
                  echo json_encode($data);
  }
  else
  {
    $data = array('status' => '0', 'data'=>"0", 'msg'=>'not ashin diet plan log');
                  echo json_encode($data);
  }

}






else if($_REQUEST['act'] == 'assign_diet_plan')
{

  $diet_plan             =   (file_get_contents("php://input"));
  $data                  =   json_decode($diet_plan);
  $coach_id              =   $data->coach_id;
  $athelete_id           =   $data->athelete_id;
  $diet_id               =   $data->diet_id;
  $coach_name            =   $data->coach_name;
  $list_id               =   explode(',', $athelete_id);
foreach($list_id as $value)
{
$num[]  = "('0','$coach_id','$value','$diet_id',CURDATE())";
}
  $data                  =   implode(',', $num); 
  $req                   =   new MydietPlanService();
  $res                   =   $req->assign_plan($data,$coach_name,$diet_id,$list_id);
        if($res)
        {
            $data = array('status' => '1', 'data'=> "$res", 'msg'=>'assign diet plan');
                       echo json_encode($data);
        }
        else
        {
            $data = array('status' => '0', 'data'=>"0", 'msg'=>'not assign diet plan');
                  echo json_encode($data);
        }   

}







?>