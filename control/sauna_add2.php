<?php
include_once 'usercontrol.php';
$title = "ДОБАВИТЬ САУНА";
$active = "7";

$userid = $_SESSION['userid'];
$flat_id = 0;
$flat_type = 4;

$error = "";

$latitude = "42.87568142335946";
$longitude = "74.61169433337409";
$zoom = "9";

if (isset($_POST['name_ru'])) {
	$objectlog = getpost('objectlog');
	$city = (int)$_POST['city'];
	$district = (int)$_POST['district'];
	$street = $_POST['street'];
	$crosses = $_POST['crosses'];
	$apartment = (int)$_POST['apartment'];
	$homenumber = (int)$_POST['homenumber'];
	$landmark_ru = $_POST['landmark_ru'];
	$landmark_eng = $_POST['landmark_eng'];
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];
	$zoom = $_POST['zoom'];
	
    $phone = $_POST['phone'];
	$phone2 = $_POST['phone2'];
	$phone3 = $_POST['phone3'];
	$email = $_POST['email'];
	$skype = $_POST['skype'];
	$icq = $_POST['icq'];
	
	$name_ru = $_POST['name_ru'];
	$name_eng = $_POST['name_eng'];
	$name_native = $_POST['name_native'];
    $description_ru = $_POST['description_ru'];
	$description_eng = $_POST['description_eng'];
	$description_native = $_POST['description_native'];
	
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
        if ($image_url['error'] <= 0) {
            $handle = new Upload($image_url);
            $newname = time();
            if ($handle->uploaded) {
                $handle->image_resize = true;
                $handle->image_ratio_y = true;
                $handle->image_x = 800;
                $handle->file_new_name_body = $newname;
                //$path=substr(date("d.m.Y"),3,2);
                $handle->Process('../images/big/');
                if ($handle->processed) {
                    $pic1 = $handle->file_dst_name;
                } else {
                    $error.=$handle->error . '';
                }

                $handle->image_resize = true;
                //$handle->image_ratio_y = true;
                $handle->image_x = 455;
                $handle->image_y = 276;
                $handle->file_new_name_body = $newname;
                //$path=substr(date("d.m.Y"),3,2);
                $handle->Process('../images/mainimg/');
                if ($handle->processed) {
                    $pic1 = $handle->file_dst_name;
                } else {
                    $error.=$handle->error . '';
                }

                $handle->image_resize = true;
                //$handle->image_ratio_y = true;
				$handle->image_ratio_crop = true;
                $handle->image_x = 230;
                $handle->image_y = 170;
                $handle->file_new_name_body = $newname;
                //$path=substr(date("d.m.Y"),3,2);
                $handle->Process('../images/thu/');
                if ($handle->processed) {
                    $pic1 = $handle->file_dst_name;
                } else {
                    $error.=$handle->error . '';
                }
            }
        }else {
			$error="<b>Главное фото отсутствует!</b><br>";
		}
		
			$insert = array(
				"user_id" => $userid,
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
				"main_img" =>  $pic1
        	);
		if ($error == "") {
			if (!$db->insert("flats", $insert)) $error ="Ошибка!";
			else {$rwFlat = $db->select_one("flats", "update_date='" . $update_date . "' AND city='" . $city . "' AND district='" . $district . "' AND user_id='" . $userid . "'", "*", " ORDER BY flat_id DESC", "0,1");
			 $flat_id = $rwFlat["flat_id"];
			}
			if ($error == "") {
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
    if ($error == "") {
        //echo '<div id="msgerror">' . $error . '</div>';
        $redurl = $flat_id==0?"index.php?action=saunaadded":"sauna_rooms.php?flat_id=".$flat_id; 
		redirect($redurl, "js");
    }
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

                <form action="sauna_add.php" method="post" enctype="multipart/form-data" name="addnew" id="addnew">
                    <input type="hidden" name="flat_type" value="<?=$flat_type;?>"/><!-- FLAT TYPE: KVARTIRA -->
                    <p class="textRed" style="background:#F00"> Внимание! </p>
                    <div class="well">
                        <p style="color:#F00">Если у вас несколько саун в одном месте, <a href="sauna_add.php" style="color:#03F; text-decoration:underline">вам сюда...</a></p>
                    </div>
                    <div class="clear"></div>
                    <h2 class="textRed">Вместимость</h2>                    
                    <div class="well">
                        <div class="priceforing">Вместимость:</div>                        
                        
                      <select id="capacity" name="capacity" class="priceformedium">
                      	<option value="1-5 чел">1-5 чел</option>
                        <option value="5-10 чел">5-10 чел</option>
                        <option value="10-15 чел">10-15 чел</option>
                      </select>                        
                    </div><!--.well--> 
                    <div class="clear"></div> 
                    <div class="well">
                        <div class="priceforing">Сколько комнат отдыха:</div>                        
                        
                      <select id="capacity" name="capacity" class="priceformedium">
                      	<option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                      </select>                        
                    </div><!--.well--> 
                    <div class="clear"></div> 
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
                        <div class="priceforing">Скидка:</div>                        
                    <span style="float:left;margin-top:5px;">с &nbsp;</span> 
                    <select type="select" name="skidkafrom" class="pricefor">
                    <? for ($i=0; $i<48; $i++){ 
						$skidkafromvalue = (!($i%2)) ? ((int)($i/2)).":00":((int)($i/2)).":30";
					?>
                    	<option value="<?=$skidkafromvalue;?>"><?=$skidkafromvalue;?></option>
                    <? } ?>
                    </select>	 
                    
                    <span style="float:left;margin-top:5px;"> &nbsp;&nbsp;&nbsp;до &nbsp;</span>
                    <select type="select" name="skidkato" class="pricefor">
                    <? for ($i=0; $i<48; $i++){ 
						$skidkatovalue = (!($i%2)) ? ((int)($i/2)).":00":((int)($i/2)).":30";
					?>
                    	<option value="<?=$skidkatovalue;?>"><?=$skidkatovalue;?></option>
                    <? } ?>
                    </select>
                    
                    <input type="text" class="pricefor" name="skidka" value="<?=$skidka;?>"/>        
                    </div><!--.well-->
                    <div class="clear"></div> 
                    <div class="well">
                        <div class="priceforing">Процент за обслуживание:</div>                        
                    <input type="text" class="pricefor" name="price" value="<?=$price;?>"/>
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
							if ($inv["flat_type"]==4) $invname = "<font color='#FF0000'>".$invname."</font>";
						?>
                            <div style="width:350px;float:left; margin-top:10px">
                            <input type="checkbox" value="<?=$inv["inventory_id"];?>" <? 
							for ($i=0; $i<count($inventory); $i++) if ($inventory[$i]==$inv["inventory_id"]){
									echo 'checked="checked"'; break;
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
                            <input type="radio" value="<?=$cuisine;?>" name="dancefloor"/><?=$cuisine;?> &nbsp;&nbsp;
                            </div>
                        <? } ?> 
                        
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <p class="textRed">Парилка</p>
                    <?
                    	$listcuisine = array("Финская","Русская","Сухая","Влажная","Турецкий хамам");
					?>
                     <div class="well">
                        
                        <?php
                        foreach ($listcuisine as $cuisine) {
						?>
                            <div style="width:350px;float:left; margin-top:10px">
                            <input type="checkbox" value="<?=$cuisine;?>" name="cuisine[]"/><?=$cuisine;?> &nbsp;&nbsp;
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
                            <input type="checkbox" value="<?=$cuisine;?>" name="cuisine[]"/><?=$cuisine;?> &nbsp;&nbsp;
                            </div>
                        <? } ?> 
                        
                    </div><!--.well-->
					<div class="clear"></div>

                    <p class="textRed">Бассейн</p>
                    <?
                    	$listcuisine = array("Летний (на улице)","Зимний (внутри)","Теплое","Холодное","Дубовая бочка (купель)");
					?>
                     <div class="well">
                        
                        <?php
                        foreach ($listcuisine as $cuisine) {
						?>
                            <div style="width:350px;float:left; margin-top:10px">
                            <input type="checkbox" value="<?=$cuisine;?>" name="cuisine[]"/><?=$cuisine;?> &nbsp;&nbsp;
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
                        $rwMas = $db->select("massagedb");
                        foreach ($rwMas as $msg) {
					?>
                    
                    <div class="well">
                        <p class="star"><?=$msg["name"];?></p>                   
                        <input type="text" class="pricefor" style="margin-right:0" name="phone"  value=""/>
                        <span style="float:left; width:30px; margin-right:10px">мин.</span>
                        <input type="text" class="pricefor" name="phone"  value=""/>
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
                            <input type="checkbox" value="<?=$cuisine;?>" name="cuisine[]"/><?=$cuisine;?> &nbsp;&nbsp;
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
                            <input type="checkbox" value="<?=$cuisine;?>" name="cuisine[]"/><?=$cuisine;?> &nbsp;&nbsp;
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
                    <?
                    	$listcuisine = array("Веники","Мыло","Шампунь","Мочалка","Шапки для парилки","Губка для скраба","Бритва одноразовая","Полотенца","Кальян");
					?>
                        <?php
                        foreach ($listcuisine as $cuisine) {
						?>
                            <div class="well">
                                <p class="star"><?=$cuisine;?></p>                   
                                <input type="text" class="pricefor" style="margin-right:0" name="phone"  value=""/>
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
                            <input type="checkbox" value="<?=$cuisine;?>" name="cuisine[]"/><?=$cuisine;?> &nbsp;&nbsp;
                            </div>
                        <? } ?> 
                        
                    </div><!--.well-->
					<div class="clear"></div>
                    
                      				  	
                  <p class="textSubjectSmall">Главное Фото <font color="#FF0000">*</font></b>(обязательно) - Минимальное разрешение фотографии должно составлять 720 (ширина) на 477 (высота) пикселей</p>
                    
                    <div class="well">                        
                        <input type="file" class="longtitude" name="image_url"> 
                    </div><!--.well--> 
                  <div class="clear"></div>
                    <p class="textSubjectSmall">Дополнительные Фото (720x477)</p>

                    <div class="well">
                        <input type="file" class="longtitude" name="photo1"> 
                      <div class="clear"></div>
                        </br>                         
                        <input type="file" class="longtitude" name="photo2">
                        <div class="clear"></div>
                        </br>                         
                        <input type="file" class="longtitude" name="photo3">
                        <div class="clear"></div>
                        </br>                         
                        <input type="file" class="longtitude" name="photo4">
                        <div class="clear"></div>
                        </br>                         
                        <input type="file" class="longtitude" name="photo5">
                        <div class="clear"></div>
                        </br> 

                        <input type="file" class="longtitude" name="photo6">
                        <div class="clear"></div>
                        </br> 
                        <input type="file" class="longtitude" name="photo7">
                        <div class="clear"></div>
                        </br> 
                        <input type="file" class="longtitude" name="photo8">
                        <div class="clear"></div>
                        </br> 
                        <input type="file" class="longtitude" name="photo9">
                        <div class="clear"></div>
                        </br> 
                        <input type="file" class="longtitude" name="photo10">   
                    </div><!--.well--> 
                    <div class="clear"></div>
                    
                    <hr />
                    <? include 'controlsubdomain.php';?>
                    <div class="well">     
                    
                    <input type="image" id="dobavitkv" src="../images/sitetools/send.png"> <br/>
                    После добавления Звоните по телефону (0552) 895 335, (0702) 895 335, (0502) 895 335
                    </div>
                  
</form>

</div><!--end main_border-->

<?php
include_once 'footer.php';
?>