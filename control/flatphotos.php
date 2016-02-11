<?php
include_once 'usercontrol.php';
$title = "РЕДАКТУРА";
$active = "7";

$userid = $_SESSION['userid'];
$flat_id = $_REQUEST['flat_id'];
$photo_id = $_REQUEST['photo_id'];

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

if (isset($_POST['mainimg'])){
	$image_url = $_FILES['image_url'];
	
	if ($image_url['error'] <= 0) {
			$handle = new Upload($image_url);
            $newname = time();
            if ($handle->uploaded) {
                $handle->image_resize = true;
				$handle->image_ratio_x = true;
                //$handle->image_ratio_y = true;
				//$handle->image_ratio_crop = true;
                //$handle->image_x = 800;
				$handle->image_y = 485;
                $handle->file_new_name_body = $newname;
                //$path=substr(date("d.m.Y"),3,2);
                $handle->Process('../images/big/');
                if ($handle->processed) {
                    $pic1 = $handle->file_dst_name;
                } else {
                    $error.=$handle->error . '';
                }
				MakeStamp('../images/big/'.$photo_url);

                $handle->image_resize = true;
                //$handle->image_ratio_y = true;
				$handle->image_ratio_crop = true;
                $handle->image_x = 455;
                $handle->image_y = 276;
                $handle->file_new_name_body = $newname;
                //$path=substr(date("d.m.Y"),3,2);
                $handle->Process('../images/mainimg/');
                if ($handle->processed) {
                    $pic1 = $handle->file_dst_name;
                } else {
                    $error.=$handle->error . '';
                }

                $handle->image_resize = true;
                //$handle->image_ratio_y = true;
				$handle->image_ratio_crop = true;
                $handle->image_x = 230;
                $handle->image_y = 170;
                $handle->file_new_name_body = $newname;
                //$path=substr(date("d.m.Y"),3,2);
                $handle->Process('../images/thu/');
                if ($handle->processed) {
                    $pic1 = $handle->file_dst_name;
					unlink("../images/big/".$_POST["oldphoto"]);
					unlink("../images/mainimg/".$_POST["oldphoto"]);
					unlink("../images/thu/".$_POST["oldphoto"]);
                } else {
                    $error.=$handle->error . '';
                }
				$update = array(
				"main_img" => $pic1
				);
				if ($error == "") {
					$db->update(DB_PREFIX . "flats", $update, "flat_id = " . $flat_id);
					$success =true;
				}
				
            }	
	} else $error="Главное фото: Файл не выбран";
}
if (isset($_POST['otherimg'])) {	
	for ($i = 1; $i < 11; $i++) {
                $strPic = $_FILES['photo' . $i];
                if (isset($strPic)) {
                    $handle = new Upload($strPic);
                    if ($handle->uploaded) {
                        $time = time();
                        $handle->image_resize = true;
                        //$handle->image_ratio_y = true;
						$handle->image_ratio_crop = true;
                        $handle->image_x = 800;
						$handle->image_y = 485;
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
                            "image_url" => $photo_url
                        );
                        $db->insert(DB_PREFIX . "photos", $insert);
                    }
                }}
}
$rwPhoto = $db->select("photos", "room_id='0' AND album_id='0' AND flat_id='" . $flat_id . "'", "*", "", "");
$rwFlat = $db->select_one("flats", "flat_id='" . $flat_id . "'", "*", "", "");

include_once 'header.php';
?>


<div class="main_border">   
			<? $nm =(strlen($rwFlat['name_ru'])>60) ? substr($rwFlat['name_ru'], 0, 60)." ..." : $rwFlat['name_ru'];  ?>
  <h2 class="maintitle">Администрирование фотографий &raquo; <?php echo $nm;?></h2>
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
            <? } else if (count($rwPhoto)==0) {?>  
            
            <p class="textRed">Фото</p>
                    <p style="line-height: 16px;">
                        Если Вы являетесь собственником квартиры и хотели бы сдавать свою квартиру в посуточную аренду мы готовы к сотрудничеству с Вами на взаимовыгодной основе. Наш фотограф выедет к Вам и бесплатно сделает фото Вашей квартиры и они будут размещены на страницах нашего сайта и/или в базе данных объектов.
                  </p>
                    <br/>
                    <p style="line-height: 16px;">
                        Если Вы сдаете свою квартиру в посуточную аренду впервые, целесообразно воспользоваться услугами нашего дизайнера для достижения максимального эффекта от сдачи Вашей квартиры в аренду. Даже если Вы ранее сдавали квартиру на длительный срок, консультация может быть Вам полезна, так как требования к посуточной аренде отличаются от долгосрочной сдачи. Даже банальная переклейка обоев и расстановка мебели может произвести значительный эффект. Стоимость первоначальной консультации дизайнера с выездом на объект и определением объема работ - 200 сом (Бишкек).
                  </p>
                    <br/>
                    <p style="line-height: 16px;">
                        Ввиду острого дефицита гостиничных номеров в Бишкеке доход от сдачи квартиры в краткосрочную аренду оказывается, как правило, значительно выше дохода, полученного от длительной аренды, а сохранность квартиры намного лучше.
                    </p>
                    <br/>
  <div class="clear"></div>
            
            <? } ?>
            
           

                     
                    <p class="textSubjectSmall">Главное Фото - <b><font color="#FF0000">Минимальное разрешение фотографии должно составлять 720 (ширина) на 477 (высота) пикселей</font></b></p>
                    
                    <div class="well">                        
                    <form action="flatphotos.php" method="post" enctype="multipart/form-data" name="editphotos" id="editphotos">
                    <img src="../images/mainimg/<?php echo $rwFlat['main_img']; ?>" alt="" class="item" width="200px"><br/>
                    <input type="hidden" name="flat_id" value="<?=$flat_id;?>"/>
                    <input type="hidden" name="mainimg" value="1"/>
                    <input type="hidden" name="oldphoto" value="<?php echo $rwFlat['main_img']; ?>"/>
                    <input type="file" class="longtitude" name="image_url"><br/>
                    <input type="submit" name="button" id="button" value="Сменить главное фото" />
                    </form> 
                    
                    </div><!--.well--> 
                    <div class="clear"></div>
  <p class="textSubjectSmall">Фотографии объекта</p>
            <? foreach ($rwPhoto as $photo){?>
            

            
            
                        <!-- wrapper div -->  
<div class='photowrapper'>  
    <!-- image -->  
    <img src='../images/thu/<?php echo $photo['image_url']; ?>' />  
    <!-- description div -->  
    <div class='photodescription'>  
        <!-- description content -->  
        <p class='photodescription_content'><a onClick='return confirm("Вы уверены, что хотите удалить?");' href="flatphotos.php?photo_id=<?=$photo['photo_id'];?>&flat_id=<?=$flat_id;?>&action=delete">Удалить фото</a></p>  
        <!-- end description content -->  
    </div>  
    <!-- end description div -->  
</div>  
<!-- end wrapper div -->  

            
            <? } ?>
            <div class="clear" style="margin-top:80px"></div>
                    <form action="flatphotos.php" method="post" enctype="multipart/form-data" name="editphotos" id="editphotos">
                    <input type="hidden" name="flat_id" value="<?=$flat_id;?>"/>
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