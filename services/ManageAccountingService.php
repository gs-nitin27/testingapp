<?php

/**
* 
*/
class ManageAccountingService 
{
	
	
public function MonthsListing($userid, $year)
{


$query = mysql_query("SELECT MONTHNAME(cd.`joining_date`)AS MONTH , YEAR(cd.`joining_date`) AS YEAR , SUM(cd.`fees`)AS fees , ROUND((SUM(cd.`fees`)/COUNT(cd.`student_id`)),2) AS perStudentEarning from `gs_class_data` AS cd LEFT JOIN `gs_coach_class` AS gc ON cd.`classid` = gc.`id` WHERE gc.`userid` = '$userid' AND YEAR(cd.`joining_date`) = YEAR(CURDATE()) GROUP BY MONTH(`joining_date`) ORDER BY MONTH(`joining_date`) ASC "); 

if(mysql_num_rows($query)>0)
{

while($row = mysql_fetch_assoc($query))
{


$data[] = $row;

}
return $data;

}
else
	return 0;

//SELECT MONTH(cd.`joining_date`) , cd.`classid`,sum(cd.`fees`) , gc.`userid` FROM `gs_class_data` AS cd LEFT JOIN `gs_coach_class` AS gc ON cd.`classid` = gc.`id` WHERE gc.`userid` = '16' GROUP BY cd.`classid` 

}



}

 ?>