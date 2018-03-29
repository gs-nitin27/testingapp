<?php

 class Website_service
 {

public function editFormalEducation($item_per_page,$position)
{

$results = mysql_query("SELECT id,name,description,image,sport_name,organizer_city,start_date,end_date,entry_start_date,entry_end_date, email_app_collection,type,location,organizer_name  FROM gs_eventinfo WHERE `publish` = '1' ORDER BY id DESC LIMIT $position, $item_per_page");

while ( $row = mysql_fetch_assoc($results)) {
              $event_title             = $row['name'];
              $event_summary           = $row['description'];
              $event_org_name          = $row['organizer_name'];
              $event_type              = $row['type'];
              $event_email             = $row['email_app_collection'];
              $event_location          = $row['location'];
              $event_url               = "event-detail/".$row['id'];
              $event_img_name          = $row['image'];
              $event_image_path        = "https://getsporty.in/portal/uploads/event/".$event_img_name;
  echo '<div class="col-lg-3 col-md-3"><div class=" hover-boxs"><div class="job-box"><img src="'.$event_image_path.'"></div><div class="slide-job-list"><h4>'.$event_title.'</h4><p> Type : <span> '.$event_type .'</span></p><p> Organizer Name : <span> '.$event_org_name .'</span></p><p> Location : <span>'.$event_location.'</span></p><p> Email : <span> '.$event_email.' </span></p><div class="read-c"><a href="'.$event_url .'">Read More</a> </div></div></div></div> ';
}


}