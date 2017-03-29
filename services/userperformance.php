<?php
class UserPerformanceService
{

/***************This Function are used to find Performance****************************/

public function userPerformance($id,$age,$sport,$gender)
{
	//print_r($id);die();
	$query 	= mysql_query("SELECT *FROM `gs_assess_question` WHERE `age_group` LIKE '$age' AND `sport` LIKE '$sport' AND `gender` LIKE '$gender' ");
	$num = mysql_num_rows($query);
	if ($num>0)
	{
	while ($row=mysql_fetch_assoc($query))
	{

		$row['question']=json_decode($row['question']);
		$row['performance_id'] = $id['id'];
		$data = $row;
	}
	return $data;
	}
	else
	{
		return 0;
	}
}	




/******************************Save ***************************************/

public function  save($coachid,$athleteid)
{

$query =mysql_query("INSERT INTO `gs_athlit_performance` (`id`,`coachid`,`athlitid`,`data`,`status`,`date_created`) VALUES('0','$coachid','$athleteid','0','0',CURDATE())");
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

	public function ageGropup($dob)
	{
		$date_1 = new DateTime($dob);
		$date_2 = new DateTime( date( 'd-m-Y' ));
		$difference = $date_2->diff( $date_1 );
		$year=(string)$difference->y;
			$query 	= mysql_query("SELECT age_group FROM gs_age_group ");
			$num = mysql_num_rows($query);
			if ($num>0)
			{
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
	$coachid         =  $userdata->coachid;
	$athleteid       =  $userdata->athleteid;
	$data       	 =  $userdata->data;
	$status       	 =  $userdata->status;
	$query =mysql_query("INSERT INTO `gs_athlit_performance` (`id`,`coachid`,`athlitid`,`data`,`status`,`date_created`) VALUES('0','$coachid','$athleteid','$data','$status',CURDATE())");
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
} //End function



public function findData($last_id)
{
	$query 	= mysql_query("SELECT `id`,`status` FROM `gs_athlit_performance` WHERE `id`=$last_id ");
	$num = mysql_num_rows($query);
	if ($num>0)
	{
	while ($row=mysql_fetch_assoc($query))
	{
		$data=$row;
	}
	return $data;
	}
}					




/**************************************************************/

		
public function  publishPerformance($userdata)
{
	$id         =  $userdata->id;
	$data       =  $userdata->data;
	$status     =  $userdata->status;
	$query =mysql_query("UPDATE `gs_athlit_performance` SET `data`= '$data' ,`status`='$status' ,`date_publish`= CURDATE() WHERE `id`='$id'");
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

$query= mysql_query("SELECT user.`name` , gs_athlit_performance.* FROM user INNER JOIN gs_athlit_performance ON `user`.`userid`=`gs_athlit_performance`.coachid WHERE `athlitid`=$athleteid ");

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