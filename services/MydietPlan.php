<?php
class MydietPlan
{

public function diet_plan($userdata,$userid)
{
$data        = json_decode($userdata);
$start_date  = $data->start_date;
$end_date    = $data->end_date;
   $query = mysql_query("INSERT INTO `gs_diet_plan`(`id`,`userid`, `my_diet_plan`,`start_date`,`end_date`) VALUES ('0',$userid,'$userdata','$start_date', '$end_date') ");
   if($query)
    {
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


} // End of Class

