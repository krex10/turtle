function compare_info() {
	$(".comparable").draggable({
				appendTo: "body",
				helper: "clone"
	});
	$( "#dropzone ul" ).droppable({
		activeClass: "ui-state-default",
		hoverClass: "ui-state-hover",
		accept: ":not(.ui-sortable-helper)",
		drop: function( event, ui ) {
			$( this ).find( ".placeholder" ).remove();
			$( "<li></li>" ).text( ui.draggable.text() ).appendTo( this );
			$('h1.dropzone_header_grey').removeClass('dropzone_header_grey').addClass("dropzone_header");
			$("[class='dropzone_header']").on("click", function () {
				document.getElementById("sort_distance").style.display = "none";
				document.getElementById("sort_price").style.display = "none";
				document.getElementById("slider-range-min").style.display = "none";
				document.getElementById("re_search").style.display = "none";
				document.getElementById("filters").style.display = "none";
				document.getElementById("next_show").style.display = "none";
				document.getElementById("prev_show").style.display = "none";
				document.getElementById("distance").style.display = "none";
				document.getElementById("showing_results").style.display = "none";
				document.getElementById("dropzone").style.display = "none";
				for(i=0; i < 5; i ++) {
					document.getElementById("cost"+i).style.display = "none";
					document.getElementById("dist"+i).style.display = "none";
					document.getElementById("pad_dist"+i).style.display = "none";
				}
			});
		}
	}).sortable({
				items: "li:not(.placeholder)",
				sort: function() {
					// gets added unintentionally by droppable interacting with sortable
					// using connectWithSortable fixes this, but doesn't allow you to customize active/hoverClass options
					$( this ).removeClass( "ui-state-default" );
				}
	});
}