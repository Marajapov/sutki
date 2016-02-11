<?php
include_once 'usercontrol.php';

error_reporting(E_ALL & ~(E_STRICT|E_NOTICE)); 
ini_set('display_errors', '1');

$title = "КВАРТИРА";
$active = "1";

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
   Main();
    break;
}

//*******************************************************
function Main(){
	include_once 'header_login.php';
?><br />
<br />
<?php if (isset($_GET['loginerror'])) {?>
<div class="error">
			Неправильное имя пользователя и/или пароль.
		</div>
<?php }?>
<div class="container">
	<section id="content">
		<form action="?a=login" method="post" id="loginForm">
			<h1>Гостиница.KG</h1>
            

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
<div style="text-align:center"><a href="index.php" style="text-decoration:underline; ">На главную</a></div>
<?php
include_once 'footer_login.php';

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
                redirect("index.php","header");
	}
}

//********************************************************
function Login(){
	global $session;
    
        try {

			$username = $_POST['username'];
			$password = $_POST['password'];
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