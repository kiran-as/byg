<?php
session_start();
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED);

$dbuser="root";
$dbpass="";
$dbname="package";  //the name of the database
$chandle = mysql_connect("localhost", $dbuser, $dbpass) 
    or die("Connection Failure to Database");
mysql_select_db($dbname, $chandle) or die ($dbname . " Database not found. " . $dbuser);


/*
$host="203.124.112.130";
$dbuser="packageinfo";
$dbpass="packageinfo#2K";
$dbname="packageinfo";
$chandle = mysql_connect($host, $dbuser, $dbpass) 
    or die("Connection Failure to Database");
mysql_select_db($dbname, $chandle) or die ($dbname . " Database not found. " . $dbuser);
*/

?>