<?php 
$div_table = mysql_real_escape_string($_POST['newtable']); // Make sure to clean the
	$insert = array(
		"tbl" => $div_table
 );
	$db->insert(DB_PREFIX . "flats", $insert);	
			
?>