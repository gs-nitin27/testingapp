<?php
class parentsUserService
{


public function  get_parent_child($parent_id)
{  
	$query  = mysql_query("SELECT `child_id` FROM `gs_association` WHERE `parent_id` ='$parent_id' ");
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



public function varify_child($decode_data)
{ 
  $query  = mysql_query("SELECT * FROM `user` WHERE `name`= '$decode_data->name' AND `dob`= '$decode_data->dob'");
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
        
} // End Funtction 


// public function get_child_id$child_id)
// {
// 	$query = mysql_query("SELECT `userid`, IFNull(`userid`,'') AS userid
// 	 FROM `user` WHERE `userid`= $child_id ");
// 	$num = mysql_num_rows($query);
// 	 if ($num>0)
// 	 {
// 		$row = mysql_fetch_assoc($query);
// 		return $row['userid'];
// 	 }
// 	 else
// 	 {
// 		return 0;
// 	 }

// } // End Function

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
	$unicode = rand();
	$query = mysql_query("INSERT INTO `gs_association`(`parent_id`,`child_id`,`unicode`) VALUES('$parent_id','$child_id','$unicode')");
	 if ($query)
	 {
				return 1;
	 }
	 else
	 {
		return 0;
	 }

} // End Function


}  // End Class



?>