<?php
class event_service 
{
 public function event_participants_list($id)
 {
    $query =mysql_query("SELECT * FROM `user` WHERE `userid` IN (SELECT `userid` FROM `user_events` WHERE `userevent` = $id)");
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
	$query  = mysql_query("SELECT *FROM `user_events` WHERE  `userevent` = '$event_id' AND `entry_passcode`='$entry_passcode'");
	$num = mysql_num_rows($query);
	if ($num>0) 
	{
	 mysql_query("UPDATE  `user_events` SET  `status` = '2' WHERE `entry_passcode` = '$entry_passcode' ");
     return 1;
	}
	else
	{
		return 0;
	}
}  // End Function




}  // End Class
?>

