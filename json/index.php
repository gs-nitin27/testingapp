<!doctype html>
<?php 
      //$host = "localhost";
	// $user = "root";
	//  $pass = "mysql";
	
	include 'config.php';
	
	 // $databaseName = "getsport_gs";
	 // $tableName = "gs_resources";
	
	  
	 // include 'DB.php';
	  // $con = mysql_connect($host,$user,$pass);
	  // $dbs = mysql_select_db($databaseName, $con);
	
	 // $databaseName = "getsport_gs";
	 // $tableName = "gs_resources";
	
	  // mysql_set_charset("UTF8");

	   $query = mysql_query("SELECT id,title,summary,image,token,url FROM `gs_resources` WHERE `status`= 1 ORDER BY date_created DESC limit 8" ); 
	 //  header('Content-type: text/html; charset=utf-8');
       
	  
	  
	  
	 

 ?>
 
 
<html lang="en" class="no-js">


<head>
    <meta charset="UTF-8">
    <title>getsporty</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="shortcut icon" href="gs.png">
    
    <!-- Bootstrap 3.3.2 -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/js/rs-plugin/css/settings.css">

    <link rel="stylesheet" href="assets/css/styles.css">


    <script type="text/javascript" src="assets/js/modernizr.custom.32033.js"></script>


<style> 


p {
    font-size: 90%;
}

#corner {
    padding:2px;
    border-radius: 10px;
	border: 4px solid #e5e5e5;
    width: 214px;
    height: 430px;    
}

#corner2 {
    border-radius: 20px;
    border: 1px solid #e5e5e5;
    padding: 10px; 
    width: 235px;
    height: 450px;    
}

</style>
	
</head>

<body>
    
    <div class="pre-loader">
        <div class="load-con">
            <img src="assets/img/freeze/logo.png" class="animated fadeInDown" alt="">
            <div class="spinner">
              <div class="bounce1"></div>
              <div class="bounce2"></div>
              <div class="bounce3"></div>
            </div>
        </div>
    </div>
   
    <header>
        
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="fa fa-bars fa-lg"></span>
                        </button>
                        <a class="navbar-brand" href="index.php">
                            <img src="assets/img/freeze/logo.png" alt="" class="logo">
                        </a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="#about">about</a>
                            </li>
                            <li><a href="#features">Know About</a>
                            </li>
                          <!--  <li><a href="#reviews">reviews</a>
                            </li>  -->
                            <li><a href="#screens">Latest News</a>
                            </li>
                            <li><a class="getApp" href="#getApp">get app</a>
                            </li>
                            <li><a href="#support">support</a>
                            </li>
							<li><a href="http://getsportyportal.getsporty.in/">Login</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.container-->
        </nav>

        
        <!--RevSlider-->
        <div class="tp-banner-container">
            <div class="tp-banner" >
                <ul>
                    <!-- SLIDE  -->
                    <li data-transition="fade" data-slotamount="7" data-masterspeed="1500" >
                        <!-- MAIN IMAGE -->
                        <img src="assets/img/transparent.png"  alt="slidebg1"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">
                        <!-- LAYERS -->
                        <!-- LAYER NR. 1 -->
                        <div class="tp-caption lfl fadeout hidden-xs"
                            data-x="left"
                            data-y="bottom"
                            data-hoffset="30"
                            data-voffset="0"
                            data-speed="500"
                            data-start="700"
                            data-easing="Power4.easeOut">
                            <img src="assets/img/freeze/Slides/hand-freeze.png" alt="">
                        </div>

                        <div class="tp-caption lfl fadeout visible-xs"
                            data-x="left"
                            data-y="center"
                            data-hoffset="700"
                            data-voffset="0"
                            data-speed="500"
                            data-start="700"
                            data-easing="Power4.easeOut">
                            <img src="assets/img/freeze/iphone-freeze.png" alt="">
                        </div>

                        <div class="tp-caption large_white_bold sft" data-x="550" data-y="center" data-hoffset="0" data-voffset="-80" data-speed="500" data-start="1200" data-easing="Power4.easeOut">
                           
                        </div>
                        <div class="tp-caption large_white_light sfr" data-x="770" data-y="center" data-hoffset="0" data-voffset="-80" data-speed="500" data-start="1400" data-easing="Power4.easeOut">
                          Your Sports 
                        </div>
                        <div class="tp-caption large_white_light sfb" data-x="550" data-y="center" data-hoffset="0" data-voffset="0" data-speed="1000" data-start="1500" data-easing="Power4.easeOut">
                           "Partner" in Making
                        </div>

                        <div class="tp-caption sfb hidden-xs" data-x="550" data-y="center" data-hoffset="0" data-voffset="85" data-speed="1000" data-start="1700" data-easing="Power4.easeOut">
                            <a href="#about" class="btn btn-primary inverse btn-lg">LEARN MORE</a>
                        </div>
                        <div class="tp-caption sfr hidden-xs" data-x="730" data-y="center" data-hoffset="0" data-voffset="85" data-speed="1500" data-start="1900" data-easing="Power4.easeOut">
                            <a href="#getApp" class="btn btn-default btn-lg">GET APP</a>
                        </div>

                    </li>
                   
                    
                </ul>
            </div>
        </div>


    </header>


    <div class="wrapper">

        

        <section id="features">
            <div class="container">
                <div class="section-heading scrollpoint sp-effect3">
                    <h1>Know About</h1>
                    <div class="divider"></div>
                    <p>Learn more about this feature packed App</p>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4 scrollpoint sp-effect1">
                        <div class="media text-right feature">
                            <a class="pull-right" href="#">
                                <i class="fa fa-calendar fa-2x"></i>
                            </a>
                            <div class="media-body">
                                <h3 class="media-heading">Events</h3>
                                like camps, seminars, clinics.
                            </div>
                        </div>
                        <div class="media text-right feature">
                            <a class="pull-right" href="#">
                                <i class="fa fa-trophy fa-2x"></i>
                            </a>
                            <div class="media-body">
                                <h3 class="media-heading">Tournaments</h3>
                                Competition organised by sports bodies.
                            </div>
                        </div>
                        <div class="media text-right feature">
                            <a class="pull-right" href="#">
                                <i class="fa fa-certificate fa-2x"></i>
                            </a>
                            <div class="media-body">
                                <h3 class="media-heading">Exams & Certification </h3>
                                for courses in sports field.
                            </div>
                        </div>
                        <div class="media text-right feature">
                            <a class="pull-right" href="#">
                                <i class="fa fa-briefcase fa-2x"></i>
                            </a>
                            <div class="media-body">
                                <h3 class="media-heading">Jobs</h3>
                                in field of sport.
                            </div>
                        </div>
                    <div class="media text-right feature">
                            <a class="pull-right" href="#">
                                <i class="fa fa-book fa-2x"></i>
                            </a>
                            <div class="media-body">
                                <h3 class="media-heading">Generic info</h3>
                                 about Indian Sports.
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-4 col-sm-4" >
                        <img src="assets/img/freeze/iphone-freeze.png" class="img-responsive scrollpoint sp-effect5" alt="">
                    </div>
                    <div class="col-md-4 col-sm-4 scrollpoint sp-effect2">
                        <div class="media feature">
                            <a class="pull-left" href="#">
                                <i class="fa fa-user fa-2x"></i>
                            </a>
                            <div class="media-body">
                                <h3 class="media-heading">Upcoming Athletes </h3>
                                and other sports people.
                            </div>
                        </div>
                        <div class="media feature">
                            <a class="pull-left" href="#">
                                <i class="fa fa-list-alt fa-2x"></i>
                            </a>
                            <div class="media-body">
                                <h3 class="media-heading">News Articles</h3>
                               about domestic sports scene.
                            </div>
                        </div>
                        <div class="media feature">
                            <a class="pull-left" href="#">
                                <i class="fa fa-search-plus fa-2x"></i>
                            </a>
                            <div class="media-body">
                                <h3 class="media-heading">Analysis</h3>
                                done by experts.
                            </div>
                        </div>
                        <div class="media feature">
                            <a class="pull-left" href="#">
                                <i class="fa fa-video-camera fa-2x"></i>
                            </a>
                            <div class="media-body">
                                <h3 class="media-heading">Training videos</h3>
                               for best sports learning.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="screens">
            <div class="container" id="latestnews">
                <div class="section-heading scrollpoint sp-effect3">
                    <h1>Latest New</h1>
                    <div class="divider"></div>
                    <p>See what’s included in the App</p>
                </div>
                <div class="slider filtering scrollpoint sp-effect5" >
				
				 <?php
                         while($array = mysql_fetch_row($query))                            
		                  {
							$i=0;
			                $test[$i]=$array; 
		                   
						   
							
				            ?>
				 
				   <div class="one">
				   <div id="corner2">
				   <div id="corner" >		  
				   <div><img src="http://getsportyportal.getsporty.in/uploads/resources/<?php echo $test[$i][3]; ?>" alt=""  style=" width:200px ;height:115px;" ></div>
				   
				    <div><p><b><?php echo $test[$i][1];?></b></p>
				    </div>
				    <div>
				    <p><?php echo $test[$i][2];?></p>
					<div>
					<?php 
					if($test[$i][4]==1) 
					{
						$id=$test[$i][0];
					print "<a href='blog.php?id=$id' target='_blank' >continue reading.</a>";
					
					}
					 else{
					  ?>	  
				        <a  href="<?php echo $test[$i][5];?>"  target="_blank">continue reading.</a>		 
					 <?php }  ?>
				   </div>
                   </div>
                   </div>
                    </div>
					</div>
					  <?php  
					$i++;}?>
                </div>
            </div>
        </section>

		

        <section id="getApp">
            <div class="container-fluid">
                <div class="section-heading inverse scrollpoint sp-effect3">
                    <h1>Get App</h1>
                    <div class="divider"></div>
                    <p>Choose your native platform and get started!</p>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="hanging-phone scrollpoint sp-effect2 hidden-xs" style="margin-right:100px;">
                            <img src="assets/img/freeze/freeze-angled2.png" alt="">
                        </div>
                        <div class="platforms">
                            <a href="https://play.google.com/store/apps/details?id=getsportylite.darkhoprsesport.com.getsportylite&hl=en"  class="btn btn-primary inverse scrollpoint sp-effect1">
                                <i class="fa fa-android fa-3x pull-left"></i>
                                <span>Download for</span><br>
                                <b>Android</b>
                            </a>
                            
                               <!-- <a href="#" class="btn btn-primary inverse scrollpoint sp-effect2">
                                    <i class="fa fa-apple fa-3x pull-left"></i>
                                    <span>Download for</span><br>
                                    <b>Apple IOS</b>
                                </a>  -->
                        </div>

                    </div>
                </div>

                

            </div>
        </section>
		
		
		
        <section id="about">
            <div class="container">
                
                <div class="section-heading scrollpoint sp-effect3">
                    <h1>About Us</h1>
                    <div class="divider"></div>
                    <p></p>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="about-item scrollpoint sp-effect2">
                            <i class="fa fa-info fa-2x"></i>
                            <h3>Get The Info</h3>
                            <p>Get all the info about domestic sports scene in India at one place. We curate the info and link it to you.</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6" >
                        <div class="about-item scrollpoint sp-effect5">
                            <i class="fa fa-search fa-2x"></i>
                            <h3>Search</h3>
                            <p>Search for required information events, tournaments, happenings, people, success stories in the field of sports.</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6" >
                        <div class="about-item scrollpoint sp-effect5">
                            <i class="fa fa-users fa-2x"></i>
                            <h3>Subscribe</h3>
                            <p>Subscribe for our Alert Messaging service and get the required information in form of alerts.</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-6" >
                        <div class="about-item scrollpoint sp-effect1">
                            <i class="fa fa-list fa-2x"></i>
                            <h3>Create</h3>
                            <p>Help us in creating content by subscribing to our Create feature (this feature will be launched shortly).</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

		
		

        <section id="support" class="doublediagonal">
            <div class="container">
                <div class="section-heading scrollpoint sp-effect3">
                    <h1>Support</h1>
                    <div class="divider"></div>
                    <p>For more info and support, contact us!</p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-8 col-sm-8 scrollpoint sp-effect1">
                               							
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Your name">
                                    </div>
                                    <div class="form-group">
                                        <!-- input type="email" class="form-control" placeholder="Your email"> -->
                                         <input type="text" class="form-control" placeholder="Your email" name="name" id="email"/>
										         
                                    </div>
                                    <div class="form-group">
                                        <textarea cols="30" rows="10" class="form-control" placeholder="Your message"></textarea>
                                    </div>
									
									
									
                                    <button type="submit" id="save" onclick="saveEmail()" class="btn btn-primary btn-lg">Submit</button>
                                
                            </div>
                            <div class="col-md-4 col-sm-4 contact-details scrollpoint sp-effect2">
                                <div class="media">
                                    <a class="pull-left" href="#" >
                                        <i class="fa fa-map-marker fa-2x"></i>
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading">A 29, Sector 7, Noida, India ,201301</h4>
                                    </div>
                                </div>
                                <div class="media">
                                    <a class="pull-left" href="#" >
                                        <i class="fa fa-envelope fa-2x"></i>
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <a href="mailto:support@dhs.in">info@darkhorsesports.in</a>
                                        </h4>
                                    </div>
                                </div>
                                <div class="media">
                                    <a class="pull-left" href="#" >
                                        <i class="fa fa-phone fa-2x"></i>
                                    </a>
                                    <div class="media-body">
                                        <h4 class="media-heading">+91 120 4081135</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <div class="container"><div>
			   
				
                <a href="index.php" class="scrollpoint sp-effect3">
                    <img src="assets/img/freeze/logo.png" alt="" class="logo">
                </a>
                <div class="social">
                    <a href="#" class="scrollpoint sp-effect3"><i class="fa fa-twitter fa-lg"></i></a>
                    <a href="#" class="scrollpoint sp-effect3"><i class="fa fa-google-plus fa-lg"></i></a>
                    <a href="#" class="scrollpoint sp-effect3"><i class="fa fa-facebook fa-lg"></i></a>
                </div>
                <div class="rights">
                    <p>Copyright &copy; 2016</p>
                    <p>Design By &nbsp; &nbsp;<a href="#"><b>Dark Horse Sports</b></a></p>
                </div>
				</div>
            </div>
        </footer>

        

    </div>
    <script src="assets/js/jquery-1.11.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/placeholdem.min.js"></script>
    <script src="assets/js/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
    <script src="assets/js/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script>
        $(document).ready(function() {
            appMaster.preLoader();
        });
    </script>


<script >
function saveEmail()
{

var email = $('#email').val();

$.ajax({

url:'welcome.php',
method:'POST',
data:'act=sendEmail&email='+email,
datatype:"json",
success:function(data)
{
var data = JSON.parse(data);
if(data.status == 0)
{
alert(data.message);
$('#email').val('');

}
else{
 
//alert("Thanks For contacting us!");
alert(data.message);
$('#email').val('');


}



}
})

}

</script>

<!--
<script id="source" language="javascript" type="text/javascript">

  $(function () 
  {
    //-----------------------------------
    // 2) Send a http request with AJAX 
    //------------------------------------
    $.ajax({                                      
      url: 'next.php',        //the script to call to get data          
      data: "",//you can insert url arguments here to pass to api.php
      dataType: 'json',        //data format      
      success: function(data)    //on recieve of reply
      { 
	    
        var pos0  =data[0][0];   //get position 1 data from returned array
        var pos01 =data[0][1];  
        var pos02 =data[0][2];  
        var pos03 =data[0][3];  
        var pos05 =data[0][4];  
        var pos06 =data[0][5];  
		
		
        var pos1  =data[1][0];    
        var pos12 =data[1][1];   
        var pos13 =data[1][2];   
        var pos14 =data[1][3];
        var pos15 =data[1][4];
        var pos16 =data[1][5];
		
		
	    var pos2  =data[2][0];       
	    var pos22 =data[2][1];       
	    var pos23 =data[2][2];       
	    var pos24 =data[2][3];
	    var pos25 =data[2][4];
	    var pos26 =data[2][5];
		
		
	    var pos3  =data[3][0];      
	    var pos32 =data[3][1];      
	    var pos33 =data[3][2];      
	    var pos34 =data[3][3]; 
	    var pos35 =data[3][4]; 
	    var pos36 =data[3][5]; 
		
		
	    var pos4  =data[4][0];       
	    var pos42 =data[4][1];      
	    var pos43 =data[4][2];      
	    var pos44 =data[4][3];
	    var pos45 =data[4][4];
	    var pos46 =data[4][5];
		
		
	    var pos5  =data[5][0];       
	    var pos52 =data[5][1];      
	    var pos53 =data[5][2];      
	    var pos54 =data[5][3];  
	    var pos55 =data[5][4];  
	    var pos56 =data[5][5];  
		
		
	    var pos6  =data[6][0];      
	    var pos62 =data[6][1];      
	    var pos63 =data[6][2];      
	    var pos64 =data[6][3]; 
	    var pos65 =data[6][4]; 
	    var pos66 =data[6][5]; 
		
		
	    var pos7  =data[7][0];      
	    var pos72 =data[7][1];      
	    var pos73 =data[7][2];      
	    var pos74 =data[7][3];      
	    var pos75 =data[7][4];      
	    var pos76 =data[7][5];      
  
        // Update html content
		        

	 //Set output element html: 
     $('#1').html("<b>"+pos01.toString()+"</b>");
     $('#12').html(pos02.toString()); 
	 $('#13').attr('src', "staging/assets/crop/"+pos03);
	 $('#18').click(function()
	 {
	      if(pos05==1)
		  {
		  window.location='blog.php?id='+pos0;
		  }
		  else{
		  window.location.href=pos06;
		  }
	 });
	
	 
     $('#2').html("<b>"+pos12.toString()+"</b>");
     $('#22').html(pos13.toString()); 
	 $('#23').attr('src', "staging/assets/crop/"+pos14);
    $('#28').click(function()
     {
             //blogdata(pos1);  
        if(pos15==1)
		  {
           window.location='blog.php?id='+pos1;  
		  }
		  else{
		     window.location.href=pos16;

			} 
                
     });
	 
     $('#3').html("<b>"+pos22.toString()+"</b>");
     $('#32').html(pos23.toString());
	 $('#33').attr('src', "staging/assets/crop/"+pos24);
    $('#38').click(function()
     {
	 
	     if(pos25==1)
		  {
           window.location='blog.php?id='+pos2;
		  }
		  else{
		     window.location.href=pos26;

			} 
         
     });

	 
     $('#4').html("<b>"+pos32.toString()+"</b>");
     $('#42').html(pos33.toString());
	 $('#43').attr('src', "staging/assets/crop/"+pos34);
    $('#48').click(function()
     {
	   if(pos35==1)
		  {
           window.location='blog.php?id='+pos3;
		  }
		  else{
		     window.location.href=pos36;

			} 
          
     });
	 
     $('#5').html("<b>"+pos42.toString()+"</b>");
     $('#52').html(pos43.toString());
	 $('#53').attr('src', "staging/assets/crop/"+pos44);
    $('#58').click(function()
     {
	   if(pos25==1)
		  {
           window.location='blog.php?id='+pos4;
		  }
		  else{
		     window.location.href=pos46;

			} 
          
     });
	 
     $('#6').html("<b>"+pos52.toString()+"</b>");
     $('#62').html(pos53.toString());
	 $('#63').attr('src', "staging/assets/crop/"+pos54);
    $('#68').click(function()
     {
	  if(pos25==1)
		  {
            window.location='blog.php?id='+pos5;
		  }
		  else{
		     window.location.href=pos56;

			} 
         
     });
	 
     $('#7').html("<b>"+pos62.toString()+"</b>");
     $('#72').html(pos63.toString());
	 $('#73').attr('src', "staging/assets/crop/"+pos64);
    $('#78').click(function()
     {
	 if(pos25==1)
		  {
            window.location='blog.php?id='+pos6;
		  }
		  else{
		     window.location.href=pos66;

			} 
         
     });
	 
     $('#8').html("<b>"+pos72.toString()+"</b>");
     $('#82').html(pos73.toString());
	 $('#83').attr('src', "staging/assets/crop/"+pos74);
    $('#88').click(function()
     {
	    if(pos25==1)
		  {
           window.location='blog.php?id='+pos7;
		  }
		  else{
		     window.location.href=pos76;

			} 
          
     });
	 
      }
    });
  }); 

  
  
//   function blogdata(id) {
//     $.ajax({
//         url: 'blog.php',
//         type: 'post',
//         data: "id="+id,
//         dataType:"JSON",
//         success: function(data) {   
//             window.open("blog.php");
//             //window.location.href ="blog.php";
        
//         }
//     });
//     //  window.location.href ="blog.php/blog(data)";
// };
  </script>
  -->
</body>
</html>