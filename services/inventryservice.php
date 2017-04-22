<?php 
class inventryservice 
{
/**
     * function to check the existing user while registration
     * @param in variable $where
     * @return results data in array form on success and 0 on failure..
     * @access public  
     */ 
 
 public function createinventry($invoice,$userdata,$sno)
 {
   if($userdata->mode_of_payment == 1)
   {
        $trans = 0;
   }
   else
   {
         $trans = $userdata->transaction_id;
   }
  $query = mysql_query("INSERT INTO `gs_inventry`(`invoiceid`,`transactionid`,`userid`,`coach_id`,`classid`,`remarks`,`paymentid`,`date_of_transaction`,`sno`,`mode_of_payment`,`amount_paid`) VALUES('$invoice','$trans','$userdata->student_id','$userdata->coach_id','$userdata->classid','$userdata->remark','$userdata->payment_id',CURDATE(),$sno,'$userdata->mode_of_payment','$userdata->amount_paid')");
  if($query)
  {
    return 1;
  }
  else
  {
    return 0;
  }

 }

 public function inventrylastid()
 {
    $query = mysql_query("SELECT MAX(sno) as sno FROM `gs_inventry`");
    $row = mysql_num_rows($query);
   if($row)
   {
     while($data = mysql_fetch_assoc($query))
      {
      $result = $data;
      }
       
        return $result;
   }

 }



public function invoicehistory($userid)
{
   $query = mysql_query("SELECT gs_inventry.* , `gs_coach_class`.`class_title` FROM gs_inventry INNER JOIN gs_coach_class ON `gs_inventry`.`classid`=`gs_coach_class`.id WHERE `gs_inventry`.`userid`=$userid ");
    $row = mysql_num_rows($query);
   if($row)
   {
     while($data = mysql_fetch_assoc($query))
      {
      $data['amount_paid']  =  (float)$data['amount_paid'];
      $result[]    = $data;
      }
      
        return $result;
   }
   else
   {
    return 0;
   }
}


} // End Class


