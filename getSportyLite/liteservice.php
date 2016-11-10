 <?php
  class liteservice
  { 
  
  /*******************Check The User is Already Exits [Function]*************/

  public function  userExits($where)
  {
     $query  = mysql_query("SELECT `userid`,`name`, `email` FROM `user` ".$where);
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
  
/****************Sign Up in Getsporty [Function]***********************/

 public function GsUserRegister($data)
  {
     $name         =  $data['name'];
     $email        =  $data['email'];
     $password1    =  $data['password'];
     $token        =  mysql_escape_string($data['token']);
     $query =mysql_query("INSERT INTO `user`(`userid`, `name`, `email`, `password`,`device_id`) VALUES('','$name','$email','$password1','$token')");
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
  }

public function userdata($id)
{
    $query  = mysql_query("SELECT `userid`,`name`, `email` FROM `user` where `userid` = '$id'");
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


/****************************Sign In GetSporty [Function]*******************************/

public function gsSignIn($email,$password1,$token)
{

$query = mysql_query("SELECT `userid`,`name`, `email` ,`device_id` FROM `user` WHERE `email` = '$email' AND `password` = '$password1'");
  $row  = mysql_num_rows($query);
  
    if($row)
        {
          while($row = mysql_fetch_assoc($query))
          {   if($data['device_id'] != $token)
               {
                mysql_query(" UPDATE `user` SET `device_id` = '$token' WHERE `email` = '$email' AND `password` = '$password1'");
               }
              $data= $row; 
          }
          return $data;
          } 
          else
          {
          return 0;
          }
  }

/****************************Listing Resources GetSporty [Function]*************************/

public function getList()
{
$query = mysql_query("SELECT *FROM `gs_resources` ORDER by `date_created` desc ");
  $row  = mysql_num_rows($query);
  if($row > 0)
  {
   while ($row = mysql_fetch_assoc($query))
   {   
       $des1=strip_tags($row['description']); 
       $desc  = preg_replace("/[^a-zA-Z 0-9]+/", "", $des1);
       $row['description'] = $desc;
       $sum1=strip_tags($row['summary']);
       $sum=preg_replace("/[^a-zA-Z 0-9]+/", "", $sum1);
       $row['summary'] = $sum; 
       $row['fav'] = '0';
       $data[] = $row;
  }
  return $data;
   }
  else
  {
  return 0;
  }
}


/****************************Listing  for Sports GetSporty [Function]**************/

public function Get_Sports()
{
$query = mysql_query("SELECT `sports` FROM `gs_sports` where 1  ");
  $row  = mysql_num_rows($query);
  if($row)
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


/****************************Listing for Location GetSporty [Function]**************/

public function Get_Location()
{
$query = mysql_query("SELECT `name` FROM `gs_city` where 1 GROUP BY `name` ORDER BY `name` ASC ");
  $row  = mysql_num_rows($query);
  if($row)
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


/******************** Seraching [Function]******************************/


public function GetSearch($where)
{
    $query = mysql_query("SELECT * FROM `gs_resources` where ".$where);
    if(mysql_num_rows($query) > 0)
    {
    while($row = mysql_fetch_assoc($query))
    {
       $des1=strip_tags($row['description']); 
       $desc  = preg_replace("/[^a-zA-Z 0-9]+/", "", $des1);
       $row['description'] = $desc;
       $sum1=strip_tags($row['summary']);
       $sum=preg_replace("/[^a-zA-Z 0-9]+/", "", $sum1);
       $row['summary'] = $sum; 
       $row['fav'] = '0';
       $rows[] = $row;
        }
          return $rows;
        } 
        else
        {
          return 0;
        }
}




/************************ Get Details of Resources[Function]*****************/

public function getDetail($userid)
{
$query = mysql_query("SELECT * FROM `gs_resources` where `id`=$userid ");
if(mysql_num_rows($query)>0)
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


/************************ Get favourites of Resources [Function]*****************/

 public function favourites($user_id, $module , $user_favs)
  {
    $record = mysql_query("SELECT * FROM `users_fav` WHERE `userid` = '$user_id' AND `module` = '$module' ");
  if(mysql_num_rows($record) < 1)
     {
         $query = mysql_query("INSERT INTO `users_fav`(`id`, `userid`, `userfav`, `module`) VALUES ('','$user_id','$user_favs','$module')");
      if ($query)
      {
        return 1;
      }
      else
      {
        return 0;
      }
  }
  else
  {
             while($data = mysql_fetch_assoc($record))
          {
                $row = $data;
                return $row;
               
          }   
      }
   }


public function updatefav($id,$user_id,$data)
{
  $data = rtrim($data,"");
  $data = rtrim($data,",");
$query = mysql_query("UPDATE `users_fav` SET `userfav` = '$data' WHERE `userid` = '$user_id' AND `id` = '$id' ");
if($query)
{
  return 1;
}else
{
  return 0;
}
}


/*************** Save Token When user is first instal APPS [Function]********/

public function saveToken($token)
  {

    $query = mysql_query("SELECT `token_id` FROM `get_token` USE INDEX (`token_id`) WHERE `token_id` = '$token'");
    if(mysql_num_rows($query) < 1)
      {

        $insert = mysql_query("INSERT INTO `get_token` (`id`,`token_id`) VALUES ('','$token')");
        if($insert)
        {
          return 1;
        }else{
          return 0;
        }
      }else{
        return 1;
      }
  }


/*************************Get The Favourate [Function]*********************************/


public function getfav($id,$type)
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

  
public function get_fvdata($fwhere)
  {

    $query = mysql_query("SELECT *FROM `gs_resources` where `id` IN (".$fwhere.")" );
   if(mysql_num_rows($query)>0)
   {
   while($row = mysql_fetch_assoc($query))
   {  
       $des1=strip_tags($row['description']); 
       $desc  = preg_replace("/[^a-zA-Z 0-9]+/", "", $des1);
       $row['description'] = $desc;
       $sum1=strip_tags($row['summary']);
       $sum=preg_replace("/[^a-zA-Z 0-9]+/", "", $sum1);
       $row['summary'] = $sum; 
       $row['fav'] = 1;
      $data[] = $row;
   }
   return $data;
}
else{
  return 0;
   }
}


/************* Subscribed The Application by User [Function]************************/

public function getsubscribed($userid)
{
  $query = mysql_query("SELECT  *FROM `gs_subscribed` WHERE `userid` = '$userid' AND `Moudule` = '6'");
  if(mysql_num_rows($query)>0)
  {

  while ($row = mysql_fetch_assoc($query)) {
    return $row;
  }
}
  else
  {
    return 0;
  }

  }


/******************Save the Subscribe query [Function]*************************/

public function saveSubscribe($userid , $where, $textjson)
  { //echo "INSERT INTO `gs_subscribed`(`id`, `userid`, `search_para`, `Moudule`, `count`, `subscribe`, `date`,`para_json`) VALUES ('','$userid','$where','6','0','1',CURDATE(),'$textjson')";die;
    if($this->getsubscribed($userid) == 0)
    {
     $query = mysql_query("INSERT INTO `gs_subscribed`(`id`, `userid`, `search_para`, `Moudule`, `count`, `subscribe`, `date`,`para_json`) VALUES ('','$userid','$where','6','0','1',CURDATE(),'$textjson')");
    }else
    {
      $query = mysql_query("UPDATE `gs_subscribed` SET `search_para` = '$where',`subscribe`  = '1' ,`para_json` = '$textjson' WHERE `userid` = '$userid' AND `Moudule` = '6' ");
    }
    if($query)
    {
    return 1;
    }else
    {
    return 0;
    }
  }

public function getSubs($userid,$module)
{

$query = "SELECT `para_json` FROM `gs_subscribed` WHERE `userid` = '$userid' AND `Moudule` = '$module'";
$exec = mysql_query($query);
if(mysql_num_rows($exec) > 0)
{
while ($row = mysql_fetch_assoc($exec)) {
$rows[] = json_decode($row['para_json']);
}
//print_r($rows);die;
return $rows;

}else{
return false;
}
 

}
/****************Create Resource [Share Story here] [Function] *******************************/


// public function getCreate($data)
// {
//   $title             = $data->title;
//   $summary           = $data->summary; 
//   $url               = $data->link;
//   $image             = $data->photo;
//   $topic_artical     = $data->topic_artical; 
//   $sports            = $data->sports;
//   $location          = $data->location;
// $query  = mysql_query("INSERT INTO `gs_resources`(`id`,`title`,`summary`,`url`,`topic_of_artical`,`sport`,`location`,`date_created`) VALUES ('','$title ','$summary','$url','$topic_artical ','$sports',' $location ',CURRENT_DATE)");


//   if($query)
//   { 
//     $id = mysql_insert_id();
//     if($id!=NULL && $image!=NULL)
//     {
//      $image = $this->imageupload($image,$id,$title);
//     }
//   return 1;
//   }
//   else
//     {
//       return 0;
//     }


// }

// ***************Function for Upload Image in Create Resource***********************


// public function imageupload($image,$id,$title)
// {
//   define('UPLOAD_DIR','gs_images/Resources/');
//   $img = $image;

//   $img = str_replace('data:image/png;base64,', '', $img);
//   $img = str_replace('$filepath,', '', $img);
//   $img = str_replace(' ', '+', $img);
//   $data = base64_decode($img);
//   $img_name = $id.'_'.$title;
//   $success=move_uploaded_file($img, $filepath);
//   $file = UPLOAD_DIR .$img_name. '.png';
//   $success = file_put_contents($file, $data);
//   if($success)
//   {
//     $img_name = $img_name. '.png';
//     $updateImage = mysql_query("update `gs_resources` set `image`='$img_name' where `id`='$id'");
//   if($updateImage)
//   {
//     return 1;
//   }
//   }
//   else
//     {
//       echo "image not uploaded";
//       return 0;
//     }


// }















} // End Class