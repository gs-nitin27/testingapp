<?php
include('../config1.php');
include('liteservice.php');
//include('config1.php');
include('../services/userdataservice.php');

/****************Sign Up in Getsporty***********************/



if($_REQUEST['act'] == 'gs_signup')
{
    $name             =  urldecode($_REQUEST ['name']);
    $email            =  urldecode($_REQUEST ['email']);
    $password1        =  md5(urldecode(@$_REQUEST ['password']));
    $device_id        =  urldecode($_REQUEST['device_id']);
    $facebook_status  =  urldecode($_REQUEST['facebook_status']);
    $where      =  "WHERE `email` = '".$email."'";
    $req        =  new liteservice();
    $res        =  $req->userExits($where);
    $data       =  array('name'=>$name,'email'=>$email,'password'=> $password1,'device_id'=> $device_id,'facebook_status'=>$facebook_status);
      if($res)
      {
         $req1        = array('data' => $res,'message' => 'User is  already Registered','status' => 0);
         echo json_encode($req1); 
      }
      else
      {
        $req2     = new liteservice();
        $res3     = $req2->GsUserRegister($data);
            if($res3)
            {
             $res4 = array('data' => $res3,'status' => 1);
             echo json_encode($res4);
            }
            else
            {
             $res5 = array('data' =>$res4, 'message'=> 'User record not exit','status' => 0);
             echo json_encode($res5);  
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
      $device_id     = urldecode($_REQUEST['device_id']);
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

    $req            =  new liteservice();
    $res            =  $req->getList();
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
       $data = array('data'=>'0' , 'message'=>'Resources is not Found','status'=>'0');
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
    if($key != '')
      {
      $where        =  " `summary` LIKE '%$key%' ";  
      }
      else
      {
      $where          =  " `summary` ='' ";
      }
     $user_id      =  urldecode($_REQUEST ['user_id']);
     $req          =  new liteservice();
     $module       = '6';
     $res = $req->GetSearch($where);
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
        $data = array('data'=>'0' ,'message'=>'Record is not Searching', 'status'=>'0');
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
       $sum1 = strip_tags($value['summary']);
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

else if ($_REQUEST['act'] == "gs_fav" )
{
  $user_id   =urldecode(@$_REQUEST['user_id']);
  $module    =urldecode(@$_REQUEST['type']);
  $user_favs =urldecode(@$_REQUEST['id']);
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

else if($_REQUEST['act'] == "gs_getfav")
{
  $id   = urldecode($_REQUEST['user_id']);
  $type = urldecode($_REQUEST ['type']);
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
       else
       {
             $data = array('data'=>0,'status' => 0);
             echo json_encode($data);
       }

}




/*************** New GET FAVOURATE for JOB ,Event ,and Tournament and Resources* For GetsportLite************/
/*
| Type 1 = Job
| Type 2 = Event
| Type 3 = Tournament
| Type 6 = Resources
*/


else if($_REQUEST['act'] == "gs_getfav1")
{
  $id     = urldecode($_REQUEST ['user_id']);
  $type   = urldecode($_REQUEST['type']);
  $rev    = new liteservice();
  $res    = $rev->getfav($id,$type);
  //print_r($res);die();
   if($res != 0)
    { 
     switch ($type)
      {
        case '1':
              $favdata    = $res['userfav'];
             // print_r($favdata);die();
              $rev1       = $rev->get_fvdata1($favdata,$type);
              $rev2       = new userdataservice();
              $result     = $rev2->getuserjobs($rev1, $type, $id);
         break;
        case '2':
        
              $favdata    = $res['userfav'];
              $result     = $rev->get_fvdata1($favdata,$type);
              break;
        case '3':
              $favdata    = $res['userfav'];
              $result     = $rev->get_fvdata1($favdata,$type);
             break;
          default:
               $favdata   = $res['userfav'];
               $result    = $rev->get_fvdata1($favdata,$type);
              break;
      }
         // $req1      =    array('status' => 1,'data'=>$result,'msg'=>'The Record is Found');
                      //    echo json_encode($req1); 
  
//}

            $req1      =    array('status' => 1,'data'=>$result,'msg'=>'The Record is Found');
                          echo json_encode($req1); 
 }
       else
       {
             $req1      =    array('status' => 0,'data'=>$result,'msg'=>'The Record is Not  Found');
                             echo json_encode($req1); 
       }

}  // End of Statement





/***************TOKEN for save*****************/

else if($_REQUEST['act'] == 'get_token')
{
  $device_id = $_REQUEST['device_id'];
  $req = new liteservice();
  $res = $req->saveToken($device_id);
  echo json_encode($res);
}




/**************SUBSCRIBE for save*******************/

else if($_REQUEST['act']=="gs_sub")
{
   $key          =  urldecode($_REQUEST ['key']);
   $sports       =  urldecode($_REQUEST ['sports']);
   $module       =  urldecode($_REQUEST ['module']);
   $user_id      =  urldecode($_REQUEST ['user_id']);
   if($module=='1')
   {
       $table = "gs_jobInfo" ;
   }
   if($module=='2')
   {
    $table = "gs_eventinfo" ;
   }
   if($module=='3')
   {
     $table = "gs_tournament_info" ;
   }
   if($module=='6')
   {
     $table = "gs_resources" ;
   }

   $where[]      = "$table WHERE 1=1 ";
   $arr = array();

   
   if($module != '')
   {
       $arr['module'] = $module;    
   }
   else
   {
        $arr['module'] = $module;  
   }
  if($sports != '')
   {
     $where[] = " `sport` = '$sports' ";
     $arr['sport'] = $sports;
   }
   else
   {
     $where[] = " `sport` LIKE '%$sports%' ";
     $arr['sport'] = $sports;
   }
   if($key != '')
   {
     $where[] = " `description` LIKE '%$key%' ";
     $arr['key'] = $key;    
   }
   else
   {
     $where[] = " `description` LIKE '%$key%' ";
     $arr['key'] = $key;  
   }
   $whereclause = implode('AND', $where);
   $req = new liteservice();
   $res = $req->saveSubscribe($module,$user_id , mysql_real_escape_string($whereclause),json_encode($arr)); 

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
    $req       = new liteservice();
    $res       = $req->getSubs($userid);
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
   $module       = '6';
   $where[]      = ' 1=1 ';
   $arr = array();
   if($sports != '')
   {
     $where[] = " `sport` = '$sports' ";
     $arr['sport'] = $sports;
   }
   else
     {
     $where[] = " `sport` LIKE '%$sports%' ";
     $arr['sport'] = $sports;
     }
   
   if($location != '')
   {
     $where[] = " `location` = '$location' ";
     $arr['location'] = $location;
   }
   else
   {
     $where[] = " `location` LIKE '%$location%' ";
     $arr['location'] = $location;
   }
    if($topic != '')
   {
     $where[] = " `topic_of_artical` = '$topic' "; 
     $arr['topic_of_artical'] = $topic;    
   }
    else
    {
      $where[] = " `topic_of_artical` LIKE '%$topic%' "; 
      $arr['topic_of_artical'] = $topic; 
    }
   if($key != '')
   {
     $where[] = " `Description` LIKE '%$key%' ";
     $arr['key'] = $key;    
   }
   else
   {
     $where[] = " `Description` LIKE '%$key%' ";
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



/*********************************************************************/
// This Act is Transfer in Create Database.php so Please Ignore this Code 


/***************Code for Searching the Result form [JOB,EVENT, TOURNAMENT]  ****************/


else if($_REQUEST['act'] == "gs_searching")
{
    $keyword   =  $_REQUEST['key'];
    $userid    =  $_REQUEST['userid'];
    $module    =  $_REQUEST['module'];
    switch ($module)
    {
      case '1':
              $module        = '1';
               if(empty($keyword))
                {
                 $where="`gs_jobInfo` WHERE 1 ";
                }
                else
                {
                 $where="`gs_jobInfo` WHERE `title` like '%$keyword%' OR `description` like '%$keyword%' ";
                }
        break;

      case '2':
               $module        = '2';
             if(empty($keyword))
              {
                 $where="`gs_eventinfo` WHERE 1 ";
              }
              else
              {
                  $where="`gs_eventinfo` WHERE `type` like '%$keyword%' OR `description` like '%$keyword%' ";
              }
              break;
      case '3':
               $module        = '3';
             if(empty($keyword))
              {
                $where="`gs_tournament_info` WHERE 1 ";
              }
              else
              {
                 $where="`gs_tournament_info` WHERE `sport` like '%$keyword%' OR `description` like '%$keyword%' ";
               
              }
      break;
      default:
                $resp = array('data'=>'0' ,  'status'=>'Record is Found');
                echo json_encode($resp);
    }
           $req = new liteservice();
           $res = $req->getSearching($where,$module);
           if($res != 0)
            { 
            if($userid=='')
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
                    else
                    {
                    $res[$key]['fav'] ='0';
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
        $data = array('data'=>'0' ,'message'=>'Record is not Searching', 'status'=>'0');
        echo json_encode($data);
    }
}
  




/*******************This API Get the DAta for www. getsporty.in **********************************/

else if($_REQUEST['act'] == "blog_api")
{

$id     = $_REQUEST['id'];
$token  = $_REQUEST['token'];
if(!isset($id))
{
  $where = 'WHERE `token` IN ('.$token.') AND `status` = 1 ORDER BY `date_created` DESC';
}else
{ 
  $where = "WHERE `id` = '$id' ";
}
$req = new liteservice();
$res = $req->getBlogData($where);
if($res != 0)
{
 $data = array('data'=>$res,'status'=>'1');
 
}else
{
  $data = array('data'=>$res,'status'=>'');
}
echo json_encode($data);
}



/*****************************Get Data From Job Table******************************************/

else if($_REQUEST['act'] == "job_api")
{
 $where      = " `publish` = '1' ORDER BY `date_created` DESC ";
$req         = new liteservice();
$res          = $req->get_Job_Data($where);
if($res != 0)
{
 $data = array('data'=>$res,'status'=>'1');
 
}
else
{
  $data = array('data'=>$res,'status'=>'');
}
echo json_encode($data);
}




/*****************************Get Data Event Table******************************************/



else if($_REQUEST['act'] == "event_and_tour_api")
{
$req         = new liteservice();
$res          = $req->get_Event__tour_Data();
if($res != 0)
{
 $data = array('data'=>$res,'status'=>'1');
 
}
else
{
  $data = array('data'=>$res,'status'=>'');
}
echo json_encode($data);
}







?>







       

            



