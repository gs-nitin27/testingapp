<?php
include('config1.php');
include('services/getListingService.php');
include('services/userdataservice.php');
include('services/searchdataservice.php');
include('services/UserProfileService.php');
include('services/emailService.php');
include('getSportyLite/liteservice.php');
error_reporting(E_ERROR | E_PARSE);

if($_REQUEST['act'] == 'notificationlisting')
{
	$userid                	=  @$_REQUEST['userid'];
	$user_app              	=  @$_REQUEST['user_app'];
	$request                =  new GetListingService();
	$response               =  $request->getAlertListing($userid,$user_app);
  $num                    =  sizeof($response);
            for($i = 0 ; $i< $num ; $i++)
            {    
             $response [$i]['alert_data'] = json_decode($response[$i]['alert_data']);
            }
            if($response)
            {
              $Result = array('status' => '1','data'=>$response,'msg'=>'Success');
              echo json_encode($Result);
            }
            else
            { $data = [];                  
              $Result = array('status' => '0','data'=>$data ,'msg'=>'No data');
              echo json_encode($Result);
            }

}  // End of Statement


