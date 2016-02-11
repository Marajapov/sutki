<div class="well">
<p class="star">Район / Населённый пункт: </p>
<select id="district" name="district"  class="priceformedium" onchange="updateSubDistrict(this.value)">
<option value="0" <? if ($region['region_id']==0) echo 'selected';?>>Другое: </option>
<?php
$rwRegions = $db->select("regions", "city_id='".$city."'", "*", "ORDER BY region_id ASC");
foreach ($rwRegions as $region) {
?>
<option value="<? echo $region["region_id"];?>" <? if ($region['region_id'] == $district) echo 'selected';?> >
	<?=$region['region_title'];?>
</option>
<? } ?>                 
</select>
<input type="text" id="district_text" name="district_text" style="width:290px;<? if ($actiontype=="edit" && $district>0) {?>display:none;<? }?>" value="<?=$district_text;?>" />
                    
</div><!--.well-->
<div class="clear"></div>
<script type="text/javascript">
        function updateSubDistrict(district){
			document.getElementById("district_text").style.display = district==0 ? 'block':'none'; 		
		}
</script>
<script type="text/javascript">
function updateDistrict(form_name, city_id)
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
  
  function stateck(form_name) {
    	
		if(httpxml.readyState==4){
			var myarray=eval(httpxml.responseText);
			var form = document.forms[form_name.name];
			for(j=form.district.options.length-1;j>=0;j--){
					form.district.remove(j);
				}
			
			var optn = document.createElement("OPTION");
			optn.text = 'Другое:';
			optn.value = '0';
			form.district.options.add(optn);
			document.getElementById("district_text").style.display = 'block'; 		
				
			for (i=0;i<myarray.length;i++){
				var optn = document.createElement("OPTION");
				optn.text = myarray[i++];
				optn.value = myarray[i];
				form.district.options.add(optn);
				} 
			form.district.disabled  = false;
			}
		else { form.district.disabled  = true; }		
    }
	
	var url="ajax_getRegions.php";
	url=url+"?city_id="+city_id;
	url=url+"&sid="+Math.random();
	httpxml.onreadystatechange=function () {stateck(form_name);};
	httpxml.open("GET",url,true);
	httpxml.send(null);
  }
</script>