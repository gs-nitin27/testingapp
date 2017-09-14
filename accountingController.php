<?php
include('cofig1.php');
include('accountingService.php');


if($_REQUEST['act'] == 'classlist')
{
   $userid = $_REQUEST['userid'];

   $req = new accountingService();
   $res = $req->classlist($userid);

   if($res)
   {
   	echo json_encode($res);
   }
   else
   {
   	echo json_encode($res);
   }
}



?>