<?
include('../services/userdataservice.php');
include('../config1.php');


$query = mysql_query("SELECT gs.`id`,us.`userid`,us.`device_id`, gs.`search_para` , gs.`count` FROM `gs_subscribed` as gs LEFT JOIN `user` AS us ON gs.`userid` = us.`userid` WHERE us.`device_id` <> ''");
if(mysql_num_rows($query)> 0)
{
  while ($row = mysql_fetch_assoc($query)) {
         $query1    = mysql_query("SELECT * FROM ".$row['search_para']."");
         if(mysql_num_rows($query1)>0)
         {
           while($records = mysql_fetch_assoc($query1))
           {
            $subs_result[] = $records; 
           }


         }
         $row['data'] =$subs_result; 
         //$new_count = mysql_num_rows($query1);
        // echo "test";
        //  $new_record = $new_count - $row['count'];
        //  $update    = mysql_query("UPDATE `gs_subscribed` SET `count` = '$new_count' WHERE `id` = ".$row['id']."");
        
        // echo "------------------".$new_record;
       // if($new_record > 0){
        // echo $row['device_id'];
         //print_r($subs_result);
         $req = new userdataservice();
        $array_data = array('title'=> 'new updates from getsporty', 'message'=> $row['data'] , 'device_id' => $device_id , 'indicator' => 1); 
        $device_id = 'dwY5OcMY7zI:APA91bEcq_Vs-Ujw1EaOKHbGbloFoPZnE9g7H_ikshnK5UrvtvceufUVjn3j5n3bs7h5j0ezayf4a7zOiYnzV2-2QSZSHsGurBHBUxE14HbyxAKiY0EpTphJxBSkDqUZp2rXp0ZIWwGx';
        $message1 = $new_record." New Update from getSporty for your subscription";
        $res = $req->sendLitePushNotificationToGCM($device_id/*$row['device_id']*/, json_encode($array_data));
       // print_r($res);
         // }


  }




} 

?>