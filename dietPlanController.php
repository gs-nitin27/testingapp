<?php
include('config1.php');
include('services/MydietPlanService.php');
include('services/userdataservice.php');
include('cron/configservice.php');


/*****************************Create My Diet Plan**************************/

if($_REQUEST['act'] == 'my_diet_plan')
{
  $userdata       =   (file_get_contents("php://input"));
  $userid         =   $_REQUEST['userid'];
  $usertype       =   $_REQUEST['usertype'];
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
 $usertype       =   $_REQUEST['usertype'];
 $req            =   new MydietPlanService();
 $res            =   $req->list_plan($userid,$usertype);
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




else if($_REQUEST['act'] == 'studnet_plan_list')
{
$coach_id         =   $_REQUEST['coach_id'];
$diet_id          =   $_REQUEST['diet_id'];
$req              =   new MydietPlanService();
$res              =   $req->studnet_list($coach_id,$diet_id);
        if($res)
        {
            $data = array('status' => '1', 'data'=> $res, 'msg'=>'studnet list');
                       echo json_encode($data);
        }
        else
        {
            $data = array('status' => '0', 'data'=>[], 'msg'=>'studnet is not in list');
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
$num[]  = "('0','$coach_id','$value','$diet_id',CURDATE(),'0')";
}
  $data                  =   implode(',', $num); 
  $req                   =   new MydietPlanService();
  $res                   =   $req->assign_plan($data,$coach_name,$diet_id,$athelete_id);
        if($res)
        {
            $data = array('status' => '1', 'data'=>[], 'msg'=>'assign diet plan');
                       echo json_encode($data);
        }
        else
        {
            $data = array('status' => '0', 'data'=>[], 'msg'=>'not assign diet plan');
                  echo json_encode($data);
        }   

}




else if($_REQUEST['act'] == 'edit_assign_plan')
{

  $diet_plan             =   (file_get_contents("php://input"));
  $data                  =   json_decode($diet_plan);
  $assign_id             =   $data->assign_id;
  $assign_status         =   $data->assign_status;
  $diet_id               =   $data->diet_id;
  $userid                =   $data->userid;
  $req                   =   new MydietPlanService();
  $res                   =   $req->edit_assign($assign_id,$assign_status,$diet_id,$userid);
if($res)
        {
            $data = array('status' => '1', 'data'=> "1", 'msg'=>'edit assign diet plan');
                       echo json_encode($data);
        }
        else
        {
            $data = array('status' => '0', 'data'=>"0", 'msg'=>'not edit assign diet plan');
                  echo json_encode($data);
        }

}



else if($_REQUEST['act'] == 'active_diet_plan')
{

  $diet_plan             =   (file_get_contents("php://input"));
  $data                  =   json_decode($diet_plan);
  $athelete_id           =   $data->athelete_id;
  $diet_id               =   $data->diet_id;
  $status                =   $data->status;
  $req                   =   new MydietPlanService();
  $res                   =   $req->active_plan($athelete_id,$diet_id,$status);
        if($res)
        {
            $data = array('status' => '1', 'data'=> "1", 'msg'=>'active diet plan');
                       echo json_encode($data);
        }
        else
        {
            $data = array('status' => '0', 'data'=>"0", 'msg'=>'not active diet plan');
                  echo json_encode($data);
        }   

}





else if($_REQUEST['act'] == 'show_diet_plan')
{

  $athlete_id            =   $_REQUEST['athlete_id'];
  $req                   =   new MydietPlanService();
  $res                   =   $req->show_plan($athlete_id);
        if($res)
        {
            $data = array('status' => '1', 'data'=> $res, 'msg'=>'show diet plan');
                       echo json_encode($data);
        }
        else
        {
            $data = array('status' => '0', 'data'=>"0", 'msg'=>'show diet plan');
                  echo json_encode($data);
        }   

}

?>