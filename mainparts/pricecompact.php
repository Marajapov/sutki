<?
$isRoom=false;
$curname = "сом"; if ($flat['currency']==1) $curname = "$";

if ($flat['flat_type']<3 || $flat['sauna_type']==1){
	if ($flat['flat_type']<3) $resultprice = showdiscountprice($flat['price_night'], $flat['currency'], $usdtokgs, $flat['discount'], $flat['discountdate_from'], $flat['discount_date']);
	else $resultprice = $flat['price'];
	 //$resultprice =$flat['price_night'];
}
else {
	$rwRooms = $db->select("rooms", "flat_id='".$flat['flat_id']."'");
	if (count($rwRooms)){
		//if (count($rwRooms)==1) 
		$maxpr = 0;
		$minpr = 0;
		$mincur = " сом";
		$maxcur = " сом";
		foreach($rwRooms as $rwroom){
			$coverprice = $flat['flat_type'] == 4 ? $rwroom['price']:$rwroom['price_night'];
			if ($flat['flat_type'] == 3 || $flat['flat_type'] == 5) $coverprice = $rwroom['price_day'];
			
			$thispr = returndiscountprice($coverprice, $rwroom['currency'], $usdtokgs, $rwroom['discount'], $rwroom['discountdate_from'], $rwroom['discount_date']);
			//echo $thispr;
			if ($maxpr==0 || $thispr>$maxpr) { $maxpr = $thispr; if ($rwroom['currency']==1) $maxcur = " $"; }
			if ($minpr==0 || $thispr<$minpr) { $minpr = $thispr; if ($rwroom['currency']==1) $mincur = " $";  }
		} 
		if (count($rwRooms)>1) {
				$isRoom = true;
				$curname = $mincur;
				$resultprice = $minpr." - ". $maxpr;
			}
		else {$resultprice = $minpr; $curname = $mincur;}
	}
}
echo $resultprice ;
?>