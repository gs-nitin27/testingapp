<?
include('../services/userdataservice.php');
include('../config1.php');

$query = mysql_query("SELECT * FROM `gs_resources` WHERE `date_created` >= now() - INTERVAL 1 DAY AND `status` = 1");
$getToken = mysql_query("SELECT `token_id` FROM `get_token` WHERE 1 GROUP BY `token_id` ");
if(mysql_num_rows($query) > 0)
	{    $rows = mysql_num_rows($query);
		$req = new userdataservice(); 
		$message = $rows."new update from getSporty";
		while($row = mysql_fetch_assoc($getToken)){
		$token = $row['token_id'];
        $res = $req->sendLitePushNotificationToGCM($token, $message);
		print_r($res);
		}


	}


?>