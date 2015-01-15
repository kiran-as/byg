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

$bookedseattemp = mysql_query("Select idgroundcost from tbl_tempseatblock");
while($row = mysql_fetch_assoc($bookedseattemp))
{
    $bookedseatsarray[$i] = $row['idgroundcost'];
	$i++;
}

if($_POST)
{
	
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

	   $playdatesql = mysql_query("Select a.idgroundcost,a.amount,b.fromtime,b.totime,b.idgroundtime,a.idground,a.playdate,a.status 
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
				   alert('Sorry, that slot just got booked a second ago');
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
function fnblockseat(idgroundcost,type)
{
  
  formData='idgroundcost='+idgroundcost+'&type='+type;   
	$.ajax({
	url : "ajax/ajax_tempseatblock.php",
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
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function updatecandidateaddress(idgroundcost,type)
{
  var email = $('#email').val();
  var phone = $('#phoneno').val();
  var name = $('#name').val();
  flag=0;
  if(name=='')
  {
     alert('Plese Enter Username');
	 flag=1;
  }
  if(email=='' && flag==0)
  {
     alert('Plese Enter email');
	 flag=1;
  }
  if(email!='')
  {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{1,4})?$/;
		if( !emailReg.test( email ) ) {
		   alert('Please enter proper email address');
		   $('#email').focus();
		   flag=1;
		   }
  }
  if(flag==0 && phone=='')
  {
     alert('Please enter the phone no');
	 flag=1;
  }
  if(flag==0 && phone.length!=10)
  {
      alert('Please Enter 10 digit mobile number');
	  flag=1;
  }
  
  if(flag==0)
  {
		  formData='email='+email+'&phone='+phone+'&name='+name;   
			$.ajax({
			url : "ajax/ajax_seatadd.php",
			type: "POST",
			data : formData,
			success: function(data, textStatus, jqXHR)
			{   
				  alert('Seats has been blocked');
				  parent.location='groundadminblockseat.php';
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
         
   
   
        <?php if(in_array($idgroundcost,$bookedseatsarray)){?>
           
		    <div class="form-group col-sm-2">
                    <label class="col-sm-7 control-label hpad5 font12 pad-t9"><?php echo $playdatesqlarray[$i]['fromtime'];?> - <?php echo $playdatesqlarray[$i]['totime'];?></label>
                    <div class="col-sm-5 hpad5">
                      <button type="button" class="slot slot-booked">Booked</button>
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
                      <button type="button" class="slot" id='amount[<?php echo $playdatesqlarray[$i]['idgroundcost'];?>]' name='amount[]' value='<?php echo $playdatesqlarray[$i]['amount'];?>' onclick="fnbookslot('<?php echo $playdatesqlarray[$i]['idgroundcost'];?>','1')";>Available</button>
                    </div>                  
                  </div>
				  
		 <div class="form-group col-sm-2" id='completedslot<?php echo $playdatesqlarray[$i]['idgroundcost'];?>' style='display:none'>
                    <label class="col-sm-7 control-label hpad5 font12 pad-t9"><?php echo $playdatesqlarray[$i]['fromtime'];?> - <?php echo $playdatesqlarray[$i]['totime'];?></label>
                    <div class="col-sm-5 hpad5">
                      <button type="button" class="slot slot-selected" id='amount[<?php echo $playdatesqlarray[$i]['idgroundcost'];?>]' name='amount[]' value='<?php echo $playdatesqlarray[$i]['amount'];?>' onclick="fnbookslot('<?php echo $playdatesqlarray[$i]['idgroundcost'];?>','2')";>Selected</button>
                    </div>                  
                  </div>		  
	  
	       <div class="form-group col-sm-2" id='bookedslot<?php echo $playdatesqlarray[$i]['idgroundcost'];?>' style='display:none'>
                    <label class="col-sm-7 control-label hpad5 font12 pad-t9"><?php echo $playdatesqlarray[$i]['fromtime'];?> - <?php echo $playdatesqlarray[$i]['totime'];?></label>
                    <div class="col-sm-5 hpad5">
<button type="button" class="slot slot-booked">Booked</button>                    </div>                  
                  </div>	
	   <?php }?>

  <?php }?>  
  
                                                    
                 </div>                
                               
                </div>                
                <div class="clearfix brd-top pad-t20 mar-t10" id='viewdisplayform' style='display:none'>
                    <form class="form-horizontal col-sm-6" role="form">                  
                      <div class="form-group">
                        <label class="col-sm-4 control-label"><span class="error-text">*</span>User Name</label>
                        <div class="col-sm-8">
                            <input type="text" name='name' id='name' class="form-control"/>
                        </div>
                      </div>      
                      <div class="form-group">
                        <label class="col-sm-4 control-label"><span class="error-text">*</span>Email Adress</label>
                        <div class="col-sm-8">
                            <input type="email" name='email' id='email' class="form-control"/>
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="col-sm-4 control-label"><span class="error-text">*</span>Phone Number</label>
                        <div class="col-sm-8">
                            <input type="text" name='phoneno' id='phoneno'  class="form-control" onkeypress="return isNumber(event)" maxlength='10'/>
                        </div>
                      </div>                                                                                                                                                                    
                    </form>
                </div>                
                <div class="clearfix brd-top pad-t20 mar-t10 mar-b20">
                    <button class="btn btn-default mar-l10 pull-right mar-r20">Cancel</button>                   
                    <button class="btn btn-primary pull-right" onclick='updatecandidateaddress();'>Update</button>                    
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
