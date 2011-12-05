function more_info () {
		var i;
		var counter = 0; var result; var get_link; var numrows;
		$(document).ready(function(){
		$('#next').on("click",function() {
			get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s='+news;
			$.get(get_link, function(data) {
				result = $.parseJSON(data);
				numrows = result.numrows;
				prevs = news - 5;
				if (result.error_msg != 'null_query') {
					for (i=0; i < numrows; i++) {
						document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
						document.getElementById("dist"+i).innerHTML = result.result[i].distance;
						var padding = result.result[i].distance * 15;
						var padding_left = padding+"px";
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
			get_link = 'new_sort.php?q='+query+'&sort='+sort+'&s='+prevs;
			$.get(get_link, function(data) {
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
			$.get('new_sort.php?q='+query+'&sort='+sort+'&s=', function(data) {
				news = 5;
				var result = $.parseJSON(data);
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
		$('#sort_distance').on("click",function() {
			sort = "distance";
			$.get('new_sort.php?q='+query+'&sort='+sort+'&s=', function(data) {
				news = 5;
				var result = $.parseJSON(data);
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
	});
}
