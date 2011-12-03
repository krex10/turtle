<?php
include "config.php";
session_start();
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<script language="JavaScript" src="contact_index.js"></script>
<title>Turtle&#39;s Den</title>
<script src="jquery.js"></script>
</head>
<body>
    <div id="wrapper">
        <div id="content">
			<div id="form">
			<?php
			if (!isset($_SESSION)) { echo "Session not set, please verify cookie settings and reload the page"; exit;}
			include "config.php";
			$var = @$_GET['msg'] ;
			$trimmed = trim($var); //trim whitespace from the stored variable
			$supertrimmed = mysql_escape_string($trimmed);
			if (mail("kavi_nessen@hotmail.com", "Turtle Contact", $supertrimmed))
				echo "<p>Thank you for providing us with feedback.";

			?>
			</div>
        </div> <!--end content -->
        <div id="zippy"> <img src="turtle3.png"/> </div>
		<div id="footer" style="margin-top:50px; margin-left:170px;">
				<button class="footer_copyright" onclick="/"><a href="/turtle" class="footer_links">&copy; 2011 Turtle's Den</a> | <a class="footer_links" href="#">Feedback</a> | <a class="footer_links" href="#">Contact us</a></button>
		</div>
    </div> <!--end wrapper -->
</body>
</html>