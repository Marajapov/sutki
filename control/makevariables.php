<?
	$flat = $db->select_one("flats", "flat_id='" . $flat_id . "'", "*", "", "");
	$sauna = $db->select_one("saunadetails", "flat_id='" . $flat_id . "'", "*", "", "");
	$inventorydb = $db->select("flat_inventory", "flat_id='".$flat_id."'", "*", "","");
	
	$objectlog = $flat['objectlog'];
	$city = $flat['city'];
	$district = $flat['district'];
	$street = $flat['street'];
	$crosses = $flat['crosses'];
	$apartment = $flat['apartment'];
	$homenumber = $flat['homenumber'];
	$landmark_ru = $flat['landmark_ru'];
	$landmark_eng = $flat['landmark_eng'];
	$latitude = $flat['latitude'];
	$longitude = $flat['longitude'];
	$zoom = $flat['zoom'];
	
    $phone = $flat['phone'];
	$phone2 = $flat['phone2'];
	$phone3 = $flat['phone3'];
	$email = $flat['email'];
	$skype = $flat['skype'];
	$icq = $flat['icq'];
	
	$name_ru = $flat['name_ru'];
	$name_eng = $flat['name_eng'];
	$name_native = $flat['name_native'];
    $description_ru = $flat['description_ru'];
	$description_eng = $flat['description_eng'];
	$description_native = $flat['description_native'];
	
	$room = $flat['room'];
	$price = $flat['price'];
	$skidka = $flat['skidka'];
	
	$capacity = $sauna['capacity'];
	$skidkafrom = $sauna['skidkafrom'];
	$skidkato = $sauna['skidkato'];
	$servicefee = $sauna['servicefee'];
	$dancefloor = $sauna['dancefloor'];

	$steamvalue = $sauna['steam'];
	$steampowervalue = $sauna['steampower'];
	$poolvalue = $sauna['pool'];
	$cuisinevalue = $sauna['cuisine'];
	$shashlykvalue = $sauna['shashlyk'];
	$allowedvalue = $sauna['allowed'];

	$steamvalue = "";	foreach($steam as $item) {$steamvalue .= "|x|".$item;} 
	$steampowervalue = "";	foreach($steampower as $item) {$steampowervalue .= "|x|".$item;} 
	$poolvalue = "";	foreach($pool as $item) {$poolvalue .= "|x|".$item;} 
	$cuisinevalue = "";	foreach($cuisine as $item) {$cuisinevalue .= "|x|".$item;} 
	$shashlykvalue = "";	foreach($shashlyk as $item) {$shashlykvalue .= "|x|".$item;} 
	$allowedvalue = "";	foreach($allowed as $item) {$allowedvalue .= "|x|".$item;} 
    
?>