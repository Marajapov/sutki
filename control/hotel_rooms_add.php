<?php
include_once 'usercontrol.php';
$userid = $_SESSION['userid'];
$flat_id = $_REQUEST['flat_id'];
require 'flatcontrol.php';

if (isset($_POST["flat_id"])) {
    $error = "";
	
	$currency = (int)getpost('currency');
	
    $price = (int)getpost('price');
    $price_night = (int)getpost('price_night');
    $price_day = (int)getpost('price_day');
	
	$price_prepay = (int)getpost('price_prepay');
    $price_night_prepay = (int)getpost('price_night_prepay');
    $price_day_prepay = (int)getpost('price_day_prepay');
		
	$price_universal = ($currency==1)?$price_night*50:$price_night;
	
	$discount = (int)getpost('discount');
    $discount_date = getpost('discount_date');
	$discount_date_from = getpost('discount_date_from');
	if ($discount_date=="") $discount_date = "0000-00-00";
	if ($discount_date_from=="") $discount_date_from = "0000-00-00";
	
	$name_ru = getpost('name_ru');
	$name_eng = getpost('name_eng');
	$name_native = getpost('name_native');
    $description_ru = getpost('description_ru');
	$description_eng = getpost('description_eng');
	$description_native = getpost('description_native');
	
	$wifi = (int)getpost('wifi');
	$room = (int)getpost('room');
	$bed = (int)getpost('bed');

	$inventory = $_POST['inventory'];
	$new_table = $_POST['newtablehidden'];

    $update_date = date("Y-m-d H:m:s");
    $error = "";

    if ($price_day == "")
        $error.="<b>Цена за сутки не введен!</b><br>";
	if (count($inventory)==0)
        $error.="<b>Инвентарь не выбран!</b><br>";
	if ($name_ru == "")
        $error.="<b>Название не введен!</b><br>";
		
    if ($error == "") {
			$insert = array(
				"user_id" => $userid,
				"flat_id" => $flat_id,
				"update_date" => $update_date,
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
				"name_ru" => $name_ru,
				"name_eng" => $name_eng,
				"name_native" => $name_native,
				"description_ru" => $description_ru,
				"description_eng" => $description_eng,
				"description_native" => $description_native,
				"wifi" => $wifi,
				"room" => $room,
				"bed" => $bed,
				"tbl" => $new_table
        	);
		
        $db->insert("rooms", $insert);

        $rwFlat = $db->select_one("rooms", "update_date='" . $update_date . "' AND flat_id='" . $flat_id . "'", "*", " ORDER BY room_id DESC", "0,1");

        $room_id = $rwFlat["room_id"];

		for($i=0; $i<count($inventory); $i++){
			$insert = array(
                            "flat_id" => $flat_id,
							"room_id" => $room_id,
                            "inventory_id" => $inventory[$i]
             );
            $db->insert(DB_PREFIX . "flat_inventory", $insert);	
		}
		
		
        if ($flat_id > 0) {
            for ($i = 1; $i < 11; $i++) {
                $strPic = $_FILES['photo' . $i];
                if (isset($strPic)) {
                    $handle = new Upload($strPic);
                    if ($handle->uploaded) {
                        $time = time();
                        $handle->image_resize = true;
                        $handle->image_ratio_y = true;
                        $handle->image_x = 800;
                        $handle->file_new_name_body = $time;
                        $handle->Process('../images/big/');
                        if ($handle->processed) {
                            $photo_url = $handle->file_dst_name;
                        } else {
                            continue;
                        }

                        $handle->image_resize = true;
						$handle->image_ratio_crop = true;
                        $handle->image_x = 230;
                        $handle->image_y = 170;
                        $handle->file_new_name_body = $time;
                        $handle->Process('../images/thu/');
                        if ($handle->processed) {
                            $photo_url = $handle->file_dst_name;
                        } else {
							@unlink('../images/big/'.$time);
                            continue;
                        }

                        $insert = array(
                            "flat_id" => $flat_id,
							"room_id" => $room_id,
                            "image_url" => $photo_url
                        );
                        if (!$db->insert(DB_PREFIX . "photos", $insert)) $error .= "Ошибка! (Фотографии)";
                    }
                }
            }
        }
    }
    if ($error == "") {
        //echo '<div id="msgerror">' . $error . '</div>';
        redirect("hotel_rooms.php?flat_id=".$flat_id, "js");
    }
}
$rwFlat = $db->select_one("flats", "flat_id='" . $flat_id . "'", "name_ru", "", "");
$flat_name_ru = $rwFlat['name_ru'];
$title = $flat_name_ru." &raquo; ДОБАВИТЬ НОМЕР ";

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
                <li>- Прикрепите качественные фотографий объекта.</li>
            </ul>
            </div>
            <div class="clear"></div>

                <form action="hotel_rooms_add.php" method="post" enctype="multipart/form-data" name="addnew" id="addnew" onsubmit="copytablevalues()">
                    <input type="hidden" name="flat_id" value="<?=$flat_id;?>"/>
                    <p class="textRed">Информация на русском языке</p>
                    
                    <div class="well">
                      <p class="star">Название: </p>                       
                        
                        <input type="text" class="priceforlong" name="name_ru"  value="<?=$name_ru;?>"/>
                        <div class="postinput"><b><font color="#FF0000">*</font></b>(обязательно)</div>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                      <p class="star">Информация: </p>
                        <textarea name="description_ru" class="priceforlongwys" rows="14" id="wysiwyg"><?=$description_ru;?></textarea>                       
                    </div><!--.well-->
					<div class="clear"></div>
                     <? include('buildtable.php'); ?>
                    
                    <p class="textRed">Информация на английском языке (необязательно)</p>
                    
                    <div class="well">
                      <p class="star">Название: </p>                       
                        
                        <input type="text" class="priceforlong" name="name_eng"  value="<?=$name_eng;?>"/>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Информация: </p>
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
                        <p class="star">Информация: </p>
                        <textarea name="description_native" class="priceforlong" rows="6" id="description_native"><?=$description_native;?></textarea>                       
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
                        <div class="priceforing">Цена за час (при предоплате):</div>                        
                        <input type="text" class="pricefor" name="price_prepay" value="<?=$price_prepay;?>"/>
                    </div><!--.well--> 
                    <div class="clear"></div>
                    
                    <div class="well">
                        <div class="priceforing">Цена за ночь:</div>                        
                        <input type="text" class="pricefor" name="price_night" value="<?=$price_night;?>"/>
                        
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
                        <div class="postinput"><b><font color="#FF0000">*</font></b>(обязательно)</div>
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

                    
                    
				  <p class="textRed">Параметры номера:</p>
                    
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
                    
					<div class="clear"></div><!--.well-->

				   <p class="textRed">Инвентарь:<font color="#FF0000">*</font>(обязательно)</p>
                    <div class="well">                        
                       <?php
                        $rwInv = $db->select("inventory", "flat_type like '0' OR flat_type like '%3%'", "*", "");
                        foreach ($rwInv as $inv) {?>
                            <div style="width:350px;float:left">
                            <input type="checkbox" value="<?=$inv["inventory_id"];?>" <? 
							for ($i=0; $i<count($inventory); $i++) if ($inventory[$i]==$inv["inventory_id"]){
									echo 'checked="checked"'; break;
								}
							?> name="inventory[]"/> <?=$inv["inventory"];?> &nbsp;&nbsp;
                            </div>
                        <? } ?> 
                    </div><!--.well-->
                    <div class="clear"></div>

                  <p class="textRed">Фото</p>

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
                    <div class="well">     
                    
                    <input type="image" id="dobavitkv" src="../images/sitetools/send.png">
                    </div>
                  
</form>

</div><!--end main_border-->

<?php
include_once 'footer.php';
?>