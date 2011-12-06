var filter;
function filter_color (utils, lease, furnished) {
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
}