<? require_once 'config.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php if ($title != "") echo $title . " - "; ?>  Сеть посуточной аренды </title>
        <meta name="description" content="Ищете квартиру посуточно в Бишкеке? Здесь фото галерея всех квартир на сутки в Бишкеке! Посуточная аренда квартир  г. Бишкека." />
        <meta name="keywords" content="квартиры, посуточно, Бишкек, аренда, снять на сутки">
        <link href="css/my.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="maxmertdrop/maxmertkit.css">	<!-- for configuration dropdown menu border -->
		<link rel="stylesheet" type="text/css" href="maxmertdrop/maxmertkit-components.css">  <!-- for edit place -->
		<link rel="stylesheet" type="text/css" href="maxmertdrop/maxmertkit-animation.css">   <!-- for animation -->

		
		<script type="text/javascript" src="maxmertdrop/jquery.js"></script>
		<script type="text/javascript" src="maxmertdrop/modernizr.js"></script>  <!-- for drop up -->
		<script type="text/javascript" src="maxmertdrop/maxmertkit.js"></script>
		<script type="text/javascript" src="maxmertdrop/maxmertkit.popup.js"></script>
        
     	<? if($_SERVER['PHP_SELF']=="/dobavit.php"){ ?>
		<script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkDCwNRQqDIE_kz7uBfmNl1iOBsCT2nt8&sensor=true">
        </script>
        <script type="text/javascript">
			
			var map = null;
    		var geocoder = null;
			var marker = null;
			var mapOptions = null;
			
		  function updatemap(){
				 var address = document.getElementById("address").value + ", Бишкек, Кыргызстан ";
				 geocoder.geocode( {'address': address}, function(results, status) {
            		if (status == google.maps.GeocoderStatus.OK) {
                		var latLng = results[0].geometry.location;
						mapOptions.center = latLng;
						
						map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);
						document.getElementById("latitude").value = map.getCenter().lat(); 
						document.getElementById("longitude").value = map.getCenter().lng(); 
						document.getElementById("zoom").value = map.getZoom(); 
						marker = new google.maps.Marker({
							position: latLng, 
							map: map, 
							title: "where is your position?"
						});
						google.maps.event.addListener(map, 'center_changed', function() {
							marker.setPosition(map.getCenter());
							document.getElementById("latitude").value = map.getCenter().lat(); 
							document.getElementById("longitude").value = map.getCenter().lng(); 
							document.getElementById("zoom").value = map.getZoom(); 
						});
						
						google.maps.event.addListener(map, "zoom_changed", function(){ 
						  document.getElementById("zoom").value = map.getZoom(); 
						}); 
						//marker.setPosition(map.getCenter());
            		} else {alert("Geocode failed. Reason: " + status);}
         		});
		  }
		
          function initialize() {
            mapOptions = {
              zoom: 16,
              center: new google.maps.LatLng(42.87568142335946,74.61169433337409),
              mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);
			geocoder = new google.maps.Geocoder();
    
            var image = 'images/beachflag.png';
            var myLatLng = new google.maps.LatLng(42.87568142335946,74.61169433337409);

            marker = new google.maps.Marker({
                position: myLatLng, 
                map: map, 
                title: "Ваш объект?"
            });
            
            google.maps.event.addListener(map, 'center_changed', function() {
                marker.setPosition(map.getCenter());
                document.getElementById("latitude").value = map.getCenter().lat(); 
                document.getElementById("longitude").value = map.getCenter().lng(); 
                document.getElementById("zoom").value = map.getZoom(); 
            });
            
            google.maps.event.addListener(map, "zoom_changed", function(){ 
              document.getElementById("zoom").value = map.getZoom(); 
            }); 
              
          }
	  
    </script>
    
		<? } ?>
        
      		<script type="text/javascript">
			(function($){
				$(document).ready(function(){
					$('.js-dropdown').popup({
						template: '.dropdown-template',
						trigger: 'click',
						placement: 'bottom',
						animation: 'growUp',
						theme: 'primary',
						onlyOne: true,
						open: function() {
							$(this).addClass('_active_')
						},
						close: function() {
							$(this).removeClass('_active_')
						}
					});

				});
			})(jQuery);
		</script>
		<script type="javascript/template" class="dropdown-template">
			<div class="-dropdown">
				<i class="-arrow"></i>
				<ul class="-menu -primary-">				
					<li style="background:#CCC"><a href="user.php">Мои объекты</a></li>
					<li style="background:#CCC"><a href="updateprofile.php">Личные данные</a></li>
					<li style="background:#CCC"><a href="changepassword.php">Пароль</a></li>
					<li style="background:#CCC"><a href="login.php?a=logout">Завершить работу</a></li>
				</ul>
			</div>
		</script>  
    </head>
    <body <? if(($_SERVER['PHP_SELF']=="/dobavit.php") || ($_SERVER['PHP_SELF']=="/detail.php") ){ ?>onload="initialize()"<? } ?>>
        <div id="dvFullSite">
            <div id="dvTopHeader">
                <div id="topHeader">
                    <div id="topHeaderLeft">
                        <img src="images/phone.png" alt="" class="topHeadering phone">
                            <p class="topHeadering2">Контактная информация: (0550) 87 07 57, (0556) 19 58 22</p>
                    </div><!--#topHeaderLeft-->
                    
					
                    <div id="topHeaderRight">
                    
                    
                    
                    
                    <? if ($session->verifyAccess()) {?>
                    
                    <div id="javascript" class="-container">			
			<article class="-row">
				<div class="-col6">
	<span class="js-dropdown js-dropdown1 -btn username" data-content="Dropdown1" data-header="Header" style="width:200px; text-align:center"><?=$_SESSION['name'];?></span>
                            </div>
                        </article>
                    </div>
                    
                       
                       
                    <? } else {?>
                        <p class="topHeadering2"><a href="login.php">Логин</a></p>
                    <? } ?>
                    </div> 
                    
                    
                </div><!--#topHeader-->   
            </div><!--#dvTopHeader-->  
            <div class="clear"></div>
            <div id="header">
                <div id="headerMiddle">
                    <div id="headerMiddleLeft">
                        <div id="logo">
                            <a href="index.php">
                                <img src="images/logo.png" alt="">
                            </a>
                        </div><!--#logo-->
                    </div><!--#headerMiddleLeft--> 

                    <div id="headerMiddleRight">
                        <div id="topMenu">
                            <ul class="topMenu">
                                <!--                        <li class="notalone">
                                                            <a href="index.php" <?php if ($active == 1) echo 'class="active"'; ?>>ГЛАВНАЯ</a>
                                                        </li>-->
                                <li class="notalone">
                                    <a href="vladelcam.php" <?php if ($active == 2) echo 'class="active"'; ?> >ВЛАДЕЛЬЦАМ</a>
                                </li>
                                <li class="notalone">
                                    <a href="index.php" <?php if ($active == 0) echo 'class="active"'; ?>>ВСЕ КВАРТИРЫ</a>
                                </li>
                                <li class="notalone">
                                    <a href="index.php?special=1" <?php if ($active == 4) echo 'class="active"'; ?>>СПЕЦПРЕДЛОЖЕНИЯ</a>
                                </li>
                                <!--                                <li class="notalone">
                                                                    <a href="vopros-otvet.php" <?php if ($active == 5) echo 'class="active"'; ?>>ВОПРОС-ОТВЕТ</a>
                                                                </li>-->
                                <li class="notalone">
                                    <a href="contacts.php" <?php if ($active == 6) echo 'class="active"'; ?>>КОНТАКТЫ</a>
                                </li>
                                <li class="notalone">
                                    <a href="dobavit.php" <?php if ($active == 7) echo 'class="active"'; ?>>ДОБАВИТЬ КВАРТИРУ</a>
                                </li>
                            </ul><!--.topMenu-->
                        </div><!--#topMenu-->                   
                    </div><!--#headerMiddleRight-->
                </div><!--#headerMiddle-->  

                <div class="clear"></div>

                <div id="headerBottom">
                    <a href="index.php?room=1&flat_type=0"><img src="images/odno.png" alt="" class="button"></a>
                    <div class="extraButton14"></div>
                    <a href="index.php?room=2&flat_type=0"><img src="images/dvuh2.png" alt="" class="button"></a>
                    <div class="extraButton13"></div>
                    <a href="index.php?flat_type=3"><img src="images/sauna.png" alt="" class="button"></a>
                    <div class="extraButton13"></div>
                    <a href="index.php?flat_type=1"><img src="images/osobnyak.png" alt="" class="button"></a>
                    <div class="extraButton14"></div>
                    <a href="index.php?flat_type=2"><img src="images/otel.png" alt="" class="button"></a>
                </div><!--#headerBottom-->
                <div class="clear"></div>       
            </div><!--#header-->