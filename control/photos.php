<?php
include_once 'usercontrol.php';
$title = "РЕДАКТУРА";
$active = "7";

$userid = $_SESSION['userid'];
$flat_id = $_REQUEST['flat_id'];
require 'flatcontrol.php';

$flat_type = (isset($_REQUEST["flat_type"]))?$_REQUEST["flat_type"]:0;
$flat_type = (($flat_type>1) || ($flat_type<0))?0:$flat_type; 
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
	
	$currency = $_POST['currency'];
	
    $price = $_POST['price'];
    $price_night = $_POST['price_night'];
    $price_day = $_POST['price_day'];
	
	$price_prepay = $_POST['price_prepay'];
    $price_night_prepay = $_POST['price_night_prepay'];
    $price_day_prepay = $_POST['price_day_prepay'];	
	
	$discount = $_POST['discount'];
    $discount_date = $_POST['discount_date'];
	
	$city = $_POST['city'];
	$district = $_POST['district'];
	$street = $_POST['street'];
	$apartment = $_POST['apartment'];
	$homenumber = $_POST['homenumber'];
	$landmark_ru = $_POST['landmark_ru'];
	$landmark_eng = $_POST['landmark_eng'];
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];
	$zoom = $_POST['zoom'];
	
    $phone = $_POST['phone'];
	$email = $_POST['email'];
	$skype = $_POST['skype'];
	$icq = $_POST['icq'];
	
	$name_ru = $_POST['name_ru'];
	$name_eng = $_POST['name_eng'];
	$name_native = $_POST['name_native'];
    $description_ru = $_POST['description_ru'];
	$description_eng = $_POST['description_eng'];
	$description_native = $_POST['description_native'];
	
	$wifi = $_POST['wifi'];
	$room = $_POST['room'];
	$bed = $_POST['bed'];
	$construct_serial = $_POST['construct_serial'];
	$floor = $_POST['floor'];
	$total_floors = $_POST['total_floors'];
	$msquare = $_POST['msquare'];
	
	$infrastructure = $_POST['infrastructure'];
	$inventory = $_POST['inventory'];
	
	
	
	//echo $insert;

    $update_date = date("Y-m-d H:m:s");
    $error = "";

    /*if ($phone == "")
        $error.="<b>Номер телефона не введен!</b><br>";
    if ($address == "")
        $error.="<b>Адрес не введен!</b><br>";
    if ($description == "")
        $error.="<b>Описание не введено!</b><br>";
	*/
    if ($error == "") {

			$update = array(
				"update_date" => $update_date,
				"flat_type" => $flat_type,
				"currency" => $currency,
				"price" => $price,
				"price_night" => $price_night,
				"price_day" => $price_day,
				"price_prepay" => $price_prepay,
				"price_night_prepay" => $price_night_prepay,
				"price_day_prepay" => $price_day_prepay,	
				"discount" => $discount,
				"discount_date" => $discount_date,
				"city" => $city,
				"district" => $district,
				"street" => $street,
				"apartment" => $apartment,
				"homenumber" => $homenumber,
				"landmark_ru" => $landmark_ru,
				"landmark_eng" => $landmark_eng,
				"latitude" => $latitude,
				"longitude" => $longitude,
				"zoom" => $zoom,
				"phone" => $phone,
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
				"msquare" => $msquare
        	);
		$db->update(DB_PREFIX . "flats", $update, "flat_id = " . $flat_id);
		
		$db->delete(DB_PREFIX . "flat_inventory", "flat_id = " . $flat_id);
		$db->delete(DB_PREFIX . "flat_infrastructure", "flat_id = " . $flat_id);
		
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
        
    }
}
$rwFlat = $db->select_one("flats", "flat_id='" . $flat_id . "'", "*", "", "");
{
	$currency = $rwFlat['currency'];
	
    $price = $rwFlat['price'];
    $price_night = $rwFlat['price_night'];
    $price_day = $rwFlat['price_day'];
	
	$price_prepay = $rwFlat['price_prepay'];
    $price_night_prepay = $rwFlat['price_night_prepay'];
    $price_day_prepay = $rwFlat['price_day_prepay'];	
	
	$discount = $rwFlat['discount'];
    $discount_date = $rwFlat['discount_date'];
	
	$city = $rwFlat['city'];
	$district = $rwFlat['district'];
	$street = $rwFlat['street'];
	$apartment = $rwFlat['apartment'];
	$homenumber = $rwFlat['homenumber'];
	$landmark_ru = $rwFlat['landmark_ru'];
	$landmark_eng = $rwFlat['landmark_eng'];
	$latitude = $rwFlat['latitude'];
	$longitude = $rwFlat['longitude'];
	$zoom = $rwFlat['zoom'];
	
    $phone = $rwFlat['phone'];
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
	
}

$infrastructuredb = $db->select("flat_infrastructure", "flat_id='".$flat_id."'", "*", "","");
$inventorydb = $db->select("flat_inventory", "flat_id='".$flat_id."'", "*", "","");
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
            
                <form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data" name="addnew" id="addnew">
                    <input type="hidden" name="flat_type" value="<?=$flat_type;?>"/><!-- FLAT TYPE: KVARTIRA -->
                    <input type="hidden" name="flat_id" value="<?=$flat_id;?>"/><!-- FLAT TYPE: KVARTIRA -->
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
                      <input type="text" class="pricefor" name="price" value="<?=$price;?>"/><p class="postinput">сом</p>
                    </div><!--.well--> 
                    <div class="clear"></div> 
                    
                    <div class="well">
                        <div class="priceforing">Цена за час (при предоплате):</div>                        
                        <input type="text" class="pricefor" name="price_prepay" value="<?=$price_prepay;?>"/><p class="postinput">сом</p>
                    </div><!--.well--> 
                    <div class="clear"></div>
                    
                    <div class="well">
                        <div class="priceforing">Цена за ночь:</div>                        
                        <input type="text" class="pricefor" name="price_night" value="<?=$price_night;?>"/><p class="postinput">сом</p>
                    </div><!--.well-->
                    <div class="clear"></div>
                    
                    <div class="well">
                        <div class="priceforing">Цена за ночь (при предоплате):</div>                        
                        <input type="text" class="pricefor" name="price_night_prepay" value="<?=$price_night_prepay;?>"/><p class="postinput">сом</p>
                    </div><!--.well-->
                    <div class="clear"></div>
                    
                    <div class="well">
                        <div class="priceforing">Цена за сутки:</div>                        
                        <input type="text" class="pricefor" name="price_day" value="<?=$price_day;?>"/><p class="postinput">сом</p>
                    </div><!--.well-->
                    <div class="clear"></div>
                     
                    <div class="well">
                        <div class="priceforing">Цена за сутки (при предоплате):</div>                        
                        <input type="text" class="pricefor" name="price_day_prepay" value="<?=$price_day_prepay;?>"/><p class="postinput">сом</p>
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
                        <p class="priceforing">Скидка действительна до: </p>
                        <input type="text" name="discount_date" class="pricefor"  value="<?=$discount_date;?>"/>
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
                    
                    <div class="well">
                        <p class="star">Район / Населённый пункт: </p>
                    <select id="district" name="district"  class="priceformedium">
                     <?php
						$rwRegions = $db->select("regions", "", "*", "ORDER BY region_id ASC");
						foreach ($rwRegions as $region) {
							echo '<option value="' . $region["region_id"] . '" ';
							if ($region['region_id'] == $district) echo 'selected';
							echo ' >' . $region['region_title'] . '</option>';
						}
					?>                 
                    </select>
                    </div><!--.well-->
                    <div class="clear"></div>
                    
                    
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
                        <p class="star">Ориентир (рус): </p>
                        <input type="text" name="landmark_ru" class="priceforlong" value="<?=$landmark_ru;?>"/>
                    </div><!--.well-->
                    <div class="clear"></div>
                    <div class="well">
                        <p class="star">Ориентир (англ): </p>
                        <input type="text" name="landmark_eng" class="priceforlong" value="<?=$landmark_eng;?>"/>
                    </div><!--.well-->
                    <div class="clear"></div>
                    <div class="well" style="margin-top:10px">

                      	  <p class="star"><input type="button" value="Найти вышеуказанный адрес" onclick="updatemap()" class="findonmapbutton"  /> </p> <br/>
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
                        <p class="star">ICQ: </p>                       
                        <input type="text" class="priceformedium" name="icq"  value="<?=$icq;?>"/>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <p class="textRed">Информация о квартире на русском языке</p>
                    
                    <div class="well">
                        <p class="star">Название: </p>                       
                        
                        <input type="text" class="priceforlong" name="name_ru"  value="<?=$name_ru;?>"/>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Описание квартиры: </p>
                        <textarea name="description_ru" class="priceforlong" rows="6" id="description_ru"><?=$description_ru;?></textarea>                       
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <p class="textRed">Информация о квартире на английском языке (необязательно)</p>
                    
                    <div class="well">
                        <p class="star">Название: </p>                       
                        
                        <input type="text" class="priceforlong" name="name_eng"  value="<?=$name_eng;?>"/>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Описание квартиры: </p>
                        <textarea name="description_eng" class="priceforlong" rows="6" id="description_eng"><?=$description_eng;?></textarea>                       
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <p class="textRed">Информация о квартире на кыргызском языке (необязательно)</p>
                    
                    <div class="well">
                        <p class="star">Название: </p>                       
                        
                        <input type="text" class="priceforlong" name="name_native"  value="<?=$name_native;?>"/>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Описание квартиры: </p>
                        <textarea name="description_native" class="priceforlong" rows="6" id="description_native"><?=$description_native;?></textarea>                       
                    </div><!--.well-->
					<div class="clear"></div>
                    
					<p class="textRed">Параметры квартиры</p>
                    
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
                    
                    <? } ?>
                    
                   <div class="well">
                        <p class="star">Этаж: </p>
                     <input name="floor" type="text" class="pricefor" value="<?=$floor;?>"/>                       
                  </div><!--.well-->
					<div class="clear"></div>
                    
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

                   <p class="textRed">Инвентарь:</p>
                    <div class="well">                        
                       <?php
                        $rwInv = $db->select("inventory", "", "*", "");
                        foreach ($rwInv as $inv) {?>
                            <input type="checkbox" value="<?=$inv["inventory_id"];?>" <? 
							foreach ($inventorydb as $inven) if ($inven["inventory_id"]==$inv["inventory_id"]){
									echo 'checked="checked"'; break;
								}
							?> name="inventory[]"/> <?=$inv["inventory"];?> &nbsp;&nbsp;
                        <? } ?> 
                    </div><!--.well-->
                    <div class="clear"></div>
                    
                    <p class="textRed">Инфраструктура:</p>
                    <div class="well">                        
                       <?php
                        $rwInf = $db->select("infrastructure", "", "*", "");
                        foreach ($rwInf as $inf) { ?>
                            <input type="checkbox" value="<?=$inf["infrastructure_id"];?>" <? 
							foreach ($infrastructuredb as $infra) if ($infra["infrastructure_id"]==$inf["infrastructure_id"]){
									echo 'checked="checked"'; break;
								}
							?> name="infrastructure[]"/> <?=$inf["infrastructure"];?>&nbsp;&nbsp;
                        <? } ?>
                    </div><!--.well-->
                    <div class="clear"></div><hr/>
                    <div class="well">     
                    <input type="image" id="editkv" src="../images/sitetools/send.png"> <br/>
                    </div>
                  
</form>

</div><!--end main_border-->

<?php
include_once 'footer.php';
?>