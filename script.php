<?php

//include('config.php');
//include('config1.php');
// please change the IP Address and Password
// This Script is check the Local Server so Please change it


$con         = mysql_connect('127.0.0.1','root','');
$selected = mysql_select_db('getsport_staging') or die("Could not select databasename");
$selected = mysql_select_db('getsport_gs') or die("Could not select databasename");
mysql_query("INSERT INTO `test`.`gs_resources` (`userid`,`title`,`description`,`summary`,`url`,`date_created`,`token`,`image`,`keyword`,`topic_of_artical`,`sport`,`video_link`,`location`,`status`,`date_updated`) SELECT `userid`,`title`,`description`,`summary`,`url`,`date_created`,`token`,`image`,`keyword`,`topic_of_artical`,`sport`,`video_link`,`location`,`status`=0,`date_updated` FROM `getsport_staging`.`gs_resources` WHERE `date_created` = CURDATE() AND `status` = 1" );



?>