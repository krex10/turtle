<?php
session_start();

if (!isset($_SESSION)) { 
	echo "Session not set, please verify cookie settings and reload the page"; 
	exit;
}

include "config.php";
//query and position #
$var = @$_GET['q'] ;
$s = @$_GET['s'];
//sort
$sort = @$_GET['sort'];
if (!$sort)
	{$sort = "rating";}
//set filters
$filter = @$_GET['filter'];
$pattern = "yes";
$filter_array = array("utils" => "None", "lease" => "None", "furnished" => "None");
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

$query = "Select * from temp where address like \"%$supertrimmed%\"";
//BUILD FILTER AND QUERY
if(strpos($filter, $pattern))
	$filter_var = "Yes";
else
	$filter_var = "No" ;
if(strpos($filter, "utils") === 0) {
	$filter_array['utils'] = $filter_var;
	$query .= "and utils_included = '$filter_array[utils]'";
}
else if(strpos($filter, "lease") === 0) {
	$filter_array['lease'] = $filter_var;
	$query .= "and lease_required = '$filter_array[lease]'";
}
else if(strpos($filter, "furnished") === 0) {
	$filter_array['furnished'] = $filter_var;
	$query .= "and furnished = '$filter_array[furnished]'";
}
$query .= "ORDER BY $sort";

$numresults=mysql_query($query) or die ($query);
$totalrows=mysql_num_rows($numresults); 
if ($totalrows == 0)
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
	echo "], \"numrows\": \"".$numrows."\", \"totalrows\": \"".$totalrows."\"}";
}
?>