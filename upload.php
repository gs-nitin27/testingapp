	<?php
	include('config1.php');
	$filename = $_FILES['file']['name'];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	if($ext == 'csv')
	{
	   $tmpName = $_FILES['file']['tmp_name'];	
       if(($handle = fopen($tmpName, 'r')) !== FALSE) {
            // necessary if a large csv file
            set_time_limit(0);

            $row = 0;

            while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                // number of fields in the csv
                $col_count = count($data);
                if($row > 0)
                {
                    $id = $data['7'].$data['2'].$data['6'];
                    $query[] = "('".$id."','".$data['7']."','".$data['6']."','".$data['5']."','".$data['4']."',CURDATE(),'".$data['2']."','".$data['1']."','".$data['3']."')";  	
                }

                // inc the row
                $row++;
            }
           $values = implode(',', $query);
           $sql_query = mysql_query("INSERT INTO `gs_student_list`(`student_id`, `institute_id`, `student_reg_no`, `date_of_birth`, `gender`, `date_created`, `class`, `name`, `guardian name`) VALUES ".$values."");
            fclose($handle);
        }
	}
	else if(isset($_POST['btn_upload']))
	{
		$filetmp=$_FILES["file_img"]["tmp_name"];
		$filename=$_FILES["file_img"]["name"];
		//$filetype=$_FILES["file_img"]["type"];
		$filepath="img2/".$filename;
		//echo $filetmp."<br>";
		echo "File name------------------>".$filename."<br>";
		//echo $filetype."<br>";
		//echo $filetype."<br>";
		echo "File Path------------>".$filepath."<BR>";
		echo "File tmp---------------->".$filetmp."<br>";
		$enc_name=base64_encode($filetmp);
		echo "Base-64 Encode------------->".$enc_name."<br>";

		$dec_name=base64_decode($enc_name);
		echo "Base-64 Decode ------------->".$dec_name."<br>";
	echo "**********"."<br>";

			move_uploaded_file($dec_name, $filepath);
			//$a='4';
			
			//if(empty(mysql_query("select `image` from `emp`))
				//{ 
					//insert into emp(id,image) values('','$filename');
			//}
			//$tfname=mysql_query("select `image` from `emp` where `image` ='$filename'");
			
			//elseif ($tfname) {
					//	{
			//$tfname=mysql_query("select `image` from `emp` where `image` ='$filename'";
					//echo $tfname;
					//if($tfname)
			//{
				//echo "Record is Already Exist";
				
			//}
			//else
			//{
				$sql=mysql_query("insert into emp(id,image) values('','$filename')");
				
				if ($sql) {
    $last_id = mysqli_insert_id($sql);

   // echo "New record created successfully. Last inserted ID is: " . $last_id;
//} //else {
	 echo $last_id;
    echo "Error: " . $sql . "<br>" ;
}
}


				//else
				//{
					//echo "<center>"."<font color='red'>"."----------Image file is Not insert in Database---------";
				//}
		
		//$result=mysql_query($sql)
	//}
	//}

	//}
/*
$query1 = mysql_query("SELECT * FROM `emp` ");
if(mysql_num_rows($query1) > 0)
{

while($row = mysql_fetch_assoc($query1))
{
	echo"<br>";
$id=$row['id'];
$name=$row['image'];
$name_id=$id."_".$name;
echo "--------";
echo $name_id;
$filepath="img3/".$name_id;
move_uploaded_file($name, $filepath);
}
}


*/


	?>