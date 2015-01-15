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
?>
<html>
<head>
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
<table>
<form action='' method='POST' name=''>
     <tr>
	     <td><select name='idground' id='idground' >
		     <?php for($i=0;$i<count($groundadminarray);$i++){?>
                <option value='<?php echo $groundadminarray[$i]['idground'];?>'>
				<?php echo $groundadminarray[$i]['groundname'];?></option>		
        <?php }?>				
	</td>
	 </tr>
	  <tr>
       <td>
	       <input type='text' id="datepicker" name="datepicker" value="">

	   </td>
  </tr>
  <tr>
      <td><input type='submit' name='Save' id='Save'></td>
  </tr>
  <tr>
  <td>
  <?php for($i=0;$i<count($playdatesqlarray);$i++){?>
  <input type='hidden' id='groundcost[]' name='groundcost[]' value='<?php echo $playdatesqlarray[$i]['idgroundcost'];?>'><br/> 
        <input type='text' id='amount[<?php echo $playdatesqlarray[$i]['idgroundcost'];?>]' name='amount[]' 
		        value='<?php echo $playdatesqlarray[$i]['amount'];?>'><br/>
  <?php }?>
  </td>
  </tr>
  </form>
</table>

</html>