<?php
setlocale(LC_CTYPE, 'ru_RU');
$title = "КВАРТИРА";
$active = "1";
require_once 'config.php';
	$rws = $db->select("flats", "flat_id<85","*","");
	foreach ($rws as $rw) {
		$id = $rw['flat_id'];
		?>


    <div id="detail">
        <div id="first">
            

            <div id="telephone">
                Владелец : <?=mb_convert_encoding($rw['author'], 'Windows-1252', 'UTF-8');?>
                </p>
                <p>Тел: <?php echo $rw['phone_number']; ?></p>
                
                <p>Почта: <?=mb_convert_encoding($rw['email'], 'Windows-1252', 'UTF-8');?></p>
            </div>

            <!--<div id="svobodna">
                <a href="#" id="svobod"><img src="images/svobodna.jpg" alt=""></a>
            </div>--><!--#svobodna-->

        </div><!--#first-->               

        <div class="extra1">
        </div><!--.extra-->
        <div id="itemInfo">
            <h2 class="textH2"><b>ID <?php
                echo $rw['flat_id'] . "</b> / ";
                echo $rw['room_type_id'];
                ?> -ком, <?php echo $arrType[$rw['flat_type']] . ", " . $arrRegions[$rw['region_id']]; ?></h2> 

            <div id="text">
                <div class="txtLine">
                    <div class="txtLineLeft txtLineBold">
                        Цена за час
                    </div>

                    <div class="txtLineRight txtLineRed">
                        <?php echo $rw['price_hour']; ?> сом
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="txtLine">
                    <div class="txtLineLeft txtLineBold">
                        Цена за ночь
                    </div>

                    <div class="txtLineRight txtLineRed">
                        <?php echo $rw['price_night']; ?> сом
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="txtLine">
                    <div class="txtLineLeft txtLineBold">
                        Цена за сутки
                    </div>

                    <div class="txtLineRight txtLineRed">
                        <?php echo $rw['price_day']; ?> сом
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="txtLine">
                    <div class="txtLineLeft">
                        Комнаты
                    </div>

                    <div class="txtLineRight ">
                        <?php echo $rw['room_type_id']; ?> 
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="txtLine">
                    <div class="txtLineLeft">
                        Спальных мест
                    </div>

                    <div class="txtLineRight ">
                        <?php echo $rw['bed']; ?> 
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="txtLine">
                    <div class="txtLineLeft">
                        Тип строения
                    </div>

                    <div class="txtLineRight ">
                        <?php echo $arrSeria[$rw['floor']]; ?>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="txtLine">
                    <div class="txtLineLeft">
                        Район
                    </div>

                    <div class="txtLineRight ">
                        <?php echo $arrRegions[$rw['region_id']]; ?> 
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="txtLine">
                    <div class="txtLineLeft">
                        Адрес
                    </div>

                    <div class="txtLineRight ">
                    <?=mb_convert_encoding($rw['address'], 'Windows-1252', 'UTF-8');?>
                    </div>
                    <div class="clear"></div>
                </div>



                <div class="clear"></div>

            </div>

        </div><!--#itemInfo-->

        <div class="clear"></div>
        
        <div id="thePhoto">

                    <img src="media/open/<?php echo $rw['image_url']; ?>">        

            </div><!--#thePhoto-->
            <div class="clear"></div>

            <div id="thumbs">
                <?php
                $rwPhotos = $db->select("photos", "flat_id=" . $id);
                foreach ($rwPhotos as $rwPhoto) {
                    ?>
                    <div class="thumbic">

                            <img src="media/open/<?php echo $rwPhoto['image_url']; ?>">

                    </div>
                    <?php
                }
                ?>


                <div class="clear"></div>
            </div><!--#thumbs-->
            <div class="clear"></div>
        
        <div id="bothOfThem">
            <div class="row">
                <h3 class="textH3">Описание:</h3>
                <p>
<?=mb_convert_encoding($rw['description'], 'Windows-1252', 'UTF-8');?>
                
                
                </p>
            </div>    

            <!--<div class="row">
                <h3 class="textH3">Расположение:</h3>
                <div id="map">
                    <iframe width="612" scrolling="no" height="314" frameborder="0" src="iframe_map.php?region=<?php echo $arrRegions[$rw['region_id']]; ?>&adress=<?php echo $rw['address']; ?>&" marginwidth="0" marginheight="0"></iframe>


                </div>
            </div> -->
        </div>
        <hr/>
    <? } ?>
    

    <div class="clear"></div>
</div><!--#items-->