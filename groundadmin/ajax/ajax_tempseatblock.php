<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../../application/conn.php");
$idgroundcost = $_POST['idgroundcost'];
$type = $_POST['type'];
$sessionid = session_id();
$createddate = date('Y-m-d H:i:s');
if($type==2)
{
   mysql_query("Delete from tbl_tempseatblock where sessionid='$sessionid' and idgroundcost='$idgroundcost'");
}
if($type==1)
{
mysql_query("Insert into tbl_tempseatblock (idgroundcost,sessionid,createddate)
 VALUES('".$idgroundcost."','".$sessionid."','".$createddate."')");
}