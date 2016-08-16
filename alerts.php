<?php 
//$page = $_SERVER['PHP_SELF'];
 //$sec = "20";
 //header("Refresh: $sec; url=$page");
 //echo "Watch the page reload itself in 10 second!";
?>
<Html>
<head>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript">



// function reloadPage(){
//   window.location.reload();
// }
// var time  = 5*60000;
// setTimeout ( reloadPage, time);

//43200000

   
$.ajax({

    type: "POST",
    url:  "sendAlerts.php",
    data: "act=test",
    dataType: "text",
    success: function(result) {

    }
}); 
  
</script>
</head>
<body>
<input type="button" id="alert" value="Send Alerts" onclick="myFunction()"></input>
</body>
</html>