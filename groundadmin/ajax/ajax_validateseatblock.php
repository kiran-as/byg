<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../../application/conn.php");
$idgroundcost = $_POST['idgroundcost'];
$type = $_POST['type'];
$sessionid = session_id();
$idtempseatblock=0;
if($type==1)
{
    $groundcosttemp = mysql_query("Select * from tbl_tempseatblock where idgroundcost='$idgroundcost' and sessionid!='$sessionid'");
	while($row = mysql_fetch_assoc($groundcosttemp))
	{
		$idtempseatblock = $row['idtempseatblock'];
	}
}



 echo $idtempseatblock;
?>