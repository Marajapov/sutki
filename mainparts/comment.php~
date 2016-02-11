<div class="comment">
                  <p class="insTitle">Отзывы</p>
                  	<?
                    	$rwComments = $db->select("comments", "flat_id='".$flat['flat_id']."'");
						foreach($rwComments as $comment){
					?>
                    <div class="commentText">
                    	   <div class="informComment">
                              <div class="autor"><?=$comment['name'];?></div>
                              <div class="commentDate"><?=$comment['create_date'];?></div>
                              <? if ($comment['review']==0){?>
                              <div class="reviewNegative">Отрицательный</div>
                              <? } ?>
                              <? if ($comment['review']==1){?>
                              <div class="reviewNeutral">Нейтральный</div>
                              <? } ?>
                              <? if ($comment['review']==2){?>
                              <div class="review">Положительный</div>
                              <? } ?>
                          </div>
                      <div class="mainCommenText"><?=nl2br($comment['description']);?>
                     </div>   
                   </div>  <!--end commentText-->
                   <? } ?>
                    
                   
                    <div class="enterComment">
                    <p class="insTitle">Оставьте свой отзыв</p>
                   
                   <form action="http://www.sutki.kg/ru/addcomment.php" method="post">
                    <label for="autor">Ваше имя:</label>
                   <input name="author" type="text" maxlength="250" /><br />
                   <label for="review">Тип отзыва:</label>
                   <select name="review" id="">
                   <option value="2">Положительный</option>
                   <option value="0">Отрицательный</option>
                   <option value="1">Нейтральный</option>
                   </select><br />
                   <label for="comment">Отзыв:</label>
                   <textarea name="comment" cols="" rows=""></textarea> <br />
				   <label for="captcha">Каптча</label>
				   <input name="captcha" type="text" placeholder="Введите цифры" />
				   <img src="captcha.php" /> <br />
                   <input name="" class="comBtn" type="submit" value="Оставить отзыв" />
                   <input type="hidden" name="flat" value="<?=$flat['flat_id'];?>" />
                   </form>
                    </div>
                    <div class="commentSgadow"></div>

<div class='footerMenu' align='center'>
</div>

                  </div><!--end comment-->    



