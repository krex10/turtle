function contact () {
	document.getElementById("sort_distance").style.display = "none";
	document.getElementById("sort_price").style.display = "none";
	document.getElementById("slider-range-min").style.display = "none";
	document.getElementById("re_search").style.display = "none";
	document.getElementById("filters").style.display = "none";
	document.getElementById("next_show").style.display = "none";
	document.getElementById("prev_show").style.display = "none";
	document.getElementById("distance").style.display = "none";
	document.getElementById("showing_results").style.display = "none";
	for(i=0; i < 5; i ++) {
		document.getElementById("cost"+i).style.display = "none";
		document.getElementById("dist"+i).style.display = "none";
		document.getElementById("pad_dist"+i).style.display = "none";
	}
	document.getElementById("showing_results").innerHTML = "<p class='showing'>Contact us</p>";
}

function feedback () {
	document.getElementById("sort_distance").style.display = "none";
	document.getElementById("sort_price").style.display = "none";
	document.getElementById("slider-range-min").style.display = "none";
	document.getElementById("re_search").style.display = "none";
	document.getElementById("filters").style.display = "none";
	document.getElementById("next_show").style.display = "none";
	document.getElementById("prev_show").style.display = "none";
	document.getElementById("distance").style.display = "none";
	document.getElementById("showing_results").style.display = "none";
	for(i=0; i < 5; i ++) {
		document.getElementById("cost"+i).style.display = "none";
		document.getElementById("dist"+i).style.display = "none";
		document.getElementById("pad_dist"+i).style.display = "none";
	}
	document.getElementById("feedback").style.display = "inline";
}