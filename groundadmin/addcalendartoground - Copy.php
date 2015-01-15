<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../application/conn.php");
$idgroundadmin = $_SESSION['idgroundadmin'];
$idground =$_GET['idground'];
$groundsql = mysql_query("Select * from tbl_groundtime where idground='$idground'");
$i=0;
while($row = mysql_fetch_assoc($groundsql))
{
   $groundtimearraydetails[$i]['idgroundtime'] = $row['idgroundtime'];
   $groundtimearraydetails[$i]['idground'] = $row['idground'];
   $groundtimearraydetails[$i]['fromtime'] = $row['fromtime'];
   $groundtimearraydetails[$i]['totime'] = $row['totime'];
   $groundtimearraydetails[$i]['status'] = $row['status'];
   $i++;
}
if($_POST)
{
$startdate = date('Y-m-d', strtotime($_POST['datepicker']));
$enddate = date('Y-m-d',strtotime($_POST['datepicker1']));
   if($_POST['monday']==1)
   {
      $response = getDates($startdate,$enddate,"Monday",$idground,$_POST);
   }
   if($_POST['tuesday']==2)
   {
      $response = getDates($startdate,$enddate,"Tuesday",$idground,$_POST);
   }
   if($_POST['wednesday']==3)
   {
      $response = getDates($startdate,$enddate,"Wednesday",$idground,$_POST);
   }
   if($_POST['thursday']==4)
   {
      $response = getDates($startdate,$enddate,"Thursday",$idground,$_POST);
   }
   if($_POST['friday']==5)
   {
      $response = getDates($startdate,$enddate,"Friday",$idground,$_POST);
   }
   if($_POST['saturday']==6)
   {
      $response = getDates($startdate,$enddate,"Saturday",$idground,$_POST);
   }
   if($_POST['sunday']==7)
   {
      $response = getDates($startdate,$enddate,"Sunday",$idground,$_POST);
   }
   echo "<script>parent.location='groundindex.php'</script>";
   exit;
}

function getDates($startDate,$endDate,$dayname,$idground,$_POST)
{

$createddate = $updateddate = date('Y-m-d H:i:s');
$createdby = $modifiedby = $idgroundadmin = $_SESSION['idgroundadmin'];
$endDate = strtotime($endDate);
for($i = strtotime($dayname, strtotime($startDate)); $i <= $endDate; $i = strtotime('+1 week', $i))
{
  $playdate = date('Y-m-d', $i);
  for($j=0;$j<count($_POST['timearray']);$j++)
  {
     $idground =$_GET['idground'];
     $idgroundtime = $_POST['idgroundtime'][$j];
	 
	 $amount = $_POST['timearray'][$j];
	 if($amount=='')
	 {
	   $amount=0;
	 }
	 $status ='Active';
	 $idgroundcost = 0;
	 $groundcostsql = mysql_query("Select * from tbl_groundcost where playdate='$playdate' and idground='$idground' and
	 idgroundtime='$idgroundtime'");
	 while($row = mysql_fetch_assoc($groundcostsql))
	 {
		$idgroundcost = $row['idgroundcost'];
	 }
	 

	 if($idgroundcost!=0)
	 {
				  
	 	     $upddate = date('Y-m-d H:i:s');
			 mysql_query("Update tbl_groundcost set status='Inactive', updateddate='$upddate',modifiedby='$idgroundadmin'
		              where idgroundcost='$idgroundcost'");
	 }

	mysql_query("Insert into tbl_groundcost(idground,idgroundtime,amount,status,playdate,createdby,modifiedby,createddate,updateddate) VALUES 
	('".$idground."','".$idgroundtime."','".$amount."','".$status."','".$playdate."',
	 '".$createdby."','".$modifiedby."','".$createddate."','".$updateddate."') ");
	
  }
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
                          <input type="type" id="datepicker" name="datepicker"  class="form-control">
                          <span class="date"></span>
                        </div>
                      </div>                                                                                                                    
                    </div>
                    <div class="form-horizontal col-sm-6" role="form">
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><span class="error-text">*</span>End Date</label>
                            <div class="col-sm-8 pos-rel">
                                <input type="type" id="datepicker1" name="datepicker1"  class="form-control">
                                <span class="date"></span>
                            </div>
                        </div>
                    </div>                 
                </div> 
                <div class="clearfix">
                 <div class="form-horizontal col-sm-12" role="form">
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                      <div class="checkbox">
                        <label class="checkbox-inline">
                          <input type="checkbox" id='monday' name='monday' value='1'> MON
                        </label>
                        <label class="checkbox-inline">
                          <input type="checkbox" id='tuesday' name='tuesday' value='2'> TUE
                        </label> 
                        <label class="checkbox-inline">
                          <input type="checkbox" id='wednesday' name='wednesday' value='3'> WED
                        </label>
                        <label class="checkbox-inline">
                          <input type="checkbox" id='thursday' name='thursday' value='4'> THU
                        </label>
                        <label class="checkbox-inline">
                          <input type="checkbox" id='friday' name='friday' value='5'> FRI
                        </label>
                        <label class="checkbox-inline">
                          <input type="checkbox"  id='saturday' name='saturday' value='6'> SAT
                        </label> 
                        <label class="checkbox-inline">
                          <input type="checkbox"  id='sunday' name='sunday' value='7'> SUN
                        </label>                                                                       
                      </div>
                    </div>
                  </div>
                 </div>               
                </div>
                <div class="clearfix brd-top pad-t20 mar-t10">
                <div class="form-horizontal" role="form">
                 <div class="row mar0">
				  
				  
                  <?php for($i=0;$i<count($groundtimearraydetails);$i++){?>
					 <div class="form-group col-sm-2">
							<label class="col-sm-7 control-label hpad5 font12 pad-t9"><?php echo $groundtimearraydetails[$i]['fromtime'];?> - <?php echo $groundtimearraydetails[$i]['totime'];?></label>
						 <div class="col-sm-5 hpad5">
						    <input type='hidden' value='<?php echo $groundtimearraydetails[$i]['idgroundtime'];?>' id='idgroundtime[]' name='idgroundtime[]'>
							<input type="type" value='' id='timearray[]' name='timearray[]' class="form-control hpad5" placeholder="Price">
						 </div>                  
                    </div>
				  <?php }?>                                                                                                   
                 </div>                
                </div>                
                </div>
                <div class="clearfix brd-top pad-t20 mar-t10">
                    <button class="btn btn-default mar-l10 pull-right mar-r20">Cancel</button>                   
                    <button class="btn btn-primary pull-right">Save</button>                    
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
	</form>
  </body>
</html>
