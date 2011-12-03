<?php
include "config.php";
$query = "Select * from temp";
$result = mysql_query($query) or die("Couldn't execute query");
$min_price = 0;
$min_cost_query = "select MIN(cost) from temp";
$min_cost_result = mysql_query($min_cost_query) or die ("Second query Failed");
$min_cost_array = mysql_fetch_array ($min_cost_result);
while ($row= mysql_fetch_array($result)) {
		$rating=0;
		if ($row['lease_required'] == 'Yes')
			{$lease_bonus = 20;}
		if ($row['utils_included'] == 'No')
			{$utils_bonus = 40;}
		if ($row['furnished'] == 'No')
			{$furnished_bonus = 40;}
		if ($row['furnished'] == 'Yes')
			{$furnished_bonus = 15;}
		$room_bonus = 20/$row['empty_rooms'];
		$price_bonus = $row['cost'] - $min_cost_array[0];
		$distance_bonus = $row['distance'] * 10;
		$total_bonus = $price_bonus + $room_bonus + $distance_bonus + $lease_bonus + $utils_bonus + $furnished_bonus;
		$rating = $rating + $total_bonus;
		$update_query = "Update temp set rating = '{$rating}' where address = '{$row['address']}' and cost = '{$row['cost']}'";
		$update = mysql_query($update_query) or die("Couldn't execute query");
		echo $rating . "\n";
}

?>