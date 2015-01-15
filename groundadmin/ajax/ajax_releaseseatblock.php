<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../../application/conn.php");
$idgroundcost = $_POST['idgroundcost'];
mysql_query("Update tbl_invoicedetails set status='Released' where idgroundcost='$idgroundcost'");
exit;
?>