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
        $form_action = "?a=update&region_id=" . get_request('region_id');
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
    $region_id = $_GET['region_id'];

    if ($region_id != "") {
        $rw = $db->select_one("regions", "region_id=" . $region_id);
        $region_title = $rw['region_title'];
        $status = $rw['status'];
        
    } else {
        $error = 'No Data';
    }
}

// DELETE************************************************************************************************************************
if ($isWhat == "delete") {
    $region_id = $_GET['region_id'];
    $rw = $db->select_one("regions", "region_id=" . $region_id);
    //echo var_dump($rw);

    
    
    $db->delete("regions", "region_id = " . $region_id);

}


// SET ORDER STATUS ************************************************************************************************************
if ($isWhat == "order") {
    $results = $db->select(DB_PREFIX . "regions", "", "region_id", "ORDER BY region_id DESC");
    if ($results[0]["region_id"] > 0) {
        foreach ($results as $rw) {
            $region_id = 0;
            $region_id = $rw['region_id'];
            $update = array(
                "news_order" => $news_order
            );
            $db->update(DB_PREFIX . "regions", $update, "region_id= " . $region_id);
        }
    }
}



// PUBLISH UNPUBLISH************************************************************************************************************
if ($isWhat == "publish") {
    $region_id = $_GET['region_id'];
    $status = $_GET['status'];
    $update = array(
        "status" => $status
    );
    $db->update(DB_PREFIX . "regions", $update, "region_id = " . $region_id);
}

// ADD NEW INSERT*****************************************************************************************************************
if ($isWhat == "add") {
    $error = "";
    $region_title = $_POST['region_title'];
    $status = ($_POST['status'] == "1") ? 1 : 0;
            echo $region_title . $status;
       
    if ($region_title == ""){
        $error.="<b>Region Title is empty!</b><br>";
    }
        $insert = array(
            "region_title" => $region_title,
            "status" => $status
        );
        
        $db->insert("regions", $insert);
    
}

//UPDATE*********************************************************************************************************
if ($isWhat == "update") {
    $error = "";
    $region_id = get_request('region_id');
    if ($region_id == "")
        $error.="<b>ID is empty!</b><br>";
    $region_title = $_POST['region_title'];

    $status = ($_POST['status'] == "1") ? 1 : 0;

    if ($region_title == "")
        $error.="<b>Region Title is empty!</b><br>";
                     
        $update = array(
            "region_title" => $region_title,
            "status" => $status
        );
        $db->update(DB_PREFIX . "regions", $update, "region_id = " . $region_id);
    
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
    <table cellpadding="0" cellspacing="0" border="0" style="height: 30px;">
        <tr>
            <td><input id="btnAddNew" value=" Добавить Нового Района " onclick="showDiv('dvForm');" type="button" style="display: <?php echo $edit ? 'none' : 'block'; ?>;" /></td>
            <td></td>
        </tr>
    </table> 

    <div id="dvForm"  class="dvForm" style="display: <?php echo $edit ? 'block' : 'none'; ?>;">

        <div id="dvFormHeader"><b><?php echo $edit ? 'Редактировать' : 'Добавить Новый Район'; ?></b></div>   

        <table cellspacing="2" cellpadding="2" style="width: 100%;">  
           
            <tr><td  style="text-align: right;">Район:</td>
                <td><input size="50" name="region_title"  value="<?php echo $edit ? $region_title : ''; ?>"/></td></tr>

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

    $count = $db->select_count(DB_PREFIX . "regions");
    $pagenav = new PageNav($count, $perpage, $start, "p", "");
    echo '<div align="left" style="padding-left:20px;">' . $pagenav->renderCom(3, 3) . '</div><br>';
    ?>

    <table cellspacing="0" cellpadding="4">
        <tr id="list_title">

            <td align="center">Район</td> 

            <td align="center">Статус</td>                 
            <td align="center"></td>
            <td align="center"></td>
            <td align="center">ID</td>  
        </tr>
        <?php


        $results = $db->select(DB_PREFIX . "regions", "", "*", " ORDER BY region_title ASC", $start . "," . $perpage);
        foreach ($results as $rw) {
            ?>
            <tr> 
  
                <td class="ntitle" style="width:100px;">                        
                    <?php
                    echo $rw["region_title"];
                    ?>  
                </td>

         
                <td class="settingstools"><a href="?a=publish&region_id=<?php echo $rw['region_id']; ?>&status=<?php echo $rw['status'] == 1 ? "0" : "1"; ?>"><img src="images/tick_circle<?php echo $rw['status']; ?>.png" title="on/off"/></a></td>
                <td class="settingstools"><a href="?a=edit&region_id=<?php echo $rw['region_id']; ?>" alt="edit"><img src="images/page_white_edit.png" title="edit"/></a></td>
                <td class="settingstools"><a href="?a=delete&region_id=<?php echo $rw['region_id']; ?>"><img src="images/cross.png" title="delete"/></a></td>  
                <td class="settingstools">
                    <?php echo $rw['region_id']; ?>
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
