<?php
class visitor_cron_service 
{
 public function get_subscriber_data()
	{
      $query = mysql_query("SELECT `email`,`where`,`phone`,`module` ,`sport`,`unique_code`,`sent_items`FROM `visitor_subscribe` WHERE '1=1'");
      if(mysql_num_rows($query)>0)
      {
      	while ($row = mysql_fetch_assoc($query)) {
      	
          $row['sent_items'];
      		if($row['sent_items'] != '')
          {
            $sent_items = $row['sent_items'];   
          }else
          {
            $sent_items = "'"."'";
          }
          if($row['module'] == '1')
      		{     $sport = $row['sport'];
                $where = $row['where']." `sport` LIKE '%$sport%' AND `id` NOT IN ($sent_items)";
                $job_data =  $this->getJobData($where);
      	        if($job_data != 0)
      	        {
                $job[$row['phone']]['data'][] = $job_data;  //get job data to send inmail notification
      		    	$job[$row['phone']]['user_info'] = $row['email'];
                $job[$row['phone']]['unique_code'] = $row['unique_code'];	
      	        }
      		}
      		if($row['module'] == '2')
      		{    $sport = $row['sport'];
               $where =  $row['where']."  `sport_name` LIKE '%$sport%' AND `id` NOT IN ($sent_items)";
               $event_data =  $this->getEventData($where);
                if($event_data != 0)
                {
                $event[$row['phone']]['data'][] = $event_data;   //get event data to send inmail notification
                $event[$row['phone']]['user_info'] = $row['email'];
                $event[$row['phone']]['unique_code'] = $row['unique_code'];
                }
      		}if($row['module'] == '3')
      		{    $sport = $row['sport'];
               $where =  $row['where']."  `sport` LIKE '%$sport%' AND `id` NOT IN ('$sent_items')";
                $tournament_data =  $this->getTournamentData($where);
                if($tournament_data != 0)
                {
                $tournament[$row['phone']]['data'][] =  $tournament_data;  //get tournament data to send inmail notification
                $tournament[$row['phone']]['user_info'] = $row['email'];
                $tournament[$row['phone']]['unique_code'] = $row['unique_code'];
                }
      		}if($row['module'] == '4')
      		{     $sport = $row['sport'];
                $where =  $row['where']."  `sport` LIKE '%$sport%' AND `id` NOT IN ('$sent_items')";
                $trial_data =  $this->getEventData($where);
                if($trial_data != 0)
                {

                $trial[$row['phone']]['data'][] = $trial_data;     //get trial data to send inmail notification
                $trial[$row['phone']]['user_info'] = $row['email'];
                $trial[$row['phone']]['unique_code'] = $row['unique_code'];
                }        		
          }if($row['module'] == '6')
      		{     $sport = $row['sport'];
                $where =  $row['where']."  `sport` LIKE '%$sport%' AND `id` NOT IN ('$sent_items')";
      			    $article_data =  $this->getArticleData($where);
                if( $article_data != 0)
                {
                $article[$row['phone']]['data'][] = $article_data; //get article data to send inmail notification
                $article[$row['phone']]['user_info'] = $row['email'];
                $article[$row['phone']]['unique_code'] = $row['unique_code'];
      		      }
          }
      		
      	}
      	$resp = array('1' =>@$job ,'2'=>@$event , '3'=>@$tournament,'4'=>@$trial,'6'=>@$article);
      	return $resp;
      }else
      {
      	return 0;
      }
	}
 public function getJobData($where)
 {  
  $query = mysql_query("SELECT `id`,`title`,`description`,`image` FROM `gs_jobInfo` WHERE ".$where." AND datediff(CURDATE(), `date_updated`) < 30 ");
    if(mysql_num_rows($query)>0)
    {
     while ($row = mysql_fetch_assoc($query)) {
      	$rows[] = $row;
    }
     return $rows;
    }
    else
    {
     return 0;
    }
 }

 public function getArticleData($where)
 {
    $query = mysql_query("SELECT  `id`,`title`,`description`,`image`,`summary` FROM `gs_resources` WHERE ".$where."");
    if(mysql_num_rows($query)>0)
    {
     while ($row = mysql_fetch_assoc($query)) {
      	$rows[] = $row;
    }
     return $rows;
    }
    else
    {
     return 0;
    }
 }

 public function getEventData($where)
 { //echo "SELECT `id`,`name`,`description`,`image` FROM `gs_eventinfo` WHERE ".$where." AND datediff(CURDATE(), `end_date`) < 0 AND `publish` = '1' ";die;
    $query = mysql_query("SELECT `id`,`name`,`description`,`image` FROM `gs_eventinfo` WHERE ".$where." AND datediff(CURDATE(), `end_date`) < 0 AND `publish` = '1' ");
    if(mysql_num_rows($query)>0)
    {
     while ($row = mysql_fetch_assoc($query)) {
      	$rows[] = $row;
    }
     return $rows;
    }
    else
    {
     return 0;
    }
 }

public function getTournamentData($where)
 {
  $query = mysql_query("SELECT `id`,`name`,`description`,`image` FROM `gs_tournament_info` WHERE ".$where." AND datediff(CURDATE(), `end_date`) < 0 ");
    if(mysql_num_rows($query)>0)
    {
     while ($row = mysql_fetch_assoc($query)) {
      	$rows[] = $row;
    }
     return $rows;
    }
    else
    {
     return 0;
    }
 }

 public function update_sent_item($item,$key)
 {
//echo "UPDATE `visitor_subscribe` SET `sent_items`  = '$item' WHERE `unique_code` = '$key' ";die;
 $query = mysql_query("UPDATE `visitor_subscribe` SET `sent_items`  = '$item' WHERE `unique_code` = '$key' ");
 if($query)
 {
  return 1;
 }
else
{
  return 0;
}
}

}
 ?>