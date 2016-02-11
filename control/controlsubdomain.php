<p class="textRed">Адрес сайта</p>
<div class="priceforing">Выберите адрес сайта <br/>(<span style="color:#F00; font-weight:bold">на латинице!</span>)</div> 

<input name="objectlog" id="objectlog" type="text"  class="pricefor"  onkeyup="transliteratename()" value="<?=$rwFlat['objectlog'];?>" />
<div class="postinput">.sutki.kg &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript: checksubdomain(<?=$flat_id;?>)" style="color:#39F; text-decoration:underline">Проверить</a> 
<div style="float:right; margin-left:15px; margin-top:-18px;">
<span id="objectlogstatusok" style="font-size:small; color:#0F0; display:none  "><img src="../cms/images/tick_circle1.png" width="16" height="16" align="left" /></span>
<span id="objectlogstatushellno" style="font-size:small; color:#F00; display:none"><img src="../cms/images/cross.png" width="16" height="16"  align="left"/> Сайт с таким именем уже существует</span></div>
</div>
<div class="clear"></div>
<script type="text/javascript">
function checksubdomain(val)
{
transliteratename();
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
					document.getElementById("objectlogstatusok").style.display = 'none';
					document.getElementById("objectlogstatushellno").style.display = 'none';
					var subc=document.getElementById("objectlogstatus");
					var res=eval(httpxml.responseText);	
					if (res=="-1") alert("Выберите адрес сайта!");
					else if (res=="1") document.getElementById("objectlogstatushellno").style.display = 'block';
					else document.getElementById("objectlogstatusok").style.display = 'block';
				}	
    		}
			
			var url="ajax_checkSubdomain.php";
			url=url+"?sub="+document.getElementById("objectlog").value;
			url=url+"&flat="+val;
			url=url+"&sid="+Math.random();
			httpxml.onreadystatechange=function () {stateck();};
			httpxml.open("GET",url,true);
			httpxml.send(null);
  }
  
  function transliterate(word){
		  var answer = "", a = {};

   			a["Ё"]="YO";a["Й"]="I";a["Ц"]="TS";a["У"]="U";a["К"]="K";a["Е"]="E";a["Н"]="N";a["Г"]="G";a["Ш"]="SH";a["Щ"]="SCH";a["З"]="Z";a["Х"]="H";a["Ъ"]="'";
   			a["ё"]="yo";a["й"]="i";a["ц"]="ts";a["у"]="u";a["к"]="k";a["е"]="e";a["н"]="n";a["г"]="g";a["ш"]="sh";a["щ"]="sch";a["з"]="z";a["х"]="h";a["ъ"]="'";
   			a["Ф"]="F";a["Ы"]="I";a["В"]="V";a["А"]="a";a["П"]="P";a["Р"]="R";a["О"]="O";a["Л"]="L";a["Д"]="D";a["Ж"]="ZH";a["Э"]="E";
   			a["ф"]="f";a["ы"]="i";a["в"]="v";a["а"]="a";a["п"]="p";a["р"]="r";a["о"]="o";a["л"]="l";a["д"]="d";a["ж"]="zh";a["э"]="e";
   			a["Я"]="Ya";a["Ч"]="CH";a["С"]="S";a["М"]="M";a["И"]="I";a["Т"]="T";a["Ь"]="'";a["Б"]="B";a["Ю"]="YU";
   			a["я"]="ya";a["ч"]="ch";a["с"]="s";a["м"]="m";a["и"]="i";a["т"]="t";a["ь"]="'";a["б"]="b";a["ю"]="yu";
   	for (i in word){
     if (word.hasOwnProperty(i)) {
       if (a[word[i]] === undefined){
         if( /[^a-zA-Z0-9]/.test( word[i] ) ) 
		 	if (word[i]!="-" || word[i]!="_" ) answer += ""; else answer += word[i];
		 else answer += word[i];
       } else {
         answer += a[word[i]];
       }
     }
   }
   return answer;
		}
		
		function transliteratename(){
			var txt = document.getElementById("objectlog").value;
			document.getElementById("objectlog").value = transliterate(txt);
		}
  
</script>