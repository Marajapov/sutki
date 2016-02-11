<?php
	require_once 'config.php';
	$url = $_SERVER['PHP_SELF'];
	$safearea = (($url=="/register.php") || ($url=="/forgotpassword.php"))? false:true;
	if ($url=="/login.php"){}//prostitelno
	else if ($session->verifyAccess()){ if (!$safearea) redirect("user.php","header");  }
	else { if ($safearea) {redirect("login.php","js");}  }
 
?>