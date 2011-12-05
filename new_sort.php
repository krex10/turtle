<?php
session_start();

if (!isset($_SESSION)) { echo "Session not set, please verify cookie settings and reload the page"; exit;}
include "config.php";
$var = @$_GET['q'] ;
$s = @$_GET['s'];
$sort = @$_GET['sort'];
//sort
if (!$sort)
	{$sort = "rating"; $_SESSION['sort'] = $sort; }
else
	{$_SESSION['sort'] = $sort;}
//filter
$trimmed = trim($var); //trim whitespace from the stored variable
$supertrimmed = mysql_escape_string($trimmed);
// rows to return
$limit=5; 
// check for an empty string and display a message.
if ($supertrimmed == "")
{
	echo "{'error' : 'Your search was empty'}";
	exit;
}
// check for a search parameter
if (!isset($var))
{
	echo "{'error' : 'We dont seem to have a search parameter!'}";
	exit;

}
$query = "Select * from temp where address like \"%$supertrimmed%\" ORDER BY $sort"; 
$numresults=mysql_query($query) or die ($query);
$numrows=mysql_num_rows($numresults); 
if ($numrows == 0)
{
	echo "{\"error_msg\": \"null_query\"}";
	exit;
}
else { 
	// next determine if s has been passed to script, if not use 0
	if (empty($s)) {
		$s=0;
	}
	// get results
	$query .= " limit $s,$limit";
	$result = mysql_query($query) or die("Couldn't execute query");
	$numrows=mysql_num_rows($result); 
	// display what the person searched for
	$count = 1;
	echo "{\"result\":[";
	while ($row= mysql_fetch_array($result)) { 
		if ($count >= $numrows || $count >= $limit)
			{ echo "{ \"cost\":\"" . $row['cost'] ."\", \"distance\":\"" . $row['distance'] ."\"}"; break; }
		echo "{ \"cost\":\"" . $row['cost'] ."\", \"distance\":\"" . $row['distance'] ."\"},";
		$count++;
	}
	echo "], \"numrows\": \"".$numrows."\"}";
}
?>