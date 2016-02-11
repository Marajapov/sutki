<?php
require_once 'header.php';

global $action, $isWhat, $edit;
$edit = false;
$action = get_request('a');
$error = "";
switch ($action) {
    case "edit":
        $isWhat = "edit";
        $form_action = "?a=update&comment_id=" . get_request('comment_id');
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
$category_id = 1;
$sub_category_id = 3;
// EDIT*********************************************************************************************************************************
if ($isWhat == "edit") {
    $comment_id = $_GET['comment_id'];

    if ($comment_id != "") {
        $rw = $db->select_one("comments", "comment_id=" . $comment_id);
        $flat_id = $rw['flat_id'];
        $name = $rw['name'];
        $description = $rw['description'];

        $status = ($rw['status'] == "1") ? 1 : 0;
        $new = ($rw['new'] == "1") ? 1 : 0;
    } else {
        $error = 'No Data';
    }
}

// DELETE************************************************************************************************************************
if ($isWhat == "delete") {
    $comment_id = $_GET['comment_id'];
    $rw = $db->select_one("comments", "comment_id=" . $comment_id);
    //echo var_dump($rw);



    $db->delete("comments", "comment_id = " . $comment_id);
}


// SET ORDER STATUS ************************************************************************************************************
if ($isWhat == "order") {
    $results = $db->select("comments", "", "comment_id", "ORDER BY comment_id DESC");
    if ($results[0]["comment_id"] > 0) {
        foreach ($results as $rw) {
            $comment_id = 0;
            $comment_id = $rw['comment_id'];
            $update = array(
                "news_order" => $news_order
            );
            $db->update("comments", $update, "comment_id= " . $comment_id);
        }
    }
}



// PUBLISH UNPUBLISH************************************************************************************************************
if ($isWhat == "publish") {
    $comment_id = $_GET['comment_id'];
    $status = $_GET['status'];
    $update = array(
        "status" => $status,
        "new" => 0
    );
    $db->update("comments", $update, "comment_id = " . $comment_id);
}

//UPDATE*********************************************************************************************************
if ($isWhat == "update") {
    $error = "";
    $comment_id = get_request('comment_id');
    if ($comment_id == "")
        $error.="<b>ID is empty!</b><br>";
    $flat_id = $_POST['flat_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $status = ($_POST['status'] == "1") ? 1 : 0;

    if ($name == "")
        $error.="<b>Name is empty!</b><br>";

    $update = array(
        "flat_id" => $flat_id,
        "name" => $name,
        "description" => $description,
        "status" => 1,
        "new" => 0
    );
    $db->update(DB_PREFIX . "comments", $update, "comment_id = " . $comment_id);
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
    <span style="color: red;"><b>Please wait....</b></span>
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


    <div id="dvForm"  class="dvForm" style="display: <?php echo $edit ? 'block' : 'none'; ?>;">

        <div id="dvFormHeader"><b><?php echo $edit ? 'Редактировать' : 'Добавить Новую Комментарию'; ?></b></div>   

        <table cellspacing="2" cellpadding="2" style="width: 100%;">  

            <tr><td  style="text-align: right;">Квартира:</td>
                <td><input size="50" name="flat_id"  value="<?php echo $edit ? $flat_id : ''; ?>"/></td></tr>
            <tr><td  style="text-align: right;">Автор:</td>
                <td><input size="50" name="name"  value="<?php echo $edit ? $name : ''; ?>"/></td></tr>
            <tr><td  style="text-align: right;">Описание:</td>
                <td>
                    <textarea name="description" cols="40" rows="3" id="description"><?php echo $edit ? $description : ''; ?></textarea>
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

$count = $db->select_count(DB_PREFIX . "comments");
$pagenav = new PageNav($count, $perpage, $start, "p", "");
echo '<div align="left" style="padding-left:20px;">' . $pagenav->renderCom(3, 3) . '</div><br>';
?>

<table cellspacing="0" cellpadding="4">
    <tr id="list_title">

        <td align="center">Квартиры</td> 
        <td align="center">Автор</td>  
        <td align="center">Текст</td>             
        <td align="center">Дата</td> 
        <td align="center">Статус</td>               
        <td align="center"></td>
        <td align="center"></td>
        <td align="center">ID</td>  
    </tr>
<?php
$rwFlatsCat = $db->select("flats", "", "*", "ORDER BY flat_id ASC");
$arrFlatCat = array();
foreach ($rwFlatsCat as $flat) {

    $arrFlatCat[$flat['flat_id']] = $flat['address'];
}


$results = $db->select("comments", "", "*", " ORDER BY comment_id DESC", $start . "," . $perpage);
foreach ($results as $rw) {
    if ($rw["new"] == '1') {
        echo '<tr style="color:red;">';
    } else {
        echo '<tr>';
    }
    ?>


        <td class="ntitle" style="width:100px;">                        
            <b> <?php
    echo $rw["flat_id"];
    ?>  
            </b>
        </td>
        <td class="ntitle" style="width:100px;">                        
                <?php
                echo $rw["name"];
                ?>  
        </td>
        <td class="ntitle" style="width:100px;">                        
            <?php
            echo $rw["description"];
            ?>  
        </td>
        <td class="ntitle" style="width:100px;">                        
            <?php
            echo $rw["create_date"];
            ?>  
        </td>

        <td class="settingstools"><a href="?a=publish&comment_id=<?php echo $rw['comment_id']; ?>&status=<?php echo $rw['status'] == 1 ? "0" : "1"; ?>"><img src="images/tick_circle<?php echo $rw['status']; ?>.png" title="on/off"/></a></td>
        <td class="settingstools"><a href="?a=edit&comment_id=<?php echo $rw['comment_id']; ?>" alt="edit"><img src="images/page_white_edit.png" title="edit"/></a></td>
        <td class="settingstools"><a href="?a=delete&comment_id=<?php echo $rw['comment_id']; ?>"><img src="images/cross.png" title="delete"/></a></td>  
        <td class="settingstools">
    <?php echo $rw['comment_id']; ?>
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
