<?php
class UserPerformanceService
{


/***************This Function are used to find Performance****************************/

public function userPerformance($id,$age,$sport,$gender)
{  
	$query 	= mysql_query("SELECT * FROM `gs_assess_question` WHERE `age_group` LIKE '$age' AND `sport` LIKE '$sport' AND `gender` LIKE '$gender' AND `publish` = '1' ");
	$num = mysql_num_rows($query);
	if ($num>0)
	{
	while ($row=mysql_fetch_assoc($query))
	{	
		$row['performance_id'] = $id;
		$question1 = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $row['question']), true );
		$row['question'] =  $question1;
		$row['performance_id'] = $id;
		$data = $row;
	}
	
	return $data;
	}
	else
	{
		return 0;
	}
}	


/*********************************** Check The Performance**********************************/

public function cheackPerformance($age,$sport,$gender)
{  
	$query 	= mysql_query("SELECT *FROM `gs_assess_question` WHERE `age_group` LIKE '$age' AND `sport` LIKE '$sport' AND `gender` LIKE '$gender' ");
	$num = mysql_num_rows($query);
	if ($num>0)
	{
	   return 1;
	}
	else
	{
		return 0;
	}
}	



/******************************Save ***************************************/


public function  save($coachid,$athleteid)
{
    $query =mysql_query("INSERT INTO `gs_athlit_performance` (`id`,`coachid`,`athlitid`,`data`,`avg`,`modules_avg`,`status`,`date_created`) VALUES('0','$coachid','$athleteid','0','0','0','0',CURRENT_DATE )");
	if ($query)
	{
	 $last_id = mysql_insert_id();
     $Result  = $this->findData($last_id);
	  return $Result;
	}
	else
	{
		return 0;
	}

}




/******************************Find Age Group************************/

	public function ageGropup($dob,$gender)
	{
		$date_1 = new DateTime($dob);
		$date_2 = new DateTime( date( 'd-m-Y' ));
		$difference = $date_2->diff( $date_1 );
		$year=(string)$difference->y;
			$query 	= mysql_query("SELECT age_group FROM gs_age_group WHERE `gender` = '$gender' ");
			$num = mysql_num_rows($query);
			if ($num>0)
			{   $sum = '';
				while ($row=mysql_fetch_assoc($query))
				{
					$data[]=implode("-",$row);
				}
					$n=count($data);
					for ($i=0; $i <$n ; $i++) 
				   	{
				   	  $age= explode("-",$data[$i]);
					   $min=$age[0];
					   $max=$age[1];
					   if ($year>=$min && $year<=$max)
					   {
					      $sum="$min-$max";
						      break;
					   }
					}
				return $sum;
			}
	}


/*********************************************************/


public function  savePerformance($userdata)
{
	$id       		 =  $userdata->id;	
	$coachid         =  $userdata->coachid;
	$athleteid       =  $userdata->athleteid;
	$data       	 =  $userdata->data;
	$status       	 =  $userdata->status;
	$avg 			 =  $userdata->avg;
	$modules_avg	 =  $userdata->modules_avg;

	$query 			 =	mysql_query("UPDATE  `gs_athlit_performance` SET `coachid`='$coachid',`athlitid`= '$athleteid' ,`data`='$data',`status`='$status',`avg`= '$avg',`modules_avg`='$modules_avg',`date_created`= CURDATE() WHERE `id`=$id");
	$num=mysql_affected_rows(); 
	if ($num)
	{
	  return 1;
	}
	else
	{
		return 0;
	}
} //End function





public function findData($last_id)
{
	$query 	= mysql_query("SELECT `id`FROM `gs_athlit_performance` WHERE `id`='$last_id' ");
	$num = mysql_num_rows($query);
	if ($num>0)
	{
	while ($row=mysql_fetch_assoc($query))
	{
		$data=$row['id'];
	}
	return $data;
	}
}					




/**************************************************************/

		
public function  publishPerformance($userdata)
{
	$id 		        =  $userdata->id;
	$data 		      	=  $userdata->data;
	$status     		=  $userdata->status;
	$next_assessment 	=	date('Y/m/d', strtotime('+3 months'));
	$query =mysql_query("UPDATE `gs_athlit_performance` SET `data`= '$data' ,`status`='$status' ,`date_publish`= CURDATE(),`next_assessment`='$next_assessment' WHERE `id`='$id'");
	$num=mysql_affected_rows();
	if ($num)
	{
		$Result  = $this->findData($id);
	    return $Result;
	}
	else
	{
		return 0;
	}

} //End function




/**************************View Profile********************************/

public function viewPerformance($athleteid)
{

$query= mysql_query("SELECT `user`.`name` , `gs_athlit_performance`.* FROM user INNER JOIN `gs_athlit_performance` ON `user`.`userid`=`gs_athlit_performance`.coachid WHERE `athlitid`='$athleteid' ORDER BY `date_publish` DESC");
	$num = mysql_num_rows($query);
	
	if ($num>0)
	{
	while ($row=mysql_fetch_assoc($query))
	{
    $startTimeStamp 	= date("Y/m/d") ;
    $startTimeStamp 	= strtotime($startTimeStamp);
    $next_assessment 	= $row['next_assessment'];
    $endTimeStamp    	= strtotime($next_assessment);
	$timeDiff 			= abs($endTimeStamp - $startTimeStamp);
	$numberDays 		= $timeDiff/86400;  // 86400 seconds in one day
	$numberDays 		= intval($numberDays);
	$row['next_assessment']=$numberDays;
	$row['data'] 		= json_decode($row['data']);
	$row['modules_avg'] = json_decode($row['modules_avg']);
	$data[]=$row;
	}
	return $data;
	}
	else
	{
		return 0;
	}
}	



public function viewPerformanceguide($item,$agegropup)
{
   $query = mysql_query("SELECT `guidelines` FROM `gs_performance_guide` WHERE `sport`='$item->sport' AND `age_group`='$agegropup' AND `gender` = '$item->gender'");

   $num = mysql_num_rows($query);
	if ($num>0)
	{
	while ($row=mysql_fetch_assoc($query))
	{
		$data[]=$row;
	}
	return $data[0];
	}
	else
	{
		return 0;
	}

  }		



/*******************Save Suggestion********************/

 public function suggestion($userdata)
 {
 	$coachid 		=	 $userdata->coachid;
	$title 			=	 $userdata->title;
	$description 	=	 $userdata->description;
	$module 		=	 $userdata->module;
	$gender 		=	 $userdata->gender;
	$dob 			=	 $userdata->dob;
	$sport 			=	 $userdata->sport;
   $query = mysql_query("INSERT INTO `gs_suggestion` (`sugg_id`,`coachid`,`title`,`description`,`module`,`gender`,`dob`,`sport`) VALUES('0','$coachid','$title','$description','$module','$gender','$dob','$sport')");
	if($query)
	{
	   return 1;
	}
	else
	{
		return 0;
	}

}


/**************************Function for save_request_assessment ********************/

 public function save_request_assessment($userdata)
 {


 	$request_type		=	 $userdata->request_type;
	$assessment_type 	=	 $userdata->assessment_type;
	$athlete_id 		=	 $userdata->athlete_id;
	$video_link 		=	 $userdata->video_link;
	$date 				=	 $userdata->date;
	$time 				=	 $userdata->time;
	$venue 				=	 $userdata->venue;
    $query = mysql_query("INSERT INTO `gs_request_assessment`(`id`,`request_type`,`assessment_type`,`athlete_id`,`video_link`,`date`,`time`,`venue`) VALUES('0','$request_type','$assessment_type','$athlete_id','$video_link','$date','$time','$venue')");
	if($query)
	{
	   return 1;
	}
	else
	{
		return 0;
	}

}






public function  view_request_assessment($athlete_id)
{
  $query = mysql_query("SELECT *FROM `gs_request_assessment` WHERE `athlete_id` = '$athlete_id' ");
  $num   = mysql_num_rows($query);
  if($num)
  {
     while($row = mysql_fetch_assoc($query))
     {
     	$data[]  = $row;
     }
     return $data;
  }
  else
  {
		return 0;
  }
	

}

public function class_show($coach_id,$class_id)
{
if (empty($class_id))
{
  $where = 	" WHERE coach_id = '$coach_id' AND `status` = '2' ";
}
else
{
	$where = 	" WHERE classid = '$class_id' AND `status` = '2' ";
}

  $query1 = mysql_query("SELECT `student_id`,`student_name` FROM `gs_class_data` $where ");
  $num   = mysql_num_rows($query1);
  if($num)
  {
     while($row1 = mysql_fetch_assoc($query1))
     {
     	$athleteid  = $row1['student_id'];
$query = mysql_query("SELECT avg(avg) AS average, COUNT(*) AS total, `date_publish` FROM gs_athlit_performance WHERE athlitid = '$athleteid' ORDER BY date_publish DESC");
$row 			= mysql_fetch_assoc($query);
$average  		= $row['average'];
$total 			= $row['total'];
$date_publish   = $row['date_publish'];
if(empty($average)) 
{
$average 	   ='0';
$total    	   ='0';
$date_publish  ='';	
}





     	$row1['last_assessment'] = $date_publish;
     	$row1['avg'] 			= $average;
     	$row1['total'] 			= $total;
     	$data[]  				= $row1;
     }
     return $data;
  }
  else
  {
		return 0;
  }
	

}



public function cheack_coach_id($coach_id)
{
	$query  = mysql_query("SELECT *FROM `gs_athlit_performance` WHERE `coachid`= $coach_id ");
	$num = mysql_num_rows($query);
	if($num)
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
