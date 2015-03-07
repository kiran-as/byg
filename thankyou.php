<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("application/conn.php");

$groundsqlsettings = mysql_query("Select * from tbl_setting");
while($row = mysql_fetch_assoc($groundsqlsettings))
{
    $groundpercentage = $row['groundpercentage'];
}
		//	$_GET['status']='success';
$response = $_GET['status'].'******'.$_GET['payment_id'];
$response = $response.'LOGS';

$file = fopen("logs.txt","a");
fwrite($file,$response);
fclose($file);

if($_GET['status']=='success')
{
   
			
  $name = $_SESSION['customername'];
	$email = $_SESSION['customeremail'];
	$phone = $_SESSION['customermobile'];
	$createdby ='0';
	$date = date('Y-m-d H:i:s');
	$amount =$_SESSION['customeramount'];
	$byginvoiceno = 'BYGINV'.rand(111111,999999);
	mysql_query("Insert into tbl_invoice (name,email,phoneno,createdby,createddate,amount,bookingid)
	 VALUES('".$name."','".$email."','".$phone."','".$createdby."','".$date."','".$amount."','".$byginvoiceno."')");
	 $idinvoice = mysql_insert_id();
	 $sessionid = session_id();
	$tempseatblocksql =  mysql_query("Select * from tbl_tempseatblock where sessionid='$sessionid'");
	 while($row = mysql_fetch_assoc($tempseatblocksql))
	 {
	  $idgroundcost = $row['idgroundcost'];
	  /*echo "Insert into tbl_invoicedetails (idinvoice,idgroundcost)
	 VALUES('".$idinvoice."','".$idgroundcost."')";*/
		mysql_query("Insert into tbl_invoicedetails (idinvoice,idgroundcost)
	 VALUES('".$idinvoice."','".$idgroundcost."')");
	 }

	  $sessionid = session_id();
	$groundtime ='';
	 $groundsql = mysql_query("Select a.*,b.*,c.*,d.*,e.* from 
	                           tbl_tempseatblock as a, 
							   tbl_ground as b, 
							   tbl_groundcost as c, 
							   tbl_groundtime as d, tbl_sport as e 
	where a.idgroundcost=c.idgroundcost and c.idground=b.idground  and c.idgroundtime=d.idgroundtime and b.idsport=e.idsport and a.sessionid='$sessionid' order by c.idgroundcost asc");
	$i=0;
	while($row = mysql_fetch_assoc($groundsql))
	{
	$groundtime .= $row['fromtime'].'-'.$row['totime'].' ';
		 $groundname = $row['groundname'];
		 $address = $row['address'];
		$totalsum = $totalsum + $row['amount'];
		$playdate = $row['playdate'];
		$shortname = $row['shortname'];
		$sportname = $row['sportname'];
		$mobile = $row['mobile'];
		$i++;
	}
	$message = "<table>
                   <tr>
                       <td>Ground Name</td>
                       <td>$groundname</td>
                    </tr>
                    <tr>
                       <td>Address</td>
                       <td>$address</td>
                    </tr>
                    <tr>
                       <td>Booked Date</td>
                       <td>$playdate</td>
                    </tr>
                    <tr>
                       <td>Timings</td>
                       <td>$groundtime</td>
                    </tr>
                    <tr>
                       <td>Booked By</td>
                       <td>$name</td>
                    </tr>
                    <tr>
                       <td>Contact No</td>
                       <td>$phone</td>
                    </tr>";
$to = $email;
$subject = "Play ground booking confirmation-".$byginvoiceno;  
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From:support@bookyourground.com' . "\r\n";
$headers .= 'Cc:brinoj@gmail.com' . "\r\n";
/*echo $to;
echo $subject;
echo $message;
echo $headers;*/
$res = mail($to,$subject,$message,$headers);
/*print_r($res);
echo "mail";
exit;*/
$amountss = 0;
	 $sql = mysql_query("SELECT a.amount as baseamount,a.*,c.*,b.*
						FROM `tbl_groundcost` as a,
							  tbl_invoicedetails as b,
							  tbl_invoice as c
						 WHERE a.idgroundcost=b.idgroundcost and 
							   b.idinvoice=c.idinvoice and c.idinvoice='$idinvoice'");
							  /* echo "SELECT a.amount as baseamount,a.*,c.*,b.*
						FROM `tbl_groundcost` as a,
							  tbl_invoicedetails as b,
							  tbl_invoice as c
						 WHERE a.idgroundcost=b.idgroundcost and 
							   b.idinvoice=c.idinvoice and c.idinvoice='$idinvoice'";*/
while($row = mysql_fetch_assoc($sql))
{
    $amountss = $amountss+$row['baseamount'];
	
}
	$balanceamount = $amountss - (($amountss/100)*$groundpercentage);	

							   
  $sessionid = session_id();
   mysql_query("Delete from tbl_tempseatblock where sessionid='$sessionid'");
  $congrates = 1;
   
  $xml_data ='<?xml version="1.0"?><smslist><sms><user>ground</user><password>123456</password>
<message>BookYourGround BookingID '.$byginvoiceno.'. Time '.$groundtime.' for '.$sportname.' on '.$playdate.' at '.$shortname.'.Balance to be paid:'.$balanceamount.'+Tax Support +91-8095 887000</message>
<mobiles>'.$phone.'</mobiles>
<senderid>BKGRND</senderid>
</sms></smslist>';  
//echo $xml_data;
$URL = "http://sms.jootoor.com/sendsms.jsp?"; 

			$ch = curl_init($URL);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
			curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch); 
			//print_r($output); 
			
			
$xml_data ='<?xml version="1.0"?><smslist><sms><user>ground</user><password>123456</password>
<message>BookYourGround, Name:'.$name.' , Phone:'.$phone.', BookingID '.$byginvoiceno.'. Time '.$groundtime.' for '.$sportname.' on '.$playdate.' at '.$shortname.'</message>
<mobiles>'.$mobile.'</mobiles>
<senderid>BKGRND</senderid>
</sms></smslist>';  
//echo $xml_data;
$URL = "http://sms.jootoor.com/sendsms.jsp?"; 

			$ch = curl_init($URL);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
			curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);
			curl_close($ch); 				
			
}

$resultgroundlocationsql = mysql_query("Select * from tbl_location");
$s=0;
while ($row = mysql_fetch_assoc($resultgroundlocationsql)) {
  $arraylocation[$s]["idlocation"]	= $row["idlocation"];
  $arraylocation[$s]["locationname"]	= $row["locationname"];
  $s++;  
}

$sportsql = mysql_query("Select * from tbl_sport");
$s=0;
while ($row = mysql_fetch_assoc($sportsql)) {
  $arraysport[$s]["idsport"]	= $row["idsport"];
  $arraysport[$s]["sportname"]	= $row["sportname"];
  $s++;  
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Your Ground</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/main.css" rel="stylesheet">

	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
</head>
<body>   
        <div class="container mar-t30 mh500">
        <div class="row">
           <div class="col-md-8 col-md-offset-2">    
                <div class="secondary-box clearfix mh-md-375">
                <div class="pad-l20 pad-t5 pad-b5 brd-btm txtc">
                   <a href="index.php" class="logo logo--small mar-t10 mar-b10">Book Your Ground</a>              
                </div>
                <div class="clearfix pad-sm-t20 hpad-xs-20">
                <div class="txtc brd-btm pad-b15">
                <img src="img/smile_icon.png" class="pad-t20" />
                <h1 class="primary-title">Thank you for booking the ground!</h1>  
                </div>
<form class="form-horizontal pad-t20" role="form">
                          <div class="form-group mar-sm-b0">
                            <label class="col-sm-4 control-label">Ground Name -</label>
                            <div class="col-sm-8">
                              <p class="form-control-static font14-sm"><?php echo $groundname;?></p>
                            </div>
                          </div>
                          
                          <div class="form-group mar-sm-b0">
                            <label class="col-sm-4 control-label">Address -</label>
                            <div class="col-sm-8">
                              <p class="form-control-static font14-sm"><?php echo $address;?></p>
                            </div>
                          </div>
                          
                          <div class="form-group mar-sm-b0">
                            <label class="col-sm-4 control-label">Booked Date -</label>
                            <div class="col-sm-8">
                              <p class="form-control-static font14-sm"><?php echo date('d-m-Y',strtotime($playdate));?></p>
                            </div>
                          </div>
                          
                          <div class="form-group mar-sm-b0">
                            <label class="col-sm-4 control-label">Timings -</label>
                            <div class="col-sm-8">
                              <p class="form-control-static font14-sm"><?php echo $groundtime;?></p>
                            </div>
                          </div>                          
                                                                                                                                                                               <div class="form-group mar-sm-b0">
                            <label class="col-sm-4 control-label">Total Hours -</label>
                            <div class="col-sm-8">
                              <p class="form-control-static font14-sm"><?php echo $i;?> hours</p>
                            </div>
                          </div>
                                                                                                                                                                                  
                 
                        </form>                                                                                  
                </div>                                               
                </div>       
                </div>                                             
            </div> 
    </div> 
    
    <footer class="home-footer">
          <div class="container">
           <div class="sm-pull-right">
                <ul class="footer-nav sm-pull-left pad-t5 mar-r20">
                    <li><a href="">About Us</a></li>
                    <li><a href="">Contact Us</a></li>
                    <li><a href="">Terms &amp; Conditions</a></li>
                    <li><a href="">Privacy Policy</a></li>
                    <li><a href="">FAQ</a></li>
                    <li><a href="">How it Works</a></li>
                </ul>
                <ul class="social-media sm-pull-left pad-xs-t20">
                    <li><a href="">Facebook</a></li>
                    <li><a href="" class="twitter">Twitter</a></li>
                    <li><a href="" class="linkedin">Linkedin</a></li>
                </ul>
            </div>            
            <p class="sm-pull-left pad-t5 pad-xs-t20">&copy; 2014 bookyourground All Rights Reserved</p>               
          </div>          
    </footer>  
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   <script src="js/bootstrap.min.js"></script>
  </body>
</html>