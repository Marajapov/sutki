<?php
include_once 'admincontrol.php';
	$flat_id = $_GET['id'];
	$rwFlat = $db->select_one("flats", "flat_id='" . $flat_id . "'", "*", "", "");
	$announcement_type = $rwFlat['announcement_type'];
	$flat_type = $rwFlat['flat_type'];
	$flat_user = $rwFlat['user_id'];
	$currency = $rwFlat['currency'];
    $price = $rwFlat['price'];
    $price_msquare = $rwFlat['price_msquare'];
	$discount = $rwFlat['discount'];
	$skidka = $rwFlat['skidka'];
	$district = $rwFlat['district'];
	$subregion_id = $rwFlat['subregion'];
	$subregion_text = $rwFlat['subregion_text'];
	$street = $rwFlat['street'];
	$apartment = $rwFlat['apartment'];
	$homenumber = $rwFlat['homenumber'];
	$landmark_ru = $rwFlat['landmark_ru'];
	$latitude = $rwFlat['latitude'];
	$longitude = $rwFlat['longitude'];
	$zoom = $rwFlat['zoom'];
    $phone = $rwFlat['phone'];
	$email = $rwFlat['email'];
	$name_owner = $rwFlat['name_owner'];
	$commercialType = $rwFlat['commercialType'];
	$officeFlag = $rwFlat['officeFlag'];
    $description_ru = $rwFlat['description_ru'];
	$room = $rwFlat['room'];
	$house_type = $rwFlat['house_type'];
	$construct_serial = $rwFlat['construct_serial'];
	$floor = $rwFlat['floor'];
	$total_floors = $rwFlat['total_floors'];
	$msquare = $rwFlat['msquare'];
	$area = $rwFlat['area'];
	$sellerfee = $rwFlat['sellerfee'];
	$main_img = $rwFlat['main_img'];
	$flashtour = $rwFlat['flashtour'];
	$infrastructuredb = $db->select("flat_infrastructure", "flat_id='".$flat_id."'", "*", "","");
	$inventorydb = $db->select("flat_inventory", "flat_id='".$flat_id."'", "*", "","");
	$title = $arrType[$flat_type]." -ID:".$flat_id;
$action = "edit";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title;?></title>
<link href="../control/styles/user.css" rel="stylesheet" type="text/css" />
<link href="../control/styles/style.css" rel="stylesheet" type="text/css" />
<link href="../control/styles/login.css" rel="stylesheet" type="text/css" />
<link href="../control/styles/table.css" rel="stylesheet" type="text/css" />
  		<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkDCwNRQqDIE_kz7uBfmNl1iOBsCT2nt8&sensor=true">
    </script>
    <script type="text/javascript">
	  function initialize() {
        var mapOptions = {
          zoom: <?php echo $rwFlat['zoom']; ?>,
          center: new google.maps.LatLng(<?php echo $rwFlat['latitude']; ?>,<?php echo $rwFlat['longitude']; ?>),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);

        var image = 'images/beachflag.png';
        var myLatLng = new google.maps.LatLng(<?php echo $rwFlat['latitude']; ?>,<?php echo $rwFlat['longitude']; ?>);
        
		
		var marker = new google.maps.Marker({
			position: myLatLng, 
			map: map, 
			title: "Your location."
		});  
      }
    </script>
</head>
<body onload="initialize()">

<div class="main_border">   

			<h2 class="maintitle"><?=$title;?></h2>
            <div class="clear"></div>
					
                    <p class="textRed">Риэлтор</p>
                    
                    <? 
					
					if ($flat_user>0) $user = $db->select_one(DB_PREFIX . "users", "user_id=" . $flat_user); 
					if ($user["user_id"]== $flat_user) {
					?>
                    
                    <div class="well">
                        <p class="star">Имя: </p>                   
                        <?=$user["user_realname"];?> 
                        
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Номер телефона: </p>       
                        <?=$user["user_phone"];?>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">E-Mail: </p>                        
                        <?=$user["user_mail"];?>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <?  } else { ?>
                    <form action="changeuser.php" method="post" name="changeform" id="changeform">
                     <input type="hidden" name="id" value="<?=$flat_id;?>" />
                   	  <div class="well">
                        <p class="star">Риэлтор: </p>                        
                        <select name="user" id="user">
                        	<?
							$rwUser = $db->select("users", "user_type='2'", "*", "");
                       		foreach ($rwUser as $rww) {
							?>
                          <option value="<?=$rww["user_id"];?>"><?=$rww["user_realname"];?> (<?=$rww["user_name"];?>)</option>
                            <? } ?>
                        </select>
                       
                        <input type="submit" name="button" id="button" value="Делегировать" />
                      </div><!--.well-->
					<div class="clear"></div>
                    </form>
                    <? } ?>
                    <p class="textRed">Владелец</p>
                    <div class="well">
                        <p class="star" style="color:red">
                        <? if ($announcement_type==1) {?>На продажу<? } ?>
                        <? if ($announcement_type==2) {?>В аренду<? } ?>                  
                        </p>
                    </div><!--.well-->
					<div class="clear"></div>
                    <div class="well">
                        <p class="star">Имя владельца: </p>                   
                        <?=$name_owner;?> 
                        
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Номер телефона: </p>       
                        <?=$phone;?>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">E-Mail: </p>                        
                        <?=$email;?>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    
                    
                    <h2 class="textRed">Расценки</h2>

                    <? if ($flat_type<6) {?>
                    <div class="well">
                        <div class="priceforing">Цена</div>                        
                      <?=$price;?> <? if ($currency==1) echo "Доллар (USD)"; else echo "Сом (KGS)"; ?>
                      
                    </div><!--.well--> 
                    <div class="clear"></div> 
                    <? } else { ?>
                    <div class="well">
                        <div class="priceforing">Цена (m2):</div>
                        <?=$price_msquare;?> <? if ($currency==1) echo "Доллар (USD)"; else echo "Сом (KGS)"; ?>
                    </div><!--.well--> 
                    <div class="clear"></div>
                    <? } ?>
                    <div class="well">
                        <div class="priceforing">Торг:</div>                        
                        <?=$discount;?>
                    </div><!--.well--> 
                    <div class="clear"></div>
                    
                    <div class="well">
                        <div class="priceforing">Скидка</div>                        
                      <?=$skidka;?>
                      
                    </div><!--.well--> 
                    <div class="clear"></div>
                    
                    <p class="textRed">Местонахождение</p>
                                        
                    <div class="well">
                        <p class="star">Район: </p>
                    
                     <?php
					 	if ($district>0){
							$rwRegions = $db->select_one("regions", "region_id=".$district, "*", "");
							echo $rwRegions["region_title"];
						}
						else{
							echo $subregion_text;
						}
					?> 
                    
                    </div><!--.well-->
                    <div class="clear"></div>
                   
                    
                    <div class="well">
                        <p class="star">Название улицы: </p>
                      <?=$street;?> (Пересекается: <?=$rwFlat['crosses'];?>)
                    </div><!--.well-->
                    <div class="clear"></div>
                    <div class="well">
                        <p class="star">Номер дома: </p>
                        <?=$apartment;?>
                    </div><!--.well-->
                    <div class="clear"></div>
                    <div class="well">
                        <p class="star">Номер квартиры: </p>
                        <?=$homenumber;?>
                    </div><!--.well-->
                    <div class="clear"></div>
                    <div class="well">
                        <p class="star">Ориентир: </p>
                        <?=$landmark_ru;?>
                    </div><!--.well-->
                    <div class="clear"></div>
                    
                    <div class="well" style="margin-top:10px">

                      	  
                          <div id="map_canvas" style="width:750px; height:560px; border:solid 1px #FF0000" ></div>
                          
                            
                    </div><!--.well--> 
                    <div class="clear"></div>

					<p class="textRed">Информация об объекте</p>
                    <? if ($flat_type == 3) { ?>
                    <div class="well">
                        <div class="priceforing">Дом/Дача</div>
                        <? if ($house_type==1) echo "Дом"; if ($house_type==2) echo "Дача"; ?>                       
                    </div><!--.well-->
                    <div class="clear"></div>
                    <? } ?>
                    <? if ($flat_type != 4) { ?>
                    <div class="well">
                        <div class="priceforing">Количество комнат</div>
                       <?=$room;?>                         
                    </div><!--.well-->
                    <div class="clear"></div>
                    <? } ?>
                    
                    <? if ($flat_type == 1) { ?>
                    <div class="well">
                        <div class="priceforing">Квартира под офис?</div>
                             <? if ($officeFlag==1) echo "Да"; else "Нет";?>                   </div><!--.well-->
                    <div class="clear"></div>
                    <? } ?>
                    <? if ($flat_type==1) { ?>
                    <div class="well">
                        <div class="priceforing">Тип строения</div> 

                        <?php echo $construct_serial; ?>        
                         
                    </div><!--.well-->
                    <div class="clear"></div>
                    <? } ?>
                   
                    <? if ($flat_type==1 || $flat_type==5) { ?>
                   <div class="well">
                        <p class="star">Этаж: </p>
                     <?=$floor;?>               
                  </div><!--.well-->
					<div class="clear"></div>
                    <? } ?>
                    <? if ($flat_type!=4) { ?>
                    
                    <div class="well">
                        <p class="star">Этажность: </p>
                      <?=$total_floors;?>                       
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    
                    <div class="well">
                        <p class="star">Площадь, кв.м.: </p>
                      <?=$msquare;?>                    
                    </div><!--.well-->
					<div class="clear"></div>
                    <? } ?>
                    <? if ($flat_type==2 || $flat_type==3 || $flat_type==4) { ?>
                    <div class="well">
                        <p class="star">Участок, (сот.): </p>
                     <?=$area;?>                   
                    </div><!--.well-->
					<div class="clear"></div>
                    <? } ?>
                    
                    <? if ($flat_type == 5) { ?>
                    <div class="well">
                        <div class="priceforing">Тип объекта: </div>
                            <?=$commercialType;?>                  
                        </div><!--.well-->
                    <div class="clear"></div>
                    <? } ?>
                    <div class="well">
                        <p class="star">Описание объекта: </p>
                       <?=nl2br($description_ru);?>                       
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <p class="textRed">Инфраструктура:<font color="#FF0000">*</font>(обязательно)</p>
                    <div class="well">                        
                       <?php
                        $rwInf = $db->select("infrastructure", "", "*", "");
                        foreach ($rwInf as $inf) { ?>
                            <div style="width:350px;float:left">
                            <input type="checkbox" value="<?=$inf["infrastructure_id"];?>" <?
							if ($action=="new"){ 
								for ($i=0; $i<count($infrastructure); $i++) if ($infrastructure[$i]==$inf["infrastructure_id"]){
									echo 'checked="checked"'; break;
								}
							}
							else {
								foreach ($infrastructuredb as $infra) if ($infra["infrastructure_id"]==$inf["infrastructure_id"]){
									echo 'checked="checked"'; break;
								}
							}
							?> name="infrastructure[]"/> <?=$inf["infrastructure"];?>&nbsp;&nbsp;
                            </div>
                        <? } ?>
                    </div><!--.well-->
                    <div class="clear"></div>
                    <? if ($flat_type!=4) { ?>
                    <p class="textRed">Инвентарь:
                    <div class="well">                        
                       <?php
                        $rwInv = $db->select("inventory", "", "*", "");
                        foreach ($rwInv as $inv) { ?>
                            <div style="width:350px;float:left">
                            <input type="checkbox" value="<?=$inv["inventory_id"];?>" <?
							if ($action=="new"){ 
								for ($i=0; $i<count($inventory); $i++) if ($inventory[$i]==$inv["inventory_id"]){
									echo 'checked="checked"'; break;
								}
							}
							else {
								foreach ($inventorydb as $inven) if ($inven["inventory_id"]==$inv["inventory_id"]){
									echo 'checked="checked"'; break;
								}
							}
							?> name="inventory[]"/> <?=$inv["inventory"];?>&nbsp;&nbsp;
                            </div>
                        <? } ?>
                    </div><!--.well-->
                    <div class="clear"></div>
                    <? } ?>

                    <p class="textRed">Главное Фото</p>

                    <div class="well"><img src="../images/thu/<?=$main_img;?>" /></div><div class="clear"></div>

                    <div class="well">
                    
                    </div><!--.well--> 
                    <div class="clear"></div>
                    
                    <p class="textRed">Онлайн 3D Тур</p>
                    <? if ($action=="edit") {
						if ($flashtour=="") {?>
                        <div class="well">Отсутствует онлайн тура</div><div class="clear"></div>
						<? }else {?>
                    <div class="well"><embed src="../flashtour/<?=$flashtour;?>" width="100px" height="100px" /><br/></div><div class="clear"></div>
                    <?  }}?>
                    <div class="well">
               

                    </div><!--.well--> 
                    <div class="clear"></div>
                    
                    
                    
                    	<? 
							$albresults = $db->select("albums", "flat_id=".$flat_id, "*", " ORDER BY flat_id DESC","");
								foreach ($albresults as $alb) {	?>
                                    <p class="textRed" style="background:#090"><? echo $alb["name_ru"];?></p>
                                    <div class='photowrapper'>  
							<? $rwPhoto = $db->select("photos", "album_id='" . $alb["album_id"] . "'", "*", "", "");
								foreach ($rwPhoto as $photo) {	?>
                                    <img src='../images/thu/<?php echo $photo['image_url']; ?>' />  
                                    
								<? } ?>
                                </div>
                                <div class="clear"></div>
                                <div class="well">
                                        <p class="albumname"><?=nl2br($alb["description_ru"]);?></p> 

                                    </div><!--.well-->
                                    <div class="clear"></div>
							<? } ?>
                    

</div><!--end main_border-->

</div><!--#dvFullSite-->  

</body>
</html>