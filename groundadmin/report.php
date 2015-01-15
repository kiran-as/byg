<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../application/conn.php");
$idgroundadmin = $_SESSION['idgroundadmin'];

$sportsql = mysql_query("Select * from tbl_sport");
$s=0;
while ($row = mysql_fetch_assoc($sportsql)) {
  $arraysport[$s]["idsport"]	= $row["idsport"];
  $arraysport[$s]["sportname"]	= $row["sportname"];
  $s++;  
}

$groundnamesql = mysql_query("Select * from tbl_ground where groundadmin='$idgroundadmin'");
$i=0;
while($row = mysql_fetch_assoc($groundnamesql))
{
   $groundadminarray[$i]['idground'] = $row['idground'];
   $groundadminarray[$i]['groundname'] = $row['groundname'];
   $i++;
}

$groundsqlsettings = mysql_query("Select * from tbl_setting");
while($row = mysql_fetch_assoc($groundsqlsettings))
{
    $groundpercentage = $row['groundpercentage'];
}

if($_POST)
{
    $fromdate = date('Y-m-d',strtotime($_POST['datepicker']));
	$todate = date('Y-m-d',strtotime($_POST['datepicker1']));
	$ground = $_POST['idground'];
	$sport = $_POST['idsport'];
	
	$sql = mysql_query("SELECT a.amount as baseamount,a.*,b.status as bookingstatus, b.*,c.*,d.*,e.*,c.amount as paidamount,c.createdby as bookedby, f.*
						FROM `tbl_groundcost` as a,
							  tbl_invoicedetails as b,
							  tbl_invoice as c,
							  tbl_groundtime as d,
							  tbl_ground as e, 
							  tbl_sport as f
						 WHERE a.idgroundcost=b.idgroundcost and 
							   b.idinvoice=c.idinvoice and 
							   a.idgroundtime=d.idgroundtime and 
							   d.idground = e.idground and 
							   e.idsport = f.idsport and 
							   a.playdate>'$fromdate' and 
							   a.playdate<='$todate' and 
							   a.idground=$ground and b.status='Booked' group by c.idinvoice ");
 /*echo "SELECT a.*,b.*,c.*,d.*,e.* 
						FROM `tbl_groundcost` as a,
							  tbl_invoicedetails as b,
							  tbl_invoice as c,
							  tbl_groundtime as d,
							  tbl_ground as e, 
							  tbl_sport as f
						 WHERE a.idgroundcost=b.idgroundcost and 
							   b.idinvoice=c.idinvoice and 
							   a.idgroundtime=d.idgroundtime and 
							   d.idground = e.idground and 
							   e.idsport = f.idsport and 
							   a.playdate>'$fromdate' and 
							   a.playdate<='$todate' and 
							   a.idground=$ground and 
							   b.status='Booked'";*/
 $i=0;
while($row = mysql_fetch_assoc($sql))
{

   $groundarray[$i]['idinvoice'] = $row['idinvoice'];
   $groundarray[$i]['name'] = $row['name'];
   $groundarray[$i]['email'] = $row['email'];
   $groundarray[$i]['phone'] = $row['phoneno'];
   $groundarray[$i]['starttime'] = $row['fromtime'];
      $groundarray[$i]['endtime'] = $row['totime'];
	  $groundarray[$i]['sportname'] = $row['sportname'];
	  $groundarray[$i]['paidamount'] = $row['paidamount'];
$groundarray[$i]['bookedby'] = $row['bookedby'];
$groundarray[$i]['bookingstatus'] = $row['bookingstatus'];
$groundarray[$i]['bookingid'] = $row['bookingid'];

if($row['paidamount']==0)
{
   $idinvoice = $row['idinvoice'];
   $amountssss=0;
	$sqls = mysql_query("SELECT a.amount as baseamount,a.*,b.status as bookingstatus, b.*
						FROM `tbl_groundcost` as a,tbl_invoicedetails as b 
						where a.idgroundcost=b.idgroundcost and b.idinvoice=$idinvoice");
	while($rowss = mysql_fetch_assoc($sqls))
	{
	   $amountssss = $amountssss+$rowss['baseamount'];
	}
	$groundarray[$i]['bookingamount']=0;
	$groundarray[$i]['balanceamount'] = $amountssss;
	$groundarray[$i]['baseamount'] = $amountssss;

}
else
{
	$amountss=0;
	$idinvoice = $row['idinvoice'];
	$sql = mysql_query("SELECT a.amount as baseamount,a.*,b.status as bookingstatus, b.*
						FROM `tbl_groundcost` as a,tbl_invoicedetails as b 
						where a.idgroundcost=b.idgroundcost and b.idinvoice=$idinvoice");
	while($rowss = mysql_fetch_assoc($sql))
	{
	   $amountss = $amountss+$rowss['baseamount'];
	}
	$groundarray[$i]['bookingamount'] = ($amountss/100)*$groundpercentage;
$groundarray[$i]['balanceamount'] = $amountss - (($amountss/100)*$groundpercentage);
$groundarray[$i]['baseamount'] = $amountss;
	
}
   $groundarray[$i]['playdate'] = date('Y-m-d',strtotime($row['playdate']));
   $i++;
}

$k=0;
	$sql = mysql_query("SELECT a.amount as baseamount,a.*,b.status as bookingstatus, b.*,c.*,d.*,e.*,c.amount as paidamount,c.createdby as bookedby, f.*
						FROM `tbl_groundcost` as a,
							  tbl_invoicedetails as b,
							  tbl_invoice as c,
							  tbl_groundtime as d,
							  tbl_ground as e, 
							  tbl_sport as f
						 WHERE a.idgroundcost=b.idgroundcost and 
							   b.idinvoice=c.idinvoice and 
							   a.idgroundtime=d.idgroundtime and 
							   d.idground = e.idground and 
							   e.idsport = f.idsport and 
							   a.playdate>'$fromdate' and 
							   a.playdate<='$todate' and 
							   a.idground=$ground and b.status='Released' group by c.idinvoice ");
while($row = mysql_fetch_assoc($sql))
{
   $groundarrays[$k]['idinvoice'] = $row['idinvoice'];
   $groundarrays[$k]['name'] = $row['name'];
   $groundarrays[$k]['email'] = $row['email'];
   $groundarrays[$k]['phone'] = $row['phoneno'];
   $groundarrays[$k]['starttime'] = $row['fromtime'];
      $groundarrays[$k]['endtime'] = $row['totime'];
	  $groundarrays[$k]['sportname'] = $row['sportname'];
	  $groundarrays[$k]['paidamount'] = $row['paidamount'];
$groundarrays[$k]['bookedby'] = $row['bookedby'];
$groundarrays[$k]['bookingstatus'] = $row['bookingstatus'];
$groundarrays[$k]['bookingid'] = $row['bookingid'];
$groundarrays[$k]['baseamount'] = $row['baseamount'];
if($row['paidamount']==0)
{
	$groundarrays[$k]['bookingamount']=0;
$groundarrays[$k]['balanceamount'] = $row['baseamount'];	
}
else
{
	$idinvoice = $row['idinvoice'];
	$sql = mysql_query("SELECT a.amount as baseamount,a.*,b.status as bookingstatus, b.*
						FROM `tbl_groundcost` as a,tbl_invoicedetails as b 
						where a.idgroundcost=b.idgroundcost and b.idinvoice=$idinvoice");
	while($rowss = mysql_fetch_assoc($sql))
	{
	   $amountss = $amountss+$rowss['baseamount'];
	}
	$groundarray[$k]['bookingamount'] = ($amountss/100)*$groundpercentage;
	$groundarrays[$k]['balanceamount'] = $row['baseamount'] - (($row['baseamount']/100)*$groundpercentage);
}

   $groundarrays[$k]['playdate'] = date('Y-m-d',strtotime($row['playdate']));
   $k++;
}							   

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
	$('#datepicker').datepicker('show');
}
  </script>
  </head>

  <body>
  <form action='' method='POST'>
<?php include('include/header.php');?>
    <div class="container mar-t30">    
                <div class="secondary-box clearfix mh500">
                <div class="pad-l20 pad-t5 pad-b5 brd-btm">
                   <h4 class="primary-title">Add Price</h4>
                </div>
                <div class="clearfix pad-t20">                                    
                    <div class="form-horizontal col-sm-6" role="form">
                      <div class="form-group">
                        <label class="col-sm-4 control-label"><span class="error-text">*</span>Start Date</label>
                        <div class="col-sm-8 pos-rel">
                          <input type="type" id="datepicker" name="datepicker"  class="form-control" value="<?php echo $fromdate;?>">
                          <span class="date"></span>
                        </div>
                      </div>                                                                                                                    
                    </div>
                    <div class="form-horizontal col-sm-6" role="form">
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><span class="error-text">*</span>End Date</label>
                            <div class="col-sm-8 pos-rel">
                                <input type="type" id="datepicker1" name="datepicker1"  class="form-control" value="<?php echo $todate;?>">
                                <span class="date"></span>
                            </div>
                        </div>
                    </div> 
					<div class="form-horizontal col-sm-6" role="form">
                      <div class="form-group">
                        <label class="col-sm-4 control-label"><span class="error-text">*</span>Ground </label>
                        <div class="col-sm-8 pos-rel">
                          <select class="form-control" name='idground' id='idground' >
		     <?php for($i=0;$i<count($groundadminarray);$i++){?>
                <option value='<?php echo $groundadminarray[$i]['idground'];?>' 
				<?php if($ground==$groundadminarray[$i]['idground']){echo "selected=selected";}?>>
				<?php echo $groundadminarray[$i]['groundname'];?></option>		
        <?php }?>	
                        </select>
                        </div> 

                      </div>      <input type='submit' name='Save' id='Save' class="btn btn-primary pull-right" value='Search'>
                                                                                                                
                    </div>
					<!--
                    <div class="form-horizontal col-sm-6" role="form">
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><span class="error-text">*</span>Choose Your Sport</label>
								<div class="col-sm-8 pos-rel">
									<label class="sr-only"></label>
										
								</div>
                         </div>
                    </div>	-->				
                </div> 
                    


     <table class="table v-align-mid mar-t10">      
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Phoneno</th>
              <th>Timings</th>
              <th>Play Date</th>
			  <th>Sport</th>
              <th>Booked By</th>
			  <th>Base Amount</th>
			  
              <th>Booking Amount</th>
			  <th>Balance Amount</th>
              <th>Booking ID</th>
			  <th>Booking Status</th>
            </tr>
          </thead>
          <tbody>
		  <?php for($i=0;$i<count($groundarray);$i++){
		   $idinvoice = $groundarray[$i]['idinvoice'];
		    $row_color = ($s % 2) ? 'alternaterowcolor1' : 'alternaterowcolor'; $no = $s+1;
?>
		   <tr class="<?php echo $row_color?>">
	       <td><?php  echo $groundarray[$i]['name'];?></td>
		   <td><?php  echo $groundarray[$i]['email'];?></td>
		   <td><?php  echo $groundarray[$i]['phone'];?></td>
		   <!-- fnction to get the time slot for the multiple booking goes here--->
		   <?php 
		        $groundsql = mysql_query("Select a.*,c.*,d.*
				                         from tbl_invoicedetails as a, tbl_groundcost as c, tbl_groundtime as d
										 where a.idgroundcost=c.idgroundcost  
										 and c.idgroundtime=d.idgroundtime 
										 and a.idinvoice='$idinvoice' and a.status='Booked'");
                $groundtime='';

				while($row = mysql_fetch_assoc($groundsql))
				{
					$groundtime .= $row['fromtime'].'-'.$row['totime'].',&nbsp;';
					$g++;
				}
		   ?>
		   <!-- end of the function of multiple booking-->
		   <td><?php  echo $groundtime;?></td>
		    <td><?php echo $groundarray[$i]['playdate'];?></td>
		   <td><?php  echo $groundarray[$i]['sportname'];?></td>
		   <td><?php  if($groundarray[$i]['bookedby']>0){ echo "Admin";} else {echo "Online";};?></td>
		   <td><?php echo $groundarray[$i]['baseamount'];?></td>
		   <td><?php echo $groundarray[$i]['bookingamount'];?></td>
		   <td><?php echo $groundarray[$i]['balanceamount'];?></td>
		   
		    <td><?php echo $groundarray[$i]['bookingid'];?></td>
			<td><?php if($groundarray[$i]['bookingstatus']=='Booked'){ echo "Booked";} else { echo "Canelled";};?>
          </tr>  
		  <?php }?>
           
		   <?php for($i=0;$i<count($groundarrays);$i++){
		   $idinvoice = $groundarrays[$i]['idinvoice'];
		    $row_color = ($s % 2) ? 'alternaterowcolor1' : 'alternaterowcolor'; $no = $s+1;
?>
		   <tr class="<?php echo $row_color?>">
	       <td><?php  echo $groundarrays[$i]['name'];?></td>
		   <td><?php  echo $groundarrays[$i]['email'];?></td>
		   <td><?php  echo $groundarrays[$i]['phone'];?></td>
		   <!-- fnction to get the time slot for the multiple booking goes here--->
		   <?php 
		        $groundsql = mysql_query("Select a.*,c.*,d.*
				                         from tbl_invoicedetails as a, tbl_groundcost as c, tbl_groundtime as d
										 where a.idgroundcost=c.idgroundcost  
										 and c.idgroundtime=d.idgroundtime 
										 and a.idinvoice='$idinvoice' and a.status='Released'");
                $groundtime='';
				while($row = mysql_fetch_assoc($groundsql))
				{
					$groundtime .= $row['fromtime'].'-'.$row['totime'].',&nbsp;';
					$g++;
				}
		   ?>
		   <!-- end of the function of multiple booking-->
		   <td><?php  echo $groundtime;?></td>
		    <td><?php echo $groundarrays[$i]['playdate'];?></td>
		   <td><?php  echo $groundarrays[$i]['sportname'];?></td>
		   <td><?php  if($groundarrays[$i]['bookedby']>0){ echo "Admin";} else {echo "Online";};?></td>
		   <td><?php echo $groundarrays[$i]['baseamount'];?></td>
		   <td><?php echo $groundarrays[$i]['bookingamount'];?></td>
		   <td><?php echo $groundarrays[$i]['balanceamount'];?></td>
		   
		    <td><?php echo $groundarrays[$i]['bookingid'];?></td>
			<td><?php if($groundarrays[$i]['bookingstatus']=='Booked'){ echo "Booked";} else { echo "Canelled";};?>
          </tr>  
		  <?php }?>
          </tbody>
        </table> 
      </div>   
    <footer>
            <p>&copy; 2014 www.bookyourground.com All Rights Reserved</p>
    </footer>  
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.min.js"></script>
	</form>
  </body>
</html>
