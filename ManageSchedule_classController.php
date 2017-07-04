<?php
include('config1.php');
include('services/manageSchedulingService.php');
include('services/userdataservice.php');
error_reporting(E_ERROR | E_PARSE);



if($_REQUEST['act'] == "create_class")
{
	//print_r("expression");die;
							$data  = json_decode($_POST['data']);
							$item  = new stdClass();

                            $date = date_create($data->start_date);
                            date_add($date, date_interval_create_from_date_string($data->duration.'months'));
                            $ndate = date_format($date, 'Y-m-d');

							$item->class_name      = $data->class_name;
							$item->description     = $data->description;
							$item->days            = $data->days;
							$item->duration        = $data->duration;
							$item->start_date      = strtotime($data->start_date);
							$item->end_date        = strtotime($ndate);
							$item->start_time      = $data->start_time;
							$item->end_time        = $data->end_time;
							$item->address         = $data->address;
							$item->user_id         = $data->user_id;
							$item->location        = $data->location;
							$item->fee             = $data->fee;
							$item->age_group       = $data->age_group;
							$item->class_strength  = $data->class_strength;
							$item->class_host      = $data->class_host;
							$item->phone_no        = $data->contact_no;
							$item->classtype       = $data->classtype;

                              //print_r($data->contact_no);die;

                        $code = $item->user_id.'@'.substr(str_replace(' ','', $item->start_time),0,3).substr($data->start_date, 3,2).substr($data->start_date,8,2);
                            
                            $req2 = new manageSchedulingService();
                            $res2 = $req2->CheckforExistingClass($item);
              if($res2 == 1)
            {
					    
						$req = new manageSchedulingService();
						$res = $req->createClass($item,$code);

		      if($res == 1)
		    {

						 $req1 = new manageSchedulingService();
						 $res1 =  $req1->getclassdata($item);
		      if($res1 != 0)
		    {
						 $data= array('data'=>$res1, 'status'=>1);
						 echo json_encode($data);
		    }
		    else
		    {
                         $data= array('data'=>0 , 'status'=>1);
						 echo json_encode($data); 
            }
		    }
		    else    
		    {
					     $data= array('data'=>0 , 'status'=>0);
						 echo json_encode($data); 
			}
			    }
			 else
			    {
				           $data= array('data'=>$res2, 'status'=>2, 'message'=>'already exist for same schedule');
				 		  echo json_encode($data); 
				}

		}


else if($_REQUEST['act'] == "update_class")
 {

							$data  = json_decode($_POST['data']);
							$item = new stdClass();

							$date = date_create($data->start_date);
                            date_add($date, date_interval_create_from_date_string($data->duration.'months'));
                            $ndate = date_format($date, 'Y-m-d');

                            $item->user_id        = $data->user_id;
							$item->class_name     = $data->class_name;
							$item->description    = $data->description;
							$item->days           = $data->days;
							$item->duration       = $data->duration;
							$item->start_date     = strtotime($data->start_date);
							$item->end_date       = strtotime($ndate);
							$item->start_time     = $data->start_time;
							$item->end_time       = $data->end_time;
							$item->address        = $data->address;
							$item->class_id       = $data->class_id;
							$item->fee            = $data->fee;
							$item->age_group      = $data->age_group;
							$item->class_strength = $data->class_strength;
							$item->class_host     = $data->class_host;
							$item->phone_no       = $data->contact_no;
							$item->location       = $data->location;

	 
							
	                        $code = $item->user_id.'@'.substr(str_replace(' ','', $item->start_time),0,3).substr($data->start_date, 3,2).substr($data->start_date,8,2);

							$req = new manageSchedulingService();

                             $cheakClass_timing = $req->cheakclass_exist_update($item);

                             if($cheakClass_timing == 0)
                             {
							  $res = $req->updateClass($item,$code);
                            if($res)
                            {
							$cdata =$req->get_updated_classdata($item);

							$data= array('status'=>$res , 'data' => $cdata);
						    echo json_encode($data);
							}
							else
							{
								 $data = array('status' => $res);
								 echo json_encode($data);
							}
							//echo $res;
						}
						else
						{
							     $data = array('status' => 2);
								 echo json_encode($data);
						}


			 }
  

else if($_REQUEST['act'] == "get_studentlist")
 {
                          //print_r($_POST);die;
						//$id = urldecode($_POST['classid']);
						$data  = json_decode($_REQUEST['classid']);
                        $id = $data;
                        //print_r($id);die;
						$req = new manageSchedulingService();
						$res = $req->getstudentlist($id);
               
                         // print_r($res);die;
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
{                       $time = urldecode($_POST['time']);
						$time_in_24_hour_format  = date("H:i", strtotime("7 p.m"));

						$userid = urldecode($_POST['userid']);
						$date   = urldecode(strtotime($_POST['date']));

						$req = new manageSchedulingService();
						$res = $req->getclasslisting($userid, $date);
					if($res != 0)
					{

						$resc  = new manageSchedulingService();
						$resc1 = $resc->get_reschedule($date);
					//print_r($resc1);
					//unset($res[0]['id']);
					if($resc1 != 0)
					{

						$size  = sizeof($resc1);
						$size1 = sizeof($res);

					for ($i=0; $i<$size;$i++)
					{


						 $classid = $resc1[$i]['classid'];
						 $start   = $resc1[$i]['start_time'];
						 $end     = $resc1[$i]['end_time'];
					 
					for ($j=0; $j<$size1 ; $j++)
					{
					    $orig_start = $res[$j]['class_start_timing'];
					    $orig_end   = $res[$j]['class_end_timing'];

					    if($classid == $res[$j]['id'])
					{
					    $res[$j]['class_start_timing'] = $start;
					    $res[$j]['class_end_timing']   = $end;
					    $res[$j]['status']             = $resc1[$i]['resc_type'];   
					}
				}
			 }

					}        for($k = 0 ; $k<sizeof($res) ;$k++)
		         	         {

					             if($res[$k]['status'] == "")
					             {
					    
					             $res[$k]['status']   = '4';

					             }


					         }
							
							$data = array('status'=>'1','data'=>$res);
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
					$data1 = json_decode($_POST['data']);
					$item  = new stdClass();
                     
                     // print_r($data1);die;


					$item->userid              = $data1->userid;
					$item->date                = strtotime($data1->date);
					$item->start_time          = $data1->start_time;
					$item->end_time            = $data1->end_time;
					$item->classid             = $data1->classid;
					$item->type                = $data1->type; 
					$item->existing_classid    = $data1->existing_classid; 
					$item->old_start_time      = $data1->old_start_time;
					$item->old_end_time        = $data1->old_end_time;

					$req = new manageSchedulingService();
					$res = $req->varify_existing($item,$data);


					$req1 = new manageSchedulingService();
					$res1 = $req1->create_reschedule($item);
					if($item->type == 0)
					{
					$data  = '1';
					$start = $item->old_start_time;
					$end   = $item->old_end_time;
					$var   = new manageSchedulingService();
					$var1  = $var->varify_existing($item, $data);
					$req2  = new manageSchedulingService();
					$res2  = $req2->create_reschedulefororig($item , $start, $end);

}

echo $res1;

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