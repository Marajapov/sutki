<?php
require '../config.php';
$success = 0;
if (isset($_POST["email"])){
	
	$email = $db->escape($_POST["email"]);
	$singleUser = $db->select_one("users", "user_mail='" . $email . "'", "*", " ORDER BY user_id DESC", "0,1");
	if ($singleUser["user_mail"]==$email){
		
		$newpass = generatecode();
		$update = array("user_password" => md5($newpass));
				$strMessage = "\n Ваш новый пароль : " . $newpass . "\n <br><br>\n http://www.gostinisa.kg\n";
				try{
					require_once 'class/Swift/lib/swift_required.php';
					$transporter = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
						->setUsername('gostinisa.kg@gmail.com')
						->setPassword('tilek1981');
				//$this->mailer = Swift_Mailer::newInstance($transporter);
					$mailer = Swift_Mailer::newInstance($transporter);
					$message = Swift_Message::newInstance('Ваш новый пароль')
						->setFrom(array('gostinisa.kg@gmail.com' => 'Gostinisa.kg'))
						->setTo(array($email => $singleUser["user_realname"]))
						->setBody($strMessage);
					$mailer->send($message);
					$db->update(DB_PREFIX . "users", $update, "user_mail = '" . $email."'");
					$success = 1;
					}
				catch (Exception $e){
					$success = 2;
					}
	}
	else $success = 2;	
}


function generatecode()
{
	$str = "a,b,c,d,e,f,g,h,i,k,l,m,o,n,p,q,r,s,t,u,v,w,x,y,z,0,1,2,3,4,5,6,7,8,9";
	$bir = explode(",",$str);
	$randcode = "";
	for($c=0; $c<5; $c++)
		$randcode .= $bir[rand(0,count($bir)-1)];
	return $randcode;
}
include_once 'header_free.php';
?><br />
<br />
<?php if ($success==2) {?>
<div class="error">Ошибка отправки формы. Попробуйте ещё раз.</div>
<?php }?>

<?php if ($success==1) {?>
<div class="success" style="text-align:center; width:200px">Пароль отправлен.</div>

<? } else {?>
<div class="container">
	<section id="content">
		<form action="" method="post" id="forgotpassForm">
			<h1><?=SITE_ADDR;?></h1>
            <div class="explanation">Мы сформируем новый пароль и отправим его на адрес электронной почты, указанный Вами при регистрации.</div>

			<div>
				<input type="text" placeholder="Укажите ваш электронная почта" required="" id="email" name="email" class="email" />
			</div>
            
			<div>
            	<input type="submit" style="width:350px" id="submit" value="     Восстановить     "  />
				
			</div>
		</form><!-- form -->
		<!-- small -->
	</section><!-- content -->
</div><!-- container -->
 <? } ?>       
</div>
<div style="text-align:center"><a href="index.php" style="text-decoration:underline; ">На главную</a></div>
<?php
include_once 'footer_free.php';
?>