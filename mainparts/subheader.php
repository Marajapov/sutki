<body <?php if($detailpageFlag){?>onload="initialize()"<? }?>>

  <?php
	if(	($_SERVER['SCRIPT_NAME']!="/ru/chastye-voprosy.php")) include '../mainparts/issykkul.php';?>
    <!-- abakan izmenil 01.07.2013 mestami -->
  <div id="top">
    <div class="topPanel"> 
        <div class="lang">

        <a href="http://www.sutki.kg/control" class="user">Личный кабинет</a> Язык:
                     
                     	<? if ($lang == 'ru') { ?>
                        <a href="#" data-dropdown="#dropdown1-1" class="drop1">pусский <img src="http://www.sutki.kg/ru/images/r.png" alt="" /></a>
                          <div id="dropdown1-1" class="dropdown1 dropdown1-tip">
                          <ul class="dropdown1-menu1 dropdown1-menu">
                            <li><a href="http://www.sutki.kg/en" class="item">english <img src="http://www.sutki.kg/ru/images/usa.png" alt="" /></a></li>
                         </ul> 
                          </div>
                       <? } ?>
                       <? if ($lang == 'en') { ?>
                       <a href="#" data-dropdown="#dropdown1-1" class="drop1">english <img src="http://www.sutki.kg/ru/images/usa.png" alt="" /></a>
                          <div id="dropdown1-1" class="dropdown1 dropdown1-tip">
                        <ul class="dropdown1-menu1 dropdown1-menu">
                            <li><a href="/ru" class="item">pусский <img src="http://www.sutki.kg/ru/images/r.png" alt="" /></a></li>
                            <!--<li><a href="../ky" class="item">кыргызча<img src="/images/kg.png" alt="" /></a></li>-->
                         </ul> 
                          </div>
                       <? } ?>  
          </div>
     </div>
  </div><!--end top-->

  <div id="header">
        <div class="headerCenter">
            <a href="http://www.sutki.kg/ru/index.php"><div class="logo"></div></a>
            <div class="addHotel"><a href="http://www.sutki.kg/ru/add.php"><div class="addBtn">Добавить свой отель или квартиру</div></a></div>
            
              
        </div>
        <div class="headerShadow">
        
        </div>
      
        
  </div><!--end header-->

  <div id="conteiner">
  
      <div id="topMenu">
          <div class="way">
          	    <ul>
          	        <?=$subheaderbrowser;?>
          	    </ul>
          	</div>
          	
          	<div class="rightMenu">
          	  <ul>
          	  	<li><a href="http://www.sutki.kg/ru/contact.php">Контакты</a></li>
          	  	<li><a href="http://www.sutki.kg/ru/about.php">О компании</a></li>
                <li><a href="http://www.sutki.kg/ru/chastye-voprosy.php">Как пользоваться сайтом?</a></li>
                
          	  </ul>
          	</div>
          	
      </div><!--end topMenu-->
