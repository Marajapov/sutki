<p class="mainTitle" style="width:755px;">Самые популярные квартиры в <?=$CurrentCity['in_the_city']?></p>
<? 
	$rwFlats = $db->select("flats", "mainpageorder>'0' AND flat_type='1'","*", "order by mainpageorder asc");
	foreach($rwFlats as $flat) include 'singlecompact.php';
?>
<div id="clear"></div><br />
<div align="center">
<select onchange="submitformbyflatypefooter(this.value)">
<option value="0">Просмотреть</option>
<option value="3">Отели</option>
<option value="1">Квартира посуточно</option>
<option value="2">Особняки</option>
</select>
</div>

<script type="text/javascript">

function submitformbyflatypefooter(val){
	if (val==0) return;
	document.mainfilterform.searchhotelflag.checked=false;
	document.mainfilterform.searchkvflag.checked=false;
	document.mainfilterform.searchesflag.checked=false;
	if (val==3) document.mainfilterform.searchhotelflag.checked=true;
	if (val==1) document.mainfilterform.searchkvflag.checked=true;
	if (val==2) document.mainfilterform.searchesflag.checked=true;
  document.mainfilterform.submit();
}

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