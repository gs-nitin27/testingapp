 <?php
  class userdataservice
  {
  
  /*******************Check The User is Already Exits [Function]*************/

  public function  userExits($where)
  {
   $query  = mysql_query("SELECT * FROM `gs_signup` ".$where);
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
          return 1;
     }
     else
     {    
          return 0;
     }  
  }

/****************************Sign In GetSporty [Function]*******************************/
// public function utf8ize($d) {
//     if (is_array($d)) {
//         foreach ($d as $k => $v) {
//             $d[$k] = utf8ize($v);
//         }
//     } else if (is_string ($d)) {
//         return utf8_encode($d);
//     }
//     return $d;
// }
/*****************/

/****************************Sign In GetSporty [Function]*******************************/
public function gsSignIn($email,$password1)
{
$query = mysql_query("SELECT `name`, `email` FROM `gs_signup` WHERE `email` = '$email' AND `password` = '$password1' ");
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

//  $query    = mysql_query("SELECT * FROM `gs_resources` WHERE `id`=11 ");
  //SELECT * FROM `gs_resources` ORDER by `date_created`
$query = mysql_query("SELECT `sports` FROM `gs_sports` where 1  ");

 //$data =array();
  $row  = mysql_num_rows($query);
  if($row)
  {
   while ($row = mysql_fetch_assoc($query))
   {
  
    $data[] = $row;
   // print_r($row);die();
  //foreach ($data as  $value) {
   // print_r($value);die();
}
//foreach ($data as  $value) 
//{
//print_r($value['description']);
//$temp[] = preg_replace("/[^a-zA-Z 0-9]+/", "", $value['description']);




//die();
   //$temp[] = preg_replace("/[^a-zA-Z 0-9]+/", "", $data[]['description']);

   
  // $json = $temp;
    //$json = $temp;
    //print_r($json);die();
 //$data['description'];die();
  // return $json;
 //  print_r($data);die();
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

//  $query    = mysql_query("SELECT * FROM `gs_resources` WHERE `id`=11 ");
  //SELECT * FROM `gs_resources` ORDER by `date_created`
$query = mysql_query("SELECT `city` FROM `location` where `status`=1 ");

 //$data =array();
  $row  = mysql_num_rows($query);
  if($row)
  {
   while ($row = mysql_fetch_assoc($query))
   {
  
    $data[] = $row;
   
}
//foreach ($data as  $value) 
//{
//print_r($value['description']);
//$temp[] = preg_replace("/[^a-zA-Z 0-9]+/", "", $value['description']);




//die();
   //$temp[] = preg_replace("/[^a-zA-Z 0-9]+/", "", $data[]['description']);

   
  // $json = $temp;
    //$json = $temp;
    //print_r($json);die();
 //$data['description'];die();
  // return $json;
 //  print_r($data);die();
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
 // echo "SELECT * FROM `gs_resources` where `id`=$userid "; die();
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




















} // End Class