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
   $req        =  new userdataservice();
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
   $req1 = new userdataservice();
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
    //echo "ram";die();
    $email         = urldecode($_REQUEST['email']);
    $pass          = md5(urldecode($_REQUEST['password']));
    $username      = mysql_real_escape_string($email);
    $password1     = mysql_real_escape_string($pass);
    $req           =  new userdataservice();
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
    $req           =  new userdataservice();
    $userid        = urldecode($_POST ['userid']);
    $res           =  $req->getList();
    $type          = '6'; 
   if($res)
    { 
      $res1 = $req->getfav($userid,$type);  
      $favid = split(",", $res1['userfav']);
    foreach ($res as $key => $value)
     {
       $res[$key]['description']; 
       $desc  = preg_replace("/[^a-zA-Z 0-9]+/", "", $value['description']);
       $res[$key]['description'] = $desc;
        foreach ($favid as $key2 => $value1) 
       {
         if($res[$key]['id'] == $value1 && $userid!= '')
         { 
          $res[$key]['fav'] = '1';
         }else{
          $res[$key]['fav'] = '0';
         }
       }
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


/****************************Searching The Resources *******************************/

else if($_REQUEST['act']=="gs_sports")
{ 
    $req           =  new userdataservice();
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

    $req           =  new userdataservice();
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
   $req          =  new userdataservice();
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
    if($res)
    {   
    foreach ($res as $key1 => $value)
     {
       $res[$key1]['description']; 
       $desc  = preg_replace("/[^a-zA-Z 0-9]+/", "", $value['description']);
       $res[$key1]['description'] = $desc;
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
  


/****************************Details of Resources *******************************/

else if($_REQUEST['act']=="gs_detail")
{ 
  $userid          =  urldecode(($_POST ['id']));
  $req             =  new userdataservice();
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
       foreach ($favid as $key => $value1) 
       {
         if($res[$key2]['id'] == $value1)
         {
          $res[$key2]['fav'] = '1';
         }else{
          $res[$key2]['fav'] = '0';
         }
       }
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
$rev = new userdataservice();
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
$res = new userdataservice();
$rev = $res->updatefav($id,$user_id,$data);
if($rev == 1)
echo 0;
}
else if($favourite == "")
{
$favourite =  $res['userfav'];
$id        = $res['id'];
$res       = new userdataservice();
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
$res = new userdataservice();
$rev = $res->updatefav($id,$user_id,$data);
echo json_encode($rev);
     }
  }
}


/***************Code for GET Favourate*******************/


else if($_POST['act'] == "gs_getfav")
{
  //echo "ram";die();
$id   = urldecode($_POST ['id']);
$type = urldecode($_POST ['type']);
$rev  = new userdataservice();
//echo "$id";die();
$res  = $rev->getfav($id,$type);

if($res != 0)
{

$favdata = $res['userfav'];
$res1  = new userdataservice();
$rev1  = $res1->get_fvdata($favdata);//die;
$favdata = split(",",$favdata);

         $data = array('data'=>$rev1,'status' => 1);
         echo json_encode($data);
   }else
         $data = array('data'=>0,'status' => 0);
         echo json_encode($data);
}













?>











