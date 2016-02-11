<?php
include_once 'admincontrol.php';
$deletedDate = date("Y-m-d H:m:s");
$update = array("status" => 0);
if (isset($_GET["flat_id"])){
	$flat_id = $_GET["flat_id"];
	$db->update(DB_PREFIX . "flats", $update, "flat_id = " . $flat_id);
	header("location:".$_SERVER["HTTP_REFERER"]);
}
?>