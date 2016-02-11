<?
if ($flat['objectlog']=="unknown404" || ($flat['objectlog']=="")) $flaturl = "http://www.sutki.kg/ru/detail.php?id=".$flat['flat_id']; 
else $flaturl = "http://www.sutki.kg/ru/detail.php?objectlog=".$flat['objectlog'];
?>
<a href = "<?php  echo $flaturl; ?>">

