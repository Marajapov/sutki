<?php
include_once 'operatorcontrol.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$title;?></title>
<link href="styles/main.css" rel="stylesheet" type="text/css" />
<?php if($_SERVER['SCRIPT_NAME']=="/control/changepassword.php" || $_SERVER['SCRIPT_NAME']=="/control/profile.php"){ ?>
<link href="styles/login.css" rel="stylesheet" type="text/css" />
<?php } ?> 
</head>
<body>
<?php include 'subheader.php';?>