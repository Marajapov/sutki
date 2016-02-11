<?php 
		   $searchsql = "city = '".$searchcity."'";
		   if ($searchregion>0) { $searchsql .= " AND district = '".$searchregion."'";}
		   if ($flat_type>0) { $searchsql .= " AND flat_type = '".$flat_type."'"; }
		   if ($flat_type<0) { $searchsql .= $flattypesql; }
		   if ($flat_type==1 && $searchroom>0) { 
		   		if ($searchroom<5)	$searchsql .= " AND room = '".$searchroom."'"; 
		   		else $searchsql .= " AND room >= '".$searchroom."'"; 
		   }
		   /*switch ($searchroom>0){
			case 1: $searchsql .= " AND room <= '2'"; break;
			case 2: $searchsql .= " AND room <= '3'"; break;
			case 3: $searchsql .= " AND room <= '4'"; break;
			case 4: $searchsql .= " AND room > '4'"; break;
			}*/
			if ($searchkeyword=="Поиск...") $searchkeyword = "";
			if (strlen($searchkeyword)>0){
				$searchsql .= " AND (";
				$searchsql .= " flat_id = '".$searchkeyword."'";
				$searchsql .= " OR street like '%".$searchkeyword."%'";	
				$searchsql .= " OR landmark_ru like '%".$searchkeyword."%'";
				$searchsql .= " OR landmark_eng like '%".$searchkeyword."%'";
				$searchsql .= " OR name_ru like '%".$searchkeyword."%'";
				$searchsql .= " OR name_native like '%".$searchkeyword."%'";
				$searchsql .= " OR name_eng like '%".$searchkeyword."%'";
				$searchsql .= " OR description_ru like '%".$searchkeyword."%'";
				$searchsql .= " OR description_native like '%".$searchkeyword."%'";
				$searchsql .= " OR description_eng like '%".$searchkeyword."%'";
				$searchsql .= " OR construct_serial like '%".$searchkeyword."%'";	
				$searchsql .= ")";	
			}

			if (isset($_GET['searchpage'])) {
            $start = (int)getget('searchpage');
			} else {
				$start = 0;
			}
			$perpage = 25;
			$sqlorder = "ORDER BY flat_id DESC";
			if ($searchsort=='price_night') $sqlorder = "order by price_universal asc";
			$count = $db->select_count("flats", $searchsql);
			$pagenav = new PageNav2($count, $perpage, $start, "p");
			$rwFlats = $db->select("flats", $searchsql, "*", $sqlorder, $start . "," . $perpage);
?>
<div class="mainTitle" style="width:726px;">Найдено <span><?=$count;?></span> предложений

                  <div class="dropList">
                     Сортировать:
        <?
        	$sortArs = array("Цена"=>"price_night","Новые"=>"flat_id");
			foreach($sortArs as $key=>$value){
			//echo $key.$searchsort;
			if ($value != $searchsort) continue;
		?>
        <a href="#" data-dropdown="#dropdown-1" class="drop"><?=$key;?></a>
        <? } ?>             
       	<div id="dropdown-1" class="dropdown dropdown-tip">
       	<ul class="dropdown-menu1 dropdown-menu">
       		<?
				foreach($sortArs as $key=>$value){
				if ($value == $searchsort) continue;
			?>
            <li><a href="javascript: submitformbysort('<?=$value;?>')" class="item"><?=$key;?></a></li>
            <? } ?>
        </ul> 
       	</div>
        
</div> </div> 
<div id="clear"></div><br />

<?php echo '<div align="right" style="margin-right:50px" >' . $pagenav->renderCom2(5, 3) . '</div>'; ?> 
<? 
	foreach($rwFlats as $flat) include 'singlesearch.php';
?>
<br />
<?php echo '<div align="center" >' . $pagenav->renderCom2(5, 3) . '</div>'; ?>
<br />
<script type="text/javascript">
function submitformbysort(val)
{
  document.mainfilterform.searchsort.value=val;
  document.mainfilterform.submit();
}
function submitformbypage(val)
{
  document.mainfilterform.searchpage.value=val;
  document.mainfilterform.submit();
}
</script>
<script type="text/javascript">
jQuery(function($){
	<? foreach($rwFlats as $flat) {?>
	// Cycle plugin
	$('.slideshowcompact<?=$flat['flat_id']?>').cycle({
	    fx:     'none',
	    speed:   500,
	    timeout: 70
	}).cycle("pause");
	
	// Pause & play on hover
	$('.slideshowcontainercompact<?=$flat['flat_id']?>').hover(function(){
		$(this).find('.slideshowcompact<?=$flat['flat_id']?>').addClass('active').cycle('resume');
	}, function(){
		$(this).find('.slideshowcompact<?=$flat['flat_id']?>').removeClass('active').cycle('pause');
	});
	<? } ?>
});
</script>