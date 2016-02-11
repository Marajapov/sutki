<?
	if (!$session->isAdmin()) {
		if ($room_id>0){
			$roomtcount = $db->select_count("rooms", "user_id='" . $userid . "' AND room_id='" . $room_id . "'", "room_id", "", "");
			if ($roomtcount==0) { 
				redirect("index.php?action=roomowner", "js");
			}
		} 
		else{
			redirect("index.php?action=roomowner", "js");
		}
	}
	
?>