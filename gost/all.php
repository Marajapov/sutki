<?php
include_once 'header.php';
  $results = $db->select("flats", "", "*", " ORDER BY  flat_id DESC", $start . "," . $perpage);
  echo var_dump($results);
?>

<div id="items">
            
            <?php 
                       
            for($i=0; $i<=count($results)-1; $i++){ 
                 
                if(($i+1)%3 == 1){?>
                <div class="itemRowContainer"> 
                <?php } ?>
                <div class="iteming">
                    <div class="itemingBack">
                    <a href="details.php?id=<?php echo $results[$i]['flat_id']; ?>">
                        <img src="media/items/<?php echo $results[$i]['image_url']; ?>" alt="" class="item">
                    </a>
                    </div><!--.itemingBack--> 
                    <div class="textMain"> 
                        <h4 class="titleH4"><?php echo $results[$i]['room_type_id']; ?>-КОМ, Бишкек, <?php echo $results[$i]['price_day']; ?> сом. в сутки</h4>
                        <p><?php echo $results[$i]['description']; ?></p>
                    <a href="#" class="linkMain">подробное...</a>
                </div><!--.textMain-->
                <div class="clear"></div> 
                </div><!--.iteming-->
                <?php 
                if(($i+1)%3 == 0){ ?>
                </div><!--.itemRowContainer-->
                <?php } 
                else{
                    ?>
                    <div class="extra">
                    </div><!--.extra-->
                <?php
                }
                ?>   
             <?php } ?>                                
            
              
        
        </div><!--.items-->
        
        
<?php
include_once 'footer.php';
?>