<?php
require '../config.php';

global $action;
$action= get_request('a');
switch ($action)
{
  case "login":
    Login();
    break;
  case "logout":
    Logout();
    break;
  case "err":
    LoginErr();
    break;
  default:
   Main(SITE_ADDR);
    break;
}

//*******************************************************
function Main($addr){
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--[if lt IE 7 ]> <html lang="ru" class="ie6 ielt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="ru" class="ie7 ielt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="ru" class="ie8"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html lang="ru"> <!--<![endif]-->
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Вход в личный кабинет - <?=$addr;?></title>
        <meta name="description" content="Посуточная аренда квартир" />
        <meta name="keywords" content="квартиры, посуточно, аренда, снять на сутки">
        <link href="../styles/login.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
	function validate(){
		if (document.getElementById("password1").value != document.getElementById("password2").value) {
			alert("Пароли не совпадают");
			return false;	
		}
		return true;	
	}
</script>
    </head>
    <body>
        <div id="dvFullSite">
            <div class="clear"></div>
            <!--#header-->
<?php if (isset($_GET['loginerror'])) {?>
<div class="error">
			Неправильное имя пользователя и/или пароль.
		</div>
<?php }?>
<div class="container">
	<section id="content">
		<form action="?a=login" method="post" id="loginForm">
			<h1><?=$addr;?></h1>
            

			<div>
				<input type="text" placeholder="Логин" required="" id="username" name="username" class="username" />
			</div>
            
            
            
			<div>
				<input type="password" placeholder="Пароль" required="" id="password" name="password" class="password" />
			</div>
            
            
            
            
			<div>
            	<input type="submit" id="submit" value="Войти &raquo;" />
				<a href="forgotpassword.php">Забыли пароль?</a>
				<a href="register.php">Регистрация</a>
			</div>
		</form><!-- form -->
		<div class="explanation">
			Если Вы еще не зарегистрированы на нашем сайте, пройдите несложную регистрацию (30 секунд) для бесплатного размещения информации о вашей квартире или отеле.
		</div><!-- small -->
	</section><!-- content -->
</div><!-- container -->
        
</div>
<div style="text-align:center"><a href="../index.php" style="text-decoration:underline; ">На главную</a></div>
<?php


}

//*********************************************************

function Logout()
{
	$_SESSION['auth'] = "";
	$_SESSION['name'] = "";
	session_destroy();

	if(isset($_SERVER['HTTP_REFERER']))
	{
		//header("location: ".$_SERVER['HTTP_REFERER']);
                redirect($_SERVER['HTTP_REFERER'],"header");
	}
	else
	{
		//header("location: index.php");
                redirect("login.php","header");
	}
}

//********************************************************
function Login(){
	global $session;
    
        try {

			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			
			/* Verify the login details are correct and redirect to secure.php */
			$session->isLogin($username, $password);

                        if($session->verifyAccess()){
						
						$pos = strpos($_SERVER['HTTP_REFERER'], "login.php");
                        if(isset($_SERVER['HTTP_REFERER']) && ($pos === false)){
                           //header("location: ".$_SERVER['HTTP_REFERER']);
                            redirect($_SERVER['HTTP_REFERER'],"header");
                          // GotoURLMsg($_SERVER['HTTP_REFERER'], 1, "");
                           }else{
                           //header("location: index.php");
                          redirect("index.php","header");
                          }
                        }
                 

	}
	catch(Exception $error) {
		print $error->getMessage();
	}


}
//*******************************************
function LoginErr() {
	global $userdata;

	//if(iMEMBER) goBack("index.php");
	//$backURL=$_SERVER['HTTP_REFERER'];
	$backURL="login.php?loginerror=1";

	if (!isset($_GET['error'])){ $error = "";}else{$error = $_GET['error'];}
	if ($error == 1) {
		
        echo GotoURLMsg($backURL,2,"Error");
		
	} elseif ($error == 2) {
		
		echo GotoURLMsg($backURL,2,"Неправильное имя пользователя и/или пароль.");
	} elseif ($error == 3) {
		echo GotoURLMsg($backURL,2,"Неправильное имя пользователя и/или пароль.");
	} elseif ($error == 4) {   
		echo GotoURLMsg($backURL,2,"Неправильное имя пользователя и/или пароль.");
	}



	//if(isset($_SERVER['HTTP_REFERER'])){
    //header("location: ".$_SERVER['HTTP_REFERER']);
    //}else{
    //header("location: index.php");
    //}
}
?>