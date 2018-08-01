<?php

include('config1.php');
include('services/property_listing_service.php');

if($_REQUEST['act'] == 'add_institute')
{
$data = json_decode(file_get_contents('php://input'));
$obj = new Property_listing_service();
$resp = $obj->addInstitutetoListing($data);
if($resp != 0)
{
$resp = array('status' =>'1' , 'msg'=>'Success');
}else
{
$resp = array('status' =>'0' , 'msg'=>'Failure');
}
echo json_encode($resp);
}

if($_REQUEST['act'] == 'institute_list')
{
@$q = $_REQUEST['q'];
$obj = new Property_listing_service();
$resp = $obj->getInstituteListing($q);
if($resp != 0)
{
$resp = array('status' =>'1' ,'data'=>$resp ,'msg'=>'Success');
}else
{
$resp = array('status' =>'0' ,'data'=>[], 'msg'=>'Failure');
}
echo json_encode($resp);
}




 ?>