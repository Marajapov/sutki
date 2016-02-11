<?php
require_once 'header.php';

global $action, $isWhat, $edit;
$edit = false;
$action = get_request('a');
$error = "";
switch ($action) {
    case "add":
        $isWhat = "add";
        $form_action = "?a=add";
        break;
    case "edit":
        $isWhat = "edit";
        $form_action = "?a=update&flat_id=" . get_request('flat_id');
        $edit = true;
        break;
    case "update":
        $isWhat = "update";
        $form_action = "?a=add";
        break;
    case "delete":
        $isWhat = "delete";
        $form_action = "?a=add";
        break;
    case "publish":
        $isWhat = "publish";
        $form_action = "?a=add";
        break;
    case "reserved":
        $isWhat = "reserved";
        $form_action = "?a=add";
        break;
    case "special":
        $isWhat = "special";
        $form_action = "?a=add";
        break;
    case "special1":
        $isWhat = "special1";
        $form_action = "?a=add";
        break;
    case "order":
        $isWhat = "order";
        $form_action = "?a=add";
        break;
    default:
        $isWhat = "";
        $form_action = "?a=add";
        break;
        break;
}

// EDIT*********************************************************************************************************************************
if ($isWhat == "edit") {
    $flat_id = $_GET['flat_id'];

    if ($flat_id != "") {
        $rw = $db->select_one(DB_PREFIX . "flats", "flat_id=" . $flat_id);
        $flat_type = $rw['flat_type'];
        $room_type = $rw['room_type'];
        $room_type_ided = $rw['room_type_id'];
        $image_url = $rw['image_url'];
        $address = $rw['address'];
        $floor = $rw['floor'];
        $region_id = $rw['region_id'];
        $price_hour = $rw['price_hour'];
        $price_night = $rw['price_night'];
        $price_day = $rw['price_day'];
        $description = $rw['description'];
        $bed = $rw['bed'];
        $reserved = $rw['reserved'];
        $onMap = $rw['onMap'];
        $count = $rw['count'];
        $author = $rw['author'];
        $phone_number = $rw['phone_number'];
        $email = $rw['email'];

        $create_date = $rw['create_date'];
        $status = $rw['status'];
        $new = $rw['new'];
        $flat_id = $rw['flat_id'];
    } else {
        $error = 'No Data';
    }
}

// DELETE************************************************************************************************************************
if ($isWhat == "delete") {
    $flat_id = $_GET['flat_id'];
    $rw = $db->select_one(DB_PREFIX . "flats", "flat_id=" . $flat_id);
    //echo var_dump($rw);
    if ($rw["image_url"] != "") {
        deleteFile("../media/thumb/" . $rw["image_url"]);
        deleteFile("../media/big/" . $rw["image_url"]);
        deleteFile("../media/open/" . $rw["image_url"]);
        deleteFile("../media/items/" . $rw["image_url"]);
    }

    $rw_photos = $db->select(DB_PREFIX . "photos", "flat_id=" . $flat_id, "*");
    foreach ($rw_photos as $rw_photo) {
        if ($rw_photo["image_url"] != "") {
            deleteFile("../media/thumb/" . $rw_photo["image_url"]);
            deleteFile("../media/open/" . $rw_photo["image_url"]);
        }
        $db->delete(DB_PREFIX . "photos", "flat_id = " . $rw_photo["flat_id"]);
    }


    $db->delete(DB_PREFIX . "flats", "flat_id = " . $flat_id);
}

// SET ORDER STATUS ************************************************************************************************************
if ($isWhat == "order") {
    //$results = $db->select("flats", "", "flat_id", "ORDER BY flat_id DESC");

    $flat_id = $_GET['id'];
    $order = $_POST['txt_' . $flat_id];
    $update = array(
        "sortby" => $order
    );
    $db->update("flats", $update, "flat_id= " . $flat_id);
}



// PUBLISH UNPUBLISH************************************************************************************************************
if ($isWhat == "publish") {
    $flat_id = $_GET['flat_id'];
    $status = $_GET['status'];
    $update = array(
        "status" => $status,
        "new" => 0
    );
    $db->update(DB_PREFIX . "flats", $update, "flat_id = " . $flat_id);
}

// RESERVED UNRESERVED************************************************************************************************************
if ($isWhat == "reserved") {
    $flat_id = $_GET['flat_id'];
    $reserved = $_GET['reserved'];
    $update = array(
        "reserved" => $reserved,
        "new" => 0
    );
    $db->update(DB_PREFIX . "flats", $update, "flat_id = " . $flat_id);
}
// SPECIAL NONSPECIAL************************************************************************************************************
if ($isWhat == "special") {
    $flat_id = $_GET['flat_id'];
    $special = $_GET['special'];
    $update = array(
        "special" => $special,
        "new" => 0
    );
    $db->update(DB_PREFIX . "flats", $update, "flat_id = " . $flat_id);
}
// SPECIAL1 NONSPECIAL1************************************************************************************************************
if ($isWhat == "special1") {
    $flat_id = $_GET['flat_id'];
    $special1 = $_GET['special1'];
    $update = array(
        "special1" => $special1,
        "new" => 0
    );
    $db->update(DB_PREFIX . "flats", $update, "flat_id = " . $flat_id);
}

// ADD NEW INSERT*****************************************************************************************************************
if ($isWhat == "add") {
    $error = "";

    echo $_POST['perpage'];

    $room_type_id = $_POST['cbxRoom'];
    $region_id = $_POST['cbxRegion'];
    $flat_type = $_POST['cbxFlatType'];
    $address = $_POST['address'];
    $floor = $_POST['floor'];

    $price_hour = $_POST['price_hour'];
    $price_night = $_POST['price_night'];
    $price_day = $_POST['price_day'];
    $description = $_POST['description'];
    $bed = $_POST['bed'];
    $reserved = 0;
    $special = 0;
    $special1 = 0;

    $author = $_POST['author'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];

    $new = 1;
    $image_url = $_FILES['image_url'];
    $create_date = date("Y-m-d H:m:s");
    $status = ($_POST['status'] == "1") ? 1 : 0;
    $pic1 = "";

    if ($floor == "")
        $error.="<b>Floor is empty!</b><br>";

    if ($error == "") {
        if ($image_url['error'] <= 0) {
            $handle = new Upload($image_url);
            $newname = time();
            if ($handle->uploaded) {
                $handle->image_resize = true;
                $handle->image_ratio_y = true;
                $handle->image_x = 800;
                $handle->file_new_name_body = $newname;
                $handle->image_watermark = '../media/logo.png';
                $handle->image_watermark_x = 20;
                $handle->image_watermark_y = 20;
                $handle->image_watermark_no_zoom_in = true;
                //$path=substr(date("d.m.Y"),3,2);
                $handle->Process('../media/open/');
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
                $handle->image_watermark = '../media/logo.png';
                $handle->image_watermark_x = 10;
                $handle->image_watermark_y = 10;
                $handle->image_watermark_no_zoom_in = true;
                //$path=substr(date("d.m.Y"),3,2);
                $handle->Process('../media/big/');
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
                $handle->Process('../media/items/');
                if ($handle->processed) {
                    $pic1 = $handle->file_dst_name;
                } else {
                    $error.=$handle->error . '';
                }

//                $handle->image_resize = true;
//                //$handle->image_ratio_y = true;
//                $handle->image_x = 95;
//                $handle->image_y = 72;
//                $handle->file_new_name_body = $newname;
//                $handle->Process('../media/thumb/');
//                if ($handle->processed) {
//                    $pic1 = $handle->file_dst_name;
//                } else {
//                    $error.=$handle->error . '';
//                }
            }
        }


        $insert = array(
            "room_type_id" => $room_type_id,
            "flat_type" => $flat_type,
            "address" => $address,
            "floor" => $floor,
            "region_id" => $region_id,
            "price_hour" => $price_hour,
            "price_night" => $price_night,
            "price_day" => $price_day,
            "description" => $description,
            "bed" => $bed,
            "reserved" => $reserved,
            "onMap" => $onMap,
            "count" => $count,
            "author" => $author,
            "phone_number" => $phone_number,
            "email" => $email,
            "image_url" => $pic1,
            "special" => $special,
            "special1" => $special1,
            "new" => $new,
            "status" => $status,
        );
        $db->insert("flats", $insert);
        //$db->debug();
    }
}

//UPDATE*********************************************************************************************************
if ($isWhat == "update") {
    $error = "";
    $flat_id = get_request('flat_id');
    if ($flat_id == "")
        $error.="<b>ID is empty!</b><br>";

    $flat_type = $_POST['cbxFlatType'];
    $room_type_id = $_POST['cbxRoom'];
    $region_id = $_POST['cbxRegion'];

    $address = $_POST['address'];
    $floor = $_POST['floor'];

    $price_hour = $_POST['price_hour'];
    $price_night = $_POST['price_night'];
    $price_day = $_POST['price_day'];
    $description = $_POST['description'];
    $bed = $_POST['bed'];
    $reserved = $_POST['reserved'];
    $onMap = $_POST['onMap'];
    $count = $_POST['count'];
    $author = $_POST['author'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];

    $new = ($_POST['new'] == "1") ? 1 : 0;
    $image_url = $_FILES['image_url'];
    $create_date = date("Y-m-d H:m:s");
    $status = ($_POST['status'] == "1") ? 1 : 0;
    $hd_image_url = $_POST['hd_image_url'];
    $pic1 = "";


    if ($image_url == "")
        $error.="<b>Фотография не существует!</b><br>";

    if ($error == "") {
        if ($image_url['error'] <= 0) {

            $handle = new Upload($image_url);
            $newname = time();
            if ($handle->uploaded) {
                $handle->image_resize = true;
                $handle->image_ratio_y = true;
                $handle->image_x = 800;
                $handle->file_new_name_body = $newname;
                $handle->image_watermark = '../media/logo.png';
                $handle->image_watermark_x = 20;
                $handle->image_watermark_y = 20;
                $handle->image_watermark_no_zoom_in = true;
                //$path=substr(date("d.m.Y"),3,2);
                $handle->Process('../media/open/');
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
                $handle->image_watermark = '../media/logo.png';
                $handle->image_watermark_x = 10;
                $handle->image_watermark_y = 10;
                $handle->image_watermark_no_zoom_in = true;
                //$path=substr(date("d.m.Y"),3,2);
                $handle->Process('../media/big/');
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
                $handle->Process('../media/items/');
                if ($handle->processed) {
                    $pic1 = $handle->file_dst_name;
                } else {
                    $error.=$handle->error . '';
                }

                if ($hd_image_url != "") {
                    deleteFile("../media/big/" . $hd_image_url);
                    deleteFile("../media/items/" . $hd_image_url);
                }
            }
        } else {
            $pic1 = $hd_image_url;
            if ($_POST["delete_image1"] > 0) {
                deleteFile("../media/big/" . $hd_image_url);
                deleteFile("../media/items/" . $hd_image_url);
                $pic1 = "";
            }
        }


        $update = array(
            "room_type_id" => $room_type_id,
            "flat_type" => $flat_type,
            "address" => $address,
            "floor" => $floor,
            "region_id" => $region_id,
            "price_hour" => $price_hour,
            "price_night" => $price_night,
            "price_day" => $price_day,
            "description" => $description,
            "bed" => $bed,
            "reserved" => $reserved,
            "onMap" => $onMap,
            "count" => $count,
            "author" => $author,
            "phone_number" => $phone_number,
            "email" => $email,
            "image_url" => $pic1,
            "new" => 0,
            "status" => $status,
        );
        $db->update(DB_PREFIX . "flats", $update, "flat_id = " . $flat_id);
    }
    redirect("flats.php#" . $flat_id, "js");
}

if ($error != "")
    echo '<div class="msgerror">' . $error . '</div>';
?>

<div class="clsFooter" style="display: none; height: 600px; width: 1100px; background-color: #E7ECF1; position: absolute; z-index: 999; text-align: center;">        
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <span style="color: red;"><b>Подождите, пожалуйста....</b></span>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    &nbsp;
</div> 

<form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data" name="addnew" id="addnew">
    <table cellpadding="0" cellspacing="0" border="0" style="height: 30px;">
        <tr>
            <td><input id="btnAddNew" value=" Добавить Новую Квартиру " onclick="showDiv('dvForm');" type="button" style="display: <?php echo $edit ? 'none' : 'block'; ?>;" /></td>
            <td></td>
        </tr>
    </table> 

    <div id="dvForm"  class="dvForm" style="display: <?php echo $edit ? 'block' : 'none'; ?>;">

        <div id="dvFormHeader"><b><?php echo $edit ? 'Редактировать' : 'Добавить Новую'; ?></b></div>   

        <table cellspacing="2" cellpadding="2" style="width: 100%;">  
            <tr><td  style="text-align: right;">Тип:</td>
                <td>

                    <?php
                    echo '<select name="cbxFlatType" id="cbxFlatType">';
                    foreach ($arrType as $key => $value) {
                        echo '<option value="' . $key . '" ';
                        if ($key == $flat_type)
                            echo ' selected';
                        echo ' >' . $value . '</option>';
                    }
                    echo '</select>';
                    ?>   
                </td></tr>
            <tr><td  style="width:120px; text-align: right;" style="text-align: right;">Комнаты:</td>
                <td>
                    <?php
                    $rwRooms = $db->select("rooms", "", "*", "ORDER BY room_type ASC");
//echo var_dump($rwCategories);
                    $db->debug();
                    echo '<select name="cbxRoom" id="cbxRoom">';
                    foreach ($rwRooms as $room) {
                        echo '<option value="' . $room["room_type"] . '" ';
                        if ((int) $room['room_type'] == $room_type_ided)
                            echo 'selected';
                        echo ' >' . $room['room_type'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                    &nbsp;&nbsp;                   
                </td></tr>

            <tr><td  style="width:120px; text-align: right;" style="text-align: right;">Район:</td>
                <td>
                    <?php
                    $rwRegions = $db->select("regions", "", "*", "ORDER BY region_id ASC");
//echo var_dump($rwCategories);
                    $db->debug();

                    echo '<select name="cbxRegion" id="cbxRegion">';
                    foreach ($rwRegions as $region) {
                        echo '<option value="' . $region["region_id"] . '" ';
                        if ($region['region_id'] == $region_id)
                            echo 'selected';
                        echo ' >' . $region['region_title'] . '</option>';
                    }
                    echo '</select>';
                    ?>
                    &nbsp;&nbsp;                   
                </td></tr>    

            <tr><td  style="text-align: right;">Адресс:</td>
                <td><input size="50" name="address"  value="<?php echo $edit ? $address : ''; ?>"/></td></tr>
            <tr><td  style="text-align: right;">Тип строения:</td>
                <td>

                    <?php
                    echo '<select name="floor" class="pricefor">';
                    foreach ($arrSeria as $key => $value) {
                        echo '<option value="' . $key . '" ';
                        if ($key == $floor)
                            echo ' selected';
                        echo ' >' . $value . '</option>';
                    }
                    echo '</select>';
                    ?>    


                </td></tr>

            <tr><td  style="text-align: right;">Цена за час:</td>
                <td><input size="50" name="price_hour"  value="<?php echo $edit ? $price_hour : ''; ?>"/></td></tr>
            <tr><td  style="text-align: right;">Цена за ночь:</td>
                <td><input size="50" name="price_night"  value="<?php echo $edit ? $price_night : ''; ?>"/></td></tr>
            <tr><td  style="text-align: right;">Цена за сутки:</td>
                <td><input size="50" name="price_day"  value="<?php echo $edit ? $price_day : ''; ?>"/></td></tr>                
            <tr><td  style="text-align: right;">Описание:</td>
                <td>
                    <textarea name="description" cols="40" rows="3" id="description"><?php echo $edit ? $description : ''; ?></textarea>
                </td></tr>  
            <tr><td  style="text-align: right;">Спальные места:</td>
                <td>
                    <input size="50" name="bed" value="<?php echo $edit ? $bed : ''; ?>"/>
                </td></tr>                                                                                            

            <tr><td  style="text-align: right;">Имя пользователя :</td>
                <td><input size="50" name="author"  value="<?php echo $edit ? $author : ''; ?>"/></td></tr>

            <tr><td  style="text-align: right;">Номер телефона:</td>
                <td><input size="50" name="phone_number"  value="<?php echo $edit ? $phone_number : ''; ?>"/></td></tr>

            <tr><td  style="text-align: right;">Номер телефона:</td>
                <td><input size="50" name="email"  value="<?php echo $edit ? $email : ''; ?>"/></td></tr>

            <tr><td style="text-align: right;">Главная картинка:</td>
                <td><input type="file" name="image_url"/> <?php
                    if ($edit && $image_url != "") {
                        ;
                        ?>&nbsp;&nbsp;Удалить <input type="checkbox" name="delete_image1" value="1"><img src="../media/items/<?php echo $image_url; ?>" width="50" alt=""> <input type="hidden" name="hd_image_url" value="<?php echo $image_url; ?>">  <?php } ?>
                </td></tr>

            <tr><td style="text-align: right;">Статус</td><td>
                    <input type="checkbox" value="1" name="status" <?php echo ($edit && !$status) ? '' : 'checked="true"'; ?>/>
                </td></tr>
        </table>                              
        <div id="dvFormFooter" class="clsSubmitForm">         
            <input type="button" onclick="submitForm();" id="btnSend" value="<?php echo $edit ? "Обновить" : "   Добавить  "; ?>"/>        
            <input type="button" value="  Отмена  "  onclick="<?php echo $edit ? "gotURL();" : "hideDiv('dvForm');" ?>" /> 
        </div>            
    </div>
    <div class="clear" style="height:20px;"></div>
</form>

<script type="text/javascript">
    function submitForm() {
        $('.clsFooter').css('display','block');
        $('.clsSubmitForm').css('display','none');   
        $('#addnew').submit();
    }
</script>


<?php
if (isset($_GET['p'])) {
    $start = $_GET['p'];
} else {
    $start = 0;
}
$perpage = 30;

$ID = 0;
$flat_type = 99;
$roomID = 0;
$regionID = 0;
$priceID = "";
$priceFrom = 0;
$priceTo = 0;

//$flat_type = 
if (isset($_GET["flatType"]))
    $flat_type = get_request("flatType");
//echo $flat_type;
$ID = (int) get_request("ID2");
$roomID = (int) get_request("cbxRoom2");
$regionID = (int) get_request("cbxRegion2");
$priceID = get_request("cbxPrice2");
$priceFrom = (int) get_request("priceFrom2");
$priceTo = (int) get_request("priceTo2");


$sql = "(status=1 OR status=0) ";
if ($ID > 0) {
    $sql.=' AND flat_id=' . $ID;
}
if ($flat_type < 99) {
    $sql.= " AND flat_type=" . $flat_type;
}
if ($roomID > 0) {
    $sql.=' AND room_type_id=' . $roomID;
}
if ($regionID > 0) {
    $sql.=' AND region_id=' . $regionID;
}
if ($priceID != "" && ($priceFrom > 0 || $priceTo > 0)) {
    if ($priceFrom > 0 && $priceTo > 0) {
        $sql.=' AND ' . $priceID . '>' . $priceFrom . ' AND ' . $priceID . '<' . $priceTo;
    } else if ($priceFrom > 0 && $priceTo < 1) {
        $sql.=' AND ' . $priceID . '>' . $priceFrom;
    } else if ($priceFrom < 1 && $priceTo > 0) {
        $sql.=' AND ' . $priceID . '<' . $priceTo;
    }
}


$count = $db->select_count(DB_PREFIX . "flats",$sql);
$pagenav = new PageNav($count, $perpage, $start, "p", "flatType=" . $flat_type . "&cbxRoom2=" . $roomID . "&cbxRegion2=" . $regionID . "&cbxPrice2=" . $priceID . "&priceFrom2=" . $priceFrom . "&priceFrom=" . $priceFrom . "&priceTo2=" . $priceTo);
echo '<div align="left" style="padding-left:20px;">' . $pagenav->renderCom(3, 3) . '</div><br>';

$arrRooms = array();
$rwRooms = $db->select("rooms", "", "*", "ORDER BY room_type ASC");
foreach ($rwRooms as $rwRoom) {
    $arrRooms[$rwRoom['room_id']] = $rwRoom['room_type'];
}
//echo var_dump($arrRooms);
?>


<table cellspacing="0" cellpadding="10">
    <tr>
        <td colspan="6" style="border:1px solid #1A324B;">
            <form action="flats.php" method="get" id="generalForm">
                <table border="0"   cellpadding="1" cellspacing="0">
                    <tr  valign="middle">
<!--                        <td align="right" class="txtSearchbar"> 
                            <b>Количества записей :</b> <?php echo $count; ?>
                            &nbsp;&nbsp;&nbsp;
                        </td>-->
                        <td align="right" class="txtSearchbar">
                            <b> ID : </b>  
                            <input class="txtSearchbar" type="text" name="ID2" size="10" <?php if ((int) $ID > 0) echo 'value="' . $ID . '"'; ?> >&nbsp;                         
                        </td>

                        <td align="right" class="txtSearchbar">
                            <b> Типы квартир : </b>  

                            <?php
                            echo '<select name="flatType" id="flatType" class="searchSelectIndex">';
                            echo '<option value="99">---</option>';
                            foreach ($arrType as $key => $value) {
                                echo '<option value="' . $key . '" ';
                                if ($key == $flat_type)
                                    echo ' selected';
                                echo ' >' . $value . '</option>';
                            }
                            echo '</select>';
                            ?>   


                        </td>

                        <td align="right" class="txtSearchbar">
                            <b> Комнаты  : </b>                           
                        </td>
                        <td align="right" class="txtSearchbar">
                            <?php
                            //$rwRooms = $db->select("rooms", "", "*", "ORDER BY room_type ASC");
//echo var_dump($rwCategories);
                            //$db->debug();
                            //print_r($rwRooms);
                            echo '<select name="cbxRoom2" id="cbxRoom2" class="txtSearchbar">';
                            echo '<option value="0">---</option>';
                            foreach ($rwRooms as $room) {
                                echo '<option value="' . $room['room_type'] . '" ';
                                if ($room['room_type'] == $roomID)
                                    echo 'selected';
                                echo ' >' . $room['room_type'] . '</option>';
                            }
                            echo '</select>';
                            ?>
                            &nbsp;&nbsp;                   
                        </td>
                        <td align="right" class="txtSearchbar">
                            <b> Район : </b>                           
                        </td>
                        <td align="right" class="txtSearchbar">
                            <?php
                            $rwRegions = $db->select("regions", "", "*", "ORDER BY region_id ASC");
//echo var_dump($rwCategories);
                            $db->debug();
                            echo '<select name="cbxRegion2" id="cbxRegion" class="txtSearchbar">';
                            echo '<option value="0">---</option>';
                            foreach ($rwRegions as $region) {
                                echo '<option value="' . $region["region_id"] . '" ';
                                if ($region['region_id'] == $regionID)
                                    echo 'selected';
                                echo ' >' . $region['region_title'] . '</option>';
                            }
                            echo '</select>';
                            ?>
                            &nbsp;&nbsp;                   
                        </td>
                        <td align="right" class="txtSearchbar"> 
                            <select name="cbxPrice2" class="txtSearchbar">
                                <option value="">------------</option>
                                <option value="price_hour" <?php if ($priceID == "price_hour") echo "selected"; ?> >Цена за час</option>
                                <option value="price_night" <?php if ($priceID == "price_night") echo "selected"; ?>>Цена за ночь</option>
                                <option value="price_day" <?php if ($priceID == "price_day") echo "selected"; ?>>Цена за сутки</option>
                            </select>    
                        </td>
                        <td align="right" class="txtSearchbar"> &nbsp; 
                            Цена от <input class="txtSearchbar" type="text" name="priceFrom2" size="10" <?php if ((int) $priceFrom > 0) echo 'value="' . $priceFrom . '"'; ?> >&nbsp;
                            до <input class="txtSearchbar" type="text" name="priceTo2" size="10" <?php if ((int) $priceTo > 0) echo 'value="' . $priceTo . '"'; ?>>&nbsp;
                        </td>
                        <td align="center" class="txtSearchbar"> <A class=toolbar  href="javascript:submitFormSelected('generalForm');">Сортировать  </A>    
                        </td>    
                    </tr>
                </table>
            </form>
        </td>           

    </tr>
    <table cellspacing="0" cellpadding="4">
        <tr id="list_title">
            <td align="center">ID</td>

            <td align="center">Фотография</td> 


            <td align="center">Адресс</td> 


            <td align="center">Инфо.</br> владельца</td>


            <td align="center">Инфо.</br> о квартиры</td>

            <td align="center">Описание</td>

            <td align="center">Цены</td>




<!--            <td align="center">Бронирован</td>-->
            <td align="center">Спец.</br>пред.</br> главное</td>
            <td align="center">Спец.</br>пред.</br> боковое</td>
            <td align="center">Статус</td>                 
            <td align="center"></td>
            <td align="center"></td>
            <td align="center"></td>

        </tr>
        <?php
        $rwRegionsCat = $db->select("regions", "", "*", "ORDER BY region_id ASC");
        $arrRegionCat = array();
        foreach ($rwRegionsCat as $region) {

            $arrRegionCat[$region['region_id']] = $region['region_title'];
        }


//$count = $db->count(DB_PREFIX."flats");
//echo $sql;
        $results = $db->select("flats", $sql, "*", " ORDER BY sortby ASC, flat_id DESC", $start . "," . $perpage);
        foreach ($results as $rw) {
            if ($rw["new"] == '1') {
                echo '<tr id="' . $flat_id . '" style="color:red;">';
            } else {
                echo '<tr id="' . $flat_id . '">';
            }
            ?>


            <td class="settingstools">
                <a name="<?php echo $rw['flat_id']; ?>"></a>
                <b><?php echo $rw['flat_id']; ?></b>
            </td> 

            <td class="ntitle" style="width:80px;"> 
    <?php
    if ($rw["image_url"] != "") {
        echo '<img src="../media/items/' . $rw["image_url"] . '" width="80">';
    }
    ?>  
            </td>

            <td class="ntitle" style="width:100px;">                        
                <b>Район: </b><br/>
    <?php
    echo $arrRegionCat[$rw["region_id"]];
    ?>  </br></br>
                <b>Адресс:</b><br/>                    
                <?php
                echo $rw["address"];
                ?>  
            </td>

            <td class="ntitle" style="width:120px;">                        
                <b>Ф.И.О.:</b><br/>
    <?php
    echo $rw["author"];
    ?>  </br>
                <b>Номер тел:</b><br/>
                <?php
                echo $rw["phone_number"];
                ?> 
                </br>
                <b>Номер тел2:</b><br/>
    <?php
    echo $rw["email"];
    ?>  

            </td>



            <td class="ntitle" style="width:80px;">  
                <b>Тип:</b><br/>                
    <?php
    echo $arrType[(int) $rw['flat_type']];
    ?></br>                   
                <b>Ком.:</b><br/>
                <?php
                echo $rw['room_type_id'];
                ?></br>  
                <b>Спал. места:</b><br/>
                <?php
                echo $rw["bed"];
                ?>  </br>
                <b>Тип строения:</b><br/>
                <?php
                echo $arrSeria[$rw["floor"]];
                ?>  
            </td>        
            <td class="ntitle" style="width:150px;">                        
    <?php
    echo $rw["description"];
    ?>  
            </td>

            <td class="ntitle" style="width:50px;">                        
                <b>час:</b><br/>
    <?php
    echo $rw["price_hour"];
    ?>  </br>
                <b> ночь:</b><br/>
                <?php
                echo $rw["price_night"];
                ?>  </br>
                <b>сутки:</b><br/>
                <?php
                echo $rw["price_day"];
                ?>  
            </td>






            <td class="settingstools"><a href="?a=special1&flat_id=<?php echo $rw['flat_id']; ?>&special1=<?php echo $rw['special1'] == 1 ? "0" : "1"; ?>"><img src="images/tick_circle<?php echo $rw['special1']; ?>.png" title="on/off"/></a></td> 
            <td class="settingstools"><a href="?a=special&flat_id=<?php echo $rw['flat_id']; ?>&special=<?php echo $rw['special'] == 1 ? "0" : "1"; ?>"><img src="images/tick_circle<?php echo $rw['special']; ?>.png" title="on/off"/></a></td>
            <td class="settingstools"><a href="?a=publish&flat_id=<?php echo $rw['flat_id']; ?>&status=<?php echo $rw['status'] == 1 ? "0" : "1"; ?>"><img src="images/tick_circle<?php echo $rw['status']; ?>.png" title="on/off"/></a></td>
            <td class="settingstools"><a href="?a=edit&flat_id=<?php echo $rw['flat_id']; ?>" alt="edit"><img src="images/page_white_edit.png" title="edit"/></a></td>
            <td class="settingstools"><a href="?a=delete&flat_id=<?php echo $rw['flat_id']; ?>"><img src="images/cross.png" title="delete"/></a></td>  
            <td class="settingstools">
                <form action="flats.php?a=order&id=<?php echo $rw['flat_id']; ?>" method="post" name="frmOrder"> 
                    <input type="text" name="txt_<?php echo $rw['flat_id']; ?>" size="3" value="<?php echo $rw['sortby']; ?>"/>
                    <input type="submit" value=" Отправить ">
                </form>
            </td>

            </tr>
    <?php /**/ ?><tr>
                <td colspan="18" class="ntitle">
                    <div id="dvBtn" style="float:left; width:120px;">
                        <a  href="javascript:void(0);" onclick="ShowDivContent(<?php echo $rw["flat_id"]; ?>);"> <b>Добавить </br>Ещё Фотки</b></a>
                    </div>  
                    <div id="dvPictures" style="float:left; width: auto; min-height: 75px;">
    <?php
    $pics = $db->select(DB_PREFIX . "photos", "flat_id=" . $rw["flat_id"], "*", " ORDER BY photo_id ASC");
    foreach ($pics as $rp) {
        echo '<div style="width:105px; float:left;"><img src="../media/thumb/' . $rp["image_url"] . '" alt="0" border="0" /><br>
                                   <a href="photos.php?a=del&id=' . $rp["photo_id"] . '">Удалить</a>
                                   </div>';
    }
    ?>
                    </div>

                    <div class="clear"></div>

                    <div id="dvPhotos_<?php echo $rw["flat_id"]; ?>" style="width:600px; display:none;">
                        <form action="photos.php?a=add&id=<?php echo $rw["flat_id"]; ?>" method="post" name="frmPhotos" enctype="multipart/form-data">         
                            <table cellspacing="2" style="width: 400px;">
                                <tr><td>Фотография 1:</td><td><input type="file" name="photo1"/> 
                                <tr><td>Фотография 2:</td><td><input type="file" name="photo2"/> </td></tr>
                                <tr><td>Фотография 3:</td><td><input type="file" name="photo3"/> </td></tr>
                                <tr><td>Фотография 4:</td><td><input type="file" name="photo4"/> </td></tr>
                                <tr><td>Фотография 5:</td><td><input type="file" name="photo5"/> </td></tr>
                                <tr><td></td><td><input type="submit" name="btnSend" value="Загружать"/> </td></tr>


                            </table>
                        </form>

                    </div>

                </td>                
            </tr> <?php /**/ ?>
            <tr>
                <td style="height:5px; background-color: #222222;" colspan="18"></td>
            </tr>              
    <?php
}
?>
    </table>
        <?php
        echo '<div align="left" style="padding-left:20px;">' . $pagenav->renderCom(3, 3) . '</div><br>';
        ?>




    <input type="hidden" id="hdID">



<?php
require_once 'footer.php';
?>
