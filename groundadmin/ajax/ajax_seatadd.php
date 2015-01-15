<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../../application/conn.php");
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$createdby = $_SESSION['idgroundadmin'];
$date = date('Y-m-d H:i:s');
$amount =0;
$byginvoiceno = 'BYGINV'.rand(111111,999999);
mysql_query("Insert into tbl_invoice (name,email,phoneno,createdby,createddate,amount,bookingid)
 VALUES('".$name."','".$email."','".$phone."','".$createdby."','".$date."','".$amount."','".$byginvoiceno."')");
 $idinvoice = mysql_insert_id();
 $sessionid = session_id();
 
$tempseatblocksql =  mysql_query("Select * from tbl_tempseatblock where sessionid='$sessionid'");
 while($row = mysql_fetch_assoc($tempseatblocksql))
 {
  $idgroundcost = $row['idgroundcost'];
    mysql_query("Insert into tbl_invoicedetails (idinvoice,idgroundcost)
 VALUES('".$idinvoice."','".$idgroundcost."')");
 }
 
  $sessionid = session_id();
   mysql_query("Delete from tbl_tempseatblock where sessionid='$sessionid'");
?>