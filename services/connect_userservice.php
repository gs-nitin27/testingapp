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
  $query = mysql_query(" SELECT `userid`,`name`,`sport`,`gender`,`prof_id`,`prof_name`,`user_image`,`location`,`age_group_coached` FROM `user` WHERE `userid` IN(SELECT `lite_user_id` FROM `gs_connect` WHERE `prof_user_id`=$userid ) ");
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


public function getConnectedStatus($response,$userid,$usertype)
{
//print_r($response);
if ($usertype=='L')
{
 $query= mysql_query("SELECT `id`, `prof_user_id`, `req_status` FROM `gs_connect` WHERE lite_user_id =$userid");
    $filed =`lite_user_id`; 
}
else if ($usertype=='M')
{
   $query= mysql_query("SELECT `id`,`lite_user_id`, `req_status` FROM `gs_connect` WHERE prof_user_id =$userid");
}
    $num=mysql_num_rows($query);
  //   $data = [];
  if ($num!=0) 
  {
            for ($i=0; $i <$num ; $i++) 
            {
              $row=mysql_fetch_assoc($query);
              $data[]=$row;
            }
             // $num1=count($data);
            //  echo "$num1";die();
         // print_r($data);
           //print_r($response)       ;die();
             
            for ($i=0; $i <$num; $i++) 
            {   
                if (isset($data[$i]['prof_user_id']) && ($response[$i]['userid']==$data[$i]['prof_user_id']))
                {   
                     $response[$i]['req_status']=$data[$i]['req_status'];
                     $response[$i]['connection_id']=$data[$i]['id'];
                }
               else if (isset($data[$i]['lite_user_id']) && $response[$i]['userid']==$data[$i]['lite_user_id']) 
                {
                  $response[$i]['req_status']=$data[$i]['req_status'];
                  $response[$i]['connection_id']=$data[$i]['id'];
                }
                else
                {
                 $response[$i]['req_status']=$data[$i]['req_status'];
                 $response[$i]['connection_id']=$data[$i]['id'];
                }
            }
              return $response;  
  }
   else
  {
   return $data;
  }
}

/************ This Function are used to find Class  Informantion Created by Coach*******/


public function getClassInfo($class_id)
{
 $query= mysql_query("SELECT `id`, IFNull(`userid`,'') AS userid, IFNull(`class_title`,'') AS class_title ,IFNull(`description`,'') AS description,IFNull(`class_code`,'') AS class_code,IFNull(`class_start_timing`,'') AS class_start_timing,IFNull(`class_end_timing`,'') AS class_end_timing,IFNull(`class_start_date`,'') AS class_start_date,IFNull(`class_end_date`,'') AS class_end_date,IFNull(`class_host`,'') AS class_host,IFNull(`contact_no`,'') AS contact_no,IFNull(`class_fee`,'') AS class_fee,IFNull(`class_strength`,'') AS class_strength,IFNull(`venue`,'') AS venue,IFNull(`location`,'') AS location,IFNull(`date_created`,'') AS date_created,IFNull(`days`,'') AS days,IFNull(`age_group`,'') AS age_group ,IFNull(`duration`,'') AS duration FROM `gs_coach_class` where `id` = $class_id ");
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

/**************************************************************************************/

public function getConnect($student_id,$coach_id)
{
$query= mysql_query("SELECT *FROM `gs_connect` WHERE  `lite_user_id`='$student_id' AND `prof_user_id`='$coach_id'");
  $num =mysql_num_rows($query);
  if ($num>0)
  {
    while($row = mysql_fetch_assoc($query))
     {
       $data[] = $row;
      }
        return $data;
      //print_r($data);die();
  }
  else
  {
    return 0;
  }
}



/********************************************************************/
public function  alreadyStudent($student_id,$classid)
{
$query= mysql_query("SELECT `classid` FROM `gs_class_data` WHERE `student_id`='$student_id' AND `classid`='$classid'");
$num =mysql_num_rows($query);
    if ($num>0)
    {
    return 1;
    }
    else
    {
      return 0;
    }
}

/**************************************************************************************/


// public function getConnect($student_id,$coach_id)
// {
// $query= mysql_query("SELECT *FROM `gs_connect` WHERE  `lite_user_id`='$student_id' AND `prof_user_id`='$coach_id'");
//   $num =mysql_num_rows($query);
//   if ($num>0)
//   {
//     while($row = mysql_fetch_assoc($query))
//      {
//        $data[] = $row;
//       }
//         return $data;
//       //print_r($data);die();
//   }
//   else
//   {
//     return 0;
//   }
// }


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
  $fees              =  $userdata->fees;

   if (empty($classid) || empty($student_id) || empty($student_name) || empty($student_dob) || empty($location) || empty($gender) || empty($mode_of_payment) || empty($fees))
  {
    return 0;
  }
  else
  {
    $query= mysql_query("INSERT INTO gs_class_data(`id`,`classid`,`student_id`, `student_name`,`student_dob`,`location`,`gender`,`date_added`,`mode_of_payment`,`fees`) VALUES('0','$classid','$student_id','$student_name ','$student_dob','$location','$gender',CURDATE(),'$mode_of_payment','$fees')");
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
              $data[]   = $row ;
            }
        return $data;
  }
}


/************************Create Daily Log**************************************/

public function createdDailyLog($userdata)
{
  $userid           =  $userdata->userid;
  $phase            =  $userdata->phase;
  $activity         =  $userdata->activity;
  $duration         =  $userdata->duration;
  $distance         =  $userdata->distance;
  $performance      =  $userdata->performance;
  $remarks          =  $userdata->remarks;
  $date             =  $userdata->date;
  $reps             =  $userdata->reps;
        $query= mysql_query("INSERT INTO `gs_athlit_dailylog`(`id`,`userid`,`phase`,`activity`,`duration`, `distance`,`performance`,`remarks`,`date`,`repetition`,`dailylogstatus`) VALUES ('0',' $userid',' $phase','$activity ','$duration ','$distance','$performance','$remarks','$date','$reps','1')");
    if ($query)
     {
      return 1;
    }
    else
    {
      return 0;
    }


} // End Function


/*******************Function are used to View the Daily Log*****************/

public function viewDailyLog($userid)
{
     $query =mysql_query("SELECT *FROM `gs_athlit_dailylog`  WHERE userid = '$userid ' ORDER BY `date` DESC");
      $num = mysql_num_rows($query);
    if ($num!=0) 
    {    
           for ($i=0; $i <$num ; $i++) 
          {
            $row=mysql_fetch_assoc($query);
            $data[] = $row;
            
          }
          return $data;
    }
    else
    {
      return 0;
    }          
}

/***************************Paid and Unpaid***************************/

public function accounting($coach_id,$flag)
{

if ($flag==1)
{
  $query= mysql_query("SELECT gs_class_data.* , `gs_coach_class`.`class_title` FROM gs_class_data INNER JOIN gs_coach_class ON `gs_class_data`.`classid`=`gs_coach_class`.id WHERE `userid`=$coach_id  AND `gs_class_data`.`fees`=`gs_class_data`.`paid`");
 }
else
{
  $query= mysql_query("SELECT gs_class_data.* , `gs_coach_class`.`class_title` FROM gs_class_data INNER JOIN gs_coach_class ON `gs_class_data`.`classid`=`gs_coach_class`.id WHERE `userid`=$coach_id  AND `gs_class_data`.`fees`!=`gs_class_data`.`paid`");
 }
        $num=mysql_num_rows($query);
        if ($num!=0) 
        {
                   while($row=mysql_fetch_assoc($query))
                   {
                    
                     $data[]   = $row ;
                   }
                   return $data;
         }
         else
         {
           return 0;
         }
}

/*****************************Function for Paid Listing ********************/

public function studentPaidListing($class_id,$flag)
{
  if ($flag==1) 
  {
    $query= mysql_query("SELECT *FROM `gs_class_data`  WHERE `classid`='$class_id' AND `gs_class_data`.`fees`=`paid`");
  }
  else
  {
   $query= mysql_query("SELECT *FROM `gs_class_data`  WHERE `classid`='$class_id' AND `gs_class_data`.`fees`!=`paid`"); 
  }
  $num = mysql_num_rows($query);
  if ($num)
  {
     while($row=mysql_fetch_assoc($query))
                   {
                     $data[]   = $row ;
                   }
                   return $data;
  }
  else
  {
     return 0;
  }
}

/*****************************Function Create log ********************/
public function coach_log_assign($item)
{
 $insert  = mysql_query("INSERT `gs_coach_assignment`(`coach_id`,`phase`,`activity`,`target_duration`,`target_distance`,`target_performance`,`target_repetition`,`time_of_day`,`remarks`,`date`)  VALUES('$item->coach_id','$item->phase','$item->activity','$item->duration','$item->distance','$item->performance','$item->repetition','$item->time_of_day','$item->remark',CURDATE())");

 if($insert)
 {
  return 1;
 }
 else
 {
  return 0;
 }
}

/*****************************Function for log Listing ********************/
public function coach_log_list($coachid)
{
   $query = mysql_query("SELECT * FROM `gs_coach_assignment` WHERE `coach_id`='$coachid'");
    $num = mysql_num_rows($query);
  if ($num)
  {
     while($row=mysql_fetch_assoc($query))
                   {
                     $data[]   = $row ;
                   }
                   return $data;
  }
  else
  {
     return 0;
  }
}

/*****************************Function for student list based on classid Listing ********************/

public function studentlist($userid)
{

 $query = mysql_query("SELECT `gs_class_data`.* , `gs_coach_class`.`class_title` ,`user`.`user_image` FROM `gs_class_data` JOIN user ON `gs_class_data`.`student_id` = `user`.`userid`  JOIN gs_coach_class ON `gs_class_data`.`classid` = `gs_coach_class`.`id`  WHERE `gs_coach_class`.`userid` = '$userid'");


  // $query = mysql_query("SELECT * , `gs_coach_class`.`class_title` FROM `gs_class_data` WHERE `classid` IN (SELECT `id` ,`class_title` FROM `gs_coach_class` WHERE `userid` = '$userid')");

    $num = mysql_num_rows($query);
  if ($num)
  {
     while($row=mysql_fetch_assoc($query))
                   {
                       $date_1 = new DateTime($row['student_dob']);
                       $date_2 = new DateTime( date( 'd-m-Y' ));
                       $difference = $date_2->diff( $date_1 );
                       $year=(string)$difference->y;

                       $row['age'] = $year;

                       $data[]   = $row ;

                   }
                   return $data;
  }
  else
  {
     return 0;
  }

}

/********************Function for student list based on classid and gender Listing******************/

public function studentlistgender($userid,$gender)
{
 // $query = mysql_query("SELECT * FROM `gs_class_data` WHERE `classid`='$classid' AND `gender`='$gender'");
  $query = mysql_query("SELECT * FROM `gs_class_data` WHERE `gender` = '$gender' AND `classid` IN(SELECT `id` FROM `gs_coach_class` WHERE `userid` = '$userid') ");
  $num = mysql_num_rows($query);
  if ($num)
  {
     while($row=mysql_fetch_assoc($query))
                   {
                    
                     $data[]   = $row ;
                   }
                   return $data;
  }
  else
  {
     return 0;
  }
}


/*****************************Function for activity search  ********************/

public function search_activity()
{

  $query = mysql_query("SELECT DISTINCT(activity) FROM `gs_coach_assignment`");
  $num = mysql_num_rows($query);
  $data = [];
  if ($num)
  {
     while($row=mysql_fetch_assoc($query))
                   {
                     $data[]   = $row ;
                   }
                   return $data;
  }
  else
  {
     return 0;
  }
}
/********************* Assign log to athlete **********************************/

public function log_assign($studentid,$data)
{
      $phase     = $data[0]['phase'];
      $activity  = $data[0]['activity'];
      $id        = $data[0]['id'];
      $date      = $data[0]['date'];
      $remarks   = $data[0]['remarks'];

    $insert = mysql_query("INSERT `gs_athlit_dailylog`(`userid`,`phase`,`activity`,`remarks`,`coach_assignment_id`,`date`) VALUES('$studentid','$phase','$activity','$remarks','$id','$date')");
    if($insert)
    {
      return 1;
    }
    else
    {
      return 0;
    }    

}
/*******************Get log data  ********************/

public function logdata($logid)
{
  $query = mysql_query("SELECT * FROM `gs_coach_assignment` WHERE `id`='$logid'");
  $num = mysql_num_rows($query);
  if ($num)
  {
     while($row=mysql_fetch_assoc($query))
                   {
                     $data[]   = $row ;
                   }
                   return $data;
  }
  else
  {
     return 0;
  }
}

/*************************************View Log************************************/

public function  view_coach_log($coach_assignment_id)
{
 $query = mysql_query("SELECT * FROM `gs_coach_assignment` WHERE `id`='$coach_assignment_id' ");
  $num = mysql_num_rows($query);
  if ($num)
  {
     while($row=mysql_fetch_assoc($query))
                   {
                    
                     $data  = $row ;
                   }
                   return $data;
  }
  else
  {
     return 0;
  }
}


public function view_log_assign($log_id)
{
      $query = mysql_query("SELECT * FROM `user` WHERE `userid` IN (SELECT `userid` FROM `gs_athlit_dailylog` WHERE `coach_assignment_id` = '$log_id')");

  $num = mysql_num_rows($query);
  if ($num)
  {
     while($row=mysql_fetch_assoc($query))
                   {
                    
                     $data[]  = $row ;
                   }
                   return $data;
  }
  else
  {
     return 0;
  }

}

public function getClass_id($userid)
{
 $query= mysql_query("SELECT `id` FROM `gs_coach_class` where `userid`=$userid");
 $num=mysql_num_rows($query);
  if ($num!=0) 
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


public function updatelog($userdata)
{
  $id               =  $userdata->id;
  $phase            =  $userdata->phase;
  $activity         =  $userdata->activity;
  $duration         =  $userdata->duration;
  $distance         =  $userdata->distance;
  $performance      =  $userdata->performance;
  $remarks          =  $userdata->remarks;
  $reps             =  $userdata->reps;
              $query= mysql_query("UPDATE  `gs_athlit_dailylog` SET `phase`='$phase',`activity`='$activity',`duration`='duration' ,`distance`='$distance',`performance`='$performance',`remarks`='$remarks',`repetition`='$reps',`dailylogstatus`='1' WHERE `id`='$id' ");
  $num=mysql_affected_rows(); 
  if ($num>=1)
  {
    return 1;
  }
  else
  {
    return 0;
  }
} /// End Function

public function getage($age)
{
                 $date_1 = new DateTime($age);
                 $date_2 = new DateTime( date( 'd-m-Y' ));
                 $difference = $date_2->diff( $date_1 );
                 $year=(string)$difference->y;
                  return $year;

}



} // End Class


