function more_info () {
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
					a = news; b = news - 4; totalrows = result.totalrows;
					document.getElementById("showing_results").innerHTML = 
					"<p class='showing'>Showing results "+b+" to "+a+" of "+totalrows+"</p>";
				}
				else{
					for (i= 0; i < 5; i++) {
						document.getElementById("cost"+i).style.visibility = "hidden";
						document.getElementById("dist"+i).style.visibility = "hidden";
					}
				}
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
					prevs = prevs - 5; a = news; b = prevs +1; totalrows = result.totalrows;
					if (prevs <= 5 && counter == 1) {
						document.getElementById("prev_show").style.visibility = "hidden";
					}
					counter--;
					a = news; b = news - 4; totalrows = result.totalrows;
					document.getElementById("showing_results").innerHTML = 
					"<p class='showing'>Showing results "+b+" to "+a+" of "+totalrows+"</p>";
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
				if (result.error_msg != 'null_query') {
					for (i=0; i < numrows; i++) {
						document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
						document.getElementById("dist"+i).innerHTML = result.result[i].distance;
						padding = result.result[i].distance * 15;
						padding_left = padding+"px";
						document.getElementById("pad_dist"+i).style.paddingLeft = padding_left;
					}
					document.getElementById("sort_price").style.color = "black";
				}
				else 
					console.log("SQL QUERY FAILED");
			});
		});
		$('#sort_distance').on("click",function() {
			sort = "distance";
			$.get('new_sort.php?q='+query+'&sort='+sort+'&s=&filter='+filter, function(data) {
				news = 5;
				result = $.parseJSON(data);
				numrows = result.numrows;
				if (result.error_msg != 'null_query') {
					for (i=0; i < numrows; i++) {
						document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
						document.getElementById("dist"+i).innerHTML = result.result[i].distance;
						var padding = result.result[i].distance * 15;
						var padding_left = padding+"px";
						document.getElementById("pad_dist"+i).style.paddingLeft = padding_left;
					}
					document.getElementById("sort_distance").style.color = "black";
				}
				else 
					console.log("SQL QUERY FAILED");
			});
		});
		$('#utils_yes').on("click",function() {
			if (document.getElementById("utils_yes").style.color == "black") {
				document.getElementById("utils_yes").style.color = "white";
				filter = "utils_reset";
			}
			else { 
				filter = "utils_yes"; 
				document.getElementById("utils_yes").style.color = "black";
				document.getElementById("utils_no").style.color = "white";
			}
			get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=&filter='+filter;
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				news = 5;
				prevs = 0; a = news; b = prevs +1; totalrows = result.totalrows;
				if (result.error_msg != 'null_query') {
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
				}
				else {
					for (i= 0; i < 5; i++) {
						document.getElementById("cost"+i).style.visibility = "hidden";
						document.getElementById("dist"+i).style.visibility = "hidden";
					}
					document.getElementById("showing_results").innerHTML = 
					"<p class='showing'>No results were found</p>";
				}
			});
		});
		$('#utils_no').on("click",function() {
			if (document.getElementById("utils_no").style.color == "black") {
				document.getElementById("utils_no").style.color = "white";
				filter = "utils_reset";
			}
			else { 
				filter = "utils_no"; 
				document.getElementById("utils_no").style.color = "black";
				document.getElementById("utils_yes").style.color = "white";
			}
			get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=0&filter='+filter;
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows; 
				news = 5;
				prevs = 0; a = news; b = prevs +1; totalrows = result.totalrows;
				if (result.error_msg != 'null_query') {
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
				}
				else {
					for (i= 0; i < 5; i++) {
						document.getElementById("cost"+i).style.visibility = "hidden";
						document.getElementById("dist"+i).style.visibility = "hidden";
					}
					document.getElementById("showing_results").innerHTML = 
					"<p class='showing'>No results were found</p>";
				}
			});
		});
		$('#lease_yes').on("click",function() {
			if (document.getElementById("lease_yes").style.color == "black") {
				document.getElementById("lease_yes").style.color = "white";
				filter = "lease_reset";
			}
			else { 
				filter = "lease_yes"; 
				document.getElementById("lease_yes").style.color = "black";
				document.getElementById("lease_no").style.color = "white";
			}
			get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=0&filter='+filter;
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				news = 5;
				prevs = 0; a = news; b = prevs +1; totalrows = result.totalrows;
				if (result.error_msg != 'null_query') {
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
				}
				else {
					for (i= 0; i < 5; i++) {
						document.getElementById("cost"+i).style.visibility = "hidden";
						document.getElementById("dist"+i).style.visibility = "hidden";
					}
					document.getElementById("showing_results").innerHTML = 
					"<p class='showing'>No results were found</p>";
				}
			});
		});
		$('#lease_no').on("click",function() {
			if (document.getElementById("lease_no").style.color == "black") {
				document.getElementById("lease_no").style.color = "white";
				filter = "lease_reset";
			}
			else { 
				filter = "lease_no"; 
				document.getElementById("lease_no").style.color = "black";
				document.getElementById("lease_yes").style.color = "white";
			}
			get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=0&filter='+filter;
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				news = 5;
				prevs = 0; a = news; b = prevs +1; totalrows = result.totalrows;
				if (result.error_msg != 'null_query') {
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
				}
				else {
					for (i= 0; i < 5; i++) {
						document.getElementById("cost"+i).style.visibility = "hidden";
						document.getElementById("dist"+i).style.visibility = "hidden";
					}
					document.getElementById("showing_results").innerHTML = 
					"<p class='showing'>No results were found</p>";
				}
			});
		});
		$('#furnished_yes').on("click",function() {
			if (document.getElementById("furnished_yes").style.color == "black") {
				document.getElementById("furnished_yes").style.color = "white";
				filter = "furnished_reset";
			}
			else { 
				filter = "furnished_yes"; 
				document.getElementById("furnished_yes").style.color = "black";
				document.getElementById("furnished_no").style.color = "white";
			}
			get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=0&filter='+filter;
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				news = 5;
				prevs = 0; a = news; b = prevs +1; totalrows = result.totalrows;
				if (result.error_msg != 'null_query') {
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
				}
				else {
					for (i= 0; i < 5; i++) {
						document.getElementById("cost"+i).style.visibility = "hidden";
						document.getElementById("dist"+i).style.visibility = "hidden";
					}
					document.getElementById("showing_results").innerHTML = 
					"<p class='showing'>No results were found</p>";
				}
			});
		});
		$('#furnished_no').on("click",function() {
			if (document.getElementById("furnished_no").style.color == "black") {
				document.getElementById("furnished_no").style.color = "white";
				filter = "furnished_reset";
			}
			else { 
				filter = "furnished_no"; 
				document.getElementById("furnished_no").style.color = "black";
				document.getElementById("furnished_yes").style.color = "white";
			}
			get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s=0&filter='+filter;
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				news = 5;
				prevs = 0; a = news; b = prevs +1; totalrows = result.totalrows;
				if (result.error_msg != 'null_query') {
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
				}
				else {
					for (i= 0; i < 5; i++) {
						document.getElementById("cost"+i).style.visibility = "hidden";
						document.getElementById("dist"+i).style.visibility = "hidden";
					}
					document.getElementById("showing_results").innerHTML = 
					"<p class='showing'>No results were found</p>";
				}
			});
		});
	});
}