<?php
include('config1.php');
include('services/inventryservice.php');



if($_REQUEST['act'] == 'fee_payment')
{
 $userdata           =  json_decode(file_get_contents("php://input"));
  $request           =  new inventryservice();
  $sno               = $request->inventrylastid();

  $s_no = $sno['sno'] +1;

  $month = date("m");
  $year = date("y");
  $invoice = "DHS/".$month.$year."/".$s_no;


  $response          =  $request->createinventry($invoice,$userdata,$s_no);

  //print_r($response);die;


if($response)
   {
             $Result = array('status' => '1','data'=>$invoice ,'msg'=>'Create Daily Log ');
             echo json_encode($Result);
   }
   else
   {                     
          $Result = array('status' => '0','data'=>[] ,'msg'=>'Not Create Daily Log');
          echo json_encode($Result);
   } 
}





?>