<? 
	if ($flat['flat_type']==3){
	$resultprice = showdiscountprice($room['price_day'], $flat['currency'], $usdtokgs, $room['discount'], $room['discountdate_from'], $room['discount_date']);}
	else{

	$resultprice = showdiscountprice($room['price'], $flat['currency'], $usdtokgs, $room['discount'], $room['discountdate_from'], $room['discount_date']);	
		}
	echo $resultprice;
?>