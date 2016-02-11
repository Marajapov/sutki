<div class="sbMainPrice">
<?
$curname = "сом"; if ($flat['currency']==1) $curname = "$";
if ($flat['flat_type']<3 || $flat['sauna_type']==1){					   
	if ($flat['flat_type']<3){
		$pr1 = (int)returnprice($flat['price_night'], $flat['currency'], $usdtokgs, $flat['discount']);
		$pr2 = (int)returndiscountprice($flat['price_night'], $flat['currency'], $usdtokgs, $flat['discount'], $flat['discountdate_from'], $flat['discount_date']);
	} else {$pr1=0; $pr2 = $flat['price'];}
?>
<div class="leftPrice">
<? if ($pr1 > $pr2) {?>
<div class="discountTitle">Цена со скидкой</div><span><?=$pr2?></span> <i><?=$curname;?></i></div>
<div class="rightPrice">
<div class="discountTitle">Цена без скидки</div><span><?=$pr1?></span><i><?=$curname;?></i></div>
<? } else {?>
<div class="discountTitle">Цена</div><span><?=$pr2?></span> <i><?=$curname;?></i></div>
<div class="rightPrice"><div class="discountTitle">&nbsp;</div><span></span><i>&nbsp;</i></div> 
 <? } 
 } else {?>
<div class="leftPrice"><div class="discountTitle">Цена</div><span><? include '../mainparts/pricecompact.php';?></span> <i><?=$curname;?></i></div>
<div class="rightPrice"><div class="discountTitle">&nbsp;</div><span></span><i>&nbsp;</i></div> 
 <? } ?>                  
</div>