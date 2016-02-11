<? include 'makeurl.php';?>
                    <div class="sbItem">
                    <div class="sbPrice"><?=$flat['name_ru'];?></div>
                    <div class="sbPreview">
                    <? 
					if ($flat['discount']>0) {
						$exp_date = $flat['discount_date'];
						$todays_date = date("Y-m-d");
						
						$today = strtotime($todays_date);
						$expiration_date = strtotime($exp_date);
						$start_date = strtotime($flat['discountdate_from']);
						
						if ($start_date <= $today && $expiration_date >= $today) {
					?>
                    
                        <div class="discount-v2">
                        <p>скидка</p><span><?=$flat['discount']?></span><span class="disSlice">%</span>

                        </div>
					<? }} ?>
                    	<? $photoSlideZ = $db->select("photos", "flat_id='".$flat['flat_id']."'"); ?>
                        	<div class="slideshowcontainerspecial<?=$flat['flat_id']?>" style="background:#111 url('/images/thu/<?=$flat['main_img'];?>')">
                            
                                <ul class="slideshowspecial<?=$flat['flat_id']?>">
                               <li><img src="http://www.sutki.kg/images/thu/<?=$flat['main_img'];?>"  /></li>
                                <? foreach($photoSlideZ as $photoslide){?>
                                
                                <li><img src="http://www.sutki.kg/images/thu/<?=$photoslide['image_url'];?>"  /></li>
                                <? } ?>
                                </ul>
                            </div>  
                        
                        </div>
                        <div class="sbTitle"><? include '../mainparts/address.php'; echo $fulladdress;?></div>
                        
                        <? include '../mainparts/singletallprice.php';?>
                    </div>
</a>