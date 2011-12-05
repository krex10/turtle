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
$filter = @$_GET['filter'];
$no_filter = $filter;
	if ($filter == 'no_utils') {$filter = 'utils_included'; $filter_var = "No";}
	else if ($filter == 'no_lease') {$filter = 'lease_required' ; $filter_var = "No";}
	else if ($filter == 'no_furnished') {$filter = 'furnished' ; $filter_var = "No";}
	else { $filter_var = "Yes"; }
if (!$filter)
	{$filter = "";}
else { $_SESSION['filter'] = $filter; }
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
if (!$filter)
	{ $query = "Select * from temp where address like \"%$supertrimmed%\" ORDER BY $sort"; }
else 
	{$query = "Select * from temp where address like \"%$supertrimmed%\" AND $filter = '$filter_var' ORDER BY $sort";}
$numresults=mysql_query($query) or die ($query);
$numrows=mysql_num_rows($numresults); 
if ($numrows == 0)
{
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

	// display what the person searched for
	$count = 0;
	$test_count = 1;
	echo "{\"result\":[";
	while ($row= mysql_fetch_array($result)) { 
		$count++;
		if ($test_count >= $limit)
			{ echo "{ \"cost\":\"" . $row['cost'] ."\", \"distance\":\"" . $row['distance'] ."\"}"; break; }
		echo "{ \"cost\":\"" . $row['cost'] ."\", \"distance\":\"" . $row['distance'] ."\"},";
		$test_count++;
	}
	echo "]}";
}
?>