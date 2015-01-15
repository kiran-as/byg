<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../application/conn.php");

$idground = $_POST['idgrounds'];
	   $playdate = date('Y-m-d', strtotime($_SESSION['datepicker']));							  
	   $playdatesql = mysql_query("Select a.*,b.* 
								  from tbl_groundcost as a, tbl_groundtime as b
								  where a.idgroundtime=b.idgroundtime and a.idground='$idground' and a.playdate='$playdate'
								  and a.status='Active'");
								  $i=0;
	   while($row =  mysql_fetch_assoc($playdatesql))
	   {
			$playdatesqlarray[$i]['idgroundcost'] = $row['idgroundcost'];	
			$playdatesqlarray[$i]['amount'] = $row['amount'];
			$playdatesqlarray[$i]['idgroundtime'] = $row['idgroundtime'];
			$playdatesqlarray[$i]['fromtime'] = $row['fromtime'];
			$playdatesqlarray[$i]['totime'] = $row['totime'];
			$i++;
	   } 	

	   $bookedseatsarray = array();
$bookedseat = mysql_query("Select idgroundcost from tbl_invoicedetails where status='Booked'");
$i=0;
while($row = mysql_fetch_assoc($bookedseat))
{
    $bookedseatsarray[$i] = $row['idgroundcost'];
	$i++;
}
$sessionid = session_id();
$bookedseattemp = mysql_query("Select idgroundcost from tbl_tempseatblock where sessionid!='$sessionid'");
while($row = mysql_fetch_assoc($bookedseattemp))
{
    $bookedseatsarray[$i] = $row['idgroundcost'];
	$i++;
}

$table="<div class='primary-box clearfix pad-t15 brd-btm'><div role='form' class='col-sm-9 col-md-10 pad0'> ";
for($i=0;$i<count($playdatesqlarray);$i++){
         $idgroundcost = $playdatesqlarray[$i]['idgroundcost'];
         $fromtime = $playdatesqlarray[$i]['fromtime'];
         $totime = $playdatesqlarray[$i]['totime'];		 
		 $amount = $playdatesqlarray[$i]['amount'];
        if(in_array($idgroundcost,$bookedseatsarray)){
            $table.="<div class='form-group col-sm-2 col-xs-4'>
                   <label class='control-label dblock font12 clearfix'><span class='pull-left'>$fromtime</span><span class='pull-right'>$totime</span></label>
                    <button type='button' class='slot slot-booked'>Booked</button>                                     
                  </div>";
		} else if($playdatesqlarray[$i]['amount']<1) {
		   $table.="<div class='form-group col-sm-2 col-xs-4'>
                   <label class='control-label dblock font12 clearfix'><span class='pull-left'>$fromtime</span><span class='pull-right'>$totime</span></label>
                    <button type='button' class='slot slot-reserved'>N/A</button>                                     
                  </div>";
		} else {
		$table.="<div class='form-group col-sm-2 col-xs-4' id='availableslot$idgroundcost'>
                   <label class='control-label dblock font12 clearfix'><span class='pull-left'>$fromtime</span><span class='pull-right'>$totime</span></label>
                    <button type='button' class='slot' id='amount[$idgroundcost]' onClick='fnbookslot(&#39;$idgroundcost&#39;,1,&#39;$idground&#39;)';>Rs $amount</button>                                     
                  </div>";
	    $table.="<div class='form-group col-sm-2 col-xs-4' id='completedslot$idgroundcost' style='display:none'>
                   <label class='control-label dblock font12 clearfix'><span class='pull-left'>$fromtime</span><span class='pull-right'>$totime</span></label>
                    <button type='button' class='slot slot-selected' id='amount[$idgroundcost] name='amount[]' onclick='fnbookslot(&#39;$idgroundcost&#39;,2,&#39;$idground&#39;)';>Selected</button>                                     
                  </div>";
 $table.="<div class='form-group col-sm-2 col-xs-4' id='bookedslot
 $idgroundcost' style='display:none'>
                   <label class='control-label dblock font12 clearfix'><span class='pull-left'>$fromtime</span><span class='pull-right'>$totime</span></label>
                    <button type='button' class='slot slot-booked' id='amount[$idgroundcost] name='amount[]'>Booked</button>                                     
                  </div>";				  
	   }
   $table.="";
  }

$table.="</div><div id='paymentdisplay$idground'></div>";
echo $table;
?>