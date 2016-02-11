<?php
include_once 'header.php';
$flatsql = "city>'1'";
$filterregionselect = "city_id>'1'";
if (isset($_GET["id"])){
	$id = $_GET["id"];
	$district = $_GET["district"];
	$subregion = $_GET["subregion"];
	$mainpage = (int)$_GET["mainpage"];
	$publish_type = $_GET["publish_type"];
	$room = (int)$_GET["room"];
	$flat_type = (int)$_GET["flat_type"];
	$ot = (int) $_GET["ot"];
	$do = (int) $_GET["do"];
	$currency = (int) $_GET["currency"];
	
	if ($currency!=""){ $extraurl = "&currency=".$currency; }
	if ($ot>0){ 
		$ot_search = $currency == 1 ? $ot * 45 : $ot;
		$flatsql .= " AND price_search>'".$ot_search."'"; 
	}
	if ($do>0){ 
		$do_search = $currency == 1 ? $do * 50 : $do;
		$flatsql .= " AND price_search<'".$do_search."'"; 
	}
	
	if ($publish_type>0) { 
		if ($publish_type==1) $flatsql .= " AND liveFlag ='1' AND approved='1' AND user_id>'0'";
		if ($publish_type==2) $flatsql .= " AND (approved='0' OR user_id='0')";
		if ($publish_type==3) $flatsql .= " AND liveFlag ='0'";
	}
	if ($district>0) { $flatsql .= " AND district = '".$district."'";  }
	if ($subregion>0) { $flatsql .= " AND subregion = '".$subregion."'";  }
	if ($flat_type>0) { $flatsql .= " AND flat_type = '".$flat_type."'";  }
	if ($mainpage>0) { $flatsql .= " AND mainpageorder > '0'";  }
	if ($room>0) { $flatsql .= " AND room = '".$room."'";  }
	if ($id>0) { $flatsql = "flat_id = '".$id."'";  }
}
?>
<div class="clear" style="margin-top:0px;"></div> 
<div class="main_border" align="center">

			<h2 class="maintitle">Недвижимость</h2>
            
            <? include 'estates_filter.php';?>
            
            
            <div class="clear"></div>
			
            <?php
			$orderby = $mainpage>0?" ORDER BY mainpageorder desc":" ORDER BY mainpageorder desc, flat_id desc";
    		$results = $db->select("flats", $flatsql, "*", $orderby,"");
			$resulrcount = count($results);
			if(!$resulrcount>0){?>
				Все пусто
			<? } else { ?>
            <table width="100%">
				

    <?php
    
    foreach ($results as $rw) {
		$approved = ($rw['approved'] && $rw['user_id'])?'1':'0';
		$liveFlag = $rw['liveFlag'];
		$trstyle = 'style="background:#9C9"';
		if ($liveFlag=='0') $trstyle = 'style="background:#F00"'; else if ($approved=='0') $trstyle = 'style="background:#CCC"';
        ?>
        
        		 <tr <?=$trstyle;?>>
				   <td style="padding:3px"><span class="tinytext" style="margin-left:0px">
						<? 
							echo "ID: #".$rw['flat_id']."<br/>";
							$flat_type = $rw['flat_type'];
							echo $arrType[$flat_type];
						?>
                        </span>
				   </td>
                   <td style="padding:3px; width:200px">
                   <? if ($rw['main_img']=="") echo "Нет фото"; else {?>
						
                    	
                        <img src="../images/mainimg/<?php echo $rw['main_img']; ?>" alt="" class="item" width="200px">
                   <? } ?>
				   </td>
                    <td  style="padding:3px">
                        <?=$rw["name_owner"];?><br /><?=$rw["phone"];?><br /><?=$rw["email"];?><br />
					</td>
                    <td valign="top" style="padding:3px" >
                    <?
                    $hisdb = $db->select(DB_PREFIX . "logdb", "`where`='flat_id = " . $rw["flat_id"] . "'");
					?>
                    <a href="objecthistory.php?flat_id=<?php echo $rw['flat_id']; ?>" target="_blank" onClick="popupWin = window.open(this.href, 'contacts', 'location,width=800,height=300,top=0'); popupWin.focus(); return false;">История лог'ы</a> (всего записей : <?=count($hisdb);?>)
                    
<br />
<br />

					<a href="object.php?id=<?php echo $rw['flat_id']; ?>" target="_blank" onClick="popupWin = window.open(this.href, 'contacts', 'location,width=1100,height=600,top=0'); popupWin.focus(); return false;">Подробнее</a>         <br />
<br />
           
                    <? if ($rw['user_id']=='0') {?>
                    <font color="#FF0000"><b>Нет риэлтор</b></font>
                    <? } ?>
					</td>
                    <td valign="top" style="padding:3px">
                    
                    <? if ($liveFlag) {?>
						<a  onClick='return confirm("Вы уверены, что хотите дезактивировать?");' href="activate.php?active=0&flat_id=<?php echo $rw['flat_id']; ?>">Дезактивировать</a>
					<? } else {?>
						<a  onClick='return confirm("Вы уверены, что хотите активировать?");' href="activate.php?active=1&flat_id=<?php echo $rw['flat_id']; ?>">Активировать</a>
					<? } ?>
                    			

                    <? if (!$approved) {?>
						<br /><br /><a  onClick='return confirm("Вы уверены, что хотите одобрять?");' href="activate.php?approve=0&flat_id=<?php echo $rw['flat_id']; ?>">Одобрять</a>
					<? } ?>
                    
                    <br />	<br />
                    <? if (!$rw['special']) {?>
						<a  href="activate.php?special=1&flat_id=<?php echo $rw['flat_id']; ?>">Спецпредложения</a>
					<? } else {?>
						<font color="#FF0000"><b>Спецпредложения!</b></font> <a  href="activate.php?special=0&flat_id=<?php echo $rw['flat_id']; ?>">Убрать</a>
					<? } ?>
                    <br />	<br />
                    <? if ($rw['mainpageorder']==0) {?>
                    <form name="mpform<?=$rw['flat_id'];?>" id="mpform<?=$rw['flat_id'];?>" action="activate.php" method="post">
                    	<input name="mainpageorder" type="text" size="6"  />
                        <input type="hidden" name="id" value="<?php echo $rw['flat_id']; ?>" />
                      <input type="submit" name="button" id="button" value="Главная Страница" />
                      
                    </form>
					<? } else {?>
						<font color="#FF0000"><b><?=$rw['mainpageorder'];?>. Главная Страница!</b></font> <a  href="activate.php?mainpageorder=0&flat_id=<?php echo $rw['flat_id']; ?>">Убрать</a>
					<? } ?>
					</td>
                    <td valign="top" style="padding:3px">
                    
                    <a  onClick='return confirm("Вы уверены, что хотите удалить?");' href="delete.php?flat_id=<?php echo $rw['flat_id']; ?>">Удалить навсегда</a>
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