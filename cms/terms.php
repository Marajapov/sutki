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
        $form_action = "?a=update&term_id=" . get_request('term_id');
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
    $term_id = $_GET['term_id'];

    if ($term_id != "") {

        $row = $db->select(DB_PREFIX . "terms", "term_id=" . $term_id);
        $rw = $row[0];

        $term_id = $rw['term_id'];
        $term_name = $rw['term_name'];
        $term_type = $rw['term_type'];
        $status = $rw['status'];

    } else {
        $error = 'No Data';
    }
}

// DELETE************************************************************************************************************************
if ($isWhat == "delete") {
    $term_id = $_GET['term_id'];
    $db->delete(DB_PREFIX . "terms", "term_id = " . $term_id);
}

// PUBLISH UNPUBLISH************************************************************************************************************
if ($isWhat == "publish") {
    $term_id = $_GET['term_id'];
    $status = $_GET['status'];
    $update = array(
        "status" => $status
    );
    $db->update(DB_PREFIX . "terms", $update, "term_id = " . $term_id);
}


// ADD NEW INSERT*****************************************************************************************************************
if ($isWhat == "add") {
    $error = "";
    //if($_POST['parent_id']=="") $error.="<b>Haber metni boЕџ!</b><br>";
    if ($_POST['term_name'] == "")
        $error .= "<b> Type is Empty!</b><br>";

    if ($error == "") {
        $term_name = $_POST['term_name'];
        $term_type = $_POST['cbxTermType'];
        $status = ($_POST['status'] == "1") ? 1 : 0;
        $insert = array(
            "term_type" => $term_type,
            "term_name" => $term_name,
            "status" => $status
        );
        $db->insert(DB_PREFIX . "terms", $insert);
    }
}

//UPDATE*********************************************************************************************************
if ($isWhat == "update") {
    $error = "";
    $term_id = get_request('term_id');
    if ($_POST['term_name'] == "")
        $error .= "<b> Type is Empty!</b><br>";
    if ($error == "") {

        $term_name = $_POST['term_name'];
        $term_type = $_POST['cbxTermType'];
        $status = ($_POST['status'] == "1") ? 1 : 0;
        $update = array(
            "term_type" => $term_type,
            "term_name" => $term_name,
            "status" => $status
        );

        $db->update(DB_PREFIX . "terms", $update, "term_id = " . $term_id);
    }
}

if ($error != "")
    echo '<div class="msgerror">' . $error . '</div>';
?>
<h2 style="padding: 0px; margin: 0px;">Условия </h2>
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
        <input id="btnAddNew" value=" Добавить Новая Условия " onclick="showDiv('dvForm');" type="button"/>
    </div>

    <div id="dvForm" class="dvForm" style="display: <?php echo $edit ? 'block' : 'none'; ?>;">

        <div id="dvFormHeader"><b><?php echo $edit ? 'Редактировать' : 'Добавить Новая'; ?></b></div>
        <table cellspacing="2" cellpadding="2" style="width: 100%;">
            <tr>
                <td width="120">Тип:</td>
                <td>
                    <?php
                    echo '<select name="cbxTermType" id="cbxTermType">';
                    foreach ($arrTermType as $key => $value) {
                        echo '<option value="' . $key . '" ';
                        if ($key == $term_type)
                            echo ' selected';
                        echo ' >' . $value . '</option>';
                    }
                    echo '</select>';
                    ?>
                </td>
            </tr>

            <tr>
                <td width="120">Имя:</td>
                <td><input size="35" name="term_name" value="<?php echo $edit ? $term_name : ''; ?>"/></td>
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
        <td align="center">Тип</td>
        <td align="center">Имя</td>
        <td align="center">Статус</td>
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    <?php
    $results = $db->select(DB_PREFIX . "terms", "", "*", "ORDER BY term_type ASC,term_name ASC");
    foreach ($results as $rw) {
        ?>
        <tr>
            <td class="ntitle" style="width:50px;"><?php echo $rw['term_id']; ?></td>

            <td class="ntitle"><?php
                if ($rw['term_type'] == 0) {
                    echo 'Условия';
                } else {
                    echo 'Коммунальные Условия';
                }
                ?></td>

            <td class="ntitle"><?php echo $rw['term_name']; ?></td>
            <td class="settingstools"><a
                href="?a=publish&term_id=<?php echo $rw['term_id']; ?>&status=<?php echo $rw['status'] == 1 ? "0" : "1"; ?>"><img
                src="images/tick_circle<?php echo $rw['status']; ?>.png" title="on/off"/></a></td>

            <td class="settingstools"><a href="?a=edit&term_id=<?php echo $rw['term_id']; ?>" alt="edit"><img
                src="images/page_white_edit.png" title="edit"/></a></td>
            <td class="settingstools">
                <a href="?a=delete&term_id=<?php echo $rw['term_id']; ?>"><img src="images/cross.png"/></a></td>
        </tr>
        <?php
    }
    ?>
</table>

<?php
require_once 'footer.php';
?>