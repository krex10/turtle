function more_info () {
	$(document).ready(function(){
		$('#next').on("click",function() {
			get_link = 'new_sort.php?q='+query+'&s='+news;
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows; 
				if (result.error_msg != 'null_query') {
					specific_info(news);
					for (i=0; i < numrows; i++) {
						document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
						document.getElementById("dist"+i).innerHTML = result.result[i].distance+" km";
						padding = result.result[i].distance * 15;
						padding_left = padding+"px";
						document.getElementById("pad_dist"+i).style.paddingLeft = padding_left;
						news++;				
					}a = news; b = a - numrows + 1; prevs = b -5; totalrows = result.totalrows;
					if (numrows < 5) {
						for (i= 4; i >= numrows ; i--) {
							document.getElementById("cost"+i).style.visibility = "hidden";
							document.getElementById("dist"+i).style.visibility = "hidden";
							news++;
						}
						a = totalrows; b = totalrows - numrows;
						document.getElementById("next_show").style.visibility = "hidden";
					}
					if (news >= 5) {
						document.getElementById("prev_show").style.visibility = "visible"; counter++;
					}
					document.getElementById("showing_results").innerHTML = 
					"<p class='showing'>Showing results "+b+" to "+a+" of "+totalrows+"</p>";
				}
				else {
					for (i= 0; i < 5; i++) {
						document.getElementById("cost"+i).innerHTML = "";
						document.getElementById("dist"+i).innerHTML = "";
					}
					document.getElementById("showing_results").innerHTML = 
					"<p class='showing'>No results were found</p>";
				}
			});
		});
		$('#prev').on("click",function() {
			get_link = 'new_sort.php?q='+query+'&s='+prevs;
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows; 
				if (result.error_msg != 'null_query') {
					specific_info(prevs);
					for (i=0; i < numrows; i++) {
						document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
						document.getElementById("dist"+i).innerHTML = result.result[i].distance+" km";
						padding = result.result[i].distance * 15;
						padding_left = padding+"px";
						document.getElementById("pad_dist"+i).style.paddingLeft = padding_left;
						news--;
						document.getElementById("cost"+i).style.visibility = "visible";
						document.getElementById("dist"+i).style.visibility = "visible";
					}
					prevs = news - 10; a = news; b = a - numrows + 1; totalrows = result.totalrows;
					if (news <= 5) {
						document.getElementById("prev_show").style.visibility = "hidden";
					}
					counter--;
					document.getElementById("showing_results").innerHTML = 
					"<p class='showing'>Showing results "+b+" to "+a+" of "+totalrows+"</p>";
					document.getElementById("next_show").style.visibility = "visible";
				}
				else {
					for (i= 0; i < 5; i++) {
						document.getElementById("cost"+i).innerHTML = "";
						document.getElementById("dist"+i).innerHTML = "";
					}
					document.getElementById("showing_results").innerHTML = 
					"<p class='showing'>No results were found</p>";
				}
			});
		});
		$('#sort_price').on("click",function() {
			if (document.getElementById("sort_price").style.color == "black") {
				document.getElementById("sort_price").style.color = "white";
				filter = "sort_reset";
			}
			else {
				document.getElementById("sort_price").style.color = "black";
				document.getElementById("sort_distance").style.color = "white";
				filter = "price_sort";
			}
			$.get('new_sort.php?q='+query+'&s=&filter='+filter, function(data) {
				news = 0; prevs = 0;
				result = $.parseJSON(data);
				numrows = result.numrows; totalrows = result.totalrows;
				if (result.error_msg != 'null_query') {
					specific_info();
					for (i=0; i < numrows; i++) {
						document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
						document.getElementById("dist"+i).innerHTML = result.result[i].distance+" km";
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
						document.getElementById("next_show").style.visibility = "hidden";
					}
					document.getElementById("showing_results").innerHTML = 
					"<p class='showing'>Showing results 1 to 5 of "+totalrows+"</p>";
					document.getElementById("prev_show").style.visibility = "hidden";
				}
				else {
					for (i= 0; i < 5; i++) {
						document.getElementById("cost"+i).innerHTML = "";
						document.getElementById("dist"+i).innerHTML = "";
					}
					document.getElementById("showing_results").innerHTML = 
					"<p class='showing'>No results were found</p>";
				}
			});
		});
		$('#sort_distance').on("click",function() {
			if (document.getElementById("sort_distance").style.color == "black") {
				document.getElementById("sort_distance").style.color = "white";
				filter = "sort_reset";
			}
			else {
				document.getElementById("sort_distance").style.color = "black";
				document.getElementById("sort_price").style.color = "white";
				filter = "distance_sort";
			}
			$.get('new_sort.php?q='+query+'&s=&filter='+filter, function(data) {
				news = 0; prevs = 0;
				result = $.parseJSON(data);
				numrows = result.numrows;
				if (result.error_msg != 'null_query') {
					specific_info();
					for (i=0; i < numrows; i++) {
						document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
						document.getElementById("dist"+i).innerHTML = result.result[i].distance+" km";
						padding = result.result[i].distance * 15;
						padding_left = padding+"px";
						document.getElementById("pad_dist"+i).style.paddingLeft = padding_left;
						news++;				
					}a = news; b = a - numrows + 1; totalrows = result.totalrows;
					if (numrows < 5) {
						for (i= 4; i >= numrows ; i--) {
							document.getElementById("cost"+i).style.visibility = "hidden";
							document.getElementById("dist"+i).style.visibility = "hidden";
							news++;
						}
						a = totalrows; b = totalrows - numrows + 1;
						document.getElementById("next_show").style.visibility = "hidden";
					}
					document.getElementById("showing_results").innerHTML = 
					"<p class='showing'>Showing results 1 to 5 of "+totalrows+"</p>";
					document.getElementById("prev_show").style.visibility = "hidden";
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
			get_link = 'new_sort.php?q='+query+'&s=&filter='+filter;
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				news = 5;
				prevs = 0; a = news; b = prevs +1; totalrows = result.totalrows;
				if (result.error_msg != 'null_query') {
					specific_info();
					for (i=0; i < numrows; i++) {
						document.getElementById("cost"+i).style.visibility = "visible";
						document.getElementById("dist"+i).style.visibility = "visible";
						document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
						document.getElementById("dist"+i).innerHTML = result.result[i].distance+" km";
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
			get_link = 'new_sort.php?q='+query+'&s=0&filter='+filter;
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows; 
				news = 5;
				prevs = 0; a = news; b = prevs +1; totalrows = result.totalrows;
				if (result.error_msg != 'null_query') {
					specific_info();
					for (i=0; i < numrows; i++) {
						document.getElementById("cost"+i).style.visibility = "visible";
						document.getElementById("dist"+i).style.visibility = "visible";
						document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
						document.getElementById("dist"+i).innerHTML = result.result[i].distance+" km";
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
			get_link = 'new_sort.php?q='+query+'&s=0&filter='+filter;
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				news = 5;
				prevs = 0; a = news; b = prevs +1; totalrows = result.totalrows;
				if (result.error_msg != 'null_query') {
					specific_info();
					for (i=0; i < numrows; i++) {
						document.getElementById("cost"+i).style.visibility = "visible";
						document.getElementById("dist"+i).style.visibility = "visible";
						document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
						document.getElementById("dist"+i).innerHTML = result.result[i].distance+" km";
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
			get_link = 'new_sort.php?q='+query+'&s=&filter='+filter;
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				news = 5;
				prevs = 0; a = news; b = prevs +1; totalrows = result.totalrows;
				if (result.error_msg != 'null_query') {
					specific_info();
					for (i=0; i < numrows; i++) {
						document.getElementById("cost"+i).style.visibility = "visible";
						document.getElementById("dist"+i).style.visibility = "visible";
						document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
						document.getElementById("dist"+i).innerHTML = result.result[i].distance+" km";
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
			get_link = 'new_sort.php?q='+query+'&s=&filter='+filter;
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				news = 5;
				prevs = 0; a = news; b = prevs +1; totalrows = result.totalrows;
				if (result.error_msg != 'null_query') {
					specific_info();
					for (i=0; i < numrows; i++) {
						document.getElementById("cost"+i).style.visibility = "visible";
						document.getElementById("dist"+i).style.visibility = "visible";
						document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
						document.getElementById("dist"+i).innerHTML = result.result[i].distance+" km";
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
			get_link = 'new_sort.php?q='+query+'&s=&filter='+filter;
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				news = 5;
				prevs = 0; a = news; b = prevs +1; totalrows = result.totalrows;
				if (result.error_msg != 'null_query') {
					specific_info();
					for (i=0; i < numrows; i++) {
						document.getElementById("cost"+i).style.visibility = "visible";
						document.getElementById("dist"+i).style.visibility = "visible";
						document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
						document.getElementById("dist"+i).innerHTML = result.result[i].distance+" km";
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

function new_submit () {
	query = $('[name=q]').val();
	console.log(query);
	get_link = 'new_sort.php?q='+query+'&s=';
	$.get(get_link, function(data) {
		result = $.parseJSON(data);
		numrows = result.numrows;
		news = 0;
		prevs = 0; totalrows = result.totalrows;
		if (result.error_msg != 'null_query') {
			specific_info();
			for (i=0; i < numrows; i++) {
				document.getElementById("cost"+i).style.visibility = "visible";
				document.getElementById("dist"+i).style.visibility = "visible";
				document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
				document.getElementById("dist"+i).innerHTML = result.result[i].distance+" km";
				padding = result.result[i].distance * 15 + 130;
				padding_left = padding+"px";
				document.getElementById("pad_dist"+i).style.paddingLeft = padding_left;
				news++;
			}
			if (numrows < 5) {
				for (i= 4; i >= numrows ; i--) {
					document.getElementById("cost"+i).style.visibility = "hidden";
					document.getElementById("dist"+i).style.visibility = "hidden";
				}
				news++;
			}
			document.getElementById("showing_results").innerHTML = 
			"<p class='showing'>Showing results 1 to 5 of "+totalrows+"</p>";
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
}