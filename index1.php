
<Html>
<head>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript">

function hit(){	


// var university = "";
// var data = '{"class_name":"Test Class3","start_date":"2016-02-15","end_date":"2016-02-16","user_id":"16","start_time":"09 am"}';

var data = {
           "otp_code" : "2135",
           "userid"  :  "16",
           "phone_no" : "7838149085"  
};
"16"
var data = JSON.stringify(data);
console.log(data);

$.ajax({

    type: "POST",
    //url: "otpVarifyController.php",
    url : "create_database.php?act=getUserData&userid="+16,

// data:"act=gs_signup",
 //data:"act=register&email=devendrakumarpandey@gmail.com&password=12345",
//data:"act=getappliedjobs&user_id=176&id=133",
//data:"act=user_otp&phone=7788888",
 //data : "data="+ data,


   // url: "useralertcontroller.php",
//data: "act=select_applicant&applicant_id=84&employer_id=104&job_title=PHPdeveloper&job_id=1000&employer_name=ram&salary=5090&joining_date=12-jan-2014&other_deatil=hi how are you&status=2",
 // data: "act=select_applicant&applicant_id=84&employer_id=84&job_title=PHPdeveloper&job_id=1000&employer_name=ram&salary=5090&joining_date=12-jan-2014&other_deatil=hi how are you&status=1",

//data: "act=act=getappliedjobs&user_id=176&id=193",
    // data:"act=select_applicant&applicant_id=84&employer_id=104&employer_name=Sameer&job_id=127&job_title=Php&salary=5000&joining_date=december&other_deatil=Hi How are you &status=3",
  
    dataType: "text",
    success: function(result) {
      alert(JSON.stringify(result))
    $('#resp').text(JSON.stringify(result));
    }
});}

</script>
</head>
<form id="con" enctype='multipart/form-data' action="Image_upload.php" method="POST">
	<input type="file" name="eventImage">
    <input type="text" name="userid" value="16">
	<input name="submit" type="submit" value="Submit">
</form>
<input type="button" id="hit" name="Hit Me" value="Hit me" onClick="hit()">
<div id="resp"></div>
<body>
	
</body>
</html>  