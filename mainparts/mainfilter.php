  <div class="searchPanel">
 		<div class="topSearch">
        	<p class="searchTitle">Поиск гостиниц, отелей, и квартир посуточно</p>
               <form action="/ru/search.php" method="get" name="mainfilterform" id="mainfilterform" >
        			<input name="searchkeyword" type="text" value="<? echo $searchkeyword==""?"Поиск...":$searchkeyword;?>" class="mainSchfield" onfocus="if (this.value=='Поиск...') this.value=''" onblur="if (this.value==''){this.value='Поиск...'}"   />
                    <div id="clear" style="height:20px"></div>
                   <div class="inWrapp">
                    	<label for="city">Город</label>
<select class="selectbox" name="searchcity" id="searchcity" onchange="UpdateSearchRegion(this.value);">
                     <?php
						$rwSearchCities = $db->select("city", "", "*", "ORDER BY city_id ASC");
						$myCitySelected = 0;
						foreach ($rwSearchCities as $searchcityar) {
							if ($myCitySelected==0) $myCitySelected = $searchcityar["city_id"];
							echo '<option value="' . $searchcityar["city_id"] . '" ';
							if ($searchcity >0 && $searchcityar['city_id'] == $searchcity) {
								echo 'selected';
								 $myCitySelected = $searchcityar['city_id'];
							}
							echo ' >' . $searchcityar['name'] . '</option>';
						}
					?> 
</select>
                    </div>
                          
                      <div class="inWrapp">
                      	 <label for="area">Район</label>
                          <select class="selectbox" name="searchregion" id="searchregion">
                          <option value="0">Все</option>
						  <?php
						$rwSearchRegions = $db->select("regions", "city_id='".$myCitySelected."'", "*", "ORDER BY region_id ASC");
						foreach ($rwSearchRegions as $searchregionar) {
							echo '<option value="' . $searchregionar["region_id"] . '" ';
							if ($searchregion >0 && $searchregionar['region_id'] == $searchregion) {
								echo 'selected';
							}
							echo ' >' . $searchregionar['region_title'] . '</option>';
						}
					?>
                          </select>
                      </div>     
                           
                       <div class="inWrapp">
                        <label for="date1">Дата заезда</label>
       					 <input id="datepicker" name="searchdate1" type="text" class="date" size="15" maxlength="50" value="<?=$searchdate1;?>" />
     
                       
                       </div>
                       
                        <div class="inWrapp">
                 
                            <label for="date2" style="">Дата отъезда</label>
                            <input id="datepickers" name="searchdate2" type="text" class="date" size="15" maxlength="50"  value="<?=$searchdate2;?>" />
                       
                       </div>
                           
                           

                         <div class="inWrapp">
                         <label for="room" style="">Комнаты</label>
                             
                             <!--<select class="room" name="searchroom" id="searchroom">
                              <option  value="0">Все</option>
							 	<? foreach ($arrRoomType as $key=>$value) {?>
                            <option  value="<?=$key;?>" <? if ($searchroom==$key) echo 'selected';?>><?=$value;?></option>
                            
                            <? } ?>
                            </select>-->
                            <select class="room" name="searchroom" id="searchroom" onchange="this.form.submit()">
                              <option  value="0">Все</option>
							 	<? for ($i=1; $i<6; $i++){?>
                            <option  value="<?=$i;?>" <? if ($searchroom==$i) echo 'selected';?>><? if ($i==5) echo "+"; echo $i;?></option>
                            
                            <? } ?>
                            </select>
                            
                         </div> 
                         <div class="chekField"><input class="checkBox" id="searchhotelflag" name="searchhotelflag" type="checkbox" value="1" <? if($searchhotelflag==1) {?>checked="checked"<? } ?> />Отели
                         <input class="checkBox" id="searchkvflag" name="searchkvflag" type="checkbox" value="1"  <? if($searchkvflag==1) {?>checked="checked"<? } ?> />
                         Квартира посуточно 
                         <input class="checkBox" id="searchesflag" name="searchesflag" type="checkbox" value="1"  <? if($searchesflag==1) {?>checked="checked"<? } ?> />
                         Особняки 
                         <input class="checkBox" id="searchpanflag" name="searchpanflag" type="checkbox" value="1"  <? if($searchpanflag==1) {?>checked="checked"<? } ?> />
                         Пансионаты
                         
                         </div>
<input type="hidden" name="searchcurrency" id="searchcurrency" value="<?=$_SESSION['currency'];?>" />
<input type="hidden" name="searchsort" id="searchsort" value="price_night" />
<input type="hidden" name="searchpage" id="searchpage" value="0" />
                           <input class="searchBtn" name="" type="submit" value="Найти" />
        	  		</form>
        </div><!--end topSearcg-->

  </div><!--end searchPanel-->
  
  	<div id="slidingDiv">
        <!--<img src="/ru/images/point_finger.gif" border="0" class="show_issyk_kul" onclick="ShowHide1();"  title="Карта Иссык-куля" />-->
        <img src="http://www.sutki.kg/ru/images/mainMap.png" alt="" usemap="#FilterMap" border="0" />
        <map name="FilterMap" id="FilterMap">
          <area shape="rect" coords="392,19,510,54" href="search.php?mapcity=bishkek" alt="Бишкек" />
          <area shape="rect" coords="549,27,664,52" href="search.php?mapcity=cholpon-ata" alt="Чолпон-Ата" />
          <area shape="rect" coords="686,44,782,69" href="search.php?mapcity=karakol" alt="Каракол" />
          <area shape="poly" onclick="ShowHide1(); return false;" coords="572,80,580,80,592,76,608,72,619,71,641,67,655,66,665,67,680,69,691,73,680,81,671,85,668,94,659,99,643,96,631,96,616,96,605,94,589,91,579,88" href="#" alt="Карта Иссык-куля">
          <area shape="poly" coords="232,43,338,43,340,70,232,72" href="search.php?mapcity=talas" alt="Талас">
           <area shape="poly" coords="352,123,471,122,469,150,352,151" href="search.php?mapcity=djalal-abad" alt="Джалал-Абад">
           <area shape="poly" coords="515,95,608,95,610,123,516,123" href="search.php?mapcity=naryn" alt="Нарын">
           <area shape="poly" coords="97,185,204,185,206,217,97,217" href="search.php?mapcity=batken" alt="Баткен">
           <area shape="poly" coords="344,200,423,201,424,233,343,233" href="search.php?mapcity=osh" alt="Ош">
        </map>
    </div>
    <div class="button" id="slidingDiv1" onclick="ShowHide(); return false;"><p></p></div>
    <div class="shadow"></div>
<script type="text/javascript">

function selectradiobycity(city) {
	  document.mainfilterform.searchhotelflag.checked=false;
	  document.mainfilterform.searchkvflag.checked=false;
	  document.mainfilterform.searchesflag.checked=false;
	  document.mainfilterform.searchpanflag.checked=false;
	  if (city==2 || city == 3) document.mainfilterform.searchhotelflag.checked=true;
	  if (city==1) document.mainfilterform.searchkvflag.checked=true;
}

function UpdateSearchRegion(city)
{	
selectradiobycity(city);
var httpxml;
try
  {
  // Firefox, Opera 8.0+, Safari
  httpxml=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
		  try
   			 		{
   				 httpxml=new ActiveXObject("Msxml2.XMLHTTP");
    				}
  			catch (e)
    				{
    			try
      		{
      		httpxml=new ActiveXObject("Microsoft.XMLHTTP");
     		 }
    			catch (e)
      		{
      		alert("Your browser does not support AJAX!");
      		return false;
      		}
    		}
  }
  
  			function stateck() {
				if(httpxml.readyState==4){
					var myarray=eval(httpxml.responseText);
					var subc=document.getElementById("searchregion");			
					for(j=subc.options.length-1;j>=0;j--){
							subc.remove(j);
						}
						
					var optn = document.createElement("OPTION");
						optn.text = 'Все';
						optn.value = '0';
						subc.options.add(optn);
						
					for (i=0;i<myarray.length;i++){
						var optn = document.createElement("OPTION");
						optn.text = myarray[i++];
						optn.value = myarray[i];
						subc.options.add(optn);
						}
					subc.disabled  = false;
	
				}
			else { subc.disabled  = true; }		
    		}
			url=url+"?city_id="+city;
			url=url+"&sid="+Math.random();
			httpxml.onreadystatechange=function () {stateck();};
			httpxml.open("GET",url,true);
			httpxml.send(null);

  }
  

</script>
