<?
	require '../config.php';
	if ($session->isAdmin()) {
    $userdata = $db->select_one(DB_PREFIX . "users", " user_id=" . $_SESSION['userid']);
	} else {
    $userdata = "";
    $_SESSION['auth'] = "";
    $_SESSION['name'] = "";
    $_SESSION['userid'] = "";
    session_destroy();
    redirect("login.php", "js");
}
?>