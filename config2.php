<?php


header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

$con = mysql_connect('localhost','getsport_staging','7UNMH?n#VtGy');
if($con)
{
 $selected = mysql_select_db('getsport_staging') or die("Could not select databasename");
 
           header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		   $res = 1;
           echo json_encode($res); 
 }
else
{
echo "could not connect";
}
?> 