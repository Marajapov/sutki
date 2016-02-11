<script type="text/javascript">
function updateSubDistrictFilter(form_name, region_id)
{
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
  
  function stateckFilter(form_name) {
    	
		if(httpxml.readyState==4){
			var myarray=eval(httpxml.responseText);
			var form = document.forms[form_name.name];
			for(j=form.subregion.options.length-1;j>=0;j--){
					form.subregion.remove(j);
				}
			var optn = document.createElement("OPTION");
			optn.text = 'Все кварталы';
			optn.value = '0';
			form.subregion.options.add(optn); 
			for (i=0;i<myarray.length;i++){
				var optn = document.createElement("OPTION");
				optn.text = myarray[i++];
				optn.value = myarray[i];
				form.subregion.options.add(optn);
				}
			form.subregion.disabled  = false;
			 
			}
		else { form.subregion.disabled  = true; }		
    }
	
	var url="../control/ajax_getSubRegions.php";
	url=url+"?region_id="+region_id;
	url=url+"&sid="+Math.random();
	httpxml.onreadystatechange=function () {stateckFilter(form_name);};
	httpxml.open("GET",url,true);
	httpxml.send(null);
  }
</script>
<table cellspacing="0" cellpadding="10">
<tr>
    <td colspan="6" style="border:1px solid #1A324B;">
        <form action="index.php" method="get" id="generalFormEstateFilter" name="generalFormEstateFilter">
            <table border="0" cellpadding="1" cellspacing="0">
                <tr valign="middle">
                    <td align="left" class="txtSearchbar">
                        <b> ID : </b>
                        <input class="txtSearchbar" type="text" name="id" value="<?=$id;?>"
                               size="5"  >&nbsp;
                    </td>
                    <td align="left" class="txtSearchbar">
                        <select id="flat_type" name="flat_type">
                    <option value="-1">Тип Недвижимости : Все объекты</option>
					<? foreach ($arrType as $key => $value) {?>
                    <option value="<?=$key;?>" <? if ($flat_type==$key) echo 'selected'; ?>><?=$value;?></option>
                    <? } ?>
                    </select>                    </td>
                    <td align="right" class="txtSearchbar">
                    	<select name="publish_type" id="publish_type">
                        <option value="0">Все</option>
                        	<option value="1" <? if ($publish_type==1) echo 'selected'; ?> >Опубликованные</option>
                  			<option value="2" <? if ($publish_type==2) echo 'selected'; ?> >В ожидании</option>
                        	<?php if ($session->isAdmin()) {?>    
                            <option value="3" <? if ($publish_type==3) echo 'selected'; ?> >Удаленные</option>
                        	<?php } ?>
                        </select>
                        <b> Гл.Стр : </b>
                        <select name="mainpage" id="mainpage">
                        <option value="0">Все</option>
                        <option value="1" <? if ($mainpage==1) echo 'selected'; ?> >Главная Страница</option>
                 		</select>                    
                        </td>
                    <td align="right" class="txtSearchbar">
                        <b> Комнаты : </b>
                        <input type="text" size="5" name="room" id="room" value="<? if ($room>0) echo $room; else echo '0'; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><select id="district" name="district"  class="priceformedium" onchange="updateSubDistrictFilter(this.form,this.value)">
                    <option value="0">Все районы</option>
                     <?php
						$rwRegions = $db->select("regions", $filterregionselect, "*", "ORDER BY region_id ASC");
						$myRegionSelected = 0;
						foreach ($rwRegions as $region) {
							if ($myRegionSelected==0) $myRegionSelected = $region["region_id"];
							echo '<option value="' . $region["region_id"] . '" ';
							if ($region['region_id'] == $district) {
								echo 'selected';
								 $myRegionSelected = $region['region_id'];
							}
							echo ' >' . $region['region_title'] . '</option>';
						}
					?>                 
                    </select>                        &nbsp;&nbsp;
                      <select id="subregion" name="subregion" class="pricefor">                        
                      <option value="0">Все кварталы</option> 
                       <?php
                        $rwCity = $db->select("subregions", "region_id=".$myRegionSelected, "*", "");
                        foreach ($rwCity as $arrcity) {
                            echo '<option value="' . $arrcity["subregion_id"] . '" ';
                            if ($arrcity['subregion_id'] == $subregion) echo 'selected';
                            echo ' >' . $arrcity['subregion_name'] . '</option>';
                        }
                        ?>
                        
                        </select></td>

                    <td align="right" class="txtSearchbar">
                        &nbsp;
                       <b> Цена</b>
                        &nbsp;
                       <input class="txtSearchbar" type="text" name="ot"
                                       size="10" value="<?=$ot;?>"  >&nbsp;
                        до <input class="txtSearchbar" type="text" name="do"
                                  size="10"  value="<?=$do;?>">&nbsp;<select class="selectboxType" name="currency" id="currency">
                        <option value="1" <? if ($currency==1) echo 'selected'; ?>>$</option>
                        <option value="0" <? if ($currency==0) echo 'selected'; ?>>Сом</option>
                    </select>
                    </td>

                    <td align="center" class="txtSearchbar">
                        <input type="submit" />
                    </td>
                </tr>


            </table>
        </form>
    </td>

</tr>
</table>