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
                        <p style="color:#F00">Если у вас только одна сауна в одном месте, <a href="sauna_single.php" style="color:#03F; text-decoration:underline">вам сюда...</a></p>
                    </div>
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
					<div class="well">					  </div><!--.well-->
					<div class="clear"></div>
				  <p class="textSubjectSmall">Главное Фото <font color="#FF0000">*</font></b>(обязательно) - Минимальное разрешение фотографии должно составлять 720 (ширина) на 477 (высота) пикселей</p>
                    
                    <div class="well">                        
                        <input type="file" class="longtitude" name="image_url"> 
                    </div><!--.well--> 
                    <div class="clear"><!--.well-->                  </div>
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