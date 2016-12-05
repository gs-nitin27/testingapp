<?php
include('../config.php');
include('liteservice.php');

/****************Sign Up in Getsporty***********************/

if($_POST['act'] == 'gs_signup')
{
    $name       =  urldecode($_POST ['name']);
    $email      =  urldecode($_POST ['email']);
    $password1  =  md5(urldecode(@$_POST ['password']));
    $token      =  urldecode($_POST['tokin_id']);
    $where      =  "WHERE `email` = '".$email."'";
    $req        =  new liteservice();
    $res        =  $req->userExits($where);
    $data       =  array('name'=>$name,'email'=>$email,'password'=> $password1,'token'=> $token);
      if($res)
      {
         $req3        = array('data' => $res,'message' => 'User is  already Registered','status' => 0);
         echo json_encode($req3); 
      }
      else
      {
        $req1     = new liteservice();
        $res1     = $req1->GsUserRegister($data);
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
      $token         = urldecode($_REQUEST['tokin_id']);
      $req           = new liteservice();
      $res           = $req->gsSignIn($email,$password1,$token);
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
        if(!isset($_REQUEST['user_id']) || $_REQUEST['user_id'] == '')
        { 
            $data1 = array('data'=>$res,'status'=>'1');
            echo json_encode($data1);
        }
        else
        { 
        $userid        =  urldecode($_REQUEST['user_id']);
        $res2          = $req->getfav($userid,$module);
              if($res2 != 0 && $res2['userfav'] != '')
              {
                $res2 = split(",", $res2['userfav']);
                foreach ($res as $key => $value)
                {
                    if(in_array($res[$key]['id'], $res2))
                    {
                    $res[$key]['fav'] = '1';
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


/************  Drop Down Sports  ************************/

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


/************  Drop Down City************************/

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

/**************Searching Resource*****************/

else if($_REQUEST['act']=="gs_search")
{
   $key          =  urldecode($_REQUEST ['key']);
   $sports       =  urldecode($_REQUEST ['sports']);
   $location     =  urldecode($_REQUEST ['location']);
   $topic        =  urldecode($_REQUEST ['topic']);
   $user_id      =  urldecode($_REQUEST ['user_id']);
   $req          =  new liteservice();
   $module       = '6';
     if($sports != '')
     {
       $where[] = " `sport` = '$sports' ";
     }
     if($location != '')
     {
       $where[] = " `location` = '$location' ";
     }
     if($topic != '')
     {
       $where[] = " `topic_of_artical` = '$topic' ";    
     }
     if($key != '')
     {
       $where[] = " `Description` LIKE '%$key%' ";    
     }
       $whereclause = implode('AND', $where);
       $res = $req->GetSearch($whereclause);
     if($res != 0)
      { 
           if(!isset($_REQUEST['user_id']))
           { 
            $data1 = array('data'=>$res,'status'=>'1');
            echo json_encode($data1);
           }
           else
           { 
              $userid        =  urldecode($_REQUEST['user_id']);
              $res2          = $req->getfav($userid,$module);
              if($res2 != 0 && $res2['userfav'] != '')
              {
              $res2 = split(",", $res2['userfav']);
                foreach ($res2 as $key => $value1) 
                {
                  foreach ($res as $key => $value)
                  {
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
  $resource_id     =  urldecode($_REQUEST['id']);
  $fav             =  urldecode($_REQUEST['fav']);
  $req             =  new liteservice();
  $res             =  $req->getDetail($resource_id);
  $type            = '6';
   if($res != 0)
    {
     foreach ($res as $key2 => $value)
     {
       $res[$key2]['description']; 
       $res[$key2]['summary'];
       $des1   = strip_tags($value['description']);
       $res[$key2]['description'] = $des1;
       $sum1 = strip_tags($value['description']);
       $res[$key2]['summary'] = $sum1; 
       $res[$key2]['fav'] =$fav;
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



/******FAVOURITE BY THE USER****************/



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


/***************GET FAVOURATE*******************/


else if($_POST['act'] == "gs_getfav")
{
 
  $id   = urldecode($_POST ['user_id']);
  $type = urldecode($_POST ['type']);
  $rev  = new liteservice();
  $res  = $rev->getfav($id,$type);
  if($res != 0)
    { 
       $favdata = $res['userfav'];
       $rev1  = $rev->get_fvdata($favdata);
       if($rev1 != 0)
       {
          $data = array('data'=>$rev1,'status' => 1);
         echo json_encode($data);
       }
       else
       {
             $data = array('data'=>0,'status' => 0);
             echo json_encode($data);
       }
    }
}

/***************TOKEN for save*****************/

else if($_POST['act'] == 'get_token')
{
  $token = $_REQUEST['token'];
  $req = new liteservice();
  $res = $req->saveToken($token);
  echo json_encode($res);
}


/**************SUBSCRIBE for save*******************/

else if($_REQUEST['act']=="gs_sub")
{
   $key          =  urldecode($_REQUEST ['key']);
   $sports       =  urldecode($_REQUEST ['sports']);
   $location     =  urldecode($_REQUEST ['location']);
   $topic        =  urldecode($_REQUEST ['topic']);
   $user_id      =  urldecode($_REQUEST ['user_id']);
   $where[]      = ' 1=1 ';
   $arr = array();
   if($sports != '')
   {
     $where[] = " `sport` = '$sports' ";
     $arr['sport'] = $sports;
   }
   else
   {
     $where[] = " `sport` = '$sports' ";
     $arr['sport'] = $sports;
   }
   if($location != '')
   {
     $where[] = " `location` = '$location' ";
     $arr['location'] = $location;
   }
   else
   {
     $where[] = " `location` = '$location' ";
     $arr['location'] = $location;
   }
    if($topic != '')
   {
     $where[] = " `topic_of_artical` = '$topic' "; 
     $arr['topic_of_artical'] = $topic;    
   }
    else
    {
      $where[] = " `topic_of_artical` = '$topic' "; 
      $arr['topic_of_artical'] = $topic; 
    }
   if($key != '')
   {
     $where[] = " `Description` LIKE '%$key%'' ";
     $arr['key'] = $key;    
   }
   else
   {
     $where[] = " `Description` LIKE '%$key%'' ";
     $arr['key'] = $key;  
   }
   $whereclause = implode('AND', $where);
   $req = new liteservice();
   $res = $req->saveSubscribe($user_id , mysql_real_escape_string($whereclause),json_encode($arr)); 

   if($res != 0)
   {
   $data = array('status'=> $res , 'data'=>'Success'); 
   }else
   {
    $data = array('status'=> $res , 'data'=>'Failure');
   }
   echo json_encode($data);
}




/***************Subscribed and Alerts*******************/


  else if($_REQUEST['act'] == 'get_subs')
  {
    $userid    = $_REQUEST['user_id'];
    $module    = '6';
    $req       = new liteservice();
    $res       = $req->getSubs($userid,$module);
        if($res != 0)
        { 
        $data = array('data'=>$res,'user_id'=>$userid,'status'=>'Success');
        }
        else
        {
          $data = array('data'=>$res,'user_id'=>$userid,'status'=>'Failure');
        }
    echo json_encode($data);
  }


/********** Delete The Subscribed **************/




  else if($_REQUEST['act'] == 'un_subs')
  {
   $userid        = $_REQUEST['user_id'];
   $sub_id        = $_REQUEST['id'];
   $module        = '6';
   $req           = new liteservice();
   $res           = $req->delSubs($userid ,$sub_id,$module); 
        if($res != 0)
        {
        $data = array('status'=> $res , 'data'=>'Record is Deleted'); 
        }
        else
        {
        $data = array('status'=> $res , 'data'=>'Record is Not  Exist');
        }
   echo json_encode($data);
  }






/******************Modify The Subscribed *****************/

 else if($_REQUEST['act'] == 'modify_subs')
 {
   $user_id      =  urldecode($_REQUEST ['user_id']);
   $sub_id       =  urldecode($_REQUEST['id']) ;
   $key          =  urldecode($_REQUEST ['key']);
   $sports       =  urldecode($_REQUEST ['sports']);
   $location     =  urldecode($_REQUEST ['location']);
   $topic        =  urldecode($_REQUEST ['topic_of_artical']);
    $module = '6';
   $where[]      = ' 1=1 ';
   $arr = array();
   if($sports != '')
   {
     $where[] = " `sport` = '$sports' ";
     $arr['sport'] = $sports;
   }
   else
     {
     $where[] = " `sport` = '$sports' ";
     $arr['sport'] = $sports;
     }
   
   if($location != '')
   {
     $where[] = " `location` = '$location' ";
     $arr['location'] = $location;
   }
   else
   {
     $where[] = " `location` = '$location' ";
     $arr['location'] = $location;
   }
    if($topic != '')
   {
     $where[] = " `topic_of_artical` = '$topic' "; 
     $arr['topic_of_artical'] = $topic;    
   }
    else
    {
      $where[] = " `topic_of_artical` = '$topic' "; 
      $arr['topic_of_artical'] = $topic; 
    }
   if($key != '')
   {
     $where[] = " `Description` LIKE '%$key%'' ";
     $arr['key'] = $key;    
   }
   else
   {
     $where[] = " `Description` LIKE '%$key%'' ";
     $arr['key'] = $key;  
   }
   $whereclause = implode('AND', $where);
   $req = new liteservice();
   $res = $req->modify($user_id ,$sub_id ,mysql_real_escape_string($whereclause),json_encode($arr),$module); 
   if($res != 0)
   {
   $data = array('status'=> $res , 'data'=>'Record is Modify'); 

   }
   else
   {
    $data = array('status'=> $res , 'data'=>'Record is Not  Modify');
   }
   echo json_encode($data);
   }



 
/*********************Forget Password*********************/


 else if($_REQUEST['act']=='forget_pass')
  {
     $email      =  urldecode($_REQUEST['user_email']);
     $where      =  "WHERE `email` = '".$email."'";
     $req        =  new liteservice();
     $res        =   $req->userExits($where);
     if($res)
     {
         $req1        =    new liteservice();
         $res1        =    $req1->forgetPass($email); 
            if($res1)
           {
              $res1  = array('data'=>'OTP Code are send to your Email id', 'status'=>'1');
              echo json_encode($res1);
             exit();
           }
           else
            {
              $res2  = array('data'=>'OTP Code are Not send  to your Email id', 'status'=>'0');
              echo json_encode($res2);
              exit();
            }
              $res3  = array('data'=>'Email id is Registered', 'status'=>'1');
              echo json_encode($res3);
      }
      else
      {
          $res4  = array('data'=>'Email id is Not Registered', 'status'=>'0');
          echo json_encode($res4);
      }
}

    
/******************Change The Password************/


else if($_REQUEST['act']=='change_pass')
{
    $otp_code          =   @$_POST['otp_code'];
    $new_password      =   @$_POST['new_password'];
    $req               =  new liteservice();
    $res             =   $req->change_passwrod($otp_code,$new_password);
        if($res)
        {
        $res1  = array('data'=>'Password Successfully change', 'status'=>'1');
        echo json_encode($res1);
        exit();
        }
        else
        { 
         $res2  = array('data'=>'OTP Code is Wrong', 'status'=>'0');
         echo json_encode($res2);
         exit();
        }
}




/***************Code for Create Resource [Share Story here]  ****************/

else if($_REQUEST['act'] == "gs_create")
{
	  $data = json_decode($_REQUEST['data']);
	   $req = new liteservice();
	  $res = $req->getCreate($data);
	  if($res != 0)
	  {
	  $resp = array('status'=>$res ,  'message'=>'Resource has been created');
	  echo json_encode($resp);
	  }
	  else
	  {
	   $resp = array('status'=>$res ,  'message'=>'Resource has not been created'); 
	  echo json_encode($resp);
	  }
}


?>







       

            



