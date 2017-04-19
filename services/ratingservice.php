<?php
class ratingservice
{
	
public 	function  createrating($data)
{
		 $query = mysql_query("INSERT INTO `gs_rating`(`userid`,`entity_type`,`entity_id`,`q1`,`q2`,`q3`,`q4`,`q5`,`total_rating`,`entry_date`) VALUES('$data->userid','$data->entity_type','$data->entity_id','$data->q1','$data->q2','$data->q3','$data->q4','$data->q5','$data->total_rating',CURDATE())");
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
  $query = mysql_query("SELECT `gs_rating`.`total_rating`, `user`.`name`,`user`.`user_image` FROM `gs_rating` INNER JOIN user ON `gs_rating`.`entity_id`=`user`.`userid` WHERE `user`.`userid`='$entity_id' AND `entity_type`='$entity_type'");
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




}
?>