<a href = "detail.php?id=<?=$flat['flat_id']?>">					
                    <div class="sbItem">
                    
                    
                    
                    <div class="sbPrice"><?=$flat['name_ru'];?></div>
                    	<div class="sbPreview">
                        <? 
					if ($flat['discount']>0) {
						$exp_date = $flat['discount_date'];
						$todays_date = date("Y-m-d");
						
						$today = strtotime($todays_date);
						$expiration_date = strtotime($exp_date);
						
						if ($expiration_date >= $today) {
					?>
                    
                        <div class="discount-v2">
                        <p>скидка</p><span><?=$flat['discount']?></span><span class="disSlice">%</span>

                        </div>
					<? }} ?>
                        <img src="../images/thu/<?=$flat['main_img']?>" width="232px" height="" alt="" /></div>
                        <div class="sbTitle">
                        <?=$flat['street']?> <?=$flat['homenumber']?> <?=$flat['apartment']?> 
                        <br />пер. <?=$flat['crosses']?>
                        <br />ор.	<?=$flat['landmark_ru']?>
                        </div>
                        <div class="sbMainPrice">
                        <?
				 	$pr1 = (int)returnprice($flat['price_night'], $flat['currency'], $usdtokgs, $flat['discount']);
                 	$pr2 = (int)returndiscountprice($flat['price_night'], $flat['currency'], $usdtokgs, $flat['discount'], $flat['discountdate_from'], $flat['discount_date']);
				 ?>
                       <div class="leftPrice">
                  		<? if ($pr1 > $pr2) {?>
                       <div class="discountTitle">Цена со скидкой</div><span><?=$pr2?></span> <i><?=$curname;?></i></div>
                       <div class="rightPrice">
                       <div class="discountTitle">Цена без скидки</div><span><?=$pr1?></span><i><?=$curname;?></i></div>
                        <? } else {?>
                       <div class="discountTitle">Цена</div><span><?=$pr2?></span> <i><?=$curname;?></i></div>
                       <div class="rightPrice"><div class="discountTitle">&nbsp;</div><span>&nbsp;</span><i>&nbsp;</i></div> 
                        <? } ?>
                       
                       </div>
                  </div>
</a>