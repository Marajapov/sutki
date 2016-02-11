<? include 'makeurl.php';?>
<div class="mainItem-v2">
					<? 
					if ($flat['discount']>0) {
						$exp_date = $flat['discount_date'];
						$todays_date = date("Y-m-d");
						
						$today = strtotime($todays_date);
						$expiration_date = strtotime($exp_date);
						$str_date = strtotime($flat['discountdate_from']);
						
						//if ($str_date <= $today && $expiration_date >= $today) {
							if (true) {
					?>
                    
                        <div class="discount-v2">
                        <p>скидка</p><span><?=$flat['discount']?></span><span class="disSlice">%</span>

                        </div>
					<? }} ?>
                    <? $photoSlideZ = $db->select("photos", "flat_id='".$flat['flat_id']."'"); ?>
                  	<div class="itemPreview">
                    
                    <div class="slideshowcontainercompact<?=$flat['flat_id']?>" style="background:#111 url('/images/thu/<?=$flat['main_img'];?>')">
                        <ul class="slideshowcompact<?=$flat['flat_id']?>">
                        <li><img src="/images/thu/<?=$flat['main_img'];?>"  /></li>
                        <? foreach($photoSlideZ as $photoslide){?>
                        <li><img src="/images/thu/<?=$photoslide['image_url'];?>"  /></li>
                        <? } ?>
                        </ul>
                    </div>
                    
                    
                    </div>

					
                    <p class="descTitleCompact" style="margin-top:0px" ><?=$flat['name_ru'];?></p>
                    

                    <div class="descAddressCompact" >
					<? include '../mainparts/address.php'; echo $fulladdress;?>
                   </div>
                    <div class="priceBg" >
                    <span  style="width:50px; overflow:hidden">

                    <? include '../mainparts/pricecompact.php';?>

                    </span><span class="slice"><?=$curname;?></span></div>
                    <div class="iconField">
                    <? $invheight = 36; include '../mainparts/inventory.php';?>
                    </div>
                    <? //if ($flat['special']==1) {?>
                    <!--<div class="specialOffer"><span>Спец<br />предложение</span></div>-->

</div>
</a>