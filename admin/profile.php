<?php
include_once 'operatorcontrol.php';
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE)); 
ini_set('display_errors', '1');

$currentUser = $db->select_one("users", "user_id='" . $_SESSION['userid'] . "'", "*", " ORDER BY user_id DESC", "0,1");
$realpassword = $currentUser["user_password"];
$success = 0;
if (isset($_POST["email"])){
		$errormessage = "";
		$name = $_POST["name"];
		$email = $_POST["email"];
		$phone = $_POST["phone"];
		$password = $_POST["password"];
		
		if (md5($password) != $realpassword){
				$errormessage = "Вы указали неверный текущий пароль. <br />";
			}

		if (strlen($errormessage)==0){
			$update = array(
            "user_realname" => $name,
            "user_mail" => $email,
            "user_phone" => $phone,
        	);
        	//$db->update("users", $insert);
			$db->update(DB_PREFIX . "users", $update, "user_id = " . $_SESSION['userid']);
			$lastUser = $db->select_one("users", "user_name='" . $username . "'", "*", " ORDER BY user_id DESC", "0,1");
			$success = 1;
			
		}
}

$currentUser = $db->select_one("users", "user_id='" . $_SESSION['userid'] . "'", "*", " ORDER BY user_id DESC", "0,1");
$name = $currentUser["user_realname"];
$email = $currentUser["user_mail"];
$phone = $currentUser["user_phone"];

include_once 'header.php';
?>
<br />
<br />
<br />
<br />

<div class="container">
	<section id="content"  style="float:none">
		<form action="profile.php" method="post" id="registerForm">
			<h1>Личные данные</h1>
 <? if ($success == 1) {?>            
<div class="success">
Данные успешно сохранены
</div>
<? } else if ($errormessage != "") {?>            
<div class="validation">
<?=$errormessage;?>
</div>
<? } ?>

			<div>
				<input type="password" placeholder="Текущий пароль" required="" id="password" name="password"  class="password" />
			</div>
<br/><br/>
			<div>
				<input type="text" placeholder="Полное имя" required="" id="name" name="name" class="username" value="<?=$name;?>" />
			</div>
            
            <div>
				<input type="text" placeholder="Электронная почта" required="" id="email" name="email" class="email" value="<?=$email;?>" />
			</div>
            
            <div>
				<input type="text" placeholder="Контактный телефон" required="" id="phone" name="phone" class="phone" value="<?=$phone;?>" />
			</div>
            
            
            
            
            
			<div>
            	<input type="submit" id="submit" value="Сохранить изменения" style="width:330px" onClick="return validate()"  />
				
			</div>
		</form><!-- form -->
		
	</section><!-- content -->
</div><!-- container -->
        
</div>