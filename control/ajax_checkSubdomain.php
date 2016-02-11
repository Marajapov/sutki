<?
require "../config.php";
$sub=getget('sub');
$flat=(int)getget('flat');

if (!$sub) { echo "-1";}
else {
	if ($flat=="") $flat=0;
	$q = "name like '".$sub."'";
	$res = $db->select("reserveddb",$q);
	if (count($res)==0){
	$q = "objectlog like '".$sub."' AND flat_id <> '".$flat."'";
	$res = $db->select("flats",$q);
	}
	echo count($res); 
}
?>