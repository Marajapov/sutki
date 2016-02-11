<hr>
<?php
		$photosdb = $db->select("photos", "room_id=".$room["room_id"], "*", "","");
		$ph = count($photosdb)>0?$photosdb[0]:"";
?>
<a href = "http://www.sutki.kg/ru/detailroom.php?room=<?=$room['room_id']?>&id=<?=$flat['flat_id']?>">
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
                  		
                        <div class="searchImg">
                        <img src="http://www.sutki.kg/images/thu/<?php echo $ph['image_url']; ?>" width="232px" height="" alt="" /></div><div class="searchShadow"></div>
                         <div class="searchDesc">
                         <p class="descTitle" style=" height:26px; overlay:hidden; margin-top:0px;"><?=$room['name_ru'];?></p>
                         
                         <div style="height:50px; overflow:hidden"><?=nl2br($room['description_ru']);?></div>
                         
                         <div class="searchIcon"  style="margin-top:5px; width:370px; height:36px; overflow:hidden">
                         <? $roominv = true; $invheight = 36; include '../mainparts/inventory.php';?>
                         </div>
                         <div class="searchPrice">
						 <? 
						 	if ($flat['flat_type']==3 || $flat['flat_type']==5) echo $room['price_day']; else echo $room['price'];  
						 ?><span><? if ($room['currency']=="" || $room['currency']=="0") echo "сом"; else echo "$";?></span></div>
                         </div>
</div>  <!--end searchItem--> 
</a>