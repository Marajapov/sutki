<?php	
$searchsql = "";
if (isset($_POST["searchid"]) && (((int)($_POST["searchid"]))>0)) {
	$searchid = (int)($_POST["searchid"]);	
	$searchsql = "flat_id='".$searchid."'";
}
else if (isset($_POST["no3d"]) && (((int)($_POST["no3d"]))>0)) {
	$no3d = (int)($_POST["no3d"]);	
	$searchsql .= "length(flashtour) <4";
}
include_once 'header.php';
?>

<div class="clear" ></div> 
<div class="main_border" align="center">

            <h2 class="maintitle">Объекты</h2>

            <div class="clear"></div>

            <?php
			
			if (isset($_GET['p'])) {
            $start = (int)$_GET['p'];
			} else {
				$start = 0;
			}
			$perpage = 20;
			$count = $db->select_count("flats", $searchsql, "*", " ORDER BY flat_id DESC");
			if ($count<($start+1)) $start =  $count-1;
			$pagenav = new PageNav($count, $perpage, $start, "p", $extraurl);
			$results = $db->select("flats", $searchsql, "*", "ORDER BY flat_id DESC", $start . "," . $perpage);
			
			if(!count($results)>0){
			?>
			Все пусто
			<?php } else {?>  
            <!--START:#pagingPosts-->
        <div class="clear"></div>
        <div class="dvIndexLine">
            <div class="clear"></div><br />
            <div id="pagingPosts">
                <?php echo '<div align="center" >'. $pagenav->renderCom(5, 3) . '</div><br>'; ?>
                <div class="clear"></div>
            </div>
            
        </div>
        <!--END:#pagingPosts-->
            
                     
<table border="0" align="right" cellpadding="0" cellspacing="0" class="maps_item">       
<tr>
  <td colspan="2"><hr class="style-six"></td>
</tr>

<?php
    	foreach ($results as $rw) {
?>
<tr>
<td width="210" valign="top" class="image_td">
<?php if ($rw['flashtour']=="") {?>
<div class="noflash">
Нет 3D
</div>
<? } else {?>
<div class="yesflash" >
3D
</div>
<? } ?>
</td>
<td valign="top" class="details_td">
<div class="details"><div class="title">
<?php echo $rw['flat_id']; ?>. <a href="object.php?id=<?php echo $rw['flat_id']; ?>"><?php echo $rw['name_ru']; ?></a>

</div></div>
</td>
</tr>          
<tr>
  <td colspan="2"><hr class="style-six"></td>
</tr>
<?php }?>
</table>
<?php } ?>
</div>
<div class="clear"></div> 
<?php
include_once 'footer.php';

function makeaddress($db,$rw, $rwRegions, $rwSubRegion){
	$homenumber =  $rw["homenumber"];
	$apartment =  $rw["apartment"];
	$street = $rw["street"];
	$district = $subregion = "";
	$city = "";
	$result = "";
	//$rwRegions = $db->select("regions", "", "*", "ORDER BY region_id ASC");
	//$rwSubRegion = $db->select("subregions", "region_id=".$myRegionSelected, "*", "");
	$rwCity = $db->select("city", "", "*", "");
	if ($rw["city"]>0) foreach ($rwCity as $ct) if ($ct["city_id"] == $rw["city"]) $city = $ct["name"];
	if ($rw["district"]>0) foreach ($rwRegions as $region) if ($region["region_id"] == $rw["district"]) $district = $region["region_title"];
	if ($rw["district"]>0) foreach ($rwSubRegion as $sub) if ($sub["subregion_id"] == $rw["subregion"]) $subregion = $sub["subregion_name"];
	if (strlen($street)>0) { 
		$result = "ул. ".$street;
		if (strlen($apartment)>0 && $apartment>0) {
			$result .= " ".$apartment; if (strlen($homenumber)>0 && $homenumber>0) $result .= "/".$homenumber;  
		}
		else { if (strlen($homenumber)>0&& $homenumber>0) $result .= " ". $homenumber;}
	}
	
	if (strlen($district)>0) { if (strlen($result)>0) $result .=","; $result .= " ".$district;}
	if (strlen($subregion)>0) { if (strlen($result)>0) $result .=","; $result .= " ".$subregion;}
	if (strlen($city)>0) { if (strlen($result)>0) $result .=","; $result .= " ".$city;}
	if (strlen($result)>0) $result .=".";
	return $result;	
}
?>