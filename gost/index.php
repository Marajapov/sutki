<?php
$active = 99;
$title = "АРЕНДА КВАРТИР ПОСУТОЧНО";

if (isset($_GET["special"])) {
    $title = "СПЕЦПРЕДЛОЖЕНИЯ";
    $active = "4";
} else if (!isset($_GET["flat_type"])) {
    $title = "ВСЕ КВАРТИРЫ";
    $active = "0";
}
include_once 'header.php';

$flat_type = (int) get_request("flat_type",-1);
$room = (int) get_request("room");
$region = (int) get_request("region");
$price = get_request("price");
$priceFrom = (int) get_request("priceFrom");
$priceTo = (int) get_request("priceTo");
$special = (int) get_request("special");
//$status = (int) get_request("status");

$arrRegions = array();
$rwRegions = $db->select("regions", "status=1", "*", " ORDER by region_title ASC");

foreach ($rwRegions as $rwRegion) {
    $arrRegions[$rwRegion['region_id']] = $rwRegion['region_title'];
}
?>


<div id="itemsTopSpace"></div>
<div id="itemsTop"></div>
<div id="items">

    <?php
    $sql = "status=1";


    if ($room > 0) {
        if ($room == 2) {
            $sql.=' AND room_type_id >1';
        } else {
            $sql.=' AND room_type_id=' . $room;
        }
    }
    if ($region > 0) {
        $sql.=' AND region_id=' . $region;
    }
    if ($price != "" && ($priceFrom > 0 || $priceTo > 0)) {
        if ($priceFrom > 0 && $priceTo > 0) {
            $sql.=' AND ' . $price . '>' . $priceFrom . ' AND ' . $price . '<' . $priceTo;
        } else if ($priceFrom > 0 && $priceTo < 1) {
            $sql.=' AND ' . $price . '>' . $priceFrom;
        } else if ($priceFrom < 1 && $priceTo > 0) {
            $sql.=' AND ' . $price . '<' . $priceTo;
        }
    }
    if ($special > 0) {
        $sql.=' AND special=' . $special.' OR special1=' . $special;
        //$title = "ВСЕ КВАРТИРЫ";
        //$active = "3";   
    }

    if (isset($flat_type) && $flat_type >-1) {
        $sql.=' AND flat_type=' . $flat_type;
    }
//echo $flat_type;

    if (isset($_GET['p'])) {
        $start = $_GET['p'];
    } else {
        $start = 0;
    }

    $perpage = 9;

    $count = $db->select_count("flats", $sql, "*", " ORDER BY  flat_id DESC");
    $pagenav = new PageNav($count, $perpage, $start, "p", "flat_type=".$flat_type."&special=" . $special . "&room=" . $room . "&region=" . $region . "&price=" . $price . "&priceFrom=" . $priceFrom . "&priceTo=" . $priceTo);

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
                <p><?php echo substr($rw['description'], 0, 140); ?> ...</p>
                
                <a href="detail.php?id=<?php echo $rw['flat_id']; ?>" class="linkMain">подробное...</a>
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