<?php 
include('config1.php');
include('services/searchdataservice.php');
include('services/userdataservice.php');
error_reporting(E_ERROR | E_PARSE);

//************CODE FOR MAKING SEARCH FOR COACHES AND TRAINERS***********//

if($_POST['act'] == "search")
{
$type             = urldecode($_POST['type']);	
$location         = urldecode($_POST['location']);
$sport            = urldecode($_POST['sport']);
$id               = urldecode($_POST['userid']);
$certification    = urldecode($_POST['certification']);
$area             = urldecode($_POST['area']);
$subs             = urldecode($_POST['subs']);

$whereclause = "WHERE"." ";
if($type != "")
{
$where1 = "us.`prof_id` LIKE '%$type%'"; 
}
if($location != "")
{
$where2 = "AND us.`location` LIKE '%$location%'"; 
}
if($sport !="")
{
$where3= "AND us.`sport` LIKE '%$sport%' ";
}
if($area !="")
{
$where4= "AND (us.`address1` OR us.`address2` OR us.`address3`) LIKE '%$area%' ";
}
if($certification != "")
{
$where5 = "AND ue.`Degree_course` LIKE '%$age%' AND ue.`edu_id` = '3'"; 
}
 //echo $wherenext;
 $wherenext = $where1.$where2.$where3.$where4.$where5;// WHERE CLAUSE FOR THE SEARCH QUERY
 if($wherenext == "" )
 {
 	
$fwhere  = $whereclause."1";

 }else
// echo $fwhere;
$fwhere  = $whereclause.$wherenext; 
 //echo $fwhere;

$req = new searchdataservice();
$res = $req->gensearch($fwhere, $page); // function to get search results

if($type == "coach")
{
	$type = '4';
}
else if($type == "trainer")
{
	$type = '5';
}
if($res != 0)
{

if($id != ''){
$recarr = array();
$size = sizeof($res);
for($i = 0; $i<$size ; $i++)
{

  $resid= $res[$i]['userid'];
  array_push($recarr, $resid);
  $recarr[$i][$resid];
}
$recdata = implode(",",$recarr);
$rec     = new userdataservice();
$rec1    = $rec->saverecent($recdata,$type, $id);  // function on userdataservice class to save recent search


}

if($id != '')
{
$al1  = new searchdataservice();
$al2  = $al1->savealert($id ,$fwhere , $type , $size, $subs); // function on searchdataservice class to save recent searches
if($subs == '1')
{
echo $al2;
die();
}
}

}

$rev1 = new userdataservice();
$res1 = $rev1->getfavForUser($res, $type, $id);// function on userdataservice class to get favourites search resuts


$res = array('data' => $res1);
echo json_encode($res);
}

//***********************CODE FOR GETTING VALUES FOR SEARCH SCREEN DROPDOWNS*****************//


else if($_POST['act'] == "get_listing_for_events")
{
$location = urldecode($_POST['location']);
$type     = urldecode($_POST['type']);


$req  = new searchdataservice();
$res  = $req->getlistingforsports($type);
if($res != 0)
{
$size = sizeof($res);
for($i = 0; $i<$size ; $i++ )
{
$res[$i] = $res[$i]['sport'];
} 
$res = array_filter($res);
}
else
{
$res = array("0");
}


$req1 = new searchdataservice();
$res1 = $req1->getlistforlocation($type);
if($res1 != 0)
{
$size1 = sizeof($res1);	
for($i = 0; $i<$size1 ; $i++)
{
$res1[$i] = $res1[$i]['location'];

}
$res1 = array_filter($res1);
$res1 = array_values($res1);
}
else
{
$res1 = array("0");
}

$req2 = new searchdataservice();
$res2 = $req2->getlistforlevel($type);
//print_r($res2);
if($res2 != 0)
{
$size2 = sizeof($res2);	
for($i=0;$i<$size2; $i++)
{

$res2[$i] = $res2[$i]['level'];

}
}
else
{
$res2 = array("0");
}


$req3 = new searchdataservice();
$res3 = $req3->getlistingforage_group();
if($res3 != 0)
{
$size3 = sizeof($res3);
for($i=0 ;$i<$size3 ; $i++)
{

$res3[$i] = $res3[$i]['age_group'];
}
}
else
{
$res3 = array("0");
}


$req4 = new searchdataservice();
$res4 = $req4->getJobTitle();
if($res4 != '')
{
$size4 = sizeof($res4);
for($i = 0; $i<$size4 ; $i++)
{
$res4[$i] = $res4[$i]['title'];
}

}
else
{
	$res4 = array("0");
}
 
$req5 = new searchdataservice();
$res5 = $req5->getGender($type);
if($res5 != '')
{
$size5 = sizeof($res5);
for($i = 0; $i<$size5 ; $i++)
{
$res5[$i] = $res5[$i]['gender'];
}

}
else
{
	$res5= array("0");
}


$req6 = new searchdataservice();
$res6 = $req6->getType();
if($res6 != '')
{
$size6 = sizeof($res6);
for($i = 0; $i<$size6 ; $i++)
{
$res6[$i] = $res6[$i]['type'];
}

}
else
{
	$res6= array("0");
}



$data = array('data'=>array('sport'=>$res, 'location'=>$res1, 'level'=>$res2 , 'age_group'=>$res3 , 'jobtitle'=>$res4 , 'gender'=>$res5, 'type'=> $res6));
echo json_encode($data);
}

else if($_POST['act'] == "get_listing")
{
$location = urldecode($_POST['location']);
$type     = urldecode($_POST['type']);

$req1 = new searchdataservice();
$res1 = $req1->getArea($location,$type);
if($res1 != 0){
$size = sizeof($res1);
for($i=0; $i<$size; $i++)
{
$res1[$i] = $res1[$i]['AREA'];
}
$data1 =array_unique($res1);
$data2 =array_values($data1); 
}else 
{
$data2 = array("0");

}
//print_r($res1);

$req2 = new searchdataservice();
$res2 = $req2->getsportlisting($location,$type);
if($res2 != 0)
{
$size1 = sizeof($res2);
for($j=0; $j<$size1; $j++)
{
$res2[$j] = $res2[$j]['sport'];
}
$data3 =array_unique($res2);
$data4 =array_values(array_filter($data3)); 
}
else
{

$data4 = array("0");

}
$req3 = new searchdataservice();
$res3 = $req2->getsportcets($location,$type);
if($res3 != 0)
{
$size3 = sizeof($res3);
for($k=0; $k<$size3; $k++)
{
$res3[$k] = $res3[$k]['certs'];
}
$data6 =array_unique($res3);
$data7 =array_values(array_filter($data6));
}
else
{
//print_r($res3);
$data7 = array("0");
//echo $data7;
}

$data5 = array('data'=>array('area'=>$data2, 'sport'=>$data4, 'cert'=>$data7));
echo json_encode($data5);

}


?>