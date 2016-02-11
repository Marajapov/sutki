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
        $form_action = "?a=update&special_id=" . get_request('special_id');
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
    $special_id = $_GET['special_id'];
    if ($special_id != "") {
        $rw = $db->select_one(DB_PREFIX . "specials", "special_id=" . $special_id);
        $special_id = $rw['special_id'];
        $title = $rw['title'];
        $price = $rw['price'];
        $price_type = $rw['price_type'];
        $pic1 = $rw['pic1'];
        $desc1 = $rw['desc1'];
        $pic2 = $rw['pic2'];
        $desc2 = $rw['desc2'];
        $pic3 = $rw['pic3'];
        $desc3 = $rw['desc3'];
        $pic4 = $rw['pic4'];
        $desc4 = $rw['desc4'];
        $pic5 = $rw['pic5'];
        $desc5 = $rw['desc5'];
        $pic6 = $rw['pic6'];
        $desc6 = $rw['desc6'];
        $pic7 = $rw['pic7'];
        $desc7 = $rw['desc7'];
        $pic8 = $rw['pic8'];
        $desc8 = $rw['desc8'];
        $sortby = $rw['sortby'];
        $create_date = $rw['create_date'];
        $status = $rw['status'];
    } else {
        $error = 'No Data';
    }
}

// DELETE************************************************************************************************************************
if ($isWhat == "delete") {
    $special_id = $_GET['special_id'];
    $rw = $db->select_one(DB_PREFIX . "specials", "special_id=" . $special_id);
    //echo var_dump($rw);
    if ($rw["pic1"] != "") {
        deleteFile("../media/big/" . $rw["pic1"]);
    }

    $db->delete(DB_PREFIX . "specials", "special_id = " . $special_id);
}

// SET ORDER STATUS ************************************************************************************************************
if ($isWhat == "order") {
    //$results = $db->select("flats", "", "special_id", "ORDER BY special_id DESC");
    $special_id = $_GET['id'];
    $order = $_POST['txt_' . $special_id];
    $update = array(
        "sortby" => $order
    );
    $db->update("flats", $update, "special_id= " . $special_id);
}


// PUBLISH UNPUBLISH************************************************************************************************************
if ($isWhat == "publish") {
    $special_id = $_GET['special_id'];
    $status = $_GET['status'];
    $update = array(
        "status" => $status
    );
    $db->update(DB_PREFIX . "specials", $update, "special_id = " . $special_id);
}


// ADD NEW INSERT*****************************************************************************************************************
if ($isWhat == "add") {
    $error = "";

    $title = $_POST['title'];
    $price = $_POST['price'];
    $price_type = $_POST['price_type'];

    $desc1 = $_POST['desc1'];
    $desc2 = $_POST['desc2'];
    $desc3 = $_POST['desc3'];
    $desc4 = $_POST['desc4'];
    $desc5 = $_POST['desc5'];
    $desc6 = $_POST['desc6'];
    $desc7 = $_POST['desc7'];
    $desc8 = $_POST['desc8'];

    $sortby = $_POST['sortby'];
    $status = ($_POST['status'] == "1") ? 1 : 0;

    $pic1 = "";
    $pic2 = "";
    $pic3 = "";
    $pic4 = "";
    $pic5 = "";
    $pic6 = "";
    $pic7 = "";
    $pic8 = "";

    if ($error == "") {

        for ($i = 1; $i < 8; $i++) {
            $strPic = $_FILES['pic' . $i];
            if ($strPic['error'] <= 0) {
                $handle = new Upload($strPic);
                if ($handle->uploaded) {
                    $newname = time();
                    $handle->image_resize = true;
                    $handle->image_x = 622;
                    $handle->image_y = 421;
                    $handle->file_new_name_body = $newname;
//                $handle->image_watermark = '../media/logo.png';
//                $handle->image_watermark_x = 240;
//                $handle->image_watermark_y = 150;
//                $handle->image_watermark_no_zoom_in = true;

                    $handle->Process('../media/big/');
                    if ($handle->processed) {
                        if($i==1){
                            $pic1 = $handle->file_dst_name;
                        }else if($i==2){
                            $pic2 = $handle->file_dst_name;
                        }else if($i==3){
                            $pic3 = $handle->file_dst_name;
                        }else if($i==4){
                            $pic4 = $handle->file_dst_name;
                        }else if($i==5){
                            $pic5 = $handle->file_dst_name;
                        }else if($i==6){
                            $pic6 = $handle->file_dst_name;
                        }else if($i==7){
                            $pic7 = $handle->file_dst_name;
                        }else if($i==8){
                            $pic8 = $handle->file_dst_name;
                        }
                    } else {
                        $error .= $handle->error . '';
                    }
                }
            }
        }

        $insert = array(
            "title" => $title,
            "price" => $price,
            "price_type" => $price_type,
            "pic1" => $pic1,
            "desc1" => $desc1,
            "pic2" => $pic2,
            "desc2" => $desc2,
            "pic3" => $pic3,
            "desc3" => $desc3,
            "pic4" => $pic4,
            "desc4" => $desc4,
            "pic5" => $pic5,
            "desc5" => $desc5,
            "pic6" => $pic6,
            "desc6" => $desc6,
            "pic7" => $pic7,
            "desc7" => $desc7,
            "pic8" => $pic8,
            "desc8" => $desc8,
            "sortby" => $sortby,
            "status" => $status
        );
        $db->insert(DB_PREFIX . "specials", $insert);

        redirect("specials.php", "js");
    }
}

//UPDATE*********************************************************************************************************
if ($isWhat == "update") {
    $error = "";
    $special_id = get_request('special_id');
    if ($special_id == "")
        $error .= "<b>ID is empty!</b><br>";

    $title = $_POST['title'];
    $price = $_POST['price'];
    $price_type = $_POST['price_type'];

    $desc1 = $_POST['desc1'];
    $desc2 = $_POST['desc2'];
    $desc3 = $_POST['desc3'];
    $desc4 = $_POST['desc4'];
    $desc5 = $_POST['desc5'];
    $desc6 = $_POST['desc6'];
    $desc7 = $_POST['desc7'];
    $desc8 = $_POST['desc8'];

    $sortby = $_POST['sortby'];
    $status = ($_POST['status'] == "1") ? 1 : 0;

    $pic1 = "";
    $pic2 = "";
    $pic3 = "";
    $pic4 = "";
    $pic5 = "";
    $pic6 = "";
    $pic7 = "";
    $pic8 = "";


    $hd_pic1 = $_POST['hd_pic1'];
    $hd_pic2 = $_POST['hd_pic2'];
    $hd_pic3 = $_POST['hd_pic3'];
    $hd_pic4 = $_POST['hd_pic4'];
    $hd_pic5 = $_POST['hd_pic5'];
    $hd_pic6 = $_POST['hd_pic6'];
    $hd_pic7 = $_POST['hd_pic7'];
    $hd_pic8 = $_POST['hd_pic8'];


    if ($error == "") {
        for ($i = 1; $i < 8; $i++) {
            $strPic = $_FILES['pic' . $i];
            if ($strPic['error'] <= 0) {
                $handle = new Upload($strPic);
                if ($handle->uploaded) {
                    $newname = time();
                    $handle->image_resize = true;
                    $handle->image_x = 622;
                    $handle->image_y = 421;
                    $handle->file_new_name_body = $newname;
//                $handle->image_watermark = '../media/logo.png';
//                $handle->image_watermark_x = 240;
//                $handle->image_watermark_y = 150;
//                $handle->image_watermark_no_zoom_in = true;

                    $handle->Process('../media/big/');
                    if ($handle->processed) {
                        if($i==1){
                            $pic1 = $handle->file_dst_name;
                        }else if($i==2){
                            $pic2 = $handle->file_dst_name;
                        }else if($i==3){
                            $pic3 = $handle->file_dst_name;
                        }else if($i==4){
                            $pic4 = $handle->file_dst_name;
                        }else if($i==5){
                            $pic5 = $handle->file_dst_name;
                        }else if($i==6){
                            $pic6 = $handle->file_dst_name;
                        }else if($i==7){
                            $pic7 = $handle->file_dst_name;
                        }else if($i==8){
                            $pic8 = $handle->file_dst_name;
                            if ($hd_pic8 != "") {
                                deleteFile("../media/big/" . $hd_pic8);
                            }
                        }
                    } else {
                        $error .= $handle->error . '';
                    }
                }
            }else{

                if($i==1){
                    $pic1 = $hd_pic1;
                   if ($_POST["delete_pic1"] > 0) {
                        deleteFile("../media/big/" . $hd_pic1);
                       $pic1 = "";
                    }
                }else if($i==2){
                    $pic2 = $hd_pic2;
                    if ($_POST["delete_pic2"] > 0) {
                        deleteFile("../media/big/" . $hd_pic2);
                        $pic2 = "";
                    }
                }else if($i==3){
                    $pic3 = $hd_pic3;
                    if ($_POST["delete_pic3"] > 0) {
                        deleteFile("../media/big/" . $hd_pic3);
                        $pic3 = "";
                    }
                }else if($i==4){
                    $pic1 = $hd_pic4;
                    if ($_POST["delete_pic4"] > 0) {
                        deleteFile("../media/big/" . $hd_pic4);
                        $pic4 = "";
                    }
                }else if($i==5){
                    $pic5 = $hd_pic5;
                    if ($_POST["delete_pic5"] > 0) {
                        deleteFile("../media/big/" . $hd_pic5);
                        $pic5 = "";
                    }
                }else if($i==6){
                    $pic6 = $hd_pic6;
                    if ($_POST["delete_pic6"] > 0) {
                        deleteFile("../media/big/" . $hd_pic6);
                        $pic6 = "";
                    }
                }else if($i==7){
                    $pic7 = $hd_pic7;
                    if ($_POST["delete_pic7"] > 0) {
                        deleteFile("../media/big/" . $hd_pic7);
                        $pic7 = "";
                    }
                }else if($i==8){
                    $pic8 = $hd_pic8;
                    if ($_POST["delete_pic8"] > 0) {
                        deleteFile("../media/big/" . $hd_pic8);
                        $pic8 = "";
                    }
                }

            }
        }

        $insert = array(
            "title" => $title,
            "price" => $price,
            "price_type" => $price_type,
            "pic1" => $pic1,
            "desc1" => $desc1,
            "pic2" => $pic2,
            "desc2" => $desc2,
            "pic3" => $pic3,
            "desc3" => $desc3,
            "pic4" => $pic4,
            "desc4" => $desc4,
            "pic5" => $pic5,
            "desc5" => $desc5,
            "pic6" => $pic6,
            "desc6" => $desc6,
            "pic7" => $pic7,
            "desc7" => $desc7,
            "pic8" => $pic8,
            "desc8" => $desc8,
            "sortby" => $sortby,
            "status" => $status
        );
        $db->update(DB_PREFIX . "specials", $insert,"special_id=".$special_id);

        redirect("specials.php", "js");
    }
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

    &nbsp;
    <div class="clear"></div>
</div>

<form action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data" name="addnew" id="addnew">
<table cellpadding="0" cellspacing="0" border="0" style="height: 30px;">
    <tr>
        <td><input id="btnAddNew" value=" Добавить Новый " onclick="showDiv('dvForm');" type="button"
                   style="display: <?php echo $edit ? 'none' : 'block'; ?>;"/></td>
        <td></td>
    </tr>
</table>

<div id="dvForm" class="dvForm" style="display: <?php echo $edit ? 'block' : 'none'; ?>;">

<div id="dvFormHeader"><b><?php echo $edit ? 'Редактировать' : 'Добавить Новый'; ?></b></div>

<table cellspacing="2" cellpadding="2" style="width: 100%;">
<tr>
    <td style="text-align: right;"> Заголовок объявления:</td>
    <td><input size="50" name="title" value="<?php echo $edit ? $title : ''; ?>"/></td>
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
    <td style="text-align: right;">Картинка 1:</td>
    <td><input type="file" name="pic1"/> <?php
        if ($edit && $pic1 != "") {
            ?>&nbsp;&nbsp;Удалить
            <input type="checkbox" name="delete_pic1" value="1">
            <img src="../media/big/<?php echo $pic1; ?>" width="50" alt="">
            <input type="hidden" name="hd_pic1" value="<?php echo $pic1; ?>">  <?php } ?>
    </td>
</tr>
    <tr>
        <td style="text-align: right;">Описание 1:</td>
        <td><textarea rows="2" cols="48" name="desc1"><?php echo $edit ? $desc1 : '';?></textarea>
        </td>
    </tr>


    <tr>
        <td style="text-align: right;">Картинка 2:</td>
        <td><input type="file" name="pic2"/> <?php
            if ($edit && $pic2 != "") {
                ?>&nbsp;&nbsp;Удалить
                <input type="checkbox" name="delete_pic2" value="1">
                <img src="../media/big/<?php echo $pic2; ?>" width="50" alt="">
                <input type="hidden" name="hd_pic2" value="<?php echo $pic2; ?>">  <?php } ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">Описание 2:</td>
        <td><textarea rows="2" cols="48" name="desc2"><?php echo $edit ? $desc2 : '';?></textarea>
        </td>
    </tr>

    <tr>
        <td style="text-align: right;">Картинка 3:</td>
        <td><input type="file" name="pic3"/> <?php
            if ($edit && $pic3 != "") {
                ?>&nbsp;&nbsp;Удалить
                <input type="checkbox" name="delete_pic3" value="1">
                <img src="../media/big/<?php echo $pic3; ?>" width="50" alt="">
                <input type="hidden" name="hd_pic3" value="<?php echo $pic3; ?>">  <?php } ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">Описание 3:</td>
        <td><textarea rows="2" cols="48" name="desc3"><?php echo $edit ? $desc3 : '';?></textarea>
        </td>
    </tr>

    <tr>
        <td style="text-align: right;">Картинка 4:</td>
        <td><input type="file" name="pic4"/> <?php
            if ($edit && $pic4 != "") {
                ?>&nbsp;&nbsp;Удалить
                <input type="checkbox" name="delete_pic4" value="1">
                <img src="../media/big/<?php echo $pic4; ?>" width="50" alt="">
                <input type="hidden" name="hd_pic4" value="<?php echo $pic4; ?>">  <?php } ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">Описание 4:</td>
        <td><textarea rows="2" cols="48" name="desc4"><?php echo $edit ? $desc4 : '';?></textarea>
        </td>
    </tr>

    <tr>
        <td style="text-align: right;">Картинка 5:</td>
        <td><input type="file" name="pic5"/> <?php
            if ($edit && $pic5 != "") {
                ?>&nbsp;&nbsp;Удалить
                <input type="checkbox" name="delete_pic5" value="1">
                <img src="../media/big/<?php echo $pic5; ?>" width="50" alt="">
                <input type="hidden" name="hd_pic5" value="<?php echo $pic5; ?>">  <?php } ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">Описание 5:</td>
        <td><textarea rows="2" cols="48" name="desc5"><?php echo $edit ? $desc5 : '';?></textarea>
        </td>
    </tr>

    <tr>
        <td style="text-align: right;">Картинка 6:</td>
        <td><input type="file" name="pic6"/> <?php
            if ($edit && $pic6 != "") {
                ?>&nbsp;&nbsp;Удалить
                <input type="checkbox" name="delete_pic6" value="1">
                <img src="../media/big/<?php echo $pic6; ?>" width="50" alt="">
                <input type="hidden" name="hd_pic6" value="<?php echo $pic6; ?>">  <?php } ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">Описание 6:</td>
        <td><textarea rows="2" cols="48" name="desc6"><?php echo $edit ? $desc6 : '';?></textarea>
        </td>
    </tr>

    <tr>
        <td style="text-align: right;">Картинка 7:</td>
        <td><input type="file" name="pic7"/> <?php
            if ($edit && $pic7 != "") {
                ?>&nbsp;&nbsp;Удалить
                <input type="checkbox" name="delete_pic7" value="1">
                <img src="../media/big/<?php echo $pic7; ?>" width="50" alt="">
                <input type="hidden" name="hd_pic7" value="<?php echo $pic7; ?>">  <?php } ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">Описание 7:</td>
        <td><textarea rows="2" cols="48" name="desc7"><?php echo $edit ? $desc7 : '';?></textarea>
        </td>
    </tr>

    <tr>
        <td style="text-align: right;">Картинка 8:</td>
        <td><input type="file" name="pic8"/> <?php
            if ($edit && $pic8 != "") {
                ?>&nbsp;&nbsp;Удалить
                <input type="checkbox" name="delete_pic8" value="1">
                <img src="../media/big/<?php echo $pic8; ?>" width="50" alt="">
                <input type="hidden" name="hd_pic8" value="<?php echo $pic8; ?>">  <?php } ?>
        </td>
    </tr>
    <tr>
        <td style="text-align: right;">Описание 8:</td>
        <td><textarea rows="2" cols="48" name="desc8"><?php echo $edit ? $desc8 : '';?></textarea>
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



<table cellspacing="0" cellpadding="4">
<tr id="list_title">
    <td align="center">ID</td>

    <td align="center">Заголовок & Цены</td>

    <td align="center">Фото & Описание</td>

    <td align="center">Статус</td>

    <td align="center"></td>

</tr>
<?php


//$count = $db->count(DB_PREFIX."flats");
//echo $sql;
$results = $db->select(DB_PREFIX . "specials", "", "*", " ORDER BY sortby ASC, special_id DESC");

foreach ($results as $rw) {
    if ($rw["new"] == '1') {
        echo '<tr id="' . $special_id . '" style="color:red;">';
    } else {
        echo '<tr id="' . $special_id . '">';
    }
    ?>


<td class="settingstools">
    <a name="<?php echo $rw['special_id']; ?>"></a>
    <b><?php echo $rw['special_id']; ?></b>
</td>

<td class="ntitle" style="width:150px;" valign="top">
    <?php
    echo '<br><b>'.$rw['title'].'</b><br/>';
    echo '<br><br><b>'.$rw["price"].'&nbsp;'. $arrPriceType[$rw["price_type"]]. '</b><br>';
    ?>
</td>

<td class="ntitle" style="width:550px;">
    <?php

    if ($rw["pic1"] != "") {
        echo '<br><img src="../media/big/' . $rw["pic1"] . '" width="80"><br>';
    }else{
        echo '<hr>';
    }
    echo ''.$rw["desc1"].'<br>';

    if ($rw["pic2"] != "") {
        echo '<br><img src="../media/big/' . $rw["pic2"] . '" width="80"><br>';
    }else{
        echo '<hr>';
    }
    echo ''.$rw["desc2"].'<br>';

    if ($rw["pic3"] != "") {
        echo '<br><img src="../media/big/' . $rw["pic3"] . '" width="80"><br>';
    }else{
        echo '<hr>';
    }
    echo ''.$rw["desc3"].'<br>';

    if ($rw["pic4"] != "") {
        echo '<br><img src="../media/big/' . $rw["pic4"] . '" width="80"><br>';
    }else{
        echo '<hr>';
    }
    echo ''.$rw["desc4"].'<br>';

    if ($rw["pic5"] != "") {
        echo '<br><img src="../media/big/' . $rw["pic5"] . '" width="80"><br>';
    }else{
        echo '<hr>';
    }
    echo ''.$rw["desc5"].'<br>';

    if ($rw["pic6"] != "") {
        echo '<br><img src="../media/big/' . $rw["pic6"] . '" width="80"><br>';
    }else{
        echo '<hr>';
    }
    echo ''.$rw["desc6"].'<br>';

    if ($rw["pic7"] != "") {
        echo '<br><img src="../media/big/' . $rw["pic7"] . '" width="80"><br>';
    }else{
        echo '<hr>';
    }
    echo ''.$rw["desc7"].'<br>';

    if ($rw["pic8"] != "") {
        echo '<br><img src="../media/big/' . $rw["pic8"] . '" width="80"><br>';
    }else{
        echo '<hr>';
    }
    echo ''.$rw["desc8"].'<br>';

?>

</td>



<td class="settingstools"><a
    href="?a=publish&special_id=<?php echo $rw['special_id']; ?>&status=<?php echo $rw['status'] == 1 ? "0" : "1"; ?>"><img
    src="images/tick_circle<?php echo $rw['status']; ?>.png" title="on/off"/></a>
    <br/>
    <br/>
    <br/>
    <a href="?a=edit&special_id=<?php echo $rw['special_id']; ?>" alt="edit"><img
        src="images/page_white_edit.png" title="edit"/></a>
    <br>
    <br>
    <br>
    <a href="?a=delete&special_id=<?php echo $rw['special_id']; ?>"><img src="images/cross.png"
                                                                       title="delete"/></a>
</td>
<td class="settingstools">
    <form action="flats.php?a=order&id=<?php echo $rw['special_id']; ?>" method="post" name="frmOrder">
        <input type="text" name="txt_<?php echo $rw['special_id']; ?>" size="3"
               value="<?php echo $rw['sortby']; ?>"/>
        <input type="submit" value=" Отправить ">
    </form>
</td>

<tr>
    <td style="height:5px; background-color: #222222;" colspan="18"></td>
</tr>
    <?php
}
?>
</table>

<input type="hidden" id="hdID">



<?php
require_once 'footer.php';
?>
