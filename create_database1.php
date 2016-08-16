<?php

//echo "in db";
else if($_POST['act']=="editprofile")
{
 $data1 = json_decode($_REQUEST[ 'data' ],true);

 $item = new stdClass();

//print_r($data1);die();
$item->userId             =  $data1->userid;
$item->formal_edu         =  $data1->formal_education;
$item->sports_edu         =  $data1->sports_education;
$item->other_cert         =  $data1->other_certificate;
$item->Work_exp           =  $data1->work_experience;
$item->player_exp         =  $data1->experience_as_player;
$item->other_exp          =  $data1->other_experience;
$item->other_skills       =  $data1->other_skills;
$item->user_mobile_no     =  $data1->mobile_no;
$item->user_profile_pic   =  $data1->profile_pic;
$item->user_language      =  $data1->language;
$item->user_age_group     =  $data1->age_group;
$item->user_location      =  $data1->location;
$item->user_dob           =  $data1->dob;

$status = array('failure' => 0 , 'success' => 1);

$userId=$data1['userid'];
$formdegree=$data1['formal_education0']['degree'];
$formspec = $data1['formal_education0']['specialisation'];
$formuniversity = $data1['formal_education0']['university'];
$formpassing_year = $data1['formal_education0']['passing_year'];
$formtype_id = $data1['formal_education0']['type_id'];
$formdoc = $data1['formal_education0']['document'];
$formal_edu = $data1['formal_education0']['formal_edu'];
$sportsdegree=$data1['sports_education0']['degree'];
$sportsuniversity = $data1['sports_education0']['university'];
$sportspassing_year = $data1['sports_education0']['passing_year'];
$sportsdoc = $data1['sports_education0']['document'];
$sports_edu = $data1['sports_education0']['sport_edu'];
$otherdegree=$data1['other_certificate0']['degree'];
$otheruniversity = $data1['other_certificate0']['university'];
$otherpassing_year = $data1['other_certificate0']['passing_year'];
$otherdoc = $data1['other_certificate0']['document'];
$other_edu = $data1['other_certificate0']['other_cert'];
$we_role =  $data1['work_experience0']['role'];
$we_org =  $data1['work_experience0']['organisation'];
$we_start_month =  date('Y-m-d', strtotime($data1['work_experience0']['statrting_month']));
$we_end_month =  date('Y-m-d', strtotime($data1['work_experience0']['end_month']));
$we_working =  $data1['work_experience0']['currently_working'];
$we_work=  $data1['work_experience0']['work_experience'];
$player_level = $data1['experience_as_player0']['level'];
$player_result = $data1['experience_as_player0']['best_result'];
$player_tour_name = $data1['experience_as_player0']['tournament_name'];
$player_rank = $data1['experience_as_player0']['best_rank'];
$player_level_rank = $data1['experience_as_player0']['level_at_rank_held'];
$player_achieve = $data1['experience_as_player0']['any_achievement'];
$player_exp = $data1['experience_as_player0']['player_exp'];
$ot_role =  $data1['other_experience0']['role'];
$ot_org =  $data1['other_experience0']['organisation'];
$ot_start_month =  date('Y-m-d', strtotime($data1['other_experience0']['statrting_month']));
$ot_end_month =  date('Y-m-d', strtotime($data1['other_experience0']['end_month']));
$ot_working =  $data1['other_experience0']['currently_working'];
$ot_work=  $data1['other_experience0']['other_experience'];
$user_mobile_no = $data1['mobile_no'];
$user_profile_pic = $data1['profile_pic'];
$user_language = $data1['language'];
$user_age_group  = $data1['age_group'];
$user_location  = $data['location'];
$user_dob = $data1['dob'];
$user_ot_skill=  $data1['other_skills0']['skill_name'];
$user_ot_detail=  $data1['other_skills0']['skill_details'];

?>

