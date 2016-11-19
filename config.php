<?php
$con = mysql_connect('localhost','root','');

if($con)
{

if($_POST['token_id'] == 'dhs2016'){	
$selected = mysql_select_db('getsport_gs') or die("Could not select databasename");
 }
 else
 {
 echo "<h1>".'Unauthorized Access!'.'</h1>';die;
 }
}
else
{
echo "could not connect";
} 
?>

