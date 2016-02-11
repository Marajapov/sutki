<?
	$objectlog = getpost('objectlog');
	if (strlen($objectlog)>0){
		
		$subdq = "name like '".$objectlog."'";
		$subdresult = $db->select("reserveddb",$subdq);
		if (count($subdresult)>0) $subdomainFlag = true;
		else {
			$subdq = "objectlog like '".$objectlog."'";
			if ($flat_id>0)	$subdq  .= " AND NOT flat_id='".$flat_id."'";
			$subdresult = $db->select("flats",$subdq);
			if (count($subdresult)>0) $subdomainFlag = true;
		}
	} else $objectlog = "unknown404";
	
	function transliterate($textcyr){
        $cyr  = array('а','б','в','г','д','e','ж','з','и','й','к','л','м','н','о','п','р','с','т','у', 
        'ф','х','ц','ч','ш','щ','ъ','ь', 'ю','я','А','Б','В','Г','Д','Е','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У',
        'Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ь', 'Ю','Я' );
        $lat = array( 'a','b','v','g','d','e','zh','z','i','y','k','l','m','n','o','p','r','s','t','u',
        'f' ,'h' ,'ts' ,'ch','sh' ,'sht' ,'a' ,'y' ,'yu' ,'ya','A','B','V','G','D','E','Zh',
        'Z','I','Y','K','L','M','N','O','P','R','S','T','U',
        'F' ,'H' ,'Ts' ,'Ch','Sh' ,'Sht' ,'A' ,'Y' ,'Yu' ,'Ya' );
        $textcyr = str_replace($cyr, $lat, $textcyr);
		$textcyr = str_replace("-", "", $textcyr);
		preg_replace("/[^A-Za-z0-9 ]/", '', $string);
	}
?>