<?php
class version_service
{
	public function cheack_version($version_key,$app_type)
	{
		$query = mysql_query("SELECT *FROM `gs_version` WHERE `version_key` > $version_key AND `app_type`='$app_type'");
		$num = mysql_num_rows($query);
  		if($num)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

} // End of Class


?>