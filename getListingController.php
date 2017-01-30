<?php
include('config1.php');
include('services/searchdataservice.php');
include('services/userdataservice.php');
include('services/getListingService.php');


//*********CODE FOR STATE LISTING *************//
if($_REQUEST['act'] == "statelisting")
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


if($_REQUEST['act'] == "citylisting")
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

if($_REQUEST['act'] == "sportlisting")
{
$req = new GetListingService();
$res = $req->getsportlisting();
$data = array('data'=>$res);
echo json_encode($data);
}

//*********CODE FOR Profession Listing *************//

if($_REQUEST['act'] == "professionlisting")
{
$req = new GetListingService();
$res = $req->getProfession();
$data = array('data'=>$res);
echo json_encode($data);
}


?>