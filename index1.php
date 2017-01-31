
<Html>
<head>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript">
	

//var data = {"email":"devendrakumarpandey@gmail.com","status":1,"dob":"2017\/0\/31","userid":"313","gender":"MALE","sport":"SPORT","proffession":"Football","mobile_no":"8546523123",'user_image':"abc"};

 var data = {
   
    "email":"devendrakumarpandey@gmail.com",
    "password":"123456", 
    "device_id":"8888",
    "usertype":"104",
    "logintype":2,
  "userid":"101",
  "user_image":"55555555555555555555555"
 



};



// var university = "";
// var data = '{"class_name":"Test Class3","start_date":"2016-02-15","end_date":"2016-02-16","user_id":"16","start_time":"09 am"}';
$.ajax({

    type: "POST",
   // url: "getListingController.php?act=sportlisting",
    url: "create_database.php?act=gs_login",
    data:"data="+JSON.stringify(data),
    //url: "getListingController.php",

// data:"act=gs_signup",
 //data:"act=register&email=devendrakumarpandey@gmail.com&password=12345",
//data:"act=getappliedjobs&user_id=176&id=133",

//data:"act=gs_searching&user_id=208&module=1&key=",

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