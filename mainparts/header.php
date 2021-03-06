<? include_once '../config.php';
   //DEFAULT SETTINGS

   $searchsort='price_night';
   $flat_type = 1;
   $detailpageFlag = false;
   $subdomainFlag = false;
   $searchhotelflag=0; 
   $searchkvflag=0;
   $searchpanflag=0;
   $searchesflag=0;
   $searchsaflag=0;
   $searchkvflag=0;
   $searchcity=0;
   $curname = "$";
   $site_title = "Снять квартиру в Бишкеке посуточно и Ыссык - Куля";

   //DETECT PAGE
	if(	($_SERVER['SCRIPT_NAME']=="/ru/detail.php")) $detailpageFlag = true;
	if(	($_SERVER['SCRIPT_NAME']=="/ru/detailroom.php")) $detailpageFlag = true;
   
   // GET VALUES
   if ($detailpageFlag) {
	   //SUBDOMAIN CHECK
	   	if (isset($_GET['objectlog'])){ 
			$objectlog = getget('objectlog');
			$flat = $db->select_one("flats", "objectlog like '".$objectlog."'");
			//echo "objectlog like '".$objectlog."'";
			if (!$flat) redirect('http://www.sutki.kg/ru/index.php?r=obj',js);
			$subdomainFlag = true;
		}
	   
	   	if (isset($_REQUEST['id'])){
		   $flat = $db->select_one("flats", "flat_id='".(int)$_REQUEST['id']."'");
		   if (!$flat) redirect('index.php?r=obj',js);
		}
		
		if ($flat){

			$flat_type=$flat['flat_type'];
			if ($flat['sauna_type']==1) $saunadb = $db->select_one("saunadetails", "flat_id like '".$flat['flat_id']."'");
			$CurrentCity = $db->select_one("city", "city_id = '".$flat['city']."'");
			$searchcity = $CurrentCity['city_id'];

			$CurrentDistrict = $db->select_one("regions", "region_id = '".$flat['district']."'");   
			$albumdb = $db->select("albums", "flat_id='".$flat['flat_id']."'");
			$site_title = $flat['name_ru'] ." в ".$CurrentCity['in_the_city'].". Отзывы. Бишкек. Иссык-Куль. Кыргызстан. Киргизия";
		}
	   	if (isset($_REQUEST['room'])){
			$room = $db->select_one("rooms", "flat_id='".$flat['flat_id']."' AND room_id='".(int)$_REQUEST['room']."'");
		   if (!$room) redirect('index.php?r=obj',js);
		}
	   if (isset($_GET['changecurrency'])){
			$_SESSION['currency'] = (int)$_GET['changecurrency'];
		}
   }
   else {
	   if (isset($_GET['mapcity'])) {
		   $mapcity = getget('mapcity');
		   $CurrentCity = $db->select_one("city", "name_translit like '".$mapcity."'");
		   if (!$CurrentCity) redirect("index.php","js");
		   $searchcity = $CurrentCity['city_id'];
		   $searchroom = 1;
		   $flat_type = (isset($_GET['flat_type'])) ? (int)getget('flat_type'):1;
	   }

	   if (isset($_GET['searchcity'])) {
		   $searchcity = (int)getget('searchcity');
		   $flat_type = (int)getget('flat_type');
		   $searchregion = (int)getget('searchregion');
		   $searchdate1 = getget('searchdate1');
		   $searchdate2 = getget('searchdate2');
		   $searchroom = (int)getget('searchroom');
		   $searchhotelflag = getget('searchhotelflag');
		   $searchkvflag = getget('searchkvflag');
		   $searchsaflag = getget('searchsaflag');
		   $searchesflag = getget('searchesflag');
		   $searchpanflag = getget('searchpanflag');
		   $searchsort = getget('searchsort');
		   $searchkeyword = getget('searchkeyword');
		   $_SESSION['currency'] = getget('searchcurrency');
		   $CurrentCity = $db->select_one("city", "city_id = '".$searchcity."'");
	   }

		if (!$flat_type || $flat_type == 0){
			if (($searchhotelflag + $searchkvflag + $searchsaflag + $searchesflag+$searchpanflag)>1) {
				$flat_type = -1;
				$flattypesql = " AND (0 ";
				if ($searchkvflag==1) $flattypesql .= " OR flat_type='1'";
				if ($searchesflag==1) $flattypesql .= " OR flat_type='2'";
				if ($searchhotelflag==1) $flattypesql .= " OR flat_type='3'";
				if ($searchsaflag==1) $flattypesql .= " OR flat_type='4'";
				if ($searchpanflag==1) $flattypesql .= " OR flat_type='5'";
				$flattypesql .= " )";
			}
			else {
				if ($searchkvflag==1) $flat_type = 1;
				if ($searchesflag==1) $flat_type = 2;
				if ($searchhotelflag==1) $flat_type = 3;
				if ($searchsaflag==1) $flat_type = 4;
				if ($searchpanflag==1) $flat_type = 5;
				}
		}
		else {
			$searchesflag=0;$searchsaflag=0;$searchhotelflag=0; $searchkvflag=0;
			if ($flat_type==1) {$searchkvflag=1;}
			if ($flat_type==2) {$searchesflag=1;}
			if ($flat_type==3) {$searchhotelflag=1;}
			if ($flat_type==4) {$searchsaflag=4;}
			if ($flat_type==5) {$searchpanflag=1;}
		}
   }
   	if (!$searchcity){
		$CurrentCity = $db->select_one("city", "city_id =1");
		$searchcity = 1;
	}
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="QAGP5JaeekSS_9MXxL8X9lo9aTtr_c8LNq0a9JszVyU" name="google-site-verification"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$site_title;?></title>
<meta name="description" content="Отели, Пансионаты, Квартиры. Посуточно. Кратковременная аренда отели, апартаменты и квартир в городе Бишкек и Иссык-Куль. Гостиницы в Бишкеке. Отзывы об отелях Бишкеке и Иссык-куля отели в Бишкеке" />
<meta name="keywords" content="квартиры посуточно с фото, аренда квартир посуточно, квартиры посуточно в Бишкеке, посуточно Иссык-Куль, отель на сутки в Бишкеке, отель на сутки  на Иссык-Куле, отель на сутки в Кыргызстане, снять квартиру посуточно в Бишкеке, снять квартиру посуточно на Иссык-Куле, квартиры посуточно в Кыргызстане, квартиры посуточно на Иссык-Куле, отели, гостиницы Кыргызстана, гостиницы Бишкека, гостиницы Иссык-Куля, отели Бишкека, отели на Иссык-Куле, квартиры посуточно в Иссык-Куле, квартиры посуточно в Кыргызстане, в Бишкеке,аренда квартир в Кыргызстане, квартиры, аренда, однокомнатная, двухкомнатная,  трехкомнатная, квартиры на сутки, дом, коттедж, апартаменты посуточно, однокомнатная посуточно, двухкомнатная посуточно, трехкомнатная посуточно, снять посуточно, аренда квартир без посредников, Отдых на Иссык-Куле, пансионаты и дома отдыха на Иссык-Куле, в Иссык-Куль, отдых, лечение, санатории Иссык-Куля, отели иссык куля, отзывы, отдых на Иссык-Куле, иссыкккуль, иссык куль, об иссык-куле, центры отдыха иссык куля, Иссык-Куль отдых, Пансионаты частного сектора, снять квартиру в бишкеке на сутки, озеро Иссык-Куль, карта Иссык-Куля, карта Кыргызстана, карта Бишкека, Чолпон-Ата, туризм, частный сектор, гостевой дом, гостевой дом в Бишкеке, гостевой дом в Иссык-Куле, путешествие, квартиры посуточно бишкек, Достопримечательности иссыкульской области, Фото-тур по пансионатам Иссык куля, тур по пансионатам Иссык куля, Список лучших пансионатов без посредников на озере Иссык куль, Каталог лучших пансионатов на озере Иссык куль, активного отдыха на берегу  о.Иссык-Куля, киргизия, киргизия отдых, цены, описание, отзывы, фотографии, пансионат киргизское взморье, цены дельфин де люкс, квартиры в бишкеке посуточно,горящие туры золотые пески ,солнышко карвен отдых, снять квартиру в бишкеке посуточно, виза, аврора, озеро, квартиры в бишкеке на сутки, квартира посуточно бишкек, посуточно квартиры в бишкеке, отели в Бишкеке" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<? if ($detailpageFlag) { //include '../mainparts/headerdetail.php'; 
	?>
    <link rel="stylesheet" href="http://www.sutki.kg/ru/style/reset.css" type="text/css" />
    <link rel="stylesheet" href="http://www.sutki.kg/ru/style/style.css" type="text/css" />
    <link rel="stylesheet" href="http://www.sutki.kg/ru/style/dropdown.css" type="text/css" />
    <link rel="stylesheet" href="http://www.sutki.kg/ru/style/jquery.bxslider.css" />
    <link rel="stylesheet" href="http://www.sutki.kg/ru/style/jquery-ui-1.10.1.custom.css" />

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
    
    <script type="text/javascript" src="http://www.sutki.kg/ru/js/dropdown.js"></script>
        
    <script type="text/javascript" src="http://www.sutki.kg/ru/js/jquery.bxslider.js"></script>

    <script type="text/javascript">
    
      $(document).ready(function(){
		$('.bxslider').bxSlider({
		  pagerCustom: '#bx-pager',
		  adaptiveHeight: true
		});
		$('.bxsliderMain').bxSlider({
		  pagerCustom: '#bx-pagerMain',
		  adaptiveHeight: true
		});
		<? foreach($albumdb as $album) {?>
		$('.bxslider<?=$album['album_id'];?>').bxSlider({
		  pagerCustom: '#bx-pager<?=$album['album_id'];?>',
		  adaptiveHeight: true
		});
		<? } ?>
		$('div#thedialog').dialog({ autoOpen: false })
		$('#thelink').click(function(){ $('div#thedialog').dialog('open'); });
      });
 
    </script>

	<? } else include '../mainparts/headerdefault.php';?>  
    
    <? if (isset($_GET['r'])) {?>
    	<link id="ui-theme" rel="stylesheet" type="text/css" href="http://www.sutki.kg/style/jquery-ui-1.10.1.custom.css"/>
         
        <script type="text/javascript" src="http://www.sutki.kg/ru/js/jquery.jui_alert.min.js"></script>
        <script type="text/javascript" src="http://www.sutki.kg/ru/js/jui-ru.js"></script>
	<? } ?>
    
    	<script type="text/javascript" src="http://www.sutki.kg/ru/js/cycle.js"></script>

    <style type="text/css">
	.slideshowcompactcontainer{
		position: absolute;
		width: 230px;
		height: 170px;
		overflow: hidden;
	}
	.slideshowcompact{
		z-index:0;
		visibility:hidden;
		margin: 0;
		padding: 0;
		outline: none;
		border: none;
	}
	.slideshowcompact.active{
		visibility:visible;
		margin: 0;
		padding: 0;
		outline: none;
		border: none;
	}	
	.slideshowcompactspecial{
		position: absolute;
		width: 230px;
		height: 170px;
		overflow: hidden;
	}
	.slideshowspecial{
		z-index:0;
		visibility:hidden;
		margin: 0;
		padding: 0;
		outline: none;
		border: none;
	}
	.slideshowspecial.active{
		visibility:visible;
		margin: 0;
		padding: 0;
		outline: none;
		border: none;
	}	
	</style>
     <script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>

      <!-- Wrapping the Recaptcha create method in a javascript function -->
      <script type="text/javascript">
         function showRecaptcha(element) {
           Recaptcha.create("6LegbeMSAAAAAB2xEKdyk049IT6vJBPb1LDhriHR", element, {
             theme: "red",
             callback: Recaptcha.focus_response_field});
         }
      </script>

