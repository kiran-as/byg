<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../application/conn.php");
$idgroundcost = $_POST['idgroundcost'];
$type = $_POST['type'];
$sessionid = session_id();
$createddate = date('Y-m-d H:i:s');
$totalsum=0;
$groundsqlsettings = mysql_query("Select * from tbl_setting");
while($row = mysql_fetch_assoc($groundsqlsettings))
{
    $groundpercentage = $row['groundpercentage'];
}


	if($type==2)
	{
	   mysql_query("Delete from tbl_tempseatblock where sessionid='$sessionid' and idgroundcost='$idgroundcost'");
	}
	if($type==1)
	{

mysql_query("Delete from tbl_tempseatblock where sessionid='$sessionid' and idgroundcost='$idgroundcost'");

	mysql_query("Insert into tbl_tempseatblock (idgroundcost,sessionid,createddate)
	 VALUES('".$idgroundcost."','".$sessionid."','".$createddate."')");
	}

	$totalsum=0;
	$groundsql = mysql_query("Select a.*,b.*,c.* from tbl_tempseatblock as a, tbl_ground as b, tbl_groundcost as c
	where a.idgroundcost=c.idgroundcost and c.idground=b.idground and a.sessionid='$sessionid'");
	while($row = mysql_fetch_assoc($groundsql))
	{
		$totalsum = $totalsum + $row['amount'];
	}

	 $percentageamount = ($totalsum/100)*$groundpercentage;
	 $percentageamount = number_format((float)$percentageamount, 2, '.', '');
	 $taxpercentage = (($percentageamount)/100)*12.36;
	 $taxpercentage = number_format((float)$taxpercentage, 2, '.', '');
	 $onlinepercentage = number_format((float)15, 2, '.', '');;
	 
	 if($totalsum==0)
	 {
	 $totalamount = ($totalsum+$percentageamount+$taxpercentage+$onlinepercentage);
	 $table="";
	 }
	 else
	 {
	 
	 $totalamount = ($percentageamount+$taxpercentage+$onlinepercentage);
	 $totalamount = (round($totalamount,2));
	 	 $totalamount = number_format((float)$totalamount, 2, '.', '');
	 $totalsum = number_format((float)$totalsum, 2, '.', '');;

	 $table="<div class='col-sm-3 col-md-2'>
						<div class='txtr font12'>
							<p class='base-price'>Base Amt : <span class='pad-l10 secondary-color price-block'>$totalsum</span></p>
							<p>Booking Amt: <span class='pad-l10 secondary-color price-block'>$percentageamount</span></p>
							<p>Service Tax : <span class='pad-l10 secondary-color price-block'>$taxpercentage</span></p>
							<p>Online fees : <span class='pad-l10 secondary-color price-block'>$onlinepercentage</span></p>
							<p class='font14-sm'>Total Amt : <span class='pad-l10 secondary-color price-block'>$totalamount</span></p>
						</div>
						<button class='btn btn-primary btn-block mar-b15' onclick='registerpage();'>Continue</button>                   
					</div>";
	 }

 
 echo $table;
