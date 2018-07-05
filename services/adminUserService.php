<?php 

Class AdminUserService
{
	
	public function admin_login($email,$pwd)
	{
      $query = mysql_query("SELECT `adminid`, `userType`, `status`, `name`, `password`, `forget_code`, `email`, `contact_no`, `gender`, `address1`, `address2`, `address3`, `dob`, `user_image`, `location`, `device_id`, `access_module`, `activeuser`, `date_created`, `date_updated`  FROM `gs_admin_user` WHERE `email` = '$email' AND `password` = '$pwd'");

      if(mysql_num_rows($query) != '0')
      {
      	return mysql_fetch_assoc($query);
      }
      else
      {
      	return 0;
      }      
    }


}


?>