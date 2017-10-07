<?php

class attendanceService
{
public function student_listing($classid)
{
$query= mysql_query("SELECT `gs_class_data`.`id` AS class_join_id ,`gs_class_data`.`student_name` AS name, `gs_class_data`.`status`,`gs_class_data`.`student_id` AS userid,`gs_class_data`.`joining_date`,`gs_class_data`.`student_dob` AS dob,`gs_class_data`.`email` AS email,`gs_class_data`.`student_code`,`gs_class_data`.`phone` AS contact_no, `user`.`sport` AS sport , `user`.`user_image` , `user`.`prof_id`, `user`.`gender`, `gs_class_data`.`fees` ,`gs_class_data`.`paid` ,`gs_class_data`.`mode_of_payment` FROM user RIGHT JOIN gs_class_data ON `gs_class_data`.`student_id`=`user`.userid WHERE `classid` = '$classid'");

		$num  = mysql_num_rows($query);
		if($num)
		{
			while($row = mysql_fetch_assoc($query))
			{
				$row['attendance_status']  = 'A';
				$data[] = $row;
			}
		return $data;
		}
		else
		{
			return 0;
		}
}







public function  athlete_attendance($data)
{

$class_id 	= $data->class_id;

echo "$class_id";



$data 		= json_encode($data->data);
$row        =  $this->check_class_id($class_id);

if($row['class_id']) 
{

// $old_row 	= $row['attendance_detail'];


// $old_data = json_decode($old_row);



// $tata = $old_data[0];

// $sum  = array($tata);

// print_r($sum);

// //print_r($tata->'6-10-2017');




// //echo $old_row->'6-10-2017';


// //6-10-2017

// die();



$new_row[] 	= $old_row;
$new_row[] 	= $data;
$new_data	= implode(",",$new_row);
  $row_sel    = mysql_query("UPDATE `gs_athlete_attendance` SET `attendance_detail`='$new_data',`date_updated` = CURDATE() WHERE `class_id`= $class_id");




}
else
{
 $row_sel    = mysql_query("INSERT INTO `gs_athlete_attendance` (`class_id`,`attendance_detail`,`date_created`) VALUES('$class_id','$data',CURDATE()) ");
}
if($row_sel) 
{
return 1;
}
else
{
  return 0;
}
}



public function check_class_id($class_id)
{
$sel_row  =  mysql_query("SELECT `class_id`,`attendance_detail` FROM `gs_athlete_attendance` WHERE  `class_id` = '$class_id' ");
mysql_num_rows($sel_row);
if(mysql_num_rows($sel_row))
{
return mysql_fetch_assoc($sel_row);
}
else
{
  return 0;
}
}



} // End Class
?>