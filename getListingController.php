<?php
include('config.php');
include('services/searchdataservice.php');
include('services/userdataservice.php');
include('services/getListingService.php');


//*********CODE FOR STATE LISTING *************//
if($_POST['act'] == "statelisting")
{
$sug = $_POST['suggest'];
if ($sug == '')
{

	$fwhere = 'WHERE 1';
	
}else 
{
	$fwhere = "WHERE `state` LIKE '%".$sug."%'";
}
$req = new GetListingService();
$res = $req->getstate_listing($fwhere);


$data = array('data'=>$res);
echo json_encode($data);
}


//*********CODE FOR CITY LISTING *************//


if($_POST['act'] == "citylisting")
{
$sug = $_POST['suggest'];
if ($sug == '')
{

	$fwhere = 'WHERE 1';
}else 
{
	$fwhere = "WHERE `state` LIKE '%".$sug."%'";
}
$req = new GetListingService();
$res = $req->getcitylisting($fwhere);


$data = array('data'=>$res);
echo json_encode($data);
}

//*********CODE FOR SPORTS LISTING *************//

if($_POST['act'] == "sportlisting")
{
$req = new GetListingService();
$res = $req->getsportlisting();
$data = array('data'=>$res);
echo json_encode($data);
}
?>