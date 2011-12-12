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
        <img id="title" src="title3.png" style=""/>
        <div id="content">
            <div style=""> <img src="turtle3.png"/> </div>
            <div id="form">
                <form action="new_search.php" method="get" class="search_form" name="search_form" >
                    <label for="q"></label>
                    <input onload ="document.search_form.q.focus();" onFocus="this.value = (this.value=='Where are you moving to?')? '' : this.value;" value="Where are you moving to?" type="text" name="q"  class="search" /><br/>
                    <button class="search">New search</button>
                </form>
            </div> <!--end form -->
        </div> <!--end content -->
		<div id="footer" style="">
				<p class="footer_copyright" onclick="/">&copy; 2011 Turtle's Den | <a class="footer_links" href="#">Feedback</a> | <a class="footer_links" href="#">Contact us</a></p>
		</div>
    </div> <!--end wrapper -->
</body>
</html>