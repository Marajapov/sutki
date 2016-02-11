<? 
					$photoZsql = "room_id='0' AND album_id='0' AND flat_id='".$flat['flat_id']."'";
					$photoZdb = $db->select("photos", $photoZsql);
					if (true) {
?>
                 <div class="sliders">
					<p class="insTitle">Фотографии</p>
                 <div class="galery">
                 	
                 	 <ul class="bxsliderMain">
                     <img src="http://www.sutki.kg/images/big/<?=$flat['main_img'];?>" />
                 	   <? 
							foreach($photoZdb as $photoz){
					   ?>
                       <img src="http://www.sutki.kg/images/big/<?=$photoz['image_url'];?>"  />
                       <? } ?>
                     </ul>
                 	 
                 	 <div id="bx-pagerMain">
                     <a data-slide-index="0" href=""><img src="http://www.sutki.kg/images/thu/<?=$flat['main_img'];?>" width="113" height="72"  /></a>
                       <? 
					   		$i=0;
							foreach($photoZdb as $photoz){
							$i++;
					   ?>
                       <a data-slide-index="<?=$i;?>" href=""><img src="http://www.sutki.kg/images/thu/<?=$photoz['image_url'];?>" width="113" height="72"  /></a>
                       
                       <? } ?>
                       </div>
                 	 </div>
                 </div>
                 <br />
                 <? }?>
                 
                 
                 
                 <? 
				 	//$albumsql = "room_id=0 AND album_id>0 AND flat_id='".$flat['flat_id']."'";
					
					foreach($albumdb as $album){
					$photosql = "room_id=0 AND album_id='".$album['album_id']."' AND flat_id='".$flat['flat_id']."'";
					$photosdb = $db->select("photos", $photosql);
					?><?
					if (count($photosdb)>0) {
				?>
                 <div class="sliders">
					<p class="insTitle"><?=$album['name_ru'];?></p>
                 <div class="galery">
                 	
                 	 <ul class="bxslider<?=$album['album_id']?>">
                 	   <? 
							foreach($photosdb as $photo){
					   ?>
                       <img src="http://www.sutki.kg/images/big/<?=$photo['image_url'];?>" />
                       <? } ?>
                     </ul>
                 	 
                 	 <div id="bx-pager<?=$album['album_id']?>">
                       <? 
					   		$i=-1;
							foreach($photosdb as $photo){
							$i++;
					   ?>
                       <a data-slide-index="<?=$i;?>" href=""><img src="http://www.sutki.kg/images/thu/<?=$photo['image_url'];?>" width="113" height="72"  /></a>
                       
                       <? } ?>
                       </div>
                 	 </div>
                 </div>
                 <? } else {?>
                 <div class="sliders"><p class="insTitle"><?=$album['name_ru'];?></p></div>
                 <? }?><br />

                 <?=$album['description_ru']?><hr>
                 <div id="clear"></div>
                 <? } ?>