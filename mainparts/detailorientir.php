					<?
                    $rwOrd = $db->select("orientirdb", "flat_id='".$flat['flat_id']."'");
					if (count($rwOrd)>0){
					?>
                    <div class="comment">
                  	
                    <p class="insTitle">Ориентир</p>
                  	<?
						foreach($rwOrd as $rwOr){
					?>
                    <div style="border:1px solid; width:auto; float:left; margin-right:10px; padding:5px;">
					<?=$rwOr['ortype'];?> 
                    <font color="#CC3300"><?=$rwOr['name'];?></font> 
					<?=$rwOr['distance'];?></div>
                   
                   
                   <? } ?>
				   </div>  <!--end commentText-->
                   <div id="clear"></div>
                   <? } ?>