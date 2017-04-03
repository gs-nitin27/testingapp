<?php 

class GetListingService
{

public function getstate_listing($fwhere)
{
$query = mysql_query("SELECT DISTINCT `state` FROM `location`".$fwhere." GROUP BY `state` ORDER BY `state` ");
if(mysql_num_rows($query) > 0)
{

while($row = mysql_fetch_assoc($query))
{

$data[] = $row;

}
return $data;
}
else
return 0;
}


public function getcitylisting($fwhere)
{

$query = mysql_query("SELECT DISTINCT `city` FROM `location`".$fwhere." GROUP BY `city` ORDER BY `city` ");
if(mysql_num_rows($query) > 0)
{

while($row = mysql_fetch_assoc($query))
{

$data[] = $row;

}
return $data;
}
else
return 0;
}



public function getsportlisting()
{
$query = mysql_query("SELECT DISTINCT `sports` FROM `gs_sports`");
	if(mysql_num_rows($query) > 0)
	{
		while($row = mysql_fetch_assoc($query))
		{
		$data[] = $row;
		}
	return $data;
	}
	else
	{
	return 0;
	}
}





/*********************Drop Down for Profession***************************/

public function getProfession($prof_type)
{
if (isset($prof_type)) 
{
   $query = mysql_query("SELECT DISTINCT `id`,`profession`,`profession_type` FROM `gs_profession` where `profession_type` LIKE 'P'");
}
else
{
 $query = mysql_query("SELECT DISTINCT `id`,`profession`,`profession_type` FROM `gs_profession`");
}

	if(mysql_num_rows($query) > 0)
	{
		while($row = mysql_fetch_assoc($query))
		{
		$data[] = $row;
		}
	return $data;
	}
	else
	{
	return 0;
	}
}


/*********************Drop Down for City Listing***************************/

 public function Get_Location()
    {
      $query = mysql_query("SELECT `name` FROM `gs_city` where 1 GROUP BY `name` ORDER BY `name` ASC ");
      $row  = mysql_num_rows($query);
      if($row)
      {
            while ($row = mysql_fetch_assoc($query))
            {
              $data[] = $row;
            }
        return $data;
      }
      else
      {
         return 0;
      }
    }


/*********************Listing the Alert by the User***************************/


   public function getAlertListing($userid,$user_app)
    {
      $query = mysql_query("SELECT *FROM `gs_alerts` where `userid` = '$userid'  ORDER BY `date_alerted` DESC");
      $row  = mysql_num_rows($query);
      if($row)
      {
            while ($row = mysql_fetch_assoc($query))
            {
              $data[] = $row;
              }
              return $data;
     }
      else
      {
         return 0;
      }
    }


/*********************Listing The Age Group***************************/


 public function Age_Group()
 {
      $query = mysql_query("SELECT *FROM `gs_age_group` ");
      $row  = mysql_num_rows($query);
      if($row)
      {
            while ($row = mysql_fetch_assoc($query))
            {
              $data[] = $row;
            }
        return $data;
      }
      else
      {
         return 0;
      }
    }





} // End Class





?>