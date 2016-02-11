<?php
$adres=$_GET["adress"];
$region=$_GET["region"];
$city="Бишкек";

include_once("class/GoogleMaps/googlemap.php");
include_once("class/GoogleMaps/jsmin.php");

$MAP_OBJECT = new GoogleMapAPI(); $MAP_OBJECT->_minify_js = isset($_REQUEST["min"])?FALSE:TRUE;
//$MAP_OBJECT->setDSN("mysql://user:password@localhost/db_name");
$MAP_OBJECT->addMarkerByAddress($region.','.$adres.' Bishkek, Kyrgyzstan',"", "", $tooltip="", $filename="http://www.bradwedell.com/phpgooglemapapi/demos/img/triangle_icon.png");
?>
<html>
<head>
<?=$MAP_OBJECT->getHeaderJS();?>
<?=$MAP_OBJECT->getMapJS();?>
</head>
<body>
<?=$MAP_OBJECT->printOnLoad();?> 
<?=$MAP_OBJECT->printMap();?>
<?=$MAP_OBJECT->printSidebar();?>
</body>
</html>