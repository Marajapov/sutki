<?php
include_once 'usercontrol.php';
$title = "РЕДАКТУРА";
$active = "7";
$userid = $_SESSION['userid'];
$photo_id = $_REQUEST['photo_id'];
$room_id = $_REQUEST['room_id'];
$rwFlat = $db->select_one("rooms", "room_id='" . $room_id . "'", "*", "", "");
$roomname = $rwFlat["name_ru"];
$flat_id = $rwFlat["flat_id"];
require 'flatcontrol.php';
$success = false;
$error = "";

if (isset($_GET['action'])){
	if ($_GET['action']=="delete"){
		require 'roomphotocontrol.php';
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
                            $error.=$handle->error . '';
                        }

                        $handle->image_resize = true;
						$handle->image_ratio_crop = true;
                        $handle->image_x = 230;
                        $handle->image_y = 170;
                        $handle->file_new_name_body = $time;
                        $handle->Process('../images/thu/');
                        if ($handle->processed) {
                            $photo_url = $handle->file_dst_name;
                        } else {
                            $error.=$handle->error . '';
                        }

                        $insert = array(
                            "flat_id" => $flat_id,
							"room_id" => $room_id,
                            "image_url" => $photo_url
                        );
                        $db->insert(DB_PREFIX . "photos", $insert);
                    }
                }}
}
$rwPhoto = $db->select("photos", "room_id='" . $room_id . "'", "*", "", "");
$nmFlat = $db->select_one("flats", "flat_id='" . $flat_id . "'", "*", "", "");

include_once 'header.php';
?>


<div class="main_border">   
			<? $nm =(strlen($nmFlat['name_ru'])>60) ? substr($nmFlat['name_ru'], 0, 60)." ..." : $nmFlat['name_ru'];  ?>
            <? $rnm =(strlen($roomname)>60) ? substr($roomname, 0, 60)." ..." : $roomname;  ?>
  <h2 class="maintitle">Администрирование фотографий &raquo; &raquo; <a href="hotel_rooms.php?flat_id=<?=$flat_id;?>" style="color:#FFF"><?php echo $nm;?></a>  &raquo; <?php echo $rnm;?></h2>
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
            
           
<img src="../images/mainimg/<?php echo $nmFlat['main_img']; ?>" align="left" class="item" width="200px" style="margin:10px;">
			<div style="text-align:left; margin:10px">
			<b><?=$nmFlat['name_ru'];?></b>: 
                    <?php $ds =(strlen($nmFlat['description_ru'])>150) ? substr($nmFlat['description_ru'], 0, 150)." ..." : $nmFlat['description_ru']; ?>
                    <?=nl2br($ds);?>
                    <br/><br/>
                    НОМЕР: <b><?=$rwFlat['name_ru'];?></b>  <br/>
                    <?php $ds =(strlen($rwFlat['description_ru'])>200) ? substr($rwFlat['description_ru'], 0, 200)." ..." : $rwFlat['description_ru']; ?>
                    <?=nl2br($ds);?><br />
<br />
&raquo;&raquo; <a href="hotel_rooms.php?flat_id=<?=$flat_id;?>">Все номера отеля</a>
            </div>
            <div class="clear"></div>
            <hr/>
                   
  <p class="textRed">Фотографии</p>
            <? foreach ($rwPhoto as $photo){?>
            

            
            
                        <!-- wrapper div -->  
<div class='photowrapper'>  
    <!-- image -->  
    <img src='../images/thu/<?php echo $photo['image_url']; ?>' />  
    <!-- description div -->  
    <div class='photodescription'>  
        <!-- description content -->  
        <p class='photodescription_content'><a onClick='return confirm("Вы уверены, что хотите удалить?");' href="roomphotos.php?photo_id=<?=$photo['photo_id'];?>&room_id=<?=$room_id;?>&action=delete">Удалить фото</a></p>  
        <!-- end description content -->  
    </div>  
    <!-- end description div -->  
</div>  
<!-- end wrapper div -->  

            
            <? } ?>
            <div class="clear" style="margin-top:80px"></div>
                    <form action="roomphotos.php" method="post" enctype="multipart/form-data" name="editphotos" id="editphotos">
                    <input type="hidden" name="room_id" value="<?=$room_id;?>"/>
                    <input type="hidden" name="otherimg" value="1"/>
                    <p class="textSubjectSmall">Добавить фото</p>

                    <div class="well">
                    <? 
					for($k=1;$k<11-count($rwPhoto);$k++) { ?>
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