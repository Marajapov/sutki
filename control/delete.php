
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="../styles/user.css" rel="stylesheet" type="text/css" />
<link href="../styles/style.css" rel="stylesheet" type="text/css" />
<link href="../styles/login.css" rel="stylesheet" type="text/css" />
<link href="../styles/table.css" rel="stylesheet" type="text/css" />
     			
		</head>
<body >

  <div id="wrapper">

    <!--HEADER/NAVIGATION STARTS-->
  	<header>
  	    <section class="contained">
            <a id="logo" title="" href="index.php">>&nbsp;</a>
                        <nav>
                          <ul>
                            <li><a href="index.php">Мои объекты</a></li>
                            <li><a href="comments.php">Отзывы</a></li>
                            <li><a href="profile.php">Мои данные</a></li>
                            <li><a href="changepassword.php">Пароль</a></li>
                            <li><a href="login.php?a=logout.php">Завершить работу</a></li>
                            
                          </ul>
                        </nav>
          </section>
      </header>
    <!--HEADER/NAVIGATION ENDS-->


<div class="main_border" align="center">

			<h2 class="maintitle">Отзывы</h2>
            <div class="clear"></div>
			
                        <table width="100%" >
				<tr> 
					<td>
                    Объект
					</td>
                    <td style="width:300px">
                    Отзыв
					</td>
					<td >
					Автор
					</td>
                    <td>&nbsp;
                    	
					</td>
				</tr>


            
        		 <tr>
				   <td  style="width:150px">
												<b>СЕВЕРНОЕ СИЯНИЕ</b><br/>
                        <img src="../images/thu/1360146214.jpg" align="left" class="item" height="100px" style="margin:10px;">
                        <br /><a href="commentssingle.php?flat_id=4" class="photodescription">все <span class="red">отзывы</span> объекта</a>
					</td>
                   	<td style="width:500px">
						fasdfasdf	
					</td>

					<td valign="top">
                    	Иссык-Куль<br />
<br />
                        2013-02-08 13:44:30	
					</td>

                    <td valign="top">
                    
                    <a  onClick='return confirm("Вы уверены, что хотите удалить?");' href="delete_object.php?flat_id=4">Удалить</a>
					</td>
				</tr>
            
        		 <tr>
				   <td  style="width:150px">
												<b>Neque porro quisquam est qui d</b><br/>
                        <img src="../images/thu/1360065849.jpg" align="left" class="item" height="100px" style="margin:10px;">
                        <br /><a href="commentssingle.php?flat_id=1">все отзывы объекта</a>
					</td>
                   	<td style="width:500px">
						fasdfasdf	
					</td>

					<td valign="top">
                    	dfasd<br />
<br />
                        2013-02-08 13:44:28	
					</td>

                    <td valign="top">
                    
                    <a  onClick='return confirm("Вы уверены, что хотите удалить?");' href="delete_object.php?flat_id=1">Удалить</a>
					</td>
				</tr>
    			</table>
             
</div>
<div class="clear"></div> 
<div id="itemsBottomSpace"></div>
    <div class="clear"></div>
    <div id="dvFullFooter">
        <div id="dvFullTopFooter">
        </div><!--#dvFullTopFooter-->
        <div id="dvFullBottomFooter">
            <div id="bottomFooter">
                <div id="footerText" align="right">
                            <a href="login.php?a=logout" style="color:#FFF">Завершить работу</a></p>
                </div><!--#footerText-->              
            </div><!--#bottomFooter-->
        </div><!--#dvFullBottomFooter-->
    </div><!--#dvFullFooter-->              
  
  

</div><!--#dvFullSite-->  

</body>
</html>