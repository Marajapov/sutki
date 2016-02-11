<?php

$db_host="localhost:3306";
$db_user="apartamenty";
$db_pass="apartamentyisfine";
$db_name="apartamenty";

/*
$db_host="localhost";
$db_user="evro";
$db_pass="1";
$db_name="evro";
*/
date_default_timezone_set('Asia/Bishkek');
define('DB_PREFIX', "");
define('ROOT_PATH', dirname(__FILE__));
define("PHP_SELF",$_SERVER['PHP_SELF']); 

require_once "/class/classloader.php";
require_once "/class/functions.php";

$db=new db_mysql($db_host,$db_user,$db_pass,$db_name);
$db->connect();

// Load the stamp and the photo to apply the watermark to
$stamp = imagecreatefrompng('images/stamp.png');
$flatdb = $db->select("flats","flat_id>'170'");
foreach($flatdb as $flat){
	echo "starting :".$flat['flat_id']."<br>";
	$sourceimage = 'images/big/'.$flat['main_img'];
	if (makestamp($stamp, $sourceimage)) echo "main photo done<br>"; else echo "main photo PROBLEM!!!<br>"; 
	$photodb =  $db->select("photos","flat_id='".$flat['flat_id']."'");
	foreach($photodb as $photo) {
		if (makestamp($stamp, 'images/big/'.$photo['image_url'])) echo 'images/big/'.$photo['image_url']." done<br>";
		else echo 'images/big/'.$photo['image_url']." PROBLEM!!!<br>";
	}
}

function makestamp($stamp, $sourceimage){
	$ext = strtolower(pathinfo($sourceimage, PATHINFO_EXTENSION));
	if ($ext=="jpg") $im = imagecreatefromjpeg($sourceimage);
		else if ($ext=="png") $im = imagecreatefrompng($sourceimage);
			else return false;
	
	$sx = (int)(imagesx($im)/2 - imagesx($stamp)/2); 
	$sy = (int)(imagesy($im)/2 - imagesy($stamp)/2);
	
	// Copy the stamp image onto our photo using the margin offsets and the photo 
	// width to calculate positioning of the stamp. 
	imagecopy($im, $stamp, $sx, $sy, 0, 0, imagesx($stamp), imagesy($stamp));
	imagejpeg($im, $sourceimage, 85);
	return true;
}
?>