<? $searchid = isset($searchid)? $searchid: 0;?>
<? $no3d = isset($no3d)? $no3d: 0;?>
<div id="mainContainer">
<div id="topMenu" style="float:left">
<form action="index.php" method="post" id="generalFormEstateFilter" name="generalFormEstateFilter">
            <table border="0" cellpadding="1" cellspacing="0">
                <tr valign="middle">
                    <td align="left" class="txtSearchbar">&nbsp;</td>
                  <td align="right" class="txtSearchbar">#ID: </td>
                    <td align="left" class="txtSearchbar">
                    <input name="searchid" type="text" value="<?php echo $searchid;?>" size="10" />
                    
                    </td>
                    <td align="left" class="txtSearchbar">
                    <input type="checkbox" name="no3d" value="1" <? if ($no3d==1) echo "checked";?> > Только без 3D
                    
                    </td>
                  <td align="left" class="txtSearchbar">&nbsp;</td>
                    <td align="right" class="txtSearchbar">&nbsp;</td>
                    <td align="left" class="txtSearchbar">
                    <input type="submit" name="button" id="button" value="Найти" /></td>
                </tr>
            </table>
</form>
</div>
<div id="topMenu">
 <a href="index.php" class="nav" style="border-bottom:0px;">&nbsp;&nbsp;Объекты&nbsp;&nbsp;</a>  
 <a href="profile.php" class="nav" style="border-bottom:0px;">&nbsp;&nbsp;Мои данные&nbsp;&nbsp;</a> 
 <a href="changepassword.php" class="nav" style="border-bottom:0px;">&nbsp;&nbsp;Пароль&nbsp;&nbsp;</a> 
 <a href="login.php?a=logout" class="nav" style="border-bottom:0px;">&nbsp;&nbsp;Завершить работу&nbsp;&nbsp;</a>
 </div>
<div id="clear"></div>
<hr class="style-five"/>