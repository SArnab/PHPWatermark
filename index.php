<?php
set_time_limit(0);
ini_set('memory_limit','4M');
require('watermark.php');

if($_POST) {
	$wt = new watermark();
	var_dump($_POST);
}
?>
<form action="" method="post" enctype="multipart/form-data" name="form1">
	<p>Text:
		<input type="text" name="text" id="text">
	</p>
	<p>	
		<input type="file" name="img" id="img">
		<input type="submit" name="button" id="button" value="Submit">
		</p>
</form>

