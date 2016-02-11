<? 
	$lang = 'ru';
?>
<? include '../mainparts/header.php';?>
<? include '../mainparts/subheader.php';?>
<?	$t = $db->select_one("ttext","text_id='1'"); echo nl2br($t['msg']);?>
<? include '../mainparts/footer.php';?>