<?php
include("application/conn.php");
mysql_query("DELETE FROM tbl_tempseatblock WHERE createddate < (NOW() - INTERVAL 5 MINUTE)");
?>
