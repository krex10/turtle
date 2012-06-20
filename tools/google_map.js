function map_load() {
	myLatlng = new google.maps.LatLng(43.4690, -80.5433);
    myOptions = {
      center: myLatlng,
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    main_map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

	var marker = new google.maps.Marker({
		      position: myLatlng,
		      map: main_map,
		      title:"UW",
		      icon: "uw school.png"
		  });
}

function addMarker(location) {
  	map_marker = new google.maps.Marker({
    	position: location,
    	map: main_map,
		animation: google.maps.Animation.DROP
  	});
	markersArray.push(map_marker);
}

// Removes the overlays from the map, but keeps them in the array
function clearOverlays() {
  if (markersArray) {
    for (i in markersArray) {
      markersArray[i].setMap(null);
    }
  }
}

// Shows any overlays currently in the array
function showOverlays() {
  if (markersArray) {
    for (i in markersArray) {
      markersArray[i].setMap(main_map);
    }
  }
}

// Deletes all markers in the array by removing references to them
function deleteOverlays() {
  if (markersArray) {
    for (i in markersArray) {
      markersArray[i].setMap(null);
    }
    markersArray.length = 0;
  }
}
