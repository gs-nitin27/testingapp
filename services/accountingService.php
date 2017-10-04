<?php


class accountingServices 
{

  public function classlist($userid)
  {
      	



  }

  public function viewClass($classid)
  {
  	$query = mysql_query("SELECT * FROM `gs_coach_class` WHERE `id`='$classid'");
  	if(mysql_num_rows($query))
  	{
  		while($row = mysql_fetch_assoc($query))
  		{
          $data = $row;
  		}
  	
  	    return $data;
  	}
  	else
  	{
  		return 0;
    }
  }

public function getClassFeeList($classid,$student_id)
{
	$query = mysql_query("SELECT * FROM `gs_feeslip` WHERE `userid`='$student_id' AND `classid`='$classid' ORDER BY `id` DESC");
	if(mysql_num_rows($query))
	{
		while ($row = mysql_fetch_assoc($query)) 
		{
			$data[] = $row;
		}
		return $data;
	}
	else
	{
		return 0;
	}	
}  	
	

public function ViewClassData($classid,$student_id)
{
    $query = mysql_query("SELECT gs_coach_class.* , gs_class_data.*  FROM `gs_coach_class`  JOIN  gs_class_data ON`gs_class_data`.`classid`=`gs_coach_class`.id  WHERE `student_id` = '$student_id' AND `classid` = '$classid' ");
    if(mysql_num_rows($query))
    {
    	while( $row = mysql_fetch_assoc($query)) 
    	{
    		$data = $row;
    	}
    	return $data;
    }else
    {
    	return 0;
    }
}
public function create_feeSlip($data,$student_code)
{
  $feedata = $data->athlete_info->fee_plan;
  $keys = split("/", $feedata);
  $total_fee = $keys[1];
  $feeamountpaid = $data->athlete_info->fee_amount;
  $paid = $data->athlete_info->fee_paid; 
  $query = mysql_query("INSERT INTO `gs_fee_memo`(`class_id`, `athlete_class_id`, `fee_amount`,`fee_amount_paid` ,`coach_id`, `memo_date`, `status`) VALUES ('$data->classid','$student_code','$total_fee','$feeamountpaid','$data->coach_id',CURDATE(),'$paid')");
  if($query)
  {
    return 1;
  }else
  {
    return 0;
  }

}
public function create_invoice()
{
echo "INSERT INTO `gs_inventry`(`invoiceid`, `transactionid`, `userid`, `coach_id`, `classid`, `remarks`, `paymentid`, `date_of_transaction`, `sno`, `mode_of_payment`, `amount_paid`, `memo_amount`, `memoid`) VALUES ([value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],[value-13])";die;
 $query = mysql_query("INSERT INTO `gs_inventry`(`invoiceid`, `transactionid`, `userid`, `coach_id`, `classid`, `remarks`, `paymentid`, `date_of_transaction`, `sno`, `mode_of_payment`, `amount_paid`, `memo_amount`, `memoid`) VALUES ([value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],[value-13])");



}

}


?>