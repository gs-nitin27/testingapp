<?php
include('SimpleDatabase.php');
include('userdataservice.php');
if($_POST['act']=="register"){

 $name=urldecode($_POST ['name']);
 $email=urldecode($_POST ['email']);
 $password=urldecode($_POST ['password']);
 $phone=urldecode($_POST ['phone']);
 $gender=urldecode($_POST ['gender']);
 $prof=urldecode($_POST ['prof']);
 $sport=urldecode($_POST ['sport']);
 $location=urldecode($_POST ['location']);

$userData = array('name' => $name,'email' =>$email,'password' =>$password,'phone' => $phone,'gender' => $gender,'proffession'=>$prof,'sport'=>$sport,'location'=>$location);

$ref = new userdataservice();
$rev =  $ref->varify($userData['email']);

 if($rev > 0){
    //echo "fail";
    $status = array('status' => 0, 'message' => 'user already exists', 'result' => "$rev");
    echo json_encode($status); 
       }
   else if($rev == 0) 
       {
        //echo "success";
$ref  = new userdataservice();
$rev1 =  $ref->createUser($userData);
echo json_encode($rev1);  
}
else if($rev1 == 0)
       {
       $status = array('status' => 0 , 'message' => 'some thing went wrong');
       echo json_encode($status); 
     }
}

else if($_POST['act']=="login")
{

$status =  array('sucess' => 1, 'failure'=>0);
$email = urldecode($_POST['email']);
$pass = urldecode($_POST['password']);


$obj = new userdataservice();
$res = $obj->userlogin($email,$pass);
echo json_encode($res);
}

else if($_POST['act']=="editprofile")
{

$data1 = array('userId'=>'45' , 'degree'=>'b.tech' , 'formalities'=>array('course'=>'full' , 'branch' =>'it'));//json_decode($data , true);
//print_r($data1);//die();
$data2 = json_encode($data1);
//echo $data2;
$data3 = json_decode( str_replace( "\\", "", $data2 ) );//;json_decode($data2 , true);

$item = new stdClass();

$item->userId    = $data3->userId;
$item->degree    = $data3->degree;
$item->spec      = $data3->specialisation;
$item->formal_education0      = $data3->formal_education0;
$item->sports_education0      = $data3->sports_education0;
$item->other_certificate0      = $data3->other_certificate0;
$item->work_experience0      = $data3->work_experience0;
$item->experience_as_player0      = $data3->experience_as_player0;
$item->other_experience0      = $data3->other_experience0;
$item->mobile_no      = $data3->mobile_no;
$item->profile_pic      = $data3->profile_pic;
$item->language      = $data3->language;
$item->age_group      = $data3->age_group;
$item->dob      = $data3->dob;
$item->other_skills0      = $data3->other_skills0;
print_r($item);
$obj = new userdataservice();
$res = $obj->edit_educationprofile($item);


}



else if($_REQUEST['act']=="getUserData")
{//p
$userid = urldecode($_REQUEST['userid']);
$rev = new userdataservice();
$formaledu = $rev->getuserdata($userid);

$rev = new userdataservice();
$sportsedu = $rev->getsporteducation($userid);


$rev = new userdataservice();
$otheredu = $rev->getotherskillsdata($userid);


$rev = new userdataservice();
$user_exp = $rev->getuserexperience($userid);


$rev = new userdataservice();
$otherexp = $rev->getuserotherExp($userid);



$rev = new userdataservice();
$sportexp = $rev->getuserExpasPlayer($userid);
//print_r($sportexp);

$rev = new userdataservice();
$user_info = $rev->getuserdata($userid);


$userdata = array('formal_education' => $formaledu , 'sport_education' => $sportsedu , 'other_certification' => $otheredu , 'work_experience' => $user_exp , 'other_experience' => $otherexp , 'sports_experience' => $sportexp , 'user_info' => $user_info);
$user = array('data' => $userdata);
echo json_encode($user);
//print_r($userdata);
}

else if($_POST['act'] == "test")
{

$user = $_POST['user'];
$pass = $_POST['pass'];

$rev = new userdataservice();
$res = $rev->test($user,$pass);
}

?>