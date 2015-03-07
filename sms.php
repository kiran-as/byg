<?php
   $xml_data ='<?xml version="1.0"?><smslist><sms><user>ground</user><password>123456</password>
<message>BookYourGround BookingID BYGINV778480. Time 06:00-07:00, for Football on 2015-01-19 at GIS Indoor. Support +91-8095 887000
</message>
<mobiles>9538130954</mobiles>
<senderid>bkgrnd</senderid>
</sms></smslist>';  
echo $xml_data;
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
			print_r($output);
			exit;

?>