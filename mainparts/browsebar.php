  			<div class="bottomMenu">
            	<ul class="menuLvl1">
            		<li><a href="#" style="color:#F00"><?=$CurrentCity['name'];?> : </a></li>
            		<li><a href="javascript: submitformbyflatype(3)" <? if ($searchhotelflag==1) { ?>class="activeLink"<? } ?>>
                    Все отели
                    
                    
                    </a></li>
                    <li><a href="javascript: submitformbyflatype(1)" <? if ($searchkvflag==1) { ?>class="activeLink"<? } ?>>Все квартиры посуточно</a></li>
                    <li><a href="javascript: submitformbyflatype(2)" <? if ($searchesflag==1) { ?>class="activeLink"<? } ?>> 
                    
                    <? if ($searchcity>1) {?>
                    Все коттеджи и особняки
                    <? } else echo "Все особняки"; ?>
                    </a></li>
                    <li><a href="javascript: submitformbyflatype(5)" <? if ($searchpanflag==1) { ?>class="activeLink"<? } ?>>Все пансионаты</a></li>
            	</ul>
            </div>
<? if( $detailpageFlag) {?>
<form name="mainfilterform" id="mainfilterform" method="post" action="http://www.sutki.kg/ru/search.php">
<input type="hidden" name="flat_type" id="flat_type" />
<input type="hidden" name="searchcity" id="searchcity" />
</form>
<form name="mainfilterform1" id="mainfilterform1" method="post" action="">
<input type="hidden" name="id" id="id" />
<input type="hidden" name="changecurrency" id="changecurrency" />
</form>
<? }?>
<script type="text/javascript">
function submitformbycurrency(val)
{
	// document.mainfilterform.searchroom.value=0;
  	<? if ($detailpageFlag) {?>
	  document.mainfilterform1.changecurrency.value=val;
	  document.mainfilterform1.id.value=<?=$flat['flat_id'];?>;
	  document.mainfilterform1.submit();
	<? } else {?>
	  document.mainfilterform.searchcurrency.value=val;
	  document.mainfilterform.submit();
  	<? } ?>
}
function submitformbyflatype(val)
{
	//document.mainfilterform.searchroom.value=0;
	<? if ($detailpageFlag) {?>
	document.mainfilterform.flat_type.value=val;
	document.mainfilterform.searchcity.value=<?=$CurrentCity['city_id'];?>;
	<? } else {?>
	  document.mainfilterform.searchhotelflag.checked=false;
	  document.mainfilterform.searchkvflag.checked=false;
	  document.mainfilterform.searchesflag.checked=false;
	  document.mainfilterform.searchpanflag.checked=false;
	  if (val==3) document.mainfilterform.searchhotelflag.checked=true;
	  if (val==1) document.mainfilterform.searchkvflag.checked=true;
	  if (val==2) document.mainfilterform.searchesflag.checked=true;
	  if (val==5) document.mainfilterform.searchpanflag.checked=true;
  	<? } ?>
  document.mainfilterform.submit();
}

</script>