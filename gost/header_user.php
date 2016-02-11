<?php
require_once 'config.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php if ($title != "") echo $title . " - "; ?>  Сеть посуточной аренды </title>
        <meta name="description" content="Ищете квартиру посуточно в Бишкеке? Здесь фото галерея всех квартир на сутки в Бишкеке! Посуточная аренда квартир  г. Бишкека." />
        <meta name="keywords" content="квартиры, посуточно, Бишкек, аренда, снять на сутки">
        <link href="css/user.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/jquery-1.7.min.js"></script> 
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-32553174-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
        
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
                        <p class="topHeadering2"><?=$_SESSION['name'];?> 
                        - <a href="user.php">Мои объекты</a>
                        - <a href="updateprofile.php">Личные данные</a>
                        - <a href="changepassword.php">Пароль</a>
                        - <a href="login.php?a=logout">Завершить работу</a></p>
                    <? } ?>
                    </div> 
              </div><!--#topHeader-->   
            </div><!--#dvTopHeader-->  
            <div class="clear"></div>
            <div id="header" style="height:100px">
                <div id="headerMiddle">
                    <div id="headerMiddleLeft">
                        <div id="logo">
                            <a href="index.php">
                                <img src="images/logo.png" alt="">
                            </a>
                        </div><!--#logo-->
                    </div><!--#headerMiddleLeft--><!--#headerMiddleRight-->
                </div><!--#headerMiddle-->  
              <div class="clear"></div>       
            </div><!--#header-->