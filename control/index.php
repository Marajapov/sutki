<?php
include_once 'usercontrol.php';

$user_id = $_SESSION["userid"];
$user_name = $_SESSION["name"];

$active = 99;
include_once 'header.php';
?>

<subheader style="background:#FFF"><div class="subheaderdiv">
                          <ul style="float:right; margin-top:10px;">
                            <li  style="float:left; margin-left:20px; list-style-type: none;"><b>Добавить новый объект:</b></li>
                            <li style="float:left; margin-left:20px; list-style-type: none;"><a href="flat_add.php?flat_type=1" style="color:#000">Квартира</a></li>
                            <li style="float:left; margin-left:20px; list-style-type: none;"><a href="flat_add.php?flat_type=2" style="color:#000">Особняк и коттедж</a></li>
                            <li style="float:left; margin-left:20px; list-style-type: none;"><a href="hotel_add.php" style="color:#000">Отель</a></li>
                            <li style="float:left; margin-left:20px; list-style-type: none;"><a href="hotel_add.php?flat_type=5" style="color:#000">Пансионат</a></li>
                            <li style="float:left; margin-left:20px; list-style-type: none;"><a href="sauna_single.php" style="color:#000">Сауна</a></li>
                            
                            
                          </ul>
                          </div>
</subheader>

<div class="clear" style="margin-top:100px;"></div> 
<div class="main_border" align="center">
<?php
	if ($session->isAdmin()) $results = $usersql = "1";
	else $usersql = "user_id='".$user_id."'";
	if (isset($_GET['q']) && strlen($_GET['q'])>0){
		$q = getget('q');
		$usersql .= " AND name_ru like '%".$q."%'";
		}
	if (isset($_GET['t']) && $_GET['t']>0){
		$t = (int)$_GET['t'];
		$usersql .= " AND flat_type= '".$t."'";
		}
?>
<div style="float:left">
<form action="index.php" method="get">
                            	<input type="text" name="q" />
                            	<input type="submit" name="button" id="button" value="Искать" />
                            </form>
                            </div>
<div style="float:left">
<form action="index.php" method="get">
                            	<select name="t">
                                <option value="0">Все</option>
                                <option value="1">Квартира</option>
                                <option value="2">Особняк</option>
                                <option value="3">Отель</option>
                                <option value="5">Пансионат</option>
                                </select>
                            	<input type="submit" name="button" id="button" value="Фильтр" />
                            </form>
                            </div>
                           <div class="clear"></div>
	<h2 class="maintitle">Мои объекты</h2>
	<div class="clear"></div>
	<div style="width:100%; height:18px; background:#6F0">
		<div style="float:right; margin-right:10px" id="pagecontroldivhide">
			<a class="collapseLink" href="javascript:void(0);">Меньше</a>
		</div>
		<div style="float:right; margin-right:10px ; display:none" id="pagecontroldivshow">
			<a class="collapseShowLink" href="javascript:void(0);">Больше</a>
		</div>
		<div class="clear"></div>
		<br/>
    </div>
    

<?php
	$results = $db->select("flats", $usersql, "*", " ORDER BY flat_id DESC","");
	if(count($results)>0) foreach ($results as $flat) include 'singleobject.php'; 
?>




<div class="clear"></div> 


<?php
include_once 'footer.php';
?>
<script type="text/javascript">
 
$(document).ready(function(){   
    //On Click
    $('.collapseLink').click(function(){
        $('[id^="extra_"]').hide();
		$('[id^="pagecontroldivhide"]').hide();
		$('[id^="pagecontroldivshow"]').show();
    });
	$('.collapseShowLink').click(function(){
        $('[id^="extra_"]').show();
		$('[id^="pagecontroldivhide"]').show();
		$('[id^="pagecontroldivshow"]').hide();
    });
});

</script>