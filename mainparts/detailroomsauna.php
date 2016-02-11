<? $saunadb = $db->select_one("saunadetails", "room_id='".$room['room_id']."'");?> 
                	<div class="insTable">
  <table border="0" width="100%">
                    <tr>
                      <td width="91%" valign="top">
                      <div class="general-info">
                      <p>Общая информация!</p><div id="clear"></div>
<? if ($room['room']!="" && $room['room']>0) {?>
<div class="detailheader">Комнаты:</div> 
<div class="detailvalue"><?=$room['room'];?></div>
<div id="clear"></div>
<? } ?>
<? if ($saunadb['capacity']!="" && $saunadb['capacity']>0) {?>
<div class="detailheader">Вместимость:</div> 
<div class="detailvalue"><?=$saunadb['capacity'];?></div>
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
                  <p><?=nl2br($room['description_ru']);?></p>
                  </div>    
                  <div id="clear"></div>

                
                <? if (strlen($saunadb['dancefloor'])>1) { ?>
                <div class="insDesc">
                    <table width="100%" border="0">
                      <tr>
                        <td width="200px">Танцпол:</td>
                        <td width="20px">&nbsp;</td>
                        <td ><? echo $saunadb['dancefloor']; ?></td>
                      </tr>
                    </table>
                    
                    </div>
                <div id="clear"></div>
               <? } ?>
               
                <div class="insDesc">
                    <p class="insTitle">Парилка</p>
                    <table width="100%" border="0">
                      <tr>
                        <td width="200px">Парилка:</td>
                        <td width="20px">&nbsp;</td>
                        <td ><? echo str_replace("|x|", " ", $saunadb['steam']); ?></td>
                      </tr>
                      <tr>
                        <td width="200px">Отопление парилки:</td>
                        <td width="20px">&nbsp;</td>
                        <td ><? echo str_replace("|x|", " ", $saunadb['steampower']); ?></td>
                      </tr>
                    </table>
                    
                    </div>
                <div id="clear"></div>
                
                <div class="insDesc">
                    <table width="100%" border="0">
                      <tr>
                        <td width="200px">Бассейн:</td>
                        <td width="20px">&nbsp;</td>
                        <td ><? echo str_replace("|x|", " - ", $saunadb['pool']); ?></td>
                      </tr>
                      <tr>
                        <td width="200px">Кухня:</td>
                        <td width="20px">&nbsp;</td>
                        <td ><? echo str_replace("|x|", " - ", $saunadb['cuisine']); ?></td>
                      </tr>
                      <tr>
                        <td width="200px">Шашлыки:</td>
                        <td width="20px">&nbsp;</td>
                        <td ><? echo str_replace("|x|", " - ", $saunadb['shashlyk']); ?></td>
                      </tr>
                      <tr>
                        <td width="200px">&nbsp;</td>
                        <td width="20px">&nbsp;</td>
                        <td ><? echo str_replace("|x|", " - ", $saunadb['allowed']); ?></td>
                      </tr>
                    </table>
                    
                    </div>
                <div id="clear"></div>
                
                <? $msgdb = $db->select("sauna_massage", "flat like '".$flat['flat_id']."' group by massage");?>
                <? $prcdb = $db->select("sauna_price", "flat_id like '".$flat['flat_id']."'");?>
                
                <div class="insDesc">
                 <p class="insTitle">Массаж</p>
                    <table width="100%" border="0">
                    <? foreach ($msgdb as $msg) {?>
                      <tr>
                        <td width="200px"><? echo $msg['massage']; ?></td>
                        <td width="20px">&nbsp;</td>
                        <td width="100px"><? echo $msg['vremya']; ?> мин</td>
                        <td width="20px">&nbsp;</td>
                        <td ><? echo $msg['price']; ?> сом</td>
                      </tr>
                     <? } ?>
                    </table>
                    
                    </div>
                <div id="clear"></div>
                
                <div class="insDesc">
                 <p class="insTitle">Другие</p>
                    <table width="100%" border="0">
                    <? foreach ($prcdb as $prc) {?>
                      <tr>
                        <td width="200px"><? echo $prc['name']; ?></td>
                        <td width="20px">&nbsp;</td>
                        <td >
						<? if ($prc['price']=="0") {?>
                        <span style="color:#093; font-weight:bold">Бесплатно</span>
                        <? } else { ?>
						<? echo $prc['price']; ?> сом
                        <? } ?>
                        </td>
                      </tr>
                     <? } ?>
                    </table>
                    
                    </div>
                <div id="clear"></div>
                  
                         
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
                  <img src="/images/inventoryicons/<?=$flatinventory['img'];?>"/><p class="itemTxt"><?=$flatinventory['inventory'];?></p> 
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

<? 
	
	foreach($rwRooms as $rwroom) {
?>
	<div style="height:30px">
	<div style="float:left; width:400px;"><a href="detailroom.php?id=<?=$flat['flat_id'];?>&room=<?=$rwroom['room_id'];?>"><?=$rwroom['name_ru'];?></a></div>
    <div style="float:left;">
    <? showdiscountprice($rwroom['price_night'], $rwroom['currency'], $usdtokgs, $rwroom['discount'], $flat['discountdate_from'], $rwroom['discount_date']); ?> <? if ($_SESSION['currency']==1) echo "$"; else echo "сом"; ?></div>
    <div id="clear"></div>
    </div>
<? } ?>
<? } ?>