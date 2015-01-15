<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../application/conn.php");
$sessionid = session_id();
mysql_query("Delete from tbl_tempseatblock where sessionid='$sessionid'");

?>