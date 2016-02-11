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
        $form_action = "?a=update&room_id=" . get_request('room_id');
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
    $room_id = $_GET['room_id'];

    if ($room_id != "") {

        $row = $db->select(DB_PREFIX . "rooms", "room_id=" . $room_id);  
        $rw = $row[0];

        $room_id = $rw['room_id'];
        $room_type = $rw['room_type'];
        $status = $rw['status'];
        
    } else {
        $error = 'No News Category';
    }
}

// DELETE************************************************************************************************************************
if ($isWhat == "delete") {
    $room_id = $_GET['room_id'];
    $db->delete(DB_PREFIX . "rooms", "room_id = " . $room_id);
}

// PUBLISH UNPUBLISH************************************************************************************************************
if ($isWhat == "publish") {
    $room_id = $_GET['room_id'];
    $status = $_GET['status'];
    $update = array(
        "status" => $status
    );
    $db->update(DB_PREFIX . "rooms", $update, "room_id = " . $room_id);
}



// ADD NEW INSERT*****************************************************************************************************************
if ($isWhat == "add") {
    $error = "";
    //if($_POST['parent_id']=="") $error.="<b>Haber metni boЕџ!</b><br>";
    if ($_POST['room_type'] == "")
        $error.="<b>Room Type is Empty!</b><br>";
    // if($_POST['cbxregion']=="") $error.="<b>Region ID not selected!</b><br>";
    //if ($_POST['status'] == NULL)
    //    $error.="<b>Status is Empty!</b><br>";
        
        
    if ($error == "") {

        $room_type = $_POST['room_type'];
        $status = ($_POST['status'] == "1") ? 1 : 0;     

        $insert = array(
            "room_type" => $room_type,
            "status" => $status
        );
        $db->insert(DB_PREFIX . "rooms", $insert);
    }
}

//UPDATE*********************************************************************************************************
if ($isWhat == "update") {
    $error = "";
    $room_id = get_request('room_id');
    if ($_POST['room_type'] == "")
        $error.="<b>Category Type is Empty!</b><br>";
    if ($error == "") {

        $room_type = $_POST['room_type'];
        $create_date = date("Y-m-d H:m:s");
        //echo $create_date;
        $status = ($_POST['status'] == "1") ? 1 : 0;

        $update = array(
            "room_type" => $room_type,
            "create_date" => $create_date,
            "status" => $status
        );
        $db->update(DB_PREFIX . "rooms", $update, "room_id = " . $room_id);
    }
}

if ($error != "")
    echo '<div class="msgerror">' . $error . '</div>';
?>
<h2 style="padding: 0px; margin: 0px;">Комнаты Квартир </h2>
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

<form action="<?php echo $form_action; ?>" method="post" name="frmForm" id="frmForm">
    <div id="dvNewButton" style="display: <?php echo $edit ? 'none' : 'block'; ?>;">
        <input id="btnAddNew" value=" Добавить Новую Комнату " onclick="showDiv('dvForm');" type="button"  />
    </div>

    <div id="dvForm"  class="dvForm" style="display: <?php echo $edit ? 'block' : 'none'; ?>;">

        <div id="dvFormHeader"><b><?php echo $edit ? 'Редактировать' : 'Добавить Новую'; ?></b></div> 
        <table cellspacing="2" cellpadding="2" style="width: 100%;">
            <tr><td width="120">Тип Комнаты:</td>
                <td><input size="35" name="room_type" value="<?php echo $edit ? $room_type : ''; ?>"/></td></tr>
       
            <tr><td>Статус</td><td><input type="checkbox" value="1" name="status" <?php echo ($edit && !$status) ? '' : 'checked="true"'; ?>/></td></tr>

        </table>
        <div id="dvFormFooter" class="clsSubmitForm">         
            <input type="button" onclick="submitForm();" id="btnSend" value="<?php echo $edit ? "Обновить" : "   Добавить  "; ?>"/>        
            <input type="button" value="  Отмена  "  onclick="<?php echo $edit ? "gotURL();" : "hideDiv('dvForm');" ?>" /> 
        </div>            
    </div>
    <div class="clear" style="height:20px;"></div>
</form>



<table cellspacing="0" cellpadding="4">
    <tr id="list_title">
        <td align="center">ID</td>             
        <td align="center">Тип Комнаты</td>
        <td align="center">Статус</td>
        <td align="center">Дата</td>
        
        <td align="center"></td>
        <td align="center"></td>
    </tr>
    <?php
    $results = $db->select(DB_PREFIX . "rooms", "", "*", "ORDER BY room_id ASC");
    foreach ($results as $rw) {
        ?>
        <tr><td class="ntitle" style="width:50px;"><?php echo $rw['room_id']; ?></td>

            <td class="ntitle"><?php echo $rw['room_type']; ?></td>              
            <td class="settingstools"><a href="?a=publish&room_id=<?php echo $rw['room_id']; ?>&status=<?php echo $rw['status'] == 1 ? "0" : "1"; ?>"><img src="images/tick_circle<?php echo $rw['status']; ?>.png" title="on/off"/></a></td>
            <td class="ntitle" ><?php echo $rw['create_date']; ?></td>
            <td class="settingstools"><a href="?a=edit&room_id=<?php echo $rw['room_id']; ?>" alt="edit"><img src="images/page_white_edit.png" title="edit"/></a></td>
            <td class="settingstools">
                <?php
                if (checkSubFiles(DB_PREFIX . "flats", "room_type_id=" . $rw['room_id'], "room_type_id") > 0) {
                    echo "";
                } else {
                    ?>
                    <a href="?a=delete&room_id=<?php echo $rw['room_id']; ?>"><img src="images/cross.png" title="delete"/></a></td
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