<?php
class visitor_cron_service 
{
 public function get_subscriber_data()
	{
      $query = mysql_query("SELECT `email`,`where`,`phone`,`module` ,`sport`FROM `visitor_subscribe` WHERE '1=1'");
      if(mysql_num_rows($query)>0)
      {
      	while ($row = mysql_fetch_assoc($query)) {
      		
      		if($row['module'] == '1')
      		{     $sport = $row['sport'];
                $where =  $row['where']." `sport` LIKE '%$sport%'";
                $job_data =  $this->getJobData($where);
      	        if($job_data != 0)
      	        {
                $job[$row['phone']]['data'][] = $this->getJobData($where);  //get job data to send inmail notification
      		    	$job[$row['phone']]['user_info'] = $row['email'];	
      	        }
      		}
      		if($row['module'] == '2')
      		{    $sport = $row['sport'];
               $where =  $row['where']."  `sport_name` LIKE '%$sport%'";
               $event_data =  $this->getEventData($where);
                if($event_data != 0)
                {
                $event[$row['phone']]['data'][] = $this->getEventData($where);   //get event data to send inmail notification
                $event[$row['phone']]['user_info'] = $row['email'];
                }
      		}if($row['module'] == '3')
      		{    $sport = $row['sport'];
               $where =  $row['where']."  `sport` LIKE '%$sport%'";
                $tournament_data =  $this->getTournamentData($where);
                if($tournament_data != 0)
                {
                $tournament[$row['phone']]['data'][] = $this->getTournamentData($where);  //get tournament data to send inmail notification
                $tournament[$row['phone']]['user_info'] = $row['email'];
                }
      		}if($row['module'] == '4')
      		{     $sport = $row['sport'];
                $where =  $row['where']."  `sport` LIKE '%$sport%'";
                $trial_data =  $this->getEventData($where);
                if($trial_data != 0)
                {

                $trial[$row['phone']]['data'][] = $this->getEventData($where);     //get trial data to send inmail notification
                $trial[$row['phone']]['user_info'] = $row['email'];
                }        		
          }if($row['module'] == '6')
      		{     $sport = $row['sport'];
                $where =  $row['where']."  `sport` LIKE '%$sport%'";
      			    $article_data =  $this->getArticleData($where);
                if( $article_data != 0)
                {
                $article[$row['phone']]['data'][] = $this->getArticleData($where); //get article data to send inmail notification
                $article[$row['phone']]['user_info'] = $row['email'];
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
    $query = mysql_query("SELECT `id`,`title`,`description`,`image` FROM `gs_jobInfo` WHERE ".$where." AND datediff(CURDATE(), `date_updated`) < 7");
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
    $query = mysql_query("SELECT  `id`,`title`,`description`,`image` FROM `gs_resources` WHERE ".$where."");
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
 {  
    $query = mysql_query("SELECT `id`,`name`,`description`,`image` FROM `gs_eventinfo` WHERE ".$where." AND datediff(CURDATE(), `end_date`) < 0");
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
  $query = mysql_query("SELECT `id`,`name`,`description`,`image` FROM `gs_tournament_info` WHERE ".$where." AND datediff(CURDATE(), `end_date`) < 0");
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

 

}
 ?>