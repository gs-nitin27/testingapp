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
$query  = mysql_query("SELECT * FROM `gs_diet_plan` WHERE NOW() between `start_date` and `end_date` ");
	$num = mysql_num_rows($query);
if($num)
{
		while($row = mysql_fetch_assoc($query))
		{
			$id_diet  = $row['id'];
			$userid   = $row['userid'];
$data        = json_decode($row['my_diet_plan']);
$start_date  = $data->start_date;
$end_date    = $data->end_date;
$name        = $data->name;
$date        =  date('Y-m-d');
$day         =  strtolower(date("l"));
$value       = $data->diet_food->$day;
$log_data    = array('diet_food'=>array($day=>$value),'start_date'=>$start_date,'end_date'=>$end_date,'name'=>$name);
$log_data1 = json_encode($log_data);

        mysql_query("INSERT INTO `gs_diet_log`(`id`,`userid`,`id_diet`,`my_diet_plan`,`assign_date`) VALUES('0','$userid','$id_diet','$log_data1',CURDATE()) ");
//$data[] = "('0','".$row['userid']."','".$row['id']."','".$log_data1."',CURDATE() )"; 


			}
			return 1;
		
		}
		else
		{
			return 0;
		}
		

// 			if($this->assign_log_diet($data))
// 			{
// 				return 1;
// 			}
// 			else
// 			{
// 				return 0;
// 			}
// }
// else
// {

// 	return 0;
// }

}





/***********************Assign Log Diet*****************************************/



public function assign_log_diet($data)
{
	
	$values = implode(',', $data);

	mysql_query("INSERT INTO `gs_diet_log`(`id`,`userid`,`id_diet`,`my_diet_plan`,`assign_date`) VALUES $values");

				return 1;
}








} //End Class



?>