<?php
	// Server login details
	$host = "localhost";
	$user = "admin";
	$pass = "Nakatian1!";
	$database = "studen89_turtle";
	// Connecting to MySQL server now...
	mysql_connect("$host","studen89_admin","Nakatian1!") or die (mysql_error());
	// Select database
	mysql_select_db ("studen89_turtle") or die (mysql_error());
	// Email address
	$your_email = "kavi_nessen@hotmail.com";
	// Website Link
	$your_site = "http://www.studentprotocol.com";

?>