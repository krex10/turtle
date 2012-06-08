function map_load() {
	var myLatlng = new google.maps.LatLng(43.4690, -80.5433);
    var myOptions = {
      center: myLatlng,
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById("map_canvas"),
        myOptions);

	var marker = new google.maps.Marker({
		      position: myLatlng,
		      map: map,
		      title:"UW",
		      icon: "uw school.png"
		  });
}