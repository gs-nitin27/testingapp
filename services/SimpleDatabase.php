<?php
 class SimpleDatabase{

public function create_connection(){

$servername = "localhost";
$username = "root";
$password = "root";
$db = "get_sporty";

$vConnection = new mysqli($servername, $username, $password, $db);

// Check connection
if ($vConnection->connect_error) {
    die("Connection failed: " . $vConnection->connect_error);
}}}
?>