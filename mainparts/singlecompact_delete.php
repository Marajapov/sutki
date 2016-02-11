<a href = "detail.php?id=<?=$flat['flat_id']?>">
<div class="mainItem">
					<? 
					if ($flat['discount']>0) {
						$exp_date = $flat['discount_date'];
						$todays_date = date("Y-m-d");
						
						$today = strtotime($todays_date);
						$expiration_date = strtotime($exp_date);
						
						if ($expiration_date >= $today) {
					?>
                        <div class="discount">
                          <p>Скидка<span><?=$flat['discount']?>%</span></p>
                        </div>
					<? }} ?>
					<? if ($flat['special']==1) {?>
                    <div class="specialOffer"><p>Спецпредложение!</p></div>
                    <? } ?>
                   <div class="preview">
                   <img src="../images/thu/<?=$flat['main_img']?>" width="232px" height="" alt="" />
                   </div>
                   
                   <div class="description">
                   <p class="descTitleCompact" style="margin-top:0px" ><?=$flat['name_ru'];?></p>
                   <p class="descAddressCompact"><?=$flat['street']?> <?=$flat['homenumber']?> <?=$flat['apartment']?>(пер. <?=$flat['crosses']?>, <?=$flat['landmark_ru']?>)
                   </p>
                     
                   </div>
                   <div class="CompactIcon"><? $invheight = 18; include '../mainparts/inventory.php';?></div>
                 
                  <div class="price" align="center">
                  <p><? 
				  if ($flat['flat_type']<3){
				  echo showdiscountprice($flat['price_night'], $flat['currency'], $usdtokgs, $flat['discount'], $flat['discount_date']); ?><? 
				  }
				  else {
					
					$rwRooms = $db->select("rooms", "flat_id='".$flat['flat_id']."'");
					if (count($rwRooms)){
					if (count($rwRooms)==1) 
					$maxpr = 0;
					$minpr = 0;
					foreach($rwRooms as $rwroom){
						$thispr = returndiscountprice($rwroom['price_night'], $rwroom['currency'], $usdtokgs, $rwroom['discount'], $rwroom['discount_date']);
						if ($maxpr==0 || $thispr>$maxpr) { $maxpr = $thispr; }
						if ($minpr==0 || $thispr<$minpr) { $minpr = $thispr; }
					} 
					if (count($rwRooms)>1) echo $minpr ." - ". $maxpr; 
					else echo $minpr;
				  }}
				  ?><span><? if ($_SESSION['currency']==1) echo "$"; else echo "сом";?></span></p>
                  </div>
</div>
</a>