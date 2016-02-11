<?php
include_once 'usercontrol.php';
include_once 'header_login.php';
$errormessage = "";
if (isset($_POST["password"])){
	
	$password = $db->escape($_POST["password"]);
	$password1 = $db->escape($_POST["password1"]);
	$password2 = $db->escape($_POST["password2"]);
	if (strlen($password1)<4) $errormessage .= "Поле Пароль должно быть не менее 4 символов в длину. <br />";
	if ($password1 != $password2){ $errormessage .= "Пароли не совпадают <br />"; }
	if ($errormessage == ""){
		$singleUser = $db->select_one("users", "user_name='" . $email . "'", "*", " ORDER BY user_id DESC", "0,1");
		if ($singleUser["user_password"]==$password){
			$update = array("user_password" => md5($password1));
			$db->update(DB_PREFIX . "users", $update, "user_mail = '" . $email."'");
		}
		else $errormessage = "Неверный пароль";
	}
}

?><br />
<br />
<? if ($errormessage != "") {?>            
<div class="validation">
<?=$errormessage;?>
</div>
<? } ?>
<div class="container">
	<section id="content">
		<form action="" method="post" id="forgotpassForm">
			<h1>gostinisa.kg</h1>
            <div class="explanation">Смена пароля.</div>

			<div>
				<input type="password" placeholder="Текущий пароль" required="" id="password" name="password"  class="password" />
			</div>
            
            <div>
				<input type="password" placeholder="Новый пароль" required="" id="password1" name="password1"  class="password" />
			</div>
            
            
			<div>
				<input type="password" placeholder="Пароль (еще раз)" required="" id="password2" name="password2" class="password"  />
			</div>
            
			<div>
            	<input type="submit" style="width:350px" id="submit" value="     Далее     "  />
				
			</div>
		</form><!-- form -->
		<!-- small -->
	</section><!-- content -->
</div><!-- container -->    
</div>
<div style="text-align:center"><a href="index.php" style="text-decoration:underline; ">На главную</a></div>
<?php
include_once 'footer_login.php';

?>