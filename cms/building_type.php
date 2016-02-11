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
        $form_action = "?a=update&type_id=" . get_request('type_id');
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
    default:
        $isWhat = "";
        $form_action = "?a=add";
        break;
        break;
}


$cat_lang = 5;
$status = 1;

// EDIT*********************************************************************************************************************************
if ($isWhat == "edit") {
    $type_id = $_GET['type_id'];

    if ($type_id != "") {

        $row = $db->select(DB_PREFIX . "building_types", "type_id=" . $type_id);
        $rw = $row[0];

        $type_id = $rw['type_id'];
        $type_title = $rw['type_title'];
        $status = $rw['status'];

    } else {
        $error = 'No Data';
    }
}

// DELETE************************************************************************************************************************
if ($isWhat == "delete") {
    $type_id = $_GET['type_id'];
    $db->delete(DB_PREFIX . "building_types", "type_id = " . $type_id);
}

// PUBLISH UNPUBLISH************************************************************************************************************
if ($isWhat == "publish") {
    $type_id = $_GET['type_id'];
    $status = $_GET['status'];
    $update = array(
        "status" => $status
    );
    $db->update(DB_PREFIX . "building_types", $update, "type_id = " . $type_id);
}


// ADD NEW INSERT*****************************************************************************************************************
if ($isWhat == "add") {
    $error = "";
    //if($_POST['parent_id']=="") $error.="<b>Haber metni boЕџ!</b><br>";
    if ($_POST['type_title'] == "")
        $error .= "<b>Room Type is Empty!</b><br>";
    // if($_POST['cbxregion']=="") $error.="<b>Region ID not selected!</b><br>";
    //if ($_POST['status'] == NULL)
    //    $error.="<b>Status is Empty!</b><br>";


    if ($error == "") {
        $type_title = $_POST['type_title'];
        $status = ($_POST['status'] == "1") ? 1 : 0;
        $insert = array(
            "type_title" => $type_title,
            "status" => $status
        );
        $db->insert(DB_PREFIX . "building_types", $insert);
    }
}

//UPDATE*********************************************************************************************************
if ($isWhat == "update") {
    $error = "";
    $type_id = get_request('type_id');
    if ($_POST['type_title'] == "")
        $error .= "<b>Category Type is Empty!</b><br>";
    if ($error == "") {
        $type_title = $_POST['type_title'];
        $create_date = date("Y-m-d H:m:s");
        //echo $create_date;
        $status = ($_POST['status'] == "1") ? 1 : 0;

        $update = array(
            "type_title" => $type_title,
            "create_date" => $create_date,
            "status" => $status
        );
        $db->update(DB_PREFIX . "building_types", $update, "type_id = " . $type_id);
    }
}

if ($error != "")
    echo '<div class="msgerror">' . $error . '</div>';
?>
<h2 style="padding: 0px; margin: 0px;">Тип Строения </h2>
<div class="clsFooter"
     style="display: none; height: 600px; width: 1100px; background-color: #E7ECF1; position: absolute; z-index: 999; text-align: center;">
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

    &nbsp;
</div>

<form action="<?php echo $form_action; ?>" method="post" name="frmForm" id="frmForm">
    <div id="dvNewButton" style="display: <?php echo $edit ? 'none' : 'block'; ?>;">
        <input id="btnAddNew" value=" Добавить Новый Тип " onclick="showDiv('dvForm');" type="button"/>
    </div>

    <div id="dvForm" class="dvForm" style="display: <?php echo $edit ? 'block' : 'none'; ?>;">

        <div id="dvFormHeader"><b><?php echo $edit ? 'Редактировать' : 'Добавить Новый'; ?></b></div>
        <table cellspacing="2" cellpadding="2" style="width: 100%;">
            <tr>
                <td width="120">Тип:</td>
                <td><input size="35" name="type_title" value="<?php echo $edit ? $type_title : ''; ?>"/></td>
            </tr>

            <tr>
                <td>Статус</td>
                <td><input type="checkbox" value="1"
                           name="status" <?php echo ($edit && !$status) ? '' : 'checked="true"'; ?>/></td>
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



<table cellspacing="0" cellpadding="4">
    <tr id="list_title">
        <td align="center">ID</td>
        <td align="center">Тип Строения</td>
        <td align="center">Статус</td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    <?php
    $results = $db->select(DB_PREFIX . "building_types", "", "*", "ORDER BY type_title ASC");
    foreach ($results as $rw) {
        ?>
        <tr>
            <td class="ntitle" style="width:50px;"><?php echo $rw['type_id']; ?></td>

            <td class="ntitle"><?php echo $rw['type_title']; ?></td>
            <td class="settingstools"><a
                href="?a=publish&type_id=<?php echo $rw['type_id']; ?>&status=<?php echo $rw['status'] == 1 ? "0" : "1"; ?>"><img
                src="images/tick_circle<?php echo $rw['status']; ?>.png" title="on/off"/></a></td>

            <td class="settingstools"><a href="?a=edit&type_id=<?php echo $rw['type_id']; ?>" alt="edit"><img
                src="images/page_white_edit.png" title="edit"/></a></td>
        <td class="settingstools">
            <?php
            if (checkSubFiles(DB_PREFIX . "estates", " 	building_type=" . $rw['type_id'], "estate_id") > 0) {
                echo "";
            } else {
                ?>
                <a href="?a=delete&type_id=<?php echo $rw['type_id']; ?>"><img src="images/cross.png"
                                                                               title="delete"/></a></td
                <?php
            }
            ?>
        </tr>
        <?php
    }
    ?>
</table>

<?php
require_once 'footer.php';
?>