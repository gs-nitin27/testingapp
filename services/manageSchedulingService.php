<?php
class manageSchedulingService
{
 
public function createClass($item,$code)
{
$start_date = $item->start_date;
if($item->end_date != '')
{
  $end_date = "'".$item->end_date."'";
}else
{
  $end_date = 'DEFAULT(`class_end_date`)';
}
$query = mysql_query("INSERT INTO `gs_coach_class`(`userid`, `class_title`,`class_code`, `class_start_timing`,`class_end_timing`, `class_start_date`,`class_end_date`, `venue`,`location`,`description`,`date_created`,`days`,`age_group`,`class_fee`,`class_strength`,`contact_no`,`class_host`,`duration`,`classtype`) VALUES ('$item->user_id','$item->class_name','$code','$item->start_time','$item->end_time','$start_date',".$end_date.",'$item->address','$item->location','$item->description',CURDATE(),'$item->days','$item->age_group','$item->fee','$item->class_strength','$item->phone_no','$item->class_host','$item->duration','$item->classtype')");
$last_id = mysql_insert_id();   
if($query)
{
$getData = $this->getclassdata($last_id);
//print_r($getdata);die;
return $getData;
}
else 
{
return 0;
}
}


public function CheckforExistingClass($item)
{ 
	$start_date = $item->start_date;
  $end_date   = $item->end_date;

if(isset($item->class_id))
{
  $update_where = "AND `id` NOT IN($item->class_id)";
}else
{
  $update_where = '';
}
 $query = mysql_query("SELECT * FROM `gs_coach_class` WHERE `userid` = '$item->user_id' AND (DATEDIFF(`class_start_date` , '$start_date') < 0 OR DATEDIFF(`class_start_date` , '$start_date') = 0)".$update_where." ORDER BY `class_start_timing` DESC ");
if(mysql_num_rows($query)>0)
{
while($row = mysql_fetch_assoc($query))
{
$start_time = date("H:i", strtotime($row['class_start_timing']));
$end_time   = date("H:i", strtotime($row['class_end_timing']));
$given_start_time = date("H:i", strtotime($item->start_time));
$given_end_time = date("H:i", strtotime($item->end_time));
$days_array = explode(',', $item->days);
$days_array_given = explode(',',$row['days'] );
$result=array_intersect($days_array,$days_array_given);
if(!empty($result))
{
$var[] = $row['class_title'].' on '.implode(',', $result).' is in clash';
}
 if((($given_start_time > $start_time && $given_start_time < $end_time) || ($given_end_time > $start_time && $given_end_time < $end_time))||($given_start_time == $start_time && $given_end_time == $end_time))
 { $time_clash[] = 'timing of class'.$row['class_title'].' is also in clash';
   $row['class_fee'] = json_decode($row['class_fee']);
   $data[] = $row;
 } 
}
return $data;
}
else
{
  return 0;
}
}



public function updateClass($item,$code)
{

$start_date = $item->start_date;
if($item->end_date != '')
{
  $end_date = "'".$item->end_date."'";
}else
{
  $end_date = 'DEFAULT(`class_end_date`)';
}
$query = mysql_query("UPDATE `gs_coach_class` SET `class_title` = '$item->class_name',`description`='$item->description',`days` = '$item->days',`class_fee` = '$item->fee',`age_group` = '$item->age_group',`class_strength` = '$item->class_strength',`class_host`= '$item->class_host',`contact_no` = '$item->phone_no' , `location` = '$item->location' ,`class_code`='$code', `class_start_timing`='$item->start_time',`class_end_timing`='$item->end_time',`class_start_date` = '$start_date',`class_end_date` = $end_date, `venue` = '$item->address' WHERE `id` = '$item->class_id'");
if($query)
{
$getData = $this->get_updated_classdata($item->class_id);
return $getData;
}
else 
return 0;
}


public function getclassdata($id)
{
$query = mysql_query("SELECT * FROM `gs_coach_class` WHERE `id`  = '$id' ORDER BY `id` DESC LIMIT 1");
if(mysql_num_rows($query) != 0){
$row = mysql_fetch_assoc($query);
$row['class_fee'] = json_decode($row['class_fee']);
return $row;

}
else 

return 0;

}

public function get_updated_classdata($id)
{
//echo "SELECT * FROM `gs_coach_class` WHERE `id`  = '$id'";die;
$query = mysql_query("SELECT * FROM `gs_coach_class` WHERE `id`  = '$id'");
if(mysql_num_rows($query) != 0){
	while($row = mysql_fetch_assoc($query))
	{
    return $row; 
  }
      }
else 

return 0;;

}


public function getstudentlist($id)
{

$query= mysql_query("SELECT `gs_class_data`.`id` AS class_join_id ,`gs_class_data`.`student_name` AS name, `gs_class_data`.`status`,`gs_class_data`.`student_id` AS userid,`gs_class_data`.`joining_date`,`gs_class_data`.`student_dob` AS dob,`gs_class_data`.`email` AS email,`gs_class_data`.`student_code`,`gs_class_data`.`phone` AS contact_no, `user`.`sport` AS sport , `user`.`user_image` , `user`.`prof_id`, `user`.`gender`, `gs_class_data`.`fees` ,`gs_class_data`.`paid` ,`gs_class_data`.`mode_of_payment` FROM user RIGHT JOIN gs_class_data ON `gs_class_data`.`student_id`=`user`.userid WHERE `classid` = '$id'");

if($query)
{
while($row = mysql_fetch_assoc($query))
{
$data[] = $row;
}
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

  //print_r($class);die;
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
$day = date('w', strtotime($date));
$query = mysql_query("SELECT * FROM `gs_coach_class` WHERE `userid` = '$userid' AND (DATEDIFF(`class_start_date`,'$date') = 0 || DATEDIFF(`class_start_date`,'$date')< 0) ");
if(mysql_num_rows($query)> 0)
{
   while($row = mysql_fetch_assoc($query))
   {
    $mystring = $row['days'];
    $match = preg_match("/".$day."/i", "".$mystring."");
    if($match != 0)
    {  
    $row['class_fee'] = json_decode($row['class_fee']);

     if($row['class_end_date'] != '' || $row['class_end_date'] != NULL)
     {  // echo 
        $to = strtotime($date); // or your date as well
        $now = strtotime($row['class_end_date']);
        $datediff =  $now-$to;
        $datediff =  floor($datediff / (60 * 60 * 24));//die;
        if($datediff > 0 || $datediff = 0)
        {$row['reschedule'] = '0';
         $rows[] = $row; 
         $classid[] = $row['id'];
        }
     }
     else
     {
      $row['reschedule'] = '0';
      $rows[] = $row;
      $classid[] = $row['id'];
     }
   }
 }
    //print_r($rows);;
$data = array('data' =>$rows ,'class_id' =>implode(',',$classid));
return $data;
}else
return 0;

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
$query  = mysql_query("SELECT * FROM `class_reschedule` WHERE `classid` = '$classid' AND `userid` = '$item->userid' AND `resc_date` = FROM_UNIXTIME($item->date)");

$row = mysql_num_rows($query);
if($row > 0)
{
$query1 = mysql_query("DELETE FROM `class_reschedule` WHERE `classid` = '$classid' AND `userid` = '$item->userid' AND `resc_date` = FROM_UNIXTIME($item->date)");

}


}


public function create_reschedule($item,$date)
{  $day = split('-', $date);
   $id = $day[0].$day[1].$day[2].$item->classid;

   $varify = $this->check_forTimeClash($item,$date);
  // print_r($varify);die;
   if($varify == 0)
   {
   $query = mysql_query("INSERT INTO `class_reschedule`(`id`,`classid`, `userid`, `resc_date`, `start_time`, `end_time`, `resc_type`,`resc_to`, `resc_made`) VALUES ('$id','$item->classid','$item->userid',FROM_UNIXTIME($item->date),'$item->start_time','$item->end_time','$item->type','$item->existing_classid',CURDATE()) ON DUPLICATE KEY UPDATE `resc_date` = FROM_UNIXTIME($item->date) , `start_time` ='$item->start_time',`end_time` = '$item->end_time', `resc_type` = '$item->type', `resc_to` = '$item->existing_classid' ");
  
  if($query)
  {

  return 1;
  }
  else 
  return 0;
}
else
  return $varify;
}


public function check_forTimeClash($item,$date)
{
   //$date = '2017-11-09'; $userid = '2';
 $res = $this->getclasslisting($item->userid,$date);
 $res = $res['data'];//print_r($res['data']);die;
  foreach ($res as $key => $value) {
    if($value['id'] != $item->classid){
  $start_time = date("H:i", strtotime($value['class_start_timing']));
  $end_time   = date("H:i", strtotime($value['class_end_timing']));
  $given_start_time = date("H:i", strtotime($item->start_time));
  $given_end_time = date("H:i", strtotime($item->end_time));
  if((($given_start_time > $start_time && $given_start_time < $end_time) || ($given_end_time > $start_time && $given_end_time < $end_time))||($given_start_time == $start_time && $given_end_time == $end_time))
   { 

    $time_clash[] = array('id' =>$value['id'],'userid'=>$value['userid'],'class_title'=>$value['class_title'],'classtype'=>$value['classtype'],'description'=>$value['description'],'class_code'=>$value['class_code'],'class_start_timing'=>$value['class_start_timing'],'class_end_timing'=>$value['class_end_timing'],'class_start_date'=>$value['class_start_date'],'class_end_date'=>$value['class_end_date'] );
   
   } 
   }
  }
  if(!empty($time_clash))
  { 
    return $time_clash;
  }
  else
  {
    return 0;
  }
}
  /*while($row = mysql_fetch_assoc($query))
  {
  $start_time = date("H:i", strtotime($row['class_start_timing']));
  $end_time   = date("H:i", strtotime($row['class_end_timing']));
  $given_start_time = date("H:i", strtotime($item->start_time));
  $given_end_time = date("H:i", strtotime($item->end_time));
  $days_array = explode(',', $item->days);
  $days_array_given = explode(',',$row['days'] );
  $result=array_intersect($days_array,$days_array_given);
  if(!empty($result))
  {
  $var[] = $row['class_title'].' on '.implode(',', $result).' is in clash';
  }
   if((($given_start_time > $start_time && $given_start_time < $end_time) || ($given_end_time > $start_time && $given_end_time < $end_time))||($given_start_time == $start_time && $given_end_time == $end_time))
   { $time_clash[] = 'timing of class'.$row['class_title'].' is also in clash';
     $row['class_fee'] = json_decode($row['class_fee']);
     $data[] = $row;
   } 
  }*/
  //return $data;
/*}
else
{
  return 0;
}*/





public function get_reschedule($date,$classid,$res)
{//print_r($res['data']);die;

$query = mysql_query("SELECT `id`,`classid`,`resc_type`,`start_time`, `end_time`,`resc_to` FROM `class_reschedule` WHERE `resc_date` = '$date' AND `classid` IN ($classid) ORDER BY `start_time` ASC");
if(mysql_num_rows($query)>0)
{
while($row = mysql_fetch_assoc($query))
{
foreach ($res['data'] as $key => $value) {
  if($value['id'] == $row['classid'])
  { $row['data_key'] = $key;

    $rows[] = $row;
  }
  if($value['id'] == $row['classid'])
  {
   $row['exchange_key'] = $key;    
  }
}
}
return $rows;
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


public function update_fees($item)
{
    // print_r($item);die;
    $query = mysql_query("UPDATE `gs_class_data` SET `paid` = '$item->paid'  WHERE `classid` ='$item->class_id' AND `student_id` = '$item->student_userid' ");

    if($query)
    {
       return 1 ;
    }else
    {
      return 0;
    }

}



}



?>