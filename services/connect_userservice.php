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
 	//print_r($userid);die;
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
      $query = mysql_query("SELECT `userid`,`name`,`sport`,`gender`,`prof_id`,`prof_name`,`user_image`,`location`,`age_group_coached` FROM `user` WHERE `userid` IN(SELECT `prof_user_id` FROM `gs_connect` WHERE `lite_user_id`=$userid AND `req_status`= 1) ");
  }

  if($usertype=='M')
  {
  $query = mysql_query(" SELECT `userid`,`name`,`sport`,`gender`,`prof_id`,`prof_name`,`user_image`,`location`,`age_group_coached` FROM `user` WHERE `userid` IN(SELECT `lite_user_id` FROM `gs_connect` WHERE `prof_user_id`=$userid AND `req_status`= 1) ");
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
        $query = mysql_query("SELECT `userid`,`name`,`sport`,`gender`,`prof_id`,`prof_name`,`user_image`,`location`,`age_group_coached` FROM `user` WHERE `userid` IN(SELECT `prof_user_id` FROM `gs_connect` WHERE `lite_user_id`=$userid AND `req_status`= 0) ");
    }
    if($usertype=='M')
    {
    $query = mysql_query( "SELECT `userid`,`name`,`sport`,`gender`,`prof_id`,`prof_name`,`user_image`,`location`,`age_group_coached` FROM `user` WHERE `userid` IN(SELECT `lite_user_id` FROM `gs_connect` WHERE `prof_user_id`=$userid AND `req_status`= 0) ");
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























} // End Class