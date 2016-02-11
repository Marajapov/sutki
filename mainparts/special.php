<p class="mainTitle">Спецпредложения</p>
<? 
	$specialsql = "special=1 AND city='".$searchcity."'";
	if ($detailpageFlag) $specialsql .= " AND flat_id <> '".$flat['flat_id']."'"; 
	$rwFlats = $db->select("flats", $specialsql, "*", "order by flat_id desc");
	foreach($rwFlats as $flat) include 'singletall.php';
?>
