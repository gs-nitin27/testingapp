<?php
include('config1.php');
include('services/searchdataservice.php');
include('services/userdataservice.php');
include('services/getAlertsDataService.php');


//********CODE TO GET LISTING OF LATEST ALERTS************//
if($_POST['act'] == "getLatestAlerts")
{

$userid = urldecode($_POST['user_id']);
$module = urldecode($_POST['type']);

$req = new getAlertsDataService();
$res = $req->getAlerts($userid,$module);

if($res != 0)
{

$data = array('data'=>$res, 'status'=>'1');

}
else
{

$data = array('data'=>$res, 'status' => $res);

}
echo json_encode($data);
}


//********CODE TO GET LISTING OF SUBSCRIBED ALERTS************//

if($_POST['act'] == "getSubscribedAlerts")
{

$userid = urldecode($_POST['user_id']);
$module = urldecode($_POST['type']);

$req = new getAlertsDataService();
$res = $req->getsubscribealerts($userid);
//print_r($res);


if($res != 0)
{
$size = sizeof($res);

for($i=0 ;  $i<$size ; $i++)
{
$param = $res[$i]['search_para'];
$pos   = strstr($param, '%');
$itr = (substr_count($pos, '%'))/'2';
for( $j=0 ; $j<$itr ; $j++)
{

$pos1 = stripos($pos, '%');
 
$str = substr($pos, $pos1);
 
$str_two = substr($str, strlen('%'));
 
$second_pos = stripos($str_two, '%');
 
$str_three = substr($str_two, 0, $second_pos);
 
$unit = trim($str_three); // remove whitespaces

$pos = str_replace("%".$unit."%", '',$pos );
//$para = array($unit);

$test[] = $unit;
$param = implode(',', $test);

}
//print_r($test);

//echo $param;
$res[$i]['search_para'] = $param;
unset($test);
//echo "next";

$module = $res[$i]['Moudule'];
switch($module)
{

case "1":
  $mod = "Job";
   break;
   case "2":
   $mod = "Event";
   break;
   case "3":
   $mod = "Tournament";
   break;
   case "4":
   $mod = "Coach";
   break; 
   case "5":
   $mod = "Trainer";
   break;
   default:
   $mod = "";

}


$res[$i]['title'] = "you subscribed for  ".$mod;
}
//print_r($res);
$data = array('data'=>$res, 'status'=>'1');
//print_r($res);
}
else
{

$data = array('data'=>$res, 'status' => $res);

}
echo json_encode($data);
}

else if($_POST['act'] == "getAlerts")
{

$userid = urldecode($_POST['userid']);
$module = urldecode($_POST['module']);

$req = new searchdataservice();
$res = $req->getalerts($userid,$module);

}

//********CODE UNSUBSCRIBING ALERTS************//

else if($_POST['act'] == 'unsubscribe')
{

$userid = urldecode($_POST['user_id']);
$id     = urldecode($_POST['id']);
$req    = new getAlertsDataService();
$res    = $req->unsubscribeAlerts($userid,$id); 
if($res == 1)
{

$data = array('status'=>'1');

}
else
$data = array('status'=>'0');

echo json_encode($data);

}

// if($_POST['act'] == "testimage")
// {

// $userid = urldecode($_POST['userid']);

// $fwhere = "WHERE us.`userid` = '16' ";

// $page = "";

// $req = new searchdataservice();
// $res = $req->gensearch($fwhere, $page);
// print_r($res);
// }



 ?>