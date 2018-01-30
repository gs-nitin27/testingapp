<?php
class tournament_service
{

 public function tournament_participants_list($tournament_id)
 {

    $query =mysql_query("SELECT * FROM `user` WHERE `userid` IN (SELECT `userid` FROM `user_tournaments` WHERE `usertournament` = $tournament_id)");
			if(mysql_num_rows($query)>0)
			{
				while ($row = mysql_fetch_assoc($query)) 
				{
					$date_1 		= new DateTime($row['dob']);
	                $date_2 		= new DateTime(date( 'd-m-Y' ));
	                $difference 	= $date_2->diff($date_1);
	                $year			= (string)$difference->y;
	                $row['age']		= $year;
	                $data[]  		= $row;
				}
			return $data;
			}
			else
			return 0;
 }
public function get_tournament_sports()
{
	$query = mysql_query("SELECT * FROM `gs_sports` WHERE `status_filter` = '1'");
	if(mysql_num_rows($query)>0)
	{
		  while ($row = mysql_fetch_assoc($query)) {
		    	    $category = json_decode($row['events_category']);
		    	    $category = $category->category;
                    //json_encode($category); 
		    	    $row['events_category'] =$category;
		    	    $rows[] = $row;

	    	}
		  return $rows;
	}
	else
	{
		return 0;
	}
}

public function apply_tournament($applydata)
 {
   foreach($applydata as $key => $value) {
   	   $id = $value->tournament_id.$value->category_code.$value->applicant_id;
        $data = json_encode($applydata);
       $query_data[] =  "('$id','$value->applicant_id','$value->tournament_id',CURDATE(),'$value->fee_amount','$data','$value->organiser_id','$value->category_code')";           
        //echo $query_data;
   }
$query_data = implode(',', $query_data);
$fields = "INSERT INTO `gs_tournament_application`(`id`, `applicant_id`, `tournament_id`, `date_applied`, `fee_amount`, `application_data`, `organiser_id`, `category_code`) VALUES".$query_data;
$query = mysql_query($fields);
if($query)
{
	return 1;
}else
{
	return 0;
}
}

public function get_participant_list($where)
{   
	$query = mysql_query("SELECT a.`id`, a.`applicant_id`, a.`tournament_id`, a.`date_applied`, a.`fee_amount`, `organiser_id`, a.`category_code` ,b.`userid`, b.`name`, b.`user_image` ,b.`gender`,b.`dob` FROM `gs_tournament_application` AS a RIGHT JOIN `user` AS b ON b.`userid` = a.`applicant_id`".$where."");

	if(mysql_num_rows($query)>0)
	{
    while ($row = mysql_fetch_assoc($query)) {
		$age_obj    = new connect_userservice();
        $age        = $age_obj->getage($row['dob']);
		$row['age'] = $age;
		$rows[]     = $row;
	}
    return $rows;
    }
    else
    {
    return 0;
    }
}


} // End Class





?>