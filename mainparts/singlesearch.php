<? include 'makeurl.php';?>
<div class="searchItem">
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
                  		<? if ($flat['flashtour']!="") {?>
                  		<div class="deg360"></div>
                        <? } ?>
                        <? $photoSlideZ = $db->select("photos", "flat_id='".$flat['flat_id']."'"); ?>
                        <div class="searchImg">
                            <div class="slideshowcontainercompact<?=$flat['flat_id']?>" style="background:#111 url('/images/thu/<?=$flat['main_img'];?>')">
                                <ul class="slideshowcompact<?=$flat['flat_id']?>">
                                <li><img src="/images/thu/<?=$flat['main_img'];?>"  /></li>
                                <? foreach($photoSlideZ as $photoslide){?>
                                <li><img src="/images/thu/<?=$photoslide['image_url'];?>"  /></li>
                                <? } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="searchShadow"></div>
                         <div class="searchDesc">
                         <p class="descTitle" style=" height:26px; overlay:hidden; margin-top:0px;"><?=$flat['name_ru'];?></p>
                         <p style="font-weight:bold; height:20px; overlay:hidden; color:#999"><? include '../mainparts/address.php'; echo $fulladdress;?></p>
                         <div style="height:30px; overflow:hidden"><?=$flat['description_ru'];?>…</div>
                         <div class="searchIcon"  style="margin-top:5px; width:290px; height:36px; overflow:hidden"><? $invheight = 36; include '../mainparts/inventory.php';?></div>
                         <div class="searchPrice"><? include '../mainparts/pricecompact.php';?><span><?=$curname;?></span></div>
                         </div>
</div>  <!--end searchItem--> 
</a>