        <div id="specials">
            <img src="images/specialOrder.png" alt="">
        </div><!--#specials-->
        <?php
            $rwSpec=$db->select("flats", "special=1 AND status=1", "*", " ORDER BY sortby ASC,  flat_id DESC");
            //echo var_dump($rwSpec);
            foreach($rwSpec as $rwS){
                $rwRegion = $db->select_one("regions", "region_id=" . $rwS['region_id'], "*" );
                //$rwRoom = $db->select_one("rooms", "room_id=" . $rwS['room_type_id'], "*" );
                
                echo '<div><div class="specialPhotosBar"><div class="specialPhotosClass">';    
                echo '<img src="media/items/'. $rwS['image_url'] .'"  class="specPhotoClass">';
                echo '</div><!--specialPhotosClass--><div class="transparent45"><div class="transparent45In">';
                echo '<h3 style="font-size:11px;"><b>ID ' . $rwS['flat_id'] . ' / </b>' . $rwS['price_night'] . ' сом за ночь</h3>' ;
                echo '<p>' . ($rwS['room_type_id'] == (1 || 5))? $rwS['room_type_id'] . ' комнатная. '  : $rwS['room_type_id']. '-х комнатная. ' ;
                echo '</p>';
                echo '<p>' . $rwRegion['region_title'] . '</p>';
                echo '</div><!--#transparent45In--><!--<div class="transparent45InSecond">-->';
                
                echo '<!--</div><!--.transparent45InSecond--></div><!--.transparent45-->';
                echo '<a class="lnkDetailingButton" href="detail.php?id=' . $rwS['flat_id'] . '"><img src="images/podrobnoe.png" alt=""></a>';                
                echo '</div><!--.specialPhotosBar--></div><div class="clear"></div>';
            }
        ?>
