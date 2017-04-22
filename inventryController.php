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
if($response)
   {
             $Result = array('status' => '1','data'=>$invoice ,'msg'=>'fee payment is done ');
             echo json_encode($Result);
   }
   else
   {                     
          $Result = array('status' => '0','data'=>[] ,'msg'=>'Not payment');
          echo json_encode($Result);
   } 
}



/*************************************************************************************/

elseif($_REQUEST['act'] == 'invoice_history')
{
    $userid         =  urldecode($_REQUEST['userid']);
    $request         =  new inventryservice();
    if (empty($userid))
    {
      $Result = array('status' => '0','data'=>[] ,'msg'=>'userid is not find');
              echo json_encode($Result);
    }
    else
    {
     $response        =  $request->invoicehistory($userid);
     if($response)
       {
                 $Result = array('status' => '1','data'=>$response,'msg'=>'invoice history ');
                 echo json_encode($Result);
       }
       else
       {                     
              $Result = array('status' => '0','data'=>[] ,'msg'=>'No invoice history');
              echo json_encode($Result);
       } 
     }

}







?>