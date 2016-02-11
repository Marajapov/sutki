<?php
include_once 'usercontrol.php';
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE)); 
ini_set('display_errors', '1');

if (isset($_POST["username"])){
		$errormessage = "";
		$name = $_POST["name"];
		$username = $_POST["username"];
		$email = $_POST["email"];
		$phone = $_POST["phone"];
		$password = $_POST["password1"];
		$password2 = $_POST["password2"];
		if (strlen($username) < 4){
				$errormessage = "Поле Логин должно быть не менее 4 символов в длину. <br />";
			}
		if (strlen($password) < 4){
				$errormessage .= "Поле Пароль должно быть не менее 4 символов в длину. <br />";
			}
		if ($password != $password2){
				$errormessage .= "Пароли не совпадают <br />";
			}
		if ($session->isExistUserName($username)){
				$errormessage .= "Пользователь с таким логином уже зарегистрирован. Выберите другой. <br />";
			}
		if ($session->isExistEmail($email)){
				$errormessage .= "Пользователь с таким адресом электронной почты уже зарегистрирован. Выберите другой. <br />";
			}
		if (strlen($errormessage)==0){
			$insert = array(
            "user_name" => $username,
            "user_realname" => $name,
            "user_password" => md5($password),
            "user_mail" => $email,
            "user_phone" => $phone,
            "user_status" => "1",
            "user_type" => "0"
        	);
        	$db->insert("users", $insert);
			$lastUser = $db->select_one("users", "user_name='" . $username . "'", "*", " ORDER BY user_id DESC", "0,1");
			session_regenerate_id();
			$_SESSION['auth'] = 1;
			$_SESSION['name'] = $username;
			$_SESSION['userid'] = $lastUser["user_id"];
			redirect("index.php","header");
		}
	}
include_once 'header_login.php';
?>

<div class="container">
	<section id="content">
		<form method="post" id="registerForm">
			<h1>РЕГИСТРАЦИЯ</h1>
            
<? if ($errormessage == "") {?>            
            <div class="explanation">
Если у вас уже есть аккаунт - <a href="login.php" style="margin-right:0px; margin-top:0px; margin-left:0px; float:none; font-size:14px; text-decoration:none; ">войдите</a> в систему.
<br />
<br />

Если Вы не зарегистрированы в системе, пройдите несложную регистрацию для самостоятельного добавления и редактирования информации о вашей квартире или отеле.
<br />
<br />

Пожалуйста, заполните поля ниже:
</div>
<? } else {?>            
<div class="validation">
<?=$errormessage;?>
</div>
<? } ?>


			<div>
				<input type="text" placeholder="Название организации или Имя владельца" required="" id="name" name="name" class="username" value="<?=$name;?>" />
			</div>
            
            <div>
				<input type="text" placeholder="Логин" required="" id="username" name="username" class="username" value="<?=$username;?>" />
			</div>
            
            <div>
				<input type="text" placeholder="Электронная почта" required="" id="email" name="email" class="email" value="<?=$email;?>" />
			</div>
            
            <div>
				<input type="text" placeholder="Контактный телефон" required="" id="phone" name="phone" class="phone" value="<?=$phone;?>" />
			</div>
            
            
            <div>
				<input type="password" placeholder="Пароль" required="" id="password1" name="password1"  class="password" />
			</div>
            
            
			<div>
				<input type="password" placeholder="Пароль (еще раз)" required="" id="password2" name="password2" class="password"  />
			</div>
            
			<div>
            	<input type="submit" id="submit" value="Зарегистрироваться" style="width:330px" onClick="return validate()"  />
				
			</div>
		</form><!-- form -->
		
	</section><!-- content -->
</div><!-- container -->
        
</div>
<div style="text-align:center"><a href="index.php" style="text-decoration:underline; ">На главную</a></div>
<?php
include_once 'footer_login.php';
?>