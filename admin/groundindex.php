<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../application/conn.php");
$groundindexsql = mysql_query("Select * from tbl_ground where status='Active'");
$i=0;
while($row = mysql_fetch_assoc($groundindexsql))
{
  $groundarray[$i]['idground'] = $row['idground'];
  $groundarray[$i]['groundname'] = $row['groundname'];
  $groundarray[$i]['address'] = $row['address'];
  $groundarray[$i]['venue'] = $row['venue'];
  $groundarray[$i]['starttime'] = $row['starttime'];
  $groundarray[$i]['endtime'] = $row['endtime'];
  $groundarray[$i]['latitude'] = $row['latitude'];
  $groundarray[$i]['longitude'] = $row['longitude'];
  $groundarray[$i]['city'] = $row['city'];
  $groundarray[$i]['groundadmin'] = $row['groundadmin'];
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
	   parent.location='addground.php';
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
            <button type="button" class="btn btn-primary mar-b5" onclick='fnaddground()';>+ Add New Ground</button>
        </div>
      </div>               
    </div>    
     <table class="table v-align-mid mar-t10">      
          <thead>
            <tr>
              <th>Ground Name</th>
              <th>Address</th>
              <th>Venue</th>
              <th>Start Time</th>
              <th>End Time</th>
			    <th>Edit</th>
              
            </tr>
          </thead>
          <tbody>
		  <?php for($i=0;$i<count($groundarray);$i++){
		    $row_color = ($s % 2) ? 'alternaterowcolor1' : 'alternaterowcolor'; $no = $s+1;
?>
		   <tr class="<?php echo $row_color?>">
	       <td><?php  echo $groundarray[$i]['groundname'];?></td>
		   <td><?php  echo $groundarray[$i]['address'];?></td>
		   <td><?php  echo $groundarray[$i]['venue'];?></td>
		   <td><?php  echo $groundarray[$i]['starttime'];?></td>
		   <td><?php  echo $groundarray[$i]['endtime'];?></td>
 <td><a href="editground.php?idground=<?php  echo $groundarray[$i]['idground'];?>">Edit</a></td>

          </tr>  
		  <?php }?>
           
          </tbody>
        </table> 
      </div>   

    <?php include('include/footer.php');?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
