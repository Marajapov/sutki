<?
require '../config.php';
$a = Array("Тору","Айгыр","Чырпыкты","Тамчы","Чок-Тал","Чон-Сары-Ой","Сары-Ой","Кара-Ой","Чолпон-Ата","Бостери","Булан-Соготту","Корумду","Ананьево","Кутурга","Курмонту","Туп","Каракол","Балыкчы","Оттук","Кызыл-Туу","Ак-Сай","Боконбаев","Кадж-Сай","Тосор","Тамга","Барскоон","Чычкан","Дархан","Сау","Кызыл Суу","Джети Огуз","Шалба");
for($i = 0; $i< count($a); $i++){
	$insert = array("status"=>1,"city_id"=>2,"region_title" => $a[$i]);
	$db->insert("regions", $insert);
}
?>
