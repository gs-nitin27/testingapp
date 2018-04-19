<?php
class event_service 
{
 public function event_participants_list($id)
 {
    $query =mysql_query("SELECT * FROM `user` WHERE `userid` IN (SELECT `applicant_id` FROM `gs_event_application` WHERE `event_id` = $id)");
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


public function  check_entry_passcode($userdata)
{
	$event_id           =  $userdata->event_id;
    $entry_passcode     =  $userdata->entry_passcode;
	$query  = mysql_query("SELECT *FROM `gs_event_application` WHERE  `event_id` = '$event_id' AND `id`='$entry_passcode'");
	$num = mysql_num_rows($query);
	if ($num>0) 
	{
	 mysql_query("UPDATE  `gs_event_application` SET  `status` = '2' WHERE `id` = '$entry_passcode' ");
     return 1;
	}
	else
	{
		return 0;
	}
}  // End Function
public function apply_event($applydata)
{     
$query_data = implode(',', $applydata);
$fields = "INSERT INTO `gs_event_application`(`id`, `applicant_id`, `event_id`, `date_applied`, `fee_amount`, `application_data`, `organiser_id`,`status`) VALUES".$query_data;
//echo $fields;die;
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




}  // End Class
?>

