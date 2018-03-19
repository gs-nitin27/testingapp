<?php
class tournament_service
{
 public function tournament_participants_list($tournament_id)
 {
    $query =mysql_query("SELECT * FROM `user` WHERE `userid` IN (SELECT `userid` FROM `user_tournaments` WHERE `usertournament` = $tournament_id)");
			if(mysql_num_rows($query)>0)
			{
				while ($row = mysql_fetch_assoc($query)) 
				{
					$date_1 		= new DateTime($row['dob']);
	                $date_2 		= new DateTime(date( 'd-m-Y' ));
	                $difference 	= $date_2->diff($date_1);
	                $year			= (string)$difference->y;
	                $row['age']		= $year;
	                $data[]  		= $row;
				}
			return $data;
			}
			else
			return 0;
 }
public function get_tournament_sports()
{
	$query = mysql_query("SELECT * FROM `gs_sports` WHERE `status_filter` = '1'");
	if(mysql_num_rows($query)>0)
	{
		  while ($row = mysql_fetch_assoc($query)) {
		    	    $category = json_decode($row['events_category']);
		    	    $category = $category->category;
		    	    $row['events_category'] =$category;
		    	    $rows[] = $row;
	    	}
		  return $rows;
	}
	else
	{
		return 0;
	}
}

public function apply_tournament($applydata)
{     
$query_data = implode(',', $applydata);
$fields = "INSERT INTO `gs_tournament_application`(`id`, `applicant_id`, `tournament_id`, `date_applied`, `fee_amount`, `application_data`, `organiser_id`, `category_code`) VALUES".$query_data;
$query = mysql_query($fields);
if($query)
	{   
		return 1;
	}
else
	{
		return 0;
	}
}

public function get_participant_list($where)
{   
	$query = mysql_query("SELECT a.`id`, a.`applicant_id`, a.`tournament_id`, a.`date_applied`, a.`fee_amount`, `organiser_id`, a.`category_code` ,b.`userid`, b.`name`, b.`user_image`,b.`prof_id`,b.`sport`,b.`gender`,b.`dob` FROM `gs_tournament_application` AS a RIGHT JOIN `user` AS b ON b.`userid` = a.`applicant_id`".$where."");

	if(mysql_num_rows($query)>0)
	{
    while ($row = mysql_fetch_assoc($query)) {
		$age_obj    = new connect_userservice();
        $age        = $age_obj->getage($row['dob']);
		$row['age'] = $age;
		$rows[]     = $row;
	}
    return $rows;
    }
    else
    {
    return 0;
    }
}

public function get_participant_info($where)
{   
	$query = mysql_query("SELECT a.`id`, a.`applicant_id`, a.`tournament_id`, a.`date_applied`, a.`fee_amount`, `organiser_id`, a.`category_code` ,b.`userid`, b.`name`, b.`user_image` ,b.`gender`,b.`dob` FROM `gs_tournament_application` AS a RIGHT JOIN `user` AS b ON b.`userid` = a.`applicant_id`".$where."");

	if(mysql_num_rows($query)>0)
	{
    while ($row = mysql_fetch_assoc($query)) {
		$age_obj    = new connect_userservice();
        $age        = $age_obj->getage($row['dob']);
		$row['age'] = $age;
		$rows[]     = $row;
	}
    return $rows;
    }
    else
    {
    return 0;
    }
}

public function tournament_apply_catogery($tournament_id,$userid)
{
	$query = mysql_query("SELECT `id`,`application_data` FROM `gs_tournament_application` WHERE `applicant_id` = '$userid' AND `tournament_id` = '$tournament_id'");

	if(mysql_num_rows($query))
	{
		while($row = mysql_fetch_assoc($query)) {
			     $application_data =  json_decode($row['application_data']);
			     $row['application_data']  = $application_data;
			     $rows [] = $row;
		}
		return $rows;
	}
	else
	{
		return 0;
	}
}

public function getTournament_data($tournament_id)
{
   // echo "SELECT `update_info` FROM `gs_tournament_updates` WHERE `tournament_id` = '$tournament_id'";die;
	$query  = mysql_query("SELECT `update_info` FROM `gs_tournament_updates` WHERE `tournament_id` = '$tournament_id'");
	if(mysql_num_rows($query) != 0)
	{
	    return mysql_fetch_assoc($query);
	}
	else
	{
		return 0;
	}
} 

public function create_update($data)
{
 $query = mysql_query("INSERT INTO `gs_tournament_updates` (`tournament_id`, `update_info`, `userid`, `date_created`, `date_updated`) VALUES ('$data->tournamentid','$data->update_info','$data->userid','CURDATE()','CURDATE()') ON DUPLICATE KEY UPDATE `update_info` = '$data->update_info', `date_updated` = 'CURDATE()'");
   if($query)
   {
     return $this->getTournament_data($data->tournamentid);
   }
   else
   {
     return 0;

   }



}

} // End Class





?>