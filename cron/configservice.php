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

}


?>