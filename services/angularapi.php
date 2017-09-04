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
{
  $query = mysql_query("SELECT  * FROM `user` WHERE `email` = '$username' AND `password` = '$password'");
       
        if($query)
          {
            while($row = mysql_fetch_assoc($query))
            {   
               //$data1= $row; 
               $data['Name'] = $row['name'];
               $data['userType'] = $row['userType'];
               $data['prof_id'] =  $row['prof_id'];
               $data['contact_no']     =  $row['contact_no'];
               $data['password'] =$row['password'];
               $data['userId'] = $row['userid'];
               $data['email'] =$row['email'];
               $data['forget_code'] = $row['forget_code'];
               $data['user_image'] =$row['user_image']; 
               return $data;
             }
           }
            else
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

public function socialLogin($email,$password,$name,$forget_code,$image)
{   
  $insert = mysql_query("INSERT INTO `user`(`email`,`password`,`name`,`userType`,`prof_id`,`forget_code`,`user_image`) VALUES('$email','$password','$name','104','1','$forget_code','$image')");
   if($insert)
   {

      $data['Name'] = $name;
      $data['userType'] = "104";
      $data['prof_id'] =  "1";
      $data['name']     = $name;
      $data['forget_code'] = $forget_code;
      $data['password'] =$password;
      $data['userId'] = mysql_insert_id();
      $data['email'] =$email;
      $data['user_image'] =$image; 
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
          if($query)
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
  $query = mysql_query("SELECT `id`,`userid`,`title`,`description`,`sport`,`job_link`,`image` FROM `gs_jobinfo` WHERE `userid` = '$userid' ORDER BY id DESC");
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
  $query = mysql_query("SELECT * FROM `gs_jobinfo` WHERE `id` = '$id'");
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
 $query = mysql_query("SELECT `userid`,`prof_id`,`name`,`email`,`location`,`gender`,`contact_no`,`dob`,  `user_image`,`prof_name` FROM `user` WHERE `userid` IN ( SELECT `userid` FROM `user_jobs` WHERE `userjob` = '$jobid' )");
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

$insert = mysql_query("INSERT INTO `gs_jobinfo`(`id`,`userid`,`title`,`location`,`gender`,`sport`,`type`,`job_link`,`work_experience`,`description`,`key_requirement`,`org_address1`,`org_address2`,`org_city`,`org_state`,`org_pin`,`organisation_name`,`qualification`,`address1`,`address2`,`state`,`pin`,`contact`,`email`,`image`,`about`,`desired_skills`,`date_created`)  VALUES ('$item->id','$item->userid','$item->title','$item->location','$item->gender','$item->sport','$item->type','$item->job_link','$item->work_experience','$item->description','$item->key_requirement','$item->org_address1','$item->org_address2','$item->org_city','$item->org_state','$item->org_pin','$item->organisation_name','$item->qualification','$item->address1','$item->address2','$item->state','$item->pin','$item->contact','$item->email','$item->image','$item->about','$item->desired_skills',CURDATE()) ON DUPLICATE KEY UPDATE `title` = '$item->title' , `location` = '$item->location' , `gender` = '$item->gender',`sport` = '$item->sport' , `type` = '$item->type',`job_link` = '$item->job_link' , `work_experience` = '$item->work_experience' , `description` = '$item->description' , `key_requirement` = '$item->key_requirement' , `org_address1` = '$item->org_address1' , `org_address2` = '$item->org_address2' , `org_city` = '$item->org_city' , `org_state` = '$item->org_state' , `org_pin` = '$item->org_pin' , `organisation_name` = '$item->organisation_name' , `qualification` = '$item->qualification' ,`address1` = '$item->address1' , `address2` = '$item->address2' , `state` = '$item->state', `pin` = '$item->pin' , `contact` = '$item->contact' , `email` = '$item->email',`image` = '$item->image',`about` = '$item->about',`desired_skills` = '$item->desired_skills'");

  if($insert)
  {
   return mysql_insert_id();
  }
  else
  {
    return 0;
  }

}
}

?>