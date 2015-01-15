<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../application/conn.php");
$idgroundadmin = $_GET['idgroundadmin'];
$editgroundsql = mysql_query("Select * from tbl_groundadmin where idgroundadmin='$idgroundadmin'");
while($row = mysql_fetch_assoc($editgroundsql))
{
   $email = $row['email'];
   $password = $row['password'];
   $username = $row['username'];
}
if($_POST)
{
    $idgroundadmin = $_GET['idgroundadmin'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    mysql_query("Update tbl_groundadmin set email='$email' , password='$password', username='$username'
                where idgroundadmin='$idgroundadmin'");
	echo "<script>parent.location='groundadminindex.php'</script>";
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
                    <label class="col-sm-4 control-label"><span class="error-text">*</span>Username</label>
                    <div class="col-sm-8">
                      <input type="type" class="form-control" name='username' id='username' value='<?php echo $username;?>'>
                    </div>
                  </div>
                
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Email</label>
                    <div class="col-sm-8">
                      <input type="type" class="form-control" name='email' id='email'  value='<?php echo $email;?>'>
                    </div>
                  </div>    
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Password</label>
                    <div class="col-sm-8">
                      <input type="type" class="form-control"  name='password' id='password'  value='<?php echo $password;?>'>                    
                    </div>
                  </div>   
  <div class="clearfix pad-t20 mar-t10">
                    <button class="btn btn-default mar-l10 pull-right mar-r20">Cancel</button>                   
                    <button class="btn btn-primary pull-right" type='Submit'>Save</button>                    
                </div>   				  
                </div> 
                </div>
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
