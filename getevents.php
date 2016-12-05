
<?php
include('config1.php');
include('services/userdataservice.php');
include('services/getListingService.php');
// Get cURL resource
$ch = curl_init();

// Set url

$fields = array(
	'category' => 'sports'
	
);

//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

//open connection


//set the url, number of POST vars, POST data

curl_setopt($ch, CURLOPT_URL, 'https://api.allevents.in/events/list/?city=New%20Delhi&state=Delhi&country=India&category=sports');
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

// Set method
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');

// Set options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Set headers
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Ocp-Apim-Subscription-Key: db5444392ce148eb9b368ad5991653f9","Content-length:0"]);

// Send the request & save response to $resp
$resp = curl_exec($ch);

if(!$resp) {
  die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
} else {
  //echo "Response HTTP Status Code : " . curl_getinfo($ch, CURLINFO_HTTP_CODE);
  //echo "\nResponse HTTP Body : " . $resp;
}

// Close request to clear up some resources
curl_close($ch);
$results = json_decode($resp,true);
$size =sizeof($results['data']);
//print_r($results);
//echo $size;
for($i = 0;$i<$size;$i++)
{
$event_id   = $results['data'][$i]['event_id'];	
$event_name = $results['data'][$i]['eventname'];
$start_time = $results['data'][$i]['start_time'];
$end_time   = $results['data'][$i]['end_time'];
$city       = $results['data'][$i]['venue']['city'];
$state      = $results['data'][$i]['venue']['state'];
$country    = $results['data'][$i]['venue']['country'];
$address    = $results['data'][$i]['venue']['full_address'];
$link       = $results['data'][$i]['share_url'];
$image      = $results['data'][$i]['banner_url'];

$data = array(

'event_id'    => $event_id,
'event_name'  => $event_name,
'start_time'  => $start_time,
'end_time'    => $end_time,
'city'        => $city,
'state'       => $state,
'country'     => $country,
'address'     => $address,
'link'        => $link,
'image'       => $image 

	);

$req = new userdataservice();
$res = $req->updaterecords($data);
if($res == '1')
{

echo "record updated";

}
else

{

echo "record not updated";

}
//print_r($results['data'][0]);die();


//echo $event_name;

//(Array ( [event_id] => 477936502417448 [eventname] => Taekwondo: NATIONAL REFEREE SEMINAR AND REFRESHER COURSE- DELHI [thumb_url] => https://cdn-az.allevents.in/banners/9e07f775175b07e41a8b199ef96c1bb4 [thumb_url_large] => https://cdn-az.allevents.in/banners/9e07f775175b07e41a8b199ef96c1bb4 [start_time] => 1460714400 [start_time_display] => Fri Apr 15 2016 at 10:00 am [end_time] => 1460714400 [end_time_display] => Fri Apr 15 2016 at 10:00 am [location] => 44 AMAR COMPLEX BHAGWATI GARDEN UTTAM NAGAR, NEAR DWARKA MOD METRO STATION, NEW DELHI [venue] => Array ( [street] => [city] => New Delhi [state] => [country] => [latitude] => 0 [longitude] => 0 [full_address] => 44 AMAR COMPLEX BHAGWATI GARDEN UTTAM NAGAR, NEAR DWARKA MOD METRO STATION, NEW DELHI ) [label] => Today [featured] => 0 [event_url] => http://allevents.in/new%20delhi/taekwondo-national-referee-seminar-and-refresher-course-delhi/477936502417448 [share_url] => http://allevents.in/new%20delhi/477936502417448 [banner_url] => https://cdn-az.allevents.in/banners/587292960c4bc650b5a43816e4815adf ) )

}




?>
