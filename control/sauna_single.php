﻿<?php
include_once 'usercontrol.php';
$title = "САУНА";
$active = "7";

$userid = $_SESSION['userid'];

$flat_id = 0;
$flat_type = 4;

$error = "";

if (isset($_REQUEST['action'])) $action = $_REQUEST['action'];
else if (isset($_GET['flat_id'])) $action = 'edit'; else $action = 'new'; 

$flat_id = $_REQUEST['flat_id'];

$latitude = "42.87568142335946";
$longitude = "74.61169433337409";
$zoom = "9";

$rwMas = $db->select("massagedb");
$listPrice = array("0"=>"Веники", "1"=>"Мыло", "2"=>"Шампунь", "3"=>"Мочалка", "4"=>"Шапки для парилки", "5"=>"Губка для скраба", "6"=>"Бритва одноразовая", "7"=>"Простынья","8"=>"Полотенца", "9"=>"Кальян");

if (isset($_POST['name_ru'])) {
	$objectlog = getpost('objectlog');
	$city = (int)getpost('city');
	$district = (int)getpost('district');
	$street = getpost('street');
	$crosses = getpost('crosses');
	$apartment = (int)getpost('apartment');
	$homenumber = (int)getpost('homenumber');
	$landmark_ru = getpost('landmark_ru');
	$landmark_eng = getpost('landmark_eng');
	$latitude = getpost('latitude');
	$longitude = getpost('longitude');
	$zoom = getpost('zoom');
	
    $phone = getpost('phone');
	$phone2 = getpost('phone2');
	$phone3 = getpost('phone3');
	$email = getpost('email');
	$skype = getpost('skype');
	$icq = getpost('icq');
	
	$name_ru = getpost('name_ru');
	$name_eng = getpost('name_eng');
	$name_native = getpost('name_native');
    $description_ru = getpost('description_ru');
	$description_eng = getpost('description_eng');
	$description_native = getpost('description_native');
	
	$room = (int)getpost('room');
	$price = (int)getpost('price');
	$skidka = (int)getpost('skidka');
	
	$capacity = getpost('capacity');
	$skidkafrom = getpost('skidkafrom');
	$skidkato = getpost('skidkato');
	$servicefee = getpost('servicefee');
	$dancefloor = getpost('dancefloor');
	
	$inventory = $_POST['inventory'];
	
	$steam = $_POST['steam'];
	$steampower = $_POST['steampower'];
	$pool = $_POST['pool'];
	$cuisine = $_POST['cuisine'];
	$shashlyk = $_POST['shashlyk'];
	$allowed = $_POST['allowed'];

	$steamvalue = "";	foreach($steam as $item) {$steamvalue .= "|x|".$item;} 
	$steampowervalue = "";	foreach($steampower as $item) {$steampowervalue .= "|x|".$item;} 
	$poolvalue = "";	foreach($pool as $item) {$poolvalue .= "|x|".$item;} 
	$cuisinevalue = "";	foreach($cuisine as $item) {$cuisinevalue .= "|x|".$item;} 
	$shashlykvalue = "";	foreach($shashlyk as $item) {$shashlykvalue .= "|x|".$item;} 
	$allowedvalue = "";	foreach($allowed as $item) {$allowedvalue .= "|x|".$item;} 
    $image_url = $_FILES['image_url'];
    $update_date = date("Y-m-d H:m:s");
	$mainimg = "";
	
	$price_universal = ($currency==1)?$price_night*50:$price_night;
	
	$subdomainFlag = false;
	include 'checkSubdomain.php';
	if ($subdomainFlag) $error.="<b>Сайт с таким именем уже существует!</b><br>";
	
    if (($phone == "") || ($phone == "+996") || (strlen($phone)<6))
        $error.="<b>Номер телефона не введен!</b><br>";
    if ($name_ru == "")
        $error.="<b>Название не введен!</b><br>";
		
    if ($error == "") {
		include 'addnewdistrict.php';
		if ($action == "new")	include 'uploadmainphoto.php';	
		
			$inputvars = array(
				"objectlog" => $objectlog,
				"update_date" => $update_date,
				"flat_type" => $flat_type,
				"city" => $city,
				"district" => $district,
				"street" => $street,
				"crosses" => $crosses,
				"apartment" => $apartment,
				"homenumber" => $homenumber,
				"landmark_ru" => $landmark_ru,
				"landmark_eng" => $landmark_eng,
				"latitude" => $latitude,
				"longitude" => $longitude,
				"zoom" => $zoom,
				"phone" => $phone,
				"phone2" => $phone2,
				"phone3" => $phone3,
				"email" => $email,
				"skype" => $skype,
				"icq" => $icq,
				"name_ru" => $name_ru,
				"name_eng" => $name_eng,
				"name_native" => $name_native,
				"description_ru" => $description_ru,
				"description_eng" => $description_eng,
				"description_native" => $description_native,
				"room" => $room,
				"price" => $price,
				"discount" => $skidka
        	);
		
		if ($error == "") {
			if ($action == "new") {
				$inputvars["user_id"] = $userid;
				$inputvars["sauna_type"] = 1;
				$inputvars["main_img"] = $pic1;	
				if (!$db->insert("flats", $inputvars)) $error ="Ошибка!";
				else {
					$flat = $db->select_one("flats", "update_date='" . $update_date . "' AND user_id='" . $userid . "'", "*", " ORDER BY flat_id DESC", "0,1");
					$flat_id = $flat["flat_id"];
					}
				}
			}
			if ($action == "edit") {
				if (!$db->update("flats", $inputvars, "flat_id = " . $flat_id)) $error ="Ошибка!";
			}
    	}
		
		if ($error == "") {
			$db->delete(DB_PREFIX . "flat_inventory", "flat_id = " . $flat_id);
			$db->delete(DB_PREFIX . "saunadetails", "flat_id = " . $flat_id);
			$db->delete(DB_PREFIX . "sauna_massage", "flat = " . $flat_id);
			$db->delete(DB_PREFIX . "sauna_price", "flat_id = " . $flat_id);
			
			$insertsaunadetails = array(
						"flat_id" => $flat_id,
						"room_id" => 0,
						"capacity" => $capacity,
						"skidkafrom" => $skidkafrom,
						"skidkato" => $skidkato,
						"servicefee" => $servicefee,
						"dancefloor" => $dancefloor,
						"steam" => $steamvalue,
						"steampower" => $steampowervalue,
						"pool" => $poolvalue,
						"cuisine" => $cuisinevalue,
						"shashlyk" => $shashlykvalue,
						"allowed" => $allowedvalue
			);
			
			$db->insert("saunadetails", $insertsaunadetails);
			
			
            foreach ($rwMas as $msg) {
				$massagetime = "massagetime".$msg['id'];
				$massageprice = "massageprice".$msg['id'];
				
				if (isset($_POST[$massagetime]) && isset($_POST[$massageprice]) && strlen($_POST[$massagetime])>0  && strlen($_POST[$massageprice])>0 ) {
				$insertsaunamassage = array(
						"massage" => $msg['name'],
						"flat" => $flat_id,
						"vremya" => $_POST[$massagetime],
						"price" => getpost($massageprice)
						);
			
				$db->insert("sauna_massage", $insertsaunamassage);
				}
			}
			
			foreach ($listPrice as $key => $value) {
				$saunaitemprice = "saunaitemprice".$key;
				
				if (isset($_POST[$saunaitemprice]) && strlen($_POST[$saunaitemprice])>0 ) {
				$insertsaunaprice = array(
						"name" => $value,
						"flat_id" => $flat_id,
						"price" => getpost($saunaitemprice)
						);
				$db->insert("sauna_price", $insertsaunaprice);
				}
			}
			
			for($i=0; $i<count($inventory); $i++){
				$insert = array(
								"flat_id" => $flat_id,
								"inventory_id" => $inventory[$i]
				 );
				$db->insert(DB_PREFIX . "flat_inventory", $insert);	
			} 
			include 'uploadmassphoto.php';			
			redirect("index.php?action=saunaadded", "js");
		}
}

if ($flat_id>0) {
	require 'flatcontrol.php';
	require 'makesaunavariables.php';
}

include_once 'header.php';
?>
<div class="main_border">   

			<h2 class="maintitle"><?=$title;?></h2>
            <div class="clear"></div>
            <?php if ($error) {?>
            
            <div class="error">Обнаружены ошибки</div><div class="clear"></div>
               <div class="panelError">     
                    <div class="well">
						<?=$error;?>                    
                  </div>
                </div>
            <div class="clear"></div>
            <? } ?>  
            
            <div style="margin-left:30px;margin-top:10px;margin-bottom:10px">
            <ul>
                <li>- Поля, помеченные звездочкой (<font color="#FF0000">*</font>), обязательны для заполнения.</li>
                <li>- Объязательно пишите точную контактную информацию.</li>
                <li>- Размещение на нашем сайте <font color="#FF0000">бесплатное</font></li>
                <li>- Сауна будет опубликована только после проверки модератором!</li>
            </ul>
            </div>
            <div class="clear"></div>

                <form action="sauna_single.php" method="post" enctype="multipart/form-data" name="addnew" id="addnew">
                <input type="hidden" name="action" value="<?=$action;?>" />
                <input type="hidden" name="flat_id" value="<?=$flat_id;?>" />
                    <p class="textRed" style="background:#F00"> Внимание! </p>
                    <div class="well">
                        <p style="color:#F00">Если у вас несколько саун в одном месте, <a href="sauna_add.php" style="color:#03F; text-decoration:underline">вам сюда...</a></p>
                    </div>
                    <div class="clear"></div>
                    <h2 class="textRed">Вместимость</h2>                    
                    <div class="well">
                        <div class="priceforing">Вместимость:</div>                        
                        
                      <select id="capacity" name="capacity" class="priceformedium">
                      	<option value="1-5 чел" <? if ($capacity=="1-5 чел") echo "selected";?>>1-5 чел</option>
                        <option value="5-10 чел" <? if ($capacity=="5-10 чел") echo "selected";?>>5-10 чел</option>
                        <option value="10-15 чел" <? if ($capacity=="10-15 чел") echo "selected";?>>10-15 чел</option>
                        <option value="15-20 чел" <? if ($capacity=="15-20 чел") echo "selected";?>>15-20 чел</option>
                        <option value="20-25 чел" <? if ($capacity=="20-25 чел") echo "selected";?>>20-25 чел</option>
                      </select>                        
                    </div><!--.well--> 
                    <div class="clear"></div> 
                    <div class="well">
                        <div class="priceforing">Сколько комнат отдыха:</div>                        
                        
                      <select id="room" name="room" class="priceformedium">
                      	<? for ($i=1; $i<9; $i++) {?>
                        <option value="<?=$i;?>" <? if ($room==$i) echo "selected";?>><?=$i;?></option>
                        <? } ?>
                      </select>                        
                    </div><!--.well--> 
                    <div class="clear"></div> 
                    <h2 class="textRed">Расценки</h2>                    
                    <div class="well">
                        <div class="priceforing">Цена за час:</div>                        
                    <input type="text" class="pricefor" name="price" value="<?=$price;?>"/>
                    <span style="float:left;margin-top:5px;">&nbsp;сом</span>            
                    </div><!--.well--> 
                    <div class="clear"></div> 
                    <div class="well">
                        <div class="priceforing">Скидка:</div>                        
                    <span style="float:left;margin-top:5px;">с &nbsp;</span> 
                    <select type="select" name="skidkafrom" class="pricefor">
                    <? for ($i=0; $i<48; $i++){ 
						$skidkafromvalue = (!($i%2)) ? ((int)($i/2)).":00":((int)($i/2)).":30";
					?>
                    	<option value="<?=$skidkafromvalue;?>" <? if ($skidkafrom==$skidkafromvalue) echo "selected";?>><?=$skidkafromvalue;?></option>
                    <? } ?>
                    </select>	 
                    
                    <span style="float:left;margin-top:5px;"> &nbsp;&nbsp;&nbsp;до &nbsp;</span>
                    <select type="select" name="skidkato" class="pricefor">
                    <? for ($i=0; $i<48; $i++){ 
						$skidkatovalue = (!($i%2)) ? ((int)($i/2)).":00":((int)($i/2)).":30";
					?>
                    	<option value="<?=$skidkatovalue;?>" <? if ($skidkato==$skidkatovalue) echo "selected";?>><?=$skidkatovalue;?></option>
                    <? } ?>
                    </select>
                    
                    <input type="text" class="pricefor" name="skidka" value="<?=$skidka;?>"/>  <span style="float:left;margin-top:5px;">&nbsp;сом</span>      
                    </div><!--.well-->
                    <div class="clear"></div> 
                    <div class="well">
                        <div class="priceforing">Процент за обслуживание:</div>                        
                    <input type="text" class="pricefor" name="servicefee" value="<?=$servicefee;?>"/>
                    <span style="float:left; margin-top:5px;">%</span>            
                    </div><!--.well--> 
                    <div class="clear"></div> 
                     
                    
                    <p class="textRed">Местонахождение</p>
                    <div class="well">
                        <p class="priceforing">Город: </p>
                        <select id="city" name="city" class="priceformedium" onchange="updateDistrict(this.form,this.value)">                        
                       <?php
                        $rwCity = $db->select("city", "", "*", "");
                        foreach ($rwCity as $arrcity) {
                            echo '<option value="' . $arrcity["city_id"] . '" ';
                            if ($arrcity['city_id'] == $city) echo 'selected';
                            echo ' >' . $arrcity['name'] . '</option>';
                        }
                        ?> 
                        </select>
                    </div><!--.well-->
                    <div class="clear"></div>
                    
                  <? $actiontype = 'insert'; include 'rowsubdistrict.php';?>
                    
                    
                    <div class="well">
                        <p class="star">Название улицы: </p>
                      <input type="text" id="street" name="street" class="priceforlong" value="<?=$street;?>"/>
                    </div><!--.well-->
                    <div class="clear"></div>
                    <div class="well">
                        <p class="star">Пересекается: </p>
                      <input type="text" id="crosses" name="crosses" class="priceforlong" value="<?=$crosses;?>"/>
                    </div><!--.well-->
                    <div class="clear"></div>
                    <div class="well">
                        <p class="star">Номер дома: </p>
                        <input type="text" name="apartment" class="pricefor" value="<?=$apartment;?>"/>
                    </div><!--.well-->
                    <div class="clear"></div><!--.well-->
                 
                    
                    <div class="well">
                        <p class="star">Ориентир (рус): </p>
                        <input type="text" name="landmark_ru" class="priceforlong" value="<?=$landmark_ru;?>"/>
                    </div>
                    <div class="clear"></div>
                    <div class="well">
                        <p class="star">Ориентир (англ): </p>
                        <input type="text" name="landmark_eng" class="priceforlong" value="<?=$landmark_eng;?>"/>
                    </div>
                    <div class="clear"></div>
                    
                    
                    
                    <div class="well" style="margin-top:10px">

                      	  <p class="star"><input type="button" value="Найти вышеуказанный адрес" onclick="updatemap()" class="findonmapbutton"  /> </p> <br/><div class="red">Вы должны указать флажок где находиться ваш объект:</div>
                          <div id="map_canvas" style="width:750px; height:560px; border:solid 1px #FF0000" ></div>
                          
                          
                    <input name="latitude" id="latitude" type="hidden"  value="<?=$latitude;?>"> 
                    <input name="longitude" id="longitude" type="hidden"  value="<?=$longitude;?>">    
                    <input name="zoom" id="zoom" type="hidden"  value="<?=$zoom;?>">    
                    </div><!--.well--> 
                    <div class="clear"></div>

                    <p class="textRed">Контактная информация</p>

                    <div class="well">
                        <p class="star">Номер телефона: </p>       
                        <? if ($phone=="") $phone = "+996";?>              
                        <input type="text" class="priceformedium" name="phone"  value="<?=$phone;?>"/>
                        <div class="postinput"><b><font color="#FF0000">*</font></b>(обязательно)</div>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Доп.Номер телефона: </p>       
                        <? if ($phone2=="") $phone2 = "+996";?>              
                        <input type="text" class="priceformedium" name="phone2"  value="<?=$phone2;?>"/>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Доп.Номер телефона: </p>       
                        <? if ($phone3=="") $phone3 = "+996";?>              
                        <input type="text" class="priceformedium" name="phone3"  value="<?=$phone3;?>"/>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">E-Mail: </p>                        
                        <input type="text" class="priceformedium" name="email"  value="<?=$email;?>"/>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Skype: </p>                    
                        <input type="text" class="priceformedium" name="skype"  value="<?=$skype;?>"/>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    
                    <div class="well">
                        <p class="star">Факс: </p>                       
                        <input type="text" class="priceformedium" name="icq"  value="<?=$icq;?>"/>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <p class="textRed">Информация о сауне на русском языке</p>
                    
                    <div class="well">
                      <p class="star">Название: </p>                       
                        
                        <input type="text" class="priceforlong" name="name_ru"  value="<?=$name_ru;?>"/>
                        <div class="postinput"><b><font color="#FF0000">*</font></b>(обязательно)</div>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Описание сауны: </p>
                        <textarea name="description_ru" class="priceforlong" rows="9" id="description_ru"><?=$description_ru;?></textarea>                       
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <p class="textRed">Информация о сауне на английском языке (необязательно)</p>
                    
                    <div class="well">
                      <p class="star">Название: </p>                       
                        
                        <input type="text" class="priceforlong" name="name_eng"  value="<?=$name_eng;?>"/>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Описание сауны: </p>
                        <textarea name="description_eng" class="priceforlong" rows="9" id="description_eng"><?=$description_eng;?></textarea>                       
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <p class="textRed">Информация о сауне на кыргызском языке (необязательно)</p>
                    
                    <div class="well">
                      <p class="star">Название: </p>                       
                        
                        <input type="text" class="priceforlong" name="name_native"  value="<?=$name_native;?>"/>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Описание сауны: </p>
                        <textarea name="description_native" class="priceforlong" rows="9" id="description_native"><?=$description_native;?></textarea>                       
                    </div><!--.well-->
					<div class="clear"></div>
					<p class="textRed">Инвентарь:</p>
                    <div class="well">
                                           
                       <?php
                        $rwInv = $db->select("inventory", "flat_type=0 OR flat_type=4", "*", "");
                        foreach ($rwInv as $inv) {
							$invname = $inv["inventory"];
							//if ($inv["flat_type"]==4) $invname = "<font color='#FF0000'>".$invname."</font>";
						?>
                            <div style="width:350px;float:left; margin-top:10px">
                            <input type="checkbox" value="<?=$inv["inventory_id"];?>"  <?
							if ($inventory){ 
								for ($i=0; $i<count($inventory); $i++) if ($inventory[$i]==$inv["inventory_id"]){
									echo 'checked="checked"'; break;
								}
							}
							else if ($inventorydb) {
								foreach ($inventorydb as $inven) if ($inven["inventory_id"]==$inv["inventory_id"]){
									echo 'checked="checked"'; break;
								}
							}
							?> name="inventory[]"/><?=$invname;?> &nbsp;&nbsp;
                            </div>
                        <? } ?> 
                    </div><!--.well-->
                    <div class="clear"></div>
                    
                    <p class="textRed">Танцпол</p>
                    <?
                    	$listcuisine = array("Лазерная светомузыка","Простая светомузыка");
					?>
                     <div class="well">
                        
                        <?php
                        foreach ($listcuisine as $cuisine) {
						?>
                            <div style="width:350px;float:left; margin-top:10px">
                            <input type="radio" value="<?=$cuisine;?>" name="dancefloor" <? if ($dancefloor==$cuisine) echo "checked";?> /><?=$cuisine;?> &nbsp;&nbsp;
                            </div>
                        <? } ?> 
                        <div style="width:350px;float:left; margin-top:10px">
                            <input type="radio" value="" name="dancefloor"/>Отсутствует &nbsp;&nbsp;
                            </div>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <p class="textRed">Парилка</p>
                    <?
                    	$listcuisine = array("Финская","Турецкий хамам", "Сухая","Русская","","Влажная");
					?>
                     <div class="well">
                        
                        <?php
                        foreach ($listcuisine as $cuisine) {
						?>
                            <div style="width:350px;float:left; margin-top:10px">
                            <? if ($cuisine!="") {?>
                            <input type="checkbox" value="<?=$cuisine;?>" name="steam[]" <? if(stristr($steamvalue, $cuisine)!== false) echo "checked";?>/><?=$cuisine;?> &nbsp;
                            <? } ?>
                            &nbsp;
                            </div>
                        <? } ?> 
                        
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <p class="textRed">Отопление парилки</p>
                    <?
                    	$listcuisine = array("Дрова","Уголь","Газ","Электрическое");
					?>
                     <div class="well">
                        
                        <?php
                        foreach ($listcuisine as $cuisine) {
						?>
                            <div style="width:350px;float:left; margin-top:10px">
                            <input type="checkbox" value="<?=$cuisine;?>" name="steampower[]" <? if(stristr($steampowervalue, $cuisine)!== false) echo "checked";?>/><?=$cuisine;?> &nbsp;&nbsp;
                            </div>
                        <? } ?> 
                        
                    </div><!--.well-->
					<div class="clear"></div>

                    <p class="textRed">Бассейн</p>
                    <?
                    	$listcuisine = array("Летний (на улице)","Дубовая бочка (купель)","Теплое","Зимний (внутри)","","Холодное");
					?>
                     <div class="well">
                        
                        <?php
                        foreach ($listcuisine as $cuisine) {
						?>
                            <div style="width:350px;float:left; margin-top:10px">
                            <? if ($cuisine!="") {?>
                            <input type="checkbox" value="<?=$cuisine;?>" name="pool[]" <? if(stristr($poolvalue, $cuisine)!== false) echo "checked";?>/><?=$cuisine;?> &nbsp;
                            <? } ?>
                            </div>
                        <? } ?> 
                        
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    
                    <p class="textRed">Массаж</p>
                    
                     <div class="well">
                        <p class="star">&nbsp;</p>                   
                        <span class="priceformedium" style="width:140px; left:-20px">Сколько по времени</span>
                        <span class="priceformedium">Цена</span>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <?php
                        foreach ($rwMas as $msg) {
						$thistimevalue = "";
						$thispricevalue = "";
						foreach($massagedb as $savedmsg) if ($savedmsg['massage'] == $msg["name"]){
							$thistimevalue = $savedmsg['vremya'];
							$thispricevalue = $savedmsg['price'];
						}
					?>
                    
                    <div class="well">
                        <p class="star"><?=$msg["name"];?></p>                   
                        <input type="text" class="pricefor" style="margin-right:0" name="massagetime<?=$msg["id"];?>"  value="<?=$thistimevalue;?>"/>
                        <span style="float:left; width:30px; margin-right:10px">мин.</span>
                        <input type="text" class="pricefor" name="massageprice<?=$msg["id"];?>"  value="<?=$thispricevalue;?>"/>
                        <span style="float:left;margin-top:5px;">&nbsp;сом</span> 
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <? } ?>
                    
                    <p class="textRed">Кухня</p>
                    <?
                    	$listcuisine = array("Европейская","Национальная","Уйгурская","Дунганская","Корейская","Китайская","Домашняя","Любые блюда на заказ");
					?>
                     <div class="well">
                        
                        <?php
                        foreach ($listcuisine as $cuisine) {
						?>
                            <div style="width:350px;float:left; margin-top:10px">
                            <input type="checkbox" value="<?=$cuisine;?>" name="cuisine[]" <? if(stristr($cuisinevalue, $cuisine)!== false) echo "checked";?>/><?=$cuisine;?> &nbsp;&nbsp;
                            </div>
                        <? } ?> 
                        
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <p class="textRed">Шашлыки</p>
                    <?
                    	$listcuisine = array("Мангал","Тандыр","Барбекю");
					?>
                     <div class="well">
                        
                        <?php
                        foreach ($listcuisine as $cuisine) {
						?>
                            <div style="width:350px;float:left; margin-top:10px">
                            <input type="checkbox" value="<?=$cuisine;?>" name="shashlyk[]"  <? if(stristr($shashlykvalue, $cuisine)!== false) echo "checked";?>/><?=$cuisine;?> &nbsp;&nbsp;
                            </div>
                        <? } ?> 
                        
                    </div><!--.well-->
					<div class="clear"></div>
                  <p class="textRed">Цены</p>
                  <div class="well">
                        <p class="star">&nbsp;</p>                   
                        <span class="priceformedium">Цена</span>
                    </div><!--.well-->
					<div class="clear"></div>
                        <?php
                        foreach ($listPrice as $key=>$value) {
							$thisvalue = "";
							foreach($saunapricedb as $item) if ($item['name'] == $value){
								$thisvalue = $item['price'];
							}
						?>
                            <div class="well">
                                <p class="star"><?=$value;?></p>                   
                                <input type="text" class="pricefor" style="margin-right:0" id="saunaitemprice<?=$key;?>" name="saunaitemprice<?=$key;?>"  value="<?=$thisvalue;?>"/><span style="float:left;margin-top:5px;">&nbsp;сом</span> <span style="float:left;margin-top:5px;">&nbsp;&nbsp;&nbsp;<input type="checkbox" id="saunaitemcheck<?=$key;?>" onchange="makezero(this,<?=$key;?>)" />Бесплатно</span> 
                            </div><!--.well-->
                            <div class="clear"></div>
                            
                        <? } ?> 
				<p class="textRed">Есть - Да - Нет</p>
                    <?
                    	$listcuisine = array("По желанию допустимы свои напитки и еда","Есть разливное пиво","Есть элитные напитки (Hennessy, Jack Daniels)", "Есть безалкогольные напитки (Шоро, Чалап)","Чайная церемония");
					?>
                     <div class="well">
                        
                        <?php
                        foreach ($listcuisine as $cuisine) {
						?>
                            <div style="width:350px;float:left; margin-top:10px">
                            <input type="checkbox" value="<?=$cuisine;?>" name="allowed[]" <? if(stristr($allowedvalue, $cuisine)!== false) echo "checked";?>/><?=$cuisine;?> &nbsp;&nbsp;
                            </div>
                        <? } ?> 
                        
                    </div><!--.well-->
					<div class="clear"></div>
                  <? if ($action=="new") {?>
                  <p class="textRed" style="background:#F00"> Внимание!</p>
                  <p class="textRed" style="background:#F00"> - Минимальное разрешение фотографии должно составлять 720 (ширина) на 477 (высота) пикселей</p>
                  <p class="textRed" style="background:#F00"> - Максимальный размер фотографий 500 КБ</p>     				  	
                  <p class="textSubjectSmall">Главное Фото <font color="#FF0000">*</font></b>(обязательно)</p>
                    
                    <div class="well">                        
                        <input type="file" class="longtitude" name="image_url" id="image_url" onchange="checkfile('image_url')"> 
                        <span id="okimage_url" style="float:left; display:none">
                      <img src="../images/icons/success.png" width="16" height="16" style="display:block;"  />
                      </span>
                      <span id="noimage_url" style="float:left; display:none">
                      <img src="../images/icons/action_stop.gif" align="left" width="16" height="16" style="display:block;"/>
                      Ошибка, размер фото больше 500 КБ
                      </span>
                    </div><!--.well--> 
                  <div class="clear"></div>
                    <p class="textSubjectSmall">Дополнительные Фото (720x477)</p>

                    <div class="well">
                        <input type="file" class="longtitude" id="photo1" name="photo1" onchange="checkfile('photo1')">
                      <span id="okphoto1" style="float:left; display:none">
                      <img src="../images/icons/success.png" width="16" height="16" style="display:block;"  />
                      </span>
                      <span id="nophoto1" style="float:left; display:none">
                      <img src="../images/icons/action_stop.gif" align="left" width="16" height="16" style="display:block;"/>
                      Ошибка, размер фото больше 500 КБ
                      </span>
<div class="clear"></div>
                        </br>                         
                        <input type="file" class="longtitude" id="photo2"  name="photo2" onchange="checkfile('photo2')">
                     <span id="okphoto2" style="float:left; display:none">
                      <img src="../images/icons/success.png" width="16" height="16" style="display:block;"  />
                      </span>
                      <span id="nophoto2" style="float:left; display:none">
                      <img src="../images/icons/action_stop.gif" align="left" width="16" height="16" style="display:block;"/>
                      Ошибка, размер фото больше 500 КБ
                      </span>
                        <div class="clear"></div>
                        </br>                         
                        <input type="file" class="longtitude" id="photo3"  name="photo3" onchange="checkfile('photo3')">
                     <span id="okphoto3" style="float:left; display:none">
                      <img src="../images/icons/success.png" width="16" height="16" style="display:block;"  />
                      </span>
                      <span id="nophoto3" style="float:left; display:none">
                      <img src="../images/icons/action_stop.gif" align="left" width="16" height="16" style="display:block;"/>
                      Ошибка, размер фото больше 500 КБ
                      </span>
                        <div class="clear"></div>
                        </br>                         
                        <input type="file" class="longtitude" id="photo4"  name="photo4" onchange="checkfile('photo4')">
                      <span id="okphoto4" style="float:left; display:none">
                      <img src="../images/icons/success.png" width="16" height="16" style="display:block;"  />
                      </span>
                      <span id="nophoto4" style="float:left; display:none">
                      <img src="../images/icons/action_stop.gif" align="left" width="16" height="16" style="display:block;"/>
                      Ошибка, размер фото больше 500 КБ
                      </span>
                        <div class="clear"></div>
                        </br>                         
                        <input type="file" class="longtitude" id="photo5"  name="photo5" onchange="checkfile('photo5')">
                      <span id="okphoto5" style="float:left; display:none">
                      <img src="../images/icons/success.png" width="16" height="16" style="display:block;"  />
                      </span>
                      <span id="nophoto5" style="float:left; display:none">
                      <img src="../images/icons/action_stop.gif" align="left" width="16" height="16" style="display:block;"/>
                      Ошибка, размер фото больше 500 КБ
                      </span>
                        <div class="clear"></div>
                        </br> 
                        <input type="file" class="longtitude" id="photo6"  name="photo6" onchange="checkfile('photo6')">
                        <span id="okphoto6" style="float:left; display:none">
                      <img src="../images/icons/success.png" width="16" height="16" style="display:block;"  />
                      </span>
                      <span id="nophoto6" style="float:left; display:none">
                      <img src="../images/icons/action_stop.gif" align="left" width="16" height="16" style="display:block;"/>
                      Ошибка, размер фото больше 500 КБ
                      </span>
                        <div class="clear"></div>
                        </br> 
                        <input type="file" class="longtitude" id="photo7"  name="photo7" onchange="checkfile('photo7')">
                        <span id="okphoto7" style="float:left; display:none">
                      <img src="../images/icons/success.png" width="16" height="16" style="display:block;"  />
                      </span>
                      <span id="nophoto7" style="float:left; display:none">
                      <img src="../images/icons/action_stop.gif" align="left" width="16" height="16" style="display:block;"/>
                      Ошибка, размер фото больше 500 КБ
                      </span>
                        <div class="clear"></div>
                        </br> 
                        <input type="file" class="longtitude" id="photo8"  name="photo8" onchange="checkfile('photo8')">
                        <span id="okphoto8" style="float:left; display:none">
                      <img src="../images/icons/success.png" width="16" height="16" style="display:block;"  />
                      </span>
                      <span id="nophoto8" style="float:left; display:none">
                      <img src="../images/icons/action_stop.gif" align="left" width="16" height="16" style="display:block;"/>
                      Ошибка, размер фото больше 500 КБ
                      </span>
                        <div class="clear"></div>
                        </br> 
                        <input type="file" class="longtitude" id="photo9"  name="photo9" onchange="checkfile('photo9')">
                        <span id="okphoto9" style="float:left; display:none">
                      <img src="../images/icons/success.png" width="16" height="16" style="display:block;"  />
                      </span>
                      <span id="nophoto9" style="float:left; display:none">
                      <img src="../images/icons/action_stop.gif" align="left" width="16" height="16" style="display:block;"/>
                      Ошибка, размер фото больше 500 КБ
                      </span>
                        <div class="clear"></div>
                        </br> 
                        <input type="file" class="longtitude" id="photo10"  name="photo10" onchange="checkfile('photo10')">
                        <span id="okphoto10" style="float:left; display:none">
                      <img src="../images/icons/success.png" width="16" height="16" style="display:block;"  />
                      </span>
                      <span id="nophoto10" style="float:left; display:none">
                      <img src="../images/icons/action_stop.gif" align="left" width="16" height="16" style="display:block;"/>
                      Ошибка, размер фото больше 500 КБ
                      </span>   
                    </div><!--.well--> 
                    <div class="clear"></div>
                    
                    <hr />
                    <? } ?>
                    <? 
					$rwFlat['objectlog'] = $objectlog;
					include 'controlsubdomain.php';?>
                    <div class="well">     
                    
                    <input type="image" id="dobavitkv" src="../images/sitetools/send.png"> <br/>
                    После добавления Звоните по телефону (0552) 895 335, (0702) 895 335, (0502) 895 335
                    </div>
                  
</form>

</div><!--end main_border-->

<?php
include_once 'footer.php';
?>

<script type="text/javascript">
    function checkfile(filename){
		document.getElementById("ok"+filename).style.display='none';
		document.getElementById("no"+filename).style.display='none';
		if(window.ActiveXObject){
			var fso = new ActiveXObject("Scripting.FileSystemObject");
			var filepath = document.getElementById(filename).value;
			var thefile = fso.getFile(filepath);
			var sizeinbytes = thefile.size;
		}else{
			var sizeinbytes = document.getElementById(filename).files[0].size;
		}
		if (sizeinbytes > 500*1024) document.getElementById("no"+filename).style.display='block';
		else  document.getElementById("ok"+filename).style.display='block';
		//var fSExt = new Array('Bytes', 'KB', 'MB', 'GB');
		//fSize = sizeinbytes; i=0;while(fSize>900){fSize/=1024;i++;}
		//alert((Math.round(fSize*100)/100)+' '+fSExt[i]);
	}

	function makezero(cb, key){
		if (cb.checked) document.getElementById("saunaitemprice"+key).value ='0';
		else  document.getElementById("saunaitemprice"+key).value ='';
	}
</script>