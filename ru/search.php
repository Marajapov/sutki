<? 
	$lang = 'ru';
	$subheaderbrowser = '<li><a href="#">Поиск гостиниц, отелей, и квартир посуточно</a></li>';
?>
<? include '../mainparts/header.php';?>
<? include '../mainparts/subheader.php';?>
<? include '../mainparts/mainfilter.php';?>
<? include '../mainparts/browsebar.php';?>
		<div id="mainContent">
                  <div class="leftColumn-index">
                  <? require '../mainparts/search.php';?>
                  </div><!--end leftColumn-->
                  <div class="rightColumn">
                  <? require '../mainparts/special.php';?>
                  </div><!--end rightColumn-->
          </div>  <!--end mainContent-->
<? include '../mainparts/footer.php';?>