<?php 
session_start(); 
include "config.php"; 
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<script language="JavaScript" src="contact_index.js"></script>
<title>Turtle&#39;s Den</title>
<meta name="description" content="apartment search">
<meta name="keywords" content="apartment search waterloo students housing rent lease sublet">
<meta name="author" content="Kavi Kistnasamy">
<script src="jquery.js"></script>
</head>
<body>
    <div id="wrapper">
        <div id="content">
            <div id="form">
                <form action="new_search.php" method="get" class="search_form">
                    <label for="q"></label>
                    <input onFocus="this.value = (this.value=='Where are you living?')? '' : this.value;" value="Where are you living?" type="text" name="q"  class="search" /><br/>
                    <button class="search">New search</button>
                </form>
            </div> <!--end form -->
        </div> <!--end content -->
        <div id="zippy"> <img src="turtle3.png"/> </div>
		<div id="footer" style="margin-top:50px; margin-left:170px;">
				<button class="footer_copyright" onclick="/">&copy; 2011 Turtle's Den | <a class="footer_links" href="#">Feedback</a> | <a class="footer_links" href="#">Contact us</a></button>
		</div>
    </div> <!--end wrapper -->
</body>
</html>