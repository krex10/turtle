<?php
session_start();
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
$no_filter = $filter;
	if ($filter == 'no_utils') {$filter = 'utils_included'; $filter_var = "No";}
	else if ($filter == 'no_lease') {$filter = 'lease_required' ; $filter_var = "No";}
	else if ($filter == 'no_furnished') {$filter = 'furnished' ; $filter_var = "No";}
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
	exit;
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
?> <table >
		<tr  align='left'>
			<td width='800' align='right'>
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
				<button class="sort_buttons" onclick=<?php $sort_var = "'sort(\"".$supertrimmed."\", \"cost\", \"$filter\", \"\")'"; echo $sort_var; ?> style=<? if ($sort == 'cost') { $button_bg = "'background:#33A10B;'"; echo $button_bg; } ?> >Price</button>
			</td>
			<td style="padding-left:25px;" style="vertical-align:top; text-align:top;">
				1 km<button onclick=<?php $sort_var = "'sort(\"".$supertrimmed."\", \"distance\", \"$filter\", \"\")'"; echo $sort_var; ?> style=<? if ($sort == 'distance') { $button_bg = "'background:#33A10B;'"; echo $button_bg; } ?>><hr  class="sort_buttons" style="width:380px; height:3px;"/></button>30 km
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
				<tr>
					<td <? echo "'id=$test_count'"; ?> width="60" style="font-weight:bold; font-size:16px;"><?php echo "\${$row['cost']}";  ?></td>
					<td width="60" style=<?php echo $padding_left; ?> > <p class=<? echo "'$test_count'"; ?> style="background: url(house.png) no-repeat; padding: 20px 5px 12px 14px; width:25px;"> <?php echo "{$row['distance']}";  ?></p></td>
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
		<?php
$currPage = (($s/$limit) + 1);
//break before paging
echo "<br />";
// next we need to do the links to other results
if ($s>=1) { // bypass PREV link if s is 0
	$prevs=($s-$limit);
	$sort_var = "'sort(\"".$supertrimmed."\", \"$sort\", \"$filter\", \"$prevs\")'"; ?>
	<button class="page_buttons" onclick=<?php $sort_var = "'sort(\"".$supertrimmed."\", \"$sort\", \"$filter\", \"$prevs\" )'"; echo $sort_var; ?> style="margin-right:-105px;" >Prev Page</button> <?
}
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
	$sort_var = "'sort(\"".$supertrimmed."\", \"$sort\", \"$filter\", \"$news\")'"; ?>
	<button class="page_buttons" onclick=<?php $sort_var = "'sort(\"".$supertrimmed."\", \"$sort\", \"$no_filter\", \"$news\" , list_info)'"; echo $sort_var; ?> style="margin-left:115px;" >Next Page</button> <?
}
?>
			<div id="filters">
				<button class="filter_buttons" style=<? if ($filter == 'utils_included') { $b_bg = "'background:#33A10B;'"; echo $b_bg; } else { echo "''"; } ?> >
					<? if ($filter == 'utils_included') { ?>	<a href="#" style=<? if ($filter == 'utils_included') { $a_bg = "'color:#000000;'"; echo $a_bg; } else { echo "''"; } ?> onclick=<?php  $sort_var = "'sort(\"$supertrimmed\", \"$sort\", \"\", \"\")'"; echo $sort_var; ?> >Utilities:</a> <? } else { echo "Utilities:"; } ?> 
					<a href="#" style=<? if ($filter == 'utils_included' && $filter_var == 'Yes') { $a_bg = "'color:#000000;'"; echo $a_bg; } else { echo "''"; } ?> onclick=<?php  $sort_var = "'sort(\"$supertrimmed\", \"$sort\", \"utils_included\", \"\")'"; echo $sort_var; ?> >[Yes]</a> /
					<a href="#"  style=<? if ($filter == 'utils_included' && $filter_var == 'No') { $a_bg = "'color:#000000;'"; echo $a_bg; } else { echo "''"; } ?> onclick=<?php  $sort_var = "'sort(\"$supertrimmed\", \"$sort\", \"no_utils\", \"\")'"; echo $sort_var; ?>>[No]</a>
				</button><br/>
				<button class="filter_buttons"  style=<? if ($filter == 'lease_required') { $b_bg = "'background:#33A10B;'"; echo $b_bg; } else { echo "''"; } ?>>
					<? if ($filter == 'lease_required') { ?> <a href="#" style=<? if ($filter == 'lease_required') { $a_bg = "'color:#000000;'"; echo $a_bg; } else { echo "''"; } ?> onclick=<?php  $sort_var = "'sort(\"$supertrimmed\", \"$sort\", \"\", \"\")'"; echo $sort_var; ?> >Lease:</a>  <? } else { echo "Lease:"; } ?>
					<a href="#" style=<? if ($filter == 'lease_required' && $filter_var == 'Yes') { $a_bg = "'color:#000000;'"; echo $a_bg; } else { echo "''"; } ?> onclick=<?php  $sort_var = "'sort(\"$supertrimmed\", \"$sort\", \"lease_required\", \"\")'"; echo $sort_var; ?> >[Yes]</a> /
					<a href="#"  style=<? if ($filter == 'lease_required' && $filter_var == 'No') { $a_bg = "'color:#000000;'"; echo $a_bg; } else { echo "''"; } ?> onclick=<?php  $sort_var = "'sort(\"$supertrimmed\", \"$sort\", \"no_lease\", \"\")'"; echo $sort_var; ?>>[No]</a>
				</button><br/>
				<button class="filter_buttons"  style=<? if ($filter == 'furnished') { $b_bg = "'background:#33A10B;'"; echo $b_bg; } else { echo "''"; } ?>>
					<? if ($filter == 'furnished') { ?> <a href="#" style=<? if ($filter == 'furnished') { $a_bg = "'color:#000000;'"; echo $a_bg; } else { echo "''"; } ?> onclick=<?php  $sort_var = "'sort(\"$supertrimmed\", \"$sort\", \"\", \"\")'"; echo $sort_var; ?> >Furnished:</a>  <? } else { echo "Furnished:"; } ?>
					<a href="#" style=<? if ($filter == 'furnished' && $filter_var == 'Yes') { $a_bg = "'color:#000000;'"; echo $a_bg; } else { echo "''"; } ?> onclick=<?php  $sort_var = "'sort(\"$supertrimmed\", \"$sort\", \"furnished\", \"\")'"; echo $sort_var; ?> >[Yes]</a> /
					<a href="#"  style=<? if ($filter == 'furnished' && $filter_var == 'No') { $a_bg = "'color:#000000;'"; echo $a_bg; } else { echo "''"; } ?> onclick=<?php  $sort_var = "'sort(\"$supertrimmed\", \"$sort\", \"no_furnished\", \"\")'"; echo $sort_var; ?>>[No]</a>
				</button>
			</div> <? 
} ?>