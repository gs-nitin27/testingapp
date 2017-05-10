<?php
class event_service 
{

 public function event_participants_list($id)
 {
    $query =mysql_query("SELECT * FROM `user` WHERE `userid` IN (SELECT `userid` FROM `user_events` WHERE `userevent` = $id)");
			if(mysql_num_rows($query)>0)
			{
			while ($row = mysql_fetch_assoc($query)) {
			  $data[] = $row;
			}
			return $data;
			}
			else
			return 0;
 }
}
?>

