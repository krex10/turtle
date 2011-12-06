function more_info () {
		var i;
		var counter = 0; var result; var get_link; var numrows; var padding; var padding_left; var filter;
		$(document).ready(function(){
		$('#next').on("click",function() {
			get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s='+news+'&filter='+filter;
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				prevs = news - 5;
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
					if (news >= 5 && counter == 0) {
						document.getElementById("prev_show").style.visibility = "visible";
					}
					counter++;
				}
				else 
					console.log("SQL QUERY FAILED");
			});
		});
		$('#prev').on("click",function() {
			console.log(prevs);
			get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s='+prevs+'&filter='+filter;
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				if (result.error_msg != 'null_query') {
					for (i=0; i < numrows; i++) {
						document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
						document.getElementById("dist"+i).innerHTML = result.result[i].distance;
						padding = result.result[i].distance * 15;
						padding_left = padding+"px";
						document.getElementById("pad_dist"+i).style.paddingLeft = padding_left;
					}
					news = news - 5;
					prevs = prevs - 5;
					if (prevs <= 5 && counter == 1) {
						document.getElementById("prev_show").style.visibility = "hidden";
					}
					counter--;
				}
				else 
					console.log("SQL QUERY FAILED");
			});
		});
		$('#sort_price').on("click",function() {
			sort = "cost";
			$.get('new_sort.php?q='+query+'&sort='+sort+'&s=&filter='+filter, function(data) {
				news = 5;
				result = $.parseJSON(data);
				numrows = result.numrows;
				for (i=0; i < numrows; i++) {
					document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
					document.getElementById("dist"+i).innerHTML = result.result[i].distance;
					padding = result.result[i].distance * 15;
					padding_left = padding+"px";
					document.getElementById("pad_dist"+i).style.paddingLeft = padding_left;
				}
			});
		});
		$('#sort_distance').on("click",function() {
			sort = "distance";
			$.get('new_sort.php?q='+query+'&sort='+sort+'&s=&filter='+filter, function(data) {
				news = 5;
				result = $.parseJSON(data);
				numrows = result.numrows;
				for (i=0; i < numrows; i++) {
					document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
					document.getElementById("dist"+i).innerHTML = result.result[i].distance;
					var padding = result.result[i].distance * 15;
					var padding_left = padding+"px";
					document.getElementById("pad_dist"+i).style.paddingLeft = padding_left;
				}
			});
		});
		$('#utils_yes').on("click",function() {
			if (filter == "utils_yes") {
				document.getElementById("utils_yes").style.color = "white";
				filter = "";
				get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=0&filter='+filter;
			}
			else { 
				filter = "utils_yes"; 
				get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=0&filter='+filter;
				document.getElementById("utils_yes").style.color = "black";
			}
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				news = 5;
				prevs = 0; a = news; b = prevs +1; totalrows = result.totalrows;
				for (i=0; i < numrows; i++) {
					document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
					document.getElementById("dist"+i).innerHTML = result.result[i].distance;
					padding = result.result[i].distance * 15;
					padding_left = padding+"px";
					document.getElementById("pad_dist"+i).style.paddingLeft = padding_left;
				}
				if (numrows < 5) {
					for (i= 4; i >= numrows ; i--) {
						document.getElementById("cost"+i).style.visibility = "hidden";
						document.getElementById("dist"+i).style.visibility = "hidden";
					}
				}
				document.getElementById("showing_results").innerHTML = 
				"<p class='showing'>Showing results "+b+" to "+a+" of "+totalrows+"</p>";
			});
		});
		$('#utils_no').on("click",function() {
			if (filter == "utils_no") {
				document.getElementById("utils_no").style.color = "white";
				filter = "";
				get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=0&filter='+filter;
			}
			else { 
				filter = "utils_no"; 
				get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=0&filter='+filter;
				document.getElementById("utils_no").style.color = "black";
			}
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows; 
				news = 5;
				prevs = 0; a = news; b = prevs +1; totalrows = result.totalrows;
				for (i=0; i < numrows; i++) {
					document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
					document.getElementById("dist"+i).innerHTML = result.result[i].distance;
					padding = result.result[i].distance * 15;
					padding_left = padding+"px";
					document.getElementById("pad_dist"+i).style.paddingLeft = padding_left;
				}
				if (numrows < 5) {
					for (i= 4; i >= numrows ; i--) {
						document.getElementById("cost"+i).style.visibility = "hidden";
						document.getElementById("dist"+i).style.visibility = "hidden";
					}
				}
				document.getElementById("showing_results").innerHTML = 
				"<p class='showing'>Showing results "+b+" to "+a+" of "+totalrows+"</p>";
			});
		});
		$('#lease_yes').on("click",function() {
			if (filter == "lease_yes") {
				document.getElementById("lease_yes").style.color = "white";
				filter = "";
				get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=0&filter='+filter;
			}
			else { 
				filter = "lease_yes"; 
				get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=0&filter='+filter;
				document.getElementById("lease_yes").style.color = "black";
			}
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				news = 5;
				prevs = 0; a = news; b = prevs +1; totalrows = result.totalrows;
				for (i=0; i < numrows; i++) {
					document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
					document.getElementById("dist"+i).innerHTML = result.result[i].distance;
					padding = result.result[i].distance * 15;
					padding_left = padding+"px";
					document.getElementById("pad_dist"+i).style.paddingLeft = padding_left;
				}
				if (numrows < 5) {
					for (i= 4; i >= numrows ; i--) {
						document.getElementById("cost"+i).style.visibility = "hidden";
						document.getElementById("dist"+i).style.visibility = "hidden";
					}
				}
				document.getElementById("showing_results").innerHTML = 
				"<p class='showing'>Showing results "+b+" to "+a+" of "+totalrows+"</p>";
			});
		});
		$('#lease_no').on("click",function() {
			if (filter == "lease_no") {
				document.getElementById("lease_no").style.color = "white";
				filter = "";
				get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=0&filter='+filter;
			}
			else { 
				filter = "lease_no"; 
				get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=0&filter='+filter;
				document.getElementById("lease_no").style.color = "black";
			}
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				news = 5;
				prevs = 0; a = news; b = prevs +1; totalrows = result.totalrows;
				for (i=0; i < numrows; i++) {
					document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
					document.getElementById("dist"+i).innerHTML = result.result[i].distance;
					padding = result.result[i].distance * 15;
					padding_left = padding+"px";
					document.getElementById("pad_dist"+i).style.paddingLeft = padding_left;
				}
				if (numrows < 5) {
					for (i= 4; i >= numrows ; i--) {
						document.getElementById("cost"+i).style.visibility = "hidden";
						document.getElementById("dist"+i).style.visibility = "hidden";
					}
				}
				document.getElementById("showing_results").innerHTML = 
				"<p class='showing'>Showing results "+b+" to "+a+" of "+totalrows+"</p>";
			});
		});
		$('#furnished_yes').on("click",function() {
			if (filter == "furnished_yes") {
				document.getElementById("furnished_yes").style.color = "white";
				filter = "";
				get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=0&filter='+filter;
			}
			else { 
				filter = "furnished_yes"; 
				get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=0&filter='+filter;
				document.getElementById("furnished_yes").style.color = "black";
			}
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				news = 5;
				prevs = 0; a = news; b = prevs +1; totalrows = result.totalrows;
				for (i=0; i < numrows; i++) {
					document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
					document.getElementById("dist"+i).innerHTML = result.result[i].distance;
					padding = result.result[i].distance * 15;
					padding_left = padding+"px";
					document.getElementById("pad_dist"+i).style.paddingLeft = padding_left;
				}
				if (numrows < 5) {
					for (i= 4; i >= numrows ; i--) {
						document.getElementById("cost"+i).style.visibility = "hidden";
						document.getElementById("dist"+i).style.visibility = "hidden";
					}
				}
				document.getElementById("showing_results").innerHTML = 
				"<p class='showing'>Showing results "+b+" to "+a+" of "+totalrows+"</p>";
			});
		});
		$('#furnished_no').on("click",function() {
			if (filter == "furnished_no") {
				document.getElementById("furnished_no").style.color = "white";
				filter = "";
				get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=0&filter='+filter;
			}
			else { 
				filter = "furnished_no"; 
				get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=0&filter='+filter;
				document.getElementById("furnished_no").style.color = "black";
			}
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				news = 5;
				prevs = 0; a = news; b = prevs +1; totalrows = result.totalrows;
				for (i=0; i < numrows; i++) {
					document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
					document.getElementById("dist"+i).innerHTML = result.result[i].distance;
					padding = result.result[i].distance * 15;
					padding_left = padding+"px";
					document.getElementById("pad_dist"+i).style.paddingLeft = padding_left;
				}
				if (numrows < 5) {
					for (i= 4; i >= numrows ; i--) {
						document.getElementById("cost"+i).style.visibility = "hidden";
						document.getElementById("dist"+i).style.visibility = "hidden";
					}
				}
				document.getElementById("showing_results").innerHTML = 
				"<p class='showing'>Showing results "+b+" to "+a+" of "+totalrows+"</p>";
			});
		});
	});
}
