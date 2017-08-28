<?php
class MydietPlanService
{

public function diet_plan($userdata,$userid)
{
$data        = json_decode($userdata);
$start_date  = $data->start_date;
$end_date    = $data->end_date;
$name        = $data->name;
$date        =  date('Y-m-d');
$day         =  strtolower(date("l"));
//$value       = $data->diet_food->$day;

   $query = mysql_query("INSERT INTO `gs_diet_plan`(`id`,`userid`, `my_diet_plan`,`start_date`,`end_date`) VALUES ('0',$userid,'$userdata','$start_date', '$end_date') ");
   if($query)
    {
       $id_diet = mysql_insert_id();
       if($start_date==$date) 
       {
      $value       = $data->diet_food->$day;
      $log_data    = array('diet_food'=>array($day=>$value),'start_date'=>$start_date,'end_date'=>$end_date,'name'=>$name);
      $log_data1 = json_encode($log_data);
        mysql_query("INSERT INTO `gs_diet_log`(`id`,`userid`,`id_diet`,`my_diet_plan`,`assign_date`) VALUES('0','$userid','$id_diet','$log_data1',CURDATE()) ");
        }
          
        return 1;
    } 
    else
    {    
        return 0;
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
  $query  = mysql_query("UPDATE `gs_diet_plan` SET `my_diet_plan`='$my_diet_plan' WHERE `id` ='$id' ");
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



public function list_ashin_log($userid)
{
  $query  = mysql_query("SELECT *FROM `gs_diet_log` WHERE userid = $userid");
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
  $query  = mysql_query("UPDATE `gs_diet_log` SET `my_diet_plan`='$my_diet_log' WHERE `id` ='$id' ");
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




} // End of Class

?>