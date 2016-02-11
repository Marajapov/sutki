<?php
include_once 'admincontrol.php';
if (isset($_POST["extracounter"])){
	$id = (int)$_POST["id"];
	$extracounter = (int)$_POST["extracounter"];
	$update = array("extracounter" => $extracounter);
	$db->update("flats", $update, "flat_id = " . $id);
	header("location:".$_SERVER["HTTP_REFERER"]);
}
?>