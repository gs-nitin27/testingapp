<?php 
class connect_userservice 
{
/**
     * function to check the existing user while registration
     * @param in variable $where
     * @return results data in array form on success and 0 on failure..
     * @access public  
     */ 
 
 public function connect_user_request($lite_user_id,$prof_user_id)
 {
   $query=mysql_query("INSERT INTO `gs_connect`(`lite_user_id`,`prof_user_id`,`req_status`,`date_created`) VALUES('$lite_user_id','$prof_user_id','0',CURDATE())");
     
     if($query)
     {
     	$data =mysql_insert_id();
     	return $data;



     }
     else 
     {
     	
     	  return 0 ;

     }
 }

 public function connect_user_response($id,$req_status)
 {
   
   if($req_status == 1)
   {
     $query = mysql_query("UPDATE `gs_connect` SET `req_status`= '1' WHERE `id`='$id'");
     if($query)
     {
     	return 1;
     }
     else
     {
     	return 2;
     }
    } 
    else
    {
      $query =mysql_query("DELETE FROM `gs_connect` WHERE `id` = '$id'");
      if($query)
      {
         return 3;
      }
      else
      {
        return 4;
      }
   }
 }

 public function alerts($userid,$user_app,$jsondata)
 {
 
  $query = mysql_query("INSERT INTO `gs_alerts`(`userid`,`user_app`,`alert_data`,`date_alerted`) VALUES('$userid','$user_app','$jsondata',CURDATE())");
  if($query)
  {
  	$data = mysql_insert_id();
  	return $data;
  }
  else
  {
  	return 0;
  }

 }

 public function getuserid($id)
 {
   $query = mysql_query("SELECT `lite_user_id` ,`prof_user_id`  FROM `gs_connect` WHERE 	`id`= '$id'");
   $row = mysql_num_rows($query);
   if($row)
   {
     while($data = mysql_fetch_assoc($query))
      {
      $result[] = $data;
      }
       
        return $result;
   }

 }


public function updateseennotification($id)
{

	$query = mysql_query("UPDATE `gs_alerts` SET `seen` = 1  WHERE `id` = '$id'");
	if($query)
	{
		return 1 ;
	}
	else
	{
		return 0;
	}
 }




/****************This Function Show Connected  Usrs **************/

public function getConnectedUser($userid,$usertype)
{
  if($usertype=='L')
  {
      $query = mysql_query("SELECT userid,name,email,sport,gender,dob,user_image,location,prof_id,prof_name FROM user WHERE userid IN (SELECT `prof_user_id` FROM `gs_connect` WHERE `lite_user_id`=$userid)");
    $num=mysql_num_rows($query);
    if ($num!=0) 
     {
          for ($i=0; $i <$num ; $i++) 
          {
            $row=mysql_fetch_assoc($query);
            $data[]=$row;
          }

    return $data;  
    }
    else
    {
     return 0;
    }
}


  if($usertype=='M')
  {
  $query = mysql_query(" SELECT `userid`,`name`,`sport`,`gender`,`prof_id`,`prof_name`,`user_image`,`location`,`age_group_coached`,`gs_connect`.`req_status` FROM `user` WHERE `userid` IN(SELECT `lite_user_id` FROM `gs_connect` WHERE `prof_user_id`=$userid AND `req_status`= 1) ");
  }
   $row = mysql_num_rows($query);
   if($row)
   {
     while($data = mysql_fetch_assoc($query))
      {
      $result[] = $data;

      }
      return $result;
   }
 }


/****************This Function Show Requested Users  **************/

 public function getRequestedUser($userid,$usertype)
 {
   if($usertype=='L')
    {
        $query = mysql_query("SELECT `userid`,`name`,`sport`,`gender`,`prof_id`,`prof_name`,`user_image`,`location`,`age_group_coached`,`gs_connect`.`req_status` FROM `user` WHERE `userid` IN(SELECT `prof_user_id` FROM `gs_connect` WHERE `lite_user_id`=$userid AND `req_status`= 0) ");
    }
    if($usertype=='M')
    {
    $query = mysql_query( "SELECT `userid`,`name`,`sport`,`gender`,`prof_id`,`prof_name`,`user_image`,`location`,`age_group_coached`,`gs_connect`.`req_status` FROM `user` WHERE `userid` IN(SELECT `lite_user_id` FROM `gs_connect` WHERE `prof_user_id`=$userid AND `req_status`= 0) ");
    }
   $row = mysql_num_rows($query);
   if($row)
   {
     while($data = mysql_fetch_assoc($query))
      {
      $result[] = $data;
      }
      return $result;
   }
 }




/********************* This Function are used to find Class and Timing of Student**********/

public function getClass($userid)
{
  // This is comment for some Time so Please add after coding is complite
// $query="SELECT CH.`userid`, CH.`id`, CH.`class_title`, CH.`class_start_timing`,CH.`class_end_timing`, CH.`class_start_date` ,CH.`class_end_date`,CH.`class_fee` ,CH.`class_strength` , COUNT(CL.`classid`) AS totalStudent FROM `gs_coach_class` AS CH , `gs_class_data` AS CL WHERE CH.`userid`=$userid AND CH.`id`=CL.`classid` GROUP BY CL.`classid`";die();

 $query= mysql_query("SELECT `id`, IFNull(`userid`,'') AS userid, IFNull(`class_title`,'') AS class_title ,IFNull(`description`,'') AS description,IFNull(`class_code`,'') AS class_code,IFNull(`class_start_timing`,'') AS class_start_timing,IFNull(`class_end_timing`,'') AS class_end_timing,IFNull(`class_start_date`,'') AS class_start_date,IFNull(`class_end_date`,'') AS class_end_date,IFNull(`class_host`,'') AS class_host,IFNull(`contact_no`,'') AS contact_no,IFNull(`class_fee`,'') AS class_fee,IFNull(`class_strength`,'') AS class_strength,IFNull(`venue`,'') AS venue,IFNull(`location`,'') AS location,IFNull(`date_created`,'') AS date_created,IFNull(`days`,'') AS days,IFNull(`age_group`,'') AS age_group ,IFNull(`duration`,'') AS duration  FROM `gs_coach_class` where `userid`=$userid");
 $num=mysql_num_rows($query);
  if ($num!=0) 
 {
      for ($i=0; $i <$num ; $i++) 
      {
        $row=mysql_fetch_assoc($query);
        $row['join_status']=0;
        $data[]=$row;
      }
return $data;  
}
else
{
 return 0;
}
}



/*********************This Function are used to find the Status is 1 or 0 *******************/


public function getConnectedStatus($response, $userid)
{
//echo "SELECT `prof_user_id`,req_status FROM `gs_connect` WHERE `lite_user_id`=$userid";die();

  $query= mysql_query("SELECT `prof_user_id`, `req_status` FROM `gs_connect` WHERE `lite_user_id`=$userid");
   $num=mysql_num_rows($query);
  if ($num!=0) 
  {
            for ($i=0; $i <$num ; $i++) 
            {
              $row=mysql_fetch_assoc($query);
              $data[]=$row;
            }
            for ($i=0; $i <$num ; $i++) 
            {
                if ($response[$i]['userid']==$data[$i]['prof_user_id'])
                {
                     $response[$i]['req_status']=$data[$i]['req_status'];
                }
                else
                {
                 $response[$i]['req_status']=$data[$i]['req_status'];
                }
            }
              return $response;  
  }
   else
  {
   return 0;
  }

}


/************ This Function are used to find Class  Informantion Created by Coach*******/


public function getClassInfo($class_id)
{
 $query= mysql_query("SELECT `id`, IFNull(`userid`,'') AS userid, IFNull(`class_title`,'') AS class_title ,IFNull(`description`,'') AS description,IFNull(`class_code`,'') AS class_code,IFNull(`class_start_timing`,'') AS class_start_timing,IFNull(`class_end_timing`,'') AS class_end_timing,IFNull(`class_start_date`,'') AS class_start_date,IFNull(`class_end_date`,'') AS class_end_date,IFNull(`class_host`,'') AS class_host,IFNull(`contact_no`,'') AS contact_no,IFNull(`class_fee`,'') AS class_fee,IFNull(`class_strength`,'') AS class_strength,IFNull(`venue`,'') AS venue,IFNull(`location`,'') AS location,IFNull(`date_created`,'') AS date_created,IFNull(`days`,'') AS days,IFNull(`age_group`,'') AS age_group  FROM `gs_coach_class` where `id` = $class_id ");
 $num=mysql_num_rows($query);
 if ($num!=0) 
 {
      for ($i=0; $i <$num ; $i++) 
      {
        $row=mysql_fetch_assoc($query);
        $data[]=$row;
      }
  return $data;  
  }
  else
  {
   return 0;
  }
}

/**************************************************************/

 public function getClassJoinStudent($response, $student_id)
 {
  $query= mysql_query("SELECT `classid` FROM `gs_class_data` WHERE `student_id`=$student_id");
  $num1 =mysql_num_rows($query);
  $num=count($response);
     if ($num!=0) 
     {             
              while($row = mysql_fetch_assoc($query))
              {
                 for ($i=0; $i < sizeof($response); $i++)
                  { 
                       if($row['classid'] == $response[$i]['id'])
                       {
                        $response[$i]['join_status'] = 1;
                        break;
                       }
                 }
            }
            return $response;
     }
    else
    {
        return 0;
    }
}
//End Function 

/************ This Function are used to Insert the Student Record*******/

public function joinStudentData($userdata)
{
  $classid           =  $userdata->classid;
  $student_id        =  $userdata->userid;
  $student_name      =  $userdata->student_name;
  $student_dob       =  $userdata->student_dob;
  $location          =  $userdata->location;
  $gender            =  $userdata->gender;
  $mode_of_payment   =  $userdata->mode_of_payment;
  if (empty($classid) || empty($student_id) || empty($student_name) || empty($student_dob) || empty($location) || empty($gender) || empty($mode_of_payment))
  {
    return 0;
  }
  else
  {
    $query= mysql_query("INSERT INTO gs_class_data(`id`,`classid`,`student_id`, `student_name`,`student_dob`,`location`,`gender`,`date_added`,`mode_of_payment`) VALUES('0','$classid','$student_id','$student_name ','$student_dob','$location','$gender',CURDATE(),'$mode_of_payment')");
  return 1;
  }

}



/********************This Function are used to find the Class informatino********************/

public function ClassInfo($student_id)
{
 $query= mysql_query("SELECT gs_class_data.* , gs_coach_class.* FROM gs_class_data INNER JOIN gs_coach_class ON `gs_class_data`.`classid`=`gs_coach_class`.id WHERE `student_id`=$student_id");
  $num=mysql_num_rows($query);
  if ($num!=0) 
  {
            for ($i=0; $i <$num ; $i++) 
            {
              $row=mysql_fetch_assoc($query);

             // $a= $row[$i]['classid'];
              $data[]   = $row ;
            }
        return $data;
  }
}



/************************Create Daily Log**************************************/

public function createdDailyLog($userdata)
{
  $userid           =  $userdata->userid;
  $activity         =  $userdata->activity;
  $unit             =  $userdata->unit;
  $volume           =  $userdata->volume;
  $date             =  $userdata->date;
if (empty($userid) || empty($activity) )
  {
    return 0;
  }
else
{
    $query= mysql_query("INSERT INTO gs_athlit_dailylog (`id`,`userid`,`activity`, `unit`,`volume`,`date`) VALUES ('0',' $userid','$activity ','$unit','$volume','$date')");
return 1;
}

} // End Function













} // End Class


