<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../application/conn.php");
$idgroundadmin = $_SESSION['idgroundadmin'];

$groundnamesql = mysql_query("Select * from tbl_ground where groundadmin='$idgroundadmin'");
$i=0;
while($row = mysql_fetch_assoc($groundnamesql))
{
   $groundadminarray[$i]['idground'] = $row['idground'];
   $groundadminarray[$i]['groundname'] = $row['groundname'];
   $i++;
}
$bookedseatsarray = array();
$bookedseat = mysql_query("Select idgroundcost from tbl_invoicedetails where status='Booked'");
$i=0;
while($row = mysql_fetch_assoc($bookedseat))
{
    $bookedseatsarray[$i] = $row['idgroundcost'];
	$i++;
}
print_r($bookedseatsarray);
$bookedseattemp = mysql_query("Select idgroundcost from tbl_tempseatblock");
while($row = mysql_fetch_assoc($bookedseattemp))
{
    $bookedseatsarray[$i] = $row['idgroundcost'];
	$i++;
}

if($_POST)
{
 //print_r($_POST);
   if(count($_POST['groundcost'])>0 && isset($_POST['groundcost']))
   {
      for($i=0;$i<count($_POST['groundcost']);$i++)
	  {
	      $idgroundcost = $_POST['groundcost'][$i];
		  $amount = $_POST['amount'][$i];
		   $upddate = date('Y-m-d H:i:s');
		   $idgroundadmin = $_SESSION['idgroundadmin'];
			 mysql_query("Update tbl_groundcost set amount='$amount', updateddate='$upddate',modifiedby='$idgroundadmin'
		              where idgroundcost='$idgroundcost'");
	  }

   }
   else
   {
	   $idground = $_POST['idground'];
	   $playdate = date('Y-m-d', strtotime($_POST['datepicker']));
	   $playdatesql = mysql_query("Select a.*,b.* 
								  from tbl_groundcost as a, tbl_groundtime as b
								  where a.idgroundtime=b.idgroundtime and a.idground='$idground' and a.playdate='$playdate'
								  and a.status='Active'");
								  $i=0;
	   while($row =  mysql_fetch_assoc($playdatesql))
	   {
			$playdatesqlarray[$i]['idgroundcost'] = $row['idgroundcost'];	
			$playdatesqlarray[$i]['amount'] = $row['amount'];
			$playdatesqlarray[$i]['idgroundtime'] = $row['idgroundtime'];
			$playdatesqlarray[$i]['fromtime'] = $row['fromtime'];
			$playdatesqlarray[$i]['totime'] = $row['totime'];
			$i++;
	   } 	
   }
}
 $sessionid = session_id();
   mysql_query("Delete from tbl_tempseatblock where sessionid='$sessionid'");

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Your Ground</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
	  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
      <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
      <script src='include.js' type='text/javascript'></script>
  <script>
$(function() {
	$( "#datepicker" ).datepicker();
	$( "#datepicker1" ).datepicker();
});
function showcalendar()
{
	$('#datepickepr').datepicker('show');
}

function fnreleaseseat(idgroundcost,type)
{
  var cnf = confirm('Do you really want to Release seat?');
  if(cnf==true)
  {
   $('#bookedslot'+idgroundcost).hide();
	   $('#availableslot'+idgroundcost).show();
	  formData='idgroundcost='+idgroundcost;   
		$.ajax({
		url : "ajax/ajax_releaseseatblock.php",
		type: "POST",
		data : formData,
		success: function(data, textStatus, jqXHR)
		{
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
	  
		}
	   });
   }
}


  </script>
  </head>

  <body>
<?php include('include/header.php');?>
    <div class="container mar-t30">    
                <div class="secondary-box clearfix mh500">
                <div class="pad-l20 pad-t5 pad-b5 brd-btm">
                   <h4 class="primary-title">Block Ground</h4>
                </div>
                <div class="clearfix pad-t20">                                    
                <form class="form-horizontal col-sm-6" name='' method='POST' action=''>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><span class="error-text">*</span>Ground</label>
                    <div class="col-sm-8">
                        <select class="form-control" name='idground' id='idground' >
		     <?php for($i=0;$i<count($groundadminarray);$i++){?>
                <option value='<?php echo $groundadminarray[$i]['idground'];?>' 
				<?php if($idground==$groundadminarray[$i]['idground']){echo "selected=selected";}?>>
				<?php echo $groundadminarray[$i]['groundname'];?></option>		
        <?php }?>	
                        </select>
                    </div>
                  </div>                                   
                          <div class="form-group">
                    <label class="col-sm-4 control-label"><span class="error-text">*</span>Date</label>
                    <div class="col-sm-8 pos-rel">
                      <input type="type" class="form-control" id="datepicker" name="datepicker" value='<?php echo $playdate;?>'>
					  <input type='hidden' name='displayform' id='displayform' value='0'>

                      <span class="date"></span>
                    </div>
                  </div>   
  <input type='submit' name='Save' id='Save' class="btn btn-primary pull-right" value='Search'>
                </form> 
                           
                </div>
                <div class="clearfix brd-top pad-t20 mar-t10">
                 <div class="row mar0">
				 
				 <?php for($i=0;$i<count($playdatesqlarray);$i++){
					$idgroundcost = $playdatesqlarray[$i]['idgroundcost'];?>
         
   <tr>
   
        <?php if(in_array($idgroundcost,$bookedseatsarray)){?>
           
		    <div class="form-group col-sm-2" id='bookedslot<?php echo $playdatesqlarray[$i]['idgroundcost'];?>'>
                    <label class="col-sm-7 control-label hpad5 font12 pad-t9"><?php echo $playdatesqlarray[$i]['fromtime'];?> - <?php echo $playdatesqlarray[$i]['totime'];?></label>
                    <div class="col-sm-5 hpad5">
                      <button type="button" class="slot slot-booked"  onclick='fnreleaseseat(<?php echo $playdatesqlarray[$i]['idgroundcost'];?>)';>Booked</button>
                    </div>                  
             </div>
			 <div class="form-group col-sm-2" id='availableslot<?php echo $playdatesqlarray[$i]['idgroundcost'];?>' style='display:none'>
                    <label class="col-sm-7 control-label hpad5 font12 pad-t9"><?php echo $playdatesqlarray[$i]['fromtime'];?> - <?php echo $playdatesqlarray[$i]['totime'];?></label>
                    <div class="col-sm-5 hpad5">
                      <button type="button" class="slot" id='amount[<?php echo $playdatesqlarray[$i]['idgroundcost'];?>]' name='amount[]' value='<?php echo $playdatesqlarray[$i]['amount'];?>'>Available</button>
                    </div>                  
                  </div>
		<?php } else if($playdatesqlarray[$i]['amount']<1){ ?>
		    <div class="form-group col-sm-2">
                    <label class="col-sm-7 control-label hpad5 font12 pad-t9"><?php echo $playdatesqlarray[$i]['fromtime'];?> - <?php echo $playdatesqlarray[$i]['totime'];?></label>
                    <div class="col-sm-5 hpad5">
                      <button type="button" class="slot slot-reserved">Reserved</button>
                    </div>                  
             </div>
		<?php } else {?>

	    <div class="form-group col-sm-2" id='availableslot<?php echo $playdatesqlarray[$i]['idgroundcost'];?>'>
                    <label class="col-sm-7 control-label hpad5 font12 pad-t9"><?php echo $playdatesqlarray[$i]['fromtime'];?> - <?php echo $playdatesqlarray[$i]['totime'];?></label>
                    <div class="col-sm-5 hpad5">
                      <button type="button" class="slot" id='amount[<?php echo $playdatesqlarray[$i]['idgroundcost'];?>]' name='amount[]' value='<?php echo $playdatesqlarray[$i]['amount'];?>'>Available</button>
                    </div>                  
                  </div>
				  
		
	   <?php }?>

  <?php }?>  
  
                                                    
                 </div>                
                               
                </div>                
                          
                <div class="clearfix brd-top pad-t20 mar-t10 mar-b20">
                    <button class="btn btn-default mar-l10 pull-right mar-r20">Cancel</button>                   
                    <button class="btn btn-primary pull-right">Update</button>                    
                </div>                                               
                </div>       
    </div>   

    <footer>
            <p>&copy; 2014 www.bookyourground.com All Rights Reserved</p>
    </footer>  
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
