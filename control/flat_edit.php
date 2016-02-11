<?php
include_once 'usercontrol.php';
$title = "РЕДАКТУРА";
$active = "7";

$userid = $_SESSION['userid'];
$flat_id = $_REQUEST['flat_id'];
require 'flatcontrol.php';
$flat_type = (isset($_REQUEST["flat_type"]))?$_REQUEST["flat_type"]:1;
$flat_type = (($flat_type>1) || ($flat_type<0))?1:$flat_type; 
global $action, $isWhat, $edit;
$edit = false;
$action = get_request('a');
$error = "";
$insert = null;

$latitude = "42.87568142335946";
$longitude = "74.61169433337409";
$zoom = "9";

// EDIT FLAT*****************************************************************************************************************
if (isset($_POST['currency'])) {
    $error = "";
	
	$currency = (int)(getpost('currency'));
	
    $price = (int)getpost('price');
    $price_night =(int) getpost('price_night');
    $price_day = (int)getpost('price_day');
	
	$price_prepay = (int)getpost('price_prepay');
    $price_night_prepay = (int)getpost('price_night_prepay');
    $price_day_prepay = (int)getpost('price_day_prepay');	
	
	$discount = (int)getpost('discount');
    $discount_date = getpost('discount_date');
	$discount_date_from = getpost('discount_date_from');
	if ($discount_date=="") $discount_date = "0000-00-00";
	if ($discount_date_from=="") $discount_date_from = "0000-00-00";
	
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
	
	$wifi = (int)getpost('wifi');
	$room = (int)getpost('room');
	$bed =(int)getpost('bed');
	$construct_serial = getpost('construct_serial');
	$floor = (int)getpost('floor');
	$total_floors = (int)getpost('total_floors');
	$msquare = getpost('msquare');
	
	$infrastructure = $_POST['infrastructure'];
	$inventory = $_POST['inventory'];
	$edit_table = $_POST['edit_table_hidden']; 
	
	$price_universal = ($currency==1)?$price_night*50:$price_night;
		
    $update_date = date("Y-m-d H:m:s");
    $error = "";

	$subdomainFlag = false;
	include 'checkSubdomain.php';
	if ($subdomainFlag) $error.="<b>Сайт с таким именем уже существует!</b><br>";

    if (($phone == "") || ($phone == "+996") || (strlen($phone)<6))
        $error.="<b>Номер телефона не введен!</b><br>";
    if ($price_night == "")
        $error.="<b>Цена за ночь не введен!</b><br>";
	if (count($infrastructure)==0)
        $error.="<b>Инфраструктура не выбран!</b><br>";
	if (count($inventory)==0)
        $error.="<b>Инвентарь не выбран!</b><br>";
		
    if ($error == "") {
		if ($district==0) {
				$district_text = getpost('district_text');
				if (strlen($district_text)>0 && $city>0){
					$rwSubRegionCount = $db->select_count("regions", "city_id='".$city."' AND region_title like '".$district_text."'", "*", " ORDER BY subregion_id DESC", "0,1");
					if ($rwSubRegionCount==0){
						$insert = array("city_id" => (int)$city, "region_title" => $district_text);
						$db->insert("regions", $insert);
					}
					$rwSubRegion = $db->select_one("regions", "city_id='".$city."' AND region_title like '".$district_text."'", "*", " ORDER BY region_id DESC", "0,1");
					$district = $rwSubRegion["region_id"];
					$district_text = "";
				}
		}	
			$update = array(
				"update_date" => $update_date,
				"objectlog" => $objectlog,
				"flat_type" => $flat_type,
				"currency" => $currency,
				"price" => $price,
				"price_night" => $price_night,
				"price_day" => $price_day,
				"price_prepay" => $price_prepay,
				"price_night_prepay" => $price_night_prepay,
				"price_day_prepay" => $price_day_prepay,
				"price_universal" => $price_universal,	
				"discount" => $discount,
				"discount_date" => $discount_date,
				"discountdate_from" => $discount_date_from,
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
				"wifi" => $wifi,
				"room" => $room,
				"bed" => $bed,
				"construct_serial" => $construct_serial,
				"floor" => $floor,
				"total_floors" => $total_floors,
				"msquare" => $msquare,
				"tbl"=> $edit_table
        	);
		$newflattype = (int)$_POST['newflattype'];
		if ($newflattype > 0) $update['flat_type'] = $newflattype; 
		if (!$db->update(DB_PREFIX . "flats", $update, "flat_id = " . $flat_id)) $error = "ERROR";
		if ($error == "") {
			$db->delete(DB_PREFIX . "flat_inventory", "flat_id = " . $flat_id);
			$db->delete(DB_PREFIX . "flat_infrastructure", "flat_id = " . $flat_id);
			$db->delete(DB_PREFIX . "orientirdb", "flat_id = " . $flat_id);
			
			for($i=0; $i<count($infrastructure); $i++){
				$insert = array(
								"flat_id" => $flat_id,
								"infrastructure_id" => $infrastructure[$i]
				 );
				$db->insert(DB_PREFIX . "flat_infrastructure", $insert);	
			}
			
			for($i=0; $i<count($inventory); $i++){
				$insert = array(
								"flat_id" => $flat_id,
								"inventory_id" => $inventory[$i]
				 );
				$db->insert(DB_PREFIX . "flat_inventory", $insert);	
			}
			
			$orname = $_POST['orname'];	
			$ortype = $_POST['ortype'];	
			$ordis = $_POST['ordis'];	
			for($i=0; $i<count($orname);$i++){
				if ($orname[$i]!="" && $ortype[$i]!="" && $ordis[$i]!=""){
					$insert = array(
									"flat_id" => $flat_id,
									"ortype" => $ortype[$i],
									"name" => $orname[$i],
									"distance" => $ordis[$i]
					 );
					$db->insert("orientirdb", $insert);
				}
			}
			
		}
        
    }
}
$rwFlat = $db->select_one("flats", "flat_id='" . $flat_id . "'", "*", "", "");
{
	$objectlog = getpost('objectlog');
	$flat_type = $rwFlat['flat_type'];
	$currency = $rwFlat['currency'];
	
    $price = $rwFlat['price'];
    $price_night = $rwFlat['price_night'];
    $price_day = $rwFlat['price_day'];
	
	$price_prepay = $rwFlat['price_prepay'];
    $price_night_prepay = $rwFlat['price_night_prepay'];
    $price_day_prepay = $rwFlat['price_day_prepay'];	
	
	$discount = $rwFlat['discount'];
    $discount_date = $rwFlat['discount_date'];
	$discount_date_from = $rwFlat['discountdate_from'];
	
	$city = $rwFlat['city'];
	$district = $rwFlat['district'];
	$street = $rwFlat['street'];
	$crosses = $rwFlat['crosses'];
	$apartment = $rwFlat['apartment'];
	$homenumber = $rwFlat['homenumber'];
	$landmark_ru = $rwFlat['landmark_ru'];
	$landmark_eng = $rwFlat['landmark_eng'];
	$latitude = $rwFlat['latitude'];
	$longitude = $rwFlat['longitude'];
	$zoom = $rwFlat['zoom'];
	
    $phone = $rwFlat['phone'];
	$phone2 = $rwFlat['phone2'];
	$phone3 = $rwFlat['phone3'];
	$email = $rwFlat['email'];
	$skype = $rwFlat['skype'];
	$icq = $rwFlat['icq'];
	
	$name_ru = $rwFlat['name_ru'];
	$name_eng = $rwFlat['name_eng'];
	$name_native = $rwFlat['name_native'];
    $description_ru = $rwFlat['description_ru'];
	$description_eng = $rwFlat['description_eng'];
	$description_native = $rwFlat['description_native'];
	
	$wifi = $rwFlat['wifi'];
	$room = $rwFlat['room'];
	$bed = $rwFlat['bed'];
	$construct_serial = $rwFlat['construct_serial'];
	$floor = $rwFlat['floor'];
	$total_floors = $rwFlat['total_floors'];
	$msquare = $rwFlat['msquare'];
	$tbl = $rwFlat['tbl'];
	
}

$infrastructuredb = $db->select("flat_infrastructure", "flat_id='".$flat_id."'", "*", "","");
$inventorydb = $db->select("flat_inventory", "flat_id='".$flat_id."'", "*", "","");
$orientirdb = $db->select("orientirdb", "flat_id='".$flat_id."'", "*", "","");
include_once 'header.php';
?>


<div class="main_border">   

			<h2 class="maintitle">Редактура</h2>
           <div class="clear"></div>
            <?php if ($error) {?>
            <div class="error">Обнаружены ошибки</div><div class="clear"></div>
               <div class="panelError">     
                    <div class="well">
						<?=$error;?>                    
                  </div>
                </div>
            <div class="clear"></div>
            <? } else if (isset($_POST['currency'])) {?>

               <div class="success">     
                    <div class="well">
                    
Данные успешно сохранены
						               
                  </div>
                </div>
            <div class="clear"></div>
            <? } else {?>  
            
            <div style="margin-left:30px;margin-top:10px;margin-bottom:10px">
            <ul>
                <li>- Поля, помеченные звездочкой (<font color="#FF0000">*</font>), обязательны для заполнения.</li>
            </ul>
            </div>
            <div class="clear"></div>
            
            <? } ?>
            
                <form action="<?php echo $form_action; ?>" method="post" name="addnew" id="addnew" onsubmit="copytablevalue()">
                    <input type="hidden" name="flat_type" value="<?=$flat_type;?>"/><!-- FLAT TYPE: KVARTIRA -->
                    <input type="hidden" name="flat_id" value="<?=$flat_id;?>"/><!-- FLAT TYPE: KVARTIRA -->
                    <h2 class="textRed">Тип строение</h2>
                    &nbsp; <?
					
					switch($flat_type) {
						case 1: echo "Квартира"; break;
						case 2: echo "Особняк"; break;
						case 3: echo "Отель"; break;
						case 4: echo "Sauna"; break;
						case 5: echo "Пансионат"; break;
					}
					
			
					?>
                    :&nbsp; изменить на &nbsp
                    <select name="newflattype" >
                    	<option value="0">--</option>
                        <option value="1">Квартира</option>
                        <option value="2">Особняк</option>
                        <option value="3">Отель</option>
                        <option value="5">Пансионат</option>
                    </select>
                    
                    <h2 class="textRed">Расценки</h2>
                    
                    <div class="well">
                        <div class="priceforing">Валюта:</div>
                      <? $currency = $currency==0 || $currency ==1 ? $currency:0; ?>
                      <input type="radio" name="currency" value="0" <? if ($currency==0) {?>checked="checked"<? } ?>>Сом (KGS)
					  <input type="radio" name="currency" value="1" <? if ($currency==1) {?>checked="checked"<? } ?>>Доллар (USD)                        
                  </div><!--.well--> 
                    <div class="clear"></div> 
                    
                    <div class="well">
                        <div class="priceforing">Цена за час:</div>                        
                      <input type="text" class="pricefor" name="price" value="<?=$price;?>"/>
                    </div><!--.well--> 
                    <div class="clear"></div> 
                    
                    <div class="well">
                        <div class="priceforing">Цена за час (при предоплате):</div>                        
                        <input type="text" class="pricefor" name="price_prepay" value="<?=$price_prepay;?>"/>
                    </div><!--.well--> 
                    <div class="clear"></div>
                    
                    <div class="well">
                        <div class="priceforing">Цена за ночь:</div>                        
                        <input type="text" class="pricefor" name="price_night" value="<?=$price_night;?>"/>
                        <div class="postinput"><b><font color="#FF0000">*</font></b>(обязательно)</div>
                    </div><!--.well-->
                    <div class="clear"></div>
                    
                    <div class="well">
                        <div class="priceforing">Цена за ночь (при предоплате):</div>                        
                        <input type="text" class="pricefor" name="price_night_prepay" value="<?=$price_night_prepay;?>"/>
                    </div><!--.well-->
                    <div class="clear"></div>
                    
                    <div class="well">
                        <div class="priceforing">Цена за сутки:</div>                        
                        <input type="text" class="pricefor" name="price_day" value="<?=$price_day;?>"/>
                    </div><!--.well-->
                    <div class="clear"></div>
                     
                    <div class="well">
                        <div class="priceforing">Цена за сутки (при предоплате):</div>                        
                        <input type="text" class="pricefor" name="price_day_prepay" value="<?=$price_day_prepay;?>"/>
                    </div><!--.well-->     
                    <div class="clear"></div>
                    
                    <p class="textRed">Скидки при заезде прямо сейчас</p>
                    <div class="well">
                        <p class="priceforing">Скидка: </p>
                         <select name="discount" class="pricefor">                        
                        <?php
                        for($i=0; $i<16; $i++) {
							$k = $i*5;
                            echo '<option value="' . $k . '" ';
                            if ($k == $discount)
                                echo 'selected';
                            echo ' >' . $k . '</option>';
                        }
                        ?>
                        </select>
                    </div><!--.well-->
                    <div class="clear"></div>
                    
                    <div class="well">
                        <p class="priceforing">Скидка действительна: </p>
                        <label for="from">от</label>
                        <input type="text" id="discount_date_from" name="discount_date_from"  value="<?=$discount_date_from;?>"/>
                        <label for="to">до</label>
                        <input type="text" id="discount_date" name="discount_date"  value="<?=$discount_date;?>"/>
                    </div><!--.well-->
                    <div class="clear"></div>
                    
                    <p class="textRed">Местонахождение</p>
                    <div class="well">
                        <p class="priceforing">Город: </p>
                        <select id="city" name="city" class="priceformedium" onChange="updateDistrict(this.form,this.value)">                        
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
                    
                    <? $actiontype = 'edit';	include 'rowsubdistrict.php';?>
                    
                    
                    <div class="well">
                        <p class="star">Название улицы: </p>
                      <input type="text" id="street" name="street" class="priceforlong" value="<?=$street;?>"/>
                    </div><!--.well-->
                    <div class="clear"></div>
                    <div class="well">
                        <p class="star">Номер дома: </p>
                        <input type="text" name="apartment" class="pricefor" value="<?=$apartment;?>"/>
                    </div><!--.well-->
                    <div class="clear"></div>
                    <div class="well">
                        <p class="star">Номер квартиры: </p>
                        <input type="text" name="homenumber" class="pricefor" value="<?=$homenumber;?>"/>
                    </div><!--.well-->
                    <div class="clear"></div>
                    <div class="well">
                        <p class="star">Пересекается: </p>
                      <input type="text" id="crosses" name="crosses" class="priceforlong" value="<?=$crosses;?>"/>
                    </div><!--.well-->
                    <div class="clear"></div>
                    
                    <div class="well" >
                        <p class="star">Рядом находится(пример): </p>
                      <input type="text" id="ortypetemp" name="ortypetemp" value="магазин" disabled="disabled"/>
                      <input type="text" id="ortypetemp2" name="ortypetemp2" value="Народный" disabled="disabled"/> 
                      <input type="text" id="ortypetemp3" name="ortypetemp3" value="100м" disabled="disabled"/>             
                    </div><!--.well--> 
                    <div class="clear"></div>
                    <?
                    	
					?>
					
					<script type="text/javascript">
					var globalk = <? if (count($orientirdb)>0) echo count($orientirdb)+3; else echo "3"; ?>;
						function showOrientirDiv(){
							document.getElementById("orientir"+globalk).style.display = 'block'; 
							globalk++;
							if(globalk>=11) document.getElementById("orientireshe").style.display = 'none'; 
							
						}
					</script>
					<?
					//$rwOR = $db->select("orientirdb","flat_id='".$flat_id."'");
					//for($k=1;$k<11-count($rwOR);$k++) 
                    $k=1;
					foreach($orientirdb as $ordb) { ?>
                    <div id="orientir<?=$k;?>">
                    <div class="well">
                        <p class="star">Объект <?=$k;?>: </p>
                      <input type="text" id="ortype[]" name="ortype[]" value="<?=$ordb['ortype'];?>"/>
                      <input type="text" id="orname[]" name="orname[]" value="<?=$ordb['name'];?>"/> 
                      <input type="text" id="ordis[]" name="ordis[]" value="<?=$ordb['distance'];?>"/>             
                    </div><!--.well--> 
                    <div class="clear"></div>
					</div>
                    <? $k++;} ?> 
					<?
					//$rwOR = $db->select("orientirdb","flat_id='".$flat_id."'");
					//for($k=1;$k<11-count($rwOR);$k++) 
                    for($k=count($orientirdb)+1;$k<11;$k++) { ?>
                    <div id="orientir<?=$k;?>" <? if ($k>(2+count($orientirdb))) {?> style="display:none" <? } ?>>
                    <div class="well">
                        <p class="star">Объект <?=$k;?>: </p>
                      <input type="text" id="ortype[]" name="ortype[]" value="<?=$orientir[$k];?>"/>
                      <input type="text" id="orname[]" name="orname[]" value="<?=$orientir[$k];?>"/> 
                      <input type="text" id="ordis[]" name="ordis[]" value="<?=$orientir[$k];?>"/>             
                    </div><!--.well--> 
                    <div class="clear"></div>
					</div>
                    <? } ?> 
                    <div id="orientireshe">
                    <div class="well">
                        <p class="star"><a href="javascript:showOrientirDiv()" style="color:#06F; text-decoration:underline">Добавить еще объект</a></p>  
                    </div><!--.well--> 
                    <div class="clear"></div>
                    </div>
                    <!--
                    <div class="well">
                        <p class="star">Ориентир (рус): </p>
                        <input type="text" name="landmark_ru" class="priceforlong" value="<?=$landmark_ru;?>"/>
                    </div>
                    <div class="clear"></div>
                    <div class="well">
                        <p class="star">Ориентир (англ): </p>
                        <input type="text" name="landmark_eng" class="priceforlong" value="<?=$landmark_eng;?>"/>
                    </div><
                    <div class="clear"></div>
                    -->
                    
                    <div class="well" style="margin-top:10px">

                      	  <p class="star"><input type="button" value="Найти вышеуказанный адрес" onClick="updatemap()" class="findonmapbutton"  /> </p> <br/><div class="red">Вы должны указать флажок где находиться ваш объект:</div
                          ><div id="map_canvas" style="width:750px; height:560px; border:solid 1px #FF0000" ></div>
                          
                          
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
                    
                    <p class="textRed">Информация на русском языке</p>
                    
                    <div class="well">
                      <p class="star">Название: </p>                       
                        
                        <input type="text" class="priceforlong" name="name_ru"  value="<?=$name_ru;?>"/>
                    </div><!--.well-->
             		<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Описание: </p>
                        <textarea name="description_ru" class="priceforlong" rows="6" id="description_ru"><?=$description_ru;?></textarea> 
                                              
                    </div><!--.well-->
					<div class="clear"></div>

						<? include('edit_table.php');?>

                    <p class="textRed">Информация на английском языке (необязательно)</p>
                    
                    <div class="well">
                        <p class="star">Название: </p>                       
                        
                        <input type="text" class="priceforlong" name="name_eng"  value="<?=$name_eng;?>"/>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Описание: </p>
                        <textarea name="description_eng" class="priceforlong" rows="6" id="description_eng"><?=$description_eng;?></textarea>                       
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <p class="textRed">Информация на кыргызском языке (необязательно)</p>
                    
                    <div class="well">
                        <p class="star">Название: </p>                       
                        
                        <input type="text" class="priceforlong" name="name_native"  value="<?=$name_native;?>"/>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Описание: </p>
                        <textarea name="description_native" class="priceforlong" rows="6" id="description_native"><?=$description_native;?></textarea>                       
                    </div><!--.well-->
					<div class="clear"></div>
                    
					<p class="textRed">Параметры </p>
                    
                    <div class="well">
                        <p class="star">Бесплатный Wi-Fi: </p>
                        <input name="wifi" value="1" type="checkbox" <? if ($wifi==1) {?>checked="checked"<? } ?>/>                       
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <div class="priceforing">Количество комнат</div>
                        <select name="room" class="pricefor">  
                        <?php
							$maxroom = 11;
							if ($flat_type==1) $maxroom = 21;
                        	for($i=1; $i<$maxroom; $i++) {
                            	echo '<option value="' . $i . '" ';
                         		if ($i == $room) echo 'selected';
                            	echo ' >' . $i . '</option>';
                        	}
                        ?>   
                        </select>                           
                    </div><!--.well-->
                    <div class="clear"></div>
                    
                    <div class="well">
                        <div class="priceforing">Количество спальных мест</div>
                        <select name="bed" class="pricefor">  
                        <?php
							$maxroom = 21;
							if ($flat_type==1) $maxroom = 41;
                        	for($i=1; $i<$maxroom; $i++) {
                            	echo '<option value="' . $i . '" ';
                         		if ($i == $bed) echo 'selected';
                            	echo ' >' . $i . '</option>';
                        	}
                        ?>   
                        </select>                           
                    </div><!--.well-->
                    <div class="clear"></div>
					
                    <? if ($flat_type==0) { ?>
                    
                    <div class="well">
                        <div class="priceforing">Тип строения</div> 

                        <?php
                        echo '<select name="construct_serial" class="pricefor">';
                        foreach ($arrSeria as $key => $value) {
                            echo '<option value="' . $value . '" ';
							if ($value == $construct_serial) echo 'selected';
                            echo ' >' . $value . '</option>';
                        }
                        echo '</select>';
                        ?>        
                         
                    </div><!--.well-->
                    <div class="clear"></div>
                    
                    
                    
                   <div class="well">
                        <p class="star">Этаж: </p>
                     <input name="floor" type="text" class="pricefor" value="<?=$floor;?>"/>                       
                  </div><!--.well-->
					<div class="clear"></div>
                    <? } ?>
                    <div class="well">
                        <p class="star">Этажность: </p>
                      <input name="total_floors" type="text"  class="pricefor" value="<?=$total_floors;?>"/>                       
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Площадь, кв.м.: </p>
                      <input name="msquare" type="text"  class="pricefor" value="<?=$msquare;?>"/>                       
                    </div><!--.well-->
					<div class="clear"></div>

                   <p class="textRed">Инвентарь:<font color="#FF0000">*</font>(обязательно)</p>
                    <div class="well">                        
                       <?php
                        $rwInv = $db->select("inventory", "flat_type like '0' OR flat_type like '%1%' OR flat_type like '%2%'", "*", "");
                        foreach ($rwInv as $inv) {?>
                            <div style="width:350px;float:left">
                            <input type="checkbox" value="<?=$inv["inventory_id"];?>" <? 
							foreach ($inventorydb as $inven) if ($inven["inventory_id"]==$inv["inventory_id"]){
									echo 'checked="checked"'; break;
								}
							?> name="inventory[]"/> <?=$inv["inventory"];?> &nbsp;&nbsp;
                            </div>
                        <? } ?> 
                    </div><!--.well-->
                    <div class="clear"></div>
                    
                    <p class="textRed">Инфраструктура:<font color="#FF0000">*</font>(обязательно)</p>
                    <div class="well">                        
                       <?php
                        $rwInf = $db->select("infrastructure", "", "*", "");
                        foreach ($rwInf as $inf) { ?>
                        	<div style="width:350px;float:left">
                            <input type="checkbox" value="<?=$inf["infrastructure_id"];?>" <? 
							foreach ($infrastructuredb as $infra) if ($infra["infrastructure_id"]==$inf["infrastructure_id"]){
									echo 'checked="checked"'; break;
								}
							?> name="infrastructure[]"/> <?=$inf["infrastructure"];?>&nbsp;&nbsp;
                            </div>
                        <? } ?>
                    </div><!--.well-->
                    <div class="clear"></div><hr/>
                    <? include 'controlsubdomain.php';?>
                    <div class="well">     
                    <input type="image" id="editkv" src="../images/sitetools/send.png"> <br/>
                    </div>
                  
</form>

</div><!--end main_border-->

<?php
include_once 'footer.php';
?>