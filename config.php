<?php
$con = mysql_connect('localhost','root','mysql');
if($con)
{
$selected = mysql_select_db('getsport_gs')  or die("Could not select databasename" );
}
else
{
echo "could not connect";
} 
?>