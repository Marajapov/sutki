<?php
$title = "ДОБАВИТЬ КВАРТИРУ";
$active = "7";
include_once 'header.php';

global $action, $isWhat, $edit;
$edit = false;
$action = get_request('a');
$error = "";
switch ($action) {
    case "add":
        $isWhat = "add";
        $form_action = "?a=add";
        break;
    default:
        $isWhat = "";
        $form_action = "?a=add";
        break;
        break;
}


// ADD NEW INSERT*****************************************************************************************************************
if ($isWhat == "add") {
    $error = "";

    echo $_POST['perpage'];

    $room_type_id = $_POST['cbxRoom'];
    $region_id = $_POST['cbxRegion'];
    $flat_type = $_POST['cbxType'];

    $address = $_POST['address'];
    $floor = $_POST['floor'];

    $price_hour = $_POST['price_hour'];
    $price_night = $_POST['price_night'];
    $price_day = $_POST['price_day'];
    $description = $_POST['description'];
    $bed = $_POST['bed'];
    $reserved = 0;
    $special = 0;

    $author = $_POST['author'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];

    $new = 1;
    $image_url = $_FILES['image_url'];
    $create_date = date("Y-m-d H:m:s");
    $status = ($_POST['status'] == "1") ? 1 : 0;
    $pic1 = "";

    if ($author == "")
        $error.="<b>Имя пользователя!</b><br>";
    if ($phone_number == "")
        $error.="<b>Номер телефона не введен!</b><br>";
   
    if ($address == "")
        $error.="<b>Адрес не введен!</b><br>";
    if ($description == "")
        $error.="<b>Описание не введено!</b><br>";

    if ($error == "") {
        if ($image_url['error'] <= 0) {
            $handle = new Upload($image_url);
            $newname = time();
            if ($handle->uploaded) {
                $handle->image_resize = true;
                $handle->image_ratio_y = true;
                $handle->image_x = 800;
                $handle->file_new_name_body = $newname;
                //$path=substr(date("d.m.Y"),3,2);
                $handle->Process('media/open/');
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
                $handle->Process('media/big/');
                if ($handle->processed) {
                    $pic1 = $handle->file_dst_name;
                } else {
                    $error.=$handle->error . '';
                }

                $handle->image_resize = true;
                //$handle->image_ratio_y = true;
                $handle->image_x = 294;
                $handle->image_y = 178;
                $handle->file_new_name_body = $newname;
                //$path=substr(date("d.m.Y"),3,2);
                $handle->Process('media/items/');
                if ($handle->processed) {
                    $pic1 = $handle->file_dst_name;
                } else {
                    $error.=$handle->error . '';
                }
            }
        }

        $insert = array(
            "room_type_id" => $room_type_id,
            "address" => $address,
            "floor" => $floor,
            "region_id" => $region_id,
            "price_hour" => $price_hour,
            "price_night" => $price_night,
            "price_day" => $price_day,
            "description" => $description,
            "flat_type" => $flat_type,
            "bed" => $bed,
            "reserved" => $reserved,
            "onMap" => $onMap,
            "count" => $count,
            "author" => $author,
            "phone_number" => $phone_number,
            "email" => $email,
            "image_url" => $pic1,
            "special" => $special,
            "new" => $new,
            "status" => $status,
            "create_date" => $create_date
        );
        $db->insert("flats", $insert);
        //$db->debug();
        $rwFlat = $db->select_one("flats", "create_date='" . $create_date . "' AND address='" . $address . "' AND region_id='" . $region_id . "' AND author='" . $author . "'", "*", " ORDER BY flat_id DESC", "0,1");
        //$db->debug();
        //exit(0);
        $flat_id = $rwFlat["flat_id"];
        //echo $flat_id;
        // exit(0);
        if ($flat_id > 0) {
            for ($i = 1; $i < 6; $i++) {
                $strPic = $_FILES['photo' . $i];
                if (isset($strPic)) {
                    $handle = new Upload($strPic);
                    if ($handle->uploaded) {
                        $time = time();
                        $handle->image_resize = true;
                        $handle->image_ratio_y = true;
                        $handle->image_x = 800;
                        $handle->file_new_name_body = $time;
                        $handle->Process('media/open/');
                        if ($handle->processed) {
                            $photo_url = $handle->file_dst_name;
                        } else {
                            $error.=$handle->error . '';
                        }

                        $handle->image_resize = true;
                        $handle->image_x = 95;
                        $handle->image_y = 63;
                        $handle->file_new_name_body = $time;
                        $handle->Process('media/thumb/');
                        if ($handle->processed) {
                            $photo_url = $handle->file_dst_name;
                        } else {
                            $error.=$handle->error . '';
                        }

                        $insert = array(
                            "flat_id" => $flat_id,
                            "image_url" => $photo_url
                        );
                        $db->insert(DB_PREFIX . "photos", $insert);
                    }
                }
            }
        }
    }
    if ($error == "") {
        //echo '<div id="msgerror">' . $error . '</div>';
        redirect("success.php", "js");
    }
}
?>
<div class="clear"></div> 
<div id="itemsTopSpace"></div>
<div id="itemsTop"></div>

<div id="items">
    <div id="detail">
        <div id="uslugi">
            <?php
            if ($error) {
                echo '<div class="errorSummary1">' . $error . '</div>';
            }
            ?>  
            <div class="clear"></div>
            <h2 class="textRedH2">ДОБАВИТЬ КВАРТИРУ</h2>
            <ul>
                <li>- Внимательно заполняйте все поля.</li>
                <li>- Прикрепите качественные фотографий квартиры.</li>
                <li>- Объязательно пишите точную контактную информацию.</li>
                <li>- Размещение на нашем сайте <a href="#" id="platnoe">бесплатное</a></li>
                <li>- Квартира будет опубликована только после проверки модератором!</li>
            </ul>

            <div id="add">
                <form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data" name="addnew" id="addnew">
                    <p class="textRed">Контактная информация</p>
                    <div class="well">
                        <p class="star">Имя пользователя <p class="textRedP star">*</p></p>&nbsp;&nbsp;                        
                        <input type="text" id="fio" name="author" style="width:200px;"/>
                    </div><!--.well-->


                    <div class="well">
                        <p class="star">Номер телефона <p class="textRedP star">*</p></p> &nbsp;&nbsp; +996 &nbsp;&nbsp;                        
                        <input type="text" id="fio" name="phone_number" style="width:200px;"/>
                    </div><!--.well-->



                    <div class="well">
                        Номер телефона: &nbsp;&nbsp; +996  &nbsp;&nbsp;
                        <input type="text" id="email" name="email" style="width:200px;"/>
                        <div class="clear"></div>                                               
                    </div><!--.well--> 

                    <div class="well">
                        <div class="priceforing">Тип квартиры</div>
                        <?php
                        echo '<select name="cbxType" class="pricefor">';
                        foreach ($arrType as $key => $value) {
                            echo '<option value="' . $key . '" ';
                            echo ' >' . $value . '</option>';
                        }
                        echo '</select>';
                        ?>                            
                    </div><!--.well-->
                    <div class="clear"></div>
                    <div class="well">
                        <div class="priceforing">Цена за час:</div>                        
                        <input type="text" class="pricefor" name="price_hour"/>&nbsp;&nbsp;<p class="star">сом</p>
                    </div><!--.well--> 
                    <div class="clear"></div> 
                    <div class="well">
                        <div class="priceforing">Цена за ночь:</div>                        
                        <input type="text" class="pricefor" name="price_night"/>&nbsp;&nbsp;<p class="star">сом</p>
                    </div><!--.well-->
                    <div class="clear"></div>
                    <div class="well">
                        <div class="priceforing">Цена за сутки:</div>                        
                        <input type="text" class="pricefor" name="price_day"/>&nbsp;&nbsp;<p class="star">сом</p>
                    </div><!--.well-->     
                    <div class="clear"></div>
                    <div class="well">
                        <div class="priceforing">Комнаты</div>  
                        <?php
                        $rwRooms = $db->select("rooms", "", "*", "ORDER BY room_type ASC");
                        $db->debug();
                        echo '<select name="cbxRoom" class="pricefor">';
                        foreach ($rwRooms as $room) {
                            echo '<option value="' . $room["room_type"] . '" ';
                            if ($room['room_type'] == $room_id)
                                echo 'selected';
                            echo ' >' . $room['room_type'] . '</option>';
                        }
                        echo '</select>';
                        ?>                              
                    </div><!--.well-->
                    <div class="clear"></div>
                    <div class="well">
                        <div class="priceforing">Тип строения</div> 

                        <?php
                        echo '<select name="floor" class="pricefor">';
                        foreach ($arrSeria as $key => $value) {
                            echo '<option value="' . $key . '" ';
                            echo ' >' . $value . '</option>';
                        }
                        echo '</select>';
                        ?>        
                        <?php // 
                        /*echo '<select class="pricefor" name="floor">';
                        for ($i = 1; $i <= 20; $i++) {
                            echo '<option value="' . $i . '"';
                            if ($floor == $i)
                                echo 'selected';
                            echo ' >' . $i . '</option>';
                        }
                        echo '</select>';*/
                        ?> 
                    </div><!--.well-->
                    <div class="clear"></div>
                    <div class="well">
                        <div class="priceforing ">Район</div>

<?php
$rwRegions = $db->select("regions", "", "*", "ORDER BY region_id ASC");
$db->debug();
echo '<select name="cbxRegion" class="pricefor longtitude">';
foreach ($rwRegions as $region) {
    echo '<option value="' . $region["region_id"] . '" ';
    if ($region['region_id'] == $region_id)
        echo 'selected';
    echo ' >' . $region['region_title'] . '</option>';
}
echo '</select>';
?>                      
                    </div><!--.well-->
                    <div class="clear"></div>
                    <div class="well">
                        <p class="priceforing">Адрес</p>                         
                        <input type="text" class="pricefor longtitude" name="address" /> 
                    </div><!--.well--> 
                    <div class="clear"></div>
                    
                     <div class="well">
                        <p class="priceforing">&nbsp;</p>                         
                      
                        Укажите точный адрес. Например : Боконбаева 154
                    </div><!--.well--> 
                    <div class="clear"></div>
                    
                    
                    <div class="well">
                        <p class="priceforing">Спальные места</p>                         

<?php
echo '<select class="pricefor" name="bed">';
for ($i = 1; $i <= 20; $i++) {
    echo '<option value="' . $i . '"';
    if ($floor == $i)
        echo 'selected';
    echo ' >' . $i . '</option>';
}
echo '</select>';
?>                  
                    </div><!--.well-->
                    <div class="clear"></div>

                    <p class="textRed">Описание квартиры</p>
                    <textarea name="description" cols="58" rows="6" id="description"></textarea>
                    <div class="clear"></div>

                    <p class="textRed">Фото</p>
                    <p style="line-height: 16px;">
                        Если Вы являетесь собственником квартиры в Бишкеке и хотели бы сдавать свою квартиру в посуточную аренду мы готовы к сотрудничеству с Вами на взаимовыгодной основе. Наш фотограф выедет к Вам и бесплатно сделает фото Вашей квартиры и они будут размещены на страницах нашего сайта и/или в базе данных объектов.
                    </p>
                    <br/>
                    <p style="line-height: 16px;">
                        Если Вы сдаете свою квартиру в посуточную аренду впервые, целесообразно воспользоваться услугами нашего дизайнера для достижения максимального эффекта от сдачи Вашей квартиры в аренду. Даже если Вы ранее сдавали квартиру на длительный срок, консультация может быть Вам полезна, так как требования к посуточной аренде отличаются от долгосрочной сдачи. Даже банальная переклейка обоев и расстановка мебели может произвести значительный эффект. Стоимость первоначальной консультации дизайнера с выездом на объект и определением объема работ - 200 сом.
                    </p>
                    <br/>
                    <p style="line-height: 16px;">
                        Ввиду острого дефицита гостиничных номеров в Бишкеке доход от сдачи квартиры в краткосрочную аренду оказывается, как правило, значительно выше дохода, полученного от длительной аренды, а сохранность квартиры намного лучше.
                    </p>
                    <br/>
                    <div class="well">
                        <p class="priceforing">Главное Фото</p>
                        <div class="clear"></div>
                        </br>                         
                        <input type="file" class="longtitude" name="image_url"> 
                    </div><!--.well--> 
                    <div class="clear"></div>

                    <div class="well">
                        <p class="priceforing">Дополнительные Фото</p>
                        <div class="clear"></div>
                        </br> 

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
                    </div><!--.well--> 
                    <div class="clear"></div>

                    <input type="image" id="dobavitkv" src="images/dobavit.png">
                </form>
                <p>После добавления квартиры Звоните по телефону (0552) 895 335, (0702) 895 335, (0502) 895 335</p>
            </div><!--#add-->
        </div><!--#uslugi-->

    </div><!--#detail-->

    <div id="rightbar">
<?php
include_once 'inc_special.php';
?>
    </div><!--#rightbar-->
    <div class="clear"></div>
</div><!--#items-->

<?php
include_once 'footer.php';
?>