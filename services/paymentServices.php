
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

}


?>