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


} // End Class





?>