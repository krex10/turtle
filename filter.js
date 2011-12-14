var filter; var i; var counter = 0; var result; var get_link; var numrows; var padding; var padding_left; var foo; var dist;
function filter_color (utils, lease, furnished, sort) {
	if (utils === "Yes") {
		document.getElementById("utils_yes").style.color = "black";
	}
	if (utils === "No") {
		document.getElementById("utils_no").style.color = "black";
	}
	if (lease === "Yes") {
		document.getElementById("lease_yes").style.color = "black";
	}
	if (lease === "No") {
		document.getElementById("lease_no").style.color = "black";
	}
	if (furnished === "Yes") {
		document.getElementById("furnished_yes").style.color = "black";
	}
	if (furnished === "No") {
		document.getElementById("furnished_no").style.color = "black";
	}
	if (sort === "cost") {
		document.getElementById("sort_price").style.color = "black";
	}
	if (sort === "distance") {
		document.getElementById("sort_distance").style.color = "black";
	}
}