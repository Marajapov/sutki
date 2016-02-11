                	<div class="insTable">
  <table border="0" width="100%">
                    <tr>
                      <td width="91%" valign="top">
                      <div class="general-info">
                      <p>Общая информация</p><div id="clear"></div>
<? if ($flat['room']!="" && $flat['room']>0) {?>
<div class="detailheader">Комнаты:</div> 
<div class="detailvalue"><?=$flat['room'];?></div>
<div id="clear"></div>
<? } ?>
<? if ($flat['bed']!="" && $flat['bed']>0) {?>
<div class="detailheader">Спальных мест:</div> 
<div class="detailvalue"><?=$flat['bed'];?></div>
<div id="clear"></div>
<? } ?>

                      </div>
                      </td>
                      <td width="9%" valign="top">&nbsp;</td>
    </tr>
                    </table>
</div>
  	
                    <div class="insDesc">
                    <p class="insTitle">Описание<p>
                  <p><? $dsc=nl2br($room['description_ru']);  echo str_replace('  ','&nbsp;&nbsp;',$dsc);?></p>
                  	<!-- table ---->
                     <?=$rwRooms['tbl']; ?>
                  
                    <!-- table -->
                  </div> 
                            
<hr>	
                  <? if (strlen($room['flashtour'])>4) {?>
                  <div class="tour">
                		<p class="insTitle">Виртуальный тур</p>
                        <div class="virtualTour">
                            <object  data="http://www.sutki.kg/flashtour/<?=$room['flashtour'];?>" width="720" height="477"></object>
                    	</div>
                   </div>    
                   
                   <div id="clear"></div>
                   <? } ?>
                 
                 <? 
					$photosql = "room_id='".$room['room_id']."' AND flat_id='".$flat['flat_id']."'";
					$photosdb = $db->select("photos", $photosql);
					?><?
					if (count($photosdb)>0) {
				?>
                 <div class="sliders">
					<p class="insTitle">Фотографии</p>
                 <div class="galery">
                 	
                 	 <ul class="bxslider">
                 	   <? 
							foreach($photosdb as $photo){
					   ?>
                       <img src="/images/big/<?=$photo['image_url'];?>" />
                       <? } ?>
                     </ul>
                 	 
                 	 <div id="bx-pager">
                       <? 
					   		$i=-1;
							foreach($photosdb as $photo){
							$i++;
					   ?>
                       <a data-slide-index="<?=$i;?>" href=""><img src="/images/thu/<?=$photo['image_url'];?>" width="113" height="72"  /></a>
                       
                       <? } ?>
                       </div>
                 	 </div>
                 </div>
                 <? } ?>
                 <div id="clear"></div> 
<?
$puresql = "SELECT inventory.img, inventory.inventory FROM inventory inner JOIN flat_inventory ON inventory.inventory_id = flat_inventory.inventory_id where flat_inventory.room_id='".$room['room_id']."'";
$rwFlatInventorys = $db->selectpuresql($puresql);
if (count($rwFlatInventorys)){
?>

           <div class="inventory">
                  <p class="insTitle">Удобства</p>
              
                  <?
					foreach($rwFlatInventorys as $flatinventory) {
				  ?>
                  <div class="itemInventory">
                  <img src="http://www.sutki.kg/images/inventoryicons/<?=$flatinventory['img'];?>"/><p class="itemTxt"><?=$flatinventory['inventory'];?></p> 
                  </div>
                  <? } ?>
      </div>
      <div id="clear"></div>
<? } ?>
<?
$rwRooms = $db->select("rooms","room_id<>'".$room['room_id']."' AND flat_id='".$flat['flat_id']."'");
if (count($rwRooms)>0) {
?>	
<hr />
<p class="insTitle"><?=$arrType[$flat_type];?> "<?=$flat['name_ru'];?>" также предлагает:</p>	
<table width="200" border="0" class="table-lvl2">              
<? 
	foreach($rwRooms as $rwroom) {
?>
	<tr>
                        <td><i class="check"></i><a href="detailroom.php?id=<?=$flat['flat_id'];?>&room=<?=$rwroom['room_id'];?>" style="color:#000"><?=$rwroom['name_ru'];?></a></td>
                        <td><span><? echo showdiscountprice($rwroom['price_day'], $rwroom['currency'], $usdtokgs, $rwroom['discount'], $flat['discountdate_from'], $rwroom['discount_date']); ?></span> <? if ($rwroom['currency']==1) echo "$"; else echo "сом"; ?></td>
                      </tr>
<? } ?>
</table>
<? } ?>