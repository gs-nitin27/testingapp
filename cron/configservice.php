<?php

class ConfigService
{
	
public function assign_a_day_log()
{

	$query  = mysql_query("SELECT * FROM `gs_athletes_schedule` WHERE CURDATE() between `start_date` and `end_date` AND `active_status` = 1 ");

	if(mysql_num_rows($query)> 0)
	{

	while($row = mysql_fetch_assoc($query))
	{

	$data[] = "('".$row['userid']."','".$row['phase']."','".$row['activity']."','".$row['remarks']."',CURDATE(),0)"; 

	}

	if($this->assign_log($data) != 1)
	{
		return 0;
	}
	else
	{
		return 1;
	}
	}
}



public function assign_log($data)
{
	$values = implode(',', $data);
	$query  = mysql_query("INSERT INTO `gs_athlit_dailylog` (`userid`,`phase`,`activity`,`remarks`,`date`,`dailylogstatus`)VALUES $values ");
	
	if($query)
    { 
		return 1;
	}else
	{   
		return 0;
	}

}






/*******************************Log Diet ********************************/



public function log_diet()
{
$select_id = mysql_query("SELECT  `diet_id` FROM `gs_assign_diet_plan` WHERE `assign_status` = '1' ");

while ($row = mysql_fetch_assoc($select_id)) {
$data [] = implode(',', $row);
}

$total_id  =  implode(',', $data);

$query         = mysql_query("SELECT * FROM `gs_diet_plan` WHERE `id` IN ($total_id)  "  );

$num = mysql_num_rows($query);
if($num)
{
	 while($row = mysql_fetch_assoc($query))
		{

			$id_diet 	 = $row['id'];
			$userid  	 = $row['userid'];
			$usertype 	 = $row['userType'];
			$data        = json_decode($row['my_diet_plan']);
			$start_date  = $data->start_date;
			$end_date    = $data->end_date;
			$date        =  date('Y-m-d');
			if ($start_date <= $date && $date <= $end_date) 
			{
  			$name        = $data->name;
			$date        =  date('Y-m-d');
			$day         =  strtolower(date("l"));
			$value       = $data->diet_food->$day;
			$log_data    = array('diet_food'=>array($day=>$value),'start_date'=>$start_date,'end_date'=>$end_date,'name'=>$name);
			$log_data1   = json_encode($log_data);
			$req         =   new userdataservice();
			$pushobj 	 =   new userdataservice();			   
			$get_id 	 = $req ->getdeviceid($userid);
			$device_id   = $get_id['device_id'];
			$message_data  = json_decode($log_data1);

           mysql_query("INSERT INTO `gs_diet_log`(`id`,`userid`,`userType`,`id_diet`,`my_diet_plan`,`assign_date`) VALUES('0','$userid','$usertype','$id_diet','$log_data1',CURDATE()) ");
            $log_id = mysql_insert_id();
 $message      = array('message'=>array('my_diet_plan'=>$message_data,'id'=>$log_id),'title'=>$name,'indicator'=>8);
$jsondata      =   json_encode($message);
$pushnote      =   $pushobj->sendLitePushNotificationToGCM($device_id, $jsondata);

      }
else
{
      return 0;
}
  }

	return 1;

  }

  else
  {
  	return 0;
  }




}  // End Function













} //End Class



?>