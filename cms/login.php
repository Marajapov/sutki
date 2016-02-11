<?php
require_once("../config.php");
//$session = new Session; 

error_reporting(E_ALL & ~(E_STRICT|E_NOTICE)); 
ini_set('display_errors', '1');

if($session->verifyAccess()) {
    header("location: index.php");
    
}

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
	?>
<html>
<head>
	<title>CMS</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="css/style.css" type="text/css" />

	<!--script type="text/javascript" src="js/jquery-1.4.2.js"></script-->
</head>

<body>
<div class="wrapper">
    <form action="?a=login" method="post" id="loginForm">

			<table cellspacing="0" class="login" style="background:#1A324B; width: 100%">
            <tr>
            <td height="20" colspan="2"> 
            </td>          
            </tr>
			<tr>
			<td width="100" align="right" style="padding-right: 5">
				<b><span style="color: #FFFFFF;"> Логин  : </span></b>
			</td>
			<td>
				<input type="text" id="username" style="margin: 0 0 2 0;width:150" name="username" /><br/>
			</td>
			</tr>

			<tr>
			<td align="right" style="padding-right: 5">
				<b><span style="color: #FFFFFF;"> Пароль  : </span></b> 
			</td>
			<td>
				<input type="password" id="password" style="margin: 0 0 2 0;width:150" name="password" /><br/>
			</td>
			</tr>

			<tr>
			<td>
			</td>
			<td>
				<input style="font: 10px tahoma" type="submit" id="submit" value=" Вход " /><span style="color: red"><b><?php if (isset($_GET['loginerror'])) echo ' Error!'; ?></b></span>
			</td>
			</tr>

             <tr>
            <td height="20" colspan="2"> 
            </td>          
            </tr>
            
			</table>
        </form>

<div id="content">
          		

			
<?php
require_once 'footer.php';

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

                        if(isset($_SERVER['HTTP_REFERER'])){
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
	$backURL="login.php";

	if (!isset($_GET['error'])){ $error = "";}else{$error = $_GET['error'];}
	if ($error == 1) {
		
        echo GotoURLMsg($backURL,2,"Error");
		
	} elseif ($error == 2) {
		
		echo GotoURLMsg($backURL,2,"Wrong username or password");
	} elseif ($error == 3) {
		echo GotoURLMsg($backURL,2,"Wrong username or password");
	} elseif ($error == 4) {   
		echo GotoURLMsg($backURL,2,"Username or password is empty");
	}



	//if(isset($_SERVER['HTTP_REFERER'])){
    //header("location: ".$_SERVER['HTTP_REFERER']);
    //}else{
    //header("location: index.php");
    //}
}

?>