function specific_info (next_page) {
	if (!next_page) { next_page = 0; }
	get_link = 'new_sort.php?q='+query+'&s='+next_page;
	$.get(get_link, function(data) {
		result = $.parseJSON(data);
		numrows = result.numrows;
		totalrows = result.totalrows; deleteOverlays();
		if (result.error_msg != 'null_query') {
			for (i=0; i < numrows; i++) {
				document.getElementById("dialog"+i).style.display = "none";
				document.getElementById("dialog"+i).innerHTML = "Address: "+result.result[i].address+
																"<br/>Price: $"+result.result[i].cost+
																"<br/>Distance: "+result.result[i].distance+" km"+
																"<br/>Utilities included: "+result.result[i].utils+
																"<br/>Furnished: "+result.result[i].furnished+
																"<br/>Lease required: "+result.result[i].lease+
																"<br/>Rentalid: "+result.result[i].rentalid+
																"<br/>Description: "+result.result[i].desc;
				Lat_Long = new google.maps.LatLng(result.result[i].lat, result.result[i].longitude);
				addMarker (Lat_Long);
			}
			$("#dist0").on("click", function () {
				$("#dialog0").dialog({ 
					autoOpen: false,
					modal: true
				});
				$("#dialog0").dialog('open');
			});
			$("#dist1").on("click", function () {
				$("#dialog1").dialog({ 
					autoOpen: false,
					modal: true
				});
				$("#dialog1").dialog('open');
			});
			$("#dist2").on("click", function () {
				$("#dialog2").dialog({ 
					autoOpen: false,
					modal: true
				});
				$("#dialog2").dialog('open');
			});
			$("#dist3").on("click", function () {
				$("#dialog3").dialog({ 
					autoOpen: false,
					modal: true
				});
				$("#dialog3").dialog('open');
			});
			$("#dist4").on("click", function () {
				$("#dialog4").dialog({ 
					autoOpen: false,
					modal: true
				});
				$("#dialog4").dialog('open');
			});
		}
		else {
			console.log("Specific info failed");
		}
	});
}