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


$_SESSION['idlocation'] = $_GET['idlocation'];
$_SESSION['datepicker'] = $_GET['datepicker'];
 $sessionid = session_id();
   mysql_query("Delete from tbl_tempseatblock where sessionid='$sessionid'");
//exit;
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
    $( "#datepicker1" ).datepicker({minDate: "+0D", maxDate: "+0M +22D" });
	var idlocation = '<?php echo $_GET['idlocation'];?>';
	var datepicker = '<?php echo $_GET['datepicker'];?>';
	var idsport = '<?php echo $_GET['idsport'];?>';
	formData='idlocation='+idlocation+'&datepicker='+datepicker+'&idsport='+idsport;   
	$.ajax({
		url : "ajax/ajax_viewgrounddetails.php",
		type: "POST",
		data : formData,
		success: function(data, textStatus, jqXHR)
		{
		  
		    $('#grounddetails').html(data);
			
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
	     
		}
	});
});

function fnviewcalendar()
{
 $('#dp').datepicker('show');
}

function functionviewslot(idgrounds)
{

   $.ajax({
		url : "ajax/ajax_deletesessions.php",
		type: "POST",
		data : formData,
		success: function(data, textStatus, jqXHR)
		{
		
			formData='idgrounds='+idgrounds;   
		   $.ajax({
				url : "ajax/ajax_viewgroundseats.php",
				type: "POST",
				data : formData,
				success: function(data, textStatus, jqXHR)
				{
					//alert(data);
					$('.groundviewseats').hide();
					$('#viewseats'+idgrounds).show();
					$('#viewseats'+idgrounds).html(data);
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
				 
				}
			});
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
	     
		}
	});
	
	

}
function fnbookslot(idgroundcost,type,idground)
{
    if(type==1)
	{

	   formData='idgroundcost='+idgroundcost+'&type='+type;   
	   $.ajax({
			url : "ajax/ajax_validateseatblock.php",
			type: "POST",
			data : formData,
			success: function(data, textStatus, jqXHR)
			{
				if(data!=0){
				   	$('#bookedslot'+idgroundcost).show();
	                $('#availableslot'+idgroundcost).hide();
				   alert('Sorry these seats has been booked,just a minute ago');
				} else {
				   	$('#completedslot'+idgroundcost).show();
	                $('#availableslot'+idgroundcost).hide();
					fnblockseat(idgroundcost,type,idground);
					var displayform = $("#displayform").val();
					var cnt = parseInt(displayform) + parseInt(1);
					$("#displayform").val(cnt);
					if(parseInt(cnt)!=0)
					{
					  $('#viewdisplayform').show();
					}
				}
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
		  
			}
	   });
	    
	}
	else{
		
		   $('#completedslot'+idgroundcost).hide();
		   $('#availableslot'+idgroundcost).show();
		   fnblockseat(idgroundcost,type,idground);
		   var displayform = $("#displayform").val();
			var cnt = parseInt(displayform) - parseInt(1);
			$("#displayform").val(cnt);
			if(parseInt(cnt)==0)
			{
			  $('#viewdisplayform').hide();
			}
		
	}

	
}

function fnblockseat(idgroundcost,type,idground)
{
  
  formData='idgroundcost='+idgroundcost+'&type='+type;   
	$.ajax({
		url : "ajax/ajax_tempseatblock.php",
		type: "POST",
		data : formData,
		success: function(data, textStatus, jqXHR)
		{
			 $('#paymentdisplay'+idground).html(data);
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
	  
		}
   });

}

function registerpage()
{
   parent.location='registerdetails.php';
}
function viewgrounddetails()
{
  var idlocation = $('#idlocation').val();
  var datepickervalue = $('#datepicker1').val();
  var idsport = $('#idsport').val();
  parent.location='viewgrounds.php?idlocation='+idlocation+'&datepicker='+datepickervalue+'&idsport='+idsport;
}
  </script>
  </head>

  <body>
   <?php include('include/header.php');?>
       <section class="primary-box">
           <div class="container">
            <form class="form-inline" role="form">
             
            <div class="pad-t10 pad-b10">
              <div class="form-group">
                <label class="sr-only">Choose Your Sport</label>
                <select class="form-control" name='idsport' id='idsport'>
		      <?php for($i=0;$i<count($arraysport);$i++){?>
			    <option value='<?php echo $arraysport[$i]['idsport'];?>'
				<?php if($_GET['idsport']==$arraysport[$i]['idsport'])
				{
				   echo "selected=selected";
				}
				else{
				}
				?>
				><?php echo $arraysport[$i]['sportname'];?></option>
			  <?php }?>
		    </select>
              </div>

              <div class="form-group">
                <label class="sr-only">Choose Your Location</label>
                <select <select class="form-control"name='idlocation' id='idlocation'>
		      <?php for($i=0;$i<count($arraylocation);$i++){?>
			    <option value='<?php echo $arraylocation[$i]['idlocation'];?>'
				<?php if($_SESSION['idlocation']==$arraylocation[$i]['idlocation'])
				{
				   echo "selected=selected";
				}
				else{
				}?>><?php echo $arraylocation[$i]['locationname'];?></option>
			  <?php }?>
		    </select>
              </div>

              <div class="form-group">
                <label class="sr-only">Choose Date</label>
                <div class="pos-rel">
                 <input type="text" class="form-control" placeholder="Choose Date"  id="datepicker1" name="datepicker1" value="<?php echo $_GET['datepicker'];?>">
                    <span class="date date-view" onclick='fnviewcalendar()' id="dp"></span>
                </div>
              </div>                                    

              <button type="button" class="btn btn-primary" onclick='viewgrounddetails()'>Search</button>  

              
              </div>            

            </form>                         
           </div>
       </section>
      <div id='grounddetails'></div> 
    
  <?php include('include/footer.php');?> 
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>