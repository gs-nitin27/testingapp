<?php 

 class searchdataservice

  {

public function gensearch($fwhere, $page)
{

$query = mysql_query("SELECT  us.`userid` , us.`name` ,us.`sport`, us.`location`, us.`dob` , us.`user_image` , us.`prof_id` ,(SELECT ue.`Degree_course` FROM `gs_user_education` WHERE ue.`edu_id` = '1'  GROUP BY ue.`edu_id`) AS Degree_course ,(SELECT ue.`Degree_course` FROM `gs_user_education` WHERE ue.`edu_id` = '2' AND ue.`Degree_course` != '' GROUP BY ue.`edu_id`) AS sports_education_degree , (se.`tournament_level_for_best_rank`) AS sports_experience , us.`age_catered`FROM `user` AS us LEFT JOIN `gs_user_education` AS ue ON us.`userid` = ue.`userid` LEFT JOIN `gs_User_SportsExperience` AS se ON us.`userid` = se.`userid` 
	".$fwhere." GROUP BY us.`email`");
if($query)
{

$num = mysql_num_rows($query);
if($num > 0){

while($data = mysql_fetch_assoc($query))
{
if($page == "")
{
$row[] = $data;
}
else if($page == "fav")
{
 $row = $data;
 array_push($row['fav'], 1);
 $row['fav'] = "1";

}
else if($page == "flag")
{
 $row = $data;
 
}
}

return $row;
}
else
{

return 0;

      }

   }
	
}


// public function getusersportinfo($id)
// {

// 	//echo "SELECT a.`id` , a.`Degree_course` , ROUND((datediff(b.`month_ended`,b.`month_started`)/365), 1) as userexp FROM `gs_user_education` AS a LEFT JOIN  `gs_User_Experience` AS b ON a.`userid` = b.`userid` WHERE b.`userid` = $id ";

// $query = mysql_query("SELECT a.`id` , a.`Degree_course` , ROUND((datediff(b.`month_ended`,b.`month_started`)/365), 1) as userexp FROM `gs_user_education` AS a LEFT JOIN  `gs_User_Experience` AS b  ON a.`userid` = b.`userid` WHERE b.`userid` = $id ");

// If(mysql_num_rows($query) > 0)
// {

// while($row = mysql_fetch_assoc($query))
// {


// $data = $row; 


// }

// return $data;

// }

// }

public function getArea($location,$type)
{

$query = mysql_query("SELECT `address1` as AREA FROM `user` WHERE `location` = '$location' AND                      `address1` != '' AND `prof_id` = '$type'
	
			          UNION ALL

			          SELECT a.`venue` as AREA FROM `gs_coach_class` AS a LEFT JOIN `user` AS u ON 
		              a.`userid` = u.`userid`
			          WHERE a.`location` = '$location' AND u.`prof_id` = '$type'
                      GROUP BY AREA");


if(mysql_num_rows($query)>0)
{

while($row = mysql_fetch_assoc($query))
{

$data[] = $row;


}
//print_r($data);
return $data;

}
else
	return 0;

}

public function getsportlisting($location, $type)
 { 

$query = mysql_query("SELECT `sport` FROM `user` WHERE `location` = '$location'AND `prof_id` = '$type'");


if(mysql_num_rows($query)>0)
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


public function getsportcets($location,$type)
{

$query1 = mysql_query("SELECT CONCAT(ue.`Degree_course` ,',', ue.`specialization`) AS certs FROM `gs_user_education`  AS ue LEFT JOIN `user` AS u ON ue.`userid` = u.`userid` WHERE u.`location` = 'noida' AND u.`prof_id` = 'Coach' AND ue.`edu_id` = '2' AND CONCAT(ue.`Degree_course` ,',', ue.`specialization`) != '' GROUP BY ue.`Degree_course`");


if(mysql_num_rows($query1)>0)
{

while($row1 = mysql_fetch_assoc($query1))
{

$data1[] = $row1;


}
return  $data1;

}
else
return  0;
}

public function getlistingforsports($type)
{
	if($type == "event")
	{

    $table = "gs_eventinfo";

	}
	else if($type = "tournament")
	{

    $table  = "gs_tournament_info";


	}
	else if($type = "job")
	{

    $table  = "gs_jobInfo";


	}

$query = mysql_query("SELECT DISTINCT `sport` FROM `".$table."` WHERE `sport` != '' GROUP BY `sport`");
$rows = mysql_num_rows($query);
if($rows>0)
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

public function getlistforlocation($type)

{

if($type == "event")
	{

    $table = "gs_eventinfo";

	}
	else if($type = "tournament")
	{

    $table  = "gs_tournament_info";


	}
    else if($type = "job")
	{

    $table  = "gs_jobInfo";


	}
$query = mysql_query("SELECT DISTINCT `location` FROM `".$table."` WHERE `sport` != '' GROUP BY `location`");

if(mysql_num_rows($query)>0)
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


public function getlistforlevel($type)

{

if($type == "event")
	{

    $table = "gs_eventinfo";

	}
	else if($type = "tournament")
	{

    $table  = "gs_tournament_info";


	}

$query = mysql_query("SELECT DISTINCT `level` FROM `".$table."` WHERE `sport` != '' AND `level` != '' GROUP BY `level`");

$rows = mysql_num_rows($query);

if($rows > '0')
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


public function getType()
{

$query = mysql_query("SELECT DISTINCT `type` FROM `gs_eventinfo` WHERE `type` != ''");
{

$rows = mysql_num_rows($query);

if($rows > 0)

{

while($row = mysql_fetch_assoc($query))

$data[] = $row; 
return $data;
}
else 
{

return 0;

}

}


}

public function getlistingforage_group()
{

$query = mysql_query("SELECT DISTINCT `age_group` FROM `gs_tournament_info` WHERE `age_group` != '' GROUP BY `age_group`");

$rows = mysql_num_rows($query);

if($rows > '0')
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

public function getJobTitle()
{

$query = mysql_query("SELECT DISTINCT `title` FROM `gs_jobInfo` WHERE `title` != '' ");
$rows = mysql_num_rows($query);
if($rows>0)
{

while($row = mysql_fetch_assoc($query))
{

$data[] = $row;

}
return $data;

}
return 0;

}

public function getGender($type)
{

if($type == "job")
	{

    $table = "gs_jobInfo";

	}
	else
	{

    $table  = "gs_tournament_info";

    }


$query = mysql_query("SELECT DISTINCT `gender` FROM `".$table."` WHERE `gender` != '' ");
$rows = mysql_num_rows($query);
if($rows>0)
{

while($row = mysql_fetch_assoc($query))
{

$data[] = $row;

}
return $data;

}
return 0;


}


public function savealert($id ,$fwhere , $type, $size, $subs)

{

if($type == 'coach')
{

$type = '4';

} else if ($type == 'trainer')

{

$type = '5';

}


$param  = mysql_real_escape_string($fwhere);
$validate  = mysql_query("SELECT * FROM `gs_subscribed` WHERE `userid` = '$id' AND `Moudule` = '$type' AND `subscribe` = '$subs' ");
if(mysql_num_rows($validate)>0)
{

$query  = mysql_query("UPDATE `gs_subscribed` SET `subscribe`='$subs',`search_para` = '$param' , `Moudule` = '$type' , `count` = '$size' WHERE `userid` = '$id' AND `moudule` = '$type' AND `subscribe` = '$subs'");

}
else 
{

$query  = mysql_query("INSERT INTO `gs_subscribed`(`id`, `userid`, `search_para`, `Moudule`,`count` ,`subscribe`,`date`)VALUES ('','$id','$param','$type','$size','$subs',CURDATE())");
}


if($query)
{


	return 1;
}
else
{

return 0;

}
}





public function sendalert()
{

$query = mysql_query("SELECT * FROM `gs_subscribed`");
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
}


 ?>