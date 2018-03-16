<?php
include('config1.php');

if($_REQUEST['act'] == 'eventimage')
{   
$data =  file_get_contents("php://input");
$imageData = base64_decode($data);
$source = imagecreatefromstring($imageData);
$angle = 0;
$imageName = 'event_'.time().'.jpeg';
$rotate = imagerotate($source, $angle, 0); 
$imageSave = imagejpeg($rotate,$imageName,100);
$newpath = UPLOAD_DIR_EVENT.$imageName;
rename($imageName,$newpath);
echo json_encode($imageName);
}

else if($_REQUEST['act'] == 'jobimage')
{   error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('memory_limit', '-1');	
$data =  file_get_contents("php://input");
$data = preg_replace('#^data:image/[^;]+;base64,#', '', $data);
$imageData = base64_decode($data);
$source = imagecreatefromstring($imageData);
$angle = 0;
$imageName = 'job_'.time().'.jpeg';
$rotate = imagerotate($source, $angle, 0); 
$imageSave = imagejpeg($rotate,$imageName,100);
$newpath = UPLOAD_DIR_JOB.$imageName;
if(isset($_REQUEST['ui']))
{
$resp = rename($imageName,$newpath);
//echo json_encode($imageName);
if($resp)
{
	$response  = array('status' =>'1' ,'data'=>$imageName );
}else
{
	$response  = array('status' =>'0' ,'data'=>[] );
}
echo json_encode($response);

}else
{
echo json_encode($imageName);	
}
}

else if($_REQUEST['act'] == 'profilejob')
{   
$data =  file_get_contents("php://input");
$imageData = base64_decode($data);
$source = imagecreatefromstring($imageData);
$angle = 0;
$imageName = 'profile_'.time().'.jpeg';
$rotate = imagerotate($source, $angle, 0); 
$imageSave = imagejpeg($rotate,$imageName,100);
$newpath = UPLOAD_DIR.$imageName;
rename($imageName,$newpath);
echo json_encode($imageName);
}



?>