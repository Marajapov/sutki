<?php
include_once 'usercontrol.php';
$userid = $_SESSION['userid'];
$album_id = $_REQUEST['album_id'];
$rwFlatID = $db->select_one("albums", "album_id='" . $album_id . "'", "flat_id", "", "");
$flat_id = $rwFlatID["flat_id"];
require 'flatcontrol.php';

if (isset($_POST["album_id"])) {
    $error = "";
	$name_ru = $_POST['name_ru'];
	$name_eng = $_POST['name_eng'];
	$name_native = $_POST['name_native'];
    $description_ru = $_POST['description_ru'];
	$description_eng = $_POST['description_eng'];
	$description_native = $_POST['description_native'];
	
	if ($name_ru == "")
        $error = "<b>Название не введен!</b><br>";
		
    if ($error == "") {
			$update = array(
				"name_ru" => $name_ru,
				"name_eng" => $name_eng,
				"name_native" => $name_native,
				"description_ru" => $description_ru,
				"description_eng" => $description_eng,
				"description_native" => $description_native
        	);
		
        $db->update(DB_PREFIX . "albums", $update, "album_id = " . $album_id);
		$success = 1;
    }
}
$rwFlat = $db->select_one("flats", "flat_id='" . $flat_id . "'", "name_ru", "", "");
$flat_name_ru = $rwFlat['name_ru'];
	if ($error == ""){
		$rwalbum = $db->select_one("albums", "album_id='" . $album_id . "'", "*", "", "");
		$name_ru = $rwalbum['name_ru'];
		$name_eng = $rwalbum['name_eng'];
		$name_native = $rwalbum['name_native'];
		$description_ru = $rwalbum['description_ru'];
		$description_eng = $rwalbum['description_eng'];
		$description_native = $rwalbum['description_native'];
	}
$title = "Фотоальбомы &raquo; <a href='albums.php?flat_id=".$flat_id."' style='color:#FFF'>".$flat_name_ru."</a> &raquo; ".$name_ru;
include_once 'header.php';
?>


<div class="main_border">   

			<h2 class="maintitle"><?=$error;?> <?=$title;?></h2>
            <div class="clear"></div>
            <?php if ($error) {?>
            <div class="error">Обнаружены ошибки</div><div class="clear"></div>
               <div class="panelError">     
                    <div class="well">
						<?=$error;?>                    
                  </div>
                </div>
            <div class="clear"></div>
            <? } else if ($success) {?>

               <div class="success">     
                    <div class="well">
                    
Данные успешно сохранены
						               
                  </div>
                </div>
            <div class="clear"></div>
            <? } else {?>  
            
            <div style="margin-left:30px;margin-top:10px;margin-bottom:10px">
            <ul>
                <li>- Поля, помеченные звездочкой (<font color="#FF0000">*</font>), обязательны для заполнения.</li>
            </ul>
            </div>
            <div class="clear"></div>
            
            <? } ?>

                <form action="album_edit.php" method="post" name="addnew" id="addnew">
                    <input type="hidden" name="album_id" value="<?=$album_id;?>"/>
                  <p class="textRed">Информация на русском языке</p>
                    
                    <div class="well">
                      <p class="star">Название: </p>                       
                        
                        <input type="text" class="priceforlong" name="name_ru"  value="<?=$name_ru;?>"/>
                        <div class="postinput"><b><font color="#FF0000">*</font></b>(обязательно)</div>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                      <p class="star">Информация: </p>
                        <textarea name="description_ru" class="priceforlong" rows="14" id="description_ru"><?=$description_ru;?></textarea>                       
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <p class="textRed">Информация на английском языке (необязательно)</p>
                    
                    <div class="well">
                      <p class="star">Название: </p>                       
                        
                        <input type="text" class="priceforlong" name="name_eng"  value="<?=$name_eng;?>"/>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Информация: </p>
                        <textarea name="description_eng" class="priceforlong" rows="6" id="description_eng"><?=$description_eng;?></textarea>                       
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <p class="textRed">Информация на кыргызском языке (необязательно)</p>
                    
                    <div class="well">
                      <p class="star">Название: </p>                       
                        
                        <input type="text" class="priceforlong" name="name_native"  value="<?=$name_native;?>"/>
                    </div><!--.well-->
					<div class="clear"></div>
                    
                    <div class="well">
                        <p class="star">Информация: </p>
                        <textarea name="description_native" class="priceforlong" rows="6" id="description_native"><?=$description_native;?></textarea>                       
                    </div><!--.well-->
					<div class="clear"></div>
                  
                  
                    
                    <hr />
                    <div class="well">     
                    
                    <input type="image" id="dobavitkv" src="../images/sitetools/send.png">
                    </div>
                  
</form>

</div><!--end main_border-->

<?php
include_once 'footer.php';
?>