<?
	if ($roominv){
		if (((int)$room['bed'])>0 &&((int)$room['bed'])<7 ) echo '<img src="http://www.sutki.kg/images/inventoryicons/bed_'.$room['bed'].'.png" height="'.$invheight.'px" /> ';}
	else {
		if (((int)$flat['bed'])>0 &&((int)$flat['bed'])<7 ) echo '<img src="http://www.sutki.kg/images/inventoryicons/bed_'.$flat['bed'].'.png" height="'.$invheight.'px" /> ';
	}
	
	$puresql = "SELECT inventory.img, inventory.inventory FROM inventory INNER JOIN flat_inventory ON inventory.inventory_id = flat_inventory.inventory_id WHERE flat_inventory.flat_id='".$flat['flat_id']."'";
	if ($roominv) $puresql .= " AND room_id='".$room['room_id']."'";
	$puresql .= " GROUP BY inventory.inventory_id ORDER BY inventory.order ASC";
	$rwFlatInventorys = $db->selectpuresql($puresql);
	//echo "a".count($rwFlatInventorys);
	foreach($rwFlatInventorys as $flatinventory) {
		echo '<img src="http://www.sutki.kg/images/inventoryicons/'.$flatinventory['img'].'" title="'.$flatinventory['inventory'].'" alt="'.$flatinventory['inventory'].'" height="'.$invheight.'px" /> ';
	}
?>