<?php

Class User_access_service 
{

public function find_user_data($where)
{
  $query = "SELECT `userid`, `userType`, `status`, `name`, `email`, `contact_no`, `sport`, `gender`, `dob`, `prof_id`, `prof_name`, `user_image`, `location`, `device_id`, `date_created`, `date_updated`, `m_device_id`, `M_fb_id`, `L_fb_id`,`google_id` FROM `user` WHERE ".$where."";
  //echo $query;die;
  $sql = mysql_query($query);
  if(mysql_num_rows($sql)>0)
	{
		return mysql_fetch_assoc($sql);
	}
	else
	{
		return 0;
	}
}

public function update_user_data($update,$where)
 {

	$query = "UPDATE `user` SET  ".$update."  WHERE  ".$where." ";
	$sql = mysql_query($query);
	if(mysql_affected_rows()>0)
	{
		return 1;
	}else
	{
		return 0;
	}

 }

public function create_new_user($data)
 {  
 	$userType = $_REQUEST['userType'];
 	$name = $_REQUEST['name'];
 	$email = $_REQUEST['email'];
 	$contact_no = $_REQUEST['contact_no'];
 	$sport = $_REQUEST['sport'];
 	$gender = $_REQUEST['gender'];
 	$dob  = $_REQUEST['dob'];
 	$prof_id = $_REQUEST['prof_id'];
 	$prof_name = $_REQUEST['prof_name'];
    $user_image = $_REQUEST['user_image'];
    $location = $_REQUEST['location'];
    $device_id = $_REQUEST['device_id'];
    if($apptype != '')
    {
      $fb_id = "`".$app_type."_fb_id`";
    }
    $password = md5($email);
   $query = "INSERT INTO `user`(`userType`, `name`, `password`,`email`, `contact_no`, `sport`, `gender`, `dob`, `prof_id`, `prof_name`, `user_image`,`location`,`device_id`, `date_created`,".$fb_id.") VALUES ('$userType','$name','$password','$email','$contact_no','$sport','$gender','$dob','$prof_id','$prof_name','$user_image','$location','$device_id',CURDATE(),'$app_id')";
   $sql = mysql_query($query);
   $log_id = mysql_insert_id();
   if($sql)
   {

   	$where = "`userid` = '".$log_id."'";
   	return $this->find_user_data($where);
   }
   else
   {
   	return 0;
   }
}


}



 ?>