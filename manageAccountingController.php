<?php 
include('config.php');
include('services/searchdataservice.php');
include('services/userdataservice.php');
include('services/ManageAccountingService.php');

if($_POST['act'] == "getMonthWise_Earning")
{

$userid = urldecode($_POST['userid']);
$year   = urldecode($_POST['year']);

$req = new ManageAccountingService();
$res = $req->MonthsListing($userid, $year);
if($res != 0)
{
$data = array('data'=>$res , 'status'=>1);
echo json_encode($data);
}
else
{
$data = array('data'=>0 , 'status'=>0);
echo json_encode($data);

}


}


?>