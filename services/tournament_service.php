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

/*[applicant_id] => 234
    [tournament_id] => 231
    [fee_amount] => 23444
    [organiser_id] => 32
    [event_schedule] => 2018-01-23
    [category_code] => BL1 */
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
} // End Class





?>