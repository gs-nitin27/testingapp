<?php
$con = mysql_connect('localhost','root','');
if($con)
{
$selected = mysql_select_db('getsport_gs')  or die("Could not select tabasename" );
}
else
{
echo "could not connect";
} 
?>