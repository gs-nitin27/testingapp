<?php
//include('config1.php');
include('services/userdataservice.php');
include('services/searchdataservice.php');
include('services/UserProfileService.php');
include('services/smsOtpService.php');
error_reporting(E_ERROR | E_PARSE);


if($_REQUEST['act'] == 'user_otp')
{
$phone = 8601807045;//$_REQUEST['phone'];
$otp_code = mt_rand(1000,10000);
echo $otp_code;//die;
$msg = "Welcome to getsporty merchandise app, Your OTP is".$otp_code;
$res = sendWay2SMS(8601807045, 9711230325, $phone, $msg);
    if (is_array($res))
        echo $res[0]['result'] ? 'true' : 'false';

}



 ?>