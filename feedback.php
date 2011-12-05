<?php
include "config.php";
session_start();
?>
<div id="search_results">
	<script language="JavaScript" src="jquery.js"></script>
	<script language="JavaScript" src="jquery.qtip.min.js"></script>
	<script language="JavaScript" src="more_info.js"></script>
	<script language="JavaScript" src="contact.js"></script>
	<style type="text/css">
	#filters { display:none; }
	</style>
<?php
if (!isset($_SESSION)) { echo "Session not set, please verify cookie settings and reload the page"; exit;}
include "config.php";?>
<form style="margin-left:80px;" action="send_form.php" method="get">
    <label class="showing" for="msg">Give us some feedback!</label><br/>
    <textarea onFocus="this.value = (this.value=='insert feedback message here')? '' : this.value;" value="insert feedback message here" type="text" name="msg"  class="contact_form"></textarea><br/>
    <button class="sort_buttons">Send</button>
</form>
</div>