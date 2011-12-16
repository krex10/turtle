<?php
session_start();
if (!isset($_SESSION)) { 
	echo "Session not set, please verify cookie settings and reload the page"; 
	exit;
}

include "config.php";
//query ,position # and filter
$var = @$_GET['q'] ;
$s = @$_GET['s'];
$filter = @$_GET['filter'];
$trimmed = trim($var); //trim whitespace from the stored variable
$supertrimmed = mysql_escape_string($trimmed);
$_SESSION['no_refresh'] = $supertrimmed;
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
//first part of query = constant
$query = "Select * from temp where address like \"%$supertrimmed%\"";
//session exists, so initialize working array with Session array
//session does not exist, initialize empty working array
if (isset($_SESSION['filters']))
	$filter_array = $_SESSION['filters'];
else 
	$filter_array = array('utils'=>'None','lease'=>'None','furnished'=>'None', 'max_dist'=>'30', 'sort'=>'rating');
//BUILD FILTERS
if(isset($filter)) {
	//If filter is set to update options: None, Yes, No -> Yes/No
	if(strpos($filter, "yes") || strpos($filter, "no")) {
		//check to see if Filter is Yes/No and set the var
		if(strpos($filter, "yes"))
			{$filter_var = "Yes";}
		else
			{$filter_var = "No";}
		//Update whichever filter was set and set the 2 other from Session
		if(strpos($filter, "utils") === 0) {
			$filter_array['utils'] = $filter_var;
			$query .= "and utils_included = '$filter_array[utils]'";
			if ($filter_array['lease'] != "None")
				$query .= "and lease_required = '$filter_array[lease]'";
			if ($filter_array['furnished'] != "None")
				$query .= "and furnished = '$filter_array[furnished]'";
			if ($filter_array['max_dist'] != "None")
				$query .= "and distance <= '$filter_array[max_dist]'";
		}
		else if (strpos($filter, "lease") === 0) {
			$filter_array['lease'] = $filter_var;
			$query .= "and lease_required = '$filter_array[lease]'";
			if ($filter_array['utils'] != "None")
				$query .= "and utils_included = '$filter_array[utils]'";
			if ($filter_array['furnished'] != "None")
				$query .= "and furnished = '$filter_array[furnished]'";
			if ($filter_array['max_dist'] != "None")
				$query .= "and distance <= '$filter_array[max_dist]'";
		}
		else if (strpos($filter, "furnished") === 0) {
			$filter_array['furnished'] = $filter_var;
			$query .= "and furnished = '$filter_array[furnished]'";
			if ($filter_array['utils'] != "None")
				$query .= "and utils_included = '$filter_array[utils]'";
			if ($filter_array['lease'] != "None")
				$query .= "and lease_required = '$filter_array[lease]'";
			if ($filter_array['max_dist'] != "None")
				$query .= "and distance <= '$filter_array[max_dist]'";
		}
	}
	//If filter is set to reset an option
	else if (strpos($filter, "reset")) {
		$filter_var = "None";
		if(strpos($filter, "utils") === 0) {
			$filter_array['utils'] = $filter_var;
			if ($filter_array['lease'] != "None")
				$query .= "and lease_required = '$filter_array[lease]'";
			if ($filter_array['furnished'] != "None")
				$query .= "and furnished = '$filter_array[furnished]'";
			if ($filter_array['max_dist'] != "None")
				$query .= "and distance <= '$filter_array[max_dist]'";
		}
		else if (strpos($filter, "lease") === 0) {
			$filter_array['lease'] = $filter_var;
			if ($filter_array['utils'] != "None")
				$query .= "and utils_included = '$filter_array[utils]'";
			if ($filter_array['furnished'] != "None")
				$query .= "and furnished = '$filter_array[furnished]'";
			if ($filter_array['max_dist'] != "None")
				$query .= "and distance <= '$filter_array[max_dist]'";
		}
		else if (strpos($filter, "furnished") === 0) {
			$filter_array['furnished'] = $filter_var;
			if ($filter_array['utils'] != "None")
				$query .= "and utils_included = '$filter_array[utils]'";
			if ($filter_array['lease'] != "None")
				$query .= "and lease_required = '$filter_array[lease]'";
			if ($filter_array['max_dist'] != "None")
				$query .= "and distance <= '$filter_array[max_dist]'";
		}
		else if (strpos($filter, "sort") === 0) {
			$filter_array['sort'] = "rating";
			if ($filter_array['furnished'] != "None")
				$query .= "and furnished = '$filter_array[furnished]'";
			if ($filter_array['utils'] != "None")
				$query .= "and utils_included = '$filter_array[utils]'";
			if ($filter_array['lease'] != "None")
				$query .= "and lease_required = '$filter_array[lease]'";
			if ($filter_array['max_dist'] != "None")
				$query .= "and distance <= '$filter_array[max_dist]'";
		}
	}
	else if (strpos($filter, "_dist")) {//distance filter
		$string_length = strlen($filter);//GET THE NUMBER WITH REGEX
		if ($string_length > 10) { $filter_var = substr($filter, -2, 2); } 
		else { $filter_var = substr($filter, -1, 1); }
		$query .= "and distance <= '$filter_var'";
		$filter_array['max_dist'] = $filter_var;
		if ($filter_array['lease'] != "None")
			$query .= "and lease_required = '$filter_array[lease]'";
		if ($filter_array['furnished'] != "None")
			$query .= "and furnished = '$filter_array[furnished]'";
		if ($filter_array['utils'] != "None")
			$query .= "and utils_included = '$filter_array[utils]'";
	}
	else if (strpos($filter, "_sort")) {//price and distance sort
		if (strpos($filter, "ice_sort")) { $filter_var = "cost"; } 
		else { $filter_var = "distance"; }
		$filter_array['sort'] = $filter_var;
		if ($filter_array['lease'] != "None")
			$query .= "and lease_required = '$filter_array[lease]'";
		if ($filter_array['furnished'] != "None")
			$query .= "and furnished = '$filter_array[furnished]'";
		if ($filter_array['utils'] != "None")
			$query .= "and utils_included = '$filter_array[utils]'";
		if ($filter_array['max_dist'] != "None")
			$query .= "and distance <= '$filter_array[max_dist]'";
	}
	$query .= "ORDER BY ". $filter_array['sort'];
	$_SESSION['filters'] = $filter_array;
}
//if no filter was set
else {
	if($filter_array['utils'] != "None") {
		$query .= "and utils_included = '$filter_array[utils]'";
	}
	if($filter_array['lease'] != "None") {
		$query .= "and lease_required = '$filter_array[lease]'";
	}
	if($filter_array['furnished'] != "None") {
		$query .= "and furnished = '$filter_array[furnished]'";
	}
	if($filter_array['max_dist'] != "None") {
		$query .= "and distance <= '$filter_array[max_dist]'";
	}
	$query .= "ORDER BY ". $filter_array['sort'];
	$_SESSION['filters'] = $filter_array;
}
$numresults=mysql_query($query);
$totalrows=mysql_num_rows($numresults);
//if no results returned for query
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
			{ echo "{ \"cost\":\"" . $row['cost'] ."\", \"distance\":\"" . $row['distance'] ."\", \"address\":\"" . $row['address'] ."\", \"utils\":\"" . $row['utils_included'] ."\", \"furnished\":\"" . $row['furnished'] ."\" , \"lease\":\"" . $row['lease_required'] ."\", \"desc\":\"" . trim($row['description']) ."\"}"; break; }
		echo "{ \"cost\":\"" . $row['cost'] ."\", \"distance\":\"" . $row['distance'] ."\", \"address\":\"" . $row['address'] ."\", \"utils\":\"" . $row['utils_included'] ."\", \"furnished\":\"" . $row['furnished'] ."\" , \"lease\":\"" . $row['lease_required'] ."\", \"desc\":\"" . trim($row['description']) ."\"},";
		$count++;
	}
	echo "], \"numrows\": \"".$numrows."\", \"totalrows\": \"".$totalrows."\", \"debug\": \"".$numrows."\"}";
}
?>