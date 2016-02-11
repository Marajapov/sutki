<?php
include_once 'usercontrol.php';
$title = "РЕДАКТУРА";
$active = "7";

$userid = $_SESSION['userid'];
$album_id = $_REQUEST['album_id'];

$photo_id = $_REQUEST['photo_id'];
$rwFlatID = $db->select_one("albums", "album_id='" . $album_id . "'", "flat_id", "", "");
$flat_id = $rwFlatID["flat_id"];
require 'flatcontrol.php';
$success = false;
$error = "";

if (isset($_GET['action'])){
	if ($_GET['action']=="delete"){
		require 'photocontrol.php';
		$rwDelPhoto = $db->select_one("photos", "photo_id='" . $photo_id . "'", "*", "", "");
		unlink("../images/big/".$rwDelPhoto["image_url"]);
		unlink("../images/thu/".$rwDelPhoto["image_url"]);
		$db->delete(DB_PREFIX . "photos", "photo_id = " . $photo_id);
	}	
}

if (isset($_POST['otherimg'])) {	
	for ($i = 1; $i < 11; $i++) {
                $strPic = $_FILES['photo' . $i];
                if (isset($strPic)) {
                    $handle = new Upload($strPic);
                    if ($handle->uploaded) {
                        $time = time();
                        $handle->image_resize = true;
                        $handle->image_ratio_y = true;
                        $handle->image_x = 800;
                        $handle->file_new_name_body = $time;
                        $handle->Process('../images/big/');
                        if ($handle->processed) {
                            $photo_url = $handle->file_dst_name;
                        } else {
                            continue;
                        }
						MakeStamp('../images/big/'.$photo_url);

                        $handle->image_resize = true;
						$handle->image_ratio_crop = true;
                        $handle->image_x = 230;
                        $handle->image_y = 170;
                        $handle->file_new_name_body = $time;
                        $handle->Process('../images/thu/');
                        if ($handle->processed) {
                            $photo_url = $handle->file_dst_name;
                        } else {
							@unlink('../images/big/'.$time);
                            continue;
                        }

                        $insert = array(
                            "flat_id" => $flat_id,
							"album_id" => $album_id,
                            "image_url" => $photo_url
                        );
                        $db->insert(DB_PREFIX . "photos", $insert);
                    }
                }}
}
$rwPhoto = $db->select("photos", "album_id='" . $album_id . "'", "*", "", "");
$rwFlat = $db->select_one("flats", "flat_id='" . $flat_id . "'", "*", "", "");
$total = count($rwPhoto);
$maxcount = $total > 10 ? 21-$total: 11;
include_once 'header.php';
?>


<div class="main_border">   
			<? $nm =(strlen($rwFlat['name_ru'])>60) ? substr($rwFlat['name_ru'], 0, 60)." ..." : $rwFlat['name_ru'];  ?>
  <h2 class="maintitle">Администрирование фотографий &raquo; <a style='color:#FFF' href="albums.php?flat_id=<?=$flat_id?>"><?php echo $nm;?></a></h2>
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
            <? } ?>
  <? if (count($rwPhoto)>0) {?>            
  <p class="textSubjectSmall">Фотографии альбома</p>
            <? foreach ($rwPhoto as $photo){?>
            

            
            
                        <!-- wrapper div -->  
<div class='photowrapper'>  
    <!-- image -->  
    <img src='../images/thu/<?php echo $photo['image_url']; ?>' />  
    <!-- description div -->  
    <div class='photodescription'>  
        <!-- description content -->  
        <p class='photodescription_content'><a onClick='return confirm("Вы уверены, что хотите удалить?");' href="albumphotos.php?photo_id=<?=$photo['photo_id'];?>&album_id=<?=$album_id;?>&action=delete">Удалить фото</a></p>  
        <!-- end description content -->  
    </div>  
    <!-- end description div -->  
</div>  
<!-- end wrapper div -->  

            
            <? } ?>
            <div class="clear" style="margin-top:80px"></div>
            <? } ?>
                    <form action="albumphotos.php" method="post" enctype="multipart/form-data" name="editphotos" id="editphotos">
                    <input type="hidden" name="album_id" value="<?=$album_id;?>"/>
                    <input type="hidden" name="otherimg" value="1"/>
                    <p class="textSubjectSmall">Добавить фото</p>

                    <div class="well">
                    <? 
					for($k=1;$k<$maxcount;$k++) { ?>
                        <input type="file" class="longtitude" name="photo<?=$k;?>"> 
                        <div class="clear"></div>
                        </br>
                    <? } ?>                           
                    </div><!--.well--> 
                    <div class="clear"></div>
                    
                    <hr />
                    <div class="well">     
                    
                    <input type="image" id="dobavitkv" src="../images/sitetools/send.png"> <br/>

                    </div>
                  
</form>
					

</div><!--end main_border-->

<?php
include_once 'footer.php';
?>