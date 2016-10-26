 <?php
  class userdataservice
  { 
  
  /*******************Check The User is Already Exits [Function]*************/

  public function  userExits($where)
  {
   $query  = mysql_query("SELECT `id`,`name`, `email` FROM `gs_signup` ".$where);
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
$query =mysql_query("INSERT INTO `gs_signup`(`id`, `name`, `email`, `password`) VALUES('','$name','$email','$password1')");
     if($query)
     {
     $id = mysql_insert_id();
    if($id!=NULL)
    {
     $data1 = $this->userdata();
    }
  return $data1;
   } 
    else
     {    
          return 0;
     }  
  }

public function userdata()
{
    $query  = mysql_query("SELECT `id`,`name`, `email` FROM `gs_signup` where 1");
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
public function gsSignIn($email,$password1)
{
$query = mysql_query("SELECT `id`,`name`, `email` FROM `gs_signup` WHERE `email` = '$email' AND `password` = '$password1' ");
  $row  = mysql_num_rows($query);
  
    if($row)
        {
          while($row = mysql_fetch_assoc($query))
          {
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


$query = mysql_query("SELECT * FROM `gs_resources` ORDER by `date_created` ");

 
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
$query = mysql_query("SELECT `name` FROM `gs_city` where 1 ");
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


/******************** New Seraching******************************/


public function GetSearch( $where)
  {
      $query = mysql_query("SELECT * FROM `gs_resources` where ".$where);
      $query1 = $query;
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




/************************ Get Details of Resources*****************/

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

/************************ Get favourites of Resources*****************/

 public function favourites($user_id, $module , $user_favs)
  {
    //echo "SELECT * FROM `users_fav` WHERE `userid` = '$user_id' AND `module` = '$module' ";die();
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



/*************************Get The Favourate*********************************/


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
  $query = mysql_query("SELECT `id`,`userid`, `title`,`sport`,`description`,`url`,`date_created`,`image`,`video_link`,`location` FROM `gs_resources` where `id` IN (".$fwhere.")" );

   if(mysql_num_rows($query)>0){
   while($row = mysql_fetch_assoc($query))
   {  $desc  = preg_replace("/[^a-zA-Z 0-9]+/", "", $row['description']);
      $row['description'] = $desc;
      $row['fav'] = 1;
      $data[] = $row;

   }
   
   return $data;
}
else{
  return 0;
   }
}


























} // End Class