<?php
include_once 'admincontrol.php';
$flat_id = $_POST["id"];
$user_id = $_POST["user"];
$update = array("user_id" => $user_id);
$db->update(DB_PREFIX . "flats", $update, "flat_id = " . $flat_id);
header("location:object.php?id=".$flat_id);
?>