<?php
include "config.php";
define("MAPS_HOST", "maps.google.ca");
define("KEY", "AIzaSyDK1vuOeBWL4n2g7IZtmeiTnOhh4QoJ7Dw");
$query = "Select * from temp where distance = 0";
$result = mysql_query($query) or die("Couldn't execute query");
$delay = 100000;
$base_url = "http://" . MAPS_HOST . "/maps/geo?output=xml" . "&key=" . KEY;
$counter = 0;
while ($row = mysql_fetch_array($result)) {
	  $geocode_pending = true; 
	  while ($geocode_pending) {
	    $address = $row['address'];
	    $id = $row['rentalId'];
	    $request_url = $base_url . "&q=" . urlencode($address);

		//cURL Geocodes
		$cURL = curl_init();
		// Set the URL to execute
		curl_setopt($cURL, CURLOPT_URL, $request_url);
		// Set options. More info at http://my.php.net/curl-setopt
		curl_setopt($cURL, CURLOPT_HEADER, 0);
		curl_setopt($cURL, CURLOPT_RETURNTRANSFER, 1);
		// Execute, saving results in a variable
		$result_xml = curl_exec($cURL);
		$xml = simplexml_load_string($result_xml);
		// Close CURL resource
		curl_close($cURL);
		$status = $xml->Response->Status->code;

		if (strcmp($status, "620") == 0) {
	      	// sent geocodes too fast
	      	$delay += 100000;
		  	echo "620 loop\n";
			$geocode_pending = false;
	    } 

		else if (strcmp($status, "200") == 0) {
			//Successful geocode
			$geocode_pending = false;
			$coordinates = $xml->Response->Placemark->Point->coordinates;
			$coordinatesSplit = split(",", $coordinates);
			// Format: Longitude, Latitude, Altitude
			$lat = (float)$coordinatesSplit[1];
			$lng = (float)$coordinatesSplit[0];
			$query = "Update temp set lat = '{$lat}', longitude = '{$lng}' where rentalId = '{$id}'";
			$update_result = mysql_query($query);;
			if (!$update_result) {
				die("Invalid query: " . mysql_error());
			}
			else {
				echo $id. " successfully geocoded. ";
				//cURL Geocodes
				$cURL_dist = curl_init();
				// Set the URL to execute
				$request_url_dist = "http://maps.googleapis.com/maps/api/distancematrix/xml?origins=".$lat.",".$lng."&destinations=43.473057,-80.540102&sensor=false";
				curl_setopt($cURL_dist, CURLOPT_URL, $request_url_dist);
				// Set options. More info at http://my.php.net/curl-setopt
				curl_setopt($cURL_dist, CURLOPT_HEADER, 0);
				curl_setopt($cURL_dist, CURLOPT_RETURNTRANSFER, 1);
				// Execute, saving results in a variable
				$result_xml_dist = curl_exec($cURL_dist);
				$xml_dist = simplexml_load_string($result_xml_dist);
				// Close CURL resource
				curl_close($cURL_dist);
				$dist = (float)($xml_dist->row[0]->element->distance->value)/1000;
				$query_dist = "Update temp set distance = ".$dist." where rentalId = ".$id."";
				$update_result_dist = mysql_query($query_dist);;
				if (!$update_result_dist) {
					die("Invalid query: " . mysql_error());
				}
				else {
					echo $id. " successfully distanced with ".$dist." km.\n";
					$counter++;
				}
			}
		}

		else {
			// failure to geocode
	      	$geocode_pending = false;
			echo "Address: ".$address. "failed to geocode.\n";
			echo "Received Status: ".$status."\n";
	    }
	    usleep($delay);
	  }
}
echo "Addresses successful: ". $counter;
?>