
<?php
include('config1.php');
include('services/angularapi.php');
include('services/getListingService.php');
include('services/smsOtpService.php');

if($_REQUEST['act'] == 'contentangular')
{
  $req    =   new angularapi();
  $res= $req->getContentInfo();
    echo json_encode($res); 
}

else if($_REQUEST['act'] == 'angulartest')
{
        $username       =  $_REQUEST['email'];
        $password       =  md5($_REQUEST['password']);
        $req    =   new angularapi();
        $res = $req->angulartest($username, $password);
        if($res)
        {
        $data = array("data" =>$res);     
        echo json_encode($res);
        }
        else
        {
        $data = array("data" =>0);        
        echo json_encode($res);
        }
}
else if($_REQUEST['act']=='AthletedashboardData')
{
  $userid = $_REQUEST['userid'];
  $req = new angularapi(); 
  $res = $req->AthletedashboardData($userid);
  echo json_encode($res);


}
else if($_REQUEST['act'] == 'mobileVerify')
{
  $mobileNo  = $_REQUEST['mobileNo']; 
  $userid    = $_REQUEST['userid'];
  $forgot_code          =  mt_rand(1000,10000);

  $req = new angularapi();
  $res = $req->mobileVerify($mobileNo,$userid,$forgot_code);
  if($res)
  {
     echo json_encode($res);
     $msg   = "Hello + athlete + your + otp + varification + code + is +".$forgot_code;
     $sms = sendWay2SMS(9528454915,8824784642, $mobileNo, $msg);
  }
  else
  {
    echo json_encode($res);
  }
}

else if($_REQUEST['act'] == 'OTPVerify')
{
  $otpcode = $_REQUEST['otpcode'];
  $userid    = $_REQUEST['userid'];

  $req = new angularapi();
  $res = $req->OTPVerify($otpcode,$userid);
  if($res)
  {
     echo json_encode($res);
  }
  else
  {
    echo json_encode($res);
  }


}

else if($_REQUEST['act'] == 'profile_data_update')
{
   $data = json_decode(file_get_contents("php://input"));

   $userid    = $data->userid; 
   $prof_id   = $data->prof_id;
   $profile   = json_encode($data->profiledata);

   $req       = new angularapi();
   $res       = $req->profile_data_update($userid,$prof_id,$profile);
   if($res)
   {
    echo json_encode($res);
   }else
   {
    echo json_encode($res);
   }

}


else if($_REQUEST['act'] == 'contentangularlex')
{
  $userid      =  $_REQUEST['userid'];
  $req    =   new angularapi();
  $res= $req->getContent($userid);
   
  echo json_encode($res); 
}

else if($_REQUEST['act'] == "participantList")
{
  $event_id = $_REQUEST['event_id'];
  $req = new angularapi();
  $res = $req->participantList($event_id);
  echo json_encode($res);
}

else if($_REQUEST['act'] == 'jobapplyUser')
{
  $job_id = $_REQUEST['id'];
  $req = new angularapi();
  $res = $req->jobapplyUser($job_id);
  echo json_encode($res);

}
else if($_REQUEST['act'] == 'getuserevent')
{
   $userid = $_REQUEST['userid'];
   $req = new angularapi();
   $res = $req->getuserevent($userid);
   echo json_encode($res);
}
else if($_REQUEST['act'] == 'geteventdetails')
{
   $id = $_REQUEST['id'];
   $req = new angularapi();
   $res = $req->geteventdetails($id);
   echo json_encode($res);
}
else if($_REQUEST['act'] == 'getuserdashboardevent')
{
  $id = $_REQUEST['userid'];
  $req = new angularapi();
  $res = $req->getuserdashboardevent($id);
  echo json_encode($res);
}
else if($_REQUEST['act'] == 'getjoblist')
{
  $userid = $_REQUEST['id'];
  $req = new angularapi();
  $res = $req->getjoblist($userid);
  echo json_encode($res);
}

else if($_REQUEST['act'] == 'getjobdetails')
{
  $id = $_REQUEST['id'];
  $req = new angularapi();
  $res = $req->getjobdetails($id);
  echo json_encode($res);

}

else if($_REQUEST['act'] == 'socialLogin')
{
  $data = json_decode(file_get_contents("php://input"));
  $email  = $data->email;
  $name   = $data->name;
  $image  = $data->image;
  $forgot_code   =  mt_rand(1000,10000);
  $password = md5($email);
  $req = new angularapi();
  $res = $req->angulartest($email, $password);
  if($res)
  {
    echo json_encode($res);
  }else
  {
    $res = $req->socialLogin($email,$password,$name,$forgot_code,$image);
    echo json_encode($res);
  }
 // $res = $req->socialLogin($email,$password,$name);
}

else if($_REQUEST['act'] == 'createcontent')
{        


        $data =  json_decode(file_get_contents("php://input"));
        $item                     =  new stdClass();
        $item->id           =  '0';
        $item->userid       =  '11';
        $item->title        =  $data->title;
        $item->content      =  $data->content;
        $item->url          =  $data->url;
        $item->publish      =  "0";

        $req    =   new angularapi();
        $res = $req->createcontent($item);     
        echo json_encode($res);
}

else if($_REQUEST['act'] == "sportlisting")
{
$req = new GetListingService();
$res = $req->getsportlisting();
echo json_encode($res);
}



else if($_REQUEST['act'] == 'createevent')
{        
        $data =  json_decode(file_get_contents("php://input"));
        $item                     =  new stdClass();
        
       

        $item->id                        = $data->id;
        $item->userid                    = $data->userid;
        $item->name                      = $data->name;
        $item->description               = $data->description;
        $item->type                      = $data->type;
        $item->sport_name                = $data->sport_name;
        $item->address_1                 = $data->address_1;
        $item->location                  = $data->location;
        $item->state                     = $data->state;
        $item->event_links               = $data->event_links;
        $item->start_date                = $data->start_date;
        $item->end_date                  = $data->end_date;
        $item->email_app_collection      = $data->email_app_collection;
        $item->mobile                    = $data->mobile;
        $item->eligibility1              = $data->eligibility1;
        $item->tandc1                    = $data->terms_cond1;
        $item->ticket_detail             = $data->ticket_detail;
        $item->image                     = $data->image;

        $req    =   new angularapi();
        $res = $req->createevent($item);     
        echo json_encode($res);
}

else if($_REQUEST['act'] == 'eventimage')
{   
$data =  file_get_contents("php://input");
$imageData = base64_decode($data);
$source = imagecreatefromstring($imageData);
$angle = 0;
$imageName = 'res_'.time().'.jpeg';
$rotate = imagerotate($source, $angle, 0); 
$imageSave = imagejpeg($rotate,$imageName,100);
$newpath = "image/event/".$imageName;
rename($imageName,$newpath);
echo json_encode($imageName);
}

else if($_REQUEST['act'] == 'jobimage')
{   
$data =  file_get_contents("php://input");
$imageData = base64_decode($data);
$source = imagecreatefromstring($imageData);
$angle = 0;
$imageName = 'res_'.time().'.jpeg';
$rotate = imagerotate($source, $angle, 0); 
$imageSave = imagejpeg($rotate,$imageName,100);
$newpath = "image/job/".$imageName;
rename($imageName,$newpath);
echo json_encode($imageName);
}

else if($_REQUEST['act'] == 'test')
{
  $data = file_get_contents("php://input");
  print_r($data);

}

else if($_REQUEST['act'] == 'profiledata')
{
  $userid      =  $_REQUEST['userid'];
  $req    =   new angularapi();
  $res= $req->profiledata($userid);
    echo json_encode($res); 
}

else if($_REQUEST['act'] == 'getUserProfile')
{
$userid         =  @$_REQUEST['userid'];
$prof_id        =  @$_REQUEST['prof_id'];
$req            =  new angularapi();
$user_res       = $req->userdata($userid);

if($user_res==0)
{
  $user = array('status' => 0, 'data'=> $user_res, 'msg'=>'User is Not Register');
  echo json_encode($user);
  die();
}

else
  {
       $req            = new angularapi();
       $res            = $req->listuserdata($userid);
       //print_r($res) ;die();
               if($res == 0)
               {
                    if($prof_id==1) 
                    {
                      $data = file_get_contents('json/Athletes.json');
                    }
                   else if ($prof_id==2) 
                    {
                      $data = file_get_contents('json/coach_profile.json');
                    }
                   else if ($prof_id == 13) 
                    {
                      $data = file_get_contents('json/other_profile.json');
                    }
                    else
                    {
                      $data = file_get_contents('json/other_profile.json');
                    }
               }
                else
                {
                  
                  $data = $res['user_detail'];

                }
                  $data = json_decode($data); 
                  $count = 0;
                  $count1 = 0; 
                  if (is_array($data) || is_object($data))
                  {
                  foreach ($data as  $value) 
                  {
                    if (is_array($value) || is_object($value))
                     {
                  
                        foreach ($value as  $value1)
                         {
                         if (is_array($value1) || is_object($value1))
                         {
                              foreach ($value1 as $value2) 
                              {
                                  
                                    if (is_array($value2) || is_object($value2))
                                     {

                                      foreach ($value2 as  $value3) 
                                      {
                                            if($value3 != '')
                                            {
                                                ++$count;
                                            }
                                            else
                                            {
                                                ++$count1;
                                            }
                                      }                          
                              }
                            
                        }
                  }
}
}
}
}
                     $comp = ($count/($count+$count1+1))*100;
                     $comp1=round($comp,2);
                     //$prof_status=$comp1.''.'%';
                    }
      
            $data->user = $user_res; 
            if (is_array($data->user) || is_object($data->user))
            {
                foreach ($data->user as $value) 
                {
                  if($value != '')
                  {
                     ++$count;
                   }
                   else
                   {
                   ++$count1;
                    }
                 }    
                    $comp = ($count/($count+$count1+1))*100;
                     $comp2=round($comp,2);
                    // $user_status=$comp1.''.'%';
            }

$Total_profile = ($comp1+$comp2)/200*100;     // Total user and profile Status calculate
$prof_status=$Total_profile;
$data->profile = (int)$Total_profile;
$res  = json_encode($data);//json_encode($data); 
$user = array('status' => 1, 'data'=> json_decode($res), 'msg'=>'Success');
echo json_encode($user);

}


else if($_REQUEST['act'] == 'createjob')
{
   $data = json_decode(file_get_contents("php://input"));
   
   $item = new stdClass();

    $item->id                        = $data->id;
    $item->userid                    = $data->userid;
    $item->title                     = $data->title;
    $item->location                  = $data->location;
    $item->gender                    = $data->gender;
    $item->sport                     = $data->sport;
    $item->type                      = $data->type;
    $item->job_link                  = $data->job_link;
    $item->work_experience           = $data->work_experience;
    $item->description               = $data->description;
    $item->about                     = $data->about;
    $item->key_requirement           = $data->key_requirement;
    $item->org_address1              = $data->org_address1;
    $item->org_address2              = $data->org_address2;
    $item->org_city                  = $data->org_city;
    $item->org_state                 = $data->org_state;
    $item->org_pin                   = $data->org_pin;
    $item->desired_skills            = $data->desired_skills;
    $item->organisation_name         = $data->organisation_name;
    $item->qualification             = $data->qualification;
    $item->address1                  = $data->address1;
    $item->address2                  = $data->address2;
    $item->state                     = $data->state;
    $item->pin                       = $data->pin;
    $item->contact                   = $data->contact;
    $item->email                     = $data->email;
    $item->image                     = $data->image; 

    $req    =   new angularapi();
    $res = $req->createjob($item);     
    echo json_encode($res);
}

?>