
        <div id="search">
            <form action="index.php" method="get" name="generalForm" id="generalForm">
                <div id="searchLeft">
                    <div id="searchLeftInTop">
                        <div class="zoom">
                            <img src="images/zoom.png" alt="">
                            <p class="searchIn" id="poisk">ПОИСК</p> 
                        </div>                      
                    </div><!--#searchLeftInTop--> 

                    <div id="searchLeftInBottom">

                        <select name="flat_type" id="flat_type" class="searchSelectIndex">
                           <option value="">Тип</option>    
                            <?php
                            foreach ($arrType as $key => $value) {
                                echo '<option value="' . $key . '" ';
                                if ($key == $flat_type)
                                    echo 'selected';
                                echo ' >' . $value . '</option>';
                            }
                            ?>    

                        </select>
                        <select name="room" id="room" class="searchSelectIndex">
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
                        echo '<select name="region" class="searchSelectIndex">';
                        echo '<option value="">Районы</option>';
                        foreach ($rwRegions as $reg) {
                            echo '<option value="' . $reg["region_id"] . '" ';
                            if ($reg['region_id'] == $region)
                                echo 'selected';
                            echo ' >' . $reg['region_title'] . '</option>';
                        }
                        echo '</select>';
                        ?>

                        <select name="price" id="price" class="searchSelectIndex">
                            <option value="">Цены</option>
                            <option value="price_hour" <?php if ($price == "price_hour") echo "selected"; ?> >Цена за час</option>
                            <option value="price_night" <?php if ($price == "price_night") echo "selected"; ?>>Цена за ночь</option>
                            <option value="price_day" <?php if ($price == "price_day") echo "selected"; ?>>Цена за сутки</option>
                        </select> 

						<div id="searchAddedInBottom">
						<p class="searchIn priceText">Цены от</p>
                    	<input type="text" id="priceFrom" name="priceFrom" class="price" <?php if ($priceFrom) echo "value=" . $priceFrom; ?>>
                    	<p class="searchIn priceText">до</p>
                    	<input type="text" id="priceTo" name="priceTo" class="price" <?php if ($priceTo) echo "value=" . $priceTo; ?>>
                    	<input type="image" id="searchButton" src="images/searchButton.png">
                        </div>
                    </div><!--#searchLeftInBottom-->
                    
                </div><!--#searchLeft-->
                

            </form>
        </div><!--#search-->