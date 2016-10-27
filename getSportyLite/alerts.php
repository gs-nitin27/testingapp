<?
include('../services/userdataservice.php');
include('liteservice.php');

if($_REQUEST['act'] == 'get_token')
{
$token = $_REQUEST['token'];
$req = new liteservice();
$res = $req->saveToken($token);



}


?>