<?php 
include('../config.php');
include('Controller/userdatabaseservice.php');

/****************Sign Up in Getsporty***********************/

if($_POST['act']=='gs_signup')
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
     $status = array('status' => 0, 'message' => 'User is  already Registered');
     $data1=array('data' =>$status);
     echo json_encode($data1); 
    }
   else
   {
   $req1 = new userdataservice();

   $res1 = $req1->GsUserRegister($data);
   if($res1 == '1')
   {
   $req2 = new userdataservice();
   $res2 = $req2->userExits($where);
   if($res2 != 0)
   {
   $res3 = array('data' => $res2,'status' => 1);
   echo json_encode($res3);  
   }
   }
   else
   {
   $res3 = array('data' => 'Record not saved','status' => 0);
   echo json_encode($res3);  
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
  //echo "ram";die();
    $req           =  new userdataservice();
    $res           =  $req->getList();
    if($res)
    {   
  //foreach ($res as $key => $value)
  // {
     // $value['description']  = preg_replace("/[^a-zA-Z 0-9]+/", "", $value['description']);
      //$value
       $data = array('data'=>$res,'status'=>'1');
       echo json_encode($data);
    //}
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
      //echo "sasaa"; exit;   
   $res         =  $req->GetSearch($where);
    }
    else
    {
      $data = array('data'=>'0' , 'status'=>'0');
        echo json_encode($data);exit;
          }
    if($res)
    {   

        $data = array('data'=>$res,'status'=>'1');
        echo json_encode($data);
  
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
  $userid         =  urldecode(($_POST ['id']));
  $req             =  new userdataservice();
  $res             =  $req->getDetail($userid);
    if($res)
    {   
        $data = array('data'=>$res,'status'=>'1');
        echo json_encode($data);
    }
    else
    {
       $data = array('data'=>'0' , 'status'=>'0');
        echo json_encode($data);
    }
}
















?>











