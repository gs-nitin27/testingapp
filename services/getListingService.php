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

public function getProfession()
{
 $query = mysql_query("SELECT DISTINCT `id`,`profession` FROM `gs_profession`");
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


} // End Class





?>