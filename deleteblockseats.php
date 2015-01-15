<?php
include("application/conn.php");
mysql_query("DELETE FROM tbl_tempseatblock");
mysql_query("delete from tbl_invoice");
mysql_query("delete from tbl_invoicedetails");
?>
