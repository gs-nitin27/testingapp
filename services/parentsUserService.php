<?php
class parentsUserService
{
public function  get_parent_child($parent_id)
{  
	$query  = mysql_query("SELECT * FROM `gs_association` WHERE `parent_id` ='$parent_id' ");
     $num = mysql_num_rows($query);
	if($num>0)
	{    $i = 0;
		while ($row  = mysql_fetch_assoc($query)) 
		{    
	  		$child_id  = $row['child_id'];
	  		//echo $row['child_activate'];die;
       		$data[]    = $this->get_child_data($child_id);
       		$data[$i]['child_activate'] = $row['child_activate'];
            $i++;
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
              {  $unique_code = rand();
              	 $data1 = $this->insert_association($parent_id,$child_id,$unique_code);
                 $data  = $this->get_child_data($child_id);
             
              }
              return $data['userid'];
        } 
        else
        {    
            return 0;
        }  
        
} 


/******************************This Function for adding a parent***********************/
public function add_Parent($parent_email,$child_id)
{  $unique_code = rand();
   $query =mysql_query("INSERT INTO `user`(`email`,`userType`,`prof_id`,`prof_name`,`date_created`,`unique_code`) VALUES('$parent_email','104','6','Parent','CURDATE()','$unique_code')");
       if($query)
       {
             $parent_id = mysql_insert_id();
             if($parent_id!=NULL)
              {
              	 $data1 = $this->insert_association($parent_id,$child_id,$unique_code);
                           
              }
              return 1;//$data['userid'];
        } 
        else
        {    
            return 0;
        }  
        
} 

public function get_child_data($child_id)
{   
	$query = mysql_query("SELECT  IFNull(`userid`,'') AS userid, IFNull(`name`,'') AS name , IFNull(`dob`,'') AS dob , IFNull(`gender`,'') AS gender,IFNull(`sport`,'') AS sport, IFNull(`unique_code`,'') AS unique_code,IFNull(`user_image`,'') AS user_image	 FROM `user` WHERE `userid`= $child_id ");
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

public function insert_association($parent_id,$child_id,$unique_code)
{
	
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

public function  activateAccount($parent_id,$child_id,$child_email,$parent_mobile,$location)
{
	$code = $this->get_association_data($parent_id,$child_id);
	if($code != 0)
	{  $code = $code['unique_code'];
	   $update = mysql_query("UPDATE `user` SET `email` = '$child_email' , `unique_code` = '$code', `contact_no` ='$parent_mobile',`prof_id`='1',`prof_name`='Athletes',`location`='$location' WHERE `userid` = '$child_id'");
	   if($update)
	   { mysql_query("UPDATE `gs_association` SET `child_activate` = '1'  WHERE `child_id` = '$child_id'");
	   	return $code;
	   }
	   else
	   {
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
	{   mysql_query("UPDATE `gs_association` SET `child_activate` = '2'  WHERE `unique_code` = '$code'");
		return "1";
	}
	else
	{
		return "0";
	}

}




public function get_all_child($parent_id,$id,$module)
{
$query = mysql_query("SELECT `userType`,`userid`,`name`,`sport`,`dob` FROM user WHERE `userid` IN (SELECT `child_id`FROM `gs_association` WHERE `parent_id`='$parent_id')");
$num = mysql_num_rows($query);
if ($num>0)
{
	while($row = mysql_fetch_assoc($query))
	{
		$userid 			 = $row['userid'];
		$dob	 			 = $row['dob'];
		$query1 			 = mysql_query("SELECT get_age('$dob', NOW()) AS age ");
		$age    			 = mysql_fetch_assoc($query1);
		$row['age']  		 = $age['age'] ;
		$apply_status 		 = $this->cheack_apply_status($userid,$id,$module);
		$row['apply_status'] = $apply_status;
		$data[]  			 = $row;
	}
       	return $data;
}
else
{
	return 0;
}

}  // End of Function


public function cheack_apply_status($userid,$id,$module)
{
         if($module=='1')
          {
         	$table	=	"`user_jobs` WHERE `userid` = $userid AND `userjob` = $id ";
          }
		  if($module=='2')
          {
          	$table 	=	"`user_events` WHERE `userid` = $userid AND `userevent` = $id ";
          }
  
          if($module=='3')
          {
         	$table 	= 	"`user_tournaments` WHERE `userid` = $userid AND `usertournament` = $id ";
          }
          
	$query = mysql_query("SELECT `status` FROM $table ");
	$num = mysql_num_rows($query);
	if ($num>0)
	{
		$row = mysql_fetch_assoc($query);
		return $row['status'];
	}
	else
	{
		return 0;
	}

}


// 2 = Event 3 = Tournament

public function child_apply($child_ids,$res_id,$module,$parent_name,$parent_email)
{
if(!empty($child_ids) && !empty($module) )
{
$total_child_id = (explode(",",$child_ids));
 $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
 $entry_passcode='';
   for ($i = 0; $i < 20; $i++)
   {
      $n    = rand(0, strlen($alphabet)-1);
      $entry_passcode .= $alphabet[$n];
   }  
foreach ($total_child_id as $key => $userid)
{
              $record[] = "('0','$userid','$res_id',CURDATE(),'1','$entry_passcode')";
}
$values  = (implode(",",$record));
			  $where    =  "`id` = $res_id";
              $object   = new  userdataservice();
              $row      =  $object->searchEvent($where);
              $req      =  new generate_code();
              $qur      =  $req->qr_code($entry_passcode,$parent_name,$parent_email,$row);
if ($module==2) 
{
$query = mysql_query("INSERT INTO `user_events`(`id`, `userid`,`userevent`,`date`,`status`,`entry_passcode`) VALUES $values");
}

if($module==3) 
{
	$query = mysql_query("INSERT INTO `user_tournaments`(`id`, `userid`, `usertournament`, `date`,`status`,`entry_passcode`)  VALUES $values");
}

return 1;
}
else
{
	return 0;
}

}  // End of Function


}  // End Class
?>