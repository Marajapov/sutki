<?php
include_once 'usercontrol.php';
$deletedDate = date("Y-m-d H:m:s");
$update = array("liveFlag" => 0, "deletedDate" => $deletedDate);
$userid = $_SESSION["userid"];
if (isset($_GET["flat_id"])){
	$flat_id = $_GET["flat_id"];
	require 'flatcontrol.php';
	$db->update(DB_PREFIX . "flats", $update, "flat_id = " . $flat_id);
	$db->update(DB_PREFIX . "rooms", $update, "flat_id = " . $flat_id);
	header("location:index.php");
	/*$rwPhoto = $db->select("photos", "flat_id='" . $flat_id . "'", "*", "", "");
	foreach ($rwPhoto as $photo){
		@unlink('../images/big/'.$photo["image_url"]);
		@unlink('../images/thu/'.$photo["image_url"]);
		//@unlink('../images/mainimg/'.$mainimg);
	}
	$db->delete(DB_PREFIX . "flat_inventory", "flat_id = " . $flat_id);
	$db->delete(DB_PREFIX . "flat_infrastructure", "flat_id = " . $flat_id);
	$db->delete(DB_PREFIX . "photos", "flat_id = " . $flat_id);
	$db->delete(DB_PREFIX . "rooms", "flat_id = " . $flat_id);
	$db->delete(DB_PREFIX . "flats", "flat_id = " . $flat_id);
	*/
}
if (isset($_GET["room_id"])){
	$room_id = $_GET["room_id"];
	$nmFlat = $db->select_one("rooms", "room_id='" . $room_id . "'", "flat_id", "", "");
	$flat_id = $nmFlat["flat_id"];
	require 'flatcontrol.php';
	$db->update(DB_PREFIX . "rooms", $update, "room_id = " . $room_id);
	header("location:".$_SERVER["HTTP_REFERER"]);
}

if (isset($_GET["album_id"])){
	$album_id = $_GET["album_id"];
	$nmFlat = $db->select_one("albums", "album_id='" . $album_id . "'", "flat_id", "", "");
	$flat_id = $nmFlat["flat_id"];
	require 'flatcontrol.php';
	$rwPhoto = $db->select("photos", "album_id='" . $album_id . "'", "*", "", "");
	foreach ($rwPhoto as $photo){
		@unlink('../images/big/'.$photo["image_url"]);
		@unlink('../images/thu/'.$photo["image_url"]);
	}
	$db->delete(DB_PREFIX . "photos", "album_id = " . $album_id);
	$db->delete(DB_PREFIX . "albums", "album_id = " . $album_id);
	header("location:".$_SERVER["HTTP_REFERER"]);
}

?>