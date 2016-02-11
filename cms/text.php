<?php
require_once 'header.php';
$error = "";
$success =  false;
if (isset($_REQUEST["id"])) $id = $_REQUEST["id"];
if (isset($_POST["msg"])) {
	$msg = $_POST["msg"];
	$insert = array("msg" => $msg);
    $db->update(DB_PREFIX . "ttext", $insert,"text_id='".$id."'");
	$success =  true;
}
$rw = $db->select_one(DB_PREFIX . "ttext", "text_id='".$id."'");
?>

<form action="text.php" method="post" name="addnew" id="addnew">
        <table cellspacing="2" cellpadding="2" style="width: 100%;">
            <tr><td><?=$rw["subject"];?> <? if ($success) echo "(обновлено)";?></td></tr>
            <tr><td><textarea name="msg" id="msg" cols="120" rows="35"><?=$rw["msg"];?></textarea></td></tr>
        </table>
			<input type="hidden" name="id" value="<?=$id;?>" />
            <input type="submit" name="submitbutton" value="Обновить"/>
</form>

<?php
require_once 'footer.php';
?>
