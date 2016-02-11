<?
$city_id=$_GET['city_id'];
require "config.php";
$q=mysql_query("select * from regions where city_id='$city_id'");
echo mysql_error();
$myarray=array();
$str="";
while($nt=mysql_fetch_array($q)){
$str=$str . "\"$nt[region_title]\"".","."\"$nt[region_id]\"".",";
}
$str=substr($str,0,(strLen($str)-1)); // Removing the last char , from the string
echo "new Array($str)";

?>