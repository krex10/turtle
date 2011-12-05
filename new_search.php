<?php session_start(); ?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>Turtle&#39;s Den</title>
		<script language="JavaScript" src="jquery.js"></script>
		<script language="JavaScript" src="jquery.qtip.min.js"></script>
		<script language="JavaScript" src="more_info.js"></script>
		<script language="JavaScript" src="contact.js"></script>
	</head>
	<body>
		<a href="/turtle">
			<img id="title" src="title3.png" style="margin-left:40px; margin-bottom:-80px; margin-top:10px;"/>
		</a>
		<div id="zippy"> 
			<a href="/turtle"><img src="turtle3.png"/></a>
		</div>
		<div id="green_page" style="padding-top:20px;">
			<div id="search_results">
			<?php
			if (!isset($_SESSION)) { echo "Session not set, please verify cookie settings and reload the page"; exit;}
			include "config.php";
			$var = @$_GET['q'] ;
			$s = @$_GET['s'];
			$sort = @$_GET['sort'];
			//sort
			if (!$sort)
				{$sort = "rating"; $_SESSION['sort'] = $sort; }
			else
				{$_SESSION['sort'] = $sort;}
			//filter
			$filter = @$_GET['filter'];
			if ($filter == 'no_utils') {$filter = 'utils_included' ; $filter_var = "No";}
			else if ($filter == 'no_utils') {$filter = 'lease_required' ; $filter_var = "No";}
			else if ($filter == 'no_utils') {$filter = 'furnished' ; $filter_var = "No";}
			else { $filter_var = "Yes"; }
			if (!$filter)
				{$filter = "";}
			else { $_SESSION['filter'] = $filter; }
			$trimmed = trim($var); //trim whitespace from the stored variable
			$supertrimmed = mysql_escape_string($trimmed);
			// rows to return
			$limit=5; 
			// check for an empty string and display a message.
			if ($supertrimmed == "")
			{
				?> <p>Your search was empty</p> 
					<?php 
				exit;
			}
			// check for a search parameter
			if (!isset($var))
			{
				?> <p>We dont seem to have a search parameter!</p> <?php
				exit;
			}
			if (!$filter)
				{ $query = "Select * from temp where address like \"%$supertrimmed%\" ORDER BY $sort"; }
			else 
				{$query = "Select * from temp where address like \"%$supertrimmed%\" AND $filter = '$filter_var' ORDER BY $sort";}
			$numresults=mysql_query($query) or die ($query);
			$numrows=mysql_num_rows($numresults); 
			if ($numrows == 0)
			{
				?>
				<p style="margin-left:80px; margin-top:20px;" class="showing">Sorry, your search for "<?php echo "$supertrimmed"; ?>" did not return any results.</p>
				<form style="margin-left:200px;" action="new_search.php" method="get" class="search_form">
                    <label for="q"></label>
                    <input onFocus="this.value = (this.value=='new search')? '' : this.value;" value="new search" type="text" name="q"  class="search" /><br/>
                    <button class="search">Search</button>
                </form> <?php
 			}
			else {
			// next determine if s has been passed to script, if not use 0
			if (empty($s)) {
				$s=0;
			}
			// get results
			$query .= " limit $s,$limit";
			$result = mysql_query($query) or die("Couldn't execute query");

			// display what the person searched for
			?> <table>
					<tr  align='left'>
						<td width='800' align='left'>
    						<strong> <?php $a = $s + ($limit) ;
      					if ($a > $numrows) { $a = $numrows ; }
      					$b = $s + 1 ;
      					echo "<p class='showing'>Showing results $b to $a of $numrows"; ?>
						</td>
						<td>
							<form style="margin-right:190px; vertical-align:top;" action="new_search.php" method="get" class="search_form">
		                    <label for="q"></label>
		                    <input onFocus="this.value = (this.value=='<? echo $var; ?>')? '' : this.value;" value="<? echo $var; ?>" type="text" name="q"  class="search2" />
		                	</form>
						</td>
					</tr>
				</table>

				<table id="results" cellspacing="7" border="1" bordercolor="green" rules="cols" frame="void" class="sortable">
    				<tr style="font-weight:bold;">
        				<td>
							<button class="sort_buttons" style="" >Price</button>
						</td>
        				<td style="padding-left:25px;" style="vertical-align:top; text-align:top;">
							1 km<button style="" ><hr  class="sort_buttons" style="width:380px; height:3px;"/></button>30 km
						</td>
					</tr>
					<?php
				$count = 1 + $s ;
				$test_count = 0;
				echo "<script> var x = []; var list_info = [x,x,x,x,x]; </script>";
				// now you can display the results returned
				while ($row= mysql_fetch_array($result)) {
					$padding = $row['distance'] * 15;
					$padding_left = "' color:white; font-weight:bold; font-size:10px; padding-left: $padding px; text-align:left;'";
						?> 
					<tr id="tr_results">
						<td  width="60" style="font-weight:bold; font-size:16px;" ><div <? echo "id=\"cost".$test_count."\""; ?>><p><?php echo "\${$row['cost']}";  ?></p>
							</div></td>
						<td  width="60" style=<?php echo $padding_left; ?> ><div> <p style="background: url(house.png) no-repeat; padding: 20px 5px 12px 14px; width:25px;" <? echo "id=\"dist".$test_count."\""; ?>><?php echo "{$row['distance']}";  ?></p></div></td>
					</tr>
					<?php
					$count++;
					echo "<script>
		list_info[$test_count] = ['$row[rentalId]','$row[address]','$row[cost]','$row[distance]','$row[available]', '$row[utils_included]','$row[lease_required]','$row[furnished]','$row[empty_rooms]']
						
						</script>";
					$test_count++;
				}
				?>
			</table><!--End results table -->
			<script>
				more_info(list_info);
			</script>
			<?php 
			$currPage = (($s/$limit) + 1);
			//break before paging
			echo "<br />";
			// next we need to do the links to other results
			$prevs=($s-$limit); 
			// calculate number of pages needing links
			$pages=intval($numrows/$limit);
			// $pages now contains int of pages needed unless there is a remainder from division
			if ($numrows%$limit) {
				// has remainder so add one page
				$pages++;
			}
			// check to see if last page
			if (!((($s+$limit)/$limit)==$pages) && $pages!=1) {
				// not last page so give NEXT link
				$news=$s+$limit; 
				echo "<script>var news = $news; var prevs = $prevs;</script>"?>
				<div id="prev_show"><button class="page_buttons" id="prev" style="margin-left:115px; display:none;">Prev Page</button> </div>
				<div id="next_show"><button class="page_buttons" id="next" style="margin-left:115px;">Next Page</button></div> <?
			}
		
			?>
			<div id="filters">
				<button class="filter_buttons">
Utilities:
					<a href="#">[Yes]</a> /
					<a href="#" >[No]</a>
				</button><br/>
				<button class="filter_buttons" >
Lease:
					<a href="#">[Yes]</a> /
					<a href="#">[No]</a>
				</button><br/>
				<button class="filter_buttons" >
Furnished:
					<a href="#">[Yes]</a> /
					<a href="#">[No]</a>
				</button><br/>
			</div> <? } ?>
			</div>
		</div>
		<div id="footer">
		<button class="footer_copyright" onclick="/"><a class="footer_links" href="/turtle">&copy; 2011 Turtle's Den</a> | <a class="footer_links" onclick="feedback();" href="#">Feedback</a> | <a class="footer_links" onclick="contact();" href="#">Contact us</a></button>
		</div>
	</body>
</html>
<script>
		$(document).ready(function(){
		//$("#search_results").on("mouseover", tester(list_info));
		$('#next').on("click",function() {
			$.get('new_sort.php?q=waterloo&sort=rating&filter=&s='+news, function(data) {
				news = news + 5;
				var result = $.parseJSON(data);
				for (var i=0; i < 5; i++) {
					document.getElementById("cost"+i).innerHTML = "$"+result.result[i].cost;
					document.getElementById("dist"+i).innerHTML = result.result[i].distance;					
				}
				if (news > 5) {
					document.getElementById("prev_show").style.display = "display:inline;";
				}				
			});
		});
		$('#prev').on("click",function() {
			$.get('new_sort.php?q=waterloo&sort=rating&filter=&s=5', function(data) {
				var result = $.parseJSON(data);
				for (var i=0; i < 5; i++) {
					document.getElementById(i).innerHTML = "$"+result.result[i].cost;					
				}				
			});
		});
	});
</script>