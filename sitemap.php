<?php

$db_host="localhost:3306";
$db_user="apartamenty";
$db_pass="apartamentyisfine";
$db_name="apartamenty";

/*
$db_host="localhost";
$db_user="evro";
$db_pass="1";
$db_name="evro";
*/
date_default_timezone_set('Asia/Bishkek');
define('DB_PREFIX', "");
define('ROOT_PATH', dirname(__FILE__));
define("PHP_SELF",$_SERVER['PHP_SELF']); 

require_once "/class/classloader.php";
require_once "/class/functions.php";

$db=new db_mysql($db_host,$db_user,$db_pass,$db_name);
$db->connect();
header("Content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
    <url>
        <loc>http://www.sutki.kg/</loc>
        <changefreq>always</changefreq>
    </url>
    <url>
        <loc>http://www.sutki.kg/ru/</loc>
        <changefreq>always</changefreq>
    </url>
    <url>
        <loc>http://www.sutki.kg/ru/index.php</loc>
        <changefreq>always</changefreq>
    </url>
    <url>
  		<loc>http://www.sutki.kg/ru/about.php</loc>
        <changefreq>monthly</changefreq>
    </url>
    <url>
      <loc>http://www.sutki.kg/ru/contact.php</loc>
      <changefreq>daily</changefreq>
    </url>
    <url>
      <loc>http://www.sutki.kg/ru/chastye-voprosy.php</loc>
      <changefreq>yearly</changefreq>
    </url>
<?php
		$rwHeaderResult = $db->select("flats");
        foreach ($rwHeaderResult as $flat) {
			if ($flat['objectlog']=="unknown404" || ($flat['objectlog']=="")) $flaturl = "http://www.sutki.kg/ru/detail.php?id=".$flat['flat_id']; 
			else $flaturl = "http://".$flat['objectlog'].".sutki.kg";  
			?>
            <url>
                <loc><?=$flaturl;?></loc>
                <changefreq>daily</changefreq>
                <priority>0.5</priority>
            </url>
<? } ?> 
</urlset>
