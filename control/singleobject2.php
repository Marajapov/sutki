<tr>
				   <td>
						<? 
							switch ($rw['flat_type']){
								case 1: echo "Квартира"; break;
								case 2: echo "Особняк"; break;
								case 3: echo "Отель"; break;
								case 4: echo "Сауна"; break;
							}
						?>
					</td>
                   <td>
						<a href="flat_edit.php?flat_id=<?php echo $rw['flat_id']; ?>">
                    	<img src="../images/mainimg/<?php echo $rw['main_img']; ?>" alt="" class="item" width="200px"></a>
					</td>

					<td valign="top">
                    
                    <?php $nm =(strlen($rw['name_ru'])>30) ? substr($rw['name_ru'], 0, 30)." ..." : $rw['name_ru']; echo $nm; ?><br/><br/>
                    <?php $ds =(strlen($rw['description_ru'])>100) ? substr($rw['description_ru'], 0, 100)." ..." : $rw['description_ru']; ?>
                    <?=nl2br($ds);?>
					</td>

                    <td valign="top">
                    <?php if ($rw['flat_type']<3){?>
                    
                    <a href = "flatphotos.php?flat_id=<?php echo $rw['flat_id'];?>">Фотографии</a>
					<br/><span class="tinytext">[ 
						<? 
							$c = $db->select_count("photos", "flat_id=".$rw['flat_id']);
							if ($c==0) echo "нет фото";
							else echo "всего: ".$c
						?> ]</span>
					<?php } ?>
                    <?php if ($rw['flat_type']>2){?>
                    	<a href = "albums.php?flat_id=<?php echo $rw['flat_id'];?>">Фотоальбомы</a>
						<br/><span class="tinytext">[ 
						<? 
							$c = $db->select_count("albums", "flat_id=".$rw['flat_id']);
							if ($c==0) echo "нет альбома";
							else echo "всего: ".$c
						?> ]</span>
					<?php } ?>
					</td>
                    <td valign="top">
                    <?php if ($rw['flat_type']==1){?><a href="flat_edit.php?flat_id=<?php echo $rw['flat_id']; ?>">Редактировать</a><?php } ?>
                    <?php if ($rw['flat_type']==2){?><a href="flat_edit.php?flat_id=<?php echo $rw['flat_id']; ?>">Редактировать</a><?php } ?>
                    <?php if ($rw['flat_type']==3){?>
					<a href="hotel_edit.php?flat_id=<?php echo $rw['flat_id']; ?>">Редактировать</a><br /><br />
                    <a href="hotel_rooms.php?flat_id=<?php echo $rw['flat_id']; ?>">Категории номеров </a>
					<?php } ?>
                    <?php if ($rw['flat_type']==4){?>
                    <a href="sauna_edit.php?flat_id=<?php echo $rw['flat_id']; ?>">Редактировать</a><br /><br />
					<a href="sauna_rooms.php?flat_id=<?php echo $rw['flat_id']; ?>">Категории номеров </a>
                    <br /><br />
                    <a href="hotel_rooms.php?flat_id=<?php echo $rw['flat_id']; ?>"></a>
					<?php } ?>
					</td>
                    <td valign="top">
                    
                    <a  onClick='return confirm("Вы уверены, что хотите удалить?");' href="delete_object.php?flat_id=<?php echo $rw['flat_id']; ?>">Удалить</a>
					</td>
				</tr>