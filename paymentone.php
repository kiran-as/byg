<?php
$data='123.45|aditya@instamojo.com|Aditya Sengupta|9821485060';

$data_sign = 'f090211756f7bc80f4a93ad26e9286fa2c9775fe';

$data_amount =urlencode("123.45");
$data_email = urlencode("aditya@instamojo.com");
$data_name = urlencode("Aditya Sengupta") ;
$data_phone = urlencode("9821485060") ;
/*https://www.instamojo.com/demo/demo-offer/?data_readonly=data_
name&data_readonly=data_email&data_readonly=data_phone&data_
readonly=data_amount&data_readonly=data_&data_sign=
6f905be9811990707f9d833da8e93bfebb23abbc&data_email=aditya@
instamojo.com&data_amount=123.45&data_name=Aditya+Sengupta&
data_phone=9821485060;
 */
$query_string = "data_amount={$data_amount}&data_sign={$data_sign}&data_amount={$data_amount}&data_name={$data_name}&data_phone={$data_phone}";
$url = " https://www.instamojo.com/demo/demo-offer/?" . $query_string;
echo $url ;
echo "<script>parent.location='$url'</script>";
exit;
?>
