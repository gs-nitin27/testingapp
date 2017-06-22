<!doctype html>

<html lang="en" class="no-js">


<head>
    <meta charset="UTF-8">
    <title>getsporty</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="shortcut icon" href="favicon.png">
    
    <!-- Bootstrap 3.3.2 -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/js/rs-plugin/css/settings.css">

    <link rel="stylesheet" href="assets/css/styles.css">


    <script type="text/javascript" src="assets/js/modernizr.custom.32033.js"></script>
	
</head>
<body>
<?php
include('../config1.php');
$email     = urldecode($_REQUEST['email']);
$query  = mysql_query("SELECT * FROM `user` WHERE `email` = '$email'");
if(mysql_num_rows($query)==1)
      {      	
        mysql_query("UPDATE `user` SET `status` ='1' WHERE `email` = '$email'");
        
       }
    

?>


        <section id="getApp">
            <div class="container-fluid">
                <div class="section-heading inverse scrollpoint sp-effect3">
                   <!-- <h1>getsporty</h1>  -->
					    <a href="index.html">
                         <img src="assets/img/freeze/logo.png" alt="" class="logo">
                        </a>
                    <div class="divider"></div>
					<br></br>
					<br></br>
                    <p><b>Your email id has been verified. Please proceed to the APP for login</b></p>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="platforms">
                            <a href="index.html" class="btn btn-primary inverse scrollpoint sp-effect1">
                                <span>OK</span><br>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="assets/js/jquery-1.11.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/placeholdem.min.js"></script>
    <script src="assets/js/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
    <script src="assets/js/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script>
        $(document).ready(function() {
            appMaster.preLoader();
        });
    </script>

</body>
</html>