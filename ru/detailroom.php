<? 
	$lang = 'ru';
?>
<? include '../mainparts/header.php';?>
<?
	$lastdb = $db->select_one("counterdb","ip='".$_SERVER['REMOTE_ADDR']."' AND room='".$room['room_id']."' AND vdate >= DATE_SUB(NOW(),INTERVAL 1 MINUTE)");
	if (!$lastdb){
		$counterinsert = array("ip"=>$_SERVER['REMOTE_ADDR'], "flat"=>$flat['flat_id'], "room"=>$room['room_id']);
		$db->insert("counterdb",$counterinsert);
	}
	$myflattype = $arrTypes[$flat['flat_type']];
	$subheaderbrowser = '<li><a href="index.php">Домашняя страница ></a></li> 
						<li><a href="search.php?mapcity='.$CurrentCity['name_translit'].'">'.$CurrentCity['name'].' ></a></li>
						<li><a href="#">'.$myflattype.' ></a></li>
						<li><a href="detail.php?id='.$flat['flat_id'].'">'.substr($flat['name_ru'],0,160).'</a></li>';
?>
<? include '../mainparts/subheader.php';?>
<? include '../mainparts/browsebar.php';?>
<div class="insideTitle">
              <div class="backList"><a href="detail.php?id=<?=$flat['flat_id'];?>" class="back">Вернуться к объекту</a>  </div>
              
              <h1><a href="detail.php?id=<?=$flat['flat_id'];?>"><?=$flat['name_ru'];?></a>
              <? include '../mainparts/hotelstar.php';?>
              </h1>
              <h2><?=$room['name_ru'];?></h2>
              
              <br>
              <span>№<?=$flat['flat_id'];?></span>
              <span class="date2"><?=showrdate($flat['update_date']); ?></span>
              <span class="view"><?=$db->select_count("counterdb","room='".$room['room_id']."'");?> просмотров</span>
           </div>
		<div id="mainContent">
                  <div class="leftColumn-index">
                  <? if ($flat['flat_type']==4) require '../mainparts/detailroomsauna.php'; else require '../mainparts/detailroom.php';?>
                  </div><!--end leftColumn-->
                  <div class="rightColumn">
                  <? require '../mainparts/detailright.php';?>
                  </div><!--end rightColumn-->
          </div>  <!--end mainContent-->
<? include '../mainparts/footer.php';?>