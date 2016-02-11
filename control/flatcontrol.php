<?
	if (!$session->isAdmin()) {
		if (($userid * $flat_id)>0){
			$flatcount = $db->select_count("flats", "user_id='" . $userid . "' AND flat_id='" . $flat_id . "'", "flat_id", "", "");
			if ($flatcount==0) { 
				redirect("index.php?action=flatowner", "js");
			}
		} 
		else{
			redirect("index.php?action=flatowner", "js");
		}
	}
?>