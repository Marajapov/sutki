
        <div id="search300">
            <div id="topperSearch">                    
                <div class="zoom">
                    <img src="images/zoom.png" alt="">
                    <p class="searchIn" id="poisk">ПОИСК</p> 
                </div>                            
            </div><!--#topperSearch-->

            <div class="clear"></div>

            <div id="searchLeftInBottom">
                <form action="index.php" method="get" id="generalForm">
                    <select name="flat_type" class="searchSelect">
                             <option value="">Тип</option>                          
                            <?php                        
                            foreach ($arrType as $key=>$value) {
                                echo '<option value="' . $key . '" ';                               
                                echo ' >' . $value. '</option>';
                            }                            
                            ?>    

                        </select>
                    
                    <select name="room" class="searchSelect">
                        <option value="">Комнаты</option>
                        <?php
                            $rwRooms2 = $db->select("rooms", "status=1", "*", "ORDER BY room_type ASC");
                            foreach ($rwRooms2 as $rwR2) {
                                echo '<option value="' . $rwR2["room_type"] . '"';
                                if ((int) $rwR2["room_type"] == $room)
                                    echo ' selected';
                                echo '>' . $rwR2["room_type"] . '</option> ';
                            }
                            ?>              
                    </select>



<?php
$rwRegions = $db->select("regions", "", "*", "ORDER BY region_id ASC");
//echo var_dump($rwCategories);
$db->debug();
echo '<select name="region" class="searchSelect">';
echo '<option value="">Районы</option>';
foreach ($rwRegions as $region) {
    echo '<option value="' . $region["region_id"] . '" ';
    if ($region['region_id'] == $region_id)
        echo 'selected';
    echo ' >' . $region['region_title'] . '</option>';
}
echo '</select>';
?>
                    <select name="price" class="searchSelect">
                        <option value="">Цены</option>
                        <option value="price_hour" <?php if ($price == "price_hour") echo "selected"; ?> >Цена за час</option>
                        <option value="price_night" <?php if ($price == "price_night") echo "selected"; ?>>Цена за ночь</option>
                        <option value="price_day" <?php if ($price == "price_day") echo "selected"; ?>>Цена за сутки</option>
                    </select> 
                    <div id="searchPriceIn300">
                        <p class="searchIn priceText">Цены от</p>
                        <input type="text" id="from" name="priceFrom" class="price" <?php if ($priceFrom) echo "value=" . $priceFrom; ?>>
                        <p class="searchIn priceText">до</p>
                        <input type="text" id="to" name="priceTo" class="price" <?php if ($priceTo) echo "value=" . $priceTo; ?>>
                        <div class="clear"></div>                            
                    </div><!--#searchPriceIn300-->

<input type="image" id="searchButton300" src="images/searchButton.png">
                    <!--<a href="javascript:submitFormSelected('generalForm');" ><img src="images/searchButton.png" alt=""  id="searchButton"></a>-->                                  </form>
            </div><!--#searchLeftInBottom-->



        </div><!--#search300-->
        <div class="clear"></div>