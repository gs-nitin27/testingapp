<?php
include('config1.php');
include('services/manageSchedulingService.php');
include('services/userdataservice.php');
error_reporting(E_ERROR | E_PARSE);



if($_REQUEST['act'] == "create_class")
{   
    $data  = json_decode(file_get_contents("php://input"));
	$date = date_create($data->start_date);
	$start_date= date_format($date,'Y-m-d');

    if($data->classtype == 2 && $data->duration != 0){
    $end_date = date_add($date, date_interval_create_from_date_string($data->duration.'months'));
    $ndate = date_format($end_date, 'Y-m-d');
    }
    else if($data->classtype == 2 && $data->duration == 0)
    {
    $end_date = date_create($data->end_date);
	$ndate= date_format($date,'Y-m-d');
    }else
    {
    $ndate = ''; 	
    }
    //echo $start_date.'---'.$ndate;die;
	$item->class_name      = $data->class_name;
	$item->description     = $data->description;
	$item->days            = $data->days;
	$item->duration        = $data->duration;
	$item->start_date      = $start_date;
	$item->end_date        = $ndate;
	$item->start_time      = $data->start_time;
	$item->end_time        = $data->end_time;
	$item->address         = $data->address;
	$item->user_id         = $data->user_id;
	$item->location        = $data->location;
	$item->fee             = json_encode($data->payment);
	$item->age_group       = $data->age_group;
	$item->class_strength  = $data->class_strength;
	$item->class_host      = $data->class_host;
	$item->phone_no        = $data->contact_no;
	$item->classtype       = $data->classtype;
    
    //print_r($item);die;

    $code = $item->user_id.'@'.substr(str_replace(' ','', $item->start_time),0,3).substr($data->start_date, 3,2).substr($data->start_date,8,2);
    if($data->check_availability == 1)
    { 	
      $req = new manageSchedulingService();
      $res = $req->CheckforExistingClass($item);
    } 
    else
    {
      	$res = 0;
    }        

    if($res == 0)
            {
			    $req = new manageSchedulingService();
				$res = $req->createClass($item,$code);
             if($res != 0)
             {
              
                 $data  = array('status'=>'1','data'=>[],'msg'=>'Success');
                 echo json_encode($data);
             }else
             {
	             $data  = array('status'=>'0','data'=>[],'msg'=>'Failure');
	             echo json_encode($data);
             }
		    }
		else
		   {
	             $data  = array('status'=>'2','data'=>$res,'msg'=>'Class alreday exist for same schedule');
	             echo json_encode($data);

		   }
	}


else if($_REQUEST['act'] == "update_class")
 {
							$data  = json_decode(file_get_contents("php://input"));
							$item = new stdClass();
                            $date = date_create($data->start_date);
							$start_date= date_format($date,'Y-m-d');

	                        if($data->classtype == 2 && $data->duration != 0){
						    $end_date = date_add($date, date_interval_create_from_date_string($data->duration.'months'));
						    $ndate = date_format($end_date, 'Y-m-d');
						    }
						    else if($data->classtype == 2 && $data->duration == 0)
						    {
						    $end_date = date_create($data->end_date);
							$ndate= date_format($date,'Y-m-d');
						    }else
						    {
						    $ndate = ''; 	
						    }
                         
                            $item->user_id        = $data->user_id;
							$item->class_name     = $data->class_name;
							$item->description    = $data->description;
							$item->days           = $data->days;
							$item->duration       = $data->duration;
							$item->start_date     = $start_date;//strtotime($data->start_date);
							$item->end_date       = $ndate;//strtotime($ndate);
							$item->start_time     = $data->start_time;
							$item->end_time       = $data->end_time;
							$item->address        = $data->address;
							$item->class_id       = $data->class_id;
							$item->fee            = json_encode($data->payment);
							$item->age_group      = $data->age_group;
							$item->class_strength = $data->class_strength;
							$item->class_host     = $data->class_host;
							$item->phone_no       = $data->contact_no;
							$item->location       = $data->location;

	 
							
	                        $code = $item->user_id.'@'.substr(str_replace(' ','', $item->start_time),0,3).substr($data->start_date, 3,2).substr($data->start_date,8,2);
		    $req = new manageSchedulingService();
		    if($data->check_availability == 1)
			    { 
			      $cheakClass_timing = $req->CheckforExistingClass($item);
			    } 
		    else
			    { 
			      	$cheakClass_timing = 0;
			    }      
			 if($cheakClass_timing == 0)
                {
				  $res = $req->updateClass($item,$code);
			    if($res != 0)
			    {
			         $data= array('status'=>'1' , 'data' => [] ,'msg'=>'record updated');
			         echo json_encode($data);
				}
				 else
				{
					 $data = array('status' =>'0' ,'data' => [] , 'msg'=>'record not updated');
					 echo json_encode($data);
				}
							
				}
				else
				{
				     $data = array('status' => '2' ,'data'=>$cheakClass_timing, 'msg'=>'class Already exist with Same Schedule' );
					 echo json_encode($data);
				}


			 }
   

else if($_REQUEST['act'] == "get_studentlist")
 {
						$data  = json_decode($_REQUEST['classid']);
                        $id = $data;
                    	$req = new manageSchedulingService();
						$res = $req->getstudentlist($id);
               			if($res != 0)
						{
						$data= array('status' =>1,'data'=>$res);
						echo json_encode($data);
						}
						else
						{  $res = [];
					       $data= array('status' =>0,'data'=>$res);
						   echo json_encode($data);
						}
}



else if($_POST['act'] == "add_student")
{
						 $data               = json_decode($_REQUEST['data']);
						 $item               = new stdClass();
						 $item->fees         = $data->fees;
						 $item->classid      = $data->classid;	
						 $item->joining_date = strtotime($data->joining_date);
						 $item->user_id      = $data->user_id;	
						 $item->student_id   = $data->student_id;	


$req = new manageSchedulingService();
$res = $req->addstudent($item);

if($res == 1)
{
//echo $res;
						$class  = $item->classid;
						$req1   = new manageSchedulingService();
						$res1   = $req1->getStudents($class);
						$data   = array('data'=>$res1);
						echo json_encode($data); 
}
else 
echo $res;
}

else if($_POST['act'] == "get_classstudent")
{
						$class = urldecode($_POST['classid']);
						//echo $item;
						$req1 = new manageSchedulingService();
						$res1 = $req1->getStudents($class);
						if($res1 != 0){
						$data = array('data'=>$res1);
						echo json_encode($data); 
}else{

	echo $res1;
}
}

else if($_REQUEST['act'] == "get_classlisting")
{                    //   print_r($_REQUEST);die;
	                    $time = urldecode($_REQUEST['time']);
						$time_in_24_hour_format  = date("H:i", strtotime("7 p.m"));

						$userid = urldecode($_REQUEST['userid']);
						$date   = urldecode(date_format(date_create($_REQUEST['date']),'Y-m-d'));
                        //echo $date;die;
						$req = new manageSchedulingService();
						$res = $req->getclasslisting($userid, $date);
					if($res != 0)
					{   //echo json_encode($res['data']);die;
                        $resc  = new manageSchedulingService();
						$resc1 = $resc->get_reschedule($date,$res['class_id'],$res);
					if($resc1 != 0)
					{  
						foreach ($resc1 as $key => $value) {
							//print_r($value);
							$res['data'][$key][$id]['class_start_timing'] = $value['start_time'];
							$res['data'][$key][$id]['class_end_timing'] = $value['end_time'];

							$key = $value['data_key'];
							$id  = $value['classid'];
							if($value['resc_type'] == '2')
								{
								$res['data'][$key]['reschedule'] = $value['resc_type'];
								}
							else if($value['resc_type'] == '1' || $value['resc_type'] == '3')
								{//print_r($res['data'][$key]['id']);die;
									//echo $res['data'][$key][$id]['class_start_timing']."first";
							     //echo $res['data'][$key]/*[$id]*/['class_end_timing']."second"; 
                                 $res['data'][$key]/*[$id]*/['class_start_timing'] = $value['start_time'];
                                 $res['data'][$key]/*[$id]*/['class_end_timing'] = $value['end_time'];
                                 $res['data'][$key]['reschedule'] = $value['resc_type'];
								}
							/*else if($value['resc_type'] == '3')	
								{
$exchange_key = $value['exchange_key'];
$excahnge_id  = $value['resc_to'];
$res['data'][$exchange_key][$excahnge_id]['class_start_timing'] = $res['data'][$key]['class_start_timing'] ;
$res['data'][$exchange_key][$excahnge_id]['class_end_timing'] = $res['data'][$key]['class_end_timing'] ;
$res['data'][$key]['class_start_timing'] = $value['start_time'];
$res['data'][$key]['class_end_timing'] = $value['end_time'];
$res['data'][$key]['reschedule'] = $value['resc_type'];
								}*/
							
				}
					 
					}      
							$data = array('status'=>'1','data'=>$res['data']);
							echo json_encode($data);
					         

					    }         
					    else
					    {
				         	$data = array('status'=>0,'data'=>[]);
				         	echo json_encode($data);
				        } 
                  }



else if($_REQUEST['act'] == "class_resc")
{
					$data1 = json_decode(file_get_contents("php://input"));
					$item  = new stdClass();
					//print_r($data1);die;
                    $item->userid              = $data1->userid;
					$item->date                = strtotime($data1->date);
					$item->start_time          = $data1->start_time;
					$item->end_time            = $data1->end_time;
					$item->classid             = $data1->classid;
					$item->type                = $data1->type; 
					$item->existing_classid    = $data1->existing_classid; 
					$item->old_start_time      = $data1->old_start_time;
					//$item->resc_to             = $data1->rechedule_with;
                    /*print_r($data1);
					print_r($item);die;*/
/*					$item->old_end_time        = $data1->old_end_time;

					$req = new manageSchedulingService();
					$res = $req->varify_existing($item,$data);

*/	
					$req1 = new manageSchedulingService();
				    $res1 = $req1->create_reschedule($item);
					/*if($item->type == 0)
					{
					$data  = '1';
					$start = $item->old_start_time;
					$end   = $item->old_end_time;
					$var   = new manageSchedulingService();
					$var1  = $var->varify_existing($item, $data);
					$req2  = new manageSchedulingService();
					$res2  = $req2->create_reschedulefororig($item , $start, $end);*/

				//}
				if($res1 != 0)
				{
					$resp =  array('status' =>$res1 ,'msg'=>'Success' );
				}else
				{
					$resp = array('status' =>$res1, 'msg'=>'Failure');
				}
				echo json_encode($resp);
}

else if($_POST['act'] == "check_existing")
{

					$data1 = json_decode($_POST['data']);
					$item  = new stdClass();

					$item->userid         = $data1->userid;
					$item->date           = strtotime($data1->date);
					$item->start_time     = $data1->start_time;
					$item->end_time       = $data1->end_time;
					$item->classid        = $data1->classid;
					$item->type           = $data1->type; 
					$item->old_start_time = $data1->old_start_time;
					$item->old_end_time   = $data1->old_end_time;
					//print_r($item);
					$check  = new manageSchedulingService();
					$check1 = $check->findresc($item);
if($check1 != 0)
{
  //print_r($check1);
								    $size  = sizeof($check1);
								  
								    for($i = 0; $i<$size ; $i++)
									{

								     $classid= $check1[$i]['classid'];
								   // echo $classid;
								    $fetch   = new manageSchedulingService();
								    $fetch1  = $fetch->fetchdataForExchange($classid);
					                //print_r($fetch1);


									}

					$data1 = array('data' => $fetch1,'status' => 1);
					echo json_encode($data1);
					}
					 else if($check1 == 0)
					{ 
					$req = new manageSchedulingService();
					$res = $req->check_existing($item);

					if($res != 0)
					{
					$data = array('data' => $res,'status' => 1);
					echo json_encode($data);
					}
					else 
					{
					$data3 = array('status' => 0);
					echo json_encode($data3);
					}
}


}

else if($_POST['act'] == "delete_class")
{
					$data1 = json_decode($_POST['data']);
					$item  = new stdClass();

					$item->userid         = $data1->userid;
					$item->date           = strtotime($data1->date);
					$item->start_time     = $data1->start_time;
					$item->end_time       = $data1->end_time;
					$item->classid        = $data1->classid;
					$item->type           = $data1->type; 

					if($item->type == '3')
					{

					$req  = new manageSchedulingService();
					$res  = $req->varify_existing($item);

					$req1 = new manageSchedulingService();
					$res1 = $req1->create_reschedule($item);
					echo $res1;
  
				}
					else if($item->type == '4')
					{

					$req2 = new manageSchedulingService();
					$res2 = $req2->deletesession($item);

					echo $res2;

					}
}

else if($_POST['act'] == "send_notification")
{

					$class = urldecode($_POST['classid']);
					$start_time = urldecode($_POST['start_time']);
					$end_time = urldecode($_POST['end_time']);
					$req1 = new manageSchedulingService();
					$res1 = $req1->getStudents($class);
					if($res1 != 0)
					{
					$size = sizeof($res1);

						for($i=0; $i<$size; $i++)
						{
							$message = "hi"."  ".$res1[$i]['name']."\r\n"."your taikoando has been rescheduled to".$start_time."to".$end_time."please be on time" ;

							$device_id = $res1[$i]['device_id'];
							$pushobj = new userdataservice();
							$pushnote = $pushobj ->sendPushNotificationToGCM($device_id, $message);

					     }

					  }
					else
								{

									echo $res1;
								}

}

else if($_REQUEST['act'] == 'update_fees') 
{
    	//$data = json_decode($_REQUEST['student_userid']);
    	$item = new stdClass();
          
       //print_r($data);die;

    	$item->student_userid   = $_REQUEST['student_userid'];
    	$item->class_id         = $_REQUEST['class_id'];
    	$item->paid             = $_REQUEST['paid'];

    	$res = new manageSchedulingService();

    	$req = $res->update_fees($item);

    	if($res)
    	{
          
          $data = array('status' =>1 , 'msg' => 'Fees updated');
          echo json_encode($data);
    	}
    	else
    	{
    		$data = array('status' =>0 ,'msg'=>'Fees not updated');
    		echo json_encode($data);
    	}
    	
}


?>