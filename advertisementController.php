<?php
include('config1.php');
include('services/AdvertisementService.php');

if($_REQUEST['act'] == 'get_current_offer')
{
   $obj = new AdvertisementService();
   $objVar = $obj->get_advertisement();
   if($objVar != 0)
   {
   	$resp = array('status' => '1','data'=>$objVar, 'msg'=>'Success');
   }else
   {
   	$resp = array('status' => '0','data'=>[], 'msg'=>'Failure');
   }
  echo json_encode($resp);
}

?>