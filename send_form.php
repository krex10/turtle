<?php/*
include "config.php";
session_start();
if (!isset($_SESSION)) { echo "Session not set, please verify cookie settings and reload the page"; exit;}
include "config.php";
$var = @$_GET['msg'] ;
$trimmed = trim($var); //trim whitespace from the stored variable
$supertrimmed = mysql_escape_string($trimmed);
if (mail("kavi_nessen@hotmail.com", "Turtle Contact", $supertrimmed)) {
	?> <p>Thank you for providing us with feedback.</p> <?
}*/
?>

