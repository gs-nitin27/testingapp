<?php
class manageSchedulingService
{


public function createClass($item,$code)
{
//$classtime = $item->start_time."-".$item->end_time;
$start_date = $item->start_date;
$end_date = $item->end_date;


$query = mysql_query("INSERT INTO `gs_coach_class`(`id`, `userid`, `class_title`,`class_code`, `class_start_timing`,`class_end_timing`, `class_start_date`, `class_end_date`, `venue`,`location`,`description`,`date_created`,`days`) VALUES ('','$item->user_id','$item->class_name','$code','$item->start_time','$item->end_time',FROM_UNIXTIME ('$start_date'),FROM_UNIXTIME ('$end_date'),'$item->address','$item->location','$item->description',CURDATE(),'$item->days')");
if($query)
{
return true;
}
else 
{
return false;
}
}


public function CheckforExistingClass($item)
{
	$end_date   = "FROM_UNIXTIME(".$item->end_date.")";
	$start_date = "FROM_UNIXTIME(".$item->start_date.")";

$query = mysql_query("SELECT `class_title` FROM `gs_coach_class` WHERE `userid` = '$item->user_id' AND (DATEDIFF(`class_start_date` , $start_date) < 0 OR DATEDIFF(`class_start_date` , $start_date) = 0) AND (DATEDIFF(`class_end_date` , $end_date) > 0 OR DATEDIFF(`class_end_date` , $end_date) = 0) AND (`class_start_timing` = '$item->start_time')AND (`class_end_timing` = '$item->end_time')ORDER BY `class_start_timing` DESC");

if(mysql_num_rows($query)>0)
{

while($row = mysql_fetch_assoc($query))
{


$data[] = $row;

}
return $data;
}
else
return '1';


}

public function updateClass($item,$code)
{

//$classtime =  $item->start_time."-".$item->end_time;
$start_date = $item->start_date;
$end_date =   $item->end_date;

$query = mysql_query("UPDATE `gs_coach_class` SET `class_title` = '$item->class_name' ,`class_code`='$code', `class_start_timing`='$item->start_time',`class_end_timing`='$item->end_time',`class_start_date` = FROM_UNIXTIME ($start_date),`class_end_date` = FROM_UNIXTIME ($end_date), `venue` = '$item->address' WHERE `id` = '$item->class_id'");
if($query)
{
return true;
}
else 
return false;
}

public function getclassdata($item)
{

$query = mysql_query("SELECT * FROM `gs_coach_class` WHERE `userid`  = '$item->user_id' ORDER BY `id` DESC LIMIT 1");
if(mysql_num_rows($query) == 1){
	while($row = mysql_fetch_assoc($query))
	{
       $data = $row;
       return $data;

	}
      }
else 

return false;

}
public function getstudentlist($id)
{
 $query = mysql_query("SELECT `student_id` FROM `gs_class_data` WHERE `classid`= $id ");
// $query = mysql_query("SELECT * FROM `user` WHERE `userid` NOT IN (SELECT `student_id` FROM `gs_class_data` WHERE `classid` = '$id') AND `prof_id` = 'Athletes'");
if($query)
{
while($row = mysql_fetch_assoc($query))
{
$data[] = $row;
}
//print_r($data);die;
return $data;
}
else 
	return 0;
}

public function addstudent($item)
{
$date = $item->joining_date;
$query = mysql_query("INSERT INTO `gs_class_data`(`id`, `classid`, `student_id`, `joining_date`, `fees`, `paid`, `date_added`) VALUES ('','$item->classid','$item->student_id',FROM_UNIXTIME ('$date'),'$item->fees','',CURDATE())");
if($query)
{

return true;

}
else{

	return false;
          }


  }

public function getStudents($class)
{
	$query = mysql_query("SELECT us.`name`,us.`device_id`, gs.`classid`,gs.`student_id` ,gs.`fees`,gs.`joining_date` FROM `gs_class_data` AS gs LEFT JOIN `user` AS us ON gs.`student_id` = us.`userid`  WHERE gs.`student_id` = us.`userid` AND gs.`classid` = '$class' ");
if(mysql_num_rows($query)>0)
{
while($rows = mysql_fetch_assoc($query))
{
$data[] = $rows;

}
return $data;

}
else{

return 0;

        }
    }


public function getclasslisting($userid, $date)
{
if($date == ""){
	$date = 'CURDATE()';

}else if($date != "")
{

$date = "FROM_UNIXTIME(".$date.")";

}

$query = mysql_query("SELECT `id`, `class_title`,`userid`,`class_start_timing`,`class_end_timing`, `class_start_date`, `class_end_date`, `class_host`, `contact_no`, `venue`, `location`, `date_created` FROM `gs_coach_class` GROUP BY `class_code` HAVING `userid` = '$userid' AND (DATEDIFF(`class_start_date` , $date) < 0 OR DATEDIFF(`class_start_date` , $date) = 0) AND (DATEDIFF(`class_end_date` , $date) > 0 OR DATEDIFF(`class_end_date` , $date) = 0) ORDER BY `class_start_timing` DESC");
if(mysql_num_rows($query)>0)
{

while($row = mysql_fetch_assoc($query))
{

$data[] = $row; 


}
return $data;

}else
return false;



}

public function varify_existing($item, $data)

{
	if($data != "")
	{
     
     $classid = $item->existing_classid;

    

	}
	else
	{

     $classid = $item->classid;
	}
//echo "SELECT * FROM `class_reschedule` WHERE `classid` = '$classid' AND `userid` = '$item->userid' AND `resc_date` = FROM_UNIXTIME($item->date)";
$query  = mysql_query("SELECT * FROM `class_reschedule` WHERE `classid` = '$classid' AND `userid` = '$item->userid' AND `resc_date` = FROM_UNIXTIME($item->date)");

$row = mysql_num_rows($query);
if($row > 0)
{
$query1 = mysql_query("DELETE FROM `class_reschedule` WHERE `classid` = '$classid' AND `userid` = '$item->userid' AND `resc_date` = FROM_UNIXTIME($item->date)");

}


}

public function create_reschedule($item)
{

$query = mysql_query("INSERT INTO `class_reschedule`(`id`, `classid`, `userid`, `resc_date`, `start_time`, `end_time`, `resc_type`,`resc_to`, `resc_made`) VALUES ('','$item->classid','$item->userid',FROM_UNIXTIME($item->date),'$item->start_time','$item->end_time','$item->type','$item->existing_classid',CURDATE())");
if($query)
{

return true;
}
else 
return false;




}

public function get_reschedule($date)
{
	//echo "SELECT * FROM `class_reschedule` WHERE `resc_date` = FROM_UNIXTIME($date)";

$query = mysql_query("SELECT * FROM `class_reschedule` WHERE `resc_date` = FROM_UNIXTIME($date) ORDER BY `start_time` ASC");
if(mysql_num_rows($query)>0)
{

while($row = mysql_fetch_assoc($query))
{

$data[] = $row;

}
return $data;

}
else
{


return 0;

}


}

public function check_existing($item)
{

$date = "FROM_UNIXTIME(".$item->date.")";
//echo "SELECT `id`, `class_title`,`userid`,`class_start_timing`,`class_end_timing`, `class_start_date`, `class_end_date`, `class_host`, `contact_no`, `venue`, `location`, `date_created` FROM `gs_coach_class` GROUP BY `class_title` HAVING `userid` = '$item->userid' AND (DATEDIFF(`class_start_date` , $date) < 0 OR DATEDIFF(`class_start_date` , $date) = 0) AND (DATEDIFF(`class_end_date` , $date) > 0 OR DATEDIFF(`class_end_date` , $date) = 0) AND `class_start_timing` = '$item->start_time' AND `class_end_timing`='$item->end_time' ORDER BY `class_start_timing` DESC";

$query = mysql_query("SELECT `id`, `class_title`,`userid`,`class_start_timing`,`class_end_timing`, `class_start_date`, `class_end_date`, `class_host`, `contact_no`, `venue`, `location`, `date_created` FROM `gs_coach_class` GROUP BY `class_title` HAVING `userid` = '$item->userid' AND (DATEDIFF(`class_start_date` , $date) < 0 OR DATEDIFF(`class_start_date` , $date) = 0) AND (DATEDIFF(`class_end_date` , $date) > 0 OR DATEDIFF(`class_end_date` , $date) = 0) AND `class_start_timing` = '$item->start_time' AND `class_end_timing`='$item->end_time' ORDER BY `class_start_timing` DESC");


//$row2 = mysql_num_rows($query);
if(mysql_num_rows($query)>0)
{
 //echo $row2; 
while($row = mysql_fetch_assoc($query))
{

$data[] = $row;

}
return $data;


}
else return 0;

}

public function fetchclassdata($item)
{
//echo "SELECT * FROM `gs_coach_class` WHERE `id` = '$item->classid'";
$query = mysql_query("SELECT * FROM `gs_coach_class` WHERE `id` = '$item->classid'");
if(mysql_num_rows($query)>0)
{
while($row = mysql_fetch_assoc($query))
{


$data = $row;


}
//print_r($data);
return $data;

}
else return 0;




}

public function create_reschedulefororig($item , $start , $end)
{
$query = mysql_query("INSERT INTO `class_reschedule`(`id`, `classid`, `userid`, `resc_date`, `start_time`, `end_time`, `resc_type`,`resc_to`, `resc_made`) VALUES ('','$item->existing_classid','$item->userid',FROM_UNIXTIME($item->date),'$start','$end','$item->type','$item->classid',CURDATE())");
if($query)
{

	return true;
}
else 
return false;

}

function findresc($item)
{

	//echo "SELECT * FROM `class_reschedule` WHERE `resc_date`=FROM_UNIXTIME($item->date) AND(`start_time` = '$item->start_time' AND `end_time`='$item->end_time') AND`userid` = '$item->userid'";

$query = mysql_query("SELECT * FROM `class_reschedule` WHERE `resc_date`=FROM_UNIXTIME($item->date) AND(`start_time` = '$item->start_time' AND `end_time`='$item->end_time') AND`userid` = '$item->userid'");
 
 if(mysql_num_rows($query)>0)
 {

while($row = mysql_fetch_assoc($query))
{
   $data[] = $row;   


}
return $data;

 }
 else;
return 0;


}

public function fetchdataForExchange($classid)
{

$query = mysql_query("SELECT `id` , `class_title` FROM `gs_coach_class` WHERE `id` = '$classid'");
if(mysql_num_rows($query) != 0)
{

while($row = mysql_fetch_assoc($query))
{

$data[] = $row;
}
return $data;

}
else return 0;
}





public function deletesession($item)
{

$query = mysql_query("DELETE FROM `gs_coach_class` WHERE `id` = '$item->classid' AND `userid` = '$item->userid'");
if($query)
{
	$query1 = mysql_query("DELETE FROM `class_reschedule` WHERE `classid` = '$item->classid' AND `userid` = '$item->userid'");

if($query1)
   return true;


  }
    else
{

   return false;

    }
  }






}



?>