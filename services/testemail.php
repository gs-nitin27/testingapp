<?php
include('emailService.php');
include('../email/emailtemplateService.php');

$req1        = new emailService();
$email="devendrakumarpandey@gmail.com";
$userid = 484;
$prof_id = 1;
$username = "ram singh";
$prof_name = "ABC";
$contact_no ="9374633";
$image_url = "https://lh5.googleusercontent.com/-TWjvOJmD4xA/AAAAAAAAAAI/AAAAAAAAATo/Qs5aHLST3k4/photo.jpg";

if (empty($image_url))
{
$image_url = "http://getsporty.in/staging/uploads/profile/demo.png";
}

$res1                      =  $req1->email_job_apply($email,$userid,$prof_id,$username,$prof_name,$contact_no,$image_url);




?>