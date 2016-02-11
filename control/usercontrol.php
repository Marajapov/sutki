<?
	require '../config.php';
	if (!($session->verifyAccess())){redirect("login.php","js");  }
?>