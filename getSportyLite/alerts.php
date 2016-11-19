<?
include('../services/userdataservice.php');
include('../config1.php');

$query = mysql_query("SELECT * FROM `gs_resources` ORDER BY `id` DESC LIMIT 0, 10");
$getToken = mysql_query("SELECT `token_id` FROM `get_token` WHERE 1 GROUP BY `token_id` ");
if(mysql_num_rows($getToken) > 0)
	{    
		$req = new userdataservice(); 
		$message = "New Update from getSporty";
		while($row = mysql_fetch_assoc($getToken)){
		$token = $row['token_id'];
        $res = $req->sendLitePushNotificationToGCM($token, $message);
		print_r($res);
		}
	}


?>