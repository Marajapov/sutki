<?php
include_once 'admincontrol.php';
$approve = array("approved" => 1);
if (isset($_GET["active"])){
	$flat_id = $_GET["flat_id"];
	$update = $_GET["active"] ? array("liveFlag" => 1):array("liveFlag" => 0);
	$db->update(DB_PREFIX . "flats", $update, "flat_id = " . $flat_id);
	header("location:".$_SERVER["HTTP_REFERER"]);
}
if (isset($_GET["approve"])){
	$flat_id = $_GET["flat_id"];
	$update = array("approved" => 1);
	$db->update(DB_PREFIX . "flats", $update, "flat_id = " . $flat_id);
	header("location:".$_SERVER["HTTP_REFERER"]);
}
if (isset($_GET["special"])){
	$flat_id = $_GET["flat_id"];
	$update = $_GET["special"] ? array("special" => 1):array("special" => 0);
	$db->update(DB_PREFIX . "flats", $update, "flat_id = " . $flat_id);
	header("location:".$_SERVER["HTTP_REFERER"]);
}

if (isset($_POST["mainpageorder"])){
	$id = (int)$_POST["id"];
	$order = (int)$_POST["mainpageorder"];
	$update = array("mainpageorder" => $order);
	if(($id*$order)>0)$db->update("flats", $update, "flat_id = " . $id);
	header("location:".$_SERVER["HTTP_REFERER"]);
}

if (isset($_GET["mainpageorder"])){
	$id = (int)$_GET["flat_id"];
	$update = array("mainpageorder" => '0');
	$db->update("flats", $update, "flat_id = " . $id);
	header("location:".$_SERVER["HTTP_REFERER"]);
}

?>