<? 
	$lang = 'ru';
?>
<? include '../mainparts/header.php';?>
<?
	$lastdb = $db->select_one("counterdb","ip='".$_SERVER['REMOTE_ADDR']."' AND flat='".$flat['flat_id']."' AND vdate >= DATE_SUB(NOW(),INTERVAL 1 MINUTE)");
	if (!$lastdb){
		$counterinsert = array("ip"=>$_SERVER['REMOTE_ADDR'], "flat"=>$flat['flat_id']);
		$db->insert("counterdb",$counterinsert);
	}
	$myflattype = $arrTypes[$flat['flat_type']];
	$subheaderlinks = "http://www.sutki.kg/ru/search.php?mapcity=".$CurrentCity['name_translit'];
	$subheaderlinks .= "&flat_type=".$flat['flat_type'];

	$subheaderbrowser = '<li><a href="http://www.sutki.kg/ru/index.php">Домашняя страница ></a></li> 
						<li><a href='.$subheaderlinks.'>'.$CurrentCity['name'].' ></a></li>
						<li><a href='.$subheaderlinks.'>'.$myflattype.' ></a></li>
						<li><a href='.$subheaderlinks.'>'.substr($flat['name_ru'],0,160).'</a></li>';
?>
<? include '../mainparts/subheader.php';?>
<? if (!$subdomainFlag) {?>
<? include '../mainparts/browsebar.php';?>
<? } ?>
<div class="insideTitle">
              <? if (!$subdomainFlag) {?>
              <div class="backList">
              <a href="javascript: submitformbyflatype(<?=$flat_type;?>)" class="back">Вернуться к списку объектов</a>  
              </div>
              <? } ?>
              <h1><?=$flat['name_ru'];?>
              <? include '../mainparts/hotelstar.php';?>
              </h1>
              <span>№<?=$flat['flat_id'];?></span>
              <span class="date2"><?=showrdate($flat['update_date']); ?></span>
              <span class="view">
			  <? 
			  	$counterdbcounter=$db->select_count("counterdb","room=0 AND flat='".$flat['flat_id']."'");
				$counterdbcounter += $flat['extracounter'];
				echo $counterdbcounter;
			  ?> 
              просмотров</span>
              
           </div>
		<div id="mainContent">
                  <div class="leftColumn-index">
                  <? 
				  	if ($flat['sauna_type']==1)	require '../mainparts/detailsauna.php';
					else require '../mainparts/detail.php';
				  ?>
                  </div><!--end leftColumn-->
                  <div class="rightColumn">
                  <? require '../mainparts/detailright.php';?>
                  </div><!--end rightColumn-->
          </div>  <!--end mainContent-->
<? include '../mainparts/footer.php';?>
<? if (isset($_GET['r'])) {
if ($_GET['r'] == 'cmnt') {
	$notifymsg = "Спасибо за ваш комментарий!<br/><br/><br/>";
	$iconpng = "success.png";
}
if ($_GET['r'] == 'ncmnt') {
	$notifymsg = "Не удалось добавить ваш комментарий.<br/><br/><br/>";
	$iconpng = "error.png";
}
	
if ($notifymsg!=""){	 
?>
<div id="topNotify">dsfdsf</div>
<script type="text/javascript">
$(function() {
 
  $("#topNotify").jui_alert({
    containerClass: "juimaindiv",
	messageBodyClass: "juimessage",
    message: '<img src="http://www.sutki.kg/images/icons/<?=$iconpng?>" style="float: left; margin-right: 10px;"><?=$notifymsg;?>',
    timeout: 6000,
    messageIconClass: "",
    messageIconClass: "jui_alert_icon ui-icon ui-icon-alert",
	use_effect: {effect_name: "slide", effect_options: {"direction": "left"}, effect_duration: "500"}
  });
});
</script>
<? }} ?>