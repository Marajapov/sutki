				<? if ($flat_type < 3 || $flat['sauna_type']==1) {
					$pricenight = $priceday = $pricehour = "";
					$curname = $flat['currency']==1 ? "$":"сом";
					if ($flat_type < 3) {
						if ($flat['price_night']>0)$pricenight = "<p><span>".returndiscountprice($flat['price_night'], $flat['currency'], $usdtokgs, $flat['discount'], $flat['discountdate_from'], $flat['discount_date']).$val."</span> ".$curname."— на один ночь</p>";
						if ($flat['price_day']>0)$priceday = "<p><span>".returndiscountprice($flat['price_day'], $flat['currency'], $usdtokgs, $flat['discount'], $flat['discountdate_from'], $flat['discount_date']).$val."</span> ".$curname."— на один сутки</p>";
						if ($flat['price']>0)$pricehour = "<p><span>".returndiscountprice($flat['price'], $flat['currency'], $usdtokgs, $flat['discount'], $flat['discountdate_from'], $flat['discount_date']).$val."</span> ".$curname."— на один час</p>";
					}
					if ($flat['sauna_type']==1) {
						$pricehour = "<p><span>".$flat['price']."</span> ".$curname."— на один час</p>";
						if ($flat['discount']>0) $pricehour .= "<p><span>".$flat['discount']."</span> ".$curname."— с ".$saunadb['skidkafrom']." до ".$saunadb['skidkato']."</p>";
						if ($saunadb['servicefee']>0)$pricehour .= "<p><span>".$saunadb['servicefee']."%</span>— За обслуживание</p>";
					}
					?>
                <div class="insRpice" style="background:url(http://www.sutki.kg/ru/images/priceBgDetail.png)">
                  <h6>Цены</h6>
                  <? $finalprice = $pricenight . $priceday . $pricehour;
				  if ($finalprice=="") echo "?"; else echo $finalprice;
				  ?>
                  </div>
       				<!--datepicker-->
                    <? } ?>
                    <? if ($room) {
					$pricenight = $priceday = $pricehour = "";
					$curname = $room['currency']==1 ? "$":"сом";
					if ($room['price_night']>0)$pricenight = "<p><span>".returndiscountprice($room['price_night'], $room['currency'], $usdtokgs, $room['discount'], $room['discountdate_from'], $room['discount_date'])."</span> ".$curname."— на один ночь</p>";
					if ($room['price_day']>0)$priceday = "<p><span>".returndiscountprice($room['price_day'], $room['currency'], $usdtokgs, $room['discount'], $room['discountdate_from'], $room['discount_date'])."</span> ".$curname."— на один сутки</p>";
					if ($room['price']>0)$pricehour = "<p><span>".returndiscountprice($room['price'], $room['currency'], $usdtokgs, $room['discount'], $room['discountdate_from'], $room['discount_date'])."</span> ".$curname."— на один час</p>";	
					?>
                <div class="insRpice">
                  <h6>Цены</h6>
                  <?
                  	if ($flat_type==4 && $flat['sauna_type']!=1) echo $pricehour . $pricenight . $priceday;
					else echo $priceday . $pricenight . $pricehour;
				  ?>
                  </div>
       				<!--datepicker-->
                    <? } ?>
                    
                    <!--<a href="#" class="online">Забронировать онлайн</a>-->
      
      			  <div class="contact">
                  <p>Связаться с владельцем</p>
                  <table border="0">
                    <? if (strlen($flat['phone'])>5) {?>
                    <tr>
                      <td>Тел:</td>
                      <td><?=str_replace(",","<br/>",$flat['phone']);?></td>
                    </tr>
                    <? } ?>
                    <? if (strlen($flat['phone2'])>5) {?>
                    <tr>
                      <td>Доп. Тел:</td>
                      <td><?=$flat['phone2'];?></td>
                    </tr>
                    <? } ?>
                    <? if (strlen($flat['phone3'])>5) {?>
                    <tr>
                      <td>Доп. Тел 2:</td>
                      <td><?=$flat['phone3'];?></td>
                    </tr>
                    <? } ?>
                    <? if (strlen($flat['email'])>5) {?>
                    <tr>
                      <td>E-mail:</td>
                      <td><?=str_replace(",","<br/>",$flat['email']);?></td>
                    </tr>
                    <? } ?>
                    <? if (strlen($flat['skype'])>5) {?>
                    <tr>
                      <td>Skype:</td>
                      <td><?=$flat['skype'];?></td>
                    </tr>
                    <? } ?>
                    <? if (strlen($flat['icq'])>5) {?>
                    <tr>
                      <td>Факс:</td>
                      <td><?=$flat['icq'];?></td>
                    </tr>
                    <? } ?>
                  </table>

                  
                  </div>
                  
                 <? include '../mainparts/special.php';?>	