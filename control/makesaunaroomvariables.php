<?
	if ($room_id>0){
		$roomdb = $db->select_one("rooms", "room_id='" . $room_id . "'", "*", "", "");
		$sauna = $db->select_one("saunadetails", "room_id='" . $room_id . "'", "*", "", "");
		$inventorydb = $db->select("flat_inventory", "room_id='".$room_id."'", "*", "","");
		$massagedb = $db->select("sauna_massage", "room_id='".$room_id."'", "*", "","");
		$saunapricedb = $db->select("sauna_price", "room_id='".$room_id."'", "*", "","");
		
		$name_ru = $roomdb['name_ru'];
		$name_eng = $roomdb['name_eng'];
		$name_native = $roomdb['name_native'];
		$description_ru = $roomdb['description_ru'];
		$description_eng = $roomdb['description_eng'];
		$description_native = $roomdb['description_native'];
		
		$room = $roomdb['room'];
		$price = $roomdb['price'];
		$skidka = $roomdb['discount'];
		
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
	}
?>