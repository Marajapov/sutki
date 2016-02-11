<?
$fulladdress = "";
if ($flat['street']!="") $fulladdress = $flat['street'];
if ($flat['homenumber']!="" && $flat['homenumber']>0) $fulladdress .=  " ".$flat['homenumber'];
if ($flat['apartment']!="" && $flat['apartment']>0) $fulladdress .=  " ".$flat['apartment'];
if ($fulladdress=="") {
	$CurrentDistrict = $db->select_one("regions","region_id='".$flat['district']."'");
	$fulladdress=$CurrentDistrict['region_title'];
}
if (!$shortaddress) {
	if ($detailpageFlag){
		$fulladdress .=  '<br /><font color="#FF0000">Пересекается:</font>'.$flat['crosses'];
		$fulladdress .=  '<br/><font color="#FF0000">Ориентир:</font>'. $flat['landmark_ru'];
	} 
	else if ($flat['crosses']!="" || $flat['landmark_ru']!="" ){	
		$fulladdress .=  ' (';
		if ($flat['crosses']!="") $fulladdress .=  'пер.'. $flat['crosses'];
		if ($flat['crosses']!="" && $flat['landmark_ru']!="") $fulladdress .=  ', ';
		if ($flat['landmark_ru']!="") $fulladdress .=  $flat['landmark_ru'];
		$fulladdress .=  ')';
	 } 
}
?>