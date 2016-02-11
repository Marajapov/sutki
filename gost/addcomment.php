<?php
$title = "КВАРТИРА";
$active = "1";
include_once 'header.php';

$action = get_request('a');
$error = "";
$err = 0;
if ($action == 'commentAdd') {
    $flat_id = get_request('id');
    $name = $_POST['name'];
    $description = $_POST['comment'];
    
    if($name == ""){
        $error.="Ваше имя не введено!!!</br>";
    }
    if($description == ""){
        $error.="Описание не введено!!!</br>";
    }
    if(!$error){
    $status = 0;
    $new = 1;

    $insert = array(
        "flat_id" => $flat_id,
        "name" => $name,
        "description" => $description,
        "new" => $new,
        "status" => $status,
    );
    $db->insert("comments", $insert);
    $err = 1;
    redirect("detail.php?id=" . $flat_id ."&e=1#added", "js");
   
    }
    else{
        $err = 2;
    redirect("detail.php?id=" . $flat_id ."&e=2#added", "js");
    
    }
}
?>

<?php
include_once 'footer.php';
?>
