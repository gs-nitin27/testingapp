<?php 
include('../config.php');
include('liteservice.php');

/****************Sign Up in Getsporty***********************/

if($_POST['act'] == 'gs_signup')
{
   $name       =  urldecode($_POST ['name']);
   $email      =  urldecode($_POST ['email']);
   $password1  =  md5(urldecode(@$_POST ['password']));
   $where      =  "WHERE `email` = '".$email."'";
   $req        =  new liteservice();
   $res        =  $req->userExits($where);
   $data       =  array('name'=>$name,'email'=>$email,'password'=> $password1);
    if($res)
    {
     $status = array('status' => $res, 'message' => 'User is  already Registered');
     $data1=array('data' =>$status);
     echo json_encode($data1); 
    }
   else
   {
    $req1 = new liteservice();

   $res1 = $req1->GsUserRegister($data);
   
    if($res1)
   {
    $res2 = array('data' => $res1,'status' => 1);
    echo json_encode($res2);
    }
   else
   {
   $res2 = array('data' => 'Record not saved','status' => 0);
   echo json_encode($res2);  
   }
   }
} 

/****************************Sign In GetSporty*******************************/

else if($_REQUEST['act']=="gs_login")
  {
    $email         = urldecode($_REQUEST['email']);
    $pass          = md5(urldecode($_REQUEST['password']));
    $username      = mysql_real_escape_string($email);
    $password1     = mysql_real_escape_string($pass);
    $req           =  new liteservice();
    $res           =  $req->gsSignIn($email,$password1);
    if($res)
      {
        $data = array('data'=>$res,'status'=>'1');
        echo json_encode($data);
      }
      else
      {
        $data = array('data'=>'Invalid login credentials' , 'status'=>'0');
        echo json_encode($data);
      }
  }
/****************************Listing The Resources *******************************/

else if($_REQUEST['act']=="gs_list")
{ 
    $req           =  new liteservice();
    $res           =  $req->getList();
    $module        = '6';
   if($res != 0)
       {
    if(!isset($_REQUEST['user_id']))
    { 
      $data1 = array('data'=>$res,'status'=>'1');
       echo json_encode($data1);
    }else
    { 
      $userid        =  urldecode($_REQUEST['user_id']);
      $res2          = $req->getfav($userid,$module);
       if($res2 != 0 && $res2['userfav'] != '')
       {
           $res2 = split(",", $res2['userfav']);
           foreach ($res2 as $key => $value1) {
            foreach ($res as $key => $value) {
            if($res[$key]['id'] == $value1)
            {
               $res[$key]['fav'] = '1';
              }
             }
            }
       }
       $data1 = array('data'=>$res,'status'=>'1');
       echo json_encode($data1);
    }
  }
    else
    {
       $data = array('data'=>'0' , 'status'=>'0');
       echo json_encode($data);
    }
}


/****************************Searching The Resources *******************************/

else if($_REQUEST['act']=="gs_sports")
{ 
    $req           =  new liteservice();
    $res           =  $req->Get_Sports();
    if($res)
    {   
        $data = array('sports'=>$res);
        $data = array('data'=>$data,'status'=>'1');
        echo json_encode($data);
     }
    else
    {
       $data = array('data'=>'0' , 'status'=>'0');
        echo json_encode($data);
    }
}
else if($_REQUEST['act']=="gs_location")
{ 

    $req           =  new liteservice();
    $res           =  $req->Get_Location();
    if($res)
    {   
      $data = array('location'=>$res);
      $data = array('data'=>$data,'status'=>'1');
      echo json_encode($data);
    }
    else
    {
       $data = array('data'=>'0' , 'status'=>'0');
        echo json_encode($data);
    }
}
/****************************Searching The Resources *******************************/

else if($_REQUEST['act']=="gs_search")
{
   $key          =  urldecode(@($_POST ['key']));
   $sports       =  urldecode((@$_POST ['sports']));
   $location     =  urldecode(@($_POST ['location']));
   $topic        =  urldecode(@($_POST ['topic']));
   $user_id      =  urldecode(@($_POST['user_id']));
   $req          =  new liteservice();
   $module       = '6';
   $where = '';
   $flag = 0;
       if(isset($sports) && trim($sports) != '')
       {
       $flag =1;
       $where .= " `sport`='$sports'";
       }
      if(isset($location) && trim($location) != '')
      {
        if($flag == 1)
        {
          $and = ' AND ';
        }
        else
        {
          $and = '';
          $flag =1;
        }
        $where .= $and." `location`='$location'";
       }
    if(isset($topic) && trim($topic) != '')
    {
      if($flag == 1)
      {
          $and = ' AND ';
      } 
      else
      {
          $and = '';
          $flag =1;
      }
        $where .= $and." `title`='$topic'";
    }

    if((isset($key) && trim($key) != '') && $flag == 1)
    {
        $where .= " AND `description` like '%$key%'";
    }
    if($where != '')
    {
      $res         =  $req->GetSearch($where);
    }
    else
    {
      $data = array('data'=>'0' , 'status'=>'0');
        echo json_encode($data);exit;
          }
    if($res != 0)
    { 
     if(!isset($_REQUEST['user_id']))
    { 
      $data1 = array('data'=>$res,'status'=>'1');
       echo json_encode($data1);
    }else
    { 
      $userid        =  urldecode($_REQUEST['user_id']);
      $res2          = $req->getfav($userid,$module);
       if($res2 != 0 && $res2['userfav'] != '')
       {
           $res2 = split(",", $res2['userfav']);
           foreach ($res2 as $key => $value1) {
            foreach ($res as $key => $value) {
            if($res[$key]['id'] == $value1)
            {
               $res[$key]['fav'] = '1';
              }
             }
            }
       }
       $data1 = array('data'=>$res,'status'=>'1');
       echo json_encode($data1);
    }
    }
    else
    {
        $data = array('data'=>'0' , 'status'=>'0');
        echo json_encode($data);
    }
}
  


/****************************Details of Resources *******************************/

else if($_REQUEST['act']=="gs_detail")
{ 
  $userid          =  urldecode(($_POST ['id']));
  $req             =  new liteservice();
  $res             =  $req->getDetail($userid);
  $type            = '6';
    if($res != 0)
    {
    $res1 = $req->getfav($userid,$type);  
    $favid = split(",", $res1['userfav']);
    foreach ($res as $key2 => $value)
     {
       $res[$key2]['description']; 
       $desc  = preg_replace("/[^a-zA-Z 0-9]+/", "", $value['description']);
       $res[$key2]['description'] = $desc;
       // foreach ($favid as $key => $value1) 
       // {
       //   if($res[$key2]['id'] == $value1)
       //   {
       //    $res[$key2]['fav'] = '1';
       //   }else{
       //    $res[$key2]['fav'] = '0';
       //   }
       // }
     }
       $data1 = array('data'=>$res,'status'=>'1');
       echo json_encode($data1);
    }
    else
    {
       $data = array('data'=>'0' , 'status'=>'0');
        echo json_encode($data);
    }
}

/******CODE FOR MARKING SEARCH RECORDS AS FAVOURITE BY THE USER [act]****************/

else if ($_POST['act'] == "gs_fav" )
{
$user_id   =urldecode(@$_POST['user_id']);
$module    =urldecode(@$_POST['type']);
$user_favs =urldecode(@$_POST['id']);
$rev = new liteservice();
$res = $rev->favourites($user_id, $module , $user_favs);
if($res == 1)
{
echo json_encode($res);
}
else
{
$favourite  =  $res['userfav'];
$favo_array = split(",",$favourite);
if(in_array($user_favs, $favo_array))
{
$res1 = array_search($user_favs, $favo_array);
unset($favo_array[$res1]);
$data = implode(",",$favo_array);
$id   = $res['id'];
$res = new liteservice();
$rev = $res->updatefav($id,$user_id,$data);
if($rev == 1)
echo 0;
}
else if($favourite == "")
{
$favourite =  $res['userfav'];
$id        = $res['id'];
$res       = new liteservice();
$rev       = $res->updatefav($id,$user_id,$user_favs);
echo json_encode($rev);
}
else if(!in_array($user_favs, $favo_array))
{
$favourite  = $res['userfav'];
$id         = $res['id'];
$favo_array = split(",",$favourite);
$add        = array_push($favo_array,$user_favs);
$data       = implode(",",$favo_array);
$res = new liteservice();
$rev = $res->updatefav($id,$user_id,$data);
echo json_encode($rev);
     }
  }
}


/***************Code for GET Favourate*******************/


else if($_POST['act'] == "gs_getfav")
{
$id   = urldecode($_POST ['user_id']);
$type = urldecode($_POST ['type']);
$rev  = new liteservice();
$res  = $rev->getfav($id,$type);

if($res != 0)
  { 

  $favdata = $res['userfav'];
  $rev1  = $rev->get_fvdata($favdata);//die;
  if($rev1 != 0){
           $data = array('data'=>$rev1,'status' => 1);
           echo json_encode($data);
     }else
           $data = array('data'=>0,'status' => 0);
           echo json_encode($data);
  }

}
else if($_POST['act'] == 'get_token')
{
$token = $_REQUEST['token'];
$req = new liteservice();
$res = $req->saveToken($token);
echo json_encode($res);
}

else if($_REQUEST['act']=="gs_sub")
{
   $key          =  urldecode(@($_POST ['key']));
   $sports       =  urldecode((@$_POST ['sports']));
   $location     =  urldecode(@($_POST ['location']));
   $topic        =  urldecode(@($_POST ['topic']));
   $user_id      =  urldecode(@($_POST['user_id']));
   $where[]      = ' 1=1 ';
   if($sports != '')
   {
     
     $where[] = " `sport` = '$sports' ";

   }if($location != '')
   {

     $where[] = " `location` = '$location' ";

   }
   if($topic != '')
   {

     $where[] = " `title` = '$topic' ";    
   }
   if($key != '')
   {

     $where[] = " `Description` LIKE '%$key%'' ";    
   }
   $whereclause = implode('AND', $where);
   $req = new liteservice();
   $res = $req->saveSubscribe($user_id , mysql_real_escape_string($whereclause)); 
   if($res != 0)
   {
   $data = array('status'=> $res , 'data'=>'Success'); 
   }else
   {
    $data = array('status'=> $res , 'data'=>'Failure');
   }
  echo json_encode($data);
}
?>











