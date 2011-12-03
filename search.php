<?php session_start() ?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Turtle&#39;s Den</title>
</head>
<body>
<!--<img id="title" src="title.png" style="margin-left:30px; margin-bottom:-500px; margin-top:10px;"/> -->
<div id="zippy" style="margin-top:10px; margin-bottom:-190px; margin-left:0px;"> <img src="turtle3.png"/> </div>
<div id="green_page">
<div id="search_results">
<?php
include "config.php";
$var = @$_GET['q'] ;
$s = @$_GET['s'] ;
$sort = @$_GET['sort'] ;
$trimmed = trim($var); //trim whitespace from the stored variable
$supertrimmed = mysql_escape_string($trimmed);
// rows to return
$limit=5; 

// check for an empty string and display a message.
if ($supertrimmed == "")
  {
  ?> <p>Do not try it noob ... </p> 
  <?php 
  exit;
  }

// check for a search parameter
if (!isset($var))
  {
  ?> <p>We dont seem to have a search parameter!</p> <?php
  exit;
  }

// Build SQL Query
if ($sort) {
    $query = "Select * from temp where address like \"%$supertrimmed%\" ORDER BY ". $sort; // EDIT HERE and specify your table and field names for the SQL query
}
else {
    $query = "Select * from temp where address like \"%$supertrimmed%\" ORDER BY rating"; // EDIT HERE and specify your table and field names for the SQL query
}


 $numresults=mysql_query($query);
 $numrows=mysql_num_rows($numresults);

// No results

if ($numrows == 0)
  {
  ?>
  <p style="margin-left:200px;">Sorry, your search for "<?php echo "$supertrimmed"; ?>" did not return any results.</p>
  <p style="margin-left:200px;"><a href="index.php">Search</a></p> <?php
  exit;
  }

// next determine if s has been passed to script, if not use 0
  if (empty($s)) {
  $s=0;
  }


// get results
  $query .= " limit $s,$limit";
  $result = mysql_query($query) or die("Couldn't execute query");

// display what the person searched for
?> <table ><tr  align='left'>
<td width='800' align='right'>
    <strong> <?php $a = $s + ($limit) ;
      if ($a > $numrows) { $a = $numrows ; }
      $b = $s + 1 ;
      echo "<p class='showing'>Showing results $b to $a of $numrows for '".$var."'"; ?>
</td>
<td><a href='index.php' align="right" class="nav-link" style="margin-left:0px">Search</a></td></tr></table>


<table id="results" cellspacing="7" border="1" bordercolor="green" rules="cols" frame="void" class="sortable">
    <tr style="font-weight:bold;">
        <td><button>Address</button></td>
        <td><button><a href=<? echo"search.php?q=".$var."&sort=cost"; ?> style="color:red;"  >Price</a></button></td>
        <td><button>Distance</button></td>
        <td><button>Availibility</button></td>
        <td><button>Utilities</button></td>
        <td><button>Lease</button></td>
        <td><button>Furnished</button></td>
        <td><button>Rooms</button></td>
        <td><button>Min-Max Stay (months)</button></td>
    </tr>
<?php
$count = 1 + $s ;

// now you can display the results returned
  while ($row= mysql_fetch_array($result)) {

  ?> <tr>
    <td width="240"><?php echo "{$row['address']}";  ?></td>
    <td width="60"><?php echo "\${$row['cost']}";  ?></td>
    <td width="60"><?php echo "{$row['distance']}";  ?> km</td>
    <td width="100"><?php echo "{$row['available']}";  ?></td>
    <td width="55"><?php echo "{$row['utils_included']}";  ?></td>
    <td width="55" ><?php echo "{$row['lease_required']}";  ?></td>
    <td width="55"><?php echo "{$row['furnished']}";  ?></td>
    <td width="55"><?php echo "{$row['empty_rooms']}/{$row['total_rooms']}";  ?></td>
    <td width="100" ><?php echo "{$row['min_stay']} - "; 
                            if ($row['max_stay'] != 0) { echo "{$row['max_stay']}"; }  
                            else { echo "Not specified"; } ?></td>
   </tr>
  
  <?php
  $count++ ;
  }
  ?>
</table>
<?php 
$currPage = (($s/$limit) + 1);

//break before paging
  echo "<br />";

  // next we need to do the links to other results
  if ($s>=1) { // bypass PREV link if s is 0
  $prevs=($s-$limit);
  print "&nbsp;<a href='$PHP_SELF?s=$prevs&q=$var' class='nav-link'>&lt;&lt; 
  Prev Page </a>&nbsp&nbsp;";
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

  echo "&nbsp;<a href='search.php?s=$news&q=$var' class='nav-link'>Next Page &gt;&gt;</a>";
  }

?>
</div>
</div>
</body>
</html>