<?php
include('config1.php');
include('services/userdataservice.php');
include('services/searchdataservice.php');
include('services/UserProfileService.php');
include('services/emailService.php');
include('getSportyLite/liteservice.php');
include('services/connect_userservice.php');
  
//include('userdataservice.php');
error_reporting(E_ERROR | E_PARSE);
// SignUp The New User  using the GetsportyLite 

/*
 | When the user is SignUp if user   LoginType=1 Then User is Normal User
 |                                   LoginType=2 Then User is Google User
 |                                   LoginType=3 Then User is Facebook User 
 | When the user is used GetsportyLite  
 |                                   UserType =104
 | When the user is Signup then the Device Id are store in User Table
*/
 

if($_REQUEST['act'] == 'gs_signup')
{
$data1                     =   json_decode($_POST['data']);
$email                     =   $data1->email;
$where                     =   "WHERE `email`= '$email' ";
$req                       =   new userdataservice();
$res                       =   $req->userVarify($where);
      if($res)
      {
          $req1      =    array('status' => 0,'data'=>$res,'msg'=>'User already registered');
          echo json_encode($req1); 
      }
      else
      {
        $req1     = new userdataservice();
        $res1     = $req1->UserSignup($data1);
            if($res1)
            {
             $res4 =  array('status' => 1,'data'=>$res1,'msg'=>'User registered');
             echo json_encode($res4);
             $req2     = new emailService();
             $res2     = $req2->emailVarification($email);
            }
            else
            {
             $res5 = array('status' => 0,'data'=>$res1,'msg'=>'User not registered');
             echo json_encode($res5);  
            }
      }
} // End of Function
// Sign In Using the GetsportyLite 

//********************Code for User Login************//


else if($_REQUEST['act']=="gs_login")
{
$data1                        =  json_decode($_POST['data']);
$email                        =  $data1->email;
$password                     =  $data1->password;
$password1                    =  md5($password);
$device_id                    =  $data1->device_id;
$logintype                    =  $data1->logintype;
$where                        =  "WHERE `email`= '$email' ";
$user_image                   =  $data1->user_image;
switch ($logintype)
{
  case '1':
           $req                         = new userdataservice();
           $res                         = $req->gsSignIn($email,$password1);
           if($res)
                   {
                      if($res['device_id'] != $device_id )
                      {
                      $mes  = 'Multiple Logins not allowed, You have been successfully Logged Out';
                      $multiple = '1';
                      $message      = array('message'=>$mes,'multiple'=>"1");
                      $pushobj      = new userdataservice();
                      $pushnote     = $pushobj ->sendPushNotificationToGCM($row1['device_id'], $message);
                      $obj          = new userdataservice();
                      $upd          = $obj->updatedevice($device_id ,$email);
                      $multiple = "1";
                      }
                      $data = array('status' => 1,'data'=>$res ,'msg'=>'User Successfull Log In');
                      echo json_encode($data);
                    }
                    else
                    {
                     $data = array('status' => 0,'data'=>$res ,'msg'=>'Invalid login credentials');
                     echo json_encode($data);
                    }
        break;
      default:
                     //  if ($user_image !='')  // This is comment because the Image is Updated
                     // {
                     //    $obj = new userdataservice();
                     //  //  $upd = $obj->updateimage($email,$user_image);
                     // }

                  $req                     =  new userdataservice();
                  $res                     =  $req->userVarify($where);
                  if($res)
                  { 
                                   
                      if($res['device_id'] != $device_id )
                      {
                        $mes  = 'Multiple Logins not allowed, You have been successfully Logged Out';
                        $multiple = '1';
                        $message = array('message'=>$mes,'multiple'=>"1");
                        $pushobj      = new userdataservice();
                        $pushnote     = $pushobj ->sendPushNotificationToGCM($row1['device_id'], $message);
                        $obj = new userdataservice();
                        $upd = $obj->updatedevice($device_id ,$email);
                        //$multiple = "1";
                     }
                                          
                      $data = array('status' => 1,'data'=>$res ,'msg'=>'User already registered');
                      echo json_encode($data);
                 }
                 else
                 {
                     $req2     = new userdataservice();
                     $res3     = $req2->UserSignup($data1);
                    if($res3)
                    {
                         if($res3['device_id'] != $device_id )
                         {
                            $mes  = 'Multiple Logins not allowed, You have been successfully Logged Out';
                            $multiple = '1';
                            $message = array('message'=>$mes,'multiple'=>"1");
                            $pushobj      = new userdataservice();
                            $pushnote     = $pushobj ->sendPushNotificationToGCM($row1['device_id'], $message);
                            $obj = new userdataservice();
                            $upd = $obj->updatedevice($device_id ,$email);
                            //$multiple = "1";
                         }

                          $data = array('status' => 0,'data'=>$res3 ,'msg'=>'User registered');
                           // $data = array('data'=>$res3,'status'=>'1','multip'=>$multiple);
                          echo json_encode($data);
                           
                    }
                  }
    break;
     


} //End Switch
} // Function End

//******************CODE FOR EDIT PROFILE STARTS ******************************/
// if Status=0 then Email are send to User for varify


else if($_REQUEST['act']=="editprofile")
{

$data1                    =  json_decode($_POST[ 'data' ]);
$item                     =  new stdClass();
$item->userid             =  $data1->userid;
$item->email              =  $data1->email;
$item->mobile_no          =  $data1->mobile_no;
$item->prof_id            =  $data1->prof_id;
$item->proffession        =  $data1->proffession;
$item->sport              =  $data1->sport;
$item->gender             =  $data1->gender;
$item->dob                =  $data1->dob;
$item->status             =  $data1->status; 
$item->link               =  $data1->link; 
$item->ageGroupCoached    =  $data1->ageGroupCoached; 
$item->languagesKnown     =  $data1->languagesKnown; 
$req                      =  new UserProfileService();
$res                      =  $req->editProfile($item);
 if ($item->status==0) 
 {
 $req2     = new emailService();
 $res2     = $req2->emailVarification($item->email);
 }
if($res==1)
{
$req1                 = new userdataservice();
$req2                 = $req1->getuserdata($item->userid);
$user = array('status' => 1, 'data'=> $req2, 'msg'=>'Updated' );
echo json_encode($user);
}
else
{
$user = array('status' => 0, 'data'=> $req2, 'msg'=>'Notupdated' );
echo json_encode($user);
}
}

//*********This is a code for Edit the User Profile using the GetsportyLite*********************

// else if($_REQUEST['act']=="gs_editprofile")
// {
// $data1                = json_decode($_POST[ 'data' ]);//
//$item                 =  new stdClass();
//$item->userid         =  $data1->userid;
//$item->email          =  $data1->email;
//$item->mobile_no      =  $data1->mobile_no;
//$item->proffession    =  $data1->proffession;
//$item->sport          =  $data1->sport;
//$item->gender         =  $data1->gender;
//$item->dob            =  $data1->dob;
//$item->verified        =  $data1->verified;
// $req = new UserProfileService();
// $res = $req->gs_editProfile($data1);
//  if($res)
//             {
//              $res4 =  array('status' => 1,'data'=>$res,'msg'=>'Updated');
//              echo json_encode($res4);
//             }
//             else
//             {
//              $res5 = array('status' => 0,'data'=>$res,'msg'=>'Notupdated');
//              echo json_encode($res5);  
//             }

// $_POST['act']=="register" This code is not used because this is Old code for signUp User so Please Ignore this code

/****CODE FOR USER REGISTRATION************************/

// if($_POST['act']=="register")
// {
//  $name       =urldecode($_POST ['name']);
//  $email      =urldecode($_POST ['email']);
//  $password1  =md5(urldecode($_POST ['password']));
//  $phone      =urldecode($_POST ['phone']);
//  $gender     =urldecode($_POST ['gender']);
//  $prof       =urldecode($_POST ['prof']);
//  $sport      =urldecode($_POST ['sport']);
//  $location   =urldecode($_POST ['location']);
//  $token      =urldecode($_POST ['token']);
//  $usertype   ='103';//urlencode($_POST ['usertype']);
//  $where      = "WHERE `email` = '".$email."'";
//  $req        = new userdataservice();
//  $res        = $req->userVarify($where);
//  $data       = array('name'=>$name,'email'=>$email,'password'=> $password1,'phone'=>$phone,'gender'=>$gender,'prof'=>$prof,'sport'=>$sport,'location'=>$location,'token'=>$token,'usertype'=>$usertype);
//   if($res != 0)
//  {
// $status = array('status' => 0, 'message' => 'user already exists');
// echo json_encode($status); 
//  }
// else
// {
// $req1 = new userdataservice();
// $res1 = $req1->createUser($data);
// if($res1 == '1')
// {
// $req2 = new userdataservice();
// $res2 = $req2->userVarify($where);
// if($res2 != 0)
// {
// $res3 = array('data' => $res2,'status' => 1);
// echo json_encode($res3);  
// }
// }
// else
// {
// $res3 = array('data' => 'record not saved','status' => 0);
// echo json_encode($res3);  
// }
// }
// }

//****CODE FOR USER Login******//

// else if($_POST['act']=="login")
// {
// $status   = array('sucess' => 1, 'failure'=>0);
// $email    = urldecode($_POST['email']);
// $pass     = md5(urldecode($_POST['password']));
// $username = mysql_real_escape_string($email);
// $password = mysql_real_escape_string($pass);
// $token    = urldecode($_POST ['token']);
// $multiple = 0;
// $validate = mysql_query("SELECT `userid` , `name`,`prof_id` , `user_image`,`location`,`device_id`FROM `user` WHERE `email` = '$username' AND `password` = '$password' ");
// $row = mysql_num_rows($validate);

// if($row==1)
// {
// 	while($row1 = mysql_fetch_assoc($validate))
// 	{
// 	   if($row1['device_id'] != $token )
// 	  {
// 	    $mes  = 'Multiple Logins not allowed, You have been successfully Logged Out';
//       $multiple = '1';
//       $message = array('message'=>$mes,'multiple'=>"1");
// 	    $pushobj      = new userdataservice();
//        $pushnote     = $pushobj ->sendPushNotificationToGCM($row1['device_id'], $message);
//  		  $obj = new userdataservice();
// 	    $upd = $obj->updatedevice($token ,$email);
//       $multiple = "1";
// 	  }
         
//           $data = array('data'=>$row1,'status'=>'1','multiple'=>$multiple);
//           echo json_encode($data);
// 	  	}
// }
// else
//     {
//         $data = array('data'=>'Invalid login credentials' , 'status'=>'0');
//         echo json_encode($data);
//     }
// }


// <<<<<<< HEAD
// //******************CODE FOR EDIT PROFILE STARTS ******************************/


// else if($_POST['act']=="editprofile")
// {
// $userid = urldecode($_POST['userid']);
// $data1  = json_decode($_REQUEST[ 'data' ]);////
// $item                     =  new stdClass();
// $item->formal_edu         =  $data1->formal_education;
// $item->sports_edu         =  $data1->sports_education;
// $item->other_cert         =  $data1->other_certificate;
// $item->Work_exp           =  $data1->work_experience;
// $item->player_exp         =  $data1->experience_as_player;
// $item->other_exp          =  $data1->other_experience;
// $item->other_skills       =  $data1->other_skills;
// $item->userinfo           =  $data1->info;
// $item->other_skills       =  $data1->other_skills;
// $formaledu = (json_decode(json_encode($item->formal_edu),true));
// $size = sizeof($formaledu);
// for($i=0;$i<$size;$i++)
// {
// $req1 = new UserProfileService();
// $res1 = $req1->editFormalEducation($userid,$formaledu[$i]);
// if($res1 != '1')
// {
// echo "some problem while saving formal education";
// =======


else if($_REQUEST['act']=="manage_Login")
{
$data1                = json_decode($_POST[ 'data' ]);
$item                 =  new stdClass();
$item->email          =  $data1->email;
$item->password       =  md5($data1->password);
$item->device_id      =  $data1->device_id;
$req1= new userdataservice();
$req3 = $req1->manage_Login($item);

if($req3 != 0 )
{
$user = array('status' => 1, 'data'=> $req3, 'msg'=>'Updated' );
echo json_encode($user);
}
else
{
$user = array('status' => 0, 'data'=> $req3, 'msg'=>'NotUpdated' );
echo json_encode($user);
}


} // End Function

else if($_REQUEST['act']=="create_manage_user")
{
$data1                = json_decode($_POST[ 'data' ]);
$item                 =  new stdClass();
$forgot_code          =  mt_rand(1000,10000);
$item->email          =  $data1->email;
$item->phone_no       =  $data1->phone_no;
$item->proffession    =  $data1->proffession;
$item->sport          =  $data1->sport;
$item->gender         =  $data1->gender;
$item->dob            =  $data1->dob;
$item->userType       =  103;
$item->forget_code    =  $forgot_code;
$item->device_id      =  $data1->device_id;
$item->token_id       =  $data1->token_id;
$item->name           =  $data1->name;
$item->prof_id        =  $data1->prof_id;
$req1= new userdataservice();
$req3 = $req1->create_manage_user_exits($item);
if($req3 == 1 )
{
$user = array('status' => 1);
echo json_encode($user);
}
else if($req3 == 2)
{
$user = array('status' => 2);
echo json_encode($user);
}
else if($req3 == 3)
{
  $user = array('status' => 3);
  echo json_encode($user);
}
else if($req3 == 4)
{
  $user = array('status' => 4);
  echo json_encode($user);

}
else if($req3 == 5)
{
  $user = array('status' => 5);
  echo json_encode($user);

}
else
{
$user = array('status' => 0);
  echo json_encode($user);
}
}




// //******************CODE FOR EDIT PROFILE STARTS ******************************/

// else if($_REQUEST['act']=="editprofile")
// {
// $data1                = json_decode($_POST[ 'data' ]);
// $item                 =  new stdClass();
// $item->userid         =  $data1->userid;
// $item->email          =  $data1->email;
// $item->mobile_no      =  $data1->mobile_no;
// $item->proffession    =  $data1->proffession;
// $item->sport          =  $data1->sport;
// $item->gender         =  $data1->gender;
// $item->dob            =  $data1->dob;
// $item->status         =  $data1->status;  
// $req                  = new UserProfileService();
// $res                  = $req->editProfile($item);
// $req1                 = new userdataservice();
// $req2                 =$req1->getuserdata($item->userid);
// if($res==1)
// {
// $user = array('Status' => 1, 'data'=> $req2, 'msg'=>'Updated' );
// echo json_encode($user);
// }
// else
// {
// $user = array('Status' => 0, 'data'=> $req2, 'msg'=>'Notupdated' );
// echo json_encode($user);
// }
// }



// /***********************Get User Data*********************************/

else if($_REQUEST['act']=="getUserData")
{//print_r($_REQUEST);
$userid =urldecode($_REQUEST['userid']);
// $eduid  = '1';
// $req1 = new UserProfileService();
// $res1 = $req1->getUserEducation($userid,$eduid); 
// if($res1 != '0')
// {
 $formaledu = 0;//$res1;
// }
// else
// {
// $formaledu =  0;
// }
// $req2 = new UserProfileService();
// $res2 = $req2->getSportsEducation($userid);
// if($res2 != '0')
// {
// $sportsedu = $res2;
// }else
// {
 $sportsedu = 0;
// }
// $eduid  = '3';
// $req3   = new UserProfileService();
// $res3   = $req3->getUserEducation($userid,$eduid);
// if($res3 != '0')
// {
// $otheredu = $res3;
// }
// else
// {
 $otheredu = 0;
// }
// $user_exp = '1';
// $req4 = new UserProfileService();
// $res4 = $req4->getUserExperience($userid,$user_exp);
// if($res4 != '0')
// {
// $work_exp = $res4;
// }
// else
// {
 $work_exp = 0;
// }

// $req5 = new UserProfileService();
// $res5 = $req5->getUserSportsExp($userid);
// if($res5 != '0')
// {
// $sport_exp = $res5;
// }
// else
// {
 $sport_exp = 0;
// }
// $user_exp = '2';
// $req6 = new UserProfileService();
// $res6 = $req6->getUserExperience($userid,$user_exp);
// if($res6 != '0')
// {
// $other_exp = $res6;
// }
// else
// {
 $other_exp = 0;
// }
// $req7         = new UserProfileService();
// $res7         = $req7->getUserSkill($userid);
// if($res7 != 0)
// {
// $other_skills = $res7;
// }
// else
// {
 $other_skills = 0;
// }
$req = new userdataservice();
$res = $req->getuserData($userid);
if($res != '0')
{
$user = $res;
}
else
{
$user = 0;
}

$userdata = array('formal_education' => $formaledu , 'sport_education' => $sportsedu , 'other_certification' => $otheredu , 'work_experience' => $work_exp , 'other_experience' => $other_exp , 'experience_as_player' => $sport_exp,'other_skills'=>$other_skills , 'user_info' => $user);
if(in_array(0, $userdata))
{
  $userdata['status'] = 0; 
}else
{
  $userdata['status'] = 1;
}
 $user = array('status' => $userdata['status'], 'data'=> $userdata, 'msg'=>'Success');
 echo json_encode($user);
}
// =======



//******************CODE FOR EDIT PROFILE STARTS ******************************/

// else if($_REQUEST['act']=="editprofile")
// {
// $data1                = json_decode($_POST[ 'data' ]);
// $item                 =  new stdClass();
// $item->userid         =  $data1->userid;
// $item->email          =  $data1->email;
// $item->mobile_no      =  $data1->mobile_no;
// $item->proffession    =  $data1->proffession;
// $item->sport          =  $data1->sport;
// $item->gender         =  $data1->gender;
// $item->dob            =  $data1->dob;
// $item->status         =  $data1->status;  
// $req                  = new UserProfileService();
// $res                  = $req->editProfile($item);
// $req1                 = new userdataservice();
// $req2                 =$req1->getuserdata($item->userid);
// if($res==1)
// {
// $user = array('Status' => 1, 'data'=> $req2, 'msg'=>'Updated' );
// echo json_encode($user);
// }
// else
// {
// $user = array('Status' => 0, 'data'=> $req2, 'msg'=>'Notupdated' );
// echo json_encode($user);
// }
// }


//print_r($item);

// $formaledu = (json_decode(json_encode($item->formal_edu),true));
// $size = sizeof($formaledu);
// for($i=0;$i<$size;$i++)
// {
// $req1 = new UserProfileService();
// $res1 = $req1->editFormalEducation($userid,$formaledu[$i]);

// if($res1 != '1')
// {

// echo "some problem while saving formal education";

// }
// }
// $sports_edu = (json_decode(json_encode($item->sports_edu),true));
// $size       = sizeof($sports_edu);
// for ($i=0; $i <$size ; $i++) 
// { 
// $req2  = new UserProfileService();
// $res2 = $req2->editSportsEducation($userid ,$sports_edu[$i]);

// if($res2!= '1')
// {

// echo "some problem while saving sports education";

// }
// }

// $education = (json_decode(json_encode($item->other_cert),true));
// //print_r($education);
// $size = sizeof($education); 
// for ($i=0; $i <$size ; $i++) 
// { 

// $req3 = new UserProfileService();
// $res3 = $req3->editFormalEducation($userid ,$education[$i]);
// //echo $res3;
// if($res3 != '1')
// {

// echo "some problem while saving other certs info.";

// }
// }
// $experience = (json_decode(json_encode($item->Work_exp),true));
// //print_r($experience);
// $size       = sizeof($experience);
// for ($i=0; $i <$size ; $i++) 
// { 

// $req4 = new UserProfileService();
// $res4 = $req4->editExperience($userid ,$experience[$i]);

// if($res4 != '1')
// {

// echo "some problem while saving user work experience";

// }
// }
//  $sports_experience = (json_decode(json_encode($item->player_exp),true));
//  $size = sizeof($sports_experience);
//  //$array = print_r($sports_experience);die();
//  for ($i=0; $i <$size ; $i++)
// { 
//   $req5 = new UserProfileService();
//   $res5 = $req5->editSportExperience($userid ,$sports_experience[$i]);

//   if($res5 != '1')
//   {

//    echo "Some probelem while saving user sports experience";

//   }
// }

// $experience = (json_decode(json_encode($item->other_exp),true));
// $size       = sizeof($experience);
// for ($i=0; $i <$size ; $i++) 
// { 

// $req6 = new UserProfileService();
// $res6 = $req6->editExperience($userid ,$experience[$i]);

// if($res6 != '1')
// {

// echo "some problem while saving user work experience";

// }
// }
// $skill = (json_decode(json_encode($item->other_skills),true));
// $size  = sizeof($skill);
// //print_r($skill);
// for($i=0;$i<$size;$i++)
// {

// $req7 = new UserProfileService();
// $res7 = $req7->editUserSkill($userid ,$skill[$i]);
// if($res7 != '1')
// {

// echo "some problem while saving user skill";

// }


// }
// $userinfo = json_decode(json_encode($item->userinfo),true);
// $req = new UserProfileService();
// $res = $req->editUserData($userid,$userinfo);
// //echo $res;
// if($res != '1')
// {

// echo "some problem while updating user info";

// }
// //echo "res1=".$res1." res2=".$res2." res3=".$res3." res4=".$res4." res5=".$res5." res6=".$res6." res7=".$res7." res=".$res;
// if ( $res1 != '0' && $res2 != '0' && $res3 != '0' && $res4 != '0' && $res5 != '0' && $res6 != '0' && $res7 != '0' && $res != '0')
// {

// $status = array('failure' => 0 , 'success' => 1);
// echo json_encode($status);
// } 
// else 
// {

// $status = array('failure' => 1 , 'success' => 0);
// echo json_encode($status);

// }
// }

else if($_POST['act']=="getUserData")
{

$userid =urldecode($_POST['userid']);
$eduid  = '1';
$req1 = new UserProfileService();
$res1 = $req1->getUserEducation($userid,$eduid); 

if($res1 != '0')
{

$formaledu = $res1;

}
else
{
$formaledu =  0;
}



$req2 = new UserProfileService();
$res2 = $req2->getSportsEducation($userid);
if($res2 != '0')
{

$sportsedu = $res2;

}else{
$sportsedu = 0;
}

$eduid  = '3';
$req3   = new UserProfileService();
$res3   = $req3->getUserEducation($userid,$eduid);
if($res3 != '0')
{
$otheredu = $res3;
}
else
{

$otheredu = 0;

}

$user_exp = '1';

$req4 = new UserProfileService();
$res4 = $req4->getUserExperience($userid,$user_exp);
if($res4 != '0')
{
$work_exp = $res4;
}
else
{

$work_exp = 0;

}

$req5 = new UserProfileService();
$res5 = $req5->getUserSportsExp($userid);
if($res5 != '0')
{

$sport_exp = $res5;

}
else
{

$sport_exp = 0;

}

$user_exp = '2';

$req6 = new UserProfileService();
$res6 = $req6->getUserExperience($userid,$user_exp);
if($res6 != '0')
{
$other_exp = $res6;
}
else
{

$other_exp = 0;

}

$req7         = new UserProfileService();
$res7         = $req7->getUserSkill($userid);
if($res7 != 0)
{

$other_skills = $res7;

}
else
{

$other_skills = 0;

}


$req = new UserProfileService();
$res = $req->getuserData($userid);
if($res != '0')
{

$user = $res;
}
else
{

$user = 0;

}

$userdata = array('formal_education' => $formaledu , 'sport_education' => $sportsedu , 'other_certification' => $otheredu , 'work_experience' => $work_exp , 'other_experience' => $other_exp , 'experience_as_player' => $sport_exp,'other_skills'=>$other_skills , 'user_info' => $user);
if(in_array(0, $userdata)){

  $userdata['status'] = 0; 

}else{

  $userdata['status'] = 1;
}
print_r($userdata);

if($res)
{
// print_r($req2);//die;
//$user = array('Status' => 1);
$user = array('Status' => 1, 'data'=> $res, 'msg'=>'Updated' );
echo json_encode($user);
}
else
{
//  $user = array('Status' => 0);
$user = array('Status' => 0, 'data'=> $res, 'msg'=>'Notupdated' );
echo json_encode($user);
}
}

//********* CODE FOR CREATING JOBS **********//

else if($_POST['act']=="createjob")
{
//$status = array('failure' => 0 , 'success' => 1);
$data1 = json_decode($_REQUEST[ 'data' ]);
$item = new stdClass(); 
$item->id                    = $data1->id;
$item->userid                = $data1->userid;
$item->title                 = $data1->title;
$item->type                  = $data1->type;
$item->sports                = $data1->sports;
$item->gender                = $data1->gender;
$item->work_exp              = $data1->work_experience;
$item->desc                  = $data1->description;
$item->desiredskill          = $data1->desired_skills;
$item->qualification         = $data1->qualification;
$item->keyreq                = $data1->key_requirement;
$item->org_address1          = $data1->org_address1;
$item->org_address2          = $data1->org_address2;
$item->org_city              = $data1->org_city;
$item->org_state             = $data1->org_state;
$item->org_pin               = $data1->org_pin;
$item->org_name              = $data1->organisation_name;
$item->about                 = $data1->about;
$item->address1              = $data1->address1; 
$item->address2              = $data1->address2; 
$item->state                 = $data1->state;
$item->city                  = $data1->city;
$item->pin                   = $data1->pin;  
$item->name                  = $data1->name;
$item->contact               = $data1->contact;
$item->email                 = $data1->email_app_collection;
$item->image                 = $data1->image; 
$req = new userdataservice();
$res = $req->create_job($item);
if($res != 0)
{ 
//$status = array('success' => 1);
echo json_encode($status['success']);
}
else
{
//$status = array('failure' => 0 , 'success' => 1);  
echo json_encode($status['failure']);
}
}

//********* CODE FOR CREATING TOURNAMENTS **********//

else if($_POST['act'] == "createtournament")
{
$status = array('failure' => 0 , 'success' => 1);
$data1 = json_decode($_REQUEST[ 'data' ]);
$item = new stdClass();
$item->id                      = $data1->id;
$item->tournament_name         = $data1->tournament_name;
$item->tournament_level        = $data1->tournament_level;
$item->tournament_ageGroup     = $data1->tournament_ageGroup;
$item->checkBox_maleValue      = $data1->checkBox_maleValue;
$item->checkBox_femaleValue    = $data1->checkBox_femaleValue;
$item->userid                  = $data1->userid;
$item->address_line1           = $data1->address_line1;
$item->address_line2           = $data1->address_line2;
$item->city                    = $data1->city;
$item->state                   = $data1->state;
$item->pin                     = $data1->pin;
$item->description             = $data1->description;
$item->eligibility1            = $data1->eligibility1;
$item->terms_and_conditions1   = $data1->terms_and_conditions1;
$item->organizer_name          = $data1->organizer_name;
$item->mobile                  = $data1->mobile;
$item->landline                = $data1->landline;
$item->emailid                 = $data1->emailid;
$item->organizer_address_line1 = $data1->organizer_address_line1;
$item->organizer_address_line2 = $data1->organizer_address_line2;
$item->organizer_city          = $data1->organizer_city;
$item->organizer_pin           = $data1->organizer_pin;
$item->tournament_links        = $data1->tournament_links;
$item->start_date              = strtotime($data1->start_date);
$item->end_date                = strtotime($data1->end_date);
$item->entry_start_date        = strtotime($data1->entry_start_date);
$item->entry_end_date          = strtotime($data1->entry_end_date);
$item->file_name               = $data1->file_name;
$item->file                    = $data1->file;
$item->email_app_collection    = $data1->email_app_collection;
$item->phone_app_collection    = $data1->phone_app_collection;
$item->sport                   = $data1->sport;
$eligibility = json_decode($data1->eligibility1);// decoding the eligibility json into array
$eligibility = implode("|", $eligibility);// converting eligibilities array stack into string to 
$terms = json_decode($data1->terms_and_conditions1);
$terms = implode("|",$terms);
$item->eligibility1          = $eligibility;
$item->terms_and_conditions1 = $terms;
if($item->checkBox_maleValue == "1" )
{
$gender = "Male";
}
else if($item->checkBox_femaleValue == "1")
{
$gender = "Female";
}
else if($item->checkBox_femaleValue == "1" && $item->checkBox_maleValue == "1"  )
{
$gender = "Unisex";
}
$req = new userdataservice();
$res = $req->create_tournament($item);
if($res == 1)
{
echo json_encode($status['success']);
}
else
echo json_encode($status['failure']);
}

//********* CODE FOR CREATING EVENTS **********//

else if ($_POST['act'] == 'createevent') 
{
$status = array('failure' => 0 , 'success' => 1);
$data1 = json_decode($_REQUEST[ 'data' ]);
$item = new stdClass();
$item->id                       = $data1->id;
$item->userid                   = $data1->userid;
$item->type                     = $data1->type;
$item->name                     = $data1->name;
$item->address1                 = $data1->address_line1;
$item->address2                 = $data1->address_line2;
$item->city                     = $data1->city;
$item->pin                      = $data1->pin;
$item->state                    = $data1->state;
$item->description              = $data1->description;
$item->eligibility1             = $data1->eligibility1;
$item->eligibility2             = $data1->eligibility2;
$item->tandc1                   = $data1->terms_and_conditions1;
$item->tandc2                   = $data1->terms_and_conditions2;
$item->organizer_name           = $data1->organizer_name;
$item->mobile                   = $data1->mobile;
$item->org_address1             = $data1->organizer_address_line1;
$item->org_address2             = $data1->organizer_address_line2;
$item->organizer_city           = $data1->organizer_city;
$item->organizer_pin            = $data1->organizer_pin;
$item->organizer_state          = $data1->organizer_state;
$item->event_links              = $data1->event_links;
$item->start_date               = strtotime($data1->start_date);//strtotime();
$item->end_date                 = strtotime($data1->end_date);//strtotime($data1['end_date']);
$item->sport                    = $data1->sport;
$item->level                    = $data1->level;
$item->entry_start_date         = strtotime($data1->entry_start_date);//strtotime($data1['entry_start_date']);
$item->entry_end_date           = strtotime($data1->entry_end_date);//strtotime($data1['entry_end_date']);
$item->file_name                = $data1->file_name;
$item->file                     = $data1->file;
$item->email_app_collection     = $data1->emailid;
$eligibility = json_decode($data1->eligibility1);
$eligibility = implode("|", $eligibility);
$terms       = json_decode($data1->terms_and_conditions1);
$terms       = implode("|",$terms);
$item->eligibility1 = $eligibility;
$item->tandc1       = $terms;
$req = new userdataservice();
$res = $req->create_event($item);
if($res == 1)
{
echo json_encode($status['success']);
}
else
echo json_encode($status['failure']);
}
//*********CODE FOR FETCHING THE CREATED DATA***********//
else if($_REQUEST['act'] == "editcreation")
{
$userid = urldecode($_REQUEST['userid']);
$type   = urldecode($_REQUEST['type']);
$id     = urldecode($_REQUEST['id']);
if($userid != '')
{
$where1 = "`userid`  = '".$userid."'";
}
if($id != '')
{
$where2 = "  AND `id` = '".$id."'";
}
$where = $where1.$where2;
$req = new userdataservice();
$res = $req->getCreation($where, $type);
if($res != 0)
{
  if(sizeof($res == '1'))
{
if($type == '2' || $type == '3')
{
$eligibility = $res[0]['eligibility1'];
$eligibility = explode("|",$eligibility);
$eligibility = array_filter(array_values($eligibility));
$size        = sizeof($eligibility);
$el = array();
for ($i=0; $i <$size ; $i++) 
{ 
$index = "Eligibility ".($i +'1');
if($eligibility[$i] == '')
{
$el[$index] = "";
}
else
{ 
$el[$index] = $eligibility[$i];
}
}
$res[0]['eligibility1'] = $el; 
if($type == '2')
{
$terms = $res[0]['terms_cond1'];
}
else if($type == '3')
{
$terms = $res[0]['terms_and_cond1'];
}
$terms = explode("|",$terms);
$terms = array_filter(array_values($terms));
$size  = sizeof($terms);
$tc = array();
for ($i=0; $i <$size ; $i++) 
{ 
$index = "Terms & condition ".($i +'1');
if($terms[$i] == '')
{
$tc[$index] = "";
}
else
{ 
$tc[$index] = $terms[$i];
}
}
$terms = $tc;
if($type == '2')
{
$res[0]['terms_cond1'] = $terms;
}
else if($type == '3')
{
$res[0]['terms_and_cond1'] = $terms;
}
}
}
  $status = 1;
}
else
{
  $status = 0;
} 
$data = array('data'=>$res, 'status'=>$status);
echo json_encode($data);
}


//********* CODE FOR MARKING SEARCH FOR JOBS **********//

else if($_POST['act'] == "search_job")
{
 $id          =urldecode($_POST['userid']);
 $title       =urldecode($_POST['job_title']);
 $sport       =urldecode($_POST['sport_name']);
 $location    =urldecode($_POST['location']);
 $gender      =urldecode($_POST['gender']);
 $key         =urldecode($_POST['key']);
 $module      =urldecode($_POST['module']);
  $request   =   new userdataservice();
 $where[]      = ' 1=1 ';
  $arr = array();
  if($sport != '')
  {
    $where[] = "`sport` LIKE '%$sport%' ";
    $arr['sport'] =  $sport ; 
  }
  if($location != '')
  {
       $where[] = "`location` LIKE '%$location%' ";
       $arr['location'] = $location;
  }
  if($title != '')
  {
     $where[] = "`title` LIKE '%$title%' "; 
     $arr['title'] = $title ;    
  }

 if($key  != '')
  {
     $where[] = "`description` LIKE '%$key%' "; 
     $arr['key'] =  $key;    
  }

if($gender  != '')
  {
     $where[]    = "`gender` LIKE '%$gender%' "; 
     $arr['gender '] =   $gender ;    
  }
    $whereclause = implode('AND', $where);
    $response       = $request ->jobsearch_user($whereclause);

if($response)
{
                                $response      = $request->getfavForUser($response,$module, $userid);
                                if ($module=='1')
                                {
                                     $response      = $request ->getuserjobs($response,$module, $userid);
                                }
           $Result = array('status' => '1','data'=>$response ,'msg'=>'Searching successfully');
           echo json_encode($Result);
}
else
{                     
        $Result = array('status' => '0','data'=>$response ,'msg'=>'Not Searching successfully');
        echo json_encode($Result);
} 
                     
} // End of Function


//********* CODE FOR SEARCHING EVENTS **********//

else if ($_REQUEST['act'] == "search_event" )
{
 $userid      = urldecode($_REQUEST['userid']);
 $key         = urldecode($_REQUEST['key']);
 $title       = urldecode($_REQUEST['title']);
 $sport       = urldecode($_REQUEST['sport']);
 $location    = urldecode($_REQUEST['location']);
 $module      = '2';                         // for Event 
 $request    = new userdataservice();
 $where[]         =   '1 =1 ';
 $arr = array();

  if($title != '')
 {
      $where[] = " `name` LIKE '%$title%' ";
      $arr['name'] =  $title ; 
 }
 if($key != '')
 {
      $where[] = " `description` LIKE '%$key%' ";
      $arr['description'] =  $key ; 
 }
 if($userid != '')
 {
    $where[] = " `userid` NOT IN ($userid) ";
    $arr['userid'] =  $userid ; 
  }
  if($sport != '')
  {
    $where[] = " `sport` LIKE '%$sport%' ";
    $arr['sport'] =  $sport ; 
  }
  if($location != '')
  {
       $where[] = "`location` LIKE '%$location%' ";
       $arr['location'] = $location;
  }

  
    $whereclause = implode('AND', $where);
   // echo "$whereclause";die();
  $response = $request->searchEvent($whereclause);
if($response)
{
                        $response      = $request->getfavForUser($response,$module, $userid);
                              //  if (!empty($userid))
                               // {
                                    
                               // }
           $Result = array('status' => '1','data'=>$response ,'msg'=>'More Result successfully');
           echo json_encode($Result);
}
else
{                     
        $Result = array('status' => '0','data'=>$response ,'msg'=>'More Result is Not Found');
        echo json_encode($Result);
} 
                     
}



//********* CODE FOR the view of JOB , EVENT , TOURNAMENT ****//

else if($_POST['act'] == "getsearchview")
{

    $type  = urldecode($_POST['type']);
    $id    = urldecode($_POST['id']);
    $user_id =urldecode($_POST['user_id']);
    $where =  "`id` = '".$id."'"; 
    $req   = new userdataservice();
    $res   = $req->getCreation($where , $type);
    if($res != 0)
    {
    /*********************************/
    $eligibility = $res[0]['eligibility1'];
    $eligibility = explode("|",$eligibility);
    $eligibility = array_filter(array_values($eligibility));
    $size        = sizeof($eligibility);
    $el = array();
    for ($i=0; $i <$size ; $i++) 
    { 
        $index = "Eligibility ".($i +'1');
        if($eligibility[$i] == '')
        {
        $el[$index] = "";
        }
        else
        { 
        $el[$index] = $eligibility[$i];
        }
    $elig[] = $el[$index];
    }

    $res[0]['eligibility1'] = $elig;


    if($type == '2')
    {
    $terms = $res[0]['terms_cond1'];
    }
    else if($type == '3')
    {
    $terms = $res[0]['terms_and_cond1'];
    }
    $terms = explode("|",$terms);
    $terms = array_filter(array_values($terms));
    $size  = sizeof($terms);

    $tc = array();
    for ($i=0; $i <$size ; $i++) 
    { 
    $index = "Terms & condition ".($i +'1');
    if($terms[$i] == '')
    {
    $tc[$index] = "";
    }
    else
    { 
    $tc[$index] = $terms[$i];
    }
    
    $t_and_c[] = $tc[$index];

    }
    $terms = $t_and_c;
          if($type == '2')
          {
          $res[0]['terms_cond1'] = $terms;
          }
          else if($type == '3')
          {

          $res[0]['terms_and_cond1'] = $terms;
        
          }
     //print_r($res);die;

// *****New code add for user job apply ********
$rev1 = new userdataservice();
$res1 = $req->getfavForUser($res, $type, $user_id);
//print_r($res1);die();
$rev2 = new userdataservice();
$res2 = $req->getuserjobs($res1, $type, $user_id);
$data = array('data'=>$res2 , 'status'=>'1');
echo json_encode($data);

    /***********call the get fav For User ********************/
         
      //    $rev1 = new userdataservice();
      //    $res1 = $rev1->getfavForUser($res, $type, $user_id);
     //     $data = array('data'=>$res1 , 'status'=>'1');
     //     echo json_encode($data);
         // print_r($data);
      /***********************************************/
       }
      //echo json_encode($data);
       
       else
       {
       $data = array('data'=>$res, 'status'=>'0');
       echo json_encode($data);
       }
       
      }



//********* CODE FOR SEARCHING TOURNAMENTS **********//

else if ($_REQUEST['act'] == "search_tournament" )
{
 $id        = urldecode($_POST ['user_id']);
 $type      = urldecode($_POST ['type']);
 $age_group = urldecode($_POST ['age_group']);
 $level     = urldecode($_POST ['level']);
 $location  = urldecode($_REQUEST ['location']);
 $gender    = urldecode($_POST ['gender']);
 $sport     = urldecode($_POST ['sport']);
 $subs      = urldecode($_POST['subs']);
 $para      = urldecode($_POST['para']);
//echo $location;print_r($_REQUEST);
if($para == '')
{

 $whereclause = "WHERE"." ";
 if($sport != "")
 {
 $where1= "`sport` LIKE '%$sport%' ";
}
 if($age_group != ""){
 $where2= "AND `age_group` LIKE '%$age_group%' ";
}
if($level !=""){

$where3= "AND `level` LIKE '%$level%' ";

}
if($location != ""){

$where4 = "AND `location` LIKE '%$location%'"; 

}
if($gender != ""){

$where5 = "AND `gender` LIKE '%$gender%'"; 

}
 //echo $wherenext;
 $wherenext = $where1.$where2.$where3.$where4.$where5;
 if($wherenext == "" ){
$fwhere  = $whereclause."1";

 }
 else
// echo $fwhere;
$fwhere  = $whereclause.$wherenext; 
}
else 
{
  $fwhere = $para;
}
//$al1  = new searchdataservice();
//$al2  = $al1->savealert($id ,$fwhere ,$type); 


$rev = new userdataservice();
$res = $rev->tournamentsearch($fwhere);

if($res != 0){
  

$recarr= array();
$size  = sizeof($res);
for($i = 0; $i<$size ; $i++)
{
  $eligibility = $res[$i]['eligibility1'];
  $res[$i]['eligibility1'] = explode("|",$eligibility);
  $terms = $res[$i]['terms_and_cond1'];
  $res[$i]['terms_and_cond1'] = explode("|", $terms);

  $resid= $res[$i]['id'];
  array_push($recarr, $resid);
}
$recdata = implode(",",$recarr);
if($id != '' && $para == '')
{
$rec     = new userdataservice();
$rec1    = $rec->saverecent($recdata,$type, $id);

}
$rev1 = new userdataservice();
$res1 = $rev->getfavForUser($res, $type, $id);

$data = array('data'=>$res1 , 'status'=>'1');

}

else
{
$data = array('data'=>'0' , 'status'=>'0');
}
if($id !='' && $subs != '0')
{
$al1  = new searchdataservice();
$al2  = $al1->savealert($id ,$fwhere , $type , $size , $subs);
echo $al2;
die();
}
echo json_encode($data);
}

//*********CODE FOR MARKING SEARCH RECORDS AS FAVOURITE BY THE USER **********//

else if ($_POST['act'] == "fav" )
{

$user_id   =urldecode($_POST['user_id']);
$module    =urldecode($_POST['type']);
$user_favs =urldecode($_POST['id']);

$rev = new userdataservice();
$res = $rev->favourites($user_id, $module , $user_favs);
//print_r($res);die();

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
//array_diff( $favo_array, array( '' ) );
$data = implode(",",$favo_array);
//rtrim($data,",");
$id   = $res['id'];


$res = new userdataservice();
$rev = $res->updatefav($id,$user_id,$data);
if($rev == 1)
echo 0;
}

else if($favourite == "")
{
  //echo "in blank";
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

else if($_POST['act'] == "recent")
{
$userid   =  urldecode($_POST ['user_id']);
$type     =  urldecode($_POST ['type']);

$rev      =  new userdataservice();
$res      =  $rev->get_recent($userid , $type);
//print_r($res);
$data     = $res['recent_act'];
$data     = split(",",$data);


$size = sizeof($data);
for($i = 0 ; $i<$size ; $i++)
{

  if($type == '4' || $type =='5')
        { 
          $fwhere ="WHERE us.`userid` = ".$data[$i];
         // echo $fwhere;
          $page  = "flag";
          $res1  = new searchdataservice();
          $rev1  = $res1->gensearch($fwhere,$page);
          $row[] = $rev1; 
          
        }
   
        else if($type != '4' || $type !='5')
        {
        $res1    =  new userdataservice();
        $rev1    =  $res1->get_recentdata($data[$i] , $type);
        $row[]   =  $rev1;
        }
      }
         //print_r($row);
        $id =  $userid;
        $res2 = new userdataservice();
        $rev2 = $res2->getfav($id , $type);
        //print_r($row);
        //print_r($rev2);

        $size = sizeof($row);
        //echo $size;
        for($j = 0 ; $j< $size ; $j++)
        {
           if($type != '4' && $type != '5')
               
               {
        

          if(in_array($row[$j]['id'], $rev2))
               {
    
                   $row[$j]['fav'] = '1';

               }
        else
         
               {
                  $row[$j]['fav'] = '0';
               }

          }
        else if($type == '4' || $type == '5')
          {

         if(in_array($row[$j]['userid'], $rev2))
         
         {

          $row[$j]['fav'] = '1';

         }
         else
         {

          $row[$j]['fav'] = '0';
         }
         }
        }
//print_r($row);

if($type == 1)
{
$req4 = new userdataservice();
$row = $req4->getuserjobs($row, $type, $userid);
}

$row1 = array('data'=>$row);
echo json_encode($row1);

}

//******* CODE FOR FETCHING FAVOURITE SEARCH RECORDS UNDER FAVOURITE TAB FOR THE USER *******//

else if($_POST['act'] == "get_fav")
{
 
$id   = urldecode($_POST ['userid']);
$type = urldecode($_POST ['type']);
$rev  = new userdataservice();
$rev = new   liteservice();
//es  = $rev->getfav($id,$type);
//$rev  = new userdataservice();

$res = $rev->getfav($id,$type);
$res  = $rev->getfavdata($id,$type);
//print_r($res);die();
if($res != 0)
{

$favdata = $res['userfav'];
$favdata = split(",",$favdata);
for($i = 0; $i<sizeof($favdata) ; $i++ )
{

if($type == '4' || $type =='5')
   { 
      $fwhere ="WHERE us.`userid` = ".$favdata[$i];
      $page = 'fav';
      $res1  = new searchdataservice();
      $rev1  = $res1->gensearch($fwhere,$page);
      $res2[] = $rev1; 
      
    }
else
   {
      $res1 = new userdataservice();
      $rev1 = $res1->getfavdata($favdata[$i] , $type);
      $res2[] = $rev1; 
   }
}

if($type == 1)
{
$req = new userdataservice();
$res2 = $req->getuserjobs($res2, $type, $id);
}

$data = array('data'=>$res2,'status' => 1);
echo json_encode($data);
}
else 
$data3 = array('status' => 0);
echo json_encode($data3);
}


/*********    CODE FOR APPLIYING FOR JOB BY THE USER   *************************/

// else if($_POST['act'] == "apply")
// {

// $userid      = urldecode($_POST ['user_id']);// Applicant User Id
// $id          = urldecode($_POST ['id']);       // Job id   
// $type        = urldecode($_POST ['type']);   // when user is Apply the Status/ is Set the 1    
// //$employerid  = urldecode($_POST ['employerid']);// Employer Id

// $rev         = new userdataservice();
// $res         = $rev->jobsapplied($userid , $id , $type);
// //die();
// $rev1        = new userdataservice();
// $res1        = $rev1->getEmpdeviceid($id);

// $rev2        = new userdataservice();
// $res2        = $rev2->getdeviceid($userid);
// $date        = date("F j, Y, g:i a");
// $message = array('message'=>$res2['name']." "." has applied for a job" , 'Module'=>'8','date_Applyed'=>$date,'userid'=>$userid,'id'=>$id);
// $empdevice_id =  $res1['device_id'];
// if($empdevice_id != '')
// {
// $pushobj      = new userdataservice();
// $pushnote     = $pushobj ->sendPushNotificationToGCM($empdevice_id, $message);
// }
// $employerid   = $res1['userid'];
// $title        = 'job application';
// $savealertobj = new userdataservice();
// $message      = $message['message'];
// $type = '8'; // Applied for Job Alert Type recognition No. 
// $savealert    = $savealertobj->savealert($employerid , $type ,$message , $title , $userid);
// $resp['status'] = "Success";
// echo json_encode($resp);
// //echo $savealert;
// //echo json_encode($res);
// }


/******************************** CODE FOR GET APPLY JOBS *******************************************************/


else if($_POST['act'] == "getappliedjobs")
{
$userid = urldecode($_POST['user_id']);
$jobid  =urldecode($_POST['id']);   // JOb id
$req = new userdataservice();
$res  = $req->getAppliedJobListing($userid,$jobid);
if($res)
{
 $data = array('data'=>$res,'status'=>'1');
 echo json_encode($data);
}
else
{
$data = array('data'=>'0','status'=>'0');
echo json_encode($data);
}
}

//CASE FOR SENDING REQUEST TO CANDIDATE ON SELECTION

// else if($_POST['act'] == 'select_applicant')
// {
//   $applicant_id = urldecode($_POST['applicant_id']);
//   $emp_id = urldecode($_POST['employer_id']);
//   $status = urldecode($_POST['status']);
//   $job_id = urldecode($_POST['job_id']);
//   $name   = urldecode($_POST['employer_name']);

//   $req = new userdataservice();
//   $res = $req->jobStatus($job_id,$applicant_id,$status);

//   if($res == true && $status == '1')
//   {
//    $date    = date("F j, Y, g:i a");
//    $message = array('message'=>$name."has sent you a job offer" , 'Module'=>'8');
//    $message1 = array('data'=>$message);
//    $pushobj  = new userdataservice();
//    $getid    = $pushobj->getdeviceid($applicant_id);  
//    $pushnote = $pushobj ->sendPushNotificationToGCM($getid, $message1);
//   }
//   else if($res == true && $status == '2')
//   {
//    $date     = date("F j, Y, g:i a");
//    $message  = array('message'=>"candidate has accepted your offer" , 'Module'=>'8');
//    $message1 = array('data'=>$message);
//    $pushobj  = new userdataservice();
//    $getid    = $pushobj->getdeviceid($emp_id);
//    $pushnote = $pushobj ->sendPushNotificationToGCM($getid, $message1);
//   }

//    echo json_decode($pushnote);
//    $resp = array();
  
//   if($pushnote)
//   {

//    $resp['status'] = "Success";
//    echo json_encode($resp);

//   }
//   else
//   {
//    $resp['status'] = "Failure";
//    echo json_encode($resp);
//   }

// }

/*****************************Sending Offer **************************************/

else if($_POST['act']=="select_applicant")
{
  $applicant_id   = urldecode($_POST['applicant_id']);
  $emp_id         = urldecode($_POST['employer_id']);
  $job_title      = urldecode($_POST['job_title']);
  $job_id         = urldecode($_POST['job_id']);
  $name           = urldecode($_POST['employer_name']);
  $salary         = urldecode($_POST['salary']);
  $joining_date   = urldecode($_POST['joining_date']);
  $other_deatil   = urldecode($_POST['other_deatil']);
  $status         = urldecode($_POST['status']);  // status=1 Apply , status=2 Offer, Status =3 Accept
  switch ($status)
  {
  case '2':
   $req = new userdataservice();
   $res =$req->jobStatus($job_id,$applicant_id,$status,$salary,$joining_date);
    //$date    = date("F j, Y, g:i a");
   $message = array('name'=>$name,'salary'=>$salary,'joining_date'=>$joining_date,'message'=>"has sent you a job offer" , 'Module'=>'8');
   $pushobj  = new userdataservice();
   $getid    = $pushobj->getdeviceid($applicant_id);
   $device_id_apply=$getid['device_id'];
   $pushobj     = new userdataservice();
   $pushnote    = $pushobj ->sendLitePushNotificationToGCM($device_id_apply, $message);
   
   //$pushnote    = $pushobj ->sendPushNotificationToGCM($device_id_apply, $message);
   //$resp['status'] = "Success";
  // echo json_encode($resp);
   $resp['status'] = "Success";
   echo json_encode($resp);
   $emailnote  = $pushobj ->sendEmail($applicant_id);
   //$resp['status'] = "Success";
   // echo json_encode($resp);
   break;
  case '3':
   $req      = new userdataservice();
   $res      =$req->jobStatus($job_id,$applicant_id,$status,$salary,$joining_date);
   $date     = date("F j, Y, g:i a");
   $message  = array('message'=>"candidate has accepted your offer" , 'Module'=>'8');
   $pushobj  = new userdataservice();
   $getid    = $pushobj->getdeviceid($emp_id);
   $device_id_offer=$getid['device_id'];
   $pushnote = $pushobj ->sendPushNotificationToGCM($device_id_offer, $message);
   $resp['status'] = "Success";
   echo json_encode($resp);
   break;
   default:
   $req = new userdataservice();
   $salary='0';
   $joining_date='0';
   $res      =$req->jobStatus($job_id,$applicant_id,$status,$salary,$joining_date);
   $resp['status'] = "Failure";
   echo json_encode($resp);
  }
}



/********************Job OffersList***********************************/
// User see the Job Offer which Company is send

else if($_POST['act'] == 'jobOffersList')
{

  $userid=urldecode($_POST['user_id']);

  $req = new userdataservice();
  $res = $req->getOfferList($userid);
  if($res != 0)
  {
  $data = array('data'=>$res,'status'=>1);
  echo json_encode($data);
  }
  else
  {
  $data = array('status'=>$res);
  echo json_encode($data);
  }

}

/* ***********************************************************************************/

else if($_POST['act'] == "create_resource")
{
  $data = json_decode($_REQUEST['data']);
  $req = new userdataservice();
  $res = $req->createResources($data);
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

/********************************************************************************/

  else if($_GET['act'] == 'getresource')
  {
    $title = urldecode($_REQUEST ['title']); 
    if($title !="")
    {
    $where1= "WHERE `title` LIKE '%$title%' ";
    $search = new userdataservice();
    $res = $search->getResources_search($where1);
      if($res != 0)
    {
    $data = array('data'=>$res , 'status'=>'1');  
    echo json_encode($data);
    }
    else
    {
    $data = array('data'=>'0' , 'status'=>'0');
    echo json_encode($data);
    }
    }
  }
/*---------------------------------------------------------------------------------------
 | This code for User Point of view when the user is search any Job ,Event ,tournament   |
 | after that the user is apply on job ,Event,or Tournament                              | 
 ----------------------------------------------------------------------------------------

/*****************************GetsportyLite Searching*****************************/

else if($_REQUEST['act'] == "gs_searching")
{
 $userid        =   urldecode($_POST ['userid']);  //Apply User Id 
 $module        =   urldecode($_POST ['module']);  //Type Job=1 Event=2 Tournament=3 
 $keyword       =   urldecode($_POST ['key']);   // Search the Value by Applicant User
 $request       =   new userdataservice();
     if(empty($keyword)) 
   {
       $keyword    = '' ;
   }
   else
   {
      $keyword   = $keyword ;
   }
   if ($module=='1')
   {
        $response   = $request->jobsearch($keyword);
   }
   if ($module=='2')
   {
      $response   = $request->eventsearch($keyword);
   }
   if ($module=='3')
  {
      $response   = $request->tournamentsearch($keyword);
  }  
if($response)
{
                                $response      = $request->getfavForUser($response,$module, $userid);
                                if ($module=='1')
                                {
                                     $response      = $request ->getuserjobs($response,$module, $userid);
                                }
           $Result = array('status' => '1','data'=>$response ,'msg'=>'Searching successfully');
           echo json_encode($Result);
}
else
{                     
        $Result = array('status' => '0','data'=>$response ,'msg'=>'Not Searching successfully');
        echo json_encode($Result);
} 
 }   // End Function


/************************  More About the User****************************/

else if($_REQUEST['act'] == "professional")
{
  $userid          =   urldecode($_REQUEST ['userid']);
  $prof_id         =   urldecode($_REQUEST ['prof_id']); 
  $sport           =   urldecode($_REQUEST ['sport']); 
  $location        =   urldecode($_REQUEST ['location']); 
  $request         =   new userdataservice();
  $userType        =   '103';
  $where[]         =   '1 =1 ';
  $arr = array();
   if($userType != '')
   {
      $where[] = " `userType` = '$userType' ";
      $arr['userType'] =  $userType ; 
   }
  if($userid != '')
  {
    $where[] = " `userid` NOT IN ($userid) ";
    $arr['userid'] =  $userid ; 
  }

  if($sport != '')
  {
    $where[] = " `sport` = '$sport' ";
    $arr['sport'] =  $sport ; 
  }
  if($location != '')
  {
       $where[] = "`location` = '$location' ";
       $arr['location'] = $location;
  }
  if($prof_id != '')
  {
     $where[] = "`prof_id` = '$prof_id' "; 
     $arr['prof_id'] = $prof_id;    
  }
    $whereclause = implode('AND', $where);
    $response   = $request->user_Info($whereclause);

  // echo "$whereclause";die();
if($response)
{
                                $response      = $request->getfavForUser($response,$module, $userid);
                              //  if (!empty($userid))
                               // {
                                    
                               // }
           $Result = array('status' => '1','data'=>$response ,'msg'=>'More Result successfully');
           echo json_encode($Result);
}
else
{                     
        $Result = array('status' => '0','data'=>$response ,'msg'=>'More Result is Not Found');
        echo json_encode($Result);
} 
                     

 }   // End Function


/*******************Get Coonect the User and Professional**********************/


else if($_REQUEST['act'] == 'connection_status')
{
$lite_user_id       =  @$_REQUEST['lite_user_id'];
$prof_user_id       =  @$_REQUEST['prof_user_id'];
$request            =  new UserProfileService();
$response           =  $request->getConnectUser($lite_user_id,$prof_user_id);
            if($response)
            {
            $Result = array('status' => '1','data'=>$response ,'msg'=>'User is Connected');
             echo json_encode($Result);
             }
            else
            {                     
              $Result = array('status' => '0','data'=>$response ,'msg'=>'User is Not Connect');
              echo json_encode($Result);
            }

}  // End of Statement


/******************************View Apply by the User ***************************/

else if($_POST['act'] == "gs_viewapply")
{
$userid = urldecode($_POST['user_id']);  // User Id [Person which is Apply Job Or Event or Tournament]
$type = urldecode($_POST['type']);       // Type is Defined the Module [1. Job , 2.Event, 3. Tournament]
$rev = new userdataservice();
$res = $rev->view_apply($userid,$type);
$res1 = $rev->getfavForUser($res, $type, $userid);  // vew the [job,event,tournament is Fav or Not]
if($res1)
{
 $data = array('data'=>$res1,'status'=>'1');
 echo json_encode($data);
}
else
{
$data = array('data'=>'0','status'=>'0');
echo json_encode($data);
}
}




/**********************    New Apply Code  act=apply  *************************/

else if($_REQUEST['act'] == "apply")
{
$userid      = urldecode($_POST ['user_id']); // Applicant User Id
$id          = urldecode($_POST ['id']);       // This is  [Job Id   Event Id  Tournament Id]
$type        = urldecode($_POST ['type']);   // when user is Apply the Status/ is Set the 1 
$module      = urldecode($_POST ['module']);  // User is Apply the Job=1 Event=2 Tournament=3
$request     = new userdataservice();
$req         = new connect_userservice();
$req1        = new emailService();
$response    =  $request->apply($userid,$id,$type,$module);
$date        = date("F j, Y, g:i a");
$user_app    = 'L';
    if ($response)
    {
    $response                  =  $request->FindDeviceId($id,$module);
       if ($response == '')
        {
         $Result = array('status' => '0','data'=>'0' ,'msg'=>'Invalid');
         echo json_encode($Result);die();
        }
        $device_id_Emp             =  $response['device_id'];
        $email_id_Emp              =   $response['email'];
        if ($device_id_Emp)
        {
          $response     = $request->userdata($userid);
          $username     = $response['name'];
          $email         = $response['email'];
           if ($module=='1')
           {
              $message      = array('message'=>$username." "." has applied for a job" , 'Module'=>$module ,'date_Applyed'=>$date,'userid'=>$userid,'id'=>$id);
            }  
          if ($module=='2')
           {
              $message      = array('message'=>$username." "." has applied for a Event" , 'Module'=>$module ,'date_Applyed'=>$date,'userid'=>$userid,'id'=>$id);
           }
          if ($module=='3')
           {
             $message      = array('message'=>$username." "." has applied for a Tournament" , 'Module'=>$module ,'date_Applyed'=>$date,'userid'=>$userid,'id'=>$id);
           }
          $jsondata      = json_encode($message );
         $response       = $req->alerts($userid,$user_app,$json_data); 
          if ($response)
          {
             $response     = $request->sendPushNotificationToGCM($empdevice_id, $message);
             $Result = array('status' => '1','data'=>'1' ,'msg'=>'Apply Success');
             echo json_encode($Result);
          }
     }
      
             // $res2     = $req1->emailForApply($email_id_Emp,$email,$module);
   
    }
    else
    {
      $Result = array('status' => '0','data'=>'0' ,'msg'=>'Not Apply');
       echo json_encode($Result);
    }


} // End Function













//**********CODE FOR VIDEO UPLOAD**************************//

if($_SERVER['REQUEST_METHOD']=='POST')
{
 $file_name = $_FILES['myFile']['name'];
 $file_size = $_FILES['myFile']['size'];
 $file_type = $_FILES['myFile']['type'];
 $temp_name = $_FILES['myFile']['tmp_name'];
 
 $location = 'VideoUpload/';
 
 move_uploaded_file($temp_name, $location.$file_name);
 //echo "http://getsporty.in/VideoUpload/".$file_name;

}
?>  