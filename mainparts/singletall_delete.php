<a href = "detail.php?id=<?=$flat['flat_id']?>">
<div class="sbItem">
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
                 <div class="sbPreview">
                 <img src="../images/thu/<?=$flat['main_img']?>" width="232px" height="" alt="" />
                 </div>
                 <div class="sbShadow"></div>
                 
                 <div class="sbDesc">
                 <p style="color:#0f8fea"><?=$flat['name_ru'];?></p>
                 <p style="color:#333">
				  	<?=$flat['street']?> <?=$flat['homenumber']?> <?=$flat['apartment']?> 
					<br />пер. <?=$flat['crosses']?>
					<br />ор.	<?=$flat['landmark_ru']?>
                 </p>
                 <span>
                 <div style="max-height:100px; overflow:hidden"><?=$flat['description_ru'];?></div>
                 </span>
                 </div>
                 
                 <div class="sbBottom">
                 <?
				 	$pr1 = (int)returnprice($flat['price_night'], $flat['currency'], $usdtokgs, $flat['discount']);
                 	$pr2 = (int)returndiscountprice($flat['price_night'], $flat['currency'], $usdtokgs, $flat['discount'], $flat['discount_date']);
				 ?>
                 <div class="sbDiscount"><p>
				 
				 <? if ($pr1 > $pr2) echo $pr1; else echo " "; ?>
                 </p><span class="s">
                 <? if ($pr1 > $pr2) { ?><? if ($_SESSION['currency']==1) echo "$"; else echo "сом"; } else echo " ";?>
                 </span></div>
                 
                 <div class="sbPrice">
                 <p>
                 <? echo $pr2 ?>
                 </p><span class="s">
                 <? if ($_SESSION['currency']==1) echo "$"; else echo "сом"; ?>
                 </span>
                 </div>
                 
                 </div>
                 </div><!--end sbItem-->
</a>