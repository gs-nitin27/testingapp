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
  $query = mysql_query("INSERT INTO `gs_inventry`(`invoiceid`,`transactionid`,`userid`,`coach_id`,`classid`,`remarks`,`paymentid`,`date_of_transaction`,`sno`,`mode_of_payment`,`amount_paid`) VALUES('$invoice','$userdata->transactionid','$userdata->student_id','$userdata->coach_id','$userdata->classid','$userdata->remarks','$userdata->paymentid',CURDATE(),$sno,'$userdata->mode_of_payment','$userdata->amount_paid')");
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




} // End Class


