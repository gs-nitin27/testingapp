<?
include('../services/userdataservice.php');
include('../config1.php');


$query = mysql_query("SELECT gs.`id`,us.`userid`,us.`device_id`, gs.`search_para`,gs.`Moudule`,gs.`para_json`, gs.`count` FROM `gs_subscribed` as gs LEFT JOIN `user` AS us ON gs.`userid` = us.`userid` WHERE /*gs.`Moudule` = '6' AND */us.`device_id` <> ''");
$req = new userdataservice(); 
if(mysql_num_rows($query)> 0)
{
  while ($row = mysql_fetch_assoc($query)) {
           if($row['Moudule'] == '1')
          {
            $table = 'gs_jobInfo';
            $topic = 'Job';
          }else if($row['Moudule'] == '2')
          {
            $table = 'gs_eventinfo';
            $topic = 'Event';
          }
          else if($row['Moudule'] == '3')
          {
            $table = 'gs_tournament_info';
            $topic = 'Tournament';
          }else
          {
            $table = 'gs_resources';
            $topic = 'Article';
          }
          $criteria = json_decode($row['para_json']);
         // echo "SELECT `id`,`image` FROM `".$table."` WHERE ".$row['search_para']."";
         $query1    = mysql_query("SELECT `id`,`image` FROM `".$table."` WHERE ".$row['search_para']."");
         $new_count = mysql_num_rows($query1);
         $new_record = $new_count - $row['count'];
         $update    = mysql_query("UPDATE `gs_subscribed` SET `count` = '$new_count' WHERE `id` = ".$row['id']."");
         if($criteria->sport !== '')
          {
            $sport = $criteria->sport; 
            $tilte = $topic." updates on ".$criteria->sport."";
            $message = "Browse and get more";
          }else
          {
            $message = "New updates";
          }
        if($new_record > 0){
        /*if($row['userid']=='100086'){*/
                  $message1 = array('title'=> $tilte , 'message'=>$message ,'sport'=>$sport,'location'=>$criteria->location, 'device_id' => $row['device_id'] , 'type'=>$row['Moudule'] ,'indicator' => 12);
               $res = $req->sendLitePushNotificationToGCM($row['device_id'], $message1);
          }
  }
} 

?>