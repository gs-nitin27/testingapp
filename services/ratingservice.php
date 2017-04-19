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




}
?>