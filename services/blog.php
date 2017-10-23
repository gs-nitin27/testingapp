<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<?php
include('liveapp/getSportyLite/config1.php');
include('liveapp/getSportyLite/liteservice.php');
$id = $_REQUEST['n'];

if(!isset($id))
{
  $where = 'WHERE `token` IN ('.$token.') AND `status` = 1 ORDER BY `date_created` DESC';
}else
{ 
  $where = "WHERE `id` = '$id' ";
}
$req = new liteservice();
$res = $req->getBlogData($where);


 $desc =  preg_replace('([""]+)', " ", $res[0]['summary']);

?>
  <meta name="twitter:dnt" content="on">
  
  <meta property="og:url" content="http://getsporty.in/blog.php?n=<?php echo $res[0]['id'];?>" />
  <meta property="og:image" content="http://getsporty.in/portal/uploads/resources/<?php echo $res[0]['image']; ?>">
  <meta property="og:title" content="<?php echo $res[0]['title']; ?>" /> 
  <meta property="og:description" content="<?php echo $desc; ?>" />  
  <meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="@getsporty" />
<meta name="twitter:title" content="<?php echo $res[0]['title']; ?>" />
<meta name="twitter:description" content="<?php echo $desc; ?>" />
<meta name="twitter:image" content="http://getsporty.in/portal/uploads/resources/<?php echo $res[0]['image']; ?>" />    
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC|Dosis|Bubbler+One" rel="stylesheet">
    
    <title>Getsporty</title>
    <!-- title bar icon-->
    <!-- <link rel="icon" type="image/png" href="img/GS Icon1.png"> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CSS -->
    <script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link href="css/compiled.min.css" rel="stylesheet">
    <link href="css/social.css" rel="stylesheet">
   
    <style>
        .bg-skin-lp {
            background-image: url('https://mdbootstrap.com/img/Photos/Horizontal/Nature/full%20page/img%20%283%29.jpg'); 
            background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center center; 
            background-attachment: fixed;
        }.banner-img-wrap.animated.fadeInLeft {
    padding: 13% 0 0 0;
}
@font-face { font-family: GillSans; src: url('font/GillSans.ttf'); } 
    .cent{
        text-align: -webkit-center;
        }
     .btn-primary1:hover {
    background-color: #ffffff !important;
}
    </style>
     <link href="css/style.css" rel="stylesheet">

</head>

<body class="fixed-sn black-skin bg-skin-lp1" id="bdy">


</div>
        <div class="collapse navbar-collapse mob-nav" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navmob" >
             
               
                <li  class="nav-item last">
                    <a id="link-7" style="background-color:#fff; color:#03a9f4;" class="nav-link" href="javascript:void(0)" target="_blank" onclick="partner()">Register With Us!</a> 
                </li>     
                              
                </ul>
        </div>
<!-- 03A9F4 -DARKER
4FC3F7 - LIGHTER  -->
    <!--Double navigation-->
    <header>

        <!-- Navbar -->
        <nav class="navbar fixed-top navbar-toggleable-md navbar-dark scrolling-navbar double-nav">
            <!-- Breadcrumb-->
<div class="navbar-header trigger">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">

                    <img src="img/trigger.png" />
                </button>
            </div>       
            <ul class="navbar-nav mr-auto">
                <li class="">
                       <a class="nav-link navbar-brand" href="#bdy">
                            <div class="hj-logo"><img src="img/logo.png"></div>
                        </a>
                </li>                                
            </ul>           
            <ul class="nav navbar-nav ml-auto flex-row" >
               
                
                <li class="nav-item last">
                    <a id="link-7" style="background-color:#fff; color:#03a9f4;" class="nav-link" href="javascript:void(0)" onclick="partner()">Register With Us!</a>
                </li>                                   
            </ul>

           
                
        </nav>

    </header>
<div class="blog_body">
<div class="container">

<div class="panel panel-default panel1">
    <div class="panel-body" style="    display: -webkit-box;">
    <div style="padding:22px ;color:white;">Get our app!!
</div>
<ul>
<li style="position: absolute;
    right: 3%;">
<a class="btn btn-primary1" href="https://play.google.com/store/apps/details?id=getsportylite.darkhoprsesport.com.getsportylite&hl=en" style=" background-color: #ffffff;   margin-top: 10px;"><i class="fa fa-android" aria-hidden="true" style="color:#000;"></i><span style="color:#000;"> Download For Android</span><span class="glyphicon glyphicon-user"></span></a>
</li>
</ul>

    </div>
  </div>
<!-- toggle div-->

 


<?php 

   if($res[0]['token'] == 1 || $res[0]['token']  == 3)
{


 ?>
<div class="row panel3" id="detail">

<div class="col-md-12"> <h2 style="margin: 20px 0px"><?php echo $res[0]['title'];?></h2><img src="http://portal.getsporty.in/uploads/resources/<?php echo $res[0]['image'];?> " style="width: 100%;"><div class="col-md-12"><h4 style="margin: 20px 0px"><?php echo $res[0]['summary'];?></h4> <h5><?php echo $res[0]['description'];?></h5> </div>


 </div>
</div>

<?php } else { ?>
   


    <div class="row panel2" id="shared">

    <div class="col-md-6"> <img src="http://portal.getsporty.in/uploads/resources/<?php echo $res[0]['image'];?> " style="width: 100%;"> </div> <div class="col-md-6" style="height:300px;"> <h2><?php echo $res[0]['title'];?></h2> <h5><?php echo $res[0]['summary'];?></h5> <div class="bottombutton1"><a href="<?php echo $res[0]['url'];?>" class="btn btn-primary" target="_blank">Read More..</a></div> </div>
   


    </div>

    <?php } ?>
   
<div id="fixedsocial">

    <div class="fb-share-button" data-href="http://getsporty.in/blog.php?n=<?php echo $res[0]['id']; ?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">Share</a></div>
	
	
    <div class="twitterflat"><a href="https://twitter.com/share" class="twitter-share-button" data-size="large" data-text="<?php echo $res[0]['title']; ?>" data-url="http://getsporty.in/blog.php?n=<?php echo $res[0]['id']; ?>" data-show-count="false">Tweet</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script></div> 
	
	
	<div class="linkedinflat">
	<a href=" https://www.linkedin.com/shareArticle?mini=true&url=http://getsporty.in/blog.php?n=<?php echo $res[0]['id']; ?>&title=<?php echo $res[0]['title'];?>
&summary=<?php echo $res[0]['summary']; ?>&source=LinkedIn" ><i class="fa fa-linkedin-square" style="font-size:36px"></i></a>
	</div>


	 <div class="g-plusflat">
	 <script src="https://apis.google.com/js/platform.js" async defer></script>
     <!-- Place this tag where you want the share button to render. -->
     <div class="g-plus" data-action="share" data-height="24"></div> 
	</div>
	
	<div class="pin">
	<a data-pin-do="buttonPin" href="https://www.pinterest.com/pin/create/button/?url=http://getsporty.in/blog.php?n=<?php echo $res[0]['id']; ?>&media=http://getsporty.in/portal/uploads/resources/<?php echo $res[0]['image']; ?>&description=<?php echo $res[0]['title']; ?>" data-pin-config="beside"><img src="https://addons.opera.com/media/extensions/55/19155/1.1-rev1/icons/icon_64x64.png" width="25" height="25">

    </a>
	
	</div>
	

</div>
 

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.10";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<!-- <div class="fb-share-button" data-href="http://getsporty.in/blog.php?n=<?php //echo $res[0]['id']; ?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">Share</a></div>







<a href="https://twitter.com/share" class="twitter-share-button" data-size="large" data-text="<?php// echo $res[0]['title']; ?>" data-url="<?php// echo $res[0]['url'];?>" data-show-count="false">Tweet</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>



<script src="https://apis.google.com/js/platform.js" async defer></script>


<div class="g-plus" data-action="share" data-height="24"></div>
 -->



</div>
</div>

 <footer class="page-footer center-on-small-only">

        <!--Footer Links
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-3 offset-1">
                    <h5 class="title">Footer Content</h5>
                    <p>Here you can use rows and columns here to organize your footer content.</p>
                </div>

                <hr class="hidden-md-up">

                <div class="col-md-2 offset-1">
                    <h5 class="title">Links</h5>
                    <ul>
                        <li><a href="#!">Link 1</a></li>
                        <li><a href="#!">Link 2</a></li>
                        <li><a href="#!">Link 3</a></li>
                        <li><a href="#!">Link 4</a></li>
                    </ul>
                </div>

                <hr class="hidden-md-up">

                <div class="col-md-2">
                    <h5 class="title">Links</h5>
                    <ul>
                        <li><a href="#!">Link 1</a></li>
                        <li><a href="#!">Link 2</a></li>
                        <li><a href="#!">Link 3</a></li>
                        <li><a href="#!">Link 4</a></li>
                    </ul>
                </div>

                <hr class="hidden-md-up">

                <div class="col-md-2">
                    <h5 class="title">Links</h5>
                    <ul>
                        <li><a href="#!">Link 1</a></li>
                        <li><a href="#!">Link 2</a></li>
                        <li><a href="#!">Link 3</a></li>
                        <li><a href="#!">Link 4</a></li>
                    </ul>
                </div>

            </div>
        </div>
        <!--/.Footer Links-->


        <hr>
<div class="foot-logo"><img src="img/logo.png"></div>
        <!--Social buttons-->
        <div class="social-section">
            <ul>
                <li><a class="btn-floating btn-small btn-fb" target="_blank" href="https://www.facebook.com/getsportyindia/"><i class="fa fa-facebook" ></i></a></li>
                <li><a class="btn-floating btn-small btn-tw" target="_blank" href="https://twitter.com/GetSportyIndia"><i class="fa fa-twitter"> </i></a></li>
                <li><a class="btn-floating btn-small btn-linkedin" target="_blank" href="https://www.linkedin.com/company-beta/3746644/"><i class="fa fa-linkedin"> </i></a></li>
            </ul>
        </div>
        <!--/.Social buttons-->

        <!--Copyright-->
        <div class="footer-copyright" id ="Partner">
            <div class="container-fluid">
                © 2017 Copyright: <a href="#"> Design By    Dark Horse Sports </a>

            </div>
        </div>
        <!--/.Copyright-->

    </footer>
 <script type="text/javascript" src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/compiled.min.js"></script>
    
        <script type="text/javascript" src="js/modernizr.js"></script>
            <script type="text/javascript" src="js/main.min.js"></script>



<script type="text/javascript">
   
$(document).ready(function(){
     $.urlParam = function(name){
          var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
          return results[1] || 0;
          }
          var id =  $.urlParam('n');

          $.ajax({url: api_url+id+"",crossDomain: true ,
              success: function(result){
              var res_data = JSON.parse(result);
              res_data    = res_data.data;
             // alert(res_data[0].token);return;
              if(res_data[0].token == 1 || res_data[0].token == 3)
              {
              var detail = '<div class="col-md-12"> <h2 style="margin: 20px 0px">'+res_data[0].title+'</h2><img src="http://portal.getsporty.in/uploads/resources/'+res_data[0].image+'"style="width: 100%;"><div class="col-md-12"><h4 style="margin: 20px 0px">'+res_data[0].summary+'</h4> <h5>'+res_data[0].description+'</h5> </div>'; $('#shared').hide();$('#detail').html(detail); }else {
                var shared = '<div class="col-md-6"> <img src="http://portal.getsporty.in/uploads/resources/'+res_data[0].image+'"style="width: 100%;"> </div> <div class="col-md-6" style="height:300px;"> <h2>'+res_data[0].title+'</h2> <h5>'+res_data[0].summary+'</h5> <div class="bottombutton1"><a href="'+res_data[0].url+'" class="btn btn-primary" target="_blank">Read More..</a></div> </div> '; $('#detail').hide(); $('#shared').html(shared); 

            }
            $('meta[name="description"]').attr("content",res_data[0].summary+','+res_data[0].sport)
            $('meta[name="keywords"]').attr("content",res_data[0].title+','+res_data[0].sport)
         }});



    });   

function partner()
{
window.open('http://portal.getsporty.in/index.php/forms/new_registration/','_blank');
}
</script>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
    </body>
    </html>
