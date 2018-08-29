<?php

Class AdvertisementService
{

public function get_advertisement()
{
$query = mysql_query("SELECT `id`, `title`, `image`, `module_data`, `date_created`, `start_date`, `end_date`, `active_status`, `app_type`, `duration` FROM `gs_ad_feature` WHERE CURDATE() BETWEEN `start_date` AND `end_date` AND `active_status` = '1'");

if(mysql_num_rows($query)>'0')
{
	
	$row = mysql_fetch_assoc($query);
	$row['module_data'] = json_decode($row['module_data']);
	return $row;
}else
{
	return 0;
}

}






}


 ?>