<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../application/conn.php");
$groundindexsql = mysql_query("Select * from tbl_sport");
$i=0;
while($row = mysql_fetch_assoc($groundindexsql))
{
  $groundarray[$i]['idsport'] = $row['idsport'];
  $groundarray[$i]['sportname'] = $row['sportname'];
  $groundarray[$i]['status'] = $row['status'];
  $i++;
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
		<script type='text/javascript'>
	function fnaddground()
	{
	   parent.location='sportadd.php';
	}
	</script>
  </head>
  
  <body>
    <?php include('include/header.php');?>
    <div class="container mar-t30">
    <div class="row">
      <div class="form-group">        
        <div class="col-sm-4">
          <input type="text" class="form-control" placeholder="Search" />
        </div>
        <div class="col-sm-4 txtr col-sm-offset-4">
            <button type="button" class="btn btn-primary mar-b5" onclick='fnaddground()';>+ Add New Sport</button>
        </div>
      </div>               
    </div>    
     <table class="table v-align-mid mar-t10">      
          <thead>
            <tr>
 <th>Idsport</th>
	   <th>Sport Name</th>
	   <th>Status</th>
	   <th>Edit</th>
            </tr>
          </thead>
          <tbody>
		  <?php for($i=0;$i<count($groundarray);$i++){
		    $row_color = ($s % 2) ? 'alternaterowcolor1' : 'alternaterowcolor'; $no = $s+1;
?>
		   <tr class="<?php echo $row_color?>">
	       <td><?php  echo $groundarray[$i]['idsport'];?></td>
		   <td><?php  echo $groundarray[$i]['sportname'];?></td>
		   <td><?php  echo $groundarray[$i]['status'];?></td>
		   <td><a href="sportedit.php?idsport=<?php  echo $groundarray[$i]['idsport'];?>">Edit</a></td>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

