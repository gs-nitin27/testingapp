<?php

class feePaymentServices 
{

 
public function feePaymentCount()
{   
 $query = mysql_query("SELECT * FROM `gs_class_data` WHERE `classid` IN ( SELECT `id` FROM `gs_coach_class` WHERE (CURDATE() between `class_start_date` AND `class_end_date`) OR (DATE(`class_start_date`) < CURDATE() AND `class_end_date` IS NULL ))");
    if(mysql_num_rows($query))
    {
     while($row = mysql_fetch_assoc($query))
     {
       $data[] ="('".$row['student_id']."','".$row['classid']."','".$row['coach_id']."','".$row['fees']."',0)"; 
     } 
      $lenght= sizeof($data);
      $feeslips_data='';
      for($i=0;$i<$lenght;$i++)
      {
        if($i==0)
        {
        	$feeslips_data .=$data[$i]; 
        }
        else
        {
        	$feeslips_data .=",".$data[$i];
        } 	
      }
     $var = $this->get_feeslip($feeslips_data);
     if($var)
     {
     	return 1;
     }else
     {
     	return 0;
     }   	
    }
    else
    {
    	return 0;
    }
}


public function get_feeslip($data)
{
  $query = mysql_query("INSERT INTO `gs_feeslip`(`userid`,`classid`,`coachid`,`payment_amount`,`status`) VALUES $data");
  if($query)
  {
  	return 1;
  }else
  {
  	return 0;
  }
}
}
?>