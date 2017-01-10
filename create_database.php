<?php
include('config1.php');
include('services/userdataservice.php');
include('services/searchdataservice.php');
include('services/UserProfileService.php');
error_reporting(E_ERROR | E_PARSE);


//****CODE FOR USER REGISTRATION******//

if($_POST['act']=="register")
{

 $name       =urldecode($_POST ['name']);
 $email      =urldecode($_POST ['email']);
 $password1  =md5(urldecode($_POST ['password']));
 $phone      =urldecode($_POST ['phone']);
 $gender     =urldecode($_POST ['gender']);
 $prof       =urldecode($_POST ['prof']);
 $sport      =urldecode($_POST ['sport']);
 $location   =urldecode($_POST ['location']);
 $token      =urldecode($_POST ['token']);
 $usertype   ='104';//urlencode($_POST ['usertype']);


 $where  = "WHERE `email` = '".$email."'";
 $req    = new userdataservice();
 $res    = $req->userVarify($where);
 $data   = array('name'=>$name,'email'=>$email,'password'=> $password1,'phone'=>$phone,'gender'=>$gender,'prof'=>$prof,'sport'=>$sport,'location'=>$location,'token'=>$token,'usertype'=>$usertype);
 
 if($res != 0)
 {

$status = array('status' => 0, 'message' => 'user already exists');
echo json_encode($status); 

 }


else
{
$req1 = new userdataservice();
$res1 = $req1->createUser($data);
if($res1 == '1')
{
$req2 = new userdataservice();
$res2 = $req2->userVarify($where);
if($res2 != 0)
{

$res3 = array('data' => $res2,'status' => 1);
echo json_encode($res3);  


}


}
else
{
$res3 = array('data' => 'record not saved','status' => 0);
echo json_encode($res3);  
}
}
}




//****CODE FOR USER Login******//

else if($_POST['act']=="login")
{
$status   = array('sucess' => 1, 'failure'=>0);
$email    = urldecode($_POST['email']);
$pass     = md5(urldecode($_POST['password']));
$username = mysql_real_escape_string($email);
$password = mysql_real_escape_string($pass);
$token    = urldecode($_POST ['token']);
$multiple = 0;
$validate = mysql_query("SELECT `userid` , `name`,`prof_id` , `user_image`,`location`,`device_id`FROM `user` WHERE `email` = '$username' AND `password` = '$password' ");
$row = mysql_num_rows($validate);

if($row==1)
{
	while($row1 = mysql_fetch_assoc($validate))
	{
	   if($row1['device_id'] != $token )
	  {
	    $mes  = 'Multiple Logins not allowed, You have been successfully Logged Out';
      $multiple = '1';
      $message = array('message'=>$mes,'multiple'=>"1");
	    $pushobj      = new userdataservice();
       $pushnote     = $pushobj ->sendPushNotificationToGCM($row1['device_id'], $message);
 		  $obj = new userdataservice();
	    $upd = $obj->updatedevice($token ,$email);
      $multiple = "1";
	  }
         
          $data = array('data'=>$row1,'status'=>'1','multiple'=>$multiple);
         // print_r($data);die();
          echo json_encode($data);
	   // $status = array('status' => 1);
	   // $res = array('data' => $row1,'status' => 1);
	   // echo json_encode($res); 

	}
}
else
    {
        $data = array('data'=>'Invalid login credentials' , 'status'=>'0');
        echo json_encode($data);
    }

//  else
//  {
// $res = array('status' => 0 , 'message' => 'Invalid login credentials' );
// echo json_encode($res);
//   }

}


//******************CODE FOR EDIT PROFILE STARTS ******************************/

else if($_POST['act']=="editprofile")
{
$userid = urldecode($_POST['userid']);
$data1  = json_decode($_REQUEST[ 'data' ]);////

$item                     =  new stdClass();
$item->formal_edu         =  $data1->formal_education;
$item->sports_edu         =  $data1->sports_education;
$item->other_cert         =  $data1->other_certificate;
$item->Work_exp           =  $data1->work_experience;
$item->player_exp         =  $data1->experience_as_player;
$item->other_exp          =  $data1->other_experience;
$item->other_skills       =  $data1->other_skills;
$item->userinfo           =  $data1->info;
$item->other_skills       =  $data1->other_skills;

//print_r($item);

$formaledu = (json_decode(json_encode($item->formal_edu),true));
$size = sizeof($formaledu);
for($i=0;$i<$size;$i++)
{
$req1 = new UserProfileService();
$res1 = $req1->editFormalEducation($userid,$formaledu[$i]);

if($res1 != '1')
{

echo "some problem while saving formal education";

}
}
$sports_edu = (json_decode(json_encode($item->sports_edu),true));
$size       = sizeof($sports_edu);
for ($i=0; $i <$size ; $i++) 
{ 
$req2  = new UserProfileService();
$res2 = $req2->editSportsEducation($userid ,$sports_edu[$i]);

if($res2!= '1')
{

echo "some problem while saving sports education";

}
}

$education = (json_decode(json_encode($item->other_cert),true));
//print_r($education);
$size = sizeof($education); 
for ($i=0; $i <$size ; $i++) 
{ 

$req3 = new UserProfileService();
$res3 = $req3->editFormalEducation($userid ,$education[$i]);
//echo $res3;
if($res3 != '1')
{

echo "some problem while saving other certs info.";

}
}
$experience = (json_decode(json_encode($item->Work_exp),true));
//print_r($experience);
$size       = sizeof($experience);
for ($i=0; $i <$size ; $i++) 
{ 

$req4 = new UserProfileService();
$res4 = $req4->editExperience($userid ,$experience[$i]);

if($res4 != '1')
{

echo "some problem while saving user work experience";

}
}
 $sports_experience = (json_decode(json_encode($item->player_exp),true));
 $size = sizeof($sports_experience);
 //$array = print_r($sports_experience);die();
 for ($i=0; $i <$size ; $i++)
{ 
  $req5 = new UserProfileService();
  $res5 = $req5->editSportExperience($userid ,$sports_experience[$i]);

  if($res5 != '1')
  {

   echo "Some probelem while saving user sports experience";

  }
}

$experience = (json_decode(json_encode($item->other_exp),true));
$size       = sizeof($experience);
for ($i=0; $i <$size ; $i++) 
{ 

$req6 = new UserProfileService();
$res6 = $req6->editExperience($userid ,$experience[$i]);

if($res6 != '1')
{

echo "some problem while saving user work experience";

}
}
$skill = (json_decode(json_encode($item->other_skills),true));
$size  = sizeof($skill);
//print_r($skill);
for($i=0;$i<$size;$i++)
{

$req7 = new UserProfileService();
$res7 = $req7->editUserSkill($userid ,$skill[$i]);
if($res7 != '1')
{

echo "some problem while saving user skill";

}


}
$userinfo = json_decode(json_encode($item->userinfo),true);
$req = new UserProfileService();
$res = $req->editUserData($userid,$userinfo);
//echo $res;
if($res != '1')
{

echo "some problem while updating user info";

}
//echo "res1=".$res1." res2=".$res2." res3=".$res3." res4=".$res4." res5=".$res5." res6=".$res6." res7=".$res7." res=".$res;
if ( $res1 != '0' && $res2 != '0' && $res3 != '0' && $res4 != '0' && $res5 != '0' && $res6 != '0' && $res7 != '0' && $res != '0')
{

$status = array('failure' => 0 , 'success' => 1);
echo json_encode($status);
} 
else 
{

$status = array('failure' => 1 , 'success' => 0);
echo json_encode($status);

}
}

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
//print_r($userdata);
$user = array('data' => $userdata);
echo json_encode($user);
}


//********* CODE FOR CREATING JOBS **********//

else if($_POST['act']=="createjob")
{
$status = array('failure' => 0 , 'success' => 1);
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

//print_r($item);

$req = new userdataservice();
$res = $req->create_job($item);

if($res != 0){

echo json_encode($status['success']);

}
else
echo json_encode($status['failure']);

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


if($item->checkBox_maleValue == "1" ){
$gender = "Male";

}else if($item->checkBox_femaleValue == "1"){

$gender = "Female";

}
else if($item->checkBox_femaleValue == "1" && $item->checkBox_maleValue == "1"  ){

$gender = "Unisex";

}

$req = new userdataservice();
$res = $req->create_tournament($item);
if($res == 1){

echo json_encode($status['success']);

}
else
echo json_encode($status['failure']);

}


//********* CODE FOR CREATING EVENTS **********//

else if ($_POST['act'] == 'createevent') {
  
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
else if($_POST['act'] == "editcreation")
{
$userid = urldecode($_POST['userid']);
$type   = urldecode($_POST['type']);
$id     = urldecode($_POST['id']);

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
  


}}
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
 $id        =urldecode($_POST ['user_id']);
 $type      =urldecode($_POST ['type']);
 $job_title =urldecode($_POST ['job_title']);
 $sport_name=urldecode($_POST ['sport_name']);
 $location  =urldecode($_POST ['location']);
 $gender    =urldecode($_POST ['gender']);
 $subs      =urldecode($_POST ['subs']);
 $para      =urldecode($_POST ['para']);

if($para == '') // For Default Search parameters
{


$whereclause = "WHERE"." ";

if($sport_name !="")
{

$where2= "AND `sport` LIKE '%$sport_name%' ";

}
if($job_title != ""){


$where1= "`title` LIKE '%$job_title%' ";
//$fwhere = $whereclause.$whereclause1;
}
if($location != ""){

$where3 = "AND `city` LIKE '%$location%'"; 

}
 if($gender != ""){

$where4 = "AND  `gender` LIKE '%$gender%'"; 

}//echo $wherenext;
 $wherenext = $where1.$where2.$where3.$where4;
 if($wherenext == "" ){
$fwhere  = $whereclause."1";

 }else
// echo $fwhere;
$fwhere  = $whereclause.$wherenext; 
}
else
{

$fwhere = $para;

}//echo $fwhere;

$search = new userdataservice();
$search_param = $search->saveparam($id,$job_title,$sport_name,$location);
//echo $id.$job_title.$sport_name.$location;//die();
$rev = new userdataservice();
$res = $rev->jobsearch($fwhere);
if($res != 0)
{

if($id != '')
{
$recarr = array();
$size = sizeof($res);
for($i = 0; $i<$size ; $i++)
{

  $resid= $res[$i]['id'];
  array_push($recarr, $resid);
  $recarr[$i][$resid];
}

$recdata = implode(",",$recarr);
if($para == '')
{
$rec     = new userdataservice();
$rec1    = $rec->saverecent($recdata,$type, $id);
}
}

$rev1 = new userdataservice();
$res1 = $rev->getfavForUser($res, $type, $id);

$rev2 = new userdataservice();
$res2 = $rev->getuserjobs($res1, $type, $id);
$data = array('data'=>$res2 , 'status'=>'1');
echo json_encode($data);

if($id !='' && $subs != '0')
{
$al1  = new searchdataservice();
$al2  = $al1->savealert($id ,$fwhere , $type , $size, $subs);
echo $al2;
die();
}

}
else
{
$data = array('data'=>'0' , 'status'=>'0');
echo json_encode($data);
}


//echo json_encode($data);
}

//********* CODE FOR SEARCHING EVENTS **********//

else if ($_POST['act'] == "search_event" )
{
 $id          = urldecode($_POST ['user_id']);
 $evtype      = urldecode($_POST ['evtype']);
 $type        = urldecode($_POST ['type']);
 $sport       = urldecode($_POST ['sport']);
 $location    = urldecode($_POST ['location']);
 $subs        = urldecode($_POST ['subs']);
 $para        = urldecode($_POST ['para']);
 if($para == ''){
 $whereclause = "WHERE"." ";
 if($evtype != "")
 {
 $where1= "`type` LIKE '%$evtype%' ";
 }
if($sport !="")
{

$where2= "AND `sport` LIKE '%$sport%' ";

}
if($location != "")
{

$where3 = "AND `location` LIKE '%$location%'"; 

}
 
 $wherenext = $where1.$where2.$where3;
 if($wherenext == "" )
 {
$fwhere  = $whereclause."1";

 }
 else
$fwhere  = $whereclause.$wherenext; 
//echo $fwhere;
}
else 
{
  $fwhere  = $para;
}
$rev = new userdataservice();
$res = $rev->eventsearch($fwhere);
if($res != 0)
{
if($id != '')
{
$recarr = array();
$size   = sizeof($res);
for($i  = 0; $i<$size ; $i++)
{
  $eligibility = $res[$i]['eligibility1'];
  $res[$i]['eligibility1'] = explode("|",$eligibility);
  $terms = $res[$i]['terms_cond1'];
  $res[$i]['terms_cond1'] = explode("|", $terms);

  $resid= $res[$i]['id'];
  array_push($recarr, $resid);
}
$recdata = implode(",",$recarr);

if($para == '')
{
$rec     = new userdataservice();
$rec1    = $rec->saverecent($recdata,$type, $id);
}
}
$req = new userdataservice();

$res1 = $rev->getfavForUser($res, $type, $id);
$data = array('data'=>$res1 , 'status'=>'1');
echo json_encode($data);
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
    /*******************************/
    $eligibility = $res[0]['eligibility1'];
    $eligibility = explode("|",$eligibility);
    $eligibility = array_filter(array_values($eligibility));
    $size        = sizeof($eligibility);
    //print_r($size);die();
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
     // print_r($res);die;
    /***********call the get fav For User ********************/
         
          $rev1 = new userdataservice();
          $res1 = $rev1->getfavForUser($res, $type, $user_id);
          $data = array('data'=>$res1 , 'status'=>'1');
          echo json_encode($data);
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

else if ($_POST['act'] == "search_tournament" )
{
 $id        = urldecode($_POST ['user_id']);
 $type      = urldecode($_POST ['type']);
 $age_group = urldecode($_POST ['age_group']);
 $level     = urldecode($_POST ['level']);
 $location  = urldecode($_POST ['location']);
 $gender    = urldecode($_POST ['gender']);
 $sport     = urldecode($_POST ['sport']);
 $subs      = urldecode($_POST['subs']);
 $para      = urldecode($_POST['para']);
 
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
$id   = urldecode($_POST ['id']);
$type = urldecode($_POST ['type']);
$rev  = new userdataservice();
$res  = $rev->getfav($id,$type);
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



else if($_POST['act'] == "apply")
{
//echo "DEV kumar";die();
$userid      = urldecode($_POST ['user_id']);// Applicant User Id
$id          = urldecode($_POST ['id']);       // Job id   
$type        = urldecode($_POST ['type']);      
$employerid  = urldecode($_POST ['employerid']);// Employer Id
$rev         = new userdataservice();
$res         = $rev->jobsapplied($userid , $id , $type);
//die();
$rev1        = new userdataservice();
$res1        = $rev1->getEmpdeviceid($id);

$rev2        = new userdataservice();
$res2        = $rev2->getdeviceid($userid);
$date        = date("F j, Y, g:i a");
$message = array('message'=>$res2['name']." "." has applied for a job" , 'Module'=>'8','date_Applyed'=>$date,'userid'=>$userid,'id'=>$id);
$empdevice_id =  $res1['device_id'];
if($empdevice_id != '')
{
$pushobj      = new userdataservice();
$pushnote     = $pushobj ->sendPushNotificationToGCM($empdevice_id, $message);
}
$employerid   = $res1['userid'];
$title        = 'job application';
$savealertobj = new userdataservice();
$message      = $message['message'];
$type = '8'; // Applied for Job Alert Type recognition No. 
$savealert    = $savealertobj->savealert($employerid , $type ,$message , $title , $userid);
$resp['status'] = "Success";
echo json_encode($resp);
//echo $savealert;
//echo json_encode($res);
}


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
  $status         = urldecode($_POST['status']);
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



/***********************************************************************/


//******************************************//
//**********GCM TESTING CODE***************//
//****************************************//
// else if($_POST['act'] == "test")
// {


// $empdevice_id =  'eh3pHqkPexM:APA91bFZovz1S5USAvx0PLBYZLcz6QRegMExKihgXrkQd3wjGwbPECqeGj_NckqA0COXsUQaaBVvownvnZrbeP5xVMNGqAgSQMKzQYY9F-jTPxD2-XklVvL0y4VNjuZN2GYgkI-pi5mt';
// $message ="has applied for a job";


// $pushobj      = new userdataservice();
// $pushnote     = $pushobj ->sendPushNotificationToGCM($empdevice_id, $message);
// echo $pushnote;

// }
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