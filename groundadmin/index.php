<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../application/conn.php");
mysql_query("DELETE FROM tbl_tempseatblock WHERE createddate <= DATE_SUB( NOW( ) , INTERVAL 1 DAY )");
if($_POST)
{
  
  $email = $_POST['email'];
  $password = $_POST['password'];
  $idgroundadmin = 0;
  $groundadminsql = mysql_query("Select * from tbl_groundadmin where email='$email' and password='$password' and status ='Active'");
  while($row = mysql_fetch_assoc($groundadminsql))
  {
	$_SESSION['idgroundadmin'] = $idgroundadmin = $row['idgroundadmin'];
	$_SESSION['username'] = $row['username'];
  }
  
  if($idgroundadmin==0)
  {
      echo "<script>alert('The above valid credentials are invalid');</script>";
	  echo "<script>parent.location='index.php'</script>";
	  exit;
  }
  else
  {
	  echo "<script>parent.location='groundindex.php'</script>";
	  exit;
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
  </head>

  <body>

    <section class="login-wrapper">
        <div class="login-container">
            <a href="#" class="logo logo--large mar-b30">Book Your Ground</a>
             <form class="form-login" role="form" action='' method='POST'>                
                <label for="inputEmail" class="sr-only">Login ID</label>
                <input name='email' id='email' class="form-control clear--top clr-brdradius" placeholder="Email Address" autofocus="">
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" name='password' id='password' class="form-control clr-brdradius mar-b20" placeholder="Password">
                <button class="btn btn-lg btn-primary btn-block clr-brdradius" type="submit">LOGIN</button>
                <div class="mar-t30"><a href="#">Forgot Password?</a></div>
              </form>            
        </div>
    </section>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>