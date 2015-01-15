<?php
error_reporting(0);
include("application/conn.php");

$resultgroundlocationsql = mysql_query("Select * from tbl_location");
$s=0;
while ($row = mysql_fetch_assoc($resultgroundlocationsql)) {
  $arraylocation[$s]["idlocation"]	= $row["idlocation"];
  $arraylocation[$s]["locationname"]	= $row["locationname"];
  $s++;  
}

$sportsql = mysql_query("Select * from tbl_sport");
$s=0;
while ($row = mysql_fetch_assoc($sportsql)) {
  $arraysport[$s]["idsport"]	= $row["idsport"];
  $arraysport[$s]["sportname"]	= $row["sportname"];
  $s++;  
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Your Ground</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
$(function() {
    $( "#datepicker1" ).datepicker({minDate: "+13D", maxDate: "+2M +1D" });
	 
});
function fnviewcalendar()
{
 $('#dp').datepicker('show');
}
function viewgrounddetails()
{
  var idlocation = $('#idlocation').val();
  var datepickervalue = $('#datepicker1').val();
  var idsport = $('#idsport').val();
  if(datepickervalue=='')
  {
     $('#dp').datepicker('show');
  }
  else
  {
  parent.location='viewgrounds.php?idlocation='+idlocation+'&datepicker='+datepickervalue+'&idsport='+idsport;
  }
}
  </script>
  </head>

  <body>
   <?php include('include/header.php');?>
    <section class="banner">
        <div id="carousel-example-generic" class="carousel slide carousel-fade home-banner" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
          </ol>

          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            <div class="item active">
              <img src="img/banner1.jpg" />
            </div>
            <div class="item">
              <img src="img/banner2.jpg" />
            </div>
            <div class="item">
              <img src="img/banner3.jpg" />
            </div>                    
          </div>
        </div>
        <div class="container banner-inner">
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <h1 class="txtc white-color banner-title font-l pad-sm-t60 font34-xs">Eat &rarr; Play &rarr; Sleep &rarr; Repeat</h1>
                    <p class="txtc white-color col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">Now booking a playground in Bangalore is super-easy, just a few clicks here and get ready to play...</p>
                <form class="form-inline sm-txtc" role="form">
                 <div class="home-search-box mar-t20">
                  <div class="form-group">
                    <label class="sr-only">Choose Your Location</label>
                    <select class="form-control"name='idlocation' id='idlocation'>
		      <?php for($i=0;$i<count($arraylocation);$i++){?>
			    <option value='<?php echo $arraylocation[$i]['idlocation'];?>'><?php echo $arraylocation[$i]['locationname'];?></option>
			  <?php }?>
		    </select>
                  </div>
                  <div class="form-group">
                    <label class="sr-only">Choose Your Sport</label>
                    <select class="form-control"  name='idsport' id='idsport'>
		      <?php for($i=0;$i<count($arraysport);$i++){?>
			    <option value='<?php echo $arraysport[$i]['idsport'];?>'><?php echo $arraysport[$i]['sportname'];?></option>
			  <?php }?>
		    </select>
                  </div>
                  
                 

                  <div class="form-group">
                    <label class="sr-only">Choose Date</label>
                    <div class="pos-rel">
                    <input type="text" class="form-control" placeholder="Choose Date"  id="datepicker1" name="datepicker1" >
                    <span class="date date-home" onclick='fnviewcalendar()' id="dp"></span>
                    </div>
                  </div>                                    

                  <button type="button" class="btn btn-primary" onclick='viewgrounddetails();'>SEARCH</button>
                  
                  </div>
                  
                </form>   
                            
                </div>
            </div>
        </div>    
    </section> <!--/ Banner Ends Here -->
    
    <section class="container">
       <div class="txtc col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3">
        <h1 class="font-l large-title secondary-color pad-t20">Our Ground Locations</h1>
        <p>We are expanding our network of playgrounds and playcourts in Bangalore and other cities.</p>
        <p>Pretty soon, we will be in your neighbourhood helping you to book and play Football, Cricket, Tennis, Badminton, Table Tennis, Swimming , Snooker and many more…</p>
        <p>Keep watching this space for our new playgrounds and courts.</p>
        </div>
        <div class="clearfix txtc">
        <div class="col-sm-4 pad-t40">
            <img src="img/callout_icon1.png" />
            <p class="pad-t20">Want to try out some new tricks after watching yesterday’s EPL ? Craving to catch up with some old
friends over a game of football ? Hungry to play your heart out and  shed some calories?</p>
       <p>Reasons are a lot –no more hassles of booking a football ground now. Just click !</p>
        </div>
        <div class="col-sm-4 pad-t40">
            <img src="img/callout_icon2.png" />
            <p class="pad-t20">Hit the ball hard and see them flying around the pitch, take a low catch, or uproot the stumps. Call your colleagues for a game of cricket. Enjoy a game and get some good exercise too.</p>
            <p>Reasons are a lot –no more hassles of booking a cricket ground now. Just click !</p>
        </div>
        <div class="col-sm-4 pad-t40">
            <img src="img/callout_icon3.png" />
              <p class="pad-t20">Make your buddy run around the court, try a shot like fedex or try out a Nadalish top spin. Time to catch up with a tennis buddy ? Enjoy a game and get some good exercise too.</p>
       <p>Reasons are a lot –no more hassles of booking a tennis court now. Just click !</p>
        </div>        
        </div>
       <div class="txtc col-sm-10 col-sm-offset-1 col-md-6 col-md-offset-3 pad-t40">
        <img src="img/testimonial_icon.png" class="mar-b10" />        
        <p class="font-italic">Really appreciate the efforts you are making to ensure that your customers are satisfied. The experience was just beyond amazing</p>
        <p class="pad-t10"><a href="#">- Johns George</a></p>
        </div>                       
    </section>
    
<?php include('include/footer.php');?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
