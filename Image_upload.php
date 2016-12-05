<?php
include('config1.php');
include('services/userdataservice.php');
include('services/searchdataservice.php');


if($_SERVER['REQUEST_METHOD']=='POST')
{

if(isset($_FILES['pro_pic']))
{
	//echo "dfddff";
	$file     = $_FILES['pro_pic'];
    $location = 'gs_images/Prof_pic/';
    $name     = "gs_".$_POST['userid'].date("Y-m-d").time();
    $size     = '5' * '1024'*'1024';
}
else if(isset($_FILES['tourImage']))
{
	//echo "oh NO!!";
	$file     = $_FILES['tourImage'];
	$location = 'gs_images/Tournaments/';
	$name     = "Tournament".$_POST['userid'].date("Y-m-d").time();
	$size     = '10'*'1024'*'1024' ;
}
else if(isset($_FILES['eventImage']))
{
	//echo "oh NO!!";
	$file     = $_FILES['eventImage'];
	$location = 'gs_images/Events/';
    $name     = "Event".$_POST['userid'].date("Y-m-d").time();
    $size     = '10' * '1024'*'1024';
}

     
     $file_name = $file['name'];
	 $file_size = $file['size'];
	 $file_type = $file['type'];
	 $temp_name = $file['tmp_name'];
     

//die();
if($file_size < $size)
{
     //echo pathinfo($file_name, PATHINFO_EXTENSION);
	 $arr  = explode('.',$file_name);


     $file_name = $name.'.'.$arr[1];
     //$location = 'gs_images/';
  if (file_exists($location.$file_name)) 
	 {
               unlink($location.$file_name);

      }
	 $image = $location.$file_name;
     

	 move_uploaded_file($temp_name,$image);
	 echo "http://getsporty.in/".$image;
}
else
{
//echo $file_size."456677";
//echo $file_name."jhuohkjhjkh";
$size =  $size/('1024'*'1024');
echo "image upload size should not exceeds".$size."  MB";

}

}



 ?>