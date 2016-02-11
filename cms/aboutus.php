<?php
require_once 'header.php';
$error = "";
if (isset($_POST["msg"])) {
	$msg = $_POST["msg"];
	$insert = array("msg" => $user_name);
    $db->update(DB_PREFIX . "ttext", $insert,"text_id='1'");
}
$rw = $db->select_one(DB_PREFIX . "ttext", "text_id='1'");
?>

<form action="aboutus.php" method="post" name="addnew" id="addnew">
        <table cellspacing="2" cellpadding="2" style="width: 100%;">
            <tr><td><?=$rw["subject"];?></td></tr>
            <tr><td><textarea name="msg" id="msg" cols="120" rows="35"><?=$rw["msg"];?></textarea></td></tr>
        </table>

            <input type="submit" name="submitbutton" value="Обновить"/>
</form>

<?php
require_once 'footer.php';
?>
