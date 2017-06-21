<?php
include('config1.php');
include('services/version_service.php');

  if($_REQUEST['act'] == 'app_version')
  { 
  $data              =   file_get_contents("php://input");
  $data1             =   json_decode(file_get_contents("php://input"));
  $version_key       =   $data1->version_key ;
  $app_type          =   $data1->app_type ;
  $request           =   new version_service();
  $response          =   $request->cheack_version($version_key,$app_type);
  if($response==1)
   {
        $sucess   = array('forceUpgrade'=>'true','recommondUpgrade'=>'true','stayonApp'=>"true"); 
          $Result = array('status' => '1','data'=>[$sucess] ,'msg'=>'Updated');
          echo json_encode($Result); 
   }
   else
   {     
          $fail   = array('forceUpgrade'=>'false','recommondUpgrade'=>'false','stayonApp'=>"false");
          $Result = array('status' => '0','data'=>[$fail],'msg'=>'No Updated');
          echo json_encode($Result); 
   } 
}

?>