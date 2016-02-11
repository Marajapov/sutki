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
        $form_action = "?a=update&user_id=" . get_request('user_id');
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
    case "employee":
        $isWhat = "employee";
        $form_action = "?a=add";
        break;
    default:
        $isWhat = "";
        $form_action = "?a=add";
        break;
        break;
}

function checkUsernameByID($username,$user_id){
    global $db;
    $rw = $db->select_one(DB_PREFIX . "users", "user_id=" . $user_id." AND user_name='".$username."'");
    if($rw['user_name']!=""){
        return true;
    }else{
        return false;
    }
}

function checkUsername($username){
    global $db;
    $rw = $db->select_one(DB_PREFIX . "users", "user_name='".$username."'");
    if($rw['user_name']!=""){
        return true;
    }else{
        return false;
    }
}


// EDIT*********************************************************************************************************************************
if ($isWhat == "edit") {
    $user_id = $_GET['user_id'];

    if ($user_id != "") {
        $rw = $db->select_one(DB_PREFIX . "users", "user_id=" . $user_id);
        $user_name = $rw['user_name'];
        $user_status = $rw['user_status'];
        $full_name = $rw['full_name'];
        $image_url = $rw['image_url'];
        $email = $rw['email'];
        $phone = $rw['phone'];
        $status = $rw['status'];
    } else {
        $error = 'No Data';
    }
}

// DELETE************************************************************************************************************************
if ($isWhat == "delete") {
    $user_id = $_GET['user_id'];
    $rw = $db->select_one(DB_PREFIX . "users", "user_id=" . $user_id);
    if ($rw["image_url"] != "") {
        deleteFile("../media/user/" . $rw["image_url"]);
    }
    $db->delete(DB_PREFIX . "users", "user_id = " . $user_id);
}

// PUBLISH UNPUBLISH************************************************************************************************************
if ($isWhat == "employee") {
    $user_id = $_GET['user_id'];
    $status = $_GET['status'];
    $update = array(
        "status" => $status,
        "new" => 0
    );
    $db->update(DB_PREFIX . "users", $update, "user_id = " . $user_id);
}

// PUBLISH UNPUBLISH************************************************************************************************************
if ($isWhat == "publish") {
    $user_id = $_GET['user_id'];
    $status = $_GET['status'];
    $update = array(
        "user_status" => $status
    );
    $db->update(DB_PREFIX . "users", $update, "user_id = " . $user_id);
}


// ADD NEW INSERT*****************************************************************************************************************
if ($isWhat == "add") {

    $error = "";
    if ($_POST['user_name'] == "") $error .= "<b>Имя пользователя !</b><br>";
    if ($_POST['full_name'] == "") $error .= "<b>Имя & Фамилия!</b><br>";
    if ($_POST['user_password'] == "") $error .= "<b>Пароль ! </b><br>";
    if ($_POST['user_password'] != $_POST['user_password2']) $error .= "<b>Подтверждение пароля !</b><br>";

    if($error==""){
        if(checkUsername($_POST['user_name'])) $error .= "<b>Имя пользователя (not empty) !</b><br>";
    }

    if ($error == "") {

        $user_name = $_POST['user_name'];
        $full_name = $_POST['full_name'];
        $image_url = $_POST['image_url'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $user_status = ($_POST['user_status'] == "1") ? 1 : 0;
        $user_password = md5($_POST['user_password']);
        $user_type = 1;
        $image_url = $_FILES['image_url'];
        $pic1 = "";

        if ($image_url['error'] <= 0) {
            $handle = new Upload($image_url);
            $newname = time();
            if ($handle->uploaded) {
                $handle->image_resize = true;
                $handle->image_x = 164;
                $handle->image_y = 174;
                $handle->file_new_name_body = $newname;
                $handle->Process('../media/user/');
                if ($handle->processed) {
                    $pic1 = $handle->file_dst_name;
                } else {
                    $error .= $handle->error . '';
                }
            }
        }

        $insert = array(
            "user_name" => $user_name,
            "user_password" => $user_password,
            "user_realname" => $full_name,
            "email" => $email,
            "user_type" => $user_type,
            "phone" => $phone,
            "image_url" => $pic1,
            "user_status" => $user_status
        );
        $db->insert(DB_PREFIX . "users", $insert);

    }
}

//UPDATE*********************************************************************************************************
if ($isWhat == "update") {
    $error = "";
    $user_id = get_request('user_id');
    if ($user_id == "")
        $error .= "<b>ID is empty!</b><br>";

    if ($_POST['user_name'] == "") $error .= "<b>Имя пользователя !</b><br>";
    if ($_POST['full_name'] == "") $error .= "<b>Имя & Фамилия!</b><br>";

    if($error==""){
        if(checkUsername($_POST['user_name'])){
            if(!checkUsernameByID($_POST['user_name'],$user_id)){

            }
        }
        if ($_POST['user_password'] != ""){
            if ($_POST['user_password'] != $_POST['user_password2']) $error .= "<b>Подтверждение пароля !</b><br>";
            $user_password = md5($_POST['user_password2']);
        }
    }

    if ($error == "") {
        $user_name = $_POST['user_name'];
        $full_name = $_POST['full_name'];
        $image_url = $_POST['image_url'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $user_status = ($_POST['user_status'] == "1") ? 1 : 0;

        $user_type = 1;
        $image_url = $_FILES['image_url'];
        $pic1 = "";

        if ($image_url['error'] <= 0) {
            $handle = new Upload($image_url);
            $newname = time();
            if ($handle->uploaded) {
                $handle->image_resize = true;
                $handle->image_x = 164;
                $handle->image_y = 174;
                $handle->file_new_name_body = $newname;
                $handle->Process('../media/user/');
                if ($handle->processed) {
                    $pic1 = $handle->file_dst_name;
                } else {
                    $error .= $handle->error . '';
                }
            }
        }

        if($_POST['user_password2']!="") {
            $insert = array(
                "user_name" => $user_name,
                "user_password" => $user_password,
                "user_realname" => $full_name,
                "email" => $email,
                "user_type" => $user_type,
                "phone" => $phone,
                "image_url" => $pic1,
                "user_status" => $user_status
            );
        }else{
            $insert = array(
                "user_name" => $user_name,
                "user_realname" => $full_name,
                "email" => $email,
                "user_type" => $user_type,
                "phone" => $phone,
                "image_url" => $pic1,
                "user_status" => $user_status
            );
        }
        $db->update(DB_PREFIX . "users", $insert,"user_id=".$user_id);
        $db->debug();
    }
}

if ($error != "")
    echo '<div class="msgerror">' . $error . '</div>';
?>

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
            <td><input id="btnAddNew" value=" Добавить Новый Сотрудник " onclick="showDiv('dvForm');" type="button"
                       style="display: <?php echo $edit ? 'none' : 'block'; ?>;"/></td>
            <td></td>
        </tr>
    </table>

    <div id="dvForm" class="dvForm" style="display: <?php echo $edit ? 'block' : 'none'; ?>;">

        <div id="dvFormHeader"><b><?php echo $edit ? 'Редактировать' : 'Добавить Новый'; ?></b></div>

        <table cellspacing="2" cellpadding="2" style="width: 100%;">

            <tr>
                <td style="text-align: right;">Имя пользователя :</td>
                <td><input size="50" name="user_name" value="<?php echo $edit ? $user_name : ''; ?>"/></td>
            </tr>
            <tr>
                <td style="text-align: right;">Пароль :</td>
                <td><input size="50" name="user_password" value=""/></td>
            </tr>
            <tr>
                <td style="text-align: right;">Подтверждение пароля:</td>
                <td><input size="50" name="user_password2" value=""/></td>
            <tr>
                <td style="text-align: right;">Имя & Фамилия :</td>
                <td><input size="50" name="full_name" value="<?php echo $edit ? $full_name : ''; ?>"/></td>
            </tr>
            <tr>
                <td style="text-align: right;">Телефон :</td>
                <td><input size="50" name="phone" value="<?php echo $edit ? $phone : ''; ?>"/></td>
            </tr>
            <tr>
                <td style="text-align: right;">E-mail:</td>
                <td><input size="50" name="email" value="<?php echo $edit ? $email : ''; ?>"/></td>
            </tr>

            <tr>
                <td style="text-align: right;">Картинка:</td>
                <td><input type="file" name="image_url"/>
                    <?php
                    if ($edit && $image_url != "") {
                        ?>
                        &nbsp;&nbsp;Удалить <input type="checkbox" name="delete_image1" value="1"><img
                            src="../media/user/<?php echo $image_url; ?>" width="50" alt="">
                        <input type="hidden" name="hd_image_url" value="<?php echo $image_url; ?>">
                        <?php } ?>
                </td>
            </tr>

            <tr>
                <td style="text-align: right;">Статус</td>
                <td>
                    <input type="checkbox" value="1"
                           name="user_status" <?php echo ($edit && !$user_status) ? '' : 'checked="true"'; ?>/>
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
    <td align="center">Фотография</td>
    <td align="center">Имя & Фамилия</td>
    <td align="center">Телефон.</br> E-mail</td>
    <td align="center">Имя пользователя</td>
    <td align="center">Статус</td>
    <td align="center"></td>
    <td align="center"></td>
</tr>
<?php

$results = $db->select(DB_PREFIX."users", "user_type < 2", "*", " ORDER BY user_date DESC, user_id DESC");
foreach ($results as $rw) {
    ?>
<td class="settingstools">
    <a name="<?php echo $rw['user_id']; ?>"></a>
    <b><?php echo $rw['user_id']; ?></b>
</td>

<td class="ntitle" style="width:170px;">
    <?php
    if ($rw["image_url"] != "") {
        echo '<img src="../media/user/' . $rw["image_url"] . '.jpg" width="164">';
    }
    ?>
</td>

<td class="ntitle" style="width:100px;">
    <?php
    echo $rw["full_name"];
    ?>
</td>

<td class="ntitle" style="width:120px;">
    <?php
    echo $rw["phone"];
    ?>  </br>
    <?php
    echo $rw["email"];
    ?>
</td>
<td class="ntitle" style="width:80px;">
    <?php
    echo $rw["user_name"];
    ?>
</td>
<td class="settingstools"><a
    href="?a=publish&user_id=<?php echo $rw['user_id']; ?>&status=<?php echo $rw['user_status'] == 1 ? "0" : "1"; ?>"><img
    src="images/tick_circle<?php echo $rw['user_status']; ?>.png" title="on/off"/></a></td>
<td class="settingstools"><a href="?a=edit&user_id=<?php echo $rw['user_id']; ?>" alt="edit"><img
    src="images/page_white_edit.png" title="edit"/></a></td>
<td class="settingstools"><a href="?a=delete&user_id=<?php echo $rw['user_id']; ?>">
    <img src="images/cross.png" border="0"/></a>
</td>

</tr>
 <?php
}
?>
</table>

<input type="hidden" id="hdID">



<?php
require_once 'footer.php';
?>
