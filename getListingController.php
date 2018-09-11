<?php
include('config1.php');
include('services/searchdataservice.php');
include('services/userdataservice.php');
include('services/getListingService.php');
include('getSportyLite/liteservice.php');




//*********CODE FOR STATE LISTING *************//


if($_REQUEST['act'] == "statelisting")
{

$fwhere = 'WHERE 1';
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
$prof_type =@$_REQUEST['prof_type'];
$req  = new GetListingService();
$res  = $req->getProfession($prof_type);
$data = array('data'=>$res);
echo json_encode($data);
}




//*********CODE FOR City  Listing *************//


if($_REQUEST['act']=="locationlisting")
 { 

    $req           =  new GetListingService();
    $res           =  $req->Get_Location();
	$data = array('data'=>$res);
	echo json_encode($data);
}

//*********CODE FOR City  Listing *************//


if($_REQUEST['act']=="agegrouplisting")
 { 
 	$req           =  new GetListingService();
    $res           =  $req->Age_Group();
	$data = array('data'=>$res);
	echo json_encode($data);
}
if($_REQUEST['act']=='event_type_list')
{
	$obj = new GetListingService();
	$res = $obj->getEventType();
	if($res != false)
	{
     $resp = array('data'=>$res, 'status'=>1);
	}
	else
	{
	 $resp = array('data'=>[],'status'=>0);
    }
    echo json_encode($resp); 
}
//*********Code For Academy Listing *************//
if($_REQUEST['act']=="academy_listing")
{
$where = [];
@$location  = $_REQUEST['location'];
@$sport     = $_REQUEST['sport'];
@$userid    = $_REQUEST['userid'];
$where[] = " `status` <> 0 ";
if($location != '')
{
	$where[] = "`location` LIKE '%$location%'";
}
if($sport != '')
{
	$where[] = "`sports` LIKE '%$sport%'";
}
$obj = new GetListingService();
$objvar = $obj->academy_list($where);
if($objvar != '0')
{
$obj1 = new liteservice();
$fa_var = $obj1->getfav($userid,'7');	
if($fa_var != 0)
{
	$fav_list = split(',', $fa_var['userfav']);
    foreach ($objvar as $key => $value) {

    	if(in_array($value['id'], $fav_list))
    	{  
    		
    		$objvar[$key]['fav'] = '1';
    	}
    }
}
$resp = array('status' => '1','data'=>$objvar , 'msg'=>'Success');
}
else
{
$resp = array('status' => '0','data'=>[] , 'msg'=>'Failure');	
}
echo json_encode($resp);
}	


?>