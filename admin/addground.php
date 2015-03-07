<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../application/conn.php");

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
  $mobile = $_POST['mobile'];
  $slot = $_POST['slot'];
  $status = 'Active';
  echo "Insert into tbl_ground(groundname,address,venue,starttime,endtime,latitude,longitude,city,groundadmin,
  status,idlocation,idsport,description,shortname,mobile,slot) values 
  ('".$groundname."','".$address."','".$venue."','".$starttime."','".$endtime."','".$latitude."','".$longitude."','".$city."',
  '".$groundadmin."','".$status."','".$idlocation."','".$idsport."','".$description."','".$shortname."','".$mobile."','".$slot."')";
//exit;
  mysql_query("Insert into tbl_ground(groundname,address,venue,starttime,endtime,latitude,longitude,city,groundadmin,
  status,idlocation,idsport,description,shortname,mobile,slot) values 
  ('".$groundname."','".$address."','".$venue."','".$starttime."','".$endtime."','".$latitude."','".$longitude."','".$city."',
  '".$groundadmin."','".$status."','".$idlocation."','".$idsport."','".$description."','".$shortname."','".$mobile."','".$slot."')");
  $idground = mysql_insert_id();
  
  for($i=0;$i<24;$i++)
  {
    $fromtime = $starttime;
    if($slot=='30')
    {
    $timestamp = strtotime($starttime) + 30*60;
    }
    if($slot=='60')
    {
      $timestamp = strtotime($starttime) + 60*60;
    }
    
	$time = date('H:i', $timestamp);
	$totime = $starttime = $time;
	if($time > $endtime)
	{
	   break;
	}
	mysql_query("Insert into tbl_groundtime (idground,fromtime,totime,status) VALUES ('".$idground."','".$fromtime."','".$totime."','Active')");
  }
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
                      <input type="type" class="form-control" name='name' id='name'>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><span class="error-text">*</span>Address</label>
                    <div class="col-sm-8">
                      <textarea class="form-control" rows="3"  name='address' id='address'></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Start Time</label>
                    <div class="col-sm-8">
                      <input type="type" class="form-control" name='starttime' id='starttime'>
                    </div>
                  </div>    
                  <div class="form-group">
                    <label class="col-sm-4 control-label">City</label>
                    <div class="col-sm-8">
                      <input type="type" class="form-control" name='city' id='city'>                    
                    </div>
                  </div>  
				   <div class="form-group">
                    <label class="col-sm-4 control-label">Sport</label>
                    <div class="col-sm-8">
                      <select class="form-control"  name='idsport' name='idsport' >
			<?php for($i=0;$i<count($arraysport);$i++){?>
			<option value='<?php echo $arraysport[$i]['idsport'];?>'><?php echo $arraysport[$i]['sportname'];?></option>
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
			<option value='<?php echo $arraygroundadmin[$i]['idgroundadmin'];?>'><?php echo $arraygroundadmin[$i]['username'];?></option>
			<?php }?>
			  </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Latitude</label>
                    <div class="col-sm-8">
                      <input type="type" class="form-control"  name='latitude' id='latitude'>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Longitude</label>
                    <div class="col-sm-8">
                      <input type="type" class="form-control"  name='longitude' id='longitude'>
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="col-sm-4 control-label">End Time</label>
                    <div class="col-sm-8">
                      <input type="type" class="form-control"  name='endtime' id='endtime'>
                    </div>
                  </div>  
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Location</label>
                    <div class="col-sm-8">
                      <select class="form-control"  name='idlocation' name='idlocation'>
                          <?php for($i=0;$i<count($arraylocation);$i++){?>
			<option value='<?php echo $arraylocation[$i]['idlocation'];?>'><?php echo $arraylocation[$i]['locationname'];?></option>
			<?php }?>
                      </select>                     
                    </div>
                  </div> 
				<div class="form-group">
                    <label class="col-sm-4 control-label">Short Name</label>
                    <div class="col-sm-8">
                      <input type="type" class="form-control"  name='shortname' id='shortname'>
                    </div>
                  </div> 	
                  
				<div class="form-group">
                    <label class="col-sm-4 control-label">Mobile</label>
                    <div class="col-sm-8">
                      <input type="type" class="form-control"  name='mobile' id='mobile'>
                    </div>
                  </div> 
                  <div class="form-group">
                    <label class="col-sm-4 control-label"><span class="error-text">*</span>Time Selection</label>
                    <div class="col-sm-8">
                      <select name='slot' id='slot' class="form-control" >
      
      <option value='30'>30 Minutes</option>
      <option value='60'>60 Minutes</option>
        </select>
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