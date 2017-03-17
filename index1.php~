
<Html>
<head>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript">

function hit(){	


//var university = "";
//var data = '{"class_name":"Test Class3","start_date":"2016-02-15","end_date":"2016-02-16","user_id":"16","start_time":"09 am"}';
 
var data = {   
       "class_id" : "86"  ,
        "class_name"     : "test  new test test test class", 
        "description"    : "new class",   
        "days"           : "1,2,3,4,5,6",   
        "address"        : "new class", 
        "start_date"     : "2017-12-10",  
          "end_date"       : "2019-4-10",             "start_time"     : "12 a.m",             "end_time"       : "1 p.m",             "user_id"        : "58",             "location"       : "noida",             "duration"       : "3",             "fee"            : "6000",             "age_group"      : "4 and above",             "contact_no"     : "8956237412",             "class_strength" :"50",             "class_host"     :"Nitin"            };
var data = JSON.stringify(data);
console.log(data);

$.ajax({
     type: "POST",
     //url: "otpVarifyController.php",
     url : "ManageSchedule_classController.php?act=update_class",// data:"act=gs_signup",
    //data:"act=register&email=devendrakumarpandey@gmail.com&password=12345",
    //data:"act=getappliedjobs&user_id=176&id=133",
    //data:"act=user_otp&phone=7788888",
    data : "data="+ data,


   // url: "useralertcontroller.php",
//data: "act=select_applicant&applicant_id=84&employer_id=104&job_title=PHPdeveloper&job_id=1000&employer_name=ram&salary=5090&joining_date=12-jan-2014&other_deatil=hi how are you&status=2",
 // data: "act=select_applicant&applicant_id=84&employer_id=84&job_title=PHPdeveloper&job_id=1000&employer_name=ram&salary=5090&joining_date=12-jan-2014&other_deatil=hi how are you&status=1",

//data: "act=act=getappliedjobs&user_id=176&id=193",
    // data:"act=select_applicant&applicant_id=84&employer_id=104&employer_name=Sameer&job_id=127&job_title=Php&salary=5000&joining_date=december&other_deatil=Hi How are you &status=3",
  
    dataType: "text",
    success: function(result) {
      alert(result);
      //alert(JSON.stringify(result))
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
