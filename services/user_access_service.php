<?php

Class User_access_service 
{

public function find_user_data($where)
{
  $query = "SELECT IFNull(`userid`,'') AS userid, IFNull(`userType`,'') AS userType, IFNull(`status`,'') AS status,IFNull(`name`,'') AS name,IFNull(`forget_code`,'') AS forget_code ,IFNull(`email`,'') AS email, IFNull(`contact_no`,'') AS contact_no,IFNull(`sport`,'') AS sport, IFNull(`gender`,'') AS gender,IFNull(`dob`,'') AS dob, IFNull(`prof_id`, '') AS prof_id,IFNull(`prof_name`,'') AS prof_name , IFNull(`user_image`,'') AS user_image ,IFNull(`profile_status`,'') AS profile_status , IFNull(`location`,'') AS location , IFNull(`prof_language`,'') AS prof_language, IFNull(`other_skill_name`,'') AS other_skill_name, IFNull(`age_catered`,'') AS age_catered, IFNull(`device_id`,'') AS device_id ,IFNull(`about_me`,'') AS about_me ,IFNull(`access_module`,'') AS access_module,IFNull(`activeuser`,'') AS activeuser ,IFNull(`date_created`,'') AS date_created, IFNull(`date_updated`,'') AS date_updated ,IFNull(`m_device_id`,'') AS m_device_id ,IFNull(`link`,'') AS link ,IFNull(`age_group_coached`,'') AS age_group_coached ,IFNull(`languages_known`,'') AS languages_known ,IFNull(`unique_code`,'') AS unique_code,IFNull(`M_fb_id`,'') AS M_fb_id,IFNull(`L_fb_id`,'') AS L_fb_id,IFNull(`google_id`,'') AS google_id FROM `user` WHERE ".$where."";
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
		return $this->find_user_data($where);
	}else
	{
		return 0;
	}

 }

public function create_new_user($data)
{ 
     $app_type = $data->app;
    if($data->loginType == '1')
    {
      $id_column = $data->app."_fb_id";
    }else
    {
      $id_column = "google_id";
    }
    $password = md5($data->email);
    $query = "INSERT INTO `user`(`userType`, `name`, `password`,`email`, `contact_no`, `sport`, `gender`, `dob`, `prof_id`, `prof_name`, `user_image`,`location`,`device_id`, `date_created`,`".$id_column."`) VALUES ('$data->userType','$data->name','$password','$data->email','$data->phone_no','$data->sport','$data->gender','$data->dob','$data->prof_id','$data->prof_name','$data->image','$data->location','$data->device_id',CURDATE(),'$data->id')";
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
  public function create_user($data)
  {   $item = new stdClass();
      $item->userType = $data->userType;
      $item->name     = $data->data->name;
      $item->passwsord = md5($data->data->email);
      $item->email     = $data->data->email;
      $item->image    = $data->data->image;

      if(isset($data->data->email))
      {
        $item->email = $data->data->email;
        $status  = 1;
      }else
      {
        $item->email = '';
        $status = 0;
      }


      if($data->loginType == '2')
      {
        $app_id_column = "google_id";
        $column = $app_id_column;
        $item->app_id        = $data->data->id; 
      }else
      {
        $app_id_column = $data->app."_fb_id";
        $column  = $app_id_column;
        $item->app_id        = $data->data->id;

      }
      //echo $app_id;die;
      $password = md5($data->data->email);
      $query = "INSERT INTO `user`(`userType`, `name`, `status`,`password`,`email`,`user_image`, `date_created`,`".$app_id_column."`) VALUES ('$item->userType','$item->name','$status','$password','$item->email','$item->image',CURDATE(),'$item->app_id')";
     $sql    = mysql_query($query);
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