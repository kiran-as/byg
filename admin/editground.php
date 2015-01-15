<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../application/conn.php");
$idground =$_GET['idground'];
	//print_r($resultsss);die();
	$resultgroundadmin = mysql_query("Select * from tbl_groundadmin");
	$s=0;
	while ($row = mysql_fetch_assoc($resultgroundadmin)) {
		  $arraygroundadmin[$s]["idgroundadmin"]	= $row["idgroundadmin"];
		  $arraygroundadmin[$s]["username"]	= $row["username"];
		  $s++;  
		}

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

$groundsql = mysql_query("Select * from tbl_ground where idground='$idground'");
while($row = mysql_fetch_assoc($groundsql))
{
  $groundname = $row['groundname'];
  $address = $row['address'];
  $venue = $row['venue'];
  $starttime = $row['starttime'];
  $endtime = $row['endtime'];
  $latitude = $row['latitude'];
  $longitude = $row['longitude'];
  $city = $row['city'];
  $groundadmin = $row['idgroundadmin'];
  $idlocation = $row['idlocation'];
  $idsport = $row['idsport'];
  $TemplateBody = $row['description'];
  $shortname = $row['shortname'];  
  $status = 'Active';
  $mobile = $row['mobile'];
}
		
if($_POST) 
{

  $groundname = $_POST['name'];
  $address = $_POST['address'];
  $venue = $_POST['venue'];
  $starttime = $_POST['starttime'];
  $endtime = $_POST['endtime'];
  $latitude = $_POST['latitude'];
  $longitude = $_POST['longitude'];
  $city = $_POST['city'];
  $groundadmin = $_POST['idgroundadmin'];
  $idlocation = $_POST['idlocation'];
  $idsport = $_POST['idsport'];
  $description = $_POST['field1'];
  $shortname = $_POST['shortname'];  
  $status = 'Active';
  $mobile = $_POST['mobile'];

  mysql_query("Update tbl_ground set groundname='$groundname',
                                address = '$address',
							   idsport = '$idsport',
							   description = '$description',
							   shortname = '$shortname',
							   groundadmin = '$groundadmin',
							   mobile = '$mobile',
							   city = '$city'
							   
			    where idground='$idground'");
  
  echo "<script>parent.location='groundindex.php'</script>";
  exit;
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
  </head>

  <body>
   <?php include('include/header.php');?>
    <div class="container mar-t30">  
<form action='' method='POST'>	
                <div class="secondary-box clearfix mh500">
                <div class="pad-l20 pad-t5 pad-b5 brd-btm">
                   <h4 class="primary-title">Add/Edit Ground</h4>
                </div>
                <div class="clearfix pad-t20">                                    
                <div class="form-horizontal col-sm-6" >
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><span class="error-text">*</span>Ground Name</label>
                    <div class="col-sm-8">
                      <input type="type" class="form-control" name='name' id='name' value='<?php echo $groundname;?>'/>
                    </div>
                  </div>
                
				   <div class="form-group">
                    <label class="col-sm-4 control-label">Sport</label>
                    <div class="col-sm-8">
                      <select class="form-control"  name='idsport' name='idsport' >
			<?php for($i=0;$i<count($arraysport);$i++){?>
			<option value='<?php echo $arraysport[$i]['idsport'];?>'
			<?php if($idsport==$arraysport[$i]['idsport']){ echo "selected=selected";}?>><?php echo $arraysport[$i]['sportname'];?></option>
			<?php }?>
			  </select>          
                    </div>
					</div>
					  <div class="form-group">
                    <label class="col-sm-4 control-label"><span class="error-text"></span>Description</label>
                    <div class="col-sm-8">
					<?php include("cms_editor.php");?>
                      
                    </div>
                  </div>
                </div> 
                <div class="form-horizontal col-sm-6">
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><span class="error-text">*</span>Ground Admin</label>
                    <div class="col-sm-8">
                      <select name='idgroundadmin' name='idgroundadmin' class="form-control" >
			<?php for($i=0;$i<count($arraygroundadmin);$i++){?>
			<option value='<?php echo $arraygroundadmin[$i]['idgroundadmin'];?>'
			<?php if($idgroundadmin==$arraygroundadmin[$i]['idgroundadmin']){ echo "selected=selected";}?>><?php echo $arraygroundadmin[$i]['username'];?></option>
			<?php }?>
			  </select>
                    </div>
                  </div>
				     <div class="form-group">
                    <label class="col-sm-4 control-label">City</label>
                    <div class="col-sm-8">
                      <input type="type" class="form-control" name='city' id='city' value='<?php echo $city;?>'/>                    
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><span class="error-text">*</span>Address</label>
                    <div class="col-sm-8">
                      <textarea class="form-control" rows="3"  name='address' id='address'><?php echo $address;?></textarea>
                    </div>
                  </div>
				<div class="form-group">
                    <label class="col-sm-4 control-label">Short Name</label>
                    <div class="col-sm-8">
                      <input type="type" class="form-control"  name='shortname' id='shortname' value='<?php echo $shortname;?>'>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Mobile</label>
                    <div class="col-sm-8">
                      <input type="type" class="form-control"  name='mobile' id='mobile' value='<?php echo $mobile;?>'>
                    </div>
                  </div> 	 				  
                </div>
                </div>    
                <div class="clearfix brd-top pad-t20 mar-t10">
                    <button class="btn btn-default mar-l10 pull-right mar-r20">Cancel</button>                   
                    <button class="btn btn-primary pull-right" type='Submit'>Save</button>                    
                </div>                                             
                </div>       
				</form>
    </div>   

    <footer>
            <p>&copy; 2014 www.bookyourground.com All Rights Reserved</p>
    </footer>  
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>