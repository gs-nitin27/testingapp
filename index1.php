
<Html>
<head>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript">
	
// var university = "";
// var data = '{"class_name":"Test Class3","start_date":"2016-02-15","end_date":"2016-02-16","user_id":"16","start_time":"09 am"}';
$.ajax({

    type: "POST",
    url: "create_database.php",

  //data:"act=apply&user_id=177&employerid=&id=197&type=1",
data:"act=getappliedjobs&user_id=176&id=133",



   // url: "useralertcontroller.php",
//data: "act=select_applicant&applicant_id=84&employer_id=104&job_title=PHPdeveloper&job_id=1000&employer_name=ram&salary=5090&joining_date=12-jan-2014&other_deatil=hi how are you&status=2",
 // data: "act=select_applicant&applicant_id=84&employer_id=84&job_title=PHPdeveloper&job_id=1000&employer_name=ram&salary=5090&joining_date=12-jan-2014&other_deatil=hi how are you&status=1",

//data: "act=act=getappliedjobs&user_id=176&id=193",
    // data:"act=select_applicant&applicant_id=84&employer_id=104&employer_name=Sameer&job_id=127&job_title=Php&salary=5000&joining_date=december&other_deatil=Hi How are you &status=3",
  
    dataType: "json",
    success: function(result) {

    }
});
</script>
</head>
<form id="con" enctype='multipart/form-data' action="Image_upload.php" method="POST">
	<input type="file" name="eventImage">
    <input type="text" name="userid" value="16">
	<input name="submit" type="submit" value="Submit">
</form>
<body>
	
</body>
</html>