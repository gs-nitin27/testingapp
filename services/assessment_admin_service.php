<?php

Class Assessment_admin_service
{

public function add_assessment($data)
	{  $query = mysql_query("INSERT INTO `gs_assessment_event`(`assessment_name`, `assigned_date`, `assigned_status`, `venue`, `category`, `date_created`,`institute_id`) VALUES ('$data->name','$data->date_assessed','$data->assessment_status','$data->venue','$data->assesment_category',CURDATE(),'$data->institute_id')");
		if($query)
		{
			return 1;
		}else
		{
			return 0;
		}
	}

public function get_assessment_list($list)
	{
		$query = mysql_query("SELECT `assessment_id`, `assessment_name`, `assigned_date`, `assigned_status`, `venue`, `category`, `date_created`, `institute_id` FROM `gs_assessment_event` WHERE `institute_id` = '$list'");
		if(mysql_num_rows($query)>0)
		{
			while ($row = mysql_fetch_assoc($query)) {
				$rows[]  = $row; 
			}
			return $rows;
		}else
		{
			return 0;
		}
     }

public function generate_student_list()
{









    



}


}

 ?>