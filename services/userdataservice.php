<?php 
 class userdataservice 
{
/**
     * function to check the existing user while registration
     * @param in variable $where
     * @return results data in array form on success and 0 on failure..
     * @access public  
     */ 
public function userVarify($where)
{


//echo "SELECT `userid`, `name`, `prof_id` FROM `user` ".$where;die();
$query  = $query  = mysql_query("SELECT *FROM `user` $where");
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


// When the user is singn In using the Google and Facebook then change the Image URL

public function updateimage($email,$user_image)
{
  //echo "dev kumar";
$query = mysql_query("UPDATE `user` SET `user_image` = '$user_image' WHERE `email` = '$email' ");
if($query)
{
  return 1;
}
else 
{
return 0;
}

}







/*
| this function are used to signup the New User in Getsporty Lite 
| when the user is Login[First Time] Using the google or facebook then this function are excute it 
| becuse this code are store the Information of User


*/
public function UserSignup($data)
{
 // print_r($data);die();
$name               =  $data->name;
$email              =  $data->email;
$password           =  $data->password;
$device_id          =  $data->device_id;
$userType           =  $data->usertype;
$logintype          =  $data->logintype;
$password1          =  md5($password);
$user_image         =  $data->user_image;
    if($logintype ==2 || $logintype==3)
     {
           $status=1;   // The Status set 1 becuse these User is Signup using Google and Facebook
     }
     else
     {
            $status=0;
     }
    
       $query =mysql_query("INSERT INTO `user`(`userid`,`userType`,`name`, `email`, `password`,`device_id`,`status`,`user_image`) VALUES('','$userType','$name','$email','$password1','$device_id',' $status','$user_image')");
       if($query)
       {
             $id = mysql_insert_id();
             if($id!=NULL)
              {
                 $data1 = $this->userdata($id);
              }
              return $data1;
        } 
        else
        {    
            return 0;
        }  
        
} // End Funtction 



/*
| This function are used to Login using the GetsportyLite|
|
*/




  /***************************Login***************************/

  public function gsSignIn($email,$password1)
    {
      $query = mysql_query("SELECT  *FROM `user` WHERE `email` = '$email' AND `password` = '$password1'");
          if($query)
          {
            while($row = mysql_fetch_assoc($query))
            {   
               $data1= $row; 
               return $data1;
             }
           }
            else
            {
               return 0;
            }
    } // end function



// This function are use to get the all Information from the User Table

/***************************************************************************/

    public function userdata($id)
    {
       $query  = mysql_query("SELECT *FROM `user` where `userid` = '$id'");
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





































/**

     * function For User Registration
 
     * @param in variable in $data array
     
     * @return results 1 on success and 0 on failure..

     * @access public  

     */ 
public function createUser($data)
{
$name     =  $data['name'];
$email    =  $data['email'];
$password =  $data['password'];
$phone    =  $data['phone'];
$gender   =  $data['gender'];
$prof     =  $data['prof'];
$sport    =  $data['sport'];
$location =  $data['location'];
$token    =  $data['token'];

$query = mysql_query("INSERT into `user`(`name`,`email`,`password`,`contact_no`,`Gender`,`prof_id`,`sport`,`location`,`device_id`) values('$name','$email','$password','$phone','$gender','$prof','$sport','$location','$token')");

if($query)
{

  return 1;

}
else
  
  return 0;

}
 
/**

     * function For fetching Device token id to send GCM message
 
     * @param $id in variable 
     
     * @return results data  on success and 0 on failure..

     * @access public  

     */ 

/*************************New Device id find**********************************/
public function getdeviceid($id)
{
  $query = mysql_query("SELECT `name`,`device_id` FROM `user` WHERE `userid` = '$id' ");
  $row = mysql_num_rows($query);
  if($row == 1)
  {
      while($data = mysql_fetch_assoc($query))
      {
      $dev = $data;
      }
        return $dev;
       
  }
  else 
  {
      return 0;
  }

}


/**********************************************************************/






/*****************Old Device Id Find code***********************************/
// public function getdeviceid($id)
// {
// //echo "SELECT `name`,`device_id` FROM `user` WHERE `userid` = '$id' ";die();
// $query = mysql_query("SELECT `name`,`device_id` FROM `user` WHERE `userid` = '$id' ");
// $row = mysql_num_rows($query);
// if($row == 1)
// {

// while($data = mysql_fetch_assoc($query))
// {

// $dev = $data;
// }
// //if($dev['device_id'] != "")
// return $dev;
// else 
// return 0;
// }

// }
// else return 0;


// }

/****************************************************************************************/
/**

     * function For fetching Device token id to send GCM message
 
     * @param $id in variable 
     
     * @return results data  on success and 0 on failure..

     * @access public  

     */ 



public function getEmpdeviceid($id)
{

$query = mysql_query("SELECT ji.`userid` , us.`device_id` , us.`email`FROM `gs_jobInfo` AS ji LEFT JOIN `user` AS us ON ji.`userid` = us.`userid` WHERE ji.`id` = '$id'");
if(mysql_num_rows($query)>0)
{

while($row = mysql_fetch_assoc($query))
{

$data = $row;

}

return $data;
}
else 
  return 0;

}

/**

     * function For updating Device token id While user login
 
     * @param token ,email in variable 
     
     * @return results data  on success and 0 on failure..

     * @access public  

     */ 

public function updatedevice($token ,$email)
{

//echo "UPDATE `user` SET `device_id` = '$token' WHERE `email` = '$email' ";//die;
$query = mysql_query("UPDATE `user` SET `device_id` = '$token' WHERE `email` = '$email' ");
if($query)
{
  return 1;
}
else 
return 0;
}




public function create_job($item)
{

$image =$item->image;
$query = mysql_query("INSERT INTO `gs_jobInfo`(`id`, `userid`, `title`,`sport`,`gender`, `type`, `work_experience`, `description`, `desired_skills`, `qualification`, `key_requirement`, `org_address1`, `org_address2`, `org_city`, `org_state`, `org_pin`, `organisation_name`, `about`, `address1`, `address2`, `state`, `city`, `pin`, `name`, `contact`, `email`, `date_created`) VALUES ('$item->id','$item->userid','$item->title','$item->sports','$item->gender','$item->type','$item->work_exp','$item->desc','$item->desiredskill','$item->qualification','$item->keyreq','$item->org_address1','$item->org_address2','$item->org_city','$item->org_state','$item->org_pin','$item->org_name','$item->about','$item->address1','$item->address2','$item->state','$item->city','$item->pin','$item->name','$item->contact','$item->email',CURDATE()) ON DUPLICATE KEY UPDATE `title` ='$item->title' , `sport` = '$item->sports',`gender` = '$item->gender' ,`type` = '$item->type' , `work_experience` = '$item->work_exp' , `description` = '$item->desc' , `desired_skills` = '$item->desiredskill' , `qualification` = '$item->qualification' , `key_requirement` = '$item->keyreq' , `organisation_name` = '$item->org_name' , `about` = '$item->about' ,`name` = '$item->name' , `contact` = '$item->contact' , `email` = '$item->email' , `date_created` = CURDATE(), `org_address1` = '$item->org_address1',`org_address2` = '$item->org_address2',`org_city` = '$item->org_city' , `org_pin` = '$item->org_pin' , `org_state`= '$item->org_state' , `address1`= '$item->address1' , `address2` = '$item->address2' , `city` = '$item->city' , `state` = '$item->state' , `pin` = '$item->pin'");
 
 if($query)
        { 
          $id = mysql_insert_id();
          if($id!=NULL && $image!=NULL)
          {
           $image = $this->imageupload($image,$id);
          }
        return 1;
        }
        else
          {
            return 0;
          }
}





/***********************************Create Tournament Function****************/


public function create_tournament($item)
{
  //print_r($item);die();

$query = mysql_query("INSERT INTO `gs_tournament_info`(`id`, `userid`, `name`, `address_1`, `address_2`, `location`,`state`, `pin`, `description`,`sport` ,`level`, `age_group`, `gender`, `eligibility1`,`eligibility2`, `terms_and_cond1`,`organiser_name`, `mobile`, `landline`, `email`, `org_address1`, `org_address2`, `org_city`, `org_pin`, `tournaments_link`, `start_date`, `end_date`, `event_entry_date`, `event_end_date`, `file_name`, `file`, `email_app_collection`, `phone_app_collection`,`date_created`) VALUES ('$item->id','$item->userid','$item->tournament_name','$item->address_line1','$item->address_line2','$item->city','$item->state','$item->pin','$item->description','$item->sport','$item->tournament_level','$item->tournament_ageGroup','$item->gender','$item->eligibility1','$item->eligibility2','$item->terms_and_conditions1','$item->organizer_name','$item->mobile','$item->landline','$item->emailid','$item->organizer_address_line1','$item->organizer_address_line2','$item->organizer_city','$item->organizer_pin','$item->tournament_links',FROM_UNIXTIME ('$item->start_date'),FROM_UNIXTIME ('$item->end_date'),FROM_UNIXTIME('$item->entry_start_date') ,FROM_UNIXTIME ('$item->entry_end_date'),'$item->file_name','$item->file','$item->email_app_collection','$item->phone_app_collection',CURDATE()) ON DUPLICATE KEY UPDATE `name` = '$item->tournament_name', `address_1` = '$item->address_line1' , `address_2` = '$item->address_line2' , `location` = '$item->city' ,`state`='$item->state' ,`pin` = '$item->pin' , `description` = '$item->description',`sport`='$item->sport',`level` = '$item->tournament_level',`age_group`='$item->tournament_ageGroup',`gender` = '$item->gender',`eligibility1` = '$item->eligibility1' ,`eligibility2` = '$item->eligibility2', `terms_and_cond1` = '$item->terms_and_conditions1',`organiser_name` = '$item->organizer_name' , `mobile` = '$item->mobile' ,`landline` = '$item->landline' , `email` = '$item->emailid' , `org_address1` = '$item->organizer_address_line1' , `org_address2` = '$item->organizer_address_line2' , `org_city` = '$item->organizer_city', `org_pin` = '$item->organizer_pin' , `tournaments_link` = '$item->tournament_links' ,`start_date` = FROM_UNIXTIME ('$item->start_date') , `end_date` = FROM_UNIXTIME ('$item->end_date') , `event_entry_date` = FROM_UNIXTIME ('$item->entry_start_date') , `event_end_date` = FROM_UNIXTIME ('$item->entry_end_date'), `file_name` = '$item->file_name' , `file` = '$item->file' , `email_app_collection` = '$item->email_app_collection' , `phone_app_collection` = '$item->phone_app_collection'");

if($query){


  return true;
}else
  return false;


}

public function create_event($item)
{

$query = mysql_query("INSERT INTO `gs_eventinfo`(`id`, `userid`, `type`,`name`,`address_1`, `address_2`, `location`, `PIN`,`state` ,`description`, `sport`,`eligibility1`, `terms_cond1`,`organizer_name`, `mobile`,`organizer_address_line1`, `organizer_address_line2`, `organizer_city`, `organizer_pin`,`organizer_state` ,`event_links`, `start_date`, `end_date`, `entry_start_date`, `entry_end_date`, `file_name`, `file`, `email_app_collection`, `dateCreated`) VALUES ('$item->id','$item->userid','$item->type','$item->name','$item->address1','$item->address2','$item->city','$item->pin','$item->state','$item->description','$item->sport','$item->eligibility1','$item->tandc1','$item->organizer_name','$item->mobile','$item->org_address1','$item->org_address2','$item->organizer_city','$item->organizer_pin','$item->organizer_state','$item->event_links',FROM_UNIXTIME ('$item->start_date'),FROM_UNIXTIME ('$item->end_date'),FROM_UNIXTIME ('$item->entry_start_date'),FROM_UNIXTIME ('$item->entry_end_date'),'$item->file_name','$item->file','$item->email_app_collection',CURDATE()) ON DUPLICATE KEY UPDATE `type` = '$item->type',`name` = '$item->name' ,`address_1` = '$item->address1' ,`address_2` = '$item->address2' ,`location` = '$item->city' ,`state` = '$item->state', `PIN` = '$item->pin' , `description` = '$item->description',`sport` = '$item->sport',`eligibility1` = '$item->eligibility1', `terms_cond1` = '$item->tandc1',`organizer_name` = '$item->organizer_name' ,  `mobile` ='$item->mobile' ,`organizer_address_line1` = '$item->org_address1' , `organizer_address_line2` = '$item->org_address2' , `organizer_city` = '$item->organizer_city' , `organizer_pin` = '$item->organizer_pin', `organizer_state` = '$item->organizer_state' ,  `event_links` = '$item->event_links' , `start_date` = FROM_UNIXTIME ('$item->start_date') ,`end_date` = FROM_UNIXTIME ('$item->end_date') ,  `entry_start_date` = FROM_UNIXTIME ('$item->entry_start_date') , `entry_end_date` = FROM_UNIXTIME ('$item->entry_end_date') , `file_name` = '$item->file_name' ,`file` = '$item->file', `email_app_collection` = '$item->email_app_collection'");

if($query)
  return true;
else
  return false;
}


public function getCreation($where , $type)
{

if($type == 1)
{


$query = mysql_query("SELECT `id`, IFNull(`userid`,'') AS userid, IFNull(`title`,'') AS title, IFNull(`location`,'') AS location, IFNull(`gender`,'') AS gender, IFNull(`sport`,'') AS sport, IFNull(`type`,'') AS type, IFNull(`work_experience`,'') AS work_experience, IFNull(`description`,'') AS description, IFNull(`desired_skills`,'') AS desired_skills, IFNull(`qualification`,'') AS qualification, IFNull(`key_requirement`,'') AS key_requirement, IFNull(`org_address1`,'') AS org_address1, IFNull(`org_address2`,'') AS org_address2, IFNull(`org_city`,'') AS org_city, IFNull(`org_state`,'') AS org_state,IFNull(`org_pin`,'') AS org_pin, IFNull(`organisation_name`,'') AS organisation_name, IFNull(`about`,'') AS about, IFNull(`address1`,'') AS address1, IFNull(`address2`,'') AS address2, IFNull(`state`,'') AS state, IFNull(`city`,'') AS city, IFNull(`pin`,'') AS pin, IFNull(`name`,'') AS name, IFNull(`contact`,'') AS contact, IFNull(`email`,'') AS email, IFNull(DATE_FORMAT(`date_created`, '%D %M %Y'),'') AS date_created , IFNull(DATEDIFF(CURDATE(),`date_created`) , '') AS days, IFNull(`job_api_key` , '') AS jobkey , IFNull(`job_link`, '') AS link, IFNull(`image`, '') AS image FROM `gs_jobInfo` WHERE ".$where." ORDER BY `date_created` ASC");
}
else if ($type == 2) 
{
  
$query = mysql_query("SELECT `id`, IFNull(`userid`,'') AS userid, IFNull(`type`,'') AS type, IFNull(`name`,'') AS name, IFNull(`address_1`,'') AS address_1, IFNull(`address_2`,'') AS address_2, IFNull(`location`,'') AS location, IFNull(`PIN`,'') AS PIN, IFNull(`state`,'') AS state, IFNull(`description`,'') AS description, IFNull(`sport`,'') AS sport, IFNull(`eligibility1`,'') AS eligibility1, IFNull(`eligibility2`,'') AS eligibility2, IFNull(`terms_cond1`,'') AS terms_cond1, IFNull(`terms_cond2`,'') AS terms_cond2, IFNull(`organizer_name`,'') AS organizer_name, IFNull(`mobile`,'') AS mobile,IFNull(`organizer_address_line1`,'') AS organizer_address_line1, IFNull(`organizer_address_line2`,'') AS organizer_address_line2, IFNull(`organizer_city`,'') AS organizer_city, IFNull(`organizer_state`,'') AS organizer_state, IFNull(`organizer_pin`,'') AS organizer_pin, IFNull(`event_links`,'') AS event_links, IFNull(DATE_FORMAT(`start_date`, '%D %M %Y'),'') AS start_date, IFNull(DATE_FORMAT(`end_date`, '%D %M %Y'),'') AS end_date, IFNull(DATE_FORMAT(`entry_start_date`, '%D %M %Y'),'') AS entry_start_date, IFNull(DATE_FORMAT(`entry_end_date`, '%D %M %Y'),'') AS entry_end_date, IFNull(`file_name`,'') AS file_name, IFNull(`file`,'') AS file, IFNull(`email_app_collection`,'') AS email_app_collection, IFNull(DATE_FORMAT(`dateCreated`, '%D %M %Y'),'') AS dateCreated,IFNull(DATEDIFF(`entry_start_date`,CURDATE()) , '') AS days,IFNull(DATEDIFF(`entry_end_date`,CURDATE()) , '') AS open FROM `gs_eventinfo` WHERE ".$where." ORDER BY `id` DESC ");
}
else if($type == 3)
{


$query = mysql_query("SELECT `id`, IFNull(`userid`,'') AS userid, IFNull(`name`,'')AS name, IFNull(`address_1`,'') AS address_1


, IFNull(`address_2`,'') AS address_2, IFNull(`location`,'') AS location, IFNull(`state`,'') AS state


, IFNull(`pin`,'') AS pin, IFNull(`description`,'') AS description, IFNull(`sport`,'') AS sport, IFNull


(`level`,'') AS level, IFNull(`age_group`,'') AS age_group, IFNull(`gender`,'') AS gender, IFNull(`terms_and_cond1`,'') AS terms_and_cond1 , IFNull(`terms_and_cond2`,'') AS terms_and_cond2, IFNull(`organiser_name`,'') AS organiser_name, IFNull(`mobile`,'') AS mobile,IFNull(`eligibility1`, '') AS eligibility1,IFNull(`eligibility2`, '') AS eligibility2


, IFNull(`landline`,'') AS landline, IFNull(`email`,'') AS email, IFNull(`org_address1`,'') AS org_address1


, IFNull(`org_address2`,'') AS org_address2, IFNull(`org_city`,'')AS org_city , IFNull(`org_pin`,'')


 AS org_pin , IFNull(`tournaments_link`,'') AS tournaments_link, IFNull(DATE_FORMAT(`start_date`, '%D %M %Y'),'') AS start_date, IFNull(DATE_FORMAT(`end_date`, '%D %M %Y'),'') AS end_date, IFNull(DATE_FORMAT(`event_entry_date`, '%D %M %Y'),'') AS event_entry_date, IFNull(DATE_FORMAT(`event_end_date`, '%D %M %Y'),'') AS event_end_date, IFNull(`file_name`,'') AS file_name, IFNull(`file`,'') AS file, IFNull(`email_app_collection`,'') AS email_app_collection,IFNull(`phone_app_collection`,'') AS phone_app_collection , IFNull(DATEDIFF(`event_entry_date`,CURDATE()) , '') AS days , IFNull(DATEDIFF(`event_end_date`,CURDATE()) , '') AS open ,IFNull(DATE_FORMAT(`date_created`, '%D %M %Y'),'') AS date_created  FROM `gs_tournament_info`  WHERE ".$where."  ORDER BY `date_created` ASC");


}
else if($type == '4')
{
$query = mysql_query("SELECT  IFNull(`userid`,'') AS userid, IFNull(`title`,'')AS title, IFNull(`description`,'') AS description, IFNull(`url`,'') AS url, IFNull(DATE_FORMAT(`date_created`, '%D %M %Y'),'') AS date_created  FROM `gs_resources`  WHERE ".$where."  ORDER BY `date_created` ASC");
} 

//$query = mysql_query("SELECT * FROM `".$table."` WHERE `userid` = '$userid' ");
if(mysql_num_rows($query) > 0)
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




 public function favourites($user_id, $module , $user_favs)
 {

     $record = mysql_query("SELECT * FROM `users_fav` WHERE `userid` = '$user_id' AND `module` = '$module' ");
     if(mysql_num_rows($record) < 1)
     {
     $query = mysql_query("INSERT INTO `users_fav`(`id`, `userid`, `userfav`, `module`) VALUES ('','$user_id','$user_favs','$module')");
      if ($query){
        return 1;
      }else{


        return 0;
      }

	}
	else
	{
         while($data = mysql_fetch_assoc($record))
          {
             
                $row = $data;
                return $row;
               // print_r($row);
          }          
	}

    
   }



public function updatefav($id,$user_id,$data)
{ $data = rtrim($data,"");
  $data = rtrim($data,",");
	//echo "UPDATE `users_fav` SET `users_fav` = '$data' WHERE `userid` = '$user_id' AND `id` = '$id' ";die();
$query = mysql_query("UPDATE `users_fav` SET `userfav` = '$data' WHERE `userid` = '$user_id' AND `id` = '$id' ");
if($query)
{
	return 1;
}else
{
	return 0;
}

  }


public function eventsearch($data)
{

$query = "SELECT `id`, IFNull(`userid`,'') AS userid, IFNull(`type`,'') AS type, IFNull(`name`,'') AS name, IFNull(`address_1`,'') AS address_1, IFNull(`address_2`,'') AS address_2, IFNull(`location`,'') AS location, IFNull(`PIN`,'') AS PIN, IFNull(`state`,'') AS state, IFNull(`description`,'') AS description, IFNull(`sport`,'') AS sport, IFNull(`eligibility1`,'') AS eligibility1, IFNull(`eligibility2`,'') AS eligibility2, IFNull(`terms_cond1`,'') AS terms_cond1, IFNull(`terms_cond2`,'') AS terms_cond2, IFNull(`organizer_name`,'') AS organizer_name, IFNull(`mobile`,'') AS mobile,IFNull(`organizer_address_line1`,'') AS organizer_address_line1, IFNull(`organizer_address_line2`,'') AS organizer_address_line2, IFNull(`organizer_city`,'') AS organizer_city, IFNull(`organizer_state`,'') AS organizer_state, IFNull(`organizer_pin`,'') AS organizer_pin, IFNull(`event_links`,'') AS event_links, IFNull(DATE_FORMAT(`start_date`, '%D %M %Y'),'') AS start_date, IFNull(DATE_FORMAT(`end_date`, '%D %M %Y'),'') AS end_date, IFNull(DATE_FORMAT(`entry_start_date`, '%D %M %Y'),'') AS entry_start_date, IFNull(DATE_FORMAT(`entry_end_date`, '%D %M %Y'),'') AS entry_end_date, IFNull(`file_name`,'') AS file_name, IFNull(`file`,'') AS file, IFNull(`email_app_collection`,'') AS email_app_collection, IFNull(DATE_FORMAT(`dateCreated`, '%D %M %Y'),'') AS dateCreated,IFNull(DATEDIFF(`entry_start_date`,CURDATE()) , '') AS days,IFNull(DATEDIFF(`entry_end_date`,CURDATE()) , '') AS open FROM `gs_eventinfo` $data ORDER BY `dateCreated` DESC ";
//echo $query;
$query1 = mysql_query($query);
if($query1)
{

while($row = mysql_fetch_assoc($query1))
{

$rows[] = $row;
//$res = array('data'=>$rows);

}
  return $rows;
 } 
  else
 {
 	return 0;
   }
}


public function tournamentsearch($fwhere)
{


//echo $query;
$query1 = mysql_query("SELECT `id`, IFNull(`userid`,'') AS userid, IFNull(`name`,'')AS name, IFNull(`address_1`,'') AS address_1


, IFNull(`address_2`,'') AS address_2, IFNull(`location`,'') AS location, IFNull(`state`,'') AS state


, IFNull(`pin`,'') AS pin, IFNull(`description`,'') AS description, IFNull(`sport`,'') AS sport, IFNull


(`level`,'') AS level, IFNull(`age_group`,'') AS age_group, IFNull(`gender`,'') AS gender, IFNull(`terms_and_cond1`,'') AS terms_and_cond1 , IFNull(`terms_and_cond2`,'') AS terms_and_cond2, IFNull(`organiser_name`,'') AS organiser_name, IFNull(`mobile`,'') AS mobile,IFNull(`eligibility1`, '') AS eligibility1,IFNull(`eligibility2`, '') AS eligibility2


, IFNull(`landline`,'') AS landline, IFNull(`email`,'') AS email, IFNull(`org_address1`,'') AS org_address1


, IFNull(`org_address2`,'') AS org_address2, IFNull(`org_city`,'')AS org_city , IFNull(`org_pin`,'')


 AS org_pin , IFNull(`tournaments_link`,'') AS tournaments_link, IFNull(DATE_FORMAT(`start_date`, '%D %M %Y'),'') AS start_date, IFNull(DATE_FORMAT(`end_date`, '%D %M %Y'),'') AS end_date, IFNull(DATE_FORMAT(`event_entry_date`, '%D %M %Y'),'') AS event_entry_date, IFNull(DATE_FORMAT(`event_end_date`, '%D %M %Y'),'') AS event_end_date, IFNull(`file_name`,'') AS file_name, IFNull(`file`,'') AS file, IFNull(`email_app_collection`,'') AS email_app_collection,IFNull(`phone_app_collection`,'') AS phone_app_collection , IFNull(DATEDIFF(`event_entry_date`,CURDATE()) , '') AS days , IFNull(DATEDIFF(`event_end_date`,CURDATE()) , '') AS open ,IFNull(DATE_FORMAT(`date_created`, '%D %M %Y'),'') AS date_created FROM `gs_tournament_info`  ".$fwhere." ORDER BY `date_created` DESC");
if($query1)
{

while($row = mysql_fetch_assoc($query1))
{

$rows[] = $row;
//$res = array('data'=>$rows);

}
  return $rows;
 } 
  else
 {
 	return 0;
   }
}


public function jobsearch($fwhere)
{

$query = "SELECT `id`, IFNull(`userid`,'') AS userid, IFNull(`title`,'') AS title, IFNull(`location`,'') AS location, IFNull(`gender`,'') AS gender, IFNull(`sport`,'') AS sport, IFNull(`type`,'') AS type, IFNull(`work_experience`,'') AS work_experience, IFNull(`description`,'') AS description, IFNull(`desired_skills`,'') AS desired_skills, IFNull(`qualification`,'') AS qualification, IFNull(`key_requirement`,'') AS key_requirement, IFNull(`org_address1`,'') AS org_address1, IFNull(`org_address2`,'') AS org_address2, IFNull(`org_city`,'') AS org_city, IFNull(`org_state`,'') AS org_state,IFNull(`org_pin`,'') AS org_pin, IFNull(`organisation_name`,'') AS organisation_name, IFNull(`about`,'') AS about, IFNull(`address1`,'') AS address1, IFNull(`address2`,'') AS address2, IFNull(`state`,'') AS state, IFNull(`city`,'') AS city, IFNull(`pin`,'') AS pin, IFNull(`name`,'') AS name, IFNull(`contact`,'') AS contact, IFNull(`email`,'') AS email, IFNull(DATE_FORMAT(`date_created`, '%D %M %Y'),'') AS date_created , IFNull(DATEDIFF(CURDATE(),`date_created`) , '') AS days, IFNull(`job_api_key` , '') AS jobkey , IFNull(`job_link`, '') AS link , IFNull(`image`, '') AS image FROM `gs_jobInfo` ".$fwhere." ORDER BY `date_created` DESC";
//echo $query;
$query1 = mysql_query($query);
if(mysql_num_rows($query1) > 0)
{



while($row = mysql_fetch_assoc($query1))
{

$rows[] = $row;
//$res = array('data'=>$rows);

}
  return $rows;
 } 
  else
 {
 	return 0;
   }
}

/**********************************/
//Function to fetch the favourite data for the user from table `user_fav` 
//and send with search results
 /*********************************/

  public function getfavForUser($data,$type,$id)
{

    //print_r($data);
  	error_reporting(E_ERROR | E_PARSE);//to remove warning message due to array puch function
    //echo "SELECT `userfav` FROM  `users_fav` WHERE `userid` = '$id' AND `module` = '$type'";
  	$query = mysql_query("SELECT `userfav` FROM  `users_fav` WHERE `userid` = '$id' AND `module` = '$type'");

        if($type == '1' || $type == '2' || $type == '3')
        {

         $type = 'id';
         }
         else if ($type == '4' || $type == '5')
        {
            $type = 'userid';
        }

   if(mysql_num_rows($query)>0 && $id != "")

    {
   
   while($row = mysql_fetch_row($query))
   {
        
              $fav = $row[0];

              $fav = split(",",$fav);
              $num = sizeof($data);
        //print_r($data);
        for($i = 0 ; $i< $num ; $i++)
        {    
              $val = $data[$i][$type];
              if(in_array($val, $fav)){

              array_push($data[$i]['fav'], 1);
              $data[$i]['fav'] = "1";
            	
            }
            else
            {

            	array_push($data[$i]['fav'], 0);
            	$data[$i]['fav'] = "0";
            }

              // if($type != 1 && $type != ""){
              // $end = $data[$i]['entry_end_date'];
              // $now = date("Y-m-d");
              // $date1=date_create($st);
              // $date2=date_create($end);
              // $diff=date_diff($date2,$date1);
              // if($diff > 0)
              // {
              // //echo $diff->format("%a");
              // $dayremain = $diff->format("%a");
              // $data[$i]['days'] = $dayremain;}

              // else{
                 
              //    $data[$i]['days'] = 0;

              // }
              // }
                }
       return $data;
        

   }


  }
else

  {
        $num = sizeof($data);
        for($i = 0 ; $i< $num ; $i++)
        {    
            $val = $data[$i][$type];
            //echo $val;
            array_push($data[$i]['fav'], 1);
            	$data[$i]['fav'] = "0";
              // if($type != 1   && $type != ""){
              // $end = $data[$i]['entry_end_date'];
              // $now = date("Y-m-d");
              // $date1=date_create($st);
              // $date2=date_create($end);
              // $diff=date_diff($date2,$date1);
              // if($diff > 0){
              // //echo $diff->format("%a");
              // $dayremain = $diff->format("%a");
              // $data[$i]['days'] = $dayremain;}

              // else{
                 
              //    $data[$i]['days'] = 0;

              //     }
              //   }

        }
         //print_r($data);
         return $data;
      }
   }




public function a($id,$type)
{
$query = mysql_query("SELECT `userfav` FROM `users_fav` WHERE `userid` = '$id' AND `module` = '$type'  AND  `userfav` != '' ");

if(mysql_num_rows($query)>0){

   while($row = mysql_fetch_assoc($query))
   {
     
      $data = $row;

   }
return $data;
}
else{

	return 0;
   }
}

public function getfavdata($favdata, $type)
{
error_reporting(E_ERROR | E_PARSE);//to remove warning message due to array puch function
$id= $favdata;
if($type == '1'){

	//$table = 'gs_jobInfo';
  $query = mysql_query("SELECT `id`, IFNull(`userid`,'') AS userid, IFNull(`title`,'') AS title, IFNull(`location`,'') AS location, IFNull(`gender`,'') AS gender, IFNull(`sport`,'') AS sport, IFNull(`type`,'') AS type, IFNull(`work_experience`,'') AS work_experience, IFNull(`description`,'') AS description, IFNull(`desired_skills`,'') AS desired_skills, IFNull(`qualification`,'') AS qualification, IFNull(`key_requirement`,'') AS key_requirement, IFNull(`org_address1`,'') AS org_address1, IFNull(`org_address2`,'') AS org_address2, IFNull(`org_city`,'') AS org_city, IFNull(`org_state`,'') AS org_state,IFNull(`org_pin`,'') AS org_pin, IFNull(`organisation_name`,'') AS organisation_name, IFNull(`about`,'') AS about, IFNull(`address1`,'') AS address1, IFNull(`address2`,'') AS address2, IFNull(`state`,'') AS state, IFNull(`city`,'') AS city, IFNull(`pin`,'') AS pin, IFNull(`name`,'') AS name, IFNull(`contact`,'') AS contact, IFNull(`email`,'') AS email, IFNull(DATE_FORMAT(`date_created`, '%D %M %Y'),'') AS date_created , IFNull(DATEDIFF(CURDATE(),`date_created`) , '') AS days, IFNull(`job_api_key` , '') AS jobkey , IFNull(`job_link`, '') AS link , IFNull(`image`, '') AS image FROM `gs_jobInfo` WHERE `id` = '$id' ");
 // $id1    = 'id';
}else if($type == '2'){

	//$table = 'gs_eventinfo';
  $query = mysql_query("SELECT `id`, IFNull(`userid`,'') AS userid, IFNull(`type`,'') AS type, IFNull(`name`,'') AS name, IFNull(`address_1`,'') AS address_1, IFNull(`address_2`,'') AS address_2, IFNull(`location`,'') AS location, IFNull(`PIN`,'') AS PIN, IFNull(`state`,'') AS state, IFNull(`description`,'') AS description, IFNull(`sport`,'') AS sport, IFNull(`eligibility1`,'') AS eligibility1, IFNull(`eligibility2`,'') AS eligibility2, IFNull(`terms_cond1`,'') AS terms_cond1, IFNull(`terms_cond2`,'') AS terms_cond2, IFNull(`organizer_name`,'') AS organizer_name, IFNull(`mobile`,'') AS mobile,IFNull(`organizer_address_line1`,'') AS organizer_address_line1, IFNull(`organizer_address_line2`,'') AS organizer_address_line2, IFNull(`organizer_city`,'') AS organizer_city, IFNull(`organizer_state`,'') AS organizer_state, IFNull(`organizer_pin`,'') AS organizer_pin, IFNull(`event_links`,'') AS event_links, IFNull(DATE_FORMAT(`start_date`, '%D %M %Y'),'') AS start_date, IFNull(DATE_FORMAT(`end_date`, '%D %M %Y'),'') AS end_date, IFNull(DATE_FORMAT(`entry_start_date`, '%D %M %Y'),'') AS entry_start_date, IFNull(DATE_FORMAT(`entry_end_date`, '%D %M %Y'),'') AS entry_end_date, IFNull(`file_name`,'') AS file_name, IFNull(`file`,'') AS file, IFNull(`email_app_collection`,'') AS email_app_collection, IFNull(DATE_FORMAT(`dateCreated`, '%D %M %Y'),'') AS dateCreated,IFNull(DATEDIFF(`entry_start_date`,CURDATE()) , '') AS days,IFNull(DATEDIFF(`entry_end_date`,CURDATE()) , '') AS open FROM `gs_eventinfo` WHERE `id` = '$id' ORDER BY `dateCreated` DESC ");
 // $id1    = 'id';
}else if($type == '3'){

	$query = mysql_query("SELECT `id`, IFNull(`userid`,'') AS userid, IFNull(`name`,'')AS name, IFNull(`address_1`,'') AS address_1


, IFNull(`address_2`,'') AS address_2, IFNull(`location`,'') AS location, IFNull(`state`,'') AS state


, IFNull(`pin`,'') AS pin, IFNull(`description`,'') AS description, IFNull(`sport`,'') AS sport, IFNull


(`level`,'') AS level, IFNull(`age_group`,'') AS age_group, IFNull(`gender`,'') AS gender, IFNull(`terms_and_cond1`,'') AS terms_and_cond1 , IFNull(`terms_and_cond2`,'') AS terms_and_cond2, IFNull(`organiser_name`,'') AS organiser_name, IFNull(`mobile`,'') AS mobile,IFNull(`eligibility1`, '') AS eligibility1,IFNull(`eligibility2`, '') AS eligibility2


, IFNull(`landline`,'') AS landline, IFNull(`email`,'') AS email, IFNull(`org_address1`,'') AS org_address1


, IFNull(`org_address2`,'') AS org_address2, IFNull(`org_city`,'')AS org_city , IFNull(`org_pin`,'')


 AS org_pin , IFNull(`tournaments_link`,'') AS tournaments_link, IFNull(DATE_FORMAT(`start_date`, '%D %M %Y'),'') AS start_date, IFNull(DATE_FORMAT(`end_date`, '%D %M %Y'),'') AS end_date, IFNull(DATE_FORMAT(`event_entry_date`, '%D %M %Y'),'') AS event_entry_date, IFNull(DATE_FORMAT(`event_end_date`, '%D %M %Y'),'') AS event_end_date, IFNull(`file_name`,'') AS file_name, IFNull(`file`,'') AS file, IFNull(`email_app_collection`,'') AS email_app_collection,IFNull(`phone_app_collection`,'') AS phone_app_collection , IFNull(DATEDIFF(`event_entry_date`,CURDATE()) , '') AS days , IFNull(DATEDIFF(`event_end_date`,CURDATE()) , '') AS open ,IFNull(DATE_FORMAT(`date_created`, '%D %M %Y'),'') AS date_created FROM `gs_tournament_info` WHERE `id` = '$id'");
  
}
//$query = mysql_query("SELECT * FROM `".$table."` WHERE `id` = '$id' ");
if(mysql_num_rows($query)>0){

while($row = mysql_fetch_assoc($query)){

                $data = $row;
                array_push($data['fav'], 1);
            	  $data['fav'] = "1";

}
return $data;

}
else{

	return 0;
}

}

public function saverecent($fwhere,$type, $id)

{	

$query = mysql_query("SELECT * FROM `recent_search` WHERE `userid` = '$id' AND `module` = '$type'");
$row  = mysql_num_rows($query);
if( $row< 1)
{
$query1 = mysql_query("INSERT INTO `recent_search`(`id`, `userid`, `recent_act`, `module`, `date`) VALUES ('','$id','$fwhere','$type',CURDATE())");
}
 else
{//echo "UPDATE `recent_search` SET `recent_act` = '".$fwhere."' AND `date` = CURDATE() WHERE `userid` = '$id' AND `module` = '$type'";//die();echo 
  $query1 = mysql_query("UPDATE `recent_search` SET `recent_act` = '".$fwhere."' , `date` = CURDATE() WHERE `userid` = '$id' AND `module` = '$type'");
 
 }


if($query){

	return 1;
}else{
	return 0;
}

  }


public function get_recent($userid , $type)
{
//echo "SELECT `recent_act` FROM `recent_search` WHERE `userid` = '$userid' AND `module` = '$type'";
$query = mysql_query("SELECT `recent_act` FROM `recent_search` WHERE `userid` = '$userid' AND `module` = '$type'");
if(mysql_num_rows($query)>0){

while($data = mysql_fetch_assoc($query)){

$row = $data;

}
return $row;
}
else
{

  return 0;
}


}

public function get_recentdata($data1, $type)

{

if($type == 1)
{

  $query = mysql_query("SELECT `id`, IFNull(`userid`,'') AS userid, IFNull(`title`,'') AS title, IFNull(`location`,'') AS location, IFNull(`gender`,'') AS gender, IFNull(`sport`,'') AS sport, IFNull(`type`,'') AS type, IFNull(`work_experience`,'') AS work_experience, IFNull(`description`,'') AS description, IFNull(`desired_skills`,'') AS desired_skills, IFNull(`qualification`,'') AS qualification, IFNull(`key_requirement`,'') AS key_requirement, IFNull(`org_address1`,'') AS org_address1, IFNull(`org_address2`,'') AS org_address2, IFNull(`org_city`,'') AS org_city, IFNull(`org_state`,'') AS org_state,IFNull(`org_pin`,'') AS org_pin, IFNull(`organisation_name`,'') AS organisation_name, IFNull(`about`,'') AS about, IFNull(`address1`,'') AS address1, IFNull(`address2`,'') AS address2, IFNull(`state`,'') AS state, IFNull(`city`,'') AS city, IFNull(`pin`,'') AS pin, IFNull(`name`,'') AS name, IFNull(`contact`,'') AS contact, IFNull(`email`,'') AS email, IFNull(DATE_FORMAT(`date_created`, '%D %M %Y'),'') AS date_created , IFNull(DATEDIFF(CURDATE(),`date_created`) , '') AS days, IFNull(`job_api_key` , '') AS jobkey , IFNull(`job_link`, '') AS link , IFNull(`image`, '') AS image FROM `gs_jobInfo` WHERE `id` = '$data1' ORDER BY `date_created` ASC");
}
else if($type == 2)
{


  $query = mysql_query("SELECT `id`, IFNull(`userid`,'') AS userid, IFNull(`type`,'') AS type, IFNull(`name`,'') AS name, IFNull(`address_1`,'') AS address_1, IFNull(`address_2`,'') AS address_2, IFNull(`location`,'') AS location, IFNull(`PIN`,'') AS PIN, IFNull(`state`,'') AS state, IFNull(`description`,'') AS description, IFNull(`sport`,'') AS sport, IFNull(`eligibility1`,'') AS eligibility1, IFNull(`eligibility2`,'') AS eligibility2, IFNull(`terms_cond1`,'') AS terms_cond1, IFNull(`terms_cond2`,'') AS terms_cond2, IFNull(`organizer_name`,'') AS organizer_name, IFNull(`mobile`,'') AS mobile,IFNull(`organizer_address_line1`,'') AS organizer_address_line1, IFNull(`organizer_address_line2`,'') AS organizer_address_line2, IFNull(`organizer_city`,'') AS organizer_city, IFNull(`organizer_state`,'') AS organizer_state, IFNull(`organizer_pin`,'') AS organizer_pin, IFNull(`event_links`,'') AS event_links, IFNull(DATE_FORMAT(`start_date`, '%D %M %Y'),'') AS start_date, IFNull(DATE_FORMAT(`end_date`, '%D %M %Y'),'') AS end_date, IFNull(DATE_FORMAT(`entry_start_date`, '%D %M %Y'),'') AS entry_start_date, IFNull(DATE_FORMAT(`entry_end_date`, '%D %M %Y'),'') AS entry_end_date, IFNull(`file_name`,'') AS file_name, IFNull(`file`,'') AS file, IFNull(`email_app_collection`,'') AS email_app_collection, IFNull(DATE_FORMAT(`dateCreated`, '%D %M %Y'),'') AS dateCreated,IFNull(DATEDIFF(`entry_start_date`,CURDATE()) , '') AS days,IFNull(DATEDIFF(`entry_end_date`,CURDATE()) , '') AS open FROM `gs_eventinfo` WHERE `id` = '$data1' ORDER BY `dateCreated` DESC ");
}
else if($type == 3)
{


  $query = mysql_query("SELECT `id`, IFNull(`userid`,'') AS userid, IFNull(`name`,'')AS name, IFNull(`address_1`,'') AS address_1


, IFNull(`address_2`,'') AS address_2, IFNull(`location`,'') AS location, IFNull(`state`,'') AS state


, IFNull(`pin`,'') AS pin, IFNull(`description`,'') AS description, IFNull(`sport`,'') AS sport, IFNull


(`level`,'') AS level, IFNull(`age_group`,'') AS age_group, IFNull(`gender`,'') AS gender, IFNull(`terms_and_cond1`,'') AS terms_and_cond1 , IFNull(`terms_and_cond2`,'') AS terms_and_cond2, IFNull(`organiser_name`,'') AS organiser_name, IFNull(`mobile`,'') AS mobile,IFNull(`eligibility1`, '') AS eligibility1,IFNull(`eligibility2`, '') AS eligibility2


, IFNull(`landline`,'') AS landline, IFNull(`email`,'') AS email, IFNull(`org_address1`,'') AS org_address1


, IFNull(`org_address2`,'') AS org_address2, IFNull(`org_city`,'')AS org_city , IFNull(`org_pin`,'')


 AS org_pin , IFNull(`tournaments_link`,'') AS tournaments_link, IFNull(DATE_FORMAT(`start_date`, '%D %M %Y'),'') AS start_date, IFNull(DATE_FORMAT(`end_date`, '%D %M %Y'),'') AS end_date, IFNull(DATE_FORMAT(`event_entry_date`, '%D %M %Y'),'') AS event_entry_date, IFNull(DATE_FORMAT(`event_end_date`, '%D %M %Y'),'') AS event_end_date, IFNull(`file_name`,'') AS file_name, IFNull(`file`,'') AS file, IFNull(`email_app_collection`,'') AS email_app_collection,IFNull(`phone_app_collection`,'') AS phone_app_collection , IFNull(DATEDIFF(`event_entry_date`,CURDATE()) , '') AS days , IFNull(DATEDIFF(`event_end_date`,CURDATE()) , '') AS open ,IFNull(DATE_FORMAT(`date_created`, '%D %M %Y'),'') AS date_created FROM `gs_tournament_info` WHERE `id` = '$data1' ORDER BY `date_created` ASC" );
}

//echo "SELECT * FROM `".$table."` WHERE `id` = '$data1'";

//$query = mysql_query("SELECT * FROM `".$table."` WHERE `id` = '$data1'");
if($query){
while($row = mysql_fetch_assoc($query)){


$data = $row;

}

return $data;
}
else{


  return 0;
}

}



public function jobsapplied($userid , $id , $type)
{

//echo"INSERT INTO `user_jobs`(`id`, `userid`, `userjob`, `date`,`status`) VALUES ('','$userid','$id',CURDATE(),$type)";die();
$query = mysql_query("INSERT INTO `user_jobs`(`id`, `userid`, `userjob`, `date`,`status`) VALUES ('','$userid','$id',CURDATE(),'$type')");
if($query)
{
  return 1;
}
else
{
  return 0;
}
}



public function getuserjobs($res, $type, $id)
{
 //echo "SELECT `userjob` FROM `user_jobs` WHERE `userid` = '$id' ";
$query  = mysql_query("SELECT `userjob` FROM `user_jobs` WHERE `userid` = '$id' ");
if(mysql_num_rows($query)>0)
{

while($row = mysql_fetch_assoc($query))
{
$data = $row;
$value =$data['userjob']; 
$size = sizeof($res);
for($j = 0 ; $j< $size ; $j++)
 {  
      $keyval = $res[$j]['id'];

      if($keyval != $value)
      {
         // echo $keyval." != ".$value."= false"."<>";
    
           array_push($res[$j]['job'], 0);
              $val1 = "0";
              if($res[$j]['job'] != "1"){
              $res[$j]['job'] = $val1;
             }else{

              $res[$j]['job'] = "1";
             }
      }
     

     else if($keyval == $value)
      {      
           //echo $keyval." == ".$value."= true"."<>";
  
          array_push($res[$j]['job'], "1");
        
          $res[$j]['job'] = "1";
          
      }
    
      
      }


}

return $res;//print_r($res);
     }
  else
  {


$size = sizeof($res);
for($i = 0 ; $i<$size ; $i++)
 {

 array_push($res[$i]['job'], 0);
        
          $res[$i]['job'] = "0";


}
  return $res;
  }
  }

public function sendPushNotificationToGCM($registatoin_ids, $message) 
{
    //Google cloud messaging GCM-API url
        $url = 'https://gcm-http.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );
          $message = array('data1'=>$message);
      $data = array('data'=>$message,'to'=>$registatoin_ids);

     
        json_encode($data);
        //print_r($fields);
    // Google Cloud Messaging GCM API Key
    define("GOOGLE_API", "AIzaSyAF1SYN40Gf_JD2J6496-cLnfT_eX4gRt8");    
        $headers = array(
            'Authorization: key=' . GOOGLE_API,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);       
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
          }


public function sendLitePushNotificationToGCM($registatoin_ids, $message) 
{
    //Google cloud messaging GCM-API url
        $url = 'https://gcm-http.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );
        //$registatoin_ids = '/topics/global';
        //echo $registatoin_ids;
       $message = array('data1'=>$message);
      $data = array('data'=>$message,'to'=>$registatoin_ids);
     // print_r($data);
        json_encode($data);
        //print_r($fields);
    // Google Cloud Messaging GCM API Key
   define("API_KEY", "AIzaSyAx3VrWlzsiEnFedeDBoCUhYe8lU5nR7VU");    
        $headers = array(
            'Authorization: key=' . API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);       
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
        //print_r($result);
    }



public function savealert($employerid ,$type,$message , $title, $applicantId)
{

//echo "INSERT INTO `gs_alerts`(`id`, `userid`,`applicant_id`, `message`, `title`, `date_alerted`) VALUES ('','$employerid','$applicantId','$message','$title','CURDATE()')";
  //print_r($title);
$query = mysql_query("INSERT INTO `gs_alerts`(`id`, `userid`,`applicant_id`, `message`, `title`, `date_alerted`,`type`) VALUES ('','$employerid','$applicantId','$message','$title',CURDATE(),'$type')");

if($query){
  return 1;
}else 
return 2;

}

public function InsertTempjobinfo($data)
{

$company     =$data['company'];
$title       =$data['title'];
$city        =$data['city'];
$location    =$data['Location'];
$state       =$data['state'];
$link        =$data['link'];
$key         =$data['key'];
$time_posted =$data['time'];
$description =$data['description'];
$jobposted   =$data['jobposted'];

$query = mysql_query("INSERT INTO `temp_gs_jobInfo`(`id`, `userid`, `title`, `location`, `gender`, `sport`, `type`, `work_experience`, `description`, `desired_skills`, `qualification`, `key_requirement`, `org_address1`, `org_address2`, `org_city`, `org_state`, `org_pin`, `organisation_name`, `about`, `address1`, `address2`, `state`, `city`, `pin`, `name`, `contact`, `email`, `date_created`,`job_api_key`,`job_link`) VALUES ('','16','$title','$Location','','','','','$description','','','','','','$city','$state','','$company','','','','','','','','','',CURDATE(),'$key','$link')");

if($query)
{

$update = $this->updatemorejobs();
if($update == '1')
{

return true;

}
else
{

return false;

}
}

return 0;

}

public function updatemorejobs()
{

$query = mysql_query("INSERT INTO `gs_jobInfo` (`userid`,`title`,`location`,`description`,`org_city`,`job_api_key`,`organisation_name`,`org_state`,`job_link`,`date_created`) SELECT a.`userid`,a.`title`,a.`location`,a.`description`,a.`org_city`,a.`job_api_key`,a.`organisation_name`,a.`org_state`,a.`job_link`,a.`date_created` FROM `temp_gs_jobInfo` AS a WHERE a.`job_api_key` NOT IN (SELECT `job_api_key` FROM  `gs_jobInfo`)");

if($query)
{

return 1;

}else
{

return 0;

}


}

public function saveparam($id,$job_title,$sport_name,$location)
{

$search = $sport_name.$job_title;

$query = mysql_query("INSERT INTO `search_param` (`userid`,`Searchquery`,`location`,`date_created`) VALUES('$id','$search','$location' , CURDATE()) ON DUPLICATE KEY UPDATE `Searchquery` ='$search' , `location` = '$location' , `date_created` = CURDATE()");
if($query)
{

return 1;

}
else
{


return 0;

}


}
public function getSearch()
{

$query = mysql_query("SELECT * FROM `search_param` ORDER BY `date_created` DESC LIMIT 0,10");
{

if(mysql_num_rows($query)>0)
{

while ($row = mysql_fetch_assoc($query)) {
  $data[] = $row;
}
return $data;

}
else

return 0;

}


}


public function updaterecords($data)
{
 $event_id    = $data['event_id']; 
 $event_name  = $data['event_name'];
 $start_time  = $data['start_time'];
 $end_time    = $data['end_time'];
 $city        = $data['city'];
 $state       = $data['state'];
 $country     = $data['country'];
 $address     = $data['address'];
 $link        = $data['link'];
 $image       = $data['image']; 
 $description = $event_name." "."<br>"."please folloe the link for more info".$link;
 $type        = 'Native';
 $description = strip_tags($description);

$query = mysql_query("INSERT INTO `Temp_gs_eventinfo`(`id`, `userid`, `type`, `name`, `address_1`, `location`, `state`,  `description`,`event_links`, `start_date`, `end_date`, `entry_start_date`, `entry_end_date`,`file`,`dateCreated`, `event_id`) VALUES ('','16','$type','$event_name','$address','$city','$state','$description','$link',FROM_UNIXTIME('$start_time'),FROM_UNIXTIME('$end_time'),FROM_UNIXTIME('$start_time'),FROM_UNIXTIME('$end_time'),'$image',CURDATE(),'$event_id')");
if($query)
{
  $resp = $this->updateMoreEvents();

  if($resp == '1')
  {

  return 1;

  }
  else
  {

  return 0;


  }

}



}
public function updateMoreEvents()
{

$query = mysql_query("INSERT INTO `gs_eventinfo` (`userid`, `type`, `name`, `address_1`, `location`, `state`,  `description`,`event_links`, `start_date`, `end_date`, `entry_start_date`, `entry_end_date`,`file`,`dateCreated`, `event_id`) SELECT a.`userid`, a.`type`, a.`name`, a.`address_1`, a.`location`, a.`state`,  a.`description`,a.`event_links`, a.`start_date`, a.`end_date`, a.`entry_start_date`, a.`entry_end_date`,a.`file`,a.`dateCreated`, a.`event_id` FROM `Temp_gs_eventinfo` AS a WHERE a.`event_id` NOT IN (SELECT `event_id` FROM  `gs_eventinfo`)");

 if($query)
 {

return 1;

 } 
else
{

return 0;

}

}

public function getAppliedJobListing($userid,$jobid)
{
$n=1;
$q ="SELECT ji.`userid` AS employerid, ji.`id` AS job_id, uj.`userid` AS applicant_id ,us.`name` AS applicant_name ,us.`user_image` AS applicant_image FROM `gs_jobInfo` AS ji LEFT JOIN `user_jobs` AS uj ON ji.`id` = uj.`userjob` LEFT JOIN `user` AS us ON us.`userid` = uj.`userid` WHERE ji.`userid`='$userid' AND ji.`id`='$jobid' AND uj.`status`>='$n'";
$query = mysql_query($q);
if(mysql_num_rows($query)>0)
{
while($row = mysql_fetch_assoc($query))
{
$rows[] = $row;
}
return $rows;
}
else
{
return 0;
}
}

/***********************************/


public function jobStatus($job_id,$applicant_id,$status,$salary,$joining_date)
{
  //echo "UPDATE `user_jobs` SET `status` = '$status',  `salary`='$salary' ,`joining_date`='$joining_date' WHERE `userid` = '$applicant_id' AND `userjob` = '$job_id'";die();
    $query = mysql_query("UPDATE `user_jobs` SET `status` = '$status',  `salary`='$salary' ,`joining_date`='$joining_date' WHERE `userid` = '$applicant_id' AND `userjob` = '$job_id'");

  if($query)
  {
    return true;
  }
  else
  {

    return false;

  }
}



public function getOfferList($userid)
{
$query = mysql_query("SELECT uj.`id` , uj.`userid` AS 'applicant_id' , uj.`userjob` , ji.`id` AS job_id, ji.`title` AS job_title , ji.`organisation_name` AS employer_name , uj.`status` FROM `user_jobs` AS uj LEFT JOIN `gs_jobInfo` AS ji ON uj.`userjob` = ji.`id` WHERE uj.`userjob` = ji.`id` AND uj.`status` > 0 AND uj.`userid` = '$userid'"); 

if(mysql_num_rows($query)>0)
{

while($row = mysql_fetch_assoc($query))
{

$rows[] = $row;

}

return $rows;

}
else
{

return 0;

}

}



/*******************************************************/

public function createResources($data)
{
  $userid       = $data->userid;
  $title        = $data->title;
  $message      = $data->message;
  $url          = $data->link;
  $image        = $data->image;

  $query  = mysql_query("INSERT INTO `gs_resources` (`id`,`userid`, `title` , `description` , `url` ,`date_created`) VALUES('','$userid','$title','$message','$url',CURDATE())");

  if($query)
        { 
          $id = mysql_insert_id();
          if($id!=NULL && $image!=NULL)
          {
           $image = $this->imageupload($image,$id);
          }
        return 1;
        }
        else
          {
            return 0;
          }
}





/***************Function for Upload Image in Create Resource***********************/


 public function imageupload($image,$id)
    {
      define('UPLOAD_DIR','../staging/uploads/job/');
      $now = new DateTime();
      $time=$now->getTimestamp(); 
      $img = $image;
      $img = str_replace('data:image/png;base64,', '', $img);
      $img = str_replace('$filepath,', '', $img);
      $img = str_replace(' ', '+', $img);
      $data = base64_decode($img);
      $img_name= "res"."_".$time;
      $success=move_uploaded_file($img, $filepath);
      $file = UPLOAD_DIR.$img_name.'.png';
      $success = file_put_contents($file, $data);
      if($success)
      {
        $img_name = $img_name. '.png';
        // This code is Used for Create Resource for Uploading the Image
       // $updateImage = mysql_query("update `gs_resources` set `image`='$img_name' where `id`='$id'");
         $updateImage = mysql_query("update `gs_jobInfo` set `image`='$img_name' where `id`='$id'");
      if($updateImage)
      {
        return 1;
      }
      }
      else
        {
          $res = array('data' =>'Image is Not Upload' ,'status' => 0);
          echo json_encode($res);
          return 0;
          //echo "image not uploaded";
         
        }
    }
 
   
/*****************************************************************/

   public function getResources_search($fwhere)
  {

    $query = "SELECT  IFNull(`title`,'') AS title, IFNull(`description`,'') AS description, IFNull(`url`,'') AS link , IFNull(`image`,'') AS image,IFNull(DATEDIFF(CURDATE(),`date_created`) ,'') AS date, IFNull(`id` , '') AS res_id FROM `gs_resources` ".$fwhere." ";

   $query1 = mysql_query($query);

    if(mysql_num_rows($query1) > 0)
      {
      while($row = mysql_fetch_assoc($query1))
      {
      $rows[] = $row; 
      }

      return $rows;
       } 
      
        else
       {
      return 0;
       }

      }  



/**************************Function for Email Send****************************/

public function sendEmail($id)
{
 $query  = mysql_query("SELECT `email`,`name` FROM `user` WHERE `userid` = '$id'");
 while ($row=mysql_fetch_assoc($query))
  {
   $email=$row['email'];
   $user_name= $row['name'];
   }
               require('class.phpmailer.php');
              $mail = new PHPMailer();
              $to=$email;
              $from="info@getsporty.in";
              $from_name="Getsporty Lite";
              $subject="Offer letter";
              $user=$user_name;
              $otp  =$code;
              //global $error;
              $mail = new PHPMailer();  // create a new object
              $mail->IsSMTP(); // enable SMTP
              $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
              $mail->SMTPAuth = true;  // authentication enabled
              $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
             // $mail->Host = 'dezire.websitewelcome.com';
              $mail->Host = 'smtp.gmail.com';
              $mail->Port = 465; 
              $mail->Username ="harshvardhan@darkhorsesports.in";  
              $mail->Password = "New@job2016";           
              $mail->SetFrom($from, $from_name);
              $mail->Subject = $subject;
              $mail->Body = '<div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#5666be;">

 <table align="center" border="4" cellpadding="4" cellspacing="3" style="max-width:480px" width="100%" class="" >
<tbody><tr>
<td align="center" valign="top">
<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="background-color:#ffffff;  border-bottom:2px solid #e5e5e5;border-radius:4px" width="100%">
<tbody><tr>

<td align="center" style="padding-right:20px;padding-left:20px" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td align="left" valign="top" style="padding-top:40px;padding-bottom:30px">
</td>
</tr>
<tr>
<td style="padding-bottom:20px" valign="top">
<h1 style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:28px;font-style:normal;font-weight:600;line-height:36px;letter-spacing:normal;margin:0;padding:0;text-align:left">RE: LETTER OF OFFER OF EMPLOYMENT – Position title</h1>
</td>
</tr>
<tr>
<td style="padding-bottom:20px" valign="top">
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left">Dear Mr. /Ms., <strong><br> ' . $user . '</strong></p>
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left">Following our recent discussions, we are delighted to offer you the position of Position Title with Our Organization. Our Organization is describe key highlights about your organization. If you join Our Organization, you will become part of a fast-paced and dedicated team that works together to provide our clients with the highest possible level of service and advice.<br> 

As a member of Our Organization team, we would ask for your commitment to deliver outstanding quality and results that exceed client expectations. In addition, we expect your personal accountability in all the products, actions, advice and results that you provide as a representative of Our Organization. In return, we are committed to providing you with every opportunity to learn, grow and stretch to the highest level of your ability and potential.<br>

We are confident you will find this new opportunity both challenging and rewarding. The following points outline the terms and conditions we are proposing.
<br><br><br><br><br>Thanks GetSportyLite Team </p> 

</td>
</tr>
<tr>
<td align="center" style="padding-bottom:60px" valign="top">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td align="center" valign="middle">
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</div>'; 
               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $mail->Send();
         return 1;
         
}       
  

public function getuserdata($userid)
{
$query = mysql_query("SELECT * FROM `user` WHERE `userid`=$userid");
{
if(mysql_num_rows($query)>0)
{
while ($row = mysql_fetch_assoc($query)) {
  $data = $row;
}
return $data;
}
else
return 0;
}
}

public function manage_Login($item)
{

$query = mysql_query("SELECT * FROM `user` WHERE `email`= '$item->email' AND `password` = '$item->password' AND `userType`= '103' ");
{
if(mysql_num_rows($query)>0)
{
while ($row = mysql_fetch_assoc($query)) 
{
  $data[] = $row;
}

if(($item->device_id != $data[0]['device_id']) || $item->device_id !=" ");
{
   $userid= $data[0]['userid'];
   $query = mysql_query("UPDATE `user` SET `device_id`='$item->device_id' WHERE `userid`='$userid'");
    

}
//die;
return $data;
}
else
return 0;
}
}



public  function create_manage_user_exits($data)
{
        $query  = mysql_query("SELECT `userid`,`password`,`userType` ,`forget_code` FROM `user`  WHERE `email`='$data->email'");
        if(mysql_num_rows($query)>0)
        {
          while($row = mysql_fetch_assoc($query))
        {
          $data = $row;
        }

        $userid=$data['userid'];
           //print_r($data['password']); die;
        if($data['userType']=='104'  && ($data['password']=='' || $data['password']== NULL ))
        {
        $query = mysql_query("UPDATE `user` SET `userType`='103' , `date_updated`=CURDATE()  WHERE `userid`='$userid'");

//###################### password set  email send to user #########################

$body ='<div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#5666be;">

 <table align="center" border="4" cellpadding="4" cellspacing="3" style="max-width:480px" width="100%" class="" >
<tbody><tr>
<td align="center" valign="top">
<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="background-color:#ffffff;  border-bottom:2px solid #e5e5e5;border-radius:4px" width="100%">
<tbody><tr>

<td align="center" style="padding-right:20px;padding-left:20px" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td align="left" valign="top" style="padding-top:40px;padding-bottom:30px">
</td>
</tr>
<tr>
<td style="padding-bottom:20px" valign="top">
<h1 style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:28px;font-style:normal;font-weight:600;line-height:36px;letter-spacing:normal;margin:0;padding:0;text-align:left">Password Reset</h1>
</td>
</tr>
<tr>
<td style="padding-bottom:20px" valign="top">
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left">
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left">  Please click on the link to reset the password <br>

 <a href="http://getsporty.in/user_reg/index.php?id='.$userid. '">continue reading.</a>

<br><br><br><br><br>Thanks GetSportyLite Team </p> 
</td>
</tr>
<tr>
<td align="center" style="padding-bottom:60px" valign="top">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td align="center" valign="middle">
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</div>'; 

   $this->sendEmail_for_password_reset($userid,$body);
   return 1;
    }

else if($data['userType']=='104')
    {
    $userid=$data['userid'];
    $query = mysql_query("UPDATE `user` SET `userType`='103' , `date_updated`=CURDATE()  WHERE `userid`='$userid'");

}
}}


//  ***************User is view apply  our JOB , EVENT ,TOURNAMENT**********************




  public function view_apply($userid,$type)
  {
switch ($type) 
{

  case '1':
       $query = "SELECT `gs_jobInfo`.`id`,`TITLE`,`description`,`image` FROM `gs_jobInfo`,`user_jobs` WHERE `gs_jobInfo`.`id`=`user_jobs`.`userjob` AND `user_jobs`.`userid`=$userid AND `user_jobs`.`STATUS`>=1";
   $query1 = mysql_query($query);

    if(mysql_num_rows($query1) > 0)
      {
      while($row = mysql_fetch_assoc($query1))
      {
      $rows[] = $row; 
      }

      return $rows;
       } 
      
        else
       {
      return 0;
       }
break;
case '2':


  break;

case '3':
      break;
      default:
     } //End Switch

}//End Function





/***************************************New Apply function Job Event Tournament*****************/

// This code is Only for Local System Please Ignore it if Functionaly is Complite then code is replace the Code Server


public function apply($userid , $id , $type,$module)
{
switch ($module)
 {
   case '1':
     $query = mysql_query("INSERT INTO `user_jobs`(`id`, `userid`, `userjob`, `date`,`status`) VALUES ('','$userid','$id',CURDATE(),'$type')");
     break;
   case '2':
       $query = mysql_query("INSERT INTO `user_events`(`id`, `userid`,`userevent`,`date`,`status`) VALUES ('','$userid','$id',CURDATE(),'$type')");
     break;
     case '3':
       $query = mysql_query("INSERT INTO `user_tournaments`(`id`, `userid`, `usertournament`, `date`,`status`) VALUES ('','$userid','$id',CURDATE(),'$type')");
       break;
  
 }  //End Switch
    if($query)
    {
      return 1;
    }
    else
    {
      return 0;
    }
}// End Function







//  *************** New Code for User is view apply  our JOB , EVENT ,TOURNAMENT**********************
// This code for view Apply when the User is apply  our JOB , EVENT ,TOURNAMENT so Pleas Ignore this Code
 public function v_apply($userid,$type)
  {
switch ($type) 
{
case '1':
      $query = mysql_query("SELECT `ji`.`id`,`ji`.`TITLE`,`ji`.`description`,`ji`.`image` FROM `gs_jobInfo` AS ji, `user_jobs` AS uj WHERE `ji`.`id`=`uj`.`userjob` AND `uj`.`userid`=$userid AND `uj`.`status`>=1");
      break;
case '2':
       $query = mysql_query("SELECT `ei`.`id`,`TITLE`,`description`,`image` FROM ` gs_eventinfo` AS ei ,`user_events` ue WHERE `ei`.`id`=`ue`.`userevent` AND `ue`.`userid`=$userid AND `ue`.`status`>=1");

      break;
case '3':
    $query = mysql_query("SELECT `gs_tournament_info`.`id`,`TITLE`,`description`,`image` FROM `gs_tournament_info`,`user_jobs` WHERE `gs_jobInfo`.`id`=`user_jobs`.`userjob` AND `user_tournaments`.`userid`=$userid AND `user_tournaments`.`status`>=1");

      break;
      default:
      $resp['status'] = "Falure";
      echo json_encode($resp);
   break;

     } //End Switch

      if(mysql_num_rows($query) > 0)
      {
      while($row = mysql_fetch_assoc($query))
      {
      $rows[] = $row; 
      }
      return $rows;
      } 
      else
      {
      return 0;
      }
}//End Function


//###################### welcome email send to user ##############################################

       
 


public function sendEmail_for_password_reset($id,$body)
{

  //print_r($id);
//  die;
 $query  = mysql_query("SELECT `email`,`name` FROM `user` WHERE `userid` = '$id'");
 while ($row=mysql_fetch_assoc($query))
  {
   $email=$row['email'];
   $user_name= $row['name'];
   }
               require('class.phpmailer.php');
              $mail = new PHPMailer();
              $to=$email;
              $from="info@getsporty.in";
              $from_name="Getsporty Lite";
              $subject="Offer letter";
              $user=$user_name;
              $otp  =$code;
              //global $error;
              $mail = new PHPMailer();  // create a new object
              $mail->IsSMTP(); // enable SMTP
              $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
              $mail->SMTPAuth = true;  // authentication enabled
              $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
             // $mail->Host = 'dezire.websitewelcome.com';
              $mail->Host = 'smtp.gmail.com';
              $mail->Port = 465; 
              $mail->Username ="harshvardhan@darkhorsesports.in";  
              $mail->Password = "New@job2016";           
              $mail->SetFrom($from, $from_name);
              $mail->Subject = $subject;
               $mail->Body = $body;
              

               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $mail->Send();
            return 1;
}

}//end class

?>
