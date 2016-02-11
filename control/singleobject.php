<div id="ControlObjectItem">
<div class="searchImg"><img src="/images/thu/<?=$flat['main_img'];?>"/></div>
<div class="descTitleControlObject"><?=$flat['name_ru'];?></div>
<div class="descAddressControlObject"><? include '../mainparts/address.php'; echo $fulladdress;?></div>
<div class="EditDeleteControlObject">
	
    
    <div style="outline: 1px solid #666; padding:5px">
    <? if ($flat['approved']=="1") {?>
    <img src="../cms/images/tick_circle1.png" width="16" height="16" />
	<? } else {?>
	<img src="../cms/images/tick_circle0.png" title="Ещё не одобрено" width="16" height="16" />
    <? } ?>
	<? if (strlen($flat['objectlog'])>0 && $flat['objectlog']!="unknown404") {
		$objlog = $flat['objectlog'];
	?>
    <a href="http://www.sutki.kg/ru/detail.php?objectlog=<?=$objlog?>" target="_blank"><?=$objlog?></a>
    <? } ?>
    </div>
    <br />

	<div style="outline: 1px solid #666; padding:5px">
	<img src="../cms/images/page_white_edit.png" width="16" height="16" /> 
    
    <a href="<?
    if ($flat['flat_type']==3 || $flat['flat_type']==5) echo "hotel_edit.php";
	else if ($flat['flat_type']==4) {
		if ($flat['sauna_type']==1) echo "sauna_single.php";
		else echo "sauna_edit.php"; 
		}
	else echo "flat_edit.php";
	?>?flat_id=<?=$flat['flat_id'];?>">Редактировать</a>
    
    </div>
    <br/>
    <div style="outline: 1px solid #666; padding:5px">
    <img src="../cms/images/cross.png" width="16" height="16" /> <a onClick='return confirm("Вы уверены, что хотите удалить?");' href="delete_object.php?flat_id=<?=$flat['flat_id']?>">Удалить</a>
    </div>
</div>
<div class="descDescControlObject"><?=$flat['description_ru'];?>…</div><div class="clear"></div>
<div class="searchIconControlObject"><? $invheight = 20; include '../mainparts/inventory.php';?></div>

</div>
<div class="clear"></div>

<!---  END OF MAIN --->
<div id="extra_<?=$flat['flat_id'];?>">
<?
	
	if ($flat['flat_type']<3 || $flat['sauna_type']==1) {
		$photozdb = $db->select("photos","flat_id='".$flat['flat_id']."' AND room_id='0' and album_id='0'");
?>
<div style="border: 0; border-bottom: 1px dashed #eaeaea;background: #999;"></div>
<div id="InsideControlObjectItem">
	<div style="float:left;color:#F00;margin-top:5px; font-weight:bold">&raquo; Фотографии
    <? if(count($photozdb)==0) echo "(нет фотографий)";?>
    </div> 
	<div style="outline: 1px solid #666; padding:5px; float:right;">
	<img src="../cms/images/page_white_edit.png" width="16" height="16" /> <a href="flatphotos.php?flat_id=<?=$flat['flat_id']?>">Управлять фотографиями</a>
    </div>
    <div class="clear"></div>
	
	<? foreach($photozdb as $photos) {?>
    <div style="float:left; margin-top:10px;margin-left:10px;outline: 1px solid #666;">
    <img src="/images/thu/<?=$photos['image_url'];?>" height="60px" />
	</div>
	<? } ?>
    
</div>
<? } ?>
<!---  END OF PHOTOS --->
<?
	
	if ($flat['flat_type']>2 && $flat['sauna_type']==0) {
		$albumdb = $db->select("albums","flat_id='".$flat['flat_id']."'");
?>
<div style="border: 0; border-bottom: 1px dashed #eaeaea;background: #999;"></div>
<div id="InsideControlObjectItem">
	<div style="float:left;color:#F00;margin-top:5px; font-weight:bold">&raquo; Фотоальбомы</div> 
	
    <? if (count($albumdb)>0) {?>
    <div style="outline: 1px solid #666; padding:5px; float:right;">
	<img src="../cms/images/page_white_edit.png" width="16" height="16" /> <a href="albums.php?flat_id=<?=$flat['flat_id']?>">Управлять фотоальбомы</a>
    </div>
    <? } ?>
    
    <div style="outline: 1px solid #666; padding:5px; float:right; margin-right:10px"><img src="../cms/images/103.png" width="16" height="16" /> <a href="album_add.php?flat_id=<?=$flat['flat_id']?>">Добавить Фотоальбом</a>
    </div>
    <div class="clear"></div>
	
	<? 
		foreach($albumdb as $album) {
	?>
    <br />
  <div style="float:left;"><ul><li><?=$album['name_ru'];?></li></ul></div><div class="clear"></div>
  <div style="float:left; max-height:36px; overflow:hidden; color:#999"></div><div class="clear"></div>
    <? 
		$aphotozdb = $db->select("photos","album_id='".$album['album_id']."'");	
		foreach($aphotozdb as $aphotos){
	?>
    <div style="float:left; margin-top:10px;margin-left:10px;outline: 1px solid #666;">
    <img src="/images/thu/<?=$aphotos['image_url'];?>" height="60px" />
	</div>
    <? } ?>
    <div class="clear"></div>
	<? } ?>
    
</div>
<? } ?>
<div class="clear"></div>
<!---  END OF ALBUMS --->

<?
	
	if ($flat['flat_type']>2 && $flat['sauna_type']==0) {
		$roomsdb = $db->select("rooms","flat_id='".$flat['flat_id']."'");
?><br />

<div style="border: 0; border-bottom: 1px dashed #eaeaea;background: #999;"></div>
<div id="InsideControlObjectItem">
	<div style="float:left;color:#F00;margin-top:5px; font-weight:bold">&raquo; Категории номеров
    <? if(count($roomsdb)==0) echo "(нет добавляемый номер)";?>
    </div> 
	
    <? if (count($roomsdb)>0) {?>
    <div style="outline: 1px solid #666; padding:5px; float:right;">
	<img src="../cms/images/page_white_edit.png" width="16" height="16" /> <a href="<?
    if ($flat['flat_type']==3 || $flat['flat_type']==5 ) echo "hotel_rooms.php";
	else if ($flat['flat_type']==4) echo "sauna_rooms.php";
	?>?flat_id=<?=$flat['flat_id'];?>">Управлять</a>
    </div>
    <? } ?>
    
    <div style="outline: 1px solid #666; padding:5px; float:right; margin-right:10px"><img src="../cms/images/103.png" width="16" height="16" /> <a href="<?
    if ($flat['flat_type']==3|| $flat['flat_type']==5 ) echo "hotel_rooms_add.php";
	else if ($flat['flat_type']==4) echo "sauna_rooms_manage.php";
	?>?flat_id=<?=$flat['flat_id'];?>">Добавить номер</a>
    </div>
    <div class="clear"></div>
	
	<? 
		foreach($roomsdb as $room) {
	?>
    <br />
  <div style="float:left;"><ul><li><?=$room['name_ru'];?></li></ul></div><div class="clear"></div>
  <div style="float:left; max-height:36px; overflow:hidden; color:#999"></div><div class="clear"></div>
    <? 
		$rphotozdb = $db->select("photos","room_id='".$room['room_id']."'");	
		foreach($rphotozdb as $rphotos){
	?>
    <div style="float:left; margin-top:10px;margin-left:10px;outline: 1px solid #666;">
    <img src="/images/thu/<?=$rphotos['image_url'];?>" height="60px" />
	</div>
    <? } ?>
    <div class="clear"></div>
	<? } ?>
    
</div>


<? } ?>
<!---  END OF ROOMS --->



<div class="clear"></div><br />
</div>
<hr class="controlsplitter" />