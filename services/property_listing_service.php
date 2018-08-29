<?php 
 Class Property_listing_service
 {
	
	public function getInstituteListing($a)
	{
		$list = mysql_query("SELECT * FROM `gs_institute` WHERE `college_name` LIKE '%$a%'");
		if(mysql_num_rows($list)>0)
		{
			while ($row = mysql_fetch_assoc($list)) {
				$rows[] = $row; 
			}
			return $rows;
		}else
		{
			return 0;
		}
	}



	public function addInstitutetoListing($a)
	{   
		$query  = mysql_query("INSERT INTO `gs_institute` (`college_name`, `address`, `location`, `email`, `image`, `contact_no`, `reg_no`, `date_created`) VALUES ('$a->inst_name','$a->inst_address','$a->inst_location','$a->inst_email','$a->inst_image','$a->inst_mobnumber','$a->inst_regno',CURDATE())");
		if($query)
		{   $id = mysql_insert_id();
			if($a->inst_image != '')
	       {
	       	include('userdataservice.php');
	       	$table = "gs_institute"; 
	       	//echo $table;die;
	       	$obj = new userdataservice();
	       	$obj_var = $obj->imageupload($a->inst_image,$id,$table);
	       }
			return 1;
		}else
		{
			return 0;
		}
	}

}
?>