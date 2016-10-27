<?
include('../services/userdataservice.php');
//include('liteservice.php');

$query = mysql_query("SELECT * FROM `gs_resources` ORDER BY `id` DESC LIMIT 0, 10");

if(mysql_num_rows($query) > 0)
{

$req = new userdataservice();
$res = $req->sendPushNotificationToGCM($registatoin_ids, $message)


}


?>