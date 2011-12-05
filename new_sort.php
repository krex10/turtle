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
$pattern = "_yes";
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
if ($filter) {
	$exists = 0;
	foreach($filter_array as $f) {
		if(preg_match($filter, $f))
			$exists = 1;
	}
	//find which filter it is and insert yes/no
	/*
	if (!$exists) { 
		preg_match();
		array_push ($filter_array, $filter);
		if(preg_match($pattern, $filter))
			array_push ($filter_var, "Yes");
		else
			array_push ($filter_var, "No");
	}
	$array_length = count($filter_array);
	$query = "Select * from temp where address like \"%$supertrimmed%\" WHERE";
	/*for ($i = 0; $i < $array_length; $i++) {
			$query .= "$filter_array[$i] = $filter_var[$i] AND"; 
	}
	$query .= "$filter_array[$i] = $filter_var[$i]"; }
	$query .= "ORDER BY $sort";*/
}
else {
	$query = "Select * from temp where address like \"%$supertrimmed%\" ORDER BY $sort"; 
}
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