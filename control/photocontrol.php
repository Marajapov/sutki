<?
	if (!$session->isAdmin()) {
		if ($photo_id>0){
			$photocount = $db->select_count("photos", "photo_id='" . $photo_id . "' AND flat_id='" . $flat_id . "'", "photo_id", "", "");
			if ($photocount==0) {redirect("index.php?action=photoowner", "js");}
		}
	}
	
?>