<hr>
<?php
		$photosdb = $db->select("photos", "room_id=".$room["room_id"], "*", "","");
		$ph = count($photosdb)>0?$photosdb[0]:"";
        ?>
<a href = "detailroom.php?room=<?=$room['room_id']?>&id=<?=$flat['flat_id']?>">
<div class="searchItem">
					<? 
					if ($room['discount']>0) {
						$exp_date = $room['discount_date'];
						$todays_date = date("Y-m-d");
						
						$today = strtotime($todays_date);
						$expiration_date = strtotime($exp_date);
						
						if ($expiration_date >= $today) {
					?>
						<div class="discount">
                      		<p>Скидка<span><?=$room['discount']?>%</span></p>
                      	</div>
                    <? }} ?>
                  	<? if ($room['special']==1) {?>
                    <div class="specialOffer" id="searchOffer"><p>Спецпредложение!</p></div>
                   	<? } ?>
						<? if ($room['flashtour']!="") {?>
                  		<div class="deg360"></div>
                        <? } ?>
                        <div class="searchImg"><img src="../images/thu/<?php echo $ph['image_url']; ?>" width="232px" height="" alt="" /></div><div class="searchShadow"></div>
                         <div class="searchDesc">
                         		<p class="searchName" style="margin-top:0px; color:#0f8fea"><?=$room['name_ru'];?></p>
                         		
                         		<p class="searchDescText"><?=$room['description_ru'];?>...</p>
                                </div>
                         	<div class="searchIcon"><? $roominv = true; $invheight = 25;include 'inventory.php';?></div>
                         	<div class="searchPrice"><? echo showprice($room['price_night'], $room['currency'], $usdtokgs); ?><span><? if ($_SESSION['currency']==1) echo "$"; else echo "сом"; ?></span></div>
                         
</div>
</a>