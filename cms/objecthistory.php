<?php
include_once 'admincontrol.php';
$id = (int)$_GET["flat_id"];
if ($id < 1) {
    redirect("index.php", "js");
} else {
    $rw = $db->select_one(DB_PREFIX . "flats", "flat_id=" . $id);
    if ($rw["flat_id"] == "") {
        redirect("index.php", "js");
    }
}
?>

<table width="100%" >
				<tr style="background:#CCC;"> 
					<td style="width:200px; padding-left:10px">ID: #<?=$rw["flat_id"];?>
                    
                    </td>
                    
                    <td><?=$rw["name_owner"];?><br /><?=$rw["phone"];?><br /><?=$rw["email"];?></td>
                    <td>Добавил: <? $userid=$rw["user_id"]; 
					if ($userid>0){
						$userdd = $db->select_one(DB_PREFIX . "users", "user_id=" . $userid);
						echo $userdd["user_name"]." (".$userdd["user_realname"].")";	
					}
					else echo "Владелец";
					?></td>
				</tr>
</table>
<table width="100%" >

<?
	$trc = 0;
	$hisdb = $db->select(DB_PREFIX . "logdb", "`where`='flat_id = " . $id . "'","*", "ORDER BY actiondate desc");
	foreach($hisdb as $his){
	$trc++;
	$color = $trc%2 ? "#FF0" : "#CC0";
?>
<tr style="background:<?=$color;?>;"> 
					<td style="width:200px; padding-left:10px"><?=$his["actionDate"];?></td>
                    <td style="width:200px"><?
                    	$user = $db->select_one(DB_PREFIX . "users", "user_id=" . $his["user_id"]);
						echo $user["user_name"]."<br/>".$user["user_first_name"]." ".$user["user_last_name"];
					?></td>
                    <td>
					<?
                    	//$ptt = "/`*`/";
						//$rpl = "'";
						//$sql = preg_replace($ptt,$rpl, $his["sql"]);
						$sql = $his["sql"];
						$action = "Обновление";
						$pos = strpos($sql, "`status`=`*`0`*`");
						if ($pos === false){
							$pos = strpos($sql, "`liveFlag`=`*`0`*`");
							if (!($pos === false)) $action = "Деактивация";
						}
						else $action = "Удаление"; 
						echo $action;
					?></td>
                    <td>
					<?=$sql;?></td>
</tr>
<? } ?>
</table>