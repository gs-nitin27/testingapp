<?php
class UserPerformanceService
{
public function user_performance($dob,$sport)
{

	$query 	= mysql_query("SELECT *FROM `gs_assess_question` WHERE `sport` = '$sport' ");
	$num = mysql_num_rows($query);
	if ($num>0)
	{
	while ($row=mysql_fetch_assoc($query))
	{
		$data[]=$row;
	}
	return $data;
	}
	else
	{
		return 0;
	}
	

}

} // End Class 


?>