<?php
require_once 'header.php';
$error = "";
$success =  false;
$id = 0;
if (isset($_POST["name"])) {
	$name = $_POST["name"];
	$order = (int)$_POST["order"];
	$id = $_POST["id"];
	$pic1 = "";
	$image_url = $_FILES['image_url'];
	if ($image_url['error'] <= 0) {
           $handle = new Upload($image_url);
		   if ($handle->uploaded) {
                $handle->image_resize = false;
                $handle->image_ratio_y = false;
                $handle->file_new_name_body = $id;
                $handle->Process('../images/inventoryicons/');
                if ($handle->processed) {
                    $pic1 = $handle->file_dst_name;
                } 
			}
	}
	
	$update = $pic1=="" ? array("inventory" => $name,"order" => $order) : array("inventory" => $name,"order" => $order, "img" => $pic1);
    $db->update(DB_PREFIX . "inventory", $update,"inventory_id='".$id."'");
	$success =  true;
}
$rws = $db->select(DB_PREFIX . "inventory");
foreach ($rws as $rw){
?>

<form enctype="multipart/form-data" action="inventory.php" method="post" name="addnew<?=$rw["inventory_id"]?>" id="addnew<?=$rw["inventory_id"]?>">
        <table cellspacing="2" cellpadding="2" style="width: 100%;">
            <tr><td><? if ($success && $rw["inventory_id"]==$id) echo "(обновлено)";?></td></tr>
            <tr><td>
            <img src="../images/inventoryicons/<?=$rw["img"];?>" width="36px">
            <input type="file" class="longtitude" name="image_url">
             <input type="text" style="width:40px" name="order" id="order" value="<?=$rw["order"];?>" />
             <input type="text" style="width:400px" name="name" id="name" value="<?=$rw["inventory"];?>" /><input type="hidden" name="oldimg" value="<?=$rw["img"];?>"/> <input type="submit" name="submitbutton<?=$rw["inventory_id"]?>" value="Обновить"/></td></tr>
        </table>
			<input type="hidden" name="id" value="<?=$rw["inventory_id"]?>" />
            
</form>

<?php
}
require_once 'footer.php';
?>
