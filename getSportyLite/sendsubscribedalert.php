<?
include('../services/userdataservice.php');
include('../config1.php');


$query = mysql_query("SELECT gs.`id`,us.`userid`,us.`device_id`, gs.`search_para` , gs.`count` FROM `gs_subscribed` as gs LEFT JOIN `user` AS us ON gs.`userid` = us.`userid` WHERE gs.`Moudule` = '6' AND us.`device_id` <> ''");
$req = new userdataservice(); 
if(mysql_num_rows($query)> 0)
{
  while ($row = mysql_fetch_assoc($query)) {
  	     echo "SELECT * FROM `gs_resources` WHERE ".$row['search_para']."";
         $query1    = mysql_query("SELECT * FROM `gs_resources` WHERE ".$row['search_para']."");
         $new_count = mysql_num_rows($query1);
         $new_record = $new_count - $row['count'];
         $update    = mysql_query("UPDATE `gs_subscribed` SET `count` = '$new_count' WHERE `id` = ".$row['id']."");
        
        echo "------------------".$new_record;
        if($new_record > 0){
        $message1 = $new_record." New Update from getSporty for your subscription";
        $res = $req->sendLitePushNotificationToGCM($row['device_id'], $message);
        print_r($res);
          }


  }




} 

?>