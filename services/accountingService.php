<?php


class accountingServices 
{

  public function classlist($userid)
  {
      	



  }

  public function viewClass($classid)
  {
  	$query = mysql_query("SELECT * FROM `gs_coach_class` WHERE `id`='$classid'");
  	if(mysql_num_rows($query))
  	{
  		while($row = mysql_fetch_assoc($query))
  		{
          $data = $row;
  		}
  	
  	    return $data;
  	}
  	else
  	{
  		return 0;
    }
  	}

public function getClassFeeList($classid,$student_id)
{
	$query = mysql_query("SELECT * FROM `gs_feeslip` WHERE `userid`='$student_id' AND `classid`='$classid' ORDER BY `id` DESC");
	if(mysql_num_rows($query))
	{
		while ($row = mysql_fetch_assoc($query)) 
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
	

public function ViewClassData($classid,$student_id)
{
  $query = mysql_query("SELECT gs_coach_class.* , gs_class_data.*  FROM `gs_coach_class`  JOIN  gs_class_data ON`gs_class_data`.`classid`=`gs_coach_class`.id  WHERE `student_id` = '$student_id' AND `classid` = '$classid' ");
  if(mysql_num_rows($query))
  {
  	while( $row = mysql_fetch_assoc($query)) 
  	{
  		$data = $row;
  	}
  	return $data;
  }else
  {
  	return 0;
  }


}
}
?>