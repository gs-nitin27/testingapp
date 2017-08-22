<?php
$link = mysql_connect('getsporty.in', 'getsport', 'v#&;Z7&X*ZMS');
if (!$link) {
die('Could not connect: ' . mysql_error());
}
$selected = mysql_select_db('getsport_staging') or die("Could not select databasename");

//mysql_close($link);
?>