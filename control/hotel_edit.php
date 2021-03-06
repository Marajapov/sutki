﻿<?php
include_once 'usercontrol.php';
$title = "Редактура";
$active = "7";

$userid = $_SESSION['userid'];
$flat_id = $_REQUEST['flat_id'];
require 'flatcontrol.php';

if (isset($_POST["city"])) {
    $error = "";
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
	$hotelstar = (int)getpost('hotelstar');

    $image_url = $_FILES['image_url'];
    $update_date = date("Y-m-d H:m:s");
    $error = "";
	$mainimg = $_POST['mainimg'];
	$infrastructure = $_POST['infrastructure'];
	$edit_table = $_POST['edit_table_hidden'];
    
	$price_universal = ($currency==1)?$price_night*50:$price_night;
	
	$subdomainFlag = false;
	include 'checkSubdomain.php';
	if ($subdomainFlag) $error.="<b>Сайт с таким именем уже существует!</b><br>";
	
	if (($phone == "") || ($phone == "+996") || (strlen($phone)<6))
        $error.="<b>Номер телефона не введен!</b><br>";
    if ($name_ru == "")
        $error.="<b>Название не введен!</b><br>";
	if (count($infrastructure)==0)
        $error.="<b>Инфраструктура не выбран!</b><br>";
		
     if ($image_url['error'] <= 0) {
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
                    $pic1 = $mainimg;
                }
				MakeStamp('../images/big/'.$photo_url);

                $handle->image_resize = true;
                //$handle->image_ratio_y = true;
				$handle->image_ratio_crop = true;
                $handle->image_x = 455;
                $handle->image_y = 276;
                $handle->file_new_name_body = $newname;
                //$path=substr(date("d.m.Y"),3,2);
                $handle->Process('../images/mainimg/');
                if ($handle->processed) {
                    $pic1 = $handle->file_dst_name;
                } else {
                    $pic1 = $mainimg;
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
                    $pic1 = $mainimg;
                }
            }
			else {$pic1 = $mainimg;}
        }
		else {$pic1 = $mainimg;}
		
		if ($pic1 != $mainimg){
			@unlink('../images/big/'.$mainimg);
			@unlink('../images/thu/'.$mainimg);
			@unlink('../images/mainimg/'.$mainimg);
		}
		
			$update = array(
				"update_date" => $update_date,
				"objectlog" => $objectlog,
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
				"hotelstar" => $hotelstar,
				"main_img" =>  $pic1,
				"tbl"=> $edit_table
        	);
		
        if ($error == "") {
			$db->update(DB_PREFIX . "flats", $update, "flat_id = " . $flat_id);
			$db->delete(DB_PREFIX . "flat_infrastructure", "flat_id = " . $flat_id);
			$db->delete(DB_PREFIX . "orientirdb", "flat_id = " . $flat_id);
			for($i=0; $i<count($infrastructure); $i++){
			$insert = array(
                            "flat_id" => $flat_id,
                            "infrastructure_id" => $infrastructure[$i]
             			);
            $db->insert(DB_PREFIX . "flat_infrastructure", $insert);	
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

$rwFlat = $db->select_one("flats", "flat_id='" . $flat_id . "'", "*", "", "");
{
	$flat_type = $rwFlat['flat_type'];
	$currency = $rwFlat['currency'];
	
    $price = $rwFlat['price'];
    $price_night = $rwFlat['price_night'];
    $price_day = $rwFlat['price_day'];
	
	$price_prepay = $rwFlat['price_prepay'];
    $price_night_prepay = $rwFlat['price_night_prepay'];
    $price_day_prepay = $rwFlat['price_day_prepay'];	
	
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
	$hotelstar = $rwFlat['hotelstar'];
	$tbl = $rwFlat['tbl'];
}
$infrastructuredb = $db->select("flat_infrastructure", "flat_id='".$flat_id."'", "*", "","");
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
            <? } else if (isset($_POST['flat_id'])) {?>

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
                <form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data" name="addnew" id="addnew" onsubmit="copytablevalue()">
                    <input type="hidden" name="flat_type" value="<?=$flat_type;?>"/><!-- FLAT TYPE: KVARTIRA -->
                    <input type="hidden" name="flat_id" value="<?=$flat_id;?>"/><!-- FLAT TYPE: KVARTIRA -->
                    
                    
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
                    <div class="clear"></div><!--.well-->
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
                    <p class="textRed">Информация</p>
                    <div class="well">
                        <p class="star">Количество звёзд: </p>                       
                        <select id="hotelstar" name="hotelstar">
                        	<?php for($i=0; $i<6; $i++){?>
                            <option value="<?=$i?>" <?php if ($i==$hotelstar) echo 'selected';?>><?=$i?></option>
							<?php } ?>
                        </select>
                    </div><!--.well-->
					<div class="clear"></div>
                    <p class="textRed">Информация об отеле на русском языке</p>
                    
                    <div class="well">
                      <p class="star">Название: </p>                       
                        
                        <input type="text" class="priceforlong" name="name_ru"  value="<?=$name_ru;?>"/>
                        <div class="postinput"><b><font color="#FF0000">*</font></b>(обязательно)</div>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Описание отеля: </p>
                        <textarea name="description_ru" class="priceforlong" rows="9" id="description_ru"><?=$description_ru;?></textarea>                       
                    </div><!--.well-->
					<div class="clear"></div>
							<? include('edit_table.php');?>
                    
                    <p class="textRed">Информация об отеле на английском языке (необязательно)</p>
                    
                    <div class="well">
                      <p class="star">Название: </p>                       
                        
                        <input type="text" class="priceforlong" name="name_eng"  value="<?=$name_eng;?>"/>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Описание отеля: </p>
                        <textarea name="description_eng" class="priceforlong" rows="9" id="description_eng"><?=$description_eng;?></textarea>                       
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <p class="textRed">Информация об отеле на кыргызском языке (необязательно)</p>
                    
                    <div class="well">
                      <p class="star">Название: </p>                       
                        
                        <input type="text" class="priceforlong" name="name_native"  value="<?=$name_native;?>"/>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Описание отеля: </p>
                        <textarea name="description_native" class="priceforlong" rows="9" id="description_native"><?=$description_native;?></textarea>                       
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
                    <div class="clear"></div>
				  <p class="textSubjectSmall">Главное Фото</p>
                  <input type="hidden" name="mainimg" id="mainimg" value="<?php echo $rwFlat['main_img']; ?>" >
                  <img src="../images/mainimg/<?php echo $rwFlat['main_img']; ?>" alt="" class="item" width="200px"><br/>
                    
                    <div class="well">                        
                        Сменить главное фото (необязательно): <input type="file" class="longtitude" name="image_url"> 
                        <br/>
                    </div><!--.well--> 
                    <div class="clear"><!--.well-->                  </div>
                  <div class="clear"></div>
                    
                    <hr />
                    <? include 'controlsubdomain.php';?>
                    <div class="well">     
                    
                    <input type="image" id="dobavitkv" src="../images/sitetools/send.png"> <br/>
                    
                    </div>
                  
</form>

</div><!--end main_border-->

<?php
include_once 'footer.php';
?>