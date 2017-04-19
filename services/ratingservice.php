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

public function view_rate($data)
{
   $query = mysql_query("SELECT * FROM `gs_rating` WHERE `userid`='$data->userid' AND `entity_id` ='$data->entity_id'");
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

public function total_rate($data)
{
   $query = mysql_query("SELECT `total_rating` FROM `gs_rating` WHERE  `entity_id` ='$data->entity_id'");
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