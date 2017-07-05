<?php
include('config1.php');
include('services/userdataservice.php');
include('services/searchdataservice.php');
include('services/UserProfileService.php');
include('services/emailService.php');

 
/******************This Act are used to Edit the User Profile********************************/

if($_REQUEST['act'] == 'editUserData')	
{
   $data 				   =  file_get_contents("php://input");
   $userdata 	     =  json_decode(file_get_contents("php://input"));
   $userid         =  @$_REQUEST['userid'];
   $prof_id        =  @$_REQUEST['prof_id'];
  //$userid        = $userdata->user->userid;
  //$prof_id       = $userdata->user->prof_id;
    if(is_null($userid))
   {
        $user = array('status' => 0, 'data'=> 'User Id is Empty ' , 'msg'=>'No User Id' );
        echo json_encode($user);
        die();
   }
  if(is_null($userdata))
   {
        $user = array('status' => 0, 'data'=> 'Json is Invalid' , 'msg'=>'Invalid Json data' );
        echo json_encode($user);
        die();
   }
    else
    {
          $req 					 = new UserProfileService();
          $res 					 = $req->edit_user($userid,$prof_id,mysql_real_escape_string($data));
        	if($res)
        	{
          	$user = array('status' => 1, 'data'=> $res , 'msg'=>'Updated' );
                    echo json_encode($user); 
          }
          else
          {
            $user = array('status' => 0, 'data'=> $res , 'msg'=>'Not Updated' );
                    echo json_encode($user);
          }
    }

}// End if Statement



/*****************************************************************/

else if($_REQUEST['act'] == 'getUserProfile')
{
$userid         =  @$_REQUEST['userid'];
$prof_id        =  @$_REQUEST['prof_id'];
$req            =  new UserProfileService();
$user_res       = $req->userdata($userid);

if($user_res==0)
{
  $user = array('status' => 0, 'data'=> $user_res, 'msg'=>'User is Not Register');
  echo json_encode($user);
  die();
}

else
  {
       $req            = new UserProfileService();
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

}// End If Statement



else if($_REQUEST['act'] == 'imageupload')
{
   $data           =  file_get_contents("php://input");
   $userid         =  @$_REQUEST['userid'];
   $userdata       =  json_decode(file_get_contents("php://input"));
   $image          =  $userdata->image;
   $req            =   new UserProfileService();
   $res            =   $req->imageupload_user($userid,$image);
        if($res)
        {
          $data = array('status' => 1, 'data'=> $res, 'msg'=>'Success');
                  echo json_encode($data);
        }
        else
        {
            $data = array('status' => 1, 'data'=>$res, 'msg'=>'Failor');
                  echo json_encode($data);
        }          
} // End of Statment






