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
        $form_action = "?a=update&estate_id=" . get_request('estate_id');
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
    $estate_id = $_GET['estate_id'];
    if ($estate_id != "") {
        $rw = $db->select_one(DB_PREFIX . "estates", "estate_id=" . $estate_id);
        $estate_id = $rw['estate_id'];
        $estate_type = $rw['estate_type'];
        $title = $rw['title'];
        $description = $rw['description'];
        $announcement_type = $rw['announcement_type'];
        $estate_type_id = $rw['estate_type_id'];
        $building_type_id = $rw['building_type_id'];
        $status_id = $rw['status_id'];
        $wall_material_id = $rw['wall_material_id'];
        $heating_id = $rw['heating_id'];
        $room = $rw['room'];
        $price = $rw['price'];
        $price_type = $rw['price_type'];
        $floor = $rw['floor'];
        $total_floor = $rw['total_floor'];
        $area_total = $rw['area_total'];
        $area_live = $rw['area_live'];
        $area_kitchen = $rw['area_kitchen'];
        $area_land = $rw['area_land'];
        $forniture = $rw['forniture'];
        $garage = $rw['garage'];
        $balcony = $rw['balcony'];
        $warehouse = $rw['warehouse'];
        $garden = $rw['garden'];
        $from_city = $rw['from_city'];
        $owner = $rw['owner'];
        $country_id = $rw['country_id'];
        $province_id = $rw['province_id'];
        $city_id = $rw['city_id'];
        $region_id = $rw['region_id'];
        $region_name = $rw['region_name'];
        $address = $rw['address'];
        $video = $rw['video'];
        $video_file = $rw['video_file'];
        $main_pic = $rw['main_pic'];
        $special = $rw['special'];
        $sortby = $rw['sortby'];
        $create_date = $rw['create_date'];
        $update_date = $rw['update_date'];
        $status = $rw['status'];
        $author_name = $rw['author_name'];
        $phone = $rw['phone'];
        $mobile = $rw['mobile'];
        $email = $rw['email'];
        $author = $rw['author'];
    } else {
        $error = 'No Data';
    }
}

// DELETE************************************************************************************************************************
if ($isWhat == "delete") {
    $estate_id = $_GET['estate_id'];
    $rw = $db->select_one(DB_PREFIX . "estates", "estate_id=" . $estate_id);
    //echo var_dump($rw);
    if ($rw["image_url"] != "") {
        deleteFile("../media/thumb/" . $rw["image_url"]);
        deleteFile("../media/big/" . $rw["image_url"]);
        deleteFile("../media/open/" . $rw["image_url"]);
        deleteFile("../media/items/" . $rw["image_url"]);
    }

    $rw_photos = $db->select(DB_PREFIX . "photos", "estate_id=" . $estate_id, "*");
    foreach ($rw_photos as $rw_photo) {
        if ($rw_photo["image_url"] != "") {
            deleteFile("../media/thumb/" . $rw_photo["image_url"]);
            deleteFile("../media/open/" . $rw_photo["image_url"]);
        }
        $db->delete(DB_PREFIX . "photos", "estate_id = " . $rw_photo["estate_id"]);
    }


    $db->delete(DB_PREFIX . "estates", "estate_id = " . $estate_id);
}

// SET ORDER STATUS ************************************************************************************************************
if ($isWhat == "order") {
    //$results = $db->select("flats", "", "estate_id", "ORDER BY estate_id DESC");
    $estate_id = $_GET['id'];
    $order = $_POST['txt_' . $estate_id];
    $update = array(
        "sortby" => $order
    );
    $db->update("flats", $update, "estate_id= " . $estate_id);
}


// PUBLISH UNPUBLISH************************************************************************************************************
if ($isWhat == "publish") {
    $estate_id = $_GET['estate_id'];
    $status = $_GET['status'];
    $update = array(
        "status" => $status
    );
    $db->update(DB_PREFIX . "estates", $update, "estate_id = " . $estate_id);
}

// RESERVED UNRESERVED************************************************************************************************************
if ($isWhat == "reserved") {
    $estate_id = $_GET['estate_id'];
    $reserved = $_GET['reserved'];
    $update = array(
        "reserved" => $reserved,
        "new" => 0
    );
    $db->update(DB_PREFIX . "estates", $update, "estate_id = " . $estate_id);
}
// SPECIAL NONSPECIAL************************************************************************************************************
if ($isWhat == "special") {
    $estate_id = $_GET['estate_id'];
    $special = $_GET['special'];
    $update = array(
        "special" => $special,
        "new" => 0
    );
    $db->update(DB_PREFIX . "estates", $update, "estate_id = " . $estate_id);
}
// SPECIAL1 NONSPECIAL1************************************************************************************************************
if ($isWhat == "special1") {
    $estate_id = $_GET['estate_id'];
    $special1 = $_GET['special1'];
    $update = array(
        "special1" => $special1,
        "new" => 0
    );
    $db->update(DB_PREFIX . "estates", $update, "estate_id = " . $estate_id);
}

// ADD NEW INSERT*****************************************************************************************************************
if ($isWhat == "add") {
    $error = "";

    $estate_type = $_POST['estate_type'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $announcement_type = $_POST['announcement_type'];
    $estate_type_id = $_POST['estate_type_id'];
    $building_type_id = $_POST['building_type_id'];
    $status_id = $_POST['status_id'];
    $wall_material_id = $_POST['wall_material_id'];
    $heating_id = $_POST['heating_id'];
    $room = $_POST['room'];
    $price = $_POST['price'];
    $price_type = $_POST['price_type'];
    $floor = $_POST['floor'];
    $total_floor = $_POST['total_floor'];
    $area_total = $_POST['area_total'];
    $area_live = $_POST['area_live'];
    $area_kitchen = $_POST['area_kitchen'];
    $area_land = $_POST['area_land'];
    $forniture = $_POST['forniture'];
    $garage = $_POST['garage'];
    $balcony = $_POST['balcony'];
    $warehouse = $_POST['warehouse'];
    $garden = $_POST['garden'];
    $from_city = $_POST['from_city'];
    $owner = $_POST['owner'];
    $country_id = $_POST['country_id'];
    $province_id = $_POST['province_id'];
    $city_id = $_POST['city_id'];
    $region_id = $_POST['region_id'];
    $region_name = $_POST['region_name'];
    $address = $_POST['address'];
    $video = $_POST['video'];
    $video_file = $_POST['video_file'];
    $special = $_POST['special'];
    $sortby = $_POST['sortby'];
    $author_name = $_POST['author_name'];
    $phone = $_POST['phone'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];

    $image_url = $_FILES['main_pic'];
    $status = ($_POST['status'] == "1") ? 1 : 0;
    $main_pic = "";

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
                $handle->image_watermark_x = 240;
                $handle->image_watermark_y = 150;
                $handle->image_watermark_no_zoom_in = true;

                $handle->Process('../media/big/');
                if ($handle->processed) {
                    $main_pic = $handle->file_dst_name;
                } else {
                    $error .= $handle->error . '';
                }


                $handle->image_resize = true;
                //$handle->image_ratio_y = true;
                $handle->image_x = 462;
                $handle->image_y = 327;
                $handle->file_new_name_body = $newname;
                $handle->image_watermark = '../media/logo.png';
                $handle->image_watermark_x = 60;
                $handle->image_watermark_y = 80;
                $handle->image_watermark_no_zoom_in = true;
                $handle->Process('../media/medium/');
                if ($handle->processed) {
                    $main_pic = $handle->file_dst_name;
                } else {
                    $error .= $handle->error . '';
                }

                $handle->image_resize = true;
                //$handle->image_ratio_y = true;
                $handle->image_x = 203;
                $handle->image_y = 133;
                $handle->file_new_name_body = $newname;
                $handle->Process('../media/thumb/');
                if ($handle->processed) {
                    $main_pic = $handle->file_dst_name;
                } else {
                    $error .= $handle->error . '';
                }


            }
        }

        $author = $_SESSION['userid'];

        $insert = array(
            "estate_type" => $estate_type,
            "title" => $title,
            "description" => $description,
            "announcement_type" => $announcement_type,
            "estate_type_id" => $estate_type_id,
            "building_type_id" => $building_type_id,
            "status_id" => $status_id,
            "wall_material_id" => $wall_material_id,
            "heating_id" => $heating_id,
            "room" => $room,
            "price" => $price,
            "price_type" => $price_type,
            "floor" => $floor,
            "total_floor" => $total_floor,
            "area_total" => $area_total,
            "area_live" => $area_live,
            "area_kitchen" => $area_kitchen,
            "area_land" => $area_land,
            "forniture" => $forniture,
            "garage" => $garage,
            "balcony" => $balcony,
            "warehouse" => $warehouse,
            "garden" => $garden,
            "from_city" => $from_city,
            "owner" => $owner,
            "country_id" => $country_id,
            "province_id" => $province_id,
            "city_id" => $city_id,
            "region_id" => $region_id,
            "region_name" => $region_name,
            "address" => $address,
            "video" => $video,
            "video_file" => $video_file,
            "main_pic" => $main_pic,
            "special" => $special,
            "sortby" => $sortby,
            "author_name" => $author_name,
            "phone" => $phone,
            "mobile" => $mobile,
            "email" => $email,
            "author" => $author,
            "status" => $status
        );
        $db->insert(DB_PREFIX . "estates", $insert);

        redirect("estates.php", "js");
    }
}

//UPDATE*********************************************************************************************************
if ($isWhat == "update") {
    $error = "";
    $estate_id = get_request('estate_id');
    if ($estate_id == "")
        $error .= "<b>ID is empty!</b><br>";

    $estate_type = $_POST['estate_type'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $announcement_type = $_POST['announcement_type'];
    $estate_type_id = $_POST['estate_type_id'];
    $building_type_id = $_POST['building_type_id'];
    $status_id = $_POST['status_id'];
    $wall_material_id = $_POST['wall_material_id'];
    $heating_id = $_POST['heating_id'];
    $room = $_POST['room'];
    $price = $_POST['price'];
    $price_type = $_POST['price_type'];
    $floor = $_POST['floor'];
    $total_floor = $_POST['total_floor'];
    $area_total = $_POST['area_total'];
    $area_live = $_POST['area_live'];
    $area_kitchen = $_POST['area_kitchen'];
    $area_land = $_POST['area_land'];
    $forniture = $_POST['forniture'];
    $garage = $_POST['garage'];
    $balcony = $_POST['balcony'];
    $warehouse = $_POST['warehouse'];
    $garden = $_POST['garden'];
    $from_city = $_POST['from_city'];
    $owner = $_POST['owner'];
    $country_id = $_POST['country_id'];
    $province_id = $_POST['province_id'];
    $city_id = $_POST['city_id'];
    $region_id = $_POST['region_id'];
    $region_name = $_POST['region_name'];
    $address = $_POST['address'];
    $video = $_POST['video'];
    $video_file = $_POST['video_file'];
    $special = $_POST['special'];
    $sortby = $_POST['sortby'];
    $author_name = $_POST['author_name'];
    $phone = $_POST['phone'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];


    $image_url = $_FILES['main_pic'];
    $status = ($_POST['status'] == "1") ? 1 : 0;
    $main_pic = "";


    $hd_image_url = $_POST['hd_image_url'];
    $pic1 = "";

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
                $handle->image_watermark_x = 240;
                $handle->image_watermark_y = 150;
                $handle->image_watermark_no_zoom_in = true;

                $handle->Process('../media/big/');
                if ($handle->processed) {
                    $main_pic = $handle->file_dst_name;
                } else {
                    $error .= $handle->error . '';
                }


                $handle->image_resize = true;
                //$handle->image_ratio_y = true;
                $handle->image_x = 462;
                $handle->image_y = 327;
                $handle->file_new_name_body = $newname;
                $handle->image_watermark = '../media/logo.png';
                $handle->image_watermark_x = 60;
                $handle->image_watermark_y = 80;
                $handle->image_watermark_no_zoom_in = true;
                $handle->Process('../media/medium/');
                if ($handle->processed) {
                    $main_pic = $handle->file_dst_name;
                } else {
                    $error .= $handle->error . '';
                }

                $handle->image_resize = true;
                //$handle->image_ratio_y = true;
                $handle->image_x = 203;
                $handle->image_y = 133;
                $handle->file_new_name_body = $newname;
                $handle->Process('../media/thumb/');
                if ($handle->processed) {
                    $main_pic = $handle->file_dst_name;
                } else {
                    $error .= $handle->error . '';
                }

                if ($hd_image_url != "") {
                    deleteFile("../media/big/" . $hd_image_url);
                    deleteFile("../media/medium/" . $hd_image_url);
                    deleteFile("../media/thumb/" . $hd_image_url);
                }
            }
        } else {
            $main_pic = $hd_image_url;
            if ($_POST["delete_image1"] > 0) {
                deleteFile("../media/big/" . $hd_image_url);
                deleteFile("../media/thumb/" . $hd_image_url);
                deleteFile("../media/medium/" . $hd_image_url);
                $main_pic = "";
            }
        }


        $author = $_SESSION['userid'];

        $update = array(
            "estate_type" => $estate_type,
            "title" => $title,
            "description" => $description,
            "announcement_type" => $announcement_type,
            "estate_type_id" => $estate_type_id,
            "building_type_id" => $building_type_id,
            "status_id" => $status_id,
            "wall_material_id" => $wall_material_id,
            "heating_id" => $heating_id,
            "room" => $room,
            "price" => $price,
            "price_type" => $price_type,
            "floor" => $floor,
            "total_floor" => $total_floor,
            "area_total" => $area_total,
            "area_live" => $area_live,
            "area_kitchen" => $area_kitchen,
            "area_land" => $area_land,
            "forniture" => $forniture,
            "garage" => $garage,
            "balcony" => $balcony,
            "warehouse" => $warehouse,
            "garden" => $garden,
            "from_city" => $from_city,
            "owner" => $owner,
            "country_id" => $country_id,
            "province_id" => $province_id,
            "city_id" => $city_id,
            "region_id" => $region_id,
            "region_name" => $region_name,
            "address" => $address,
            "video" => $video,
            "video_file" => $video_file,
            "main_pic" => $main_pic,
            "special" => $special,
            "sortby" => $sortby,
            "author_name" => $author_name,
            "phone" => $phone,
            "mobile" => $mobile,
            "email" => $email,
            "author" => $author,
            "status" => $status
        );
        $db->update(DB_PREFIX . "estates", $update, "estate_id = " . $estate_id);
    }
    redirect("estates.php#" . $estate_id, "js");
}

if ($error != "")
    echo '<div class="msgerror">' . $error . '</div>';
?>

<div class="clsFooter"
     style="display: none; min-height: 600px; width: 1100px; background-color: #E7ECF1; position: absolute; z-index: 999; text-align: center;">
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

    &nbsp;
    <div class="clear"></div>
</div>

<form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data" name="addnew" id="addnew">
<table cellpadding="0" cellspacing="0" border="0" style="height: 30px;">
    <tr>
        <td><input id="btnAddNew" value=" Добавить Новую Квартиру " onclick="showDiv('dvForm');" type="button"
                   style="display: <?php echo $edit ? 'none' : 'block'; ?>;"/></td>
        <td></td>
    </tr>
</table>

<div id="dvForm" class="dvForm" style="display: <?php echo $edit ? 'block' : 'none'; ?>;">

<div id="dvFormHeader"><b><?php echo $edit ? 'Редактировать' : 'Добавить Новую'; ?></b></div>

<table cellspacing="2" cellpadding="2" style="width: 100%;">

<tr>
    <td style="text-align: right;"></td>
    <td>
        <?php
        foreach ($arrType as $key => $value) {
            echo '<input type="radio" name="estate_type" value="' . $key . '" ' . ($key == $estate_type ? "checked " : "") . ' >';
            echo $value;
        }
        ?>
    </td>
</tr>

<tr>
    <td style="text-align: right;"> Заголовок объявления:</td>
    <td><input size="50" name="title" value="<?php echo $edit ? $title : ''; ?>"/></td>
</tr>

<tr>
    <td style="text-align: right;">Описание:</td>
    <td><textarea rows="4" cols="48" name="description"><?php echo $edit ? $description : '';?></textarea>
    </td>
</tr>
<tr>
    <td style="text-align: right;">Рубрика:</td>
    <td>
        <?php
        echo '<select name="announcement_type" id="announcement_type">';
        foreach ($arrAnnouncementType as $key => $value) {
            echo '<option value="' . $key . '" ';
            if ($key == $announcement_type)
                echo ' selected';
            echo ' >' . $value . '</option>';
        }
        echo '</select>';
        ?>
    </td>
</tr>


<tr>
    <td style="text-align: right;">Тип Недвижимости:</td>
    <td>
        <?php
        $arrEstateType=array();
        $rwEstateType = $db->select(DB_PREFIX . "estate_types", "status=1", "*", "ORDER BY type_title ASC");
        echo '<select name="estate_type_id" id="estate_type_id">';
        echo '<option value="-1">-------------</option>';
        foreach ($rwEstateType as $etype) {
            $arrEstateType[$etype["type_id"]]=$etype["type_title"];

            echo '<option value="' . $etype["type_id"] . '" ';
            if ((int)$etype['type_id'] == $estate_type_id)
                echo 'selected';
            echo ' >' . $etype['type_title'] . '</option>';
        }
        echo '</select>';
        ?>
    </td>
</tr>

<tr>
    <td style="text-align: right;">Тип строения:</td>
    <td>
        <?php
        $arrBuilding=array();
        $rwBuildingType = $db->select(DB_PREFIX . "building_types", "status=1", "*", "ORDER BY type_title ASC");
        echo '<select name="building_type_id" id="building_type_id">';
        echo '<option value="-1">-------------</option>';
        foreach ($rwBuildingType as $etype) {

            $arrBuilding[$etype["type_id"]]=$etype["type_title"];

            echo '<option value="' . $etype["type_id"] . '" ';
            if ((int)$etype['type_id'] == $building_type_id)
                echo 'selected';
            echo ' >' . $etype['type_title'] . '</option>';
        }
        echo '</select>';
        ?>
    </td>
</tr>

<tr>
    <td style="text-align: right;">Состояние:</td>
    <td>
        <?php
        $arrStatus=array();

        $rwStatusType = $db->select(DB_PREFIX . "status", "status=1", "*", "ORDER BY type_title ASC");
        echo '<select name="status_id" id="status_id">';
        echo '<option value="-1">----------------------</option>';
        foreach ($rwStatusType as $etype) {
            $arrStatus[$etype["type_id"]]=$etype["type_title"];

            echo '<option value="' . $etype["type_id"] . '" ';
            if ((int)$etype['type_id'] == $status_id)
                echo 'selected';
            echo ' >' . $etype['type_title'] . '</option>';
        }
        echo '</select>';
        ?>
    </td>
</tr>


<tr>
    <td style="text-align: right;">Материал стен дома:</td>
    <td>
        <?php
        $arrWall=array();
        $rwWallType = $db->select(DB_PREFIX . "walls", "status=1", "*", "ORDER BY type_title ASC");
        echo '<select name="wall_material_id" id="wall_material_id">';
        echo '<option value="-1">----------------------</option>';
        foreach ($rwWallType as $etype) {
            $arrWall[$etype["type_id"]]=$etype["type_title"];

            echo '<option value="' . $etype["type_id"] . '" ';
            if ((int)$etype['type_id'] == $wall_material_id)
                echo 'selected';
            echo ' >' . $etype['type_title'] . '</option>';
        }
        echo '</select>';
        ?>
    </td>
</tr>

<tr>
    <td style="text-align: right;">Отопление:</td>
    <td>
        <?php
        $arrHeating=array();
        $rwWallType = $db->select(DB_PREFIX . "heating", "status=1", "*", "ORDER BY type_title ASC");
        echo '<select name="heating_id" id="heating_id">';
        echo '<option value="-1">----------------------</option>';
        foreach ($rwWallType as $etype) {
            $arrHeating[$etype["type_id"]]=$etype["type_title"];
            echo '<option value="' . $etype["type_id"] . '" ';
            if ((int)$etype['type_id'] == $heating_id)
                echo 'selected';
            echo ' >' . $etype['type_title'] . '</option>';
        }
        echo '</select>';
        ?>
    </td>
</tr>

<tr>
    <td style="text-align: right;">Комнаты:</td>
    <td><input size="10" name="room" value="<?php echo $edit ? $room : ''; ?>"/></td>
</tr>

<tr>
    <td style="text-align: right;">Цена:</td>
    <td><input size="10" name="price" value="<?php echo $edit ? $price : ''; ?>"/>

        <?php
        echo '<select name="price_type" id="price_type">';
        foreach ($arrPriceType as $key => $value) {
            echo '<option value="' . $key . '" ';
            if ($key == $price_type)
                echo ' selected';
            echo ' >' . $value . '</option>';
        }
        echo '</select>';
        ?>
    </td>
</tr>

<tr>
    <td style="text-align: right;">Этаж:</td>
    <td><input size="10" name="floor" value="<?php echo $edit ? $floor : ''; ?>"/></td>
</tr>

<tr>
    <td style="text-align: right;">Этажность:</td>
    <td><input size="10" name="total_floor" value="<?php echo $edit ? $total_floor : ''; ?>"/></td>
</tr>

<tr>
    <td style="text-align: right;">Площадь (кв.м):</td>
    <td>
        &nbsp;&nbsp; Общая площадь : <input size="5" name="area_total" value="<?php echo $edit ? $area_total : ''; ?>"/>
        &nbsp;
        &nbsp;&nbsp; Жилая : <input size="5" name="area_live" value="<?php echo $edit ? $area_live : ''; ?>"/> &nbsp;
        &nbsp;&nbsp; Кухня : <input size="5" name="area_kitchen" value="<?php echo $edit ? $area_kitchen : ''; ?>"/>

    </td>
</tr>

<tr>
    <td style="text-align: right;">Общий Участок (сот.) :</td>
    <td>
        <input size="10" name="area_land" value="<?php echo $edit ? $area_total : ''; ?>"/>
    </td>
</tr>


<!--        <tr>-->
<!--            <td style="text-align: right;"></td>-->
<!--            <td>-->
<!--                Мебель-->
<!--                <input type="radio" value="2"  id="forniture" name="forniture">&nbsp;-->
<!--                Да&nbsp;&nbsp;&nbsp;&nbsp;-->
<!--                <input type="radio" value="1"  id="forniture" name="forniture">&nbsp;-->
<!--                Нет&nbsp;&nbsp;&nbsp;&nbsp;-->
<!--                <br/>-->
<!--               Гараж-->
<!--                <input type="radio" value="2"  id="garage" name="garage">&nbsp;-->
<!--                Да&nbsp;&nbsp;&nbsp;&nbsp;-->
<!--                <input type="radio" value="1"  id="garage" name="garage">&nbsp;-->
<!--                Нет&nbsp;&nbsp;&nbsp;&nbsp;-->
<!--                <br/>-->
<!--                Гараж-->
<!--                <input type="radio" value="2"  id="garage" name="garage">&nbsp;-->
<!--                Да&nbsp;&nbsp;&nbsp;&nbsp;-->
<!--                <input type="radio" value="1"  id="garage" name="garage">&nbsp;-->
<!--                Нет&nbsp;&nbsp;&nbsp;&nbsp;-->
<!--                <br/>-->
<!--                Гараж-->
<!--                <input type="radio" value="2"  id="garage" name="garage">&nbsp;-->
<!--                Да&nbsp;&nbsp;&nbsp;&nbsp;-->
<!--                <input type="radio" value="1"  id="garage" name="garage">&nbsp;-->
<!--                Нет&nbsp;&nbsp;&nbsp;&nbsp;-->
<!--                -->
<!--            </td>-->
<!--        </tr>-->

<tr>
    <td style="text-align: right;">Км от города :</td>
    <td><input size="5" name="from_city" value="<?php echo $edit ? $from_city : ''; ?>"/> км</td>
</tr>


<tr>
    <td style="width:120px; text-align: right;" style="text-align: right;">Район:</td>
    <td>
        <?php
        $arrRegion=array();
        $rwRegions = $db->select(DB_PREFIX . "regions", "", "*", "ORDER BY region_title ASC");
        echo '<select name="region_id" id="region_id">';
        echo '<option value="-1">----------------------</option>';
        foreach ($rwRegions as $region) {
            $arrRegion[$region["region_id"]]=$region["region_title"];

            echo '<option value="' . $region["region_id"] . '" ';
            if ($region['region_id'] == $region_id)
                echo 'selected';
            echo ' >' . $region['region_title'] . '</option>';
        }
        echo '</select>';
        ?>
        &nbsp; или &nbsp;
        <input size="25" name="region_name" value="<?php echo $edit ? $region_name : ''; ?>"/>
    </td>
</tr>

<tr>
    <td style="text-align: right;">Адресс:</td>
    <td><input size="50" name="address" value="<?php echo $edit ? $address : ''; ?>"/></td>
</tr>

<tr>
    <td style="text-align: right;">Имя пользователя :</td>
    <td><input size="30" name="author_name" value="<?php echo $edit ? $author_name : ''; ?>"/></td>
</tr>

<tr>
    <td style="text-align: right;">Номер телефона:</td>
    <td><input size="30" name="phone" value="<?php echo $edit ? $phone : ''; ?>"/></td>
</tr>

<tr>
    <td style="text-align: right;">E-mail:</td>
    <td><input size="30" name="email" value="<?php echo $edit ? $email : ''; ?>"/></td>
</tr>

<tr>
    <td style="text-align: right;">Главная картинка:</td>
    <td><input type="file" name="main_pic"/> <?php
        if ($edit && $main_pic != "") {
            ?>&nbsp;&nbsp;Удалить
            <input type="checkbox" name="delete_image1" value="1">
            <img src="../media/thumb/<?php echo $main_pic; ?>" width="50" alt="">
            <input type="hidden" name="hd_image_url" value="<?php echo $main_pic; ?>">  <?php } ?>
    </td>
</tr>

<tr>
    <td style="text-align: right;">Статус</td>
    <td>
        <input type="checkbox" value="1"
               name="status" <?php echo ($edit && !$status) ? '' : 'checked="true"'; ?>/>
    </td>
</tr>
</table>
<div id="dvFormFooter" class="clsSubmitForm">
    <input type="button" onclick="submitForm();" id="btnSend"
           value="<?php echo $edit ? "Обновить" : "   Добавить  "; ?>"/>
    <input type="button" value="  Отмена  " onclick="<?php echo $edit ? "gotURL();" : "hideDiv('dvForm');" ?>"/>
</div>
</div>
<div class="clear" style="height:20px;"></div>
</form>

<script type="text/javascript">
    function submitForm() {
        $('.clsFooter').css('display', 'block');
        $('.clsSubmitForm').css('display', 'none');
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

$id2 = 0;
$estate_type2 = -1;
$announcement_type2 = -1;
$region_id2 = 0;
$region_name2 = "";
$priceF2 = "";
$priceT2 = "";
$room2="";
$author2="";


$id2 = get_request("id2",0);
$estate_type2 = get_request("estate_type2",-1);
$announcement_type2 = get_request("announcement_type2",-1);
$region_id2 = get_request("region_id2",0);
$region_name2 = get_request("region_name2","");
$priceF2 = get_request("priceF2",0);
$priceT2 = get_request("priceT2",0);
$room2=get_request("room2",0);
$author2=get_request("author2","");

$sql = "(status=1 OR status=0) ";
if ($id2 > 0) {
    $sql .= ' AND estate_id=' . $id2;
}
if ($estate_type2 >-1) {
    $sql .= " AND estate_type=" . $estate_type2;
}
if ($announcement_type2 >-1) {
    $sql .= ' AND announcement_type=' . $announcement_type2;
}
if ($region_id2 > 0) {
    if($region_name2!=""){
        $sql .= ' AND region_name=' . $region_name2;
    }else{
        $sql .= ' AND region_id=' . $region_id2;
    }
}else{
    if($region_name2!=""){
        $sql .= ' AND region_name=' . $region_name2;
    }
}

if ($room2 >0) {
    $sql .= ' AND room=' . $room2;
}

if ($priceF2 > 0 || $priceT2 > 0) {
    if ($priceF2 > 0 && $priceT2 > 0) {
        $sql .= ' AND price >= ' . $priceT2 . ' AND price <=' . $priceT2;
    } else if ($priceF2 > 0 && $priceT2 < 1) {
        $sql .= ' AND price >' . $priceFrom;
    } else if ($priceF2 < 1 && $priceT2 > 0) {
        $sql .= ' AND price <' . $priceT2;
    }
}

if($author2!=""){
    $sql .= ' AND author=' . $author2;
}

$rwSotrudnik = $db->select(DB_PREFIX."users", "user_type=1", "*", "ORDER BY user_id ASC");
$arrSotrudnik = array();
foreach ($rwSotrudnik as $sotrudnik) {
    $arrSotrudnik[$sotrudnik['user_id']] = $sotrudnik['full_name'];
}


$count = $db->select_count(DB_PREFIX . "estates", $sql);
$db->debug();
$pagenav = new PageNav($count, $perpage, $start, "p", "estate_type2=" . $estate_type2 . "&announcement_type2=" . $announcement_type2 . "&region_id2=" . $region_id2 . "&region_name2=" . $region_name2 . "&priceF2=" . $priceF2 . "&priceT2=" . $priceT2 . "&room2=" . $room2."&author2=".$author2);
echo '<div align="left" style="padding-left:20px;">' . $pagenav->renderCom(3, 3) . '</div><br>';

//$arrRooms = array();
//$rwRooms = $db->select("rooms", "", "*", "ORDER BY room_type ASC");
//foreach ($rwRooms as $rwRoom) {
//    $arrRooms[$rwRoom['room_id']] = $rwRoom['room_type'];
//}

?>


<table cellspacing="0" cellpadding="10">
<tr>
    <td colspan="6" style="border:1px solid #1A324B;">
        <form action="estates.php" method="get" id="generalForm">
            <table border="0" cellpadding="1" cellspacing="0">
                <tr valign="middle">
                    <td align="right" class="txtSearchbar">
                        <b> ID : </b>
                        <input class="txtSearchbar" type="text" name="id2"
                               size="5" <?php if ((int)$id2 > 0) echo 'value="' . $id2 . '"'; ?> >&nbsp;
                    </td>
                    <td align="right" class="txtSearchbar">
                        <b> Тип Недвижимости : </b>
                        <?php
                        echo '<select name="estate_type2" id="estate_type2" class="searchSelectIndex">';
                        echo '<option value="-1">-----------</option>';
                        foreach ($arrType as $key => $value) {
                            echo '<option value="' . $key . '" ';
                            if ($key == $estate_type2)
                                echo ' selected';
                            echo ' >' . $value . '</option>';
                        }
                        echo '</select>';
                        ?>
                    </td>
                    <td align="right" class="txtSearchbar">
                        <b> Рубрика : </b>
                        <?php
                        echo '<select name="announcement_type2" id="announcement_type2">';
                        echo '<option value="-1">-----------</option>';
                        foreach ($arrAnnouncementType as $key => $value) {
                            echo '<option value="' . $key . '" ';
                            if ($key == $announcement_type2)
                                echo ' selected';
                            echo ' >' . $value . '</option>';
                        }
                        echo '</select>';
                        ?>
                    </td>

                    <td align="right" class="txtSearchbar">
                        <b> Комнаты : </b>
                        <input type="text" size="5" name="room2" id="room2" value="<?php echo $room2;?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Сот.</b> &nbsp;
                        <?php
                        echo '<select name="author2" id="author2" class="txtSearchbar">';
                        echo '<option value="">---</option>';
                        foreach ($arrSotrudnik as $key => $value) {
                            echo '<option value="' . $key . '" ';
                            if ($key == $author2)
                                echo 'selected';
                            echo ' >' . $value . '</option>';
                        }
                        echo '</select>';
                        ?>

                    </td>

                    <td align="right" class="txtSearchbar">
                        <b> Район : </b>
                        <?php
                        $rwRegions = $db->select(DB_PREFIX . "regions", "", "*", "ORDER BY region_id ASC");
                        echo '<select name="region_id2" id="region_id2" class="txtSearchbar">';
                        echo '<option value="0">---</option>';
                        foreach ($rwRegions as $region) {
                            echo '<option value="' . $region["region_id"] . '" ';
                            if ($region['region_id'] == $region_id2)
                                echo 'selected';
                            echo ' >' . $region['region_title'] . '</option>';
                        }
                        echo '</select>';
                        ?>
                        &nbsp;&nbsp;
                        или
                        <?php
                        $rwRegions2 = $db->select(DB_PREFIX . "estates", "", "DISTINCT region_name", "ORDER BY region_name ASC");
                        echo '<select name="region_name2" id="region_name2" class="txtSearchbar">';
                        echo '<option value="">---</option>';
                        foreach ($rwRegions2 as $region) {
                            echo '<option value="' . $region["region_name"] . '" ';
                            if ($region['region_name'] == $region_name2)
                                echo 'selected';
                            echo ' >' . $region['region_name'] . '</option>';
                        }
                        echo '</select>';
                        ?>
                    </td>
                    <td align="right" class="txtSearchbar">
                        &nbsp;
                       <b> Цена</b>
                        &nbsp;
                       <input class="txtSearchbar" type="text" name="priceF2"
                                       size="10" <?php if ((int)$priceF2 > 0) echo 'value="' . $priceF2 . '"'; ?> >&nbsp;
                        до <input class="txtSearchbar" type="text" name="priceT2"
                                  size="10" <?php if ((int)$priceT2 > 0) echo 'value="' . $priceT2 . '"'; ?>>&nbsp;
                    </td>

                    <td align="center" class="txtSearchbar">
                        <a class=toolbar href="javascript:submitFormSelected('generalForm');">Сортировать </a>
                    </td>
                </tr>


            </table>
        </form>
    </td>

</tr>
</table>

<table cellspacing="0" cellpadding="4">
<tr id="list_title">
    <td align="center">ID</td>

   <td align="center">Описание & Цены</td>

    <td align="center">Адресс</td>


    <td align="center">Инфо.</br> владельца</td>


    <td align="center">Инфо.</td>

    <td align="center">Статус</td>

    <td align="center"></td>

</tr>
<?php


//$count = $db->count(DB_PREFIX."flats");
//echo $sql;
$results = $db->select(DB_PREFIX . "estates", $sql, "*", " ORDER BY sortby ASC, estate_id DESC", $start . "," . $perpage);

foreach ($results as $rw) {
    if ($rw["new"] == '1') {
        echo '<tr id="' . $estate_id . '" style="color:red;">';
    } else {
        echo '<tr id="' . $estate_id . '">';
    }
    ?>


<td class="settingstools">
    <a name="<?php echo $rw['estate_id']; ?>"></a>
    <b><?php echo $rw['estate_id']; ?></b>
</td>

<td class="ntitle" style="width:150px;" valign="top">
    <?php
    echo '<b>'.$rw["price"].'&nbsp;'. $arrPriceType[$rw["price_type"]]. '</b><br>';
    if ($rw["main_pic"] != "") {
        echo '<br><img src="../media/thumb/' . $rw["main_pic"] . '" width="80"><br><br>';
    }
    echo '<b>'.$rw['title'].'</b><br/>';
    echo $rw["description"];
    ?>
</td>

<td class="ntitle" style="width:150px;">
    <b>Район: </b><br/>
    <?php
    echo $arrRegion[$rw["region_id"]];

    if($rw["region_name"]!=""){
        echo $region_name;
    }
    ?>  </br></br>
    <b>Адресс:</b><br/>
    <?php
    echo $rw["address"];
    ?>
    <?php
    if($rw["from_city"]!=""){
        echo '<br><b>Км от города :</b>';
        echo $rw["from_city"];
    }

?><br>
    <b>Комнаты:</b><br/>
        <?php
        echo $rw['room'];
        ?></br>
    <b>Этаж:</b><br/>
        <?php
        echo $rw['floor'].' / '.$rw['total_floor'];
        ?></br>

</td>

<td class="ntitle" style="width:120px;">
    <b>Ф.И.О.:</b><br/>
    <?php
    echo $rw["author_name"];
    ?>  </br>
    <b>Номер тел:</b><br/>
    <?php
    echo $rw["phone"];
    ?>
    </br>
    <b>Email:</b><br/>
    <?php
    echo $rw["email"];
    ?>

    </br>
    <b>Сотрудник:</b><br/>
    <?php
    echo $arrSotrudnik[$rw['author']];
    ?>
   <br/>
    <b>Общий Участок :</b><br/>
    <?php
    echo $rw["area_land"].' сот. ';
    ?>  </br>
    <b>Общая площадь :</b><br/>
    <?php
    echo $rw["area_total"];
    ?>  </br>
    <b> Жилая :</b><br/>
    <?php
    echo $rw["area_live"];
    ?>  </br>
    <b>Кухня :</b><br/>
    <?php
    echo $rw["area_kitchen"];
    ?>
</td>



<td class="ntitle" style="width:80px;">
    <b>Тип:</b><br/>
        <?php
        echo $arrType[(int)$rw['estate_type']];
        ?></br>
    <b>Рубрика:</b><br/>
        <?php
        echo $arrAnnouncementType[$rw['announcement_type']];
        ?></br>
    <b>Тип Недвижимости:</b><br/>
        <?php
        echo $arrEstateType[$rw['estate_type_id']];
        ?></br>
    <b>Тип строения:</b><br/>
        <?php
        echo $arrBuilding[$rw['building_type_id']];
        ?></br>
    <b>Состояние:</b><br/>
        <?php
        echo $arrStatus[$rw['status_id']];
        ?></br>
    <b>Материал стен дома:</b><br/>
        <?php
        echo $arrWall[$rw['wall_material_id']];
        ?></br>
    <b>Отопление:</b><br/>
        <?php
        echo $arrHeating[$rw['heating_id']];
        ?></br>

</td>


<td class="settingstools"><a
    href="?a=publish&estate_id=<?php echo $rw['estate_id']; ?>&status=<?php echo $rw['status'] == 1 ? "0" : "1"; ?>"><img
    src="images/tick_circle<?php echo $rw['status']; ?>.png" title="on/off"/></a>
<br/>
    <br/>
    <br/>
    <a href="?a=edit&estate_id=<?php echo $rw['estate_id']; ?>" alt="edit"><img
    src="images/page_white_edit.png" title="edit"/></a>
    <br>
    <br>
    <br>
    <a href="?a=delete&estate_id=<?php echo $rw['estate_id']; ?>"><img src="images/cross.png"
                                                                                             title="delete"/></a>
</td>
<td class="settingstools">
    <form action="flats.php?a=order&id=<?php echo $rw['estate_id']; ?>" method="post" name="frmOrder">
        <input type="text" name="txt_<?php echo $rw['estate_id']; ?>" size="3"
               value="<?php echo $rw['sortby']; ?>"/>
        <input type="submit" value=" Отправить ">
    </form>
</td>

</tr>
    <?php /**/ ?>
<tr>
    <td colspan="8" class="ntitle">
        <div id="dvBtn" style="float:left; width:120px;">
            <a href="javascript:void(0);" onclick="ShowDivContent(<?php echo $rw["estate_id"]; ?>);">
                <b>Добавить </br>Ещё Фотки</b></a>
        </div>
        <div id="dvPictures" style="float:left; width: auto; min-height: 75px;">
            <?php
            $pics = $db->select(DB_PREFIX . "photos", "estate_id=" . $rw["estate_id"], "*", " ORDER BY photo_id ASC");
            foreach ($pics as $rp) {
                echo '<div style="width:105px; float:left;"><img src="../media/thumb/' . $rp["image_url"] . '" alt="0" border="0" /><br>
                                   <a href="photos.php?a=del&id=' . $rp["photo_id"] . '&cid='.$rw["estate_id"].'">Удалить</a>
                                   </div>';
            }
            ?>
        </div>

        <div class="clear"></div>

        <div id="dvPhotos_<?php echo $rw["estate_id"]; ?>" style="width:600px; display:none;">
            <form action="photos.php?a=add&id=<?php echo $rw["estate_id"]; ?>" method="post" name="frmPhotos"
                  enctype="multipart/form-data">
                <table cellspacing="2" style="width: 400px;">
                    <tr>
                        <td>Фотография 1:</td>
                        <td><input type="file" name="photo1"/>
                    <tr>
                        <td>Фотография 2:</td>
                        <td><input type="file" name="photo2"/></td>
                    </tr>
                    <tr>
                        <td>Фотография 3:</td>
                        <td><input type="file" name="photo3"/></td>
                    </tr>
                    <tr>
                        <td>Фотография 4:</td>
                        <td><input type="file" name="photo4"/></td>
                    </tr>
                    <tr>
                        <td>Фотография 5:</td>
                        <td><input type="file" name="photo5"/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="btnSend" value="Загружать"/></td>
                    </tr>


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
