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

			
		return $data;
		}
		else
		{
			return [];
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
        $data1[] = $this->get_student_detail($key,$value);
       }
       return $data1; 
     }
    else
    {
        return '0';
    }
}



public function get_student_detail($id,$value)
{

$query = mysql_query("SELECT `student_name` AS name, `student_dob`,`gender`,`student_code`  FROM `gs_class_data` WHERE `student_code`='$id'");
$data =  mysql_fetch_assoc($query);
$data['attendance_status'] = $value;
$dob 					   = $data['student_dob'];
$data['age']          	   =  $this->ageGropup($dob,$gender);
unset($data['student_dob']);
return $data;
}

  


public function  athlete_attendance($data,$classid,$date )
{
$check_cancel_data  =  $this->cheak_cancel_date($classid,$date);
if($check_cancel_data)
{
return 0;
}
else
{

 $row_sel    = mysql_query("INSERT INTO `gs_class_attendence` (`id`,`class_id`,`attendence_detail`,`date_created`,`date_updated`) VALUES('0','$classid','$data','$date',CURDATE()) ");
if($row_sel) 
{
return 1;
}
else
{
  return 0;
}
}
}



public function cheak_cancel_date($classid,$date)
{
	$query = mysql_query("SELECT * FROM `class_reschedule` WHERE `class_id` ='$classid' AND `resc_date`='$date'");
	$num = mysql_num_rows($query);
	if ($num)
	{
	 return 1;
	}
	else
	{
	 return 0;
	}


}



public function check_attendance($data1)
{
 $date 			= $data1->date;
 $class_id  		= $data1->class_id;
 $student_userid 	= $data1->student_userid;
 $search_month 		= date("m",strtotime($date));
 $student_code  	= $this->get_code($student_userid,$class_id);
 $query = mysql_query("SELECT  *FROM `gs_class_attendence` WHERE `class_id` ='$class_id'");
 if(mysql_num_rows($query)>0)
 {
 while ($row = mysql_fetch_assoc($query))
 {    $attendance 			       = json_decode($row['attendence_detail']);
      $date_created  				= $row['date_created'];
      $created_month      = date("m",strtotime($date_created));
      if ($created_month  ==  $search_month )
       {
       $attendance_status 	=  get_object_vars($attendance)[$student_code];
       $attendance_data  	=  array('attendence'=>$attendance_status ,'Date'=>$date_created);
	   $data[] 				=  $attendance_data;

		} // End of Function
	}
   return $data;
 }
 else
 {
   return 0;
 }
}



public function get_code($student_id, $class_id)
{
	$query = mysql_query("SELECT `student_code` FROM `gs_class_data` WHERE `student_id`=$student_id AND `classid`= $class_id ");
	$row  = mysql_fetch_row($query);
	return $row[0];
}


public function get_athelte_detail($id,$value)
{
$query = mysql_query("SELECT `student_name` FROM `gs_class_data` WHERE `student_code`='$id'");
$row =  mysql_fetch_assoc($query);
unset($row['student_name']);
$row['attendance_status'] = $value;
return $row;
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

public function  cancel_class($data)
{
	$coach_id  = $data->coach_id;
	$class_id  = $data->class_id;
	$date 	   = $data->date;
	$message   = $data->message;

	//  $this->cheak_cancel_row($coach_id,$class_id)
//	$row_sel    = mysql_query("INSERT INTO `class_reschedule`(`classid`, `userid`, `resc_date`, `resc_type`, `resc_made`, `msg`) VALUES ('$class_id','$coach_id','$date','2',CURDATE(),'$message')");

	$day = split('-', $date);
    $id = $day[0].$day[1].$day[2].$class_id;
	$row_sel    = mysql_query("INSERT INTO `class_reschedule`(`id`,`classid`, `userid`, `resc_date`, `resc_type`, `resc_made`, `msg`) VALUES ('$id','$class_id','$coach_id','$date','2',CURDATE(),'$message')ON DUPLICATE KEY UPDATE `resc_date` = '$date', `resc_type` = '2', `resc_made` = CURDATE(),`msg` = '$message' ");
	if($row_sel) 
		{
		return 1;
		}
	else
		{
		  return 0;
		}
}





} // End Class
?>
