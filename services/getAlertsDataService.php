<?php
class getAlertsDataService
{

public function getAlerts($userid, $module)
{
//echo "SELECT IFNull(ga.`id`,'') AS id, iFNull(ga.`applicant_id`,'') AS applicant_id,IFNull(gs.`search_para`,'') AS para,IFNull(gs.`userid`,'') AS userid,IFNull(ga.`type`,'') AS Moudule,IFNull(ga.`date_alerted`,'') AS date_alerted,IFNull(ga.`message`,'') AS message,IFNull(ga.`title`,'') AS title FROM `gs_subscribed` AS gs JOIN `gs_alerts` AS ga ON gs.`id` = ga.`applicant_id` WHERE gs.`userid` = '$userid' GROUP BY ga.`message`  ORDER BY ga.`id` DESC LIMIT 0,9 ";die();

$query = mysql_query("SELECT IFNull(ga.`id`,'') AS id, iFNull(ga.`applicant_id`,'') AS applicant_id,IFNull(gs.`search_para`,'') AS para,IFNull(gs.`userid`,'') AS userid,IFNull(ga.`type`,'') AS Moudule,IFNull(ga.`date_alerted`,'') AS date_alerted,IFNull(ga.`message`,'') AS message,IFNull(ga.`title`,'') AS title FROM `gs_subscribed` AS gs JOIN `gs_alerts` AS ga ON gs.`id` = ga.`applicant_id` WHERE gs.`userid` = '$userid' GROUP BY ga.`message`  ORDER BY ga.`id` DESC LIMIT 0,9 ");

if(mysql_num_rows($query) > 0)
{

while($row = mysql_fetch_assoc($query))
{

$data[] = $row;

}
return $data;
}

else

return 0;

}

public function getsubscribealerts($userid)
{

$query = mysql_query("SELECT * FROM `gs_subscribed` WHERE `userid` = '$userid' ");
if(mysql_num_rows($query) > 0)
{

while($row = mysql_fetch_assoc($query))
{

$data[] = $row;

}

return $data;
}

}



public function saveSubscribealert( $userid,$applicantid,$message, $prof ,$type)
{

$query = mysql_query("INSERT INTO `gs_alerts`(`id`,`userid`,`applicant_id`,`message`,`title`,`date_alerted`, `type`) VALUES ('','$userid','$applicantid','$message','$prof',CURDATE(),'$type')");
if($query)
{

return true;

}
else 

return false;

}



public function unsubscribeAlerts($userid,$id)
{

$query = mysql_query("DELETE FROM `gs_subscribed` WHERE `userid` = '$userid' AND `id` = '$id'");

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