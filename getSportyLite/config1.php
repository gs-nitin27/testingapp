<?php
$con = mysql_connect('localhost','getsport_gs',',WRI%yyw%;Z3');
if($con)
{
$selected = mysql_select_db('getsport_gs') or die("Could not select databasename");
 define('UPLOAD_DIR','../../getsportyportal/uploads/resources/');
 }else
 {
echo "could not connect";
} 



?>