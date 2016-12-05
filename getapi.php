<?php
include('config1.php');
include('indeed.php');
include('userdataservice.php');
include('getListingService.php');
$client = new Indeed("2594776240068282");
$fwhere = "";
$req2 = new GetListingService();
$res2 = $req2->getstate_listing($fwhere);
print_r($res2);
if($res2 != 0)
{

$itr = sizeof($res2);
//echo $itr;die();
for($m=0;$m<$itr;$m++)
{
//$query = $res2[$m]['Searchquery'];
$location = $res2[$m]['state'];
//echo $query."rettr";
$params = array(
    "q" => "sports coach",
    "l" => $location,
    "co"=> "in",
    "sort"=>"date",
    "filter"=>1,
    "limit"=>"3",
    "userip" => "192.168.1.3",
    "useragent" => "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:44.0) Gecko/20100101 Firefox/44.0"
);
$results = $client->search($params);
print_r($results);//die();
$size = $results['totalResults'];
$job = array();
//if($size > '25')
//{

$inter = $size/'25';
for($i=0;$i<=$inter;$i++)
{
$start = $i*'25';
$params['start'] = $start;
$results = $client->search($params);
$job[] = $results;
} 
$res_size = sizeof($job); 
for($j=0;$j<$res_size;$j++)
{
$resd  =  $job[$j];
$resd1 =  $resd['results']; 
for($k=0;$k<24;$k++)
{

//*********||| S A M P L E     R E S P O N S E   F R O M     I N D E E D   A P I |||************//

//[jobtitle] => Dietician [company] => Rajiv Gandhi Cancer Institute & Research Centre [city] => New Delhi [state] => DL [country] => IN [formattedLocation] => New Delhi, Delhi [source] => CareerAge.com [date] => Thu, 07 Apr 2016 17:39:27 GMT [snippet] => Rajiv Gandhi Cancer Institute & Research Centre Rajiv Gandhi Cancer Institute & Research Centre, a NABH Accredited leading Cancer care establishment of North [url] => http://www.indeed.co.in/viewjob?jk=835d5aa0722a8310&qd=3VPTlKOBUxJ_HOwvbgc-7y3NOsyrTejEnCsxRm5rJEvPjPL3f-5zZc11uTpvvip_PDp-jkiBoFNQJ8Ql9tNpsxSQZQgZ4ZsiqKiDxQapWpw40X9RqMmoWy146cYiCabl&indpubnum=2594776240068282&atk=1afqnrmfjbqq297d [onmousedown] => indeed_clk(this, '9030'); [jobkey] => 835d5aa0722a8310 [sponsored] => [expired] => [formattedLocationFull] => New Delhi, Delhi [formattedRelativeTime] => 17 hours ago [noUniqueUrl] => 
//**********************************************************************************************//

$company     = $resd1[$k]['company'];
$title       = $resd1[$k]['jobtitle'];
$city        = $resd1[$k]['city'];
$Location    = $resd1[$k]['formattedLocationFull'];
$link        = $resd1[$k]['url'];
$key         = $resd1[$k]['jobkey'];
$state       = $resd1[$k]['state'];
$time        = $resd1[$k]['formattedRelativeTime'];
$description = strip_tags($resd1[$k]['snippet']);
$jobposted   = $resd1[$k]['date']; 
$description = strip_tags($description);
$data = array('company'=>$company,
	          'title'=>$title,
	          'city'=>$city,
	          'location'=>$Location,
	          'link'=>$link,
	          'state'=>$state,
	          'key'=>$key,
	          'time_posted'=>$time,
	          'description'=>$description,
	          'jobposted'=>$jobposted);

$req = new userdataservice();
$res = $req->InsertTempjobinfo($data);
//echo $res;

}






}	
//}

}

}
//echo json_encode($results);
 ?>