<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title;?></title>
<link href="../styles/user.css" rel="stylesheet" type="text/css" />
<link href="../styles/style.css" rel="stylesheet" type="text/css" />
<link href="../styles/login.css" rel="stylesheet" type="text/css" />
<link href="../styles/table.css" rel="stylesheet" type="text/css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<!--
<script type="text/javascript" src="tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
				selector: "textarea",
				plugins: "table",
				
    			tools: "inserttable",
				language : 'RU',
				
			 });
</script>
-->
     	<?php
		$thisurl = strtolower($_SERVER['SCRIPT_NAME']);
		$showmap = false;
		$showdatepicker = false;
		if(	($thisurl=="/control/flat_edit.php") || ($thisurl=="/control/flat_add.php") || ($thisurl=="/control/detail.php") || ($thisurl=="/control/hotel_add.php") || ($thisurl=="/control/hotel_edit.php") || ($thisurl=="/control/sauna_add.php") || ($thisurl=="/control/sauna_edit.php") || ($thisurl=="/control/sauna_single.php") )
		{
			$showmap = true;
			
		}
		if(	($thisurl=="/control/hotel_rooms_add.php") || ($thisurl=="/control/hotel_rooms_edit.php")  || ($thisurl=="/control/sauna_rooms_add.php")  || ($thisurl=="/control/sauna_rooms_edit.php") )
		{
			$showdatepicker = true;
		}
		
		if($showmap || $showdatepicker){ ?>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />

        

          
          <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
          <script>

			

          $(function() {
				 
            $( "#discount_date_from" ).datepicker({
			  dateFormat: 'yy-mm-dd',
              defaultDate: "+1w",
              changeMonth: true,
              numberOfMonths: 2,
              onClose: function( selectedDate ) {
                $( "#discount_date_from" ).datepicker( "option", "minDate", selectedDate );
              }
            });
            $( "#discount_date" ).datepicker({
			  dateFormat: 'yy-mm-dd',
              defaultDate: "+2w",
              changeMonth: true,
              numberOfMonths: 2,
              onClose: function( selectedDate ) {
                $( "#discount_date" ).datepicker( "option", "maxDate", selectedDate );
              }
            });
			$.datepicker.regional['ru'] = {
                closeText: 'Закрыть',
                prevText: '&#x3c;Пред',
                nextText: 'След&#x3e;',
                currentText: 'Сегодня',
                monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
                'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
                'Июл','Авг','Сен','Окт','Ноя','Дек'],
                dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
                dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
                dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
                weekHeader: 'Не',
                dateFormat: 'yy-mm-dd',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['ru']);
          });
		  </script>
		<?php }?>
		
		<?php if($showmap){ ?>

         
		
		<script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkDCwNRQqDIE_kz7uBfmNl1iOBsCT2nt8&sensor=true">
        </script>
        <script type="text/javascript">
			
			var map = null;
    		var geocoder = null;
			var marker = null;
			var mapOptions = null;
			
		  function updatemap(){
			     var oblast = document.getElementById("city").value;
				 var cityDDL = document.all("city");
				 var city = cityDDL.options[cityDDL.selectedIndex].text;
				 var regionDDL = document.all("district");
				 var region = regionDDL.options[regionDDL.selectedIndex].text;
				 var street = document.getElementById("street").value;
				 var zoom = 15;
				 if (oblast > 1) city += " Province";
				 if (oblast ==2) city = "Ыссык Көл облусу"
				 if (street!="") street += ", ";
				 
				 if (region == "Чок Тал") region = "Chok Tal";
				 if (region == "Сары-Ой") region = "Sary Oi";
				 if (region == "Кара-Ой") region = "Долинка";
				 if (region == "Булан-Соготту") region = "Grigorievka";
				 if (region == "Курмонту") region = "Ak Bulak"; 
				 if (region == "Оттук") region = "Ottuk";
				 if (region == "Кызыл-Туу") region = "Imeni Voroshilovo";
				 if (region == "Ак-Сай") region = "Ak-Say";
				 if (region == "Боконбаев") region = "Bokonbayevo"; 
				 if (region == "Кажы-Сай") region = "Kaji-Say";
				 if (region == "Кызыл Суу") region = "Kyzyl-Suu";
				 if (region == "Жети Огуз") region = "Jeti Oguz";
				 
				 
				 var address =  street + region + ", " + city + ", Кыргызстан ";
				 geocoder.geocode( {'address': address}, function(results, status) {
            		if (status == google.maps.GeocoderStatus.OK) {
                		var latLng = results[0].geometry.location;
						mapOptions.center = latLng;
						mapOptions.zoom = zoom;
						
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
              zoom: <?=$zoom;?>,
              center: new google.maps.LatLng(<?=$latitude;?>,<?=$longitude;?>),
              mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);
			geocoder = new google.maps.Geocoder();
    
            var image = 'images/beachflag.png';
            var myLatLng = new google.maps.LatLng(<?=$latitude;?>,<?=$longitude;?>);

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
<body <?php if ($showmap) { ?>onload="initialize()"<? } ?>>
  <div id="wrapper">
    <!--HEADER/NAVIGATION STARTS-->
  	<header>
  	    <section class="contained">
            <a id="logo" title="<?=$title;?>" href="index.php"></a>
                          <ul  style="float:right; margin-top:20px">
                            <li style="float:left; margin-left:20px; list-style-type: none;"><a href="index.php">Мои объекты</a></li>
                            <li style="float:left; margin-left:20px; list-style-type: none;"><a href="profile.php">Мои данные</a></li>
                            <li style="float:left; margin-left:20px; list-style-type: none;"><a href="changepassword.php">Пароль</a></li>
                            <li style="float:left; margin-left:20px; list-style-type: none;"><a href="login.php?a=logout">Завершить работу</a></li>
                          </ul>
          </section>
      </header>
    <!--HEADER/NAVIGATION ENDS-->