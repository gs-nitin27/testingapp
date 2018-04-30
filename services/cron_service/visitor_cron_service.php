<?php
class visitor_cron_service 
{
 public function get_subscriber_data()
	{
      $query = mysql_query("SELECT `email`,`where`,`phone`,`module` FROM `visitor_subscribe` WHERE '1=1'");
      if(mysql_num_rows($query)>0)
      {
      	while ($row = mysql_fetch_assoc($query)) {
      		
      		if($row['module'] == '1')
      		{   
      			$job[$row['phone']][] = $this->getJobData($row['where']);
      			if(!empty($job[$row['phone']][]))
      			{
      			array_push($job[$row['phone']][], $row);	
      			}
      		}
      		if($row['module'] == '2')
      		{
      			$event[$row['phone']][] = $this->getEventData($row['where']);

      		}if($row['module'] == '3')
      		{
      			$tournament[$row['phone']][] = $this->getTournamentData($row['where']);

      		}if($row['module'] == '4')
      		{
      			$trial[$row['phone']][] = $this->getEventData($row['where']);

      		}if($row['module'] == '6')
      		{
      			$article[$row['phone']][] = $this->getArticleData($row['where']);

      		}
      	}
      	$resp = array('job' =>@$job ,'event'=>@$event , 'tournament'=>@$tournament,'trial'=>@$trial,'article'=>@$article);
      	return $resp;
      }
	}
 public function getJobData($where)
 {
    $query = mysql_query("SELECT `id`,`title`,`description`,`image` FROM `gs_jobInfo` WHERE ".$where."");
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
    $query = mysql_query("SELECT `id`,`name`,`description`,`image` FROM `gs_eventinfo` WHERE ".$where."");
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
    $query = mysql_query("SELECT `id`,`name`,`description`,`image` FROM `gs_tournament_info` WHERE ".$where."");
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