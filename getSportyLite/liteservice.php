<?php
  class liteservice
  { 
    function __construct()
    {   
      error_reporting(0);
      mysql_set_charset("UTF8");
      header('Content-type: text/html; charset=utf-8');
    }

    /*******************Check The User is Already Exits [Function]*************/

    public function  userExits($where)
    {
     
       $query  = mysql_query("SELECT `userid`,`userType`,`name`, `email` FROM `user` ".$where);
       if(mysql_num_rows($query)>0)
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
    
    /****************Sign Up in Getsporty [Function]***********************/

    public function GsUserRegister($data)
    {
       $name         =  $data['name'];
       $email        =  $data['email'];
       $password1    =  $data['password'];
       $token        =  mysql_escape_string($data['token']);
       $userType     = '4';

       $query =mysql_query("INSERT INTO `user`(`userid`,`userType`, `name`, `email`, `password`,`device_id`) VALUES('','$userType','$name','$email','$password1','$token')");
       if($query)
       {
              require('class.phpmailer.php');
              $mail = new PHPMailer();
              $to=$email;
              $from="info@getsporty.in";
              $from_name="Getsporty Lite";
              $subject="Email varification ";
              $emailconform="getsporty.in/activation.php?email=";
              //$emailconform  ="testingapp.getsporty.in/getSportyLite/activation.php?email=";
              //global $error;
              $mail = new PHPMailer();  // create a new object
              $mail->IsSMTP(); // enable SMTP
              $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
              $mail->SMTPAuth = true;  // authentication enabled
              $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
              $mail->Host = 'dezire.websitewelcome.com';
              //$mail->Host = 'smtp.gmail.com';
              $mail->Port = 465; 
              $mail->Username ="info@getsporty.in";  
              $mail->Password = "%leq?xgq;D?v";           
              $mail->SetFrom($from, $from_name);
              $mail->Subject = $subject;
              // $mail->Body = ' 
              //            <h1> Click here </h1>'.$emailconform.''.$email.'<br><b>Note:- Please varification of this email</b>
              // '; 
$mail->Body = '<div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#5666be;">

 <table align="center" border="4" cellpadding="4" cellspacing="3" style="max-width:440px" width="100%" class="" >
<tbody><tr>
<td align="center" valign="top">
<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="background-color:#ffffff;  border-bottom:2px solid #e5e5e5;border-radius:4px" width="100%">
<tbody><tr>

<td align="center" style="padding-right:20px;padding-left:20px" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td align="left" valign="top" style="padding-top:40px;padding-bottom:30px">
</td>
</tr>
<tr>
<td style="padding-bottom:20px" valign="top">
<h1 style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:28px;font-style:normal;font-weight:600;line-height:36px;letter-spacing:normal;margin:0;padding:0;text-align:left">Please verify your email Address.</h1>
</td>
</tr>
<tr>
<td style="padding-bottom:20px" valign="top">
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left">To validate Your email Address, you MUST click the link below.<strong><br><h1> Click here:<h1> Click here </h1>'.$emailconform.''.$email.'<br></strong>
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left"><br>Note:- If clicking the link does not work, you can copy and paste the link into your browser address window,or retype it there.<br><br><br><br><br>Thanks you for visiting GetSportyLite Team</p> 

</td>
</tr>
<tr>
<td align="center" style="padding-bottom:60px" valign="top">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td align="center" valign="middle">
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</div>'; 
               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $mail->Send();
           return 1;
          }
          else
          {
            return 0;
          }
        }
       
    
    // public function userdata($id)
    // {
    //    $query  = mysql_query("SELECT `userid`,`userType`,`name`, `email` FROM `user` where `userid` = '$id'");
    //    if(mysql_num_rows($query)>0)
    //    {
    //       while($row = mysql_fetch_assoc($query))
    //       {
    //         $data = $row;
    //       }
    //     return $data;
    //     }
    //     else 
    //     {
    //      return 0;
    //     }
    // }

      /********************Sign In GetSporty [Function]*******************/

    public function gsSignIn($email,$password1,$token)
    {
    	      
     $query = mysql_query("SELECT `userid`,`userType`,`status`,`name`, `email` ,`device_id` FROM `user` WHERE `email` = '$email' AND `password` = '$password1'");
     $row  = mysql_num_rows($query);
    
       if($row)
       {
            while($row = mysql_fetch_assoc($query))
            {   
                if($row['status'] == '1' )
                {
                     if($row['device_id'] != $token)
                     {
                      mysql_query(" UPDATE `user` SET `device_id` = '$token' WHERE `email` = '$email' AND `password` = '$password1'");
                          $data= $row; 
                          return $data;
                     }
                     else
                     {
                        $data= $row; 
                        return $data;
                     }
               }
                else
               {
                  $data= $row; 
                  return $data;
               }
            }

        }     
        else
        {
           return 0;
        }

  }

    /****************************Listing Resources GetSporty [Function]*************************/

    public function getList()
    { 
      $query = mysql_query("SELECT *FROM `gs_resources` ORDER by `date_created` desc ");
      $row  = mysql_num_rows($query);
       if($row > 0)
        {
            while ($row = mysql_fetch_assoc($query))
            {   
                 $des1=strip_tags($row['description']); 
                 $row['description'] = $des1;
                 $sum1=strip_tags($row['summary']);
                 $row['summary'] = $sum1; 
                 $row['fav'] = '0';
                 $data[] = $row;
            }
         return $data;
        }
        else
        {
          return 0;
        }
    }

    /****************************Listing  for Sports GetSporty [Function]**************/

   public function Get_Sports()
   {
      $query = mysql_query("SELECT `sports` FROM `gs_sports` where 1  ");
      $row  = mysql_num_rows($query);
      if($row)
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
    /****************************Listing for Location GetSporty [Function]**************/
    public function Get_Location()
    {
      $query = mysql_query("SELECT `name` FROM `gs_city` where 1 GROUP BY `name` ORDER BY `name` ASC ");
      $row  = mysql_num_rows($query);
      if($row)
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

   /******************** Seraching [Function]**********************/
    public function GetSearch($where)
    {
      //echo "SELECT * FROM `gs_resources` 'where' .'$where'.";die();
     //$query ="SELECT * FROM `gs_resources` where ".$where;
        $query = mysql_query("SELECT * FROM `gs_resources` where ".$where);
        //$a=mysql_query($query);
        //echo $a;die();
        if(mysql_num_rows($query) > 0)
        {
              while($row = mysql_fetch_assoc($query))
              {
                   $des1=strip_tags($row['description']); 
                   $row['description'] = $des1;
                   $sum1=strip_tags($row['summary']);
                   $row['summary'] = $sum1; 
                   $row['fav'] = '0';
                   $rows[] = $row;
              }
        return $rows;
        } 
        else
        {
          return 0;
        }
    }
     /*************** Get Details of Resources[Function]*****************/

     public function getDetail($resource_id)
    {
      $query = mysql_query("SELECT * FROM `gs_resources` where `id`=$resource_id");
        if(mysql_num_rows($query)>0)
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
     /**************** Get favourites of Resources [Function]*****************/
     public function favourites($user_id, $module , $user_favs)
    {
        $record = mysql_query("SELECT * FROM `users_fav` WHERE `userid` = '$user_id' AND `module` = '$module' ");
       if(mysql_num_rows($record) < 1)
        {
             $query = mysql_query("INSERT INTO `users_fav`(`id`, `userid`, `userfav`, `module`) VALUES ('','$user_id','$user_favs','$module')");
            if ($query)
           {
             return 1;
           }
           else
           {
             return 0;
           }
        }
        else
        {
            while($data = mysql_fetch_assoc($record))
            {
                $row = $data;
                return $row;
            }   
        }
    }



    public function updatefav($id,$user_id,$data)
   {
       $data = rtrim($data,"");
       $data = rtrim($data,",");
       $query = mysql_query("UPDATE `users_fav` SET `userfav` = '$data' WHERE `userid` = '$user_id' AND `id` = '$id' ");
       if($query)
       {
       return 1;
       }
       else
       {
       return 0;
       }
    } 
     /********** Save Token When user is first instal APPS [Function]********/
    public function saveToken($token)
    {
      $query = mysql_query("SELECT `token_id` FROM `get_token` USE INDEX (`token_id`) WHERE `token_id` = '$token'");
      if(mysql_num_rows($query) < 1)
      {
          $insert = mysql_query("INSERT INTO `get_token` (`id`,`token_id`) VALUES ('','$token')");
          if($insert)
          {
            return 1;
          }
          else
          {
            return 0;
          }
      }
      else
      {
        return 1;
      }
    }

    /*****************Get The Favourate [Function]**********************/

    public function getfav($id,$type)
   {
      $query = mysql_query("SELECT `userfav` FROM `users_fav` WHERE `userid` = '$id' AND `module` = '$type'  AND  `userfav` != '' ");
      if(mysql_num_rows($query)>0)
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

 /*****************Get The Favourate and Alert [Function]**********************/

    public function get_fvdata($fwhere)
    {

      $query = mysql_query("SELECT *FROM `gs_resources` where `id` IN (".$fwhere.")" );
     if(mysql_num_rows($query)>0)
     {
       while($row = mysql_fetch_assoc($query))
       {  
         $des1=strip_tags($row['description']); 
          $row['description'] = $des1;
         $sum1=strip_tags($row['summary']);
          $row['summary'] = $sum1; 
         $row['fav'] = 1;
         $data[] = $row;
        }
        return $data;
      }
      else
      {
       return 0;
      }
    }

     /************* Subscribed The Application by User [Function]************************/
     public function getsubscribed($userid,$textjson)
    {
     $query = mysql_query("SELECT  *FROM `gs_subscribed` WHERE `userid` = '$userid' AND `Moudule` = '6' AND `para_json`='$textjson'");
      if(mysql_num_rows($query)>0)
      {
        while ($row = mysql_fetch_assoc($query)) 
        {
          return $row;
        }
      }
      else
      {
        return 0;
      }
    }


     /***************Save the Subscribe query [Function]*******************/

    public function saveSubscribe($userid , $where, $textjson)
    { 
      if($this->getsubscribed($userid,$textjson) == 0)
      {
       $query = mysql_query("INSERT INTO `gs_subscribed`(`id`, `userid`, `search_para`, `Moudule`, `count`, `subscribe`, `date`,`para_json`) VALUES ('','$userid','$where','6','0','1',CURDATE(),'$textjson')");
      }
      else
      {
        $query = mysql_query("UPDATE `gs_subscribed` SET `search_para` = '$where',`subscribe`  = '1' ,`para_json` = '$textjson' WHERE `userid` = '$userid' AND `Moudule` = '6' AND `para_json`='$textjson' ");
      }
      if($query)
      {
       return 1;
      }
      else
      {
       return 0;
      }
    }
     /******************Get  the All Subscribe Alert [Function]*************************/
    public function getSubs($userid,$module)
    {
      $query = "SELECT * FROM `gs_subscribed` WHERE `userid` = '$userid' AND `Moudule` = '$module'";
      $exec = mysql_query($query);
      if(mysql_num_rows($exec) > 0)
      {
        while ($row = mysql_fetch_assoc($exec)) 
        {
          $row['para_json'] = json_decode($row['para_json']);
          $rows[] = $row;
        }
        return $rows;
      }
      else
      {
        return false;
      }
    }

   /*************Function for Delete The Subscribe and Alert*************************/

    public function delSubs($userid,$sub_id,$module)
    {
     $query = mysql_query("DELETE FROM `gs_subscribed` WHERE `userid` = '$userid' AND `id`='$sub_id' AND `Moudule` ='$module'");
      if($query)
      {
        return 1;
      }
      else 
      {
        return 0;
      }
    }

     /**************Modify The Subscribe and Alert [Function]*******************/

     public function modify($user_id ,$sub_id,$where, $textjson,$module)
    {
       $query = mysql_query("UPDATE `gs_subscribed` SET `userid`='$user_id', `id`='$sub_id',`search_para` = '$where',`subscribe`  = '1' ,`para_json` = '$textjson' WHERE `userid` = '$user_id' AND `id` = '$sub_id' AND `Moudule`='$module'");
        if($query)
        {
        return 1;
        }
        else 
        {
        return 0;
        }
    }

      /***********************Forget Password [Function] **********/

    public function forgetPass($email)
    {
      $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
      $code='';
      $query  = mysql_query("SELECT * FROM `user` WHERE `email` = '$email'");
      if(mysql_num_rows($query)>0)
      {
          while($row = mysql_fetch_assoc($query))
          {
              $user_name = $row['name'];
              $code ='';
                 for ($i = 0; $i < 8; $i++)
                 {
                    $n    = rand(0, strlen($alphabet)-1);
                    $code .= $alphabet[$n];
                 }
          }
      }  
       $query  = mysql_query("UPDATE `user` SET `forget_code` ='$code'  WHERE `email` = '$email'");
      if($query)
        {
          if($code)
          {
              require('class.phpmailer.php');
              $mail = new PHPMailer();
              $to=$email;
              $from="info@getsporty.in";
              $from_name="Getsporty Lite";
              $subject="Forget Password ";
              $user=$user_name;
              $otp  =$code;
              //global $error;
              $mail = new PHPMailer();  // create a new object
              $mail->IsSMTP(); // enable SMTP
                  $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
              $mail->SMTPAuth = true;  // authentication enabled
              $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
              $mail->Host = 'dezire.websitewelcome.com';
              //$mail->Host = 'smtp.gmail.com';
              $mail->Port = 465; 
              $mail->Username ="info@getsporty.in";  
              $mail->Password = "%leq?xgq;D?v";           
              $mail->SetFrom($from, $from_name);
              $mail->Subject = $subject;
              $mail->Body = '<div style="font-family:HelveticaNeue-Light,Arial,sans-serif;background-color:#5666be;">

 <table align="center" border="4" cellpadding="4" cellspacing="3" style="max-width:440px" width="100%" class="" >
<tbody><tr>
<td align="center" valign="top">
<table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="background-color:#ffffff;  border-bottom:2px solid #e5e5e5;border-radius:4px" width="100%">
<tbody><tr>

<td align="center" style="padding-right:20px;padding-left:20px" valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td align="left" valign="top" style="padding-top:40px;padding-bottom:30px">
</td>
</tr>
<tr>
<td style="padding-bottom:20px" valign="top">
<h1 style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:28px;font-style:normal;font-weight:600;line-height:36px;letter-spacing:normal;margin:0;padding:0;text-align:left">Forgot your password? Lets get you a new one.</h1>
</td>
</tr>
<tr>
<td style="padding-bottom:20px" valign="top">
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left">Dear <strong> ' . $user . '</strong></p>
<p style="color:#5666be;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:16px;font-weight:400;line-height:24px;padding-top:0;margin-top:0;text-align:left">If you want to reset your password enter given OTP <strong>'.$otp.'</strong><br>Note:- Please change your Password after login.<br><br><br><br><br>Thanks GetSportyLite Team </p> 

</td>
</tr>
<tr>
<td align="center" style="padding-bottom:60px" valign="top">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr>
<td align="center" valign="middle">
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</div>'; 
               $txt='This email was sent in HTML format. Please make sure your preferences allow you to view HTML emails.'; 
               $mail->AltBody = $txt; 
               $mail->AddAddress($to);
               $mail->Send();
           return 1;
          }
          else
          {
            return 0;
          }
      }       
      else
      {
          return 0;
      }
    }

      /***********************Change Password [Function]****************/
     public function change_passwrod($otp_code,$new_password)
    {
      $new_password1=md5($new_password);
      $query  = mysql_query("SELECT `email` from `user`  WHERE `forget_code`= '$otp_code'");
      $query1=mysql_num_rows($query);
     if($query1)
     {
       mysql_query("UPDATE `user` SET `password` ='$new_password1',`forget_code` =''   WHERE `forget_code`='$otp_code' ");
       return 1;
      }
        else
      {
        return 0;
      }
    }


    /****************Create Resource [Share Story here] [Function] *******************************/
    
      public function getCreate($data)
      {
	      $title             = $data->title;
	      $summary           = $data->summary; 
	      $url               = $data->link;
	      $image             = $data->photo;
	      $topic_artical     = $data->topic_artical; 
	      $sports            = $data->sports;
	      $location          = $data->location;
	      $query  = mysql_query("INSERT INTO `gs_resources`(`id`,`title`,`summary`,`url`,`topic_of_artical`,`sport`,`location`,`date_created`) VALUES ('','$title ','$summary','$url','$topic_artical ','$sports',' $location ',CURRENT_DATE)");
	      if($query)
	      { 
	        $id = mysql_insert_id();
	        if($id!=NULL && $image!=NULL)
	        {
	         $image = $this->imageupload($image,$id);
	        }
	      return 1;
	      }
	      else
	        {
	          return 0;
	        }
        }

    /***************Function for Upload Image in Create Resource***********************/

    public function imageupload($image,$id)
    {
       $now = new DateTime();
       $time=$now->getTimestamp(); 
	     define('UPLOAD_DIR','../../staging/uploads/resources/');
      $img = $image;
      $img = str_replace('data:image/png;base64,', '', $img);
      $img = str_replace('$filepath,', '', $img);
      $img = str_replace(' ', '+', $img);
      echo $filepath;
      $data = base64_decode($img);
      $img_name= "res"."_".$time;
      $success=move_uploaded_file($img, $filepath);
      $file = UPLOAD_DIR.$img_name.'.png';
      $success = file_put_contents($file, $data);
      if($success)
      {
        $img_name = $img_name. '.png';
        $updateImage = mysql_query("update `gs_resources` set `image`='$img_name' where `id`='$id'");
      if($updateImage)
      {
        return 1;
      }
      }
      else
        {
          $res = array('data' =>'Image is Not Upload' ,'status' => 0);
          echo json_encode($res);
          return 0;
          //echo "image not uploaded";
         
        }
    }

   
   } // End of Class


?>

