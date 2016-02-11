<?php
include_once 'usercontrol.php';

$user_id = $_SESSION["userid"];
$user_name = $_SESSION["name"];

$active = 99;
$title = $user_name ." - АРЕНДА КВАРТИР ПОСУТОЧНО";
include_once 'header_user.php';
//$status = (int) get_request("status");
?>
<div class="clear"></div> 
<div id="itemsTopSpace"></div>
<div id="itemsTop"></div>
<div id="items">

    <?php
    $sql = "status=1 AND user_id=".$user_id;


    if (isset($_GET['p'])) {
        $start = $_GET['p'];
    } else {
        $start = 0;
    }
    $perpage = 9;

    $count = $db->select_count("flats", $sql, "*", " ORDER BY  flat_id DESC");
    $pagenav = new PageNav($count, $perpage, $start, "p", "");

    $results = $db->select("flats", $sql, "*", " ORDER BY sortby ASC, flat_id DESC", $start . "," . $perpage);
    $db->debug();
    $i = 0;
    foreach ($results as $rw) {
        $i++;
        ?>
        <div class="iteming">
            <div class="itemingBack">
                <a href="detail.php?id=<?php echo $rw['flat_id']; ?>">
                    <img src="media/items/<?php echo $rw['image_url']; ?>" alt="" class="item">
                </a>
            </div><!--.itemingBack--> 
            <div class="textMain"> 
                <h4 class="titleH4">
                    <b>ID <?php
                    echo $rw['flat_id'];
                    ?> </b>  / 
                    <?php
                    echo $rw['room_type_id'];
                    ?> -ком, <?php echo $arrRegions[(int) $rw['region_id']]; ?>, <?php echo $rw['price_night']; ?> сом за ночь</h4>
                
                <a href="bron.php?id=<?php echo $rw['flat_id']; ?>" class="linkMain">брон</a><br />
                <a href="flat_edit.php?id=<?php echo $rw['flat_id']; ?>" class="linkMain">редактировать</a>
            </div>
            <!--.textMain-->
            <div class="clear"></div> 
        </div>
        <!--.iteming-->
        <?php
        if ($i > 2) {
            $i = 0;
        } else {
           // echo '<div class="extra">
           //         </div><!--.extra-->';
        }
        ?>

    <?php } ?>
    <?php //echo '<div align="left" style="margin: 0px auto 0px; min-height: 20px; width: 940px; float:left;">' . $pagenav->renderCom(3, 3) . '</div><br>';   ?>
    <div class="clear"></div>
    <div id="pagingPosts">             
        <?php echo '<div align="center" >' . $pagenav->renderCom(3, 3) . '</div><br>'; ?>
        <div class="clear"></div>
    </div><!--#pagingPosts--> 

</div>


<!--#items-->

<?php
include_once 'footer.php';
?>