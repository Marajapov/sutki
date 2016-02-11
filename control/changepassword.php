<?php
include_once 'usercontrol.php';
include_once 'header.php';
$errormessage = "";
$success = 0;
if (isset($_POST["password"])){
	echo "ok";
	$password = $db->escape($_POST["password"]);
	$password1 = $db->escape($_POST["password1"]);
	$password2 = $db->escape($_POST["password2"]);
	if (strlen($password1)<4) $errormessage .= "Поле Пароль должно быть не менее 4 символов в длину. <br />";
	if ($password1 != $password2){ $errormessage .= "Пароли не совпадают <br />"; }
	if ($errormessage == ""){
		$singleUser = $db->select_one("users", "user_id='" . $_SESSION["userid"] . "'", "*", " ORDER BY user_id DESC", "0,1");
		echo $singleUser["user_password"]." ".md5($password);
		if ($singleUser["user_password"]==md5($password)){
			$update = array("user_password" => md5($password1));
			$db->update(DB_PREFIX . "users", $update, "user_id = '" . $_SESSION["userid"]."'");
			$success = 1;
		}
		else {$errormessage = "Неверный пароль ".$singleUser["user_password"]." ".md5($password);}
	}
}

?><br />
<br /><br />
<br />
<? if ($errormessage != "") {?>            
<div class="validation">
<?=$errormessage;?>
</div>
<? } ?>

<? if ($success == 1) {?>            
<div class="success">Пароль успешно изменен.</div>
<? } ?>


<div class="container">
	<section id="content" style="float:none">
		<form action="" method="post" id="forgotpassForm">
			<h1>Смена пароля</h1>

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
<?php
include_once 'footer_login.php';

?>