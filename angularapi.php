
<?php
include('config1.php');
include('services/angularapi.php');
include('services/getListingService.php');


   

if($_REQUEST['act'] == 'contentangular')
{
    
   

	$req    =   new angularapi();
	$res= $req->getContentInfo();
    echo json_encode($res); 
}

else if($_REQUEST['act'] == 'angulartest')
{
	     $username       =  $_REQUEST['email'];
		 $password       =  md5($_REQUEST['password']);   
         $req    =   new angularapi();
         $res = $req->angulartest($username, $password);
         if($res)
         {
         $data = array("data" =>$res);		 
          echo json_encode($res);
          }
          else
          {
          $data = array("data" =>0);        
          echo json_encode($res);
          }

}


if($_REQUEST['act'] == 'contentangularlex')
{

     $userid      =  $_REQUEST['userid'];
	$req    =   new angularapi();
	$res= $req->getContent($userid);
    echo json_encode($res); 
}

else if($_REQUEST['act'] == 'createcontent')
{        


        $data =  json_decode(file_get_contents("php://input"));
        $item                     =  new stdClass();
        $item->id           =  '0';
        $item->userid       =  '11';
        $item->title        =  $data->title;
        $item->content      =  $data->content;
        $item->url          =  $data->url;
        $item->publish      =  "0";

        $req    =   new angularapi();
        $res = $req->createcontent($item);		 
        echo json_encode($res);
}

if($_REQUEST['act'] == "sportlisting")
{
$req = new GetListingService();
$res = $req->getsportlisting();
echo json_encode($res);
}



else if($_REQUEST['act'] == 'createevent')
{        
        $data =  json_decode(file_get_contents("php://input"));
        $item                     =  new stdClass();



        $item->id                        = 0;
        $item->userid                    = $data->userid;
        $item->name                      = $data->name;
        $item->description               = $data->description;
        $item->type                      = $data->entry_type;
        $item->sport                     = $data->sport;
        $item->address1                  = $data->address;
        $item->city                      = $data->city;
        $item->state                     = $data->state;
        $item->event_links               = $data->event_link;
        $item->start_date                = $data->start_date;
        $item->end_date                  = $data->end_date;
        $item->email_app_collection      = $data->organizer_email;
        $item->mobile                    = $data->mobile;
        $item->eligibility1              = $data->eligibility;
        $item->tandc1                    = $data->terms_cond;
        $item->ticket_detail             = $data->ticket;
        $item->image                     = $data->image;

        $req    =   new angularapi();
        $res = $req->createevent($item);     
        echo json_encode($res);
}

else if($_REQUEST['act'] == 'upload')
{   

$data =  file_get_contents("php://input");
$imageData = base64_decode($data);
$source = imagecreatefromstring($imageData);
$angle = 0;
$imageName = 'res_'.time().'.jpeg';
$rotate = imagerotate($source, $angle, 0); 
$imageSave = imagejpeg($rotate,$imageName,100);

$newpath = "/image/";
move_uploaded_file($imageSave,$newpath.$imageSave);

echo json_encode($imageName);

}
?>