<?php
class MydietPlanService
{

public function diet_plan($userdata,$userid,$usertype)
{
$data        = json_decode($userdata);
$start_date  = $data->start_date;
$end_date    = $data->end_date;
$name        = $data->name;
$status      = $data->status;

$date        =  date('Y-m-d');


$day         =  strtolower(date("l"));

//$value       = $data->diet_food->$day;

if($usertype=='M')
{
$query = mysql_query("INSERT INTO `gs_diet_plan`(`id`,`userid`,`userType`, `my_diet_plan`,`start_date`,`end_date`) VALUES ('0','$userid','$usertype','$userdata','$start_date', '$end_date') ");
return 1;
}
else
{
   $query = mysql_query("INSERT INTO `gs_diet_plan`(`id`,`userid`,`userType`, `my_diet_plan`,`start_date`,`end_date`,`plan_status`) VALUES ('0','$userid','$usertype','$userdata','$start_date', '$end_date','$status') ");
   if($query)
    {
       $id_diet = mysql_insert_id();

       if($start_date==$date) 
       {
        
      $value       = $data->diet_food->$day;
      $log_data    = array('diet_food'=>array($day=>$value),'start_date'=>$start_date,'end_date'=>$end_date,'name'=>$name);
      $log_data1 = json_encode($log_data);
        mysql_query("INSERT INTO `gs_diet_log`(`id`,`userid`,`userType`,`id_diet`,`my_diet_plan`,`assign_date`) VALUES('0','$userid','$usertype','$id_diet','$log_data1',CURDATE()) ");
        }
          
        return 1;
    } 
    else
    {    
        return 0;
    } 
  }

}










public function list_plan($userid)
{
  
 $query=mysql_query("SELECT `my_diet_plan`, `id`  FROM `gs_diet_plan` WHERE `userid`='$userid'");
  if(mysql_num_rows($query)>0)
       {
          while($row = mysql_fetch_assoc($query))
          {
            $row['my_diet_plan']  =  json_decode($row['my_diet_plan']);
            $my_diet_plan1        =  (array)$row['my_diet_plan'];
            $my_diet_plan1['id']  =  $row['id'];
            $data[]               =  $my_diet_plan1;
          }
          return $data;
          }
          else 
          {
          return 0;
          }
}






public function edit_plan($id,$my_diet_plan)
{

  $data        = json_decode($my_diet_plan);
  $status      = $data->status;
  $start_date  = $data->start_date;
  $end_date    = $data->end_date;

  $query  = mysql_query("UPDATE `gs_diet_plan` SET `my_diet_plan`='$my_diet_plan',`status`='$status',`start_date`='$start_date',`end_date`='$end_date' WHERE `id` ='$id' ");
  $num = mysql_affected_rows();
  if($num)
  {
     
 if($status==1)
  {
    $req    =  new ConfigService();
    $res =   $req->log_diet();
  }
   return 1;

  }
  else 
  {
     return 0;
  }

}



public function list_ashin_log($userid)
{
  $query  = mysql_query("SELECT *FROM `gs_diet_log` WHERE userid = '$userid' ORDER BY `assign_date` DESC ");
  $num    = mysql_num_rows($query);
  $date = date('Y-m-d');
  if($num)
  {
    while ($row = mysql_fetch_assoc($query))
    {
      $row['my_diet_plan']  =  json_decode($row['my_diet_plan']);
       $data[] =$row;
    }

     return $data;
  }
  else
  {
    return 0;
  }
}




public function edit_log($id,$my_diet_log)
{
  $query  = mysql_query("SELECT *FROM `gs_diet_log` WHERE `id` = '$id' ");
  $row    = mysql_fetch_assoc($query);
  $sa     = json_decode($row['my_diet_plan']);
  $sa->diet_food=json_decode(json_decode($my_diet_log));
  $row['my_diet_plan'] = json_encode($sa);
  $row1 = $row['my_diet_plan'];
  $query  = mysql_query("UPDATE `gs_diet_log` SET `my_diet_plan`='$row1' WHERE `id` ='$id' ");
  $num = mysql_affected_rows();
  if($num)
  {
      return 1;
  }
  else 
  {
     return 0;
  }

}





public function studnet_list($coach_id,$diet_id)
{

$query = mysql_query("SELECT gs_class_data.*,`user`.`user_image` FROM gs_class_data  INNER JOIN  user ON `gs_class_data`.student_id=`user`.userid    WHERE gs_class_data.`coach_id` = $coach_id AND gs_class_data.`status`='1' AND `student_id`  NOT IN (SELECT `athlete_id` FROM `gs_assign_diet_plan` WHERE `diet_id`='$diet_id' )" );
$num   =  mysql_num_rows($query);
if($num)
{

  while ($row = mysql_fetch_assoc($query)){
    $data[]    = $row;
}
return $data;  
}

else
{
  return 0;
}


}





public function assign_plan($data,$coach_name,$diet_id,$athelete_id)
{

$query  =  mysql_query("INSERT INTO `gs_assign_diet_plan`(`assign_id`,`coach_id`,`athlete_id`,`diet_id`,`assign_date`,`assign_status`) VALUES $data ");
if($query)
{

$query1      =  mysql_query("SELECT *FROM gs_diet_plan WHERE id = '$diet_id' ") ;
 $row        =  mysql_fetch_assoc($query1);
$message_data  = $row['my_diet_plan'];

$this->find_asign_id($athelete_id,$message_data,$coach_name,$diet_id);

  return 1;

}
else
{
  return 0;
}

}




public function find_asign_id($athelete_id,$message_data,$coach_name,$diet_id)
{
  $query  = mysql_query("SELECT *FROM gs_assign_diet_plan WHERE `athlete_id` IN($athelete_id)  ");
  $query1 = mysql_query("SELECT *FROM user WHERE `userid` IN($athelete_id)  ");
  while ($row = mysql_fetch_assoc($query))
  {
        $asign_id_list[]  = $row['assign_id'];
        $row1             = mysql_fetch_assoc($query1);
        $device_id_list[] = $row1['device_id'];

  }
 for($i=0; $i <count($asign_id_list) ; $i++) 
 { 
 $message       = array('message'=>array('my_diet_plan'=>json_decode($message_data)),'title'=>$coach_name.' has assigned New diet plan','indicator'=>9,'assign_id'=>$asign_id_list[$i],'diet_id'=>$diet_id);

$json_data     =  json_encode($message);

$userdata      = new userdataservice();

$notification  = $userdata->sendLitePushNotificationToGCM($device_id_list[$i],$json_data);
}

}





public function edit_assign($assign_id,$assign_status,$diet_id,$userid)
{
if($assign_status=='1') 
{
$row            =  mysql_query("SELECT *FROM gs_diet_plan  WHERE id = '$diet_id' ");
$data           =  mysql_fetch_assoc($row);
$my_diet_plan   =  $data['my_diet_plan'] ;
$start_date     =  $data['start_date'];
$end_date       =  $data['end_date'];
$decative       = mysql_query("UPDATE gs_diet_plan set `plan_status` ='0' WHERE userid= '$userid' ");
$active         = mysql_query("INSERT INTO gs_diet_plan(`id`,`userid`,`my_diet_plan`,`start_date`,`end_date`,`plan_status`) VALUES('0','$userid','$my_diet_plan','$start_date','$end_date','$assign_status')");
  $query1 = mysql_query("UPDATE gs_assign_diet_plan set `assign_status` ='$assign_status' WHERE assign_id= '$assign_id' "); 
  $num  = mysql_affected_rows();
 }
 else
 {

  $query1 = mysql_query("UPDATE gs_assign_diet_plan set `assign_status` ='$assign_status' WHERE assign_id= '$assign_id' "); 
  $num  = mysql_affected_rows();
 }
  if ($num)
  {
    return 1;
  }
  else
  {
    return 0;
  }
}



} // End of Class

?>