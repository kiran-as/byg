<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../application/conn.php");
$idground =1;
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

}

function getDates($startDate,$endDate,$dayname,$idground,$_POST)
{
    $endDate = strtotime($endDate);
for($i = strtotime($dayname, strtotime($startDate)); $i <= $endDate; $i = strtotime('+1 week', $i))
{
  $playdate = date('Y-m-d', $i);
  for($j=0;$j<count($_POST['timearray']);$j++)
  {
     $idground =$_GET['idground'] = 1;
     $idgroundtime = $_POST['idgroundtime'][$j];
	 
	 $amount = $_POST['timearray'][$j];
	 if($amount=='')
	 {
	   $amount=0;
	 }
	 $status ='Active';
	mysql_query("Insert into tbl_groundcost(idground,idgroundtime,amount,status,playdate) VALUES ('".$idground."','".$idgroundtime."','".$amount."','".$status."','".$playdate."') ");
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
<form name='' action='' method='POST'>
<table>
  <tr>
       <td>
	       <input type='text' id="datepicker" name="datepicker" value="">
		   	       <input type='text' id="datepicker1" name="datepicker1" value="">

	   </td>
  </tr>
  <tr>
       <td><input type='checkbox' id='monday' name='monday' value='1'>Monday<br/>
	       <input type='checkbox' id='tuesday' name='tuesday' value='2'>Tuesday<br/>
		   <input type='checkbox' id='wednesday' name='wednesday' value='3'>Wednesday<br/>
		   <input type='checkbox' id='thursday' name='thursday' value='4'>Thursday<br/>
		   <input type='checkbox' id='friday' name='friday' value='5'>Friday<br/>
		   <input type='checkbox' id='saturday' name='saturday' value='6'>Saturday<br/></td>
  </tr>
  <tr>
 <?php for($i=0;$i<count($groundtimearraydetails);$i++){?>
     <br/><?php echo $groundtimearraydetails[$i]['fromtime'];?><input type='text' value='' id='timearray[]' name='timearray[]'>
	 <input type='hidden' value='<?php echo $groundtimearraydetails[$i]['idgroundtime'];?>' id='idgroundtime[]' name='idgroundtime[]'>
 <?php }?>
  </tr>
  <tr>
  <input type='submit' name='Save' id='Save' value='Save'>
  </tr>
</table>
</form>
</head>
</html>