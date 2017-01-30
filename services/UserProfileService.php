<?php
 class UserProfileService
 {

/**
     * function to edit FormalEducation
     * 
     * Long description (if any) ...
     * 
     * @param in array $education 
     * @return results 1 on success and 0 on failure..
     * @access public  
     */ 
public function editFormalEducation($userid,$education)
{
$id             = $education['id'];
$degree         = $education['Degree_course'];
$specialization = $education['specialization'];
$university     = $education['university'];
$passing_year   = strtotime($education['yr_of_passing']);
$course_type    = $education['course_type'];
$document       = $education['document'];
$formal_edu     = $education['edu_id'];
//print_r($education);

$query = mysql_query("INSERT INTO `gs_user_education`(`id`, `userid`, `Degree_course`, `specialization`, `university`, `yr_of_passing`, `course_type`, `docs`, `edu_id`, `date_created`) VALUES ('$id','$userid','$degree','$specialization','$university',FROM_UNIXTIME ('$passing_year'),'$course_type','$document','$formal_edu',CURDATE()) ON DUPLICATE KEY UPDATE `Degree_course` = '$degree',`specialization` = '$specialization' , `university` = '$university', `yr_of_passing` = FROM_UNIXTIME ('$passing_year'),`course_type` = '$course_type' ,`docs` = '$document'");

if($query)
{

return 1;

}
else
{

return 0;

}



}

/**

     * Short description for editSportsEcucation

     
     * @param in array $sports_edu 

     * @return results 1 on success and 0 on failure..

     * @access public  

     */ 
public function editSportsEducation($userid ,$sports_edu)
{

$id           = $sports_edu['id'];
$degree       = $sports_edu['Degree_course'];
$university   = $sports_edu['university'];
$passing_year = strtotime($sports_edu['yr_of_passing']);
$document     = $sports_edu['docs']; 

$query = mysql_query("INSERT INTO `user_sports_education`(`id`, `userid`, `Degree_course`,  `specialization`, `university`, `yr_of_passing`, `course_type`, `docs`, `edu_id`, `date_created`) VALUES ('$id','$userid','$degree','','$university',FROM_UNIXTIME('$passing_year'),'','$document','',CURDATE()) ON DUPLICATE KEY UPDATE `Degree_course` = '$degree' ,`university` = '$university', `yr_of_passing` = FROM_UNIXTIME ('$passing_year') , `docs` = '$document'");


if($query)
{

return 1;

}
else
{

return 0;

}


}

/**

     * function to edit editExperience
 
     * @param in array $experience 

     * @return results 1 on success and 0 on failure..

     * @access public  

     */ 

public function editExperience($userid,$experience)
{

                                                      
$id                = $experience['id'];
$role              = $experience['designation'];
$organisation      = $experience['organisation'];
$start_month       = strtotime($experience['month_started']);
$end_month         = strtotime($experience['month_ended']);
$currently_working = $experience['currently_working'];
$work_experience   = $experience['user_exp_id'];

$query = mysql_query(" INSERT INTO `gs_User_Experience`(`id`, `userid`, `designation`, `organisation`, `month_started`, `month_ended`, `currently_working`, `user_exp_id`) VALUES ('$id','$userid','$role','$organisation',FROM_UNIXTIME('$start_month'),FROM_UNIXTIME('$end_month'),'$currently_working','$work_experience') ON DUPLICATE KEY UPDATE `designation` = '$role' ,`organisation` = '$organisation', `month_started` = FROM_UNIXTIME ('$start_month'), `month_ended` = FROM_UNIXTIME ('$end_month'), `currently_working` = '$currently_working'");


if($query)
{

return 1;

}
else 
{

return 0;

}
}

/**

     * function to edit editSportExperience
 
     * @param in array $sports_experience 

     * @return results 1 on success and 0 on failure..

     * @access public  

     */ 
public function editSportExperience($userid,$sports_experience)
{ 

$id                 = $sports_experience['id'];
$level              = $sports_experience['level_played'];
$best_result        = $sports_experience['best_result'];
$tournament_name    = $sports_experience['tournament_name'];
$best_rank          = $sports_experience['best_rank'];
$level_at_rank_held = $sports_experience['tournament_level_for_best_rank'];
$any_achievement    = $sports_experience['other_achievement'];

$query = mysql_query("INSERT INTO `gs_User_SportsExperience`(`id`, `userid`, `level_played`, `best_result`, `tournament_name`, `best_rank`, `tournament_level_for_best_rank`, `other_achievement`) VALUES ('$id','$userid','$level','$best_result','$tournament_name','$best_rank','$level_at_rank_held','$any_achievement') ON DUPLICATE KEY UPDATE `level_played` = '$level',`best_result` = '$best_result', `tournament_name` = '$tournament_name' , `best_rank` = '$best_rank',`tournament_level_for_best_rank` = '$level_at_rank_held' ,`other_achievement` = '$any_achievement' ");

if($query)
{

return 1;

}
else
{

return 0;

}

}


/**

     * function to edit editUserSkill
 
     * @param in array $skill 

     * @return results 1 on success and 0 on failure..

     * @access public  

     */ 

 public function editUserSkill($userid,$skill)
{
$id           = $skill['id'];
$user_skill   = $skill['other_skill_name']; 
$skill_detail = $skill['other_skill_detail'];
$query = mysql_query("INSERT INTO `gs_user_skill`(`id`, `userid`, `user_skill`, `skill_detail`)VALUES ('$id','$userid','$user_skill','$skill_detail')ON DUPLICATE KEY UPDATE `user_skill` = '$user_skill',`skill_detail` = '$skill_detail'");

if($query)
{

return 1;

}
else 
{

return 0;

}
}
/**

     * function to edit editUserData
 
     * @param in object $userid
     
     * @return results 1 on success and 0 on failure..

     * @access public  

     */ 

public function editUserData($userid,$userinfo)
{
$name       = $userinfo['name'];
$contact_no = $userinfo['contact_no'];
$address1   = $userinfo['address1'];
$address2   = $userinfo['address2'];
$location   = $userinfo['location'];
$user_image = $userinfo['user_image'];
$dob        = strtotime($userinfo['dob']);
$language   = $userinfo['prof_language'];
$age_catered= $userinfo['age_catered'];
$aboutme    = $userinfo['about_me'];

$query = mysql_query("UPDATE `user` SET `name`='$name',`contact_no`='$contact_no',`address1`='$address1',`address2`='$address2',`dob`=FROM_UNIXTIME ('$dob'),`user_image`='$user_image',`location`='$location',`prof_language`='$language',`age_catered`='$age_catered',`about_me` = '$aboutme' WHERE `userid`='$userid'");

if($query)
{

	return 1;
}
else
{

    return 0;

}	




}

public function getUserEducation($userid,$eduid)
{

$query = mysql_query("SELECT IFNull(`id`,'') AS id, IFNull(`userid`,'') AS userid, IFNull(`Degree_course`,'') AS Degree_course, IFNull(`specialization`,'') AS specialization, IFNull(`university`,'') AS university, IFNull(DATE_FORMAT(`yr_of_passing`, '%D %M %Y'),'') AS yr_of_passing, IFNull(`course_type`,'') AS course_type, IFNull(`docs`,'') AS docs, IFNull(`edu_id`,'') AS edu_id, `date_created`  FROM `gs_user_education` WHERE `userid` = '$userid' AND `edu_id` = '$eduid' ");

if(mysql_num_rows($query)>0)
{

while($row = mysql_fetch_assoc($query))
{

$data[] = $row;



}
return $data;

}
else
{


return 0;

}

}

public function getSportsEducation($userid)
{

$query = mysql_query("SELECT IFNull(`id`,'') AS id, IFNull(`userid`,'') AS userid, IFNull(`Degree_course`,'') AS Degree_course, IFNull(`specialization`,'') AS specialization, IFNull(`university`,'') AS university, IFNull(DATE_FORMAT(`yr_of_passing`, '%D %M %Y'),'') AS yr_of_passing, IFNull(`course_type`,'') AS course_type, IFNull(`docs`,'') AS docs, IFNull(`edu_id`,'') AS edu_id, `date_created` FROM `user_sports_education` WHERE `userid` = '$userid'");
if(mysql_num_rows($query)>0)
{

while($row = mysql_fetch_assoc($query))
{

$data[] = $row;

}
return $data;

}
else
{

return 0;

}    



}

public function getUserExperience($userid,$user_exp)
{
$id                = $experience['id'];
$role              = $experience['designation'];
$organisation      = $experience['organisation'];
$start_month       = strtotime($experience['month_started']);
$end_month         = strtotime($experience['month_ended']);
$currently_working = $experience['currently_working'];
$work_experience   = $experience['user_exp_id'];
$query = mysql_query("SELECT IFNull(`id`,'') AS id, IFNull(`userid`,'') AS userid, IFNull(`designation`,'') AS designation, IFNull(`organisation`,'') AS organisation, IFNull(DATE_FORMAT(`month_started`, '%D %M %Y'),'') AS month_started, IFNull(DATE_FORMAT(`month_ended`, '%D %M %Y'),'') AS month_ended, IFNull(`currently_working`,'') AS currently_working, IFNull(`user_exp_id`,'') AS user_exp_id FROM `gs_User_Experience` WHERE `userid` = '$userid' AND `user_exp_id` = '$user_exp'");
if(mysql_num_rows($query)>0)
{

while($row = mysql_fetch_assoc($query))
{
$data[] = $row;
}
return $data;

}
else
{

return 0;

}

}

public function getUserSportsExp($userid)
{

$query = mysql_query("SELECT IFNull(`id`,'') AS id, IFNull(`userid`,'') AS userid, IFNull(`level_played`,'') AS level_played, IFNull(`best_result`,'') AS best_result, IFNull(`tournament_name`,'') AS tournament_name, IFNull(`best_rank`,'') AS best_rank, IFNull(`tournament_level_for_best_rank`,'') AS tournament_level_for_best_rank, IFNull(`other_achievement`,'') AS other_achievement FROM `gs_User_SportsExperience` WHERE `userid` = '$userid'");
if(mysql_num_rows($query)>0)
{

while($row = mysql_fetch_assoc($query))
{

$data[] = $row;

}
return $data;
}
else
     return 0;

}
public function getuserData($userid)
{

$query = mysql_query("SELECT IFNull(`userid`,'') AS userid, IFNull(`name`,'') AS name, IFNull(`password`,'') AS password, IFNull(`email`,'') AS email, IFNull(`contact_no`,'') AS contact_no, IFNull(`sport`,'')AS sport, IFNull(`Gender`,'') AS gender, IFNull(`address1`,'') AS address1, IFNull(`address2`,'') AS address2,IFNull(DATE_FORMAT(`dob`, '%D %M %Y'),'') AS dob, IFNull(`prof_id`,'') AS prof_id, IFNull(`user_image`,'') AS user_image, IFNull(`location`,'') AS location, IFNull(`prof_language`,'') AS prof_language,IFNull(`age_catered`,'') AS age_catered , IFNull(`device_id`,'')AS device_id,IFNull(`about_me`,'')AS about_me FROM `user` WHERE `userid` = '$userid'");
if(mysql_num_rows($query)>0)
{

while($row = mysql_fetch_assoc($query))
{

$data = $row;


}
return $data;
}
else
{

return 0;

}

}

public function getUserSkill($userid)
{

$query = mysql_query("SELECT IFNull(`id`,'') AS id, IFNull(`user_skill`,'') AS other_skill_name, IFNull(`skill_detail`,'') AS other_skill_detail FROM `gs_user_skill` WHERE `userid` = '$userid'");

if(mysql_num_rows($query)>0)
{

     while($row= mysql_fetch_assoc($query))
     {

          $data[] = $row;
     }
     return $data;
}
else
{

return 0; 

}

}


public function editProfile($userdata)
{
 //print_r($userdata);die();
$userid       = $userdata->userid;
$email        = $userdata->email;
$mobile_no    = $userdata->mobile_no;
$proffession  = $userdata->proffession;
$sport        = $userdata->sport;
$gender       = $userdata->gender;
$dob          = $userdata->dob;
$status       = $userdata->status;  // Status
$query = mysql_query("UPDATE `user` SET `email`='$email',`contact_no`='$mobile_no',`prof_id`='$proffession',`sport`='$sport',`dob`=FROM_UNIXTIME ('$dob'),`Gender`='$gender' WHERE `userid`='$userid'");
if($query)
{
     if ($status==0)
      {
              require('class.phpmailer.php');
              $mail = new PHPMailer();
              $to=$email;
              $from="info@getsporty.in";
              $from_name="Getsporty Lite";
              $subject="Email varification ";
              $emailconform="getsporty.in/testingactivation.php?email=";
              //$emailconform  ="testingapp.getsporty.in/getSportyLite/activation.php?email=";
              //global $error;
              $mail = new PHPMailer();  // create a new object
              $mail->IsSMTP(); // enable SMTP
              $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
              $mail->SMTPAuth = true;  // authentication enabled
              $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
              $mail->Host = 'dezire.websitewelcome.com';
              //$mail->Host = 'smtp.gmail.com';
              $mail->Port = 465; 
              $mail->Username ="info@getsporty.in";  
              $mail->Password = "%leq?xgq;D?v";           
              $mail->SetFrom($from, $from_name);
              $mail->Subject = $subject;
              // $mail->Body = ' 
              //            <h1> Click here </h1>'.$emailconform.''.$email.'<br><b>Note:- Please varification of this email</b>
              // '; 
$mail->Body = '<div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#5666be;">

 <table align="center" border="4" cellpadding="4" cellspacing="3" style="max-width:440px" width="100%" class="" >
<tbody><tr>
<td align="center" valign="top">
<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="background-color:#ffffff;  border-bottom:2px solid #e5e5e5;border-radius:4px" width="100%">
<tbody><tr>

<td align="center" style="padding-right:20px;padding-left:20px" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td align="left" valign="top" style="padding-top:40px;padding-bottom:30px">
</td>
</tr>
<tr>
<td style="padding-bottom:20px" valign="top">
<h1 style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:28px;font-style:normal;font-weight:600;line-height:36px;letter-spacing:normal;margin:0;padding:0;text-align:left">Please verify your email Address.</h1>
</td>
</tr>
<tr>
<td style="padding-bottom:20px" valign="top">
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left">To validate Your email Address, you MUST click the link below.<strong><br><h1> Click activate to login</br> <a href="'.$emailconform.''.$email.'">Activate<br></strong>
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left"><br>Note:- If clicking the link does not work, you can copy and paste the link into your browser address window,or retype it there.<br><br><br><br><br>Thanks you for visiting</p></br><p>GetSporty Team</p> 

</td>
</tr>
<tr>
<td align="center" style="padding-bottom:60px" valign="top">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td align="center" valign="middle">
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</div>'; 
               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
                   return 1; 
          }
          else
          {
            return 1;
          }
 }
else
{

    return 0;

}    



} // End of Function










} // End of Class


 ?>