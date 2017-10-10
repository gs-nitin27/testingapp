<?php

class attendanceService
{
	
public function student_listing($classid)
{
$query= mysql_query("SELECT `gs_class_data`.`id` AS class_join_id ,`user`.`userid` AS student_id ,`gs_class_data`.`student_name` AS name, `gs_class_data`.`status`,`gs_class_data`.`student_id` AS userid,`gs_class_data`.`joining_date`,`gs_class_data`.`student_dob` AS dob,`gs_class_data`.`email` AS email,`gs_class_data`.`student_code`,`gs_class_data`.`phone` AS contact_no, `user`.`sport` AS sport , `user`.`user_image` , `user`.`prof_id`, `user`.`gender`, `gs_class_data`.`fees` ,`gs_class_data`.`paid` ,`gs_class_data`.`mode_of_payment` FROM user RIGHT JOIN gs_class_data ON `gs_class_data`.`student_id`=`user`.userid WHERE `classid` = '$classid' AND `gs_class_data`.`status`='2' " );
	$num  = mysql_num_rows($query);
		if($num != 0)
		{
			while($row = mysql_fetch_assoc($query))
			{

				$student_code 			   = $row['student_code'];
				$student_id 			   = $row['student_id'];
				$name 					   = $row['name'];
				$dob 					   = $row['dob'];
				$gender 				   = $row['gender'];
  				$age          			   =  $this->ageGropup($dob,$gender);



				$row1 =  array('student_id'=>$student_id,'name'=>$name,'age'=>$age,'gender'=>$gender,'attendance_status'=>'NA','student_code'=>$student_code);

				$data[] = $row1;
			}

			//$data1[]  = $data;
		return $data;
		}
		else
		{
			return 0;
		}
}


public function ageGropup($dob,$gender)
	{
		$date_1 = new DateTime($dob);
		$date_2 = new DateTime( date( 'd-m-Y' ));
		$difference = $date_2->diff( $date_1 );
		$year=(string)$difference->y;
		return $year;
	}




public function get_attendence_data($where)
{
  $query  = mysql_query("SELECT * FROM `gs_class_attendence`".$where."");
    if(mysql_num_rows($query)> 0)
    {
       $data = mysql_fetch_assoc($query);
       $attendance = json_decode($data['attendence_detail']);
       foreach ($attendance as $key => $value) {
         $data1[$key] = $this->get_student_detail($key,$value);
       }
       $data2[] = $data1;
       return $data2;//die;
     }
    else
    {
        return '0';
    }
}



public function get_student_detail($id,$value)
{
$query = mysql_query("SELECT `student_name`,`phone`,`email` FROM `gs_class_data` WHERE `student_code`='$id'");
$data =  mysql_fetch_assoc($query);
$data['attendence'] = $value;
return $data;
}













   


public function  athlete_attendance($data,$classid )
{

//print_r($data);

//echo "INSERT INTO `gs_class_attendance` (`class_id`,`attendance_detail`,`date_created`) VALUES('$classid','$data',CURDATE()) ";die();
// $row        =  $this->check_class_id($classid);
// if($row) 
// {

// $old_row 	= $row['attendance_detail'];
// $new_row[] 	= $old_row;
// $new_row[] 	= $data;
// $new_data	= implode(",",$new_row);
//   $row_sel    = mysql_query("UPDATE `gs_athlete_attendance` SET `attendance_detail`='$new_data',`date_updated` = CURDATE() WHERE `class_id`= $classid");
// }
// else
// {

 $row_sel    = mysql_query("INSERT INTO `gs_class_attendence` (`class_id`,`attendance_detail`,`date_created`,`date_updated`) VALUES('$classid','$data',CURDATE(),CURDATE()) ");

if($row_sel) 
{
return 1;
}
else
{
  return 0;
}
}









public function check_class_id($classid)
{
$sel_row  =  mysql_query("SELECT `class_id`,`attendance_detail` FROM `gs_athlete_attendance` WHERE  `class_id` = '$classid' ");
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