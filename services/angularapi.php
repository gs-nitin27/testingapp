<?php 
class angularapi 
{
public function getContentInfo()
{
   $query = mysql_query("SELECT * FROM `cms_content`");
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


public function angulartest($username,$password)
{  //echo "SELECT  * FROM `user` WHERE `email` = '$username' AND `password` = '$password'";die;
  $query = mysql_query("SELECT  * FROM `user` WHERE `email` = '$username' AND `password` = '$password'");
       
        if(mysql_num_rows($query)>0)
          {
            while($row = mysql_fetch_assoc($query))
            {   
               //$data1= $row; 
               $data['Name'] = $row['name'];
               $data['userType'] = $row['userType'];
               $data['prof_id'] =  $row['prof_id'];
               $data['contact_no']     =  $row['contact_no'];
               $data['prof_name'] =$row['prof_name'];
               $data['userId'] = $row['userid'];
               $data['email'] =$row['email'];
               $data['forget_code'] = $row['forget_code'];
               $data['user_image'] =$row['user_image']; 
               if($row['prof_id'])
               {
                $data['first'] = '0';
               }
               else
               {
                $data['first'] = '1';
               }
               
               return $data;
             }
           }
            else
            {
               return 0;
            } 
}

public function getEmailid($userid)
{
  $query = mysql_query("SELECT `email` FROM `user` WHERE `userid` = '$userid' ");
  if(mysql_num_rows($query)>0)
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

public function getorgdetails($userid)
{ 

   $query = mysql_query("SELECT * FROM `gs_org` WHERE `userid` = '$userid'");
   if(mysql_num_rows($query)>0)
   {
    while ($row = mysql_fetch_assoc($query)) 
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
public function AthletedashboardData($userid)
{
  $query = mysql_query("SELECT * FROM `user` WHERE `userid` = '$userid'");
  if(mysql_num_rows($query)>0)
  {
    while ($row = mysql_fetch_assoc($query)) 
    {
      $data = $row;
    }
    return $data;
  }else
  {
    return 0;
  }

}
public function mobileVerify($mobile,$userid,$forget_code)
{
   $insert = mysql_query("UPDATE `user` SET  `contact_no` = '$mobile' , `forget_code` = '$forget_code' WHERE `userid` ='$userid'");
   if($insert)
   {
     return 1;
   }
   else
   {
    return 0 ;
   }
}

public function OTPVerify($otpcode,$userid)
{
  $insert = mysql_query("UPDATE `user` SET  `forget_code` = ''  WHERE `userid` ='$userid' AND `forget_code` ='$otpcode'");
  $num = mysql_affected_rows();
  if($num)
  {
     return 1;
  }
  else
  {
    return 0 ;
  }
}

public function socialLogin($email,$password,$name,$forget_code,$image,$userType,$prof_id,$prof_name)
{   
  $insert = mysql_query("INSERT INTO `user`(`email`,`password`,`name`,`userType`,`prof_id`,`prof_name`,`forget_code`,`user_image`) VALUES('$email','$password','$name','$userType','$prof_id','$prof_name','$forget_code','$image')");
   if($insert)
   {
      $data['Name'] = $name;
      $data['userType'] = $userType;
      $data['prof_id'] =  $prof_id;
      $data['name']     = $name;
      $data['forget_code'] = $forget_code;
      $data['prof_name'] = $prof_name;
      $data['userId'] = mysql_insert_id();
      $data['email'] =$email;
      $data['user_image'] =$image; 
      $data['first'] = '1';
      return $data;
   } 
   else
   {
    return 0;
   }
}

public function profiledata($userid)
{
  $query = mysql_query("SELECT  * FROM `user` WHERE `userid` = '$userid'");
          if(mysql_num_rows($query)>0)
          {
            while($row = mysql_fetch_assoc($query))
            {   
               //$data1= $row; 
               $data[] = $row;
               return $data;
             }
           }
            else
            {
               return 0;
            } 
}

public function getContent($userid)
{
   $query = mysql_query("SELECT * FROM `cms_content` WHERE `userid` = '$userid'");
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

public function getuserevent($userid)
{
  $query = mysql_query("SELECT `id`,`userid`,`name`,`location`,`sport_name` FROM `gs_eventinfo` WHERE `userid` = '$userid'");
  $row = mysql_num_rows($query);
  if($row)
  {
   while ($data = mysql_fetch_assoc($query)) 
   {
     $result[] = $data;
   }
     return $result;
  }
}

public function getuserdashboardevent($userid)
{
$query = mysql_query("SELECT * FROM `gs_eventinfo` WHERE `userid` = '$userid' ORDER BY id DESC");

  $row = mysql_num_rows($query);
  if($row)
  {
   while ($data = mysql_fetch_assoc($query)) 
   {
     $result[] = $data;
   }
     return $result;
  }
}


public function getjoblist($userid)
{
  $query = mysql_query("SELECT `id`,`userid`,`title`,`description`,`sport`,`job_link`,`image`,`location` ,`publish`,`org_city` FROM `gs_jobInfo` WHERE `userid` = '$userid' ORDER BY id DESC");
  $row = mysql_num_rows($query);
  if($row)
  {
        while($data = mysql_fetch_assoc($query))
        {
          $result [] = $data;
        }
        return $result;
  }else
  {
    return 0;
  }
}



public function profile_data_update($userid,$prof_id,$profliedata)
{
  $insert = mysql_query("INSERT INTO `gs_userdata`(`userid`,`prof_id`,`user_detail`,`created_date`) VALUES('$userid','$prof_id','$profliedata',CURDATE())  ON DUPLICATE KEY UPDATE `user_detail` = '$profliedata', `updated_date` = CURDATE()");
  if($insert)
  {
    return 1;
  }else
  {
    return 0;
  }
}

public function createcontent($item)
{
   // print_r($item);die;
   $insert = mysql_query("INSERT INTO `cms_content`(`id`,`userid`,`title`,`content`,`url`,`date_created`,`date_updated`,`publish`) VALUES('$item->id','$item->userid','$item->title','$item->content','$item->url',CURDATE(),CURDATE(),'$item->publish')");
   if($insert)
   {
    return mysql_insert_id();
   } 
   else
   {
    return 0;
   }


}



public function createevent($item)
{  
if($item->start_date)
{
$start_date = date("Y-m-d", strtotime($item->start_date));
}else
{
  $start_date = "";
}
if($item->end_date)
{
$end_date = date("Y-m-d", strtotime($item->end_date));
}
else
{
  $end_date = ""; 
}

   $insert = mysql_query("INSERT INTO `gs_eventinfo`(`id`, `userid`,`name`, `type`, `address_1`,`location`,`state` ,`description`,`sport_name`,`eligibility1`, `terms_cond1`,`mobile` ,`event_links`, `start_date`, `end_date`, `email_app_collection`,`dateCreated`,`ticket_detail`,`image`) VALUES ('$item->id','$item->userid','$item->name', '$item->type','$item->address_1','$item->location','$item->state','$item->description','$item->sport_name','$item->eligibility1','$item->tandc1','$item->mobile','$item->event_links','$start_date','$end_date','$item->email_app_collection',CURDATE(),'$item->ticket_detail','$item->image') ON DUPLICATE KEY UPDATE `name`='$item->name',`type`='$item->type',`address_1` = '$item->address_1', `location`='$item->location', `state` = '$item->state' , `description` = '$item->description' , `sport_name`='$item->sport_name', `eligibility1` = '$item->eligibility1' , `terms_cond1` = '$item->tandc1' , `mobile` = '$item->mobile' , `event_links` = '$item->event_links' , `start_date` = '$start_date' , `end_date` = '$end_date' , `email_app_collection` = '$item->email_app_collection' ,`ticket_detail` = '$item->ticket_detail' ,`image` =  '$item->image' ");
   if($insert)
   {
    return mysql_insert_id();
   } 
   else
   {
    return 0;
   }
}

public function userdata($id)
    {
    
       $query  = mysql_query("SELECT `userid`,`userType`,`status`,`name`,`email`,`contact_no`,`sport`,`gender`,`dob`,`prof_name`,`user_image`,`location`,`link`,`age_group_coached`,`languages_known` FROM `user` where `userid` = '$id'");
       if(mysql_num_rows($query)>0)
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


  public function geteventdetails($id)
  {
    $query = mysql_query("SELECT * FROM `gs_eventinfo` WHERE `id` = '$id'");
    if(mysql_num_rows($query))
    {
       while ($row = mysql_fetch_assoc($query)) {

         $data = $row;
       }
    return $data;
    }
    else
    {
      return 0;
    }


  }  

public function getjobdetails($id)
{
  $query = mysql_query("SELECT * FROM `gs_jobInfo` WHERE `id` = '$id'");
  if(mysql_num_rows($query))
  {
   while( $row = mysql_fetch_assoc($query))
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

public function listuserdata($userid)
    {
      
       $query  = mysql_query("SELECT `user_detail` FROM `gs_userdata` where `userid` = '$userid'");
       if(mysql_num_rows($query)>0)
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


public function participantList($event_id)
{
  $query = mysql_query("SELECT `userid`,`prof_id`,`name`,`email`,`location`,`gender`,`contact_no`,`dob`,  `user_image`,`prof_name` FROM `user` WHERE `userid` IN ( SELECT `userid` FROM `user_events` WHERE `userevent` = '$event_id' )");
  if(mysql_num_rows($query)>0)
  {
   while ($row = mysql_fetch_assoc($query)) {
     $data[] = $row;
   }
   return $data;

  }else {
  return 0;
}
}


public function jobapplyUser($jobid)
{
 $query = mysql_query("SELECT `user`.`userid`,`user`.`prof_id`,`user`.`name`,`user`.`email`,`user`.`location`,`user`.`gender`,`user`.`contact_no`,`user`.`dob`, `user`.`user_image`,`user`.`prof_name` , `user_jobs`.`id`, `user_jobs`.`status`,`user_jobs`.`interview_date` FROM `user` JOIN `user_jobs` ON `user`.`userid` = `user_jobs`.`userid` AND `user_jobs`.`id` IN (SELECT `id` FROM `user_jobs` WHERE `userjob` = '$jobid')");
  if(mysql_num_rows($query)>0)
  {
   while ($row = mysql_fetch_assoc($query)) {
     $data[] = $row;
   }
   return $data;

  }else {
  return 0;
}

}

public function createjob($item)
{

$insert = mysql_query("INSERT INTO `gs_jobInfo`(`id`,`userid`,`title`,`location`,`gender`,`sport`,`type`,`job_link`,`work_experience`,`description`,`key_requirement`,`org_address1`,`org_address2`,`org_city`,`org_state`,`org_pin`,`organisation_name`,`qualification`,`address1`,`address2`,`state`,`pin`,`contact`,`email`,`image`,`about`,`desired_skills`,`date_created`,`is_native`)  VALUES ('$item->id','$item->userid','$item->title','$item->location','$item->gender','$item->sport','$item->type','$item->job_link','$item->work_experience','$item->description','$item->key_requirement','$item->org_address1','$item->org_address2','$item->org_city','$item->org_state','$item->org_pin','$item->organisation_name','$item->qualification','$item->address1','$item->address2','$item->state','$item->pin','$item->contact','$item->email','$item->image','$item->about','$item->desired_skills',CURDATE(),'1') ON DUPLICATE KEY UPDATE `title` = '$item->title' , `location` = '$item->location' , `gender` = '$item->gender',`sport` = '$item->sport' , `type` = '$item->type',`job_link` = '$item->job_link' , `work_experience` = '$item->work_experience' , `description` = '$item->description' , `key_requirement` = '$item->key_requirement' , `org_address1` = '$item->org_address1' , `org_address2` = '$item->org_address2' , `org_city` = '$item->org_city' , `org_state` = '$item->org_state' , `org_pin` = '$item->org_pin' , `organisation_name` = '$item->organisation_name' , `qualification` = '$item->qualification' ,`address1` = '$item->address1' , `address2` = '$item->address2' , `state` = '$item->state', `pin` = '$item->pin' , `contact` = '$item->contact' , `email` = '$item->email',`image` = '$item->image',`about` = '$item->about',`desired_skills` = '$item->desired_skills'");

  if($insert)
  {
   return mysql_insert_id();
  }
  else
  {
    return 0;
  }

}

public function publishjob($jobid,$publish)
{
  $insert = mysql_query("UPDATE  `gs_jobInfo` SET `publish` = '$publish' WHERE `id` = '$jobid'");
  $tes = mysql_affected_rows();

  if($tes)
  {
    return $tes;

  }else{
    return 0;
  }

} 

public function registration($item)
{
$query= mysql_query("UPDATE  `user` SET `name` ='$item->name',`contact_no`='$item->phone_no',`gender`='$item->gender',`prof_id`='$item->prof_id',`prof_name`='$item->prof_name',`dob`='$item->dob',`sport`='$item->sport',`userType`='$item->userType', `forget_code`='$item->forget_code',`access_module`='$item->access_module' WHERE `userid`='$item->userid'");
$tes = mysql_affected_rows();
if($tes)
  {
  $sel = "SELECT `userid`, `userType`, `status`, `name`, `email`, `contact_no`, `sport`, `gender`, `dob`, `prof_id`, `prof_name`, `user_image`, `location`, `device_id`, `date_created`, `date_updated`, `m_device_id`, `M_fb_id`, `L_fb_id`,`google_id` FROM `user` WHERE `userid`='$item->userid'";
  //echo $query;die;
  $sql = mysql_query($sel);
  if(mysql_num_rows($sql)>0)
  {
    return mysql_fetch_assoc($sql);
  }
  //  return $item->prof_id;

  }
  else
  {
    return 0;
  }
}

public function addOrg($item)
{ 
  if($item->id == 0)
    {
       $update = '';  
    }
    else
    { 
      $update = "ON DUPLICATE KEY UPDATE `org_name`='$item->org_name',`about` = '$item->about',`address1`='$item->address1',`address2` = '$item->address1',`city`='$item->city',`state`='$item->state',`pin`='$item->pin',`mobile`='$item->mobile',`email`='$item->email',`gstin`='$item->gstin'";
    }
  $query = mysql_query("INSERT INTO `gs_org`(`userid`,`org_name`,`about`,`address1`,`address2`,`city`,`state`,`pin`,`mobile`,`email`,`gstin`) VALUES('$item->userid','$item->org_name','$item->about','$item->address1','$item->address2','$item->city','$item->state','$item->pin','$item->mobile','$item->email','$item->gstin')".$update);
  if($query)
  {
    return 1;
  }
  else
  {
    return 0;
  }
}

public function callforshortlist($userid,$jobid)
{

  $query = mysql_query("UPDATE `user_jobs` SET `status` = '2' WHERE `userid` = '$userid' AND `userjob` = '$jobid'");
  $num = mysql_affected_rows();
  if($num)
  {
     return 1;
  }
  else
  {
    return 0 ;
  }


}

// public function job_apply_userlist($jobid)
// {
//    $query = mysql_query("SELECT `userid` , `name` , `email` ,`contact_no`,`sport`,`gender`,`user_image` FROM `user` WHERE `userid` IN (SELECT `userid` FROM `user_jobs` WHERE `userjob` = '$jobid') ");

//    if(mysql_num_rows($query))
//    {
//     while ($row = mysql_fetch_assoc($query)) 
//     {
//       $data[] = $row;
//     }
//     return $data;
//    }
//    else
//    {
//     return 0;
//    }
   

// }

}

?>