<?php
include_once 'usercontrol.php';

$user_id = $_SESSION["userid"];
$user_name = $_SESSION["name"];

if(isset($_GET["action"])){
	$comment_id = $_GET["comment_id"];
	$rwComment = $db->select_one("comments", "comment_id='" . $comment_id . "'", "*", "", "");
	if ($user_id == $rwComment["user_id"]){
		if ($_GET["action"]=="delete")	$db->delete(DB_PREFIX . "comments", "comment_id = " . $comment_id);	
		if ($_GET["action"]=="approve")	{
			$update = array("status" => 1);
			$db->update(DB_PREFIX . "comments", $update, "comment_id = " . $comment_id);
		}
	}
	redirect("comments.php");
}

include_once 'header.php';
?>
<div class="main_border" align="center">

			<h2 class="maintitle">Отзывы</h2>
            <div class="clear"></div>
			
            <?php
    		$results = $db->select("comments", "user_id=".$user_id, "*", " ORDER BY comment_id DESC","");
			if(count($results)>0){
			?>
            <table width="100%" >
				<tr> 
					<td>
                    Объект
					</td>
                    <td style="width:300px">
                    Отзыв
					</td>
					<td >
					Автор
					</td>
                    <td>&nbsp;
                    	
					</td>
				</tr>
    			<?php foreach ($results as $rw) { ?>
        		 <tr>
				   <td  style="width:150px">
						<?
							$flat_id = $rw["flat_id"];
							$room_id = $rw["room_id"];
							$rwFlat = $db->select_one("flats", "flat_id='" . $flat_id . "'", "*", "", "");
							if ($room_id) $rwRoom = $db->select_one("rooms", "room_id='" . $room_id . "'", "*", "", "");
						?>
						<span class="red"><?php echo substr($rwFlat['name_ru'], 0, 150); ?></span><br/>
                        <? if ($room_id) {?><span class="darkblue"><?php echo substr($rwRoom['name_ru'], 0, 150); ?></span><br/> <? } ?>
                        <img src="../images/thu/<?php echo $rwFlat['main_img']; ?>" align="left" class="item" height="100px" style="margin:10px;">
                        <br /><a href="commentssingle.php?flat_id=<?=$flat_id;?>&room_id=<?=$room_id;?>" class="tinytext">все отзывы объекта</a>
					</td>
                   	<td style="width:500px">
						<?=nl2br($rw["description"]);?>	
					</td>

					<td valign="top">
                    	<?=$rw["name"];?><br />
<br />
                        <?=$rw["create_date"];?>	
					</td>

                    <td valign="top">
                    <? if ($rw["status"]==0) {?>
                    <a  onClick='return confirm("Вы уверены, что хотите одобрять?");' href="comments.php?action=approve&comment_id=<?php echo $rw['comment_id']; ?>">Одобрять</a>
                    <? } else { ?>
                    <span class="approvedtext">Одобрен</span>
                    <? } ?>
                    <br />
                    <br />
                    <br />
                    <a  onClick='return confirm("Вы уверены, что хотите удалить?");' href="comments.php?action=delete&comment_id=<?php echo $rw['comment_id']; ?>">Удалить</a>
					</td>
				</tr>
    <?php } ?>
			</table>
            <?php } ?>
 
</div>
<div class="clear"></div> 
<?php
include_once 'footer.php';
?>