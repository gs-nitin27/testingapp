<?php 
class angularapi 
{
public function getContentInfo()
{
   $query = mysql_query("SELECT * FROM `cms_content`");
   $row = mysql_num_rows($query);
   if($row)
   {
     while($data = mysql_fetch_assoc($query))
      {
      $result[] = $data;
      }
       return $result;
   }  	
}

public function angulartest($username,$password)
{
	
          $query = mysql_query("SELECT  * FROM `user` WHERE `email` = '$username' AND `password` = '$password'");
          if($query)
          {
            while($row = mysql_fetch_assoc($query))
            {   
               //$data1= $row; 
			         $data['customer'] = $row['name'];
               $data['customerId'] = $row['userType'];
               $data['lxDrivePath'] =  $row['name'];
               $data['name']     =  $row['name'];
               $data['password'] =$row['password'];
               $data['userId'] = $row['userid'];
               $data['userName'] =$row['email'];
               $data['imageUrl'] =$row['name'];
			   
			   
               return $data;
             }
           }
            else
            {
               return 0;
            }	
	
	
	
}

public function getContent($userid)
{
   $query = mysql_query("SELECT * FROM `cms_content` WHERE `userid` = '$userid'");
   $row = mysql_num_rows($query);
   if($row)
   {
     while($data = mysql_fetch_assoc($query))
      {
         $result[] = $data;

      }
       return $result;
   }    
}


public function createcontent($item)
{
   // print_r($item);die;
   $insert = mysql_query("INSERT INTO `cms_content`(`id`,`userid`,`title`,`content`,`url`,`date_created`,`date_updated`,`publish`) VALUES('$item->id','$item->userid','$item->title','$item->content','$item->url',CURDATE(),CURDATE(),'$item->publish')");
   if($insert)
   {
    return mysql_insert_id();
   } 
   else
   {
    return 0;
   }


}

public function createevent($item)
{
   // print_r($item);die;
   $insert = mysql_query("INSERT INTO `gs_eventinfo`(`id`, `userid`,`name`, `type`, `address_1`,`location`,`state` ,`description`,`sport_name`,`eligibility1`, `terms_cond1`,`mobile` ,`event_links`, `start_date`, `end_date`, `email_app_collection`,`dateCreated`,`ticket_detail`,`image`) VALUES ('$item->id','$item->userid','$item->name', '$item->type','$item->address1','$item->city','$item->state','$item->description','$item->sport','$item->eligibility1','$item->tandc1','$item->mobile','$item->event_links',STR_TO_DATE('$item->start_date', '%m/%d/%Y'),STR_TO_DATE('$item->end_date','%m/%d/%Y'),'$item->email_app_collection',CURDATE(),'$item->ticket_detail','$item->image')");
   if($insert)
   {
    return mysql_insert_id();
   } 
   else
   {
    return 0;
   }
}
}

?>