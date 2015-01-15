<?php
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);
include("../application/conn.php");
$idgroundadmin = $_GET['idgroundadmin'];
$editgroundsql = mysql_query("Select * from tbl_groundadmin where idgroundadmin='$idgroundadmin'");
while($row = mysql_fetch_assoc($editgroundsql))
{
   $email = $row['email'];
   $password = $row['password'];
   $username = $row['username'];
}
if($_POST)
{
    $idgroundadmin = $_GET['idgroundadmin'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    mysql_query("Update tbl_groundadmin set email='$email' , password='$password', username='$username'
                where idgroundadmin='$idgroundadmin'");
	echo "<script>parent.location='groundadminindex.php'</script>";
	exit;
}
?>
<html>
<head>
<form name='' action='' method='POST'>
<table>
    <tr>
	    <td>
		    <input type='text' name='email' id='email' value='<?php echo $email;?>'>
		</td>
		<td>
		    <input type='text' name='password' id='password' value='<?php echo $password;?>'>
		</td>
		 <td>
		    <input type='text' name='username' id='username' value='<?php echo $username;?>'>
		</td>
		<td><input type='submit' name='Save' id='Save' value='Save'></td>
	</tr>
</table>
</form>
</head>
</html>