<?php
class ratingservice
{
	
public 	function  createrating($data)
{
		 $query = mysql_query("INSERT INTO `gs_rating`(`id`,`userid`,`entity_type`,`entity_id`,`q1`,`q2`,`q3`,`q4`,`q5`,`total_rating`,`entry_date`) VALUES('$data->id','$data->userid','$data->entity_type','$data->entity_id','$data->q1','$data->q2','$data->q3','$data->q4','$data->q5','$data->total_rating',CURDATE()) ON DUPLICATE KEY UPDATE `q1`='$data->q1',`q2`='$data->q2',`q3`='$data->q3',`q4`='$data->q4',`q5`='$data->q5',`total_rating`='$data->total_rating',`date_updated`=CURDATE()");
if($query)
{
	return 1;
}
else
{
	return 0;
}
}

public function view_rate($userid,$entity_id,$entity_type)
{
   $query = mysql_query("SELECT * FROM `gs_rating` WHERE `userid`='$userid' AND `entity_id` ='$entity_id' AND `entity_type`='$entity_type'");
  $row = mysql_num_rows($query);
   if($row)
   {
     while($data = mysql_fetch_assoc($query))
      {
      $result[] = $data;
      }
       
        return $result;
   }

}

public function total_rate($entity_id,$entity_type)
{
  $query = mysql_query("SELECT `total_rating` FROM `gs_rating` WHERE  `entity_id` ='$entity_id' AND `entity_type`='$entity_type'");
  $row = mysql_num_rows($query);
   if($row)
   {
     while($data = mysql_fetch_row($query))
      {
      $result[] = $data;
      }
       
        return $result;
   }
}

public function userdata($userid)
{ 
	 $query = mysql_query("SELECT `name`,`user_image` FROM `user` WHERE `userid`= '$userid'");
    $row = mysql_num_rows($query);
   if($row)
   {
     while($data = mysql_fetch_row($query))
      {
      $result[] = $data;
      }
       
        return $result;
   }
}






}
?>