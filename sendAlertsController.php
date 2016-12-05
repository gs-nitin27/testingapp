<?php

include('config1.php');
include('services/userdataservice.php');
include('services/searchdataservice.php');
include('services/getAlertsDataService.php');
include('getSportyLite/liteservice.php');



				$req  = new searchdataservice();
				$res  = $req->sendalert();
                $size = sizeof($res);

//print_r($res);//die();
for($i = 0; $i< $size ; $i++)
{                //print_r($res);

				$fwhere = $res[$i]['search_para'];
				//echo $fwhere;

			if($res[$i]['Moudule'] == '4' || $res[$i]['Moudule'] == '5')
				{
						$req1  = new searchdataservice();
						$res1  = $req1->gensearch($fwhere,$page);
				}
				else if ($res[$i]['Moudule'] == '1') 
				{
						$req1 = new userdataservice();
						$res1 = $req1->jobsearch($fwhere);
				}
				else if ($res[$i]['Moudule'] == '2') 
				{
						$req1 = new userdataservice();
						$res1 = $req1->eventsearch($fwhere);
				}
				else if ($res[$i]['Moudule'] == '3') 
				{
						$req1 = new userdataservice();
						$res1 = $req1->tournamentsearch($fwhere);
				}
				else if ($res[$i]['Moudule'] == '6') 
				{
						$req1 = new liteservice();
						$res1 = $req1->GetSearch($fwhere);
				}  

				$updates = sizeof($res1) - $res[$i]['count'];
				//echo $updates;
				if($updates > 0)
				{

					$id = $res[$i]['userid'];


					$getTokenObj = new userdataservice();
					$getToken  = $getTokenObj->getdeviceid($id);

				if($res[$i]['Moudule'] == '1')
				{
				$prof = 'Job';
				}
				else if($res[$i]['Moudule'] == '2')
				{
				$prof = 'Event';	
				}
				else if($res[$i]['Moudule'] == '3')
				{
				$prof = 'Tournament';	
				}
				else if($res[$i]['Moudule'] == '4')
				{
				$prof = 'Coach';	
				}
				else if($res[$i]['Moudule'] == '5')
				{
				$prof = 'Trainer';	
				}
				// else if($res[$i]['Moudule'] == '6')
				// {
				// $prof = 'Subscribed';	
				// echo $res[$i]['Moudule'];
				// } 
			    
			    $userid = $id;
				$empdevice_id = $getToken['device_id'];
				$message = $updates." New Record found for your ".$prof." Search";
                if($empdevice_id != '')
              {
                $pushobj      = new userdataservice();
				$pushnote     = $pushobj ->sendPushNotificationToGCM($empdevice_id, $message);
                //echo $pushnote;
                return $pushnote;
              }
              else 
              	echo $getToken['name']."  is not yet logged in.";
                $type = $res[$i]['Moudule'];
                $title = $prof." search";
                $applicantid = $res[$i]['id'];
                //echo $applicantid."sqssas";
                $req3 = new getAlertsDataService();
				$res3 = $req3->saveSubscribealert( $userid,$applicantid,$message, $prof ,$type);

}
}






 ?>