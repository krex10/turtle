<?php
session_start(); ?>
<html>
	<head>
		<title>Turtle&#39;s Den</title>
		<script language="JavaScript" src="jquery.js"></script>
		<script language="JavaScript" src="filter.js"></script>
		<script language="JavaScript" src="info.js"></script>
		<script language="JavaScript" src="contact.js"></script>
		<link rel="stylesheet" href="jquery-ui-1.8.16.custom/development-bundle/themes/base/jquery.ui.all.css">
		<script src="jquery-ui-1.8.16.custom/development-bundle/ui/jquery.ui.core.js"></script>
		<script src="jquery-ui-1.8.16.custom/development-bundle/ui/jquery.ui.position.js"></script>
		<script src="jquery-ui-1.8.16.custom/development-bundle/ui/jquery.ui.widget.js"></script>
		<script src="jquery-ui-1.8.16.custom/development-bundle/ui/jquery.ui.mouse.js"></script>
		<script src="jquery-ui-1.8.16.custom/development-bundle/ui/jquery.ui.slider.js"></script>
		<script src="jquery-ui-1.8.16.custom/development-bundle/ui/jquery.ui.dialog.js"></script>
		<link rel="stylesheet" href="jquery-ui-1.8.16.custom/development-bundle/demos/demos.css">
		<script src="tools/slider.js"></script>
		<script src="tools/specific.js"></script>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	<body>
		<div id="wrapper">
		    <a href="/turtle">
    			<img id="title" src="title3.png" style=""/>
    		</a>
        	<div id="zippy"> 
    			<a href="/turtle"><img src="turtle3.png"/></a>
    		</div>
			<div id="green_page" style="">
				<div id="search_results">
				<?php
				if (!isset($_SESSION)) { echo "Session not set, please verify cookie settings and reload the page"; exit;}
				include "config.php";
				$var = @$_GET['q'] ;
				$s = @$_GET['s'];
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
				if (!isset($_SESSION['no_refresh']))
					$_SESSION['no_refresh'] = $supertrimmed;
				echo "<script>var query = '".$_SESSION['no_refresh']."'</script>"; 
				$query = "Select * from temp where address like \"%$_SESSION[no_refresh]%\"";
				if (isset($_SESSION['filters'])) {
					$filters = $_SESSION['filters'];
					if($filters['utils'] != "None") {
						$query .= "and utils_included = '$filters[utils]'";
					}
					if($filters['lease'] != "None") {
						$query .= "and lease_required = '$filters[lease]'";
					}
					if($filters['furnished'] != "None") {
						$query .= "and furnished = '$filters[furnished]'";
					}
					$query .= "and distance <= '$filters[max_dist]'";
					$query .= "ORDER BY $filters[sort]";
					echo "<script>max_dist = $filters[max_dist];</script>";
				}
				else { $query .= "ORDER BY rating"; }
				echo "<script>$(document).ready(function () { $('[name=q]').val('$_SESSION[no_refresh]'); });</script>"; 
				echo "<script>console.log('".mysql_escape_string($query)."');</script>";
				$numresults=mysql_query($query);
				$numrows=mysql_num_rows($numresults);
				if ($numrows == 0)
				{
					?>
					<p style="margin-left:80px; margin-top:20px;" class="showing">Sorry, your search for "<?php echo "$supertrimmed"; ?>" did not return any results.</p>
					<form style="margin-left:200px;" action="new_search.php" method="get" class="search_form">
	                    <label for="q"></label>
	                    <input onFocus="this.value = (this.value=='new search') ? '' : this.value;" value="new search" type="text" name="q"  class="search" />
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
				?> <div ="results_top">
						<div>
						<?php 
							$a = $s + ($limit) ;
     						if ($a > $numrows) { $a = $numrows ; }
     						$b = $s + 1 ;
     						echo "<div id='showing_results'><p class='showing'>Showing results $b to $a of $numrows </p> </div> <script> var b = $b; var a = $a; var totalrows = $numrows;</script>"; ?>
						</div>
						<div  id="re_search">
							<form style="" name="search_form" onsubmit="event.preventDefault(); new_submit();">
								<label for="q"></label>
								<input onFocus="this.value = (this.value==$('[name=q]').val())? '' : this.value;" value="<? echo $var; ?>" type="text" name="q"  class="small_search" onkeypress=""/>
							</form>
						</div>
					</div><!--End results top -->
					<div class="demo" style="">
						<p>
							<label class="sort_buttons" id="sort_distance" for="distance">Distance:</label>
							<input type="text" id="distance" readonly="readonly"/>
							<div id="slider-range-min"></div>
						</p>
					</div><!-- End demo -->
					<div class="sort_buttons" id="sort_price">
						<p>Price</p>
					</div>
					<div id="results" cellspacing="7" border="1" bordercolor="green" rules="cols" frame="void" class="sortable">
						<?php
							$count = 1 + $s ;
							$test_count = 0;
							echo "<script> var x = []; var list_info = [x,x,x,x,x]; </script>";
							// now you can display the results returned
							while ($row= mysql_fetch_array($result)) {
								$padding = $row['distance'] * 15 + 130;
						?> 
								<div id="row_results">
									<div>
										<div <? echo "id=\"cost".$test_count."\""; ?>>
											<p><?php echo "\${$row['cost']}";  ?></p>
										</div>
										<div  <? echo "id=\"pad_dist".$test_count."\""; ?> >
											<p class="listing" <? echo "id=\"dist".$test_count."\""; ?>><?php echo "{$row['distance']} km";  ?></p>
										</div>
										<div <? echo "id=\"dialog".$test_count."\""; ?>></div>
									</div>
								</div><!--End row results -->
						<?php
						echo "<script>document.getElementById(\"pad_dist".$test_count."\").style.marginLeft=
						\"$padding px\"</script>";
						$count++;
						$test_count++;
					}
					?>
					</div><!--End results table -->
					<?php 
						$currPage = (($s/$limit) + 1);
						// next we need to do the links to other results
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
							echo "<script>var news = '".$news."'; var prevs = 0; var sort = '".$sort."'; </script>"; ?>
					<div>
						<div id="prev_show"><button class="page_buttons" id="prev" style="">Prev Page</button> </div>
						<div id="next_show"><button class="page_buttons" id="next" style="margin-top:-28.5px; margin-left:100px;">Next Page</button></div>
					</div> <?
				}
	}
				if ($numrows != 0) {  ?>
					<div id="filters">
						<div class="filter_buttons">Utilities:
							<a href="#" id="utils_yes">[Yes]</a> /
							<a href="#" id="utils_no">[No]</a>
						</div ><br/>
						<div  class="filter_buttons" >Lease:
							<a href="#" id="lease_yes">[Yes]</a> /
							<a href="#" id="lease_no">[No]</a>
						</div ><br/>
						<div  class="filter_buttons" >Furnished:
							<a href="#" id="furnished_yes">[Yes]</a> /
							<a href="#" id="furnished_no">[No]</a>
						</div ><br/>
					</div> <? } ?>
				</div><!--end search_result -->
			</div><!--end green_page -->
			<div id="footer" style="">
				<p class="footer_copyright" onclick="/">&copy; 2011 Turtle's Den | <a class="footer_links" href="#" onclick="#">Feedback</a> | <a class="footer_links" href="#" onclick="#">Contact us</a></p>
			</div>
	    </div><!--end wrapper -->
	</body>
	<?
	if(isset($filters))
		echo "<script>$(document).ready(filter_color('$filters[utils]','$filters[lease]','$filters[furnished]','$filters[sort]'));</script>";
	?>
</html>
<script>
$(document).ready(function () { more_info(); specific_info ();});
</script>
