<?php
Class visitorService
{
	
public function visitor_message($user_info)
{
$data = json_encode($user_info);
$query = mysql_query("INSERT INTO `gs_visitor`(`email`, `date`, `user_type`, `user_info`) VALUES ('$user_info->email',CURDATE(),'$user_info->medium','$data')");
if($query)
return "1";
else
return "0";

}


} 

 ?>