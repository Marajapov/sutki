<?php
include_once 'usercontrol.php';
$title = "Категории номеров";
$active = "7";

$userid = $_SESSION['userid'];
$flat_id = $_REQUEST['flat_id'];
require 'flatcontrol.php';
$success = false;
$error = "";
$rwFlat = $db->select_one("flats", "flat_id='" . $flat_id . "'", "*", "", "");
$name_ru = $rwFlat['name_ru'];
include_once 'header.php';
?>


<div class="main_border"  align="center">   

			<h2 class="maintitle" align="left"><?=$title?> : <?=$name_ru;?></h2>
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
            <div style="width:600px">
            	<img src="../images/mainimg/<?php echo $rwFlat['main_img']; ?>" align="left" class="item" width="200px" style="margin:10px;">
				<div style="text-align:left; margin-top:10px"><br />

					<b><?=$rwFlat['name_ru'];?></b><br/><br/>
                    
            	</div>
           	</div>
            <div class="clear"></div>
            <hr/>
            <div class="clear"></div>
            <div class="rightText"><a href="hotel_rooms_add.php?flat_id=<?=$flat_id;?>">Добавить номер</a></div>
            <hr/>
            <div class="clear"></div>
            <?php
    		$results = $db->select("rooms", "flat_id=".$flat_id, "*", " ORDER BY flat_id DESC","");
			if(count($results)>0){
			?>
<table width="100%">
				<tr> 

                    <td>
                    
						
					</td>

					<td style="width:300px">
						Название
					</td>
                    <td>&nbsp;
						
					</td>

                    <td>&nbsp;
						
					</td>
                     <td>&nbsp;
						
					</td>
				</tr>


    <?php
    foreach ($results as $rw) {
		$photosdb = $db->select("photos", "room_id=".$rw["room_id"], "*", "","");
		$ph = count($photosdb)>0?$photosdb[0]:"";
        ?>
        
        		 <tr>
				   
                   <td>
                    	<img src="../images/thu/<?php echo $ph['image_url']; ?>" alt="" class="item">
					</td>

					<td valign="top">
                    <?php $nm =(strlen($rw['name_ru'])>30) ? substr($rw['name_ru'], 0, 30)." ..." : $rw['name_ru']; echo $nm; ?><br/><br/>
                    
					</td>
                    <td valign="top">
                   	<a href = "roomphotos.php?room_id=<?php echo $rw['room_id'];?>">Фотки</a>
					</td>
                    <td valign="top">
                    <a href="hotel_rooms_edit.php?room_id=<?php echo $rw['room_id']; ?>">Редактировать</a>
					</td>
                    <td valign="top">
                    
                    <a href="delete_object.php?room_id=<?php echo $rw['room_id']; ?>" onClick='return confirm("Вы уверены, что хотите удалить?");'>Удалить</a>
					</td>
				</tr>
    <?php } ?>
			</table>
            <?php } ?>
</div><!--end main_border-->

<?php
include_once 'footer.php';
?>