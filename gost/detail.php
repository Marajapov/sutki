<?php
$title = "КВАРТИРА";
$active = "1";
include_once 'header.php';

$id = (int) get_request("id", 0);
if ($id > 0) {
    $rw = $db->select_one("flats", "flat_id=" . $id, "*", " ORDER BY  flat_id DESC", "0,1");

    $arrRegions = array();
    $rwRegions = $db->select("regions", "status=1", "*", " ORDER by region_title ASC");

    foreach ($rwRegions as $rwRegion) {
        $arrRegions[$rwRegion['region_id']] = $rwRegion['region_title'];
    }
} else {
    redirect("index.php", "js");
}



if (isset($_GET['p'])) {
    $start = $_GET['p'];
} else {
    $start = 0;
}

//$perpage = get_request('perpage');
$perpage = 3;
$sqlQ = "flat_id=" . $id . " AND status=1";
$count = $db->select_count("comments", $sqlQ);
$pagenav = new PageNav($count, $perpage, $start, "p", "id=" . $id);

$rwComm = $db->select("comments", $sqlQ, "*", "ORDER BY comment_id DESC", $start . "," . $perpage);
?>
<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" /> 
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript">   
    $(document).ready(function(){
   
        $("a[rel=open]").fancybox({
            'transitionIn'        : 'none',
            'transitionOut'        : 'none',
            'titlePosition'     : 'over',
            'titleFormat'       : function(title, currentArray, currentIndex, currentOpts) {
                return '<span id="fancybox-title-over">Фото ' +  (currentIndex + 1) + ' / ' + currentArray.length + ' ' + title + '</span>';
            }
        });
     
    });
    
</script> 
<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkDCwNRQqDIE_kz7uBfmNl1iOBsCT2nt8&sensor=true">
    </script>
    <script type="text/javascript">
	  function initialize() {
        var mapOptions = {
          zoom: <?php echo $rw['zoom']; ?>,
          center: new google.maps.LatLng(<?php echo $rw['latitude']; ?>,<?php echo $rw['longitude']; ?>),
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);

        var image = 'images/beachflag.png';
        var myLatLng = new google.maps.LatLng(<?php echo $rw['latitude']; ?>,<?php echo $rw['longitude']; ?>);
        
		
		var marker = new google.maps.Marker({
			position: myLatLng, 
			map: map, 
			title: "Your location."
		});  
      }
    </script>
<div id="itemsTopSpace"></div>
<div id="itemsTop"></div>
<div id="items">

    <div id="detail">
        <div id="first">
            

            <div id="telephone">
                <p><?php echo $rw['author']; ?></p>
                <p><?php echo $rw['phone_number']; ?></p>
                <p><?php echo $rw['email']; ?></p>
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
                        <?php echo $rw['address']; ?>
                    </div>
                    <div class="clear"></div>
                </div>



                <div class="clear"></div>

            </div>

        </div><!--#itemInfo-->

        <div class="clear"></div>
        
        <div id="thePhoto">
                <a href="media/open/<?php echo $rw['image_url']; ?>" rel="open">
                    <img src="media/items/<?php echo $rw['image_url']; ?>" alt="" class="item1">        
                </a>
            </div><!--#thePhoto-->
            <div class="clear"></div>

            <div id="thumbs">
                <?php
                $rwPhotos = $db->select("photos", "flat_id=" . $id);
                foreach ($rwPhotos as $rwPhoto) {
                    ?>
                    <div class="thumbic">
                        <a href="media/open/<?php echo $rwPhoto['image_url']; ?>" rel="open">
                            <img src="media/thumb/<?php echo $rwPhoto['image_url']; ?>" alt="" class="thimbicIn">
                        </a>
                    </div>
                    <?php
                }
                ?>


                <div class="clear"></div>
            </div><!--#thumbs-->
            <div class="clear"></div>
            
        <div id="map_canvas" style="width:750px; height:560px; border:solid 1px #FF0000" ></div>
        <div class="clear"></div>
        
        <div id="bothOfThem">
            <div class="row">
                <h3 class="textH3">Описание:</h3>
                <p><?php echo $rw['description']; ?></p>
            </div>    

            <!--<div class="row">
                <h3 class="textH3">Расположение:</h3>
                <div id="map">
                    <iframe width="612" scrolling="no" height="314" frameborder="0" src="iframe_map.php?region=<?php echo $arrRegions[$rw['region_id']]; ?>&adress=<?php echo $rw['address']; ?>&" marginwidth="0" marginheight="0"></iframe>


                </div>
            </div> -->
        </div>
        <div class="row1">
            <h4>Отзывы:</h4>
            <?php
            $rwComm = $db->select("comments", "flat_id=" . $id . " AND status=1", "*", "ORDER BY comment_id DESC");
//$db->debug();
            foreach ($rwComm as $rw) {
                ?>
                <div class="post">
                    <p style="color: #9d9d9d; font-weight: bold;"><?php echo $rw['name']; ?>
                        <span style="margin-left: 20px;">
                            <?php echo $rw['create_date']; ?></span></p>
                    </br>
                    <p><?php echo $rw['description']; ?></p>
                    <hr style="height: 1px; margin: 14px 0 0 0;"/>
                </div><!--.post-->

            <?php } ?>  

            <div id="pagingPosts">             
                <?php echo '<div align="center" >' . $pagenav->renderCom(3, 3) . '</div><br>'; ?>
                <div class="clear"></div>
            </div><!--pagination--> 
            <a name="added"></a>


            <?php
            $err = get_request("e", 0);
            if ($err == 1) {
                echo '<a name="bir"></a>';
                echo '<div class="errorSummary">Поздравляем!!!</br> Ваш комментарий добавлен в наш сайт. Скоро будет всем доступным.</div>';
            }
            if ($err == 2) {
                echo '<a name="eki"></a>';
                echo '<div class="errorSummary">' . $error . '</div>';
            }
            ?>
            <div class="clear"></div>
            <div id="commentForm">

                <h4>Оставьте отзыв:</h4>
                <form action="addcomment.php?id=<?php echo $id ?>" method="post" name="comment">
                    <div class="rowek">
                        <div class="labelek1">
                            <label>Ваше имя:</label>
                        </div>
                        <div class="inputek">
                            <input type="text" name="name" id="name">
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="rowek">
                        <div class="labelek1">
                            <label>Отзыв:</label></br>
                        </div>
                        <div class="inputek">
                            <textarea name="comment" rows="5" id="otzyv" ></textarea>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <?php /* <div class="rowek">
                      <div class="labelek1">
                      <label class="labelek1">Защитный код:</label></br>
                      </div>

                      <div id="floatright">
                      <div class="inputek1">
                      <img src="images/captcha.png" alt="">
                      </div>

                      </br>

                      <div class="inputek2">
                      <label class="labelek12">Код на картинке:</label>
                      <input type="text" name="code" id="code">
                      </div>
                      </div><!--#floatright-->
                      </div><!--.rowek--> */ ?>
                    <div class="clear"></div>
                    <div id="ok">
                        <input type="image" src="images/leaveComment.png">
                    </div><!--#ok-->
                    <input type="hidden" name="a" id="a" value="commentAdd"/>
                </form>
            </div><!--#commentForm-->

        </div><!--#bothOfThem-->
    </div><!--#detail-->
    <div id="rightbar">

        <?php
        include_once 'inc_search.php';
        include_once 'inc_special.php';
        ?>

    </div><!--#rightbar-->

    <div class="clear"></div>
</div><!--#items-->


<?php
include_once 'footer.php';
?>