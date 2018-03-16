
<?php 

Class paymentServices
{

public function paymentPlan()
{
	$query = mysql_query("SELECT * FROM `gs_pricing_plan`");
	if(mysql_num_rows($query))
	{
		while ($row = mysql_fetch_assoc($query)) 
		{
			$rows[]=$row;
		}
		return $rows;
	}else
	{
		return 0;
	}
}

public function payment($paymentdata)
{
   

	$query = mysql_query("INSERT INTO `gs_billing`(`userid`,`invoice_id`,`user_item`,`module`,`amount`,`date`,`billing_status`,`transaction_id`,`date_created`,`date_updated`) VALUES('$paymentdata->userid','$paymentdata->invoice_id','$paymentdata->user_item','$paymentdata->module','$paymentdata->amount',CURDATE(),'1','$paymentdata->transaction_id',CURDATE(),CURDATE()) ");
	if($query)
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

public function useremaildata($userid)
{
	$query = mysql_query("SELECT `email` , `contact_no`,`name` FROM `user` WHERE `userid` = '$userid'");
	if(mysql_num_rows($query))
	{
		 while ($row = mysql_fetch_assoc($query)) 
		 {
		 	$rows = $row;
		 }
		 return $rows;
	}else
	{
		return 0;
	}

}

public function getTransactionList($userid)
{
	$query = mysql_query("SELECT `invoice_id`,`date`,`amount`,`transaction_data` FROM `gs_billing` WHERE `userid`='$userid' ORDER BY  `date` DESC ");

	if(mysql_num_rows($query))
	{
		while ($row = mysql_fetch_assoc($query)) 
		{   $row['transaction_data'] = $row['transaction_data'];
	        $row['date'] = date('F j, Y',strtotime($row['date'])); 
			$rows[] = $row;
		}
		return $rows;
	}
	else
	{
		return 0;
	}
}


public function findemail($userid) 
{

	$query = mysql_query("SELECT `email`,`name`,`contact_no` FROM `user` WHERE `userid` = '$userid'");
	if(mysql_num_rows($query))
	{
		while ($row = mysql_fetch_assoc($query)) 
		{
			$rows = $row;
		}
		return $rows;
	}
	else
	{
		return 0;
	}
}

public function getInvoiceData($invoice_id)
{  

  $query = mysql_query("SELECT gs_billing.* , `gs_jobInfo`.`title` FROM gs_billing INNER JOIN gs_jobInfo ON `gs_billing`.`user_item`=`gs_jobInfo`.id WHERE `gs_billing`.`invoice_id`='$invoice_id'");
	//$query = mysql_query("SELECT * FROM `gs_billing` WHERE `invoice_id`='$invoice_id'");
	if(mysql_num_rows($query))
	{
		while ($row = mysql_fetch_assoc($query)) 
		{
			$rows = $row; 
		}
	 return $rows;
	}
	else
	{
		return 0;
	}
}

public function create_hash($data)
{   
	$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
	$data->txnid = $txnid;
	unset($data->hash);
	$SALT = 'e5iIg1jwi8';
    $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

    
	
     $hashVarsSeq = explode('|', $hashSequence);
     $hash_string = '';	
  foreach($hashVarsSeq as $hash_var) {
      
      $hash_string .= isset($data->$hash_var) ? $data->$hash_var : '';
      $hash_string .= '|';
      }
    $hash_string .= $SALT;

    $hash = strtolower(hash('sha512', $hash_string));
	$resp = array('hashkey' => $hash,'taxid'=>$txnid,'hash_seq' => $hash_string);
	return $resp;
}


public function billing_data_save($item)
{

 $query = mysql_query("INSERT INTO `gs_participant_billing`(`invoice_id`,`user_item`,`module`,`amount`,`date`,`billing_status`,`transaction_id`,`userid`,`date_created`,`date_updated`,`transaction_data`) VALUES('$item->invoice_id','$item->productinfo','3','$item->amount',CURDATE(),'1','$item->txnid','$item->userid',CURDATE(),CURDATE(),'$item->transaction_data')");
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