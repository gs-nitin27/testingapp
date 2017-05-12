<?php
class parentsUserService
{


public function  get_parent_child($parent_id)
{  
	$query  = mysql_query("SELECT * FROM `gs_association` WHERE `parent_id` ='$parent_id' ");
     $num = mysql_num_rows($query);
	if($num>0)
	{
		while ($row  = mysql_fetch_assoc($query)) 
		{
	  		$child_id  = $row['child_id'];
       		$data[]    = $this->get_child_data($child_id);
	   }
	
	return $data;
}
	else
	{
		return 0;
	}
}



public function varify_child($where)
{ 
  $query  = mysql_query("SELECT * FROM `user` WHERE ".$where."");
	$num = mysql_num_rows($query);
	if ($num>0)
	{
	 return 1;
	}
	else
	{
	 return 0;
	}
}


/******************************This Function are used to Add Child***********************/

public function add_child($decode_data)
{
   $parent_id =  $decode_data->userid;
   $query =mysql_query("INSERT INTO `user`(`name`,`userType`,`dob`,`gender`,`sport`) VALUES('$decode_data->name','104','$decode_data->dob','$decode_data->gender','$decode_data->sport')");
       if($query)
       {
             $child_id = mysql_insert_id();
             if($child_id!=NULL)
              {
              	 $data1 = $this->insert_association($parent_id,$child_id);
                 $data  = $this->get_child_data($child_id);
             
              }
              return $data['userid'];
        } 
        else
        {    
            return 0;
        }  
        
} 

public function get_child_data($child_id)
{   
	$query = mysql_query("SELECT  IFNull(`userid`,'') AS userid, IFNull(`name`,'') AS name , IFNull(`dob`,'') AS dob , IFNull(`gender`,'') AS gender
	 FROM `user` WHERE `userid`= $child_id ");
	$num = mysql_num_rows($query);
	 if ($num>0)
	 {
		$row = mysql_fetch_assoc($query);
		return $row;
	 }
	 else
	 {
		return 0;
	 }

} // End Function

public function insert_association($parent_id,$child_id)
{
	$unique_code = rand();
	$query = mysql_query("INSERT INTO `gs_association`(`parent_id`,`child_id`,`unique_code`) VALUES('$parent_id','$child_id','$unique_code')");
	 if ($query)
	 {
				return 1;
	 }
	 else
	 {
		return 0;
	 }

} // End Function

public function  activateAccount($parent_id,$child_id,$child_email)
{
	$code = $this->get_association_data($parent_id,$child_id);
	if($code != 0)
	{  $code = $code['unique_code'];
	   $update = mysql_query("UPDATE `user` SET `email` = '$child_email' , `unique_code` = '$code' WHERE `userid` = '$child_id'");
	   if($update)
	   {
	   	return $code;
	   }else{
	   	return 0;
	   }

	}
  

}
// End Function
public function get_association_data($parent_id,$child_id)
{
	$query  = mysql_query("SELECT * FROM `gs_association` WHERE `parent_id` ='$parent_id' AND `child_id`= '$child_id'");
	if(mysql_num_rows($query)> 0)
	{
		$row = mysql_fetch_assoc($query);
		return $row;
	}else
	    return "0";


}

public function child_account_verify($code,$email)
{

	$query = mysql_query("UPDATE `user` SET `unique_code` = '0' WHERE `email` = '$email' AND `unique_code` = '$code'");
	if($query)
	{
		return "1";
	}else
	{
		return "0";
	}

}

}  // End Class



?>