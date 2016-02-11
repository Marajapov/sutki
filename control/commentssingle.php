<?php
include_once 'usercontrol.php';

$user_id = $userid = $_SESSION["userid"];
$flat_id = $_REQUEST["flat_id"];
$room_id = $_REQUEST["room_id"];
require 'flatcontrol.php';
if ($room_id>0) require 'roomcontrol.php';
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
	redirect("commentssingle.php?flat_id=".$flat_id."&room_id=".$room_id);
}
$rwFlat = $db->select_one("flats", "flat_id='" . $flat_id . "'", "*", "", "");
if ($room_id) $rwRoom = $db->select_one("rooms", "room_id='" . $room_id . "'", "*", "", "");
include_once 'header.php';
?>
<div class="main_border" align="center">
			
			<h2 class="maintitle">Отзывы &raquo; <?php echo $rwFlat['name_ru']; ?>
            <? if ($room_id>0) { ?> &raquo; <?php echo $rwRoom['name_ru']; ?> <? } ?>
            </h2>
            <div class="clear"></div>
			
            <?php
			$sqlcomment = "flat_id=".$flat_id;
			if ($room_id > 0) $sqlcomment .= " AND room_id = ".$room_id;
    		$results = $db->select("comments", $sqlcomment , "*", " ORDER BY comment_id DESC","");
			if(count($results)>0){
			?>
            <table width="100%" >
				<tr> 
                    <td style="width:300px">
                    Отзыв
					</td>
					<td >
					Автор
					</td>
                    <td>&nbsp;
                    	
					</td>
				</tr>


    <?php
    
    foreach ($results as $rw) {
        ?>
        
        		 <tr>
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
                    <a  onClick='return confirm("Вы уверены, что хотите одобрять?");' href="commentssingle.php?flat_id=<?=$flat_id;?>&room_id=<?=$room_id;?>&action=approve&comment_id=<?php echo $rw['comment_id']; ?>">Одобрять</a>
                    <? } else { ?>
                    <span class="approvedtext">Одобрен</span>
                    <? } ?>
                    <br />
                    <br />
                    <br />
                    <a  onClick='return confirm("Вы уверены, что хотите удалить?");' href="commentssingle.php?flat_id=<?=$flat_id;?>&room_id=<?=$room_id;?>&action=delete&comment_id=<?php echo $rw['comment_id']; ?>">Удалить</a>
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