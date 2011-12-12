$(function() {
	$( "#slider-range-min" ).slider({
		range: "min",
		value: (!(typeof max_dist === 'undefined')) ? max_dist : 15,
		min: 1,
		max: 30,
		slide: function( event, ui ) {
			$( "#distance" ).val( ui.value + " km" );
		}
	});
	$( "#distance" ).val( $( "#slider-range-min" ).slider( "value" ) + " km" );
});


$(function() {
	$( "#slider-range-min" ).slider({
		stop: function(event, ui) { 
			var max_dist = $( "#slider-range-min" ).slider( "value" );
			filter = "max_dist_"+max_dist;
			get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=&filter='+filter;
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				news = 0;
				prevs = 0; totalrows = result.totalrows;
				if (result.error_msg != 'null_query') {
					for (i=0; i < numrows; i++) {
						document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
						document.getElementById("dist"+i).innerHTML = result.result[i].distance;
						padding = result.result[i].distance * 15;
						padding_left = padding+"px";
						document.getElementById("pad_dist"+i).style.paddingLeft = padding_left;
						news++;				
					}
					if (numrows < 5) {
						for (i= 4; i >= numrows ; i--) {
							document.getElementById("cost"+i).style.visibility = "hidden";
							document.getElementById("dist"+i).style.visibility = "hidden";
						}
					}
					document.getElementById("prev_show").style.visibility = "hidden";
					document.getElementById("showing_results").innerHTML = 
					"<p class='showing'>Showing results 1 to 5 of "+totalrows+"</p>";
				}
				else{
					for (i= 0; i < 5; i++) {
						document.getElementById("cost"+i).style.visibility = "hidden";
						document.getElementById("dist"+i).style.visibility = "hidden";
					}
				}
			});
		}
	});
});
