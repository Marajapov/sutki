<?php
include_once 'header.php';

$action = get_request('a');
$error = "";
$flat_id = get_request('id');

echo $action;
echo "</br>";
echo $flat_id;
if($action== 'commentAdd'){
    $flat_id = get_request('id');
    $name = $_POST['name'];
    $description = $_POST['comment'];
    //$create_date = time();
    $status = 0;
    $new = 0;
    
    $insert = array(
    "flat_id" => $flat_id,
    "name" => $name,
    "description" => $description,
    //"create_date" => $create_date,
    "new" => $new,
    "status" => $status,
    );
    $db->insert("comments", $insert);
}
  
  
  
  
?>
