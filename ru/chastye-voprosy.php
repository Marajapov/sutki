<!doctype html>
<html>
<head>

	<meta charset="utf-8" />
    <title>F.A.Q.</title>

    <!-- Include Styles -->
    <link rel="stylesheet" href="style/faq-style.css" />
    <link rel="stylesheet" href="style/faq-dropdown.css" />
    <link type="text/css" rel="stylesheet" href="/ru/style/issykkul.css" /> 
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.ba-hashchange.js"></script>       
    <script type="text/javascript" src="js/faq-script.js"></script>
    <script src="/ru/js/tooltipScript.js" type="text/javascript"></script>    
    <script>
		$(function(){
		
	 		// hide #back-top first
			$("#back-top").hide();
			
			// fade in #back-top
			$(function () {
				$(window).scroll(function () {
					if ($(this).scrollTop() > 300) {
						$('#back-top').fadeIn();
					} else {
						$('#back-top').fadeOut();
					}
				});
			
				// scroll body to 0px on click
				$('#back-top a').click(function () {
					$('body,html').animate({
						scrollTop: 0
					}, 800);
					return false;
				});
			});
			
		});
	</script>
	
        <!--[if IE 7]><style type="text/css">#v-nav>ul>li.current{border-right:1px solid #fff!important}#v-nav>div.tab-content{z-index:-1!important;left:0}</style><![endif]-->
        <!--[if IE 8]><style type="text/css">#v-nav>ul>li.current{border-right:1px solid #fff!important}#v-nav>div.tab-content{z-index:-1!important;left:0}</style><![endif]-->
</head>
<body>

<? include '../mainparts/subheader.php';?>


		<section id="wrapper" class="wrapper">

            <h1 class="title">Вопросы и Ответы</h1>

            <div id="v-nav">

                <ul>
	               	<li id="#1" tab="tab1" class="first current">Вопросы и Ответы</li>
                    <li id="#2" tab="tab2">Как зарегистрироваться на сайте?</li>
                    <li id="#3" tab="tab3">Как авторизоваться <br/>(войти в Личный кабинет)?</li>
                    <li id="#4" tab="tab4">Как добавить квартиру?</li>
                    <li id="#5" tab="tab5">Как добавить особняк?</li>
                    <li id="#6" tab="tab6">Как добавить отель?</li>
                    <li id="#7" tab="tab7">Как добавить номер отеля?</li>
                    <li id="#8" tab="tab8">Как добавить сауну?</li>
                    <li id="#9" tab="tab9" class="last">Как добавить номер сауны?</li>
                </ul>



                <div class="tab-content">
                    <h4>Вопросы и Ответы</h4>
                    <p>Здесь Вы можете задать вопросы администратору сайта <span>&quot;Sutki.kg&quot;</span></p><br/>
                    <p>Рекомендуем ознакомиться со списком наиболее часто задаваемых вопросов, возможно 
                       это поможет быстрее найти выход из вашей ситуации.</p><br/>
                    <p>Вы можете пройти по интересующей Ваc теме, которые расположены на левой боковой панели.</p>
                </div>



                <div class="tab-content">
                    <h4>Как зарегистрироваться на сайте?</h4>
                    <p>1) Для того чтобы зарегистрироваться на нашем сайте Вам необходимо на Главной Странице нажать на кнопки входа. 
                          На изображении они выделены розовым овалом.</p>
                        <div class="image"><img src="faq-images/reg1.png" alt="" width="700" height="440"/></div>
                   	<h4></h4>
                    <p>2) В появившемся окне нажмите на кнопку <span>РЕГИСТРАЦИЯ</span> (выделена розовым овалом).</p>
                        <div class="image"><img src="faq-images/reg2.png" alt="" width="700" height="440"/></div>
                    <h4></h4>
                    <p>3) Заполните форму регистрации следуя приведенным инструкциям и примеру.</p>
                    	<div class="image"><img src="faq-images/reg3.png" alt="" width="700" height="440"/></div>
                    <h4></h4>
                    <p>4) После заполнения всех полей нажмите на кнопку <span>ЗАРЕГИСТРИРОВАТЬСЯ</span>.
                    	  Вы попадете в окно Вашего личного кабинета.</p>
                    	<div class="image"><img src="faq-images/auto1.png" alt="Личный Кабинет" width="700" height="170"/></div>
                    <h4></h4>
                    <h3>Поздравляем, Вы успешно зарегистрировались.
                        Приятного пользования услугами нашего сайта!</h3>                  
                </div>



                <div class="tab-content">
                    <h4>Как авторизоваться (войти в Личный кабинет)?</h4>
                    <p>Для авторизации (для входа в Личный кабинет) Вы должны быть зарегистрированным пользователем.</p><br/>
                    <p>1) Если Вы зарегистрированы, тогда пройдите в окно Авторизации, нажав на кнопки входа (выделены розовым овалом).</p>
                    	<div class="image"><img src="faq-images/reg1.png" alt="" width="700" height="440"/></div>
                    <h4></h4>
                    <p>2) В окне Авторизации введите Ваш логин и пароль. Затем нажмите на кнопку <span>ВОЙТИ</span> 
                    	 (выделена розовым овалом).</p>
                    	<div class="image"><img src="faq-images/auto0.png" alt="Авторизация" width="700" height="243"/></div>
                    <h4></h4>
                    <p>3) Вы перешли в Ваш Личный кабинет.</p>
                    	<div class="image"><img src="faq-images/auto1.png" alt="Личный Кабинет" width="700" height="170"/></div>
                    <h4></h4>
                    <p>Авторизованным пользователям предоставляются возможности добавления объектов на сайт, 
                    	  изменения своих данных, пароля, а также просмотра ранее добавленных Вами объектов. </p>


                                          
                </div>

                <div class="tab-content">
                    <h4>Как добавить квартиру?</h4>
                    <p>1) Для размещения рекламы своей квартиры на сайте Вам необходимо для начала пройти<br/>
                       регистрацию (см. <a href="#2"><span class="link">Как зарегистрироваться на сайте?</span></a>) или
                       авторизоваться, если Вы уже зарегистрированы (см. <a href="#3"><span class="link">Как авторизоваться (войти в
                       Личный кабинет)?</span></a>).</p><br/>
                    <p>Помните!!! В одном объявлении разрешается указывать только один объект.</p><br/>
                    <h4></h4>
                    <p>2) В личном кабинете в меню Добавить новый объект нажмите на кнопку <span>КВАРТИРА</span>.</p>
                   		<div class="image"><img src="faq-images/kvart/kvart1.png" alt="Личный Кабинет" width="700" height="170"/></div>
                    <h4></h4>
                    <p>3) Заполните форму добавления квартиры следуя ниже приведенным инструкциям.</p>
                    <div class="image">
                    	<h3>Обратите внимание на правила заполнения формы</h3>
                        <img src="faq-images/kvart/kvart2.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Укажите стоимость проживания</h3>
                       	<img src="faq-images/kvart/kvart3.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>При наличии скидки укажите сниженную стоимость проживания</h3>
                        <img src="faq-images/kvart/kvart4.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Указание местонахождения квартиры и установление флажка на карте обязательны<br/>
                        	Так Вашим будущим клиентам будет легче найти Вас и повысит шансы именно Вашего объявления</h3>
                        <img src="faq-images/kvart/kvart5.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Увелечение масштаба позволяет до точности найти дом, в котором находится квартира</h3>
                        <img src="faq-images/kvart/kvart6.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Оставьте Ваши контактные данные, для того чтобы клиентам легче было связаться с Вами</h3>
                        <img src="faq-images/kvart/kvart7.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Обязательно введите название объекта и его описание на русском языке<br/>
                        	Названия и описания на английском и кыргызском языках не обязательны,
                            но приветствуются</h3>
                        <img src="faq-images/kvart/kvart8.png" alt="Личный Кабинет" width="700" height="438"/></div>
                   	<div class="image">
                    	<h3></h3>
                        <img src="faq-images/kvart/kvart9.png" alt="Личный Кабинет" width="700" height="438"/></div>                 
                	<div class="image">
                    	<h3>Выберите из списка элементы интерьера, которые присутствуют в квартире</h3>
                        <img src="faq-images/kvart/kvart10.png" alt="Личный Кабинет" width="700" height="438"/></div>
                   	<div class="image">
                    	<h3>Выберите из списка элементы инфраструктуры, расположенные рядом с квартирой</h3>
                        <img src="faq-images/kvart/kvart11.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Загрузите фотографии (до 11 файлов). Не размещайте фотографии очень низкого качества</h3>
                        <img src="faq-images/kvart/kvart12.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Вы можете создать для квартиры ее собственную страничку в интернете<br/>
                        	Обязательно проверяйте название во избежании совпадений</h3>
                        <img src="faq-images/kvart/kvart14.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>После заполнения всех полей нажмите на кнопку <span>ДОБАВИТЬ КВАРТИРУ</span></h3>
                        <img src="faq-images/kvart/kvart13.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <h4></h4>
                    <div>
                    	<p>Вы успешно добавили квартиру!</p></div>
                    <div>
                    	<p>Вы можете просмотреть свои объекты в Личном кабинете в разделе Мои объекты.</p></div>
                </div>


                
				<div class="tab-content">
                    <h4>Как добавить особняк?</h4>
                    <p>1) Для размещения рекламы своего особняка на сайте Вам необходимо для начала пройти<br/>
                       регистрацию (см. <a href="#2"><span class="link">Как зарегистрироваться на сайте?</span></a>) или
                       авторизоваться, если Вы уже зарегистрированы (см. <a href="#3"><span class="link">Как авторизоваться (войти в
                       Личный кабинет)?</span></a>).</p><br/>
                    <p>Помните!!! В одном объявлении разрешается указывать только один объект.</p><br/>
                    <h4></h4>
                    <p>2) В личном кабинете в меню Добавить новый объект нажмите на кнопку <span>ОСОБНЯК</span>.</p>
                   		<div class="image"><img src="faq-images/osobnyak/osob1.png" alt="Личный Кабинет" width="700" height="170"/></div>
                    <h4></h4>
                    <p>3) Заполните форму добавления особняка следуя ниже приведенным инструкциям.</p>
                    <div class="image">
                    	<h3>Обратите внимание на правила заполнения формы</h3>
                        <img src="faq-images/osobnyak/osob2.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Укажите стоимость аренды</h3>
                       	<img src="faq-images/osobnyak/osob3.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>При наличии скидки укажите сниженную стоимость аренды</h3>
                        <img src="faq-images/osobnyak/osob4.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Указание местонахождения особняка и установление флажка на карте обязательны<br/>
                        	Так Вашим будущим клиентам будет легче найти Вас и повысит шансы именно Вашего объявления</h3>
                        <img src="faq-images/osobnyak/osob5.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Увелечение масштаба позволяет до точности найти местоположение особняка</h3>
                        <img src="faq-images/osobnyak/osob14.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Оставьте Ваши контактные данные, для того чтобы клиентам легче было связаться с Вами</h3>
                        <img src="faq-images/osobnyak/osob6.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Обязательно введите название объекта и его описание на русском языке<br/>
                        	Названия и описания на английском и кыргызском языках не обязательны,
                            но приветствуются</h3>
                        <img src="faq-images/osobnyak/osob7.png" alt="Личный Кабинет" width="700" height="438"/></div>
                   	<div class="image">
                    	<h3></h3>
                        <img src="faq-images/osobnyak/osob8.png" alt="Личный Кабинет" width="700" height="438"/></div>                 
                	<div class="image">
                    	<h3>Выберите из списка элементы интерьера, которые присутствуют в особняке</h3>
                        <img src="faq-images/osobnyak/osob9.png" alt="Личный Кабинет" width="700" height="438"/></div>
                   	<div class="image">
                    	<h3>Выберите из списка элементы инфраструктуры, расположенные рядом с особняком</h3>
                        <img src="faq-images/osobnyak/osob10.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Загрузите фотографии (до 11 файлов). Не размещайте фотографии очень низкого качества</h3>
                        <img src="faq-images/osobnyak/osob11.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Вы можете создать для особняка его собственную страничку в интернете<br/>
                        	Обязательно проверяйте название во избежании совпадений</h3>
                        <img src="faq-images/osobnyak/osob12.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>После заполнения всех полей нажмите на кнопку <span>ДОБАВИТЬ КВАРТИРУ</span></h3>
                        <img src="faq-images/osobnyak/osob13.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    
                    <h4></h4>
                    <div>
                    	<p>Вы успешно добавили особняк!</p></div>
                    <div>
                    	<p>Вы можете просмотреть свои объекты в Личном кабинете в разделе Мои объекты.</p></div>                   
                </div>
                
                
                
                <div class="tab-content">
                    <h4>Как добавить отель?</h4>
                    <p>1) Для размещения рекламы своего отеля на сайте Вам необходимо для начала пройти<br/>
                       регистрацию (см. <a href="#2"><span class="link">Как зарегистрироваться на сайте?</span></a>) или
                       авторизоваться, если Вы уже зарегистрированы (см. <a href="#3"><span class="link">Как авторизоваться (войти в
                       Личный кабинет)?</span></a>).</p><br/>
                    <p>Помните!!! В одном объявлении разрешается указывать только один объект.</p><br/>
                    <h4></h4>
                    <p>2) В личном кабинете в меню Добавить новый объект нажмите на кнопку <span>ОТЕЛЬ</span>.</p>
                   		<div class="image"><img src="faq-images/otel/otel0.png" alt="Личный Кабинет" width="700" height="170"/></div>
                    <h4></h4>
                    <p>3) Заполните форму добавления отеля следуя ниже приведенным инструкциям.</p>
                    <div class="image">
                    	<h3>Обратите внимание на правила заполнения формы</h3>
                        <img src="faq-images/otel/otel1.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Указание местонахождения отеля и установление флажка на карте обязательны<br/>
                        	Так Вашим будущим клиентам будет легче найти Вас и повысит шансы именно Вашего объявления</h3>
                        <img src="faq-images/otel/otel2.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Увелечение масштаба позволяет до точности найти местоположение отеля</h3>
                        <img src="faq-images/otel/otel7.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Оставьте Ваши контактные данные, для того чтобы клиентам легче было связаться с Вами</h3>
                        <img src="faq-images/otel/otel3.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Укажите количество звезд в статусе отеля</h3>
                        <img src="faq-images/otel/otel4.png" alt="Личный Кабинет" width="700" height="438"/></div>
                   	
                    <div class="image">
                    	<h3>Обязательно введите название объекта и его описание на русском языке<br/>
                        	Названия и описания на английском и кыргызском языках не обязательны,
                            но приветствуются</h3>
                       	<img src="faq-images/otel/otel5.png" alt="" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Выберите из списка элементы инфраструктуры, расположенные рядом с отелем</h3>
                        <img src="faq-images/otel/otel6.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Загрузите фотографию (1 файл). Не размещайте фотографию очень низкого качества</h3>
                        <img src="faq-images/otel/otel8.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Вы можете создать для отеля его собственную страничку в интернете<br/>
                        	Обязательно проверяйте название во избежании совпадений</h3>
                        <img src="faq-images/otel/otel9.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>После заполнения всех полей нажмите на кнопку <span>ОТПРАВИТЬ</span></h3>
                        <img src="faq-images/otel/otel10.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <h4></h4>
                    <div>
                    	<p>Вы успешно добавили отель!</p></div>
                    <div>
                    	<p>Вы можете просмотреть свои объекты в Личном кабинете в разделе Мои объекты.</p></div>                  
                </div>
 
 
                
                <div class="tab-content">
                    <h4>Как добавить номер отеля? (только для зарегистрированных пользователей)</h4>
                    <p>1) Для добавления номера в список отеля Вам необходимо для начала авторизоваться 
                    	  и добавить сам отель (см. <a href="#6"><span class="link">Как добавить отель?</span></a>)</p>
                    <h4></h4>
                    <p>2) После добавления отеля, в появившемся окне нажмите на кнопку <span>ДОБАВИТЬ НОМЕР</span>.</p>
                    <div class="image"><img src="faq-images/otel/room/room0.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <h4></h4>
                    <p>3) Заполните форму добавления номера отеля следуя ниже приведенным инструкциям.</p>
                    <div class="image">
                    	<h3>Обратите внимание на правила заполнения формы</h3>
                        <img src="faq-images/otel/room/room1.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Обязательно введите название объекта и его описание на русском языке<br/>
                        	Названия и описания на английском и кыргызском языках не обязательны,
                            но приветствуются</h3>
                        <img src="faq-images/otel/room/room2.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Укажите стоимость проживания</h3>
                        <img src="faq-images/otel/room/room3.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>При наличии скидки укажите сниженную стоимость аренды</h3>
                        <img src="faq-images/otel/room/room4.png" alt="Личный Кабинет" width="700" height="438"/></div> 
                    <div class="image">            
                		<h3>Укажите параметры номера</h3>
                        <img src="faq-images/otel/room/room5.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Выберите из списка элементы интерьера, которые присутствуют в номере отеля</h3>
                        <img src="faq-images/otel/room/room6.png" alt="Личный Кабинет" width="700" height="438"/></div>
                  	<div class="image">
                    	<h3>Загрузите фотографии (до 10 файлов). Не размещайте фотографии очень низкого качества</h3>
                        <img src="faq-images/otel/room/room7.png" alt="Личный Кабинет" width="700" height="438"/></div>
                	<div class="image">
                    	<h3>После заполнения всех полей нажмите на кнопку <span>ОТПРАВИТЬ</span></h3>
                        <img src="faq-images/otel/room/room8.png" alt="Личный Кабинет" width="700" height="438"/></div>
                	<h4></h4>
                    <div>
                    	<p>Вы успешно добавили номер отеля!</p></div>
                    <div>
                    	<p>Вы можете просмотреть свои объекты в Личном кабинете в разделе Мои объекты.</p></div>
                </div>
                
                
                
                <div class="tab-content">
                    <h4>Как добавить сауну?</h4>
                    <p>1) Для размещения рекламы своей сауны на сайте Вам необходимо для начала пройти<br/>
                       регистрацию (см. <a href="#2"><span class="link">Как зарегистрироваться на сайте?</span></a>) или
                       авторизоваться, если Вы уже зарегистрированы (см. <a href="#3"><span class="link">Как авторизоваться (войти в
                       Личный кабинет)?</span></a>).</p><br/>
                    <p>Помните!!! В одном объявлении разрешается указывать только один объект.</p><br/>
                    <h4></h4>
                    <p>2) В личном кабинете в меню Добавить новый объект нажмите на кнопку <span>САУНА</span>.</p>
                   	<div class="image">
                    	<img src="faq-images/otel/room/room0.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <h4></h4>
                    <p>3) Заполните форму добавления сауны следуя ниже приведенным инструкциям.</p>
                    <div class="image">
                    	<h3>Обратите внимание на правила заполнения формы</h3>
                        <img src="faq-images/sauna/sauna1.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Указание местонахождения сауны и установление флажка на карте обязательны<br/>
                        	Так Вашим будущим клиентам будет легче найти Вас и повысит шансы именно Вашего объявления</h3>
                        <img src="faq-images/sauna/sauna2.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Увелечение масштаба позволяет до точности найти местоположение сауны</h3>
                        <img src="faq-images/sauna/sauna5.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Оставьте Ваши контактные данные, для того чтобы клиентам легче было связаться с Вами</h3>
                        <img src="faq-images/sauna/sauna3.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Обязательно введите название объекта и его описание на русском языке<br/>
                        	Названия и описания на английском и кыргызском языках не обязательны,
                            но приветствуются</h3>
                       	<img src="faq-images/sauna/sauna4.png" alt="" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Загрузите фотографию (1 файл). Не размещайте фотографию очень низкого качества</h3>
                        <img src="faq-images/sauna/sauna6.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Вы можете создать для сауны его собственную страничку в интернете<br/>
                        	Обязательно проверяйте название во избежании совпадений</h3>
                        <img src="faq-images/sauna/sauna8.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>После заполнения всех полей нажмите на кнопку <span>ОТПРАВИТЬ</span></h3>
                        <img src="faq-images/sauna/sauna7.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <h4></h4>
                    <div>
                    	<p>Вы успешно добавили сауну!</p></div>
                    <div>
                    	<p>Вы можете просмотреть свои объекты в Личном кабинете в разделе Мои объекты.</p></div>                  
                </div>
                
                
                
                <div class="tab-content">
                    <h4>Как добавить номер сауны?</h4>
                    <p>1) Для добавления номера в список сауны Вам необходимо для начала авторизоваться 
                    	  и добавить саму сауну (см. <a href="#8"><span class="link">Как добавить сауну?</span></a>)</p>
                    <h4></h4>
                    <p>2) После добавления сауны, в появившемся окне нажмите на кнопку <span>ДОБАВИТЬ НОМЕР</span>.</p>
                    <div class="image"><img src="faq-images/sauna/nomer/nomer0.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <h4></h4>
                    <p>3) Заполните форму добавления номера сауны следуя ниже приведенным инструкциям.</p>
                    <div class="image">
                    	<h3>Обратите внимание на правила заполнения формы</h3>
                        <img src="faq-images/sauna/nomer/nomer1.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Обязательно введите название объекта и его описание на русском языке<br/>
                        	Названия и описания на английском и кыргызском языках не обязательны,
                            но приветствуются</h3>
                        <img src="faq-images/otel/room/room2.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Укажите стоимость проживания</h3>
                        <img src="faq-images/otel/room/room3.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>При наличии скидки укажите сниженную стоимость аренды</h3>
                        <img src="faq-images/otel/room/room4.png" alt="Личный Кабинет" width="700" height="438"/></div> 
                    <div class="image">            
                		<h3>Укажите параметры номера</h3>
                        <img src="faq-images/otel/room/room5.png" alt="Личный Кабинет" width="700" height="438"/></div>
                    <div class="image">
                    	<h3>Выберите из списка элементы интерьера, которые присутствуют в номере</h3>
                        <img src="faq-images/otel/room/room6.png" alt="Личный Кабинет" width="700" height="438"/></div>
                  	<div class="image">
                    	<h3>Загрузите фотографии (до 10 файлов). Не размещайте фотографии очень низкого качества</h3>
                        <img src="faq-images/otel/room/room7.png" alt="Личный Кабинет" width="700" height="438"/></div>
                	<div class="image">
                    	<h3>После заполнения всех полей нажмите на кнопку <span>ОТПРАВИТЬ</span></h3>
                        <img src="faq-images/otel/room/room8.png" alt="Личный Кабинет" width="700" height="438"/></div>
                	<h4></h4>
                    <div>
                    	<p>Вы успешно добавили номер сауны!</p></div>
                    <div>
                    	<p>Вы можете просмотреть свои объекты в Личном кабинете в разделе Мои объекты.</p></div>                   
                </div>
                
                
                
            <p id="back-top">
				<a href="#top"><span></span>Наверх</a>
			</p>    
            </div>
            

		</section>
        
        <div id="footer">
            <div class="footerMenu" align="center"><a href="index.php">На главную</a><!-- |
                <a href="#">Menu item3</a> |
                <a href="#">Menu item4</a> |
                <a href="#">Menu item5</a> |
                <a href="#">Menu item6</a> |
                <a href="#">Menu item7</a> |
                <a href="#">Menu item8</a>-->
            </div>

<!-- Bottom Ad -->
<br />
<div align="center">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-2966704049503755"
     data-ad-slot="1584666429"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>
<!-- end Bottom Ad -->	

            <div class="copy">&copy;2016 SUTKI.KG</div>
		</div>

        <!-- Include Scripts -->


<!-- GoogleAnalyticsObject -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-70021950-1', 'auto');
  ga('send', 'pageview');

</script>
<!-- end google-analytics-->

<!-- WWW.NET.KG , code for http://sutki.kg -->
<script language="javascript" type="text/javascript">
 java="1.0";
 java1=""+"refer="+escape(document.referrer)+"&amp;page="+escape(window.location.href);
 document.cookie="astratop=1; path=/";
 java1+="&amp;c="+(document.cookie?"yes":"now");
</script>
<script language="javascript1.1" type="text/javascript">
 java="1.1";
 java1+="&amp;java="+(navigator.javaEnabled()?"yes":"now");
</script>
<script language="javascript1.2" type="text/javascript">
 java="1.2";
 java1+="&amp;razresh="+screen.width+'x'+screen.height+"&amp;cvet="+
 (((navigator.appName.substring(0,3)=="Mic"))?
 screen.colorDepth:screen.pixelDepth);
</script>
<script language="javascript1.3" type="text/javascript">java="1.3"</script>
<script language="javascript" type="text/javascript">
 java1+="&amp;jscript="+java+"&amp;rand="+Math.random();
 document.write("<a href='http://www.net.kg/stat.php?id=2926&amp;fromsite=2926' target='_blank'>"+
 "<img src='http://www.net.kg/img.php?id=2926&amp;"+java1+
 "' border='0' alt='WWW.NET.KG' width='21' height='16' /></a>");
</script>
<noscript>
 <a href='http://www.net.kg/stat.php?id=2926&amp;fromsite=2926' target='_blank'><img
  src="http://www.net.kg/img.php?id=2926" border='0' alt='WWW.NET.KG' width='21'
  height='16' /></a>
</noscript>
<!-- /WWW.NET.KG -->


<!-- Yandex.Metrika informer -->
<a href="https://metrika.yandex.ru/stat/?id=25243580&amp;from=informer"
target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/25243580/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:25243580,lang:'ru'});return false}catch(e){}" /></a>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter25243580 = new Ya.Metrika({
                    id:25243580,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/25243580" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

    </body>
</html>
