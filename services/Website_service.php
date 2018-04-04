<?php

class Website_service
{
  public function get_event_data($item_per_page,$position)
  {
    $event = mysql_query("SELECT id,name,description,image,sport_name,organizer_city,start_date,end_date,entry_start_date,entry_end_date, email_app_collection,type,location,organizer_name  FROM gs_eventinfo WHERE `publish` = '1' ORDER BY id DESC LIMIT $position, $item_per_page");
    while($row = mysql_fetch_assoc($event)){
                  $event_title             = $row['name'];
                  $event_summary           = $row['description'];
                  $event_org_name          = $row['organizer_name'];
                  $event_type              = $row['type'];
                  $event_email             = $row['email_app_collection'];
                  $event_location          = $row['location'];
                  $event_url               = "event-detail/".$row['id'];
                  $e_start_date            = date('d F', strtotime($row['start_date']));
                  $e_end_date              = date('d F, Y', strtotime($row['end_date']));
                  $e_entry_start_date      = date('d F', strtotime($row['entry_start_date']));
                  $e_entry_end_date        = date('d F, Y',strtotime($row['entry_end_date']));
                  $event_img_name          = $row['image'];
                  $event_image_path        = "https://getsporty.in/portal/uploads/event/".$event_img_name;
      echo '<div class="col-lg-3 col-md-3"><div class=" hover-boxs"><div class="job-box"><img src="'.$event_image_path.'"></div><div class="slide-job-list"><h4>'.$event_title.'</h4><p> Type : <span> '.$event_type .'</span></p><p> Start : <span> '.$e_start_date.' - '.$e_end_date.'</span></p><p> Entry : <span> '.$e_entry_start_date.' - '.$e_entry_end_date.' </span></p><p> Location : <span>'.$event_location.'</span></p><div class="read-c"><a href="'.$event_url .'">Read More</a> </div></div></div></div> ';
    }
  }


public function get_job_data($item_per_page,$position)
  {
    $job = mysql_query("SELECT id,title,description,image,organisation_name,org_city,date_updated,date_created  FROM gs_jobInfo WHERE `publish` = '1' ORDER BY id DESC LIMIT $position, $item_per_page");
      while ( $row = mysql_fetch_assoc($job)){

                    $J_id                =   $row['id'];
                    $J_title             =  $row['title'];
                    $J_description       =  $row['description'];
                    $J_org_name          =  $row['organisation_name'];
                    $J_org_city          =  $row['org_city'];
                    $date_updated        =  $row['date_updated'];
                    $J_url               =  "job-detail/".$row['id'];
                    $J_img               =  $row['image'];
                    $J_image_path        =  "https://getsporty.in/portal/uploads/job/".$J_img;
                    $datetime1 = new DateTime();
                    $datetime2 = new DateTime($date_updated);
                    $interval = $datetime1->diff($datetime2);
                    $J_day = $interval->format(' %a Days ago ');

       echo '<div class="col-lg-3 col-md-3"><div class=" hover-boxs"><div class="job-box"><img src="'.$J_image_path.'" alt="img"></div><div class="slide-job-list"><h4>'.$J_title.'</h4><p> Location : <span>'.$J_location.' </span></p><p> Posted : <span> '.$J_day.' </span></p><p> Organisation Name : <span> '.$job_org_name.' </span></p><div class="read-c"><a href="'.$J_url.'">Read More</a> </div></div></div></div> ';


     
      }
  }



  public function get_tournament_data($item_per_page,$position)
  {
    $tournament = mysql_query("SELECT id,name,image,start_date,end_date,event_entry_date,event_end_date, org_city,sport FROM gs_tournament_info WHERE `publish` = '1' ORDER BY id DESC LIMIT $position, $item_per_page");
    while($row = mysql_fetch_assoc($tournament)){

                  $T_id                = $row['id'];
                  $T_title             = $row['name'];
                  $T_img               = $row['image'];
                  $T_start_date        = date('d F', strtotime($row['start_date']));
                  $T_end_date          = date('d F, Y', strtotime($row['end_date']));
                  $T_event_entry_date  = date('d F', strtotime($row['event_entry_date']));
                  $T_event_end_date    = date('d F, Y', strtotime($row['event_end_date']));
                  $T_org_city          = $row['org_city'];
                  $T_sport             = $row['sport'];
                  $T_url               = "tournament-detail/".$T_id;
                  $T_image_path        = "https://getsporty.in/portal/uploads/tournament/".$T_img;
      if(!empty($T_img))
      {
echo '<div class="col-lg-3 col-md-3"><div class=" hover-boxs"> <div class="job-box"> <img src="'.$T_image_path.'" alt="img"> </div><div class="slide-job-list"><h4>'.$T_title.'</h4><p> Location : <span> '.$T_org_city.'</span></p><p> Start : <span> '.$T_start_date.' - '.$T_end_date.'</span></p><p> Entry : <span> '.$T_event_entry_date.' - '.$T_event_end_date.' </span></p> <p> Sport : <span>Lawn Tennis </span></p><div class="read-c"> <a href="'.$T_url.'">Read More</a> </div></div> </div> </div>    ';  
}


      } // End of for Loop


  }




  public function get_article_data($item_per_page,$position)
  {
    $resources = mysql_query("SELECT id,title,summary,image,token,url,video_link,token  FROM `gs_resources` WHERE `status` = '1' ORDER BY id DESC LIMIT $position, $item_per_page");
    while ( $row = mysql_fetch_assoc($resources)){
                  $A_id           = $row['id'];
                  $A_title        = $row['title'];
                  $A_img          = $row['image'];

                  $A_summary      = substr($row['summary'],0,200) ;
                  $A_token        = $row['token'];
                  $A_url          = $row['url'];
                  $A_video_link   = $row['video_link'];
                  $A_url          = "article-detail/".$row['id'];
                  $A_image_path        = "https://getsporty.in/portal/uploads/resources/".$A_img;
                  $A_summary      = substr($row['summary'],0,200) ;
                  $A_token        = $row['token'];
                  $A_url          = $row['url'];
                  $A_video_link   = $row['video_link'];
                  $res_url        = "article-detail/".$row['id'];
                  $A_image_path   = "https://getsporty.in/portal/uploads/resources/".$A_img;

            if($A_token==0)
            {
                          $res_url     = $A_url;
            }
            if($A_token==1 || $A_token==3) 
            {
                $res_url               = "article-detail/".$A_id ;

            }
            if ($A_token== 2) 
            {
          $video_url     = "https://www.youtube.com/embed/".$A_video_link;
          $A_video = '
          <div  data-toggle="modal" data-target="#myModa'.$A_video_link.'">
                   <img src="img/play-icon.svg" width= "50px">
              </div>
               <div id="myModa'.$A_video_link.'" class="modal fade" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                    <div class="modal-content">
                       <div class="modal-body">
                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <iframe width="100%" height="315" src="'.$video_url.'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                         </div>
                    </div>
                </div>
            </div>';

            }
         


 echo ' <div class="col-lg-3 col-md-3">  <div class=" hover-boxs"> <div class="job-box"> <img src="'.$A_image_path.'" alt="img">     </div>     <div class="slide-job-list">     <h4>'.$A_title.'</h4> <p><span> '.$A_summary.'</span></p>  '.$A_video.' <div class="read-c"><a href="'.$res_url.'">Read More</a> </div>    </div>                            </div>                </div> ';


    }
  }





  

} // End of Class