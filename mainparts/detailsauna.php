                	<div class="insTable">
  <table border="0" width="100%">
                    <tr>
                      <td width="55%" valign="top">
                      <div class="general-info">
                      <p>Общая информация</p><div id="clear"></div>
<div class="detailheader">Город:</div> <div class="detailvalue"><?=$CurrentCity['name'];?></div>
<div id="clear"></div>
<? if ($CurrentDistrict) {?>
<div class="detailheader">Район(-ы):</div> <div class="detailvalue"><?=$CurrentDistrict['region_title'];?></div>
<div id="clear"></div>
<? } ?>
<? 
$shortaddress =  true; include '../mainparts/address.php';
if ($fulladdress != $CurrentDistrict['region_title']) {?>
<div class="detailheader">Адрес:</div> 
<div class="detailvalue"><? echo $fulladdress; ?> </div>
<div id="clear"></div>
<? } ?>
<? if ($flat['crosses']!="") {?>
<div class="detailheader">Пересекается:</div> 
<div class="detailvalue"><?=$flat['crosses'];?></div>
<div id="clear"></div>
<? } ?>
<? if ($flat['landmark_ru']!="") {?>
<div class="detailheader">Ориентир:</div> 
<div class="detailvalue"><?=$flat['landmark_ru'];?></div>
<div id="clear"></div>
<? } ?>
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
<? if ($flat['msquare']!="" && $flat['msquare']>0) {?>
<div class="detailheader">Площадь:</div> 
<div class="detailvalue"><?=$flat['msquare'];?></div>
<div id="clear"></div>
<? } ?>
<? if ($flat_type==1 && ($flat['floor']>0 || $flat['total_floors']>0)) {?>
<div class="detailheader">Этаж:</div> 
<div class="detailvalue"><? if ($flat['floor']>0) echo $flat['floor']; else echo '1'; ?><? if ($flat['total_floors']>0) echo " / ".$flat['total_floors'];?></div>
<div id="clear"></div>
<? } ?>
                      </div>
                      </td>
                      <td width="45%" valign="top">
                      <?
$puresql = "SELECT infrastructure.infrastructure FROM infrastructure inner JOIN flat_infrastructure ON infrastructure.infrastructure_id = flat_infrastructure.infrastructure_id where flat_infrastructure.flat_id='".$flat['flat_id']."'";
$rwFlatInfrastructures = $db->selectpuresql($puresql);
$countrwInfras = count($rwFlatInfrastructures);
if ($countrwInfras){
						?>
                      Рядом находится<br />
                      <? 
					  $i=0;
					  foreach($rwFlatInfrastructures as $rwFlatInfrastructure) {?>
                     <div class="detailinfrastructure">
					 <? echo $rwFlatInfrastructure['infrastructure'];
					 $i++;
					 if ($i==9) break;
					 ?></div>
                     <? }}?> <? if ($countrwInfras>9) {?>
                     
                     <a id="thelink" href="#" style="color:#00F; text-decoration:underline">Еще <?=($countrwInfras-9);?></a>
                     <? }?>
                     <div id="thedialog" title="Рядом находится ">
                     	<? 
					  foreach($rwFlatInfrastructures as $rwFlatInfrastructure) {?>
                     <div class="detailinfrastructure">
					 <? echo $rwFlatInfrastructure['infrastructure'];?>
                     </div>
                     <? }?>             
                     </div>
                      
                      </td>
    </tr>
                    </table>
</div>
  	
                    <div class="insDesc">
                    <p class="insTitle">Описание<p>
                  <p><?=nl2br($flat['description_ru']);?>
</div> 
                  <div id="clear"></div>
                  
                  <div class="insDesc">
                    <p class="insTitle">Вместимость</p>
                    <table width="100%" border="0">
                      <tr>
                        <td width="200px">Комнат отдыха:</td>
                        <td width="20px">&nbsp;</td>
                        <td ><? echo $flat['room']; ?></td>
                      </tr>
                      <tr>
                        <td width="200px">Вместимость:</td>
                        <td width="20px">&nbsp;</td>
                        <td ><? echo $saunadb['capacity']; ?></td>
                      </tr>
                    </table>
                    
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


<?
$puresql = "SELECT inventory.img, inventory.inventory FROM inventory inner JOIN flat_inventory ON inventory.inventory_id = flat_inventory.inventory_id where flat_inventory.flat_id='".$flat['flat_id']."'";
$rwFlatInventorys = $db->selectpuresql($puresql);
if (count($rwFlatInventorys)){
?>
<? if ($flat_type<3 || $flat['sauna_type']==1) {?>
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
<? }} ?>	
<? if ($flat_type>2 && $flat['sauna_type']==0) {?>
<hr>	
<p class="insTitle">Категории номеров</p>	

<? 
	$rwRooms = $db->select("rooms","flat_id='".$flat['flat_id']."'");
	foreach($rwRooms as $room) include 'singleroom.php';
	$room = null;
?>
<div id="clear"></div>
<? } ?>	
				<? if (strlen($flat['flashtour'])>4) {?>
                  <div class="tour">
                		<p class="insTitle">Виртуальный тур</p>
                        <div class="virtualTour">
                            <object  data="http://www.sutki.kg/flashtour/<?=$flat['flashtour'];?>" width="720" height="477"></object>
                    	</div>
                   </div>    
                   
                   <div id="clear"></div>
                 <? } ?>
                  <div class="map">
                     <p class="insTitle"><?=$arrType[$flat['flat_type']];?> на карте города: <? include '../mainparts/address.php';?></p>
                     <div id="map_canvas" style="width:741px; height:500px;"></div>
                  <div id="clear"></div>
                  </div>
                 <div id="clear"></div>
	<hr />
                <? include 'detailphotos.php';?>	
				<? include 'detailorientir.php';?>	
				<? include 'comment.php';?>	
                <? //include 'otherflats.php';?>	
                  
                  
                   
<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkDCwNRQqDIE_kz7uBfmNl1iOBsCT2nt8&sensor=true">
    </script>
    <script type="text/javascript">
	  function initialize() {
        var mapOptions = {
          zoom: <?php echo $flat['zoom']; ?>,
          center: new google.maps.LatLng(<?php echo $flat['latitude']; ?>,<?php echo $flat['longitude']; ?>),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);
		geocoder = new google.maps.Geocoder();

        var image = 'images/beachflag.png';
        var myLatLng = new google.maps.LatLng(<?php echo $flat['latitude']; ?>,<?php echo $flat['longitude']; ?>);
        
		
		var marker = new google.maps.Marker({
			position: myLatLng, 
			map: map, 
			title: "<?php echo $flat['street']; ?> <?php echo $flat['apartment']; ?>"
		});  
      }
	  
    </script>