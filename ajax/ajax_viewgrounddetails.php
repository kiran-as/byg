<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../application/conn.php");
$playdate = date('Y-m-d',strtotime($_POST['datepicker']));
$idlocation = $_POST['idlocation'];
$idsport = $_POST['idsport'];
$groundlist = mysql_query("Select * from tbl_groundcost where playdate='$playdate' and status='Active' group by idground");
$idground=0;
while($row = mysql_fetch_assoc($groundlist))
{
   $idground .= ','.$row['idground'];
}
$groundsqllist = mysql_query("Select * from tbl_ground where idground in ($idground) and idsport='$idsport' and idlocation='$idlocation'");
$i=0;
while($row = mysql_fetch_assoc($groundsqllist))
{
   $arraygrounddetails[$i]['description'] = $row['description'];
   $arraygrounddetails[$i]['groundname'] = $row['groundname'];
   $arraygrounddetails[$i]['address'] = $row['address'];
   $arraygrounddetails[$i]['idground'] = $row['idground'];
   $i++;
}

if($i==0)
{
   $table="<div class='container mar-t30 mh500'><div class='txtc' id='grounddetails'>No Grounds found for the Above mentioned Date, Please change the search parameters and try again</div></div>";
}
else
{
$table="<div class='container mar-t30 mh500'>
        <div class='row'>
           <div class='col-md-12'>    
                <div class='secondary-box clearfix mh-md-375'>";
for($i=0;$i<count($arraygrounddetails);$i++){
$idground = $arraygrounddetails[$i]['idground'];
$groundname = $arraygrounddetails[$i]['groundname'];
$address = $arraygrounddetails[$i]['address'];
$description = $arraygrounddetails[$i]['description'];

$table.="
                    <div class='clearfix brd-btm pad-t15 pad-b15'>
                        <div class='col-sm-5 col-md-2'>
                            <img src='img/$idground.png' class='img-responsive'/>
                        </div>
                        <div class='col-sm-7 col-md-8'>
                            <h4 class='secondary-color'>$groundname</h4>
                            <p>$address</p>
                           <p>$description</p>
                        </div>
                        <div class='col-sm-4 col-md-2 col-sm-offset-8 col-md-offset-0'>
                            <h3 class='price-color sm-txtr mar-sm-t0'></h3>
                            <button class='btn btn-primary btn-block' onclick='functionviewslot($idground)';>View Slots</button>
                        </div>
                    </div> 
                     <div id='viewseats$idground' class='groundviewseats'></div>";
		 }
		$table.=" </div>       
                </div>
                                               
            </div> 
								
               
    </div> ";
}
echo $table;

?>