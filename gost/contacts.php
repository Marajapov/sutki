<?php
$title = "КОНТАКТЫ";
$active = "6";
include_once('header.php');

$error = "";
if (isset($_POST['hdWhat'])) {
    ($_POST["txtName"] == "" ? $error.="<br>Имя !" : $strName = $_POST["txtName"]);
    ($_POST["txtEmail"] == "" ? $error.="<br>Email !" : $strEmail = $_POST["txtEmail"]);
    ($_POST["txtDesc"] == "" ? $error.="<br>Текст сообщения !" : $strDesc = $_POST["txtDesc"]);


    If ($error == "") {



        $strMessage = "\n
Имя :- " . $strName . "\n
Email :- " . $strEmail . "\n
Текст сообщения: :- " . $strDesc . "\n";


        require_once 'class/Swift/lib/swift_required.php';
        
        $transporter = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
                ->setUsername('gostinisa.kg@gmail.com')
                ->setPassword('tilek1981');

        //$this->mailer = Swift_Mailer::newInstance($transporter);


        $mailer = Swift_Mailer::newInstance($transporter);



        $message = Swift_Message::newInstance('www.gostinisa.kg')
                ->setFrom(array('gostinisa.kg@gmail.com' => 'Gostinisa.kg'))
                ->setTo(array('gostinisa.kg@gmail.com' => 'Gostinisa.kg'))
                ->setBody($strMessage)
        ;


        $result = $mailer->send($message);

        //echo $result;





//        $mail = new EMail;
//        $mail->Username = 'info@gostinisa.kg';
//        $mail->Password = 'costinisakg';
//
//        $mail->SetFrom("info@gostinisa.kg", "Gostinisa.KG");  // Name is optional
//        $mail->AddTo("gostinisa.kg@gmail.com", "Сеть посуточной аренды"); // Name is optional
//        $mail->AddTo("diamend@gmail.com");
//        $mail->Subject = "Some subject or other";
//        $mail->Message = $strMessage;
//
//        $mail->ContentType = "text/html";          // Defaults to "text/plain; charset=iso-8859-1"
////$mail->Headers['X-SomeHeader'] = 'abcde';		// Set some extra headers if required
//        $mail->ConnectTimeout = 30;  // Socket connect timeout (sec)
//        $mail->ResponseTimeout = 8;  // CMD response timeout (sec)
//
//
//
//        $error = $success = $mail->Send();
    }
}
?>

<div id="itemsTopSpace"></div>
<div id="itemsTop"></div>
<div id="items">
    <div id="detail">
        <div id="uslugi">
            <?php
            if ($error) {
                echo '<div class="errorSummary1">' . $error . '<div class="clear"></div></div><div class="clear"></div>';
            }else if($result==1){
                echo '<div class="errorSummary1"> Ваше сообщение успешно отправлено  <div class="clear"></div></div><div class="clear"></div>';
            }
            ?>  
            <h2 class="textRedH2">НАШИ КОНТАКТЫ</h2>
            <p><strong>По вопросам аренды необходимо связываться напрямую с владельцами.</br>
                    Их контакты указаны внутри квартир.</strong></br><br/>
                С помощью этой формы Вы можете задать нам вопрос, оставить Ваши замечания, предложения</br>
                или другую информацию. Мы постараемся связаться с Вами как можно быстрее.</br>
                При необходимости Вы также можете посвонить по указанным телефонам.  
            </p>
            <div id="cont">
                <div>
                    <div class="lefter">
                        <p id="platnoe">Телефоны:</p>
                    </div>
                    <div class="righter">
                        <p class="textRed">(0550) 87 07 57</p>
                        <p class="textRed">(0556) 19 58 22</p>                       
                    </div>
                </div>
				
                <div>
                    <div class="lefter">
                        <p id="platnoe">Email:</p>
                    </div>
                    <div class="righter">
                        <p class="textRed"><a href="mailto:gostinisa.kg@gmail.com">gostinisa.kg@gmail.com</a></p>                    
                    </div>
                </div>
            </div><!--#cont-->


            <div class="clear"></div>
            <form action="<?php echo $form_action; ?>" method="post" name="contact" id="contact">
                <div class="well">
                    <p class="star">Имя <span style="color:red;">*</span></p>:
                    <div class="clear"></div>                      
                    <input type="text" id="txtName" class="fio1" name="txtName"/>
                </div><!--.well-->

                <div class="well">
                    <p class="star">Email <span style="color:red;">*</span></p>:
                    <div class="clear"></div>                       
                    <input type="text" id="txtEmail" class="email1" name="txtEmail" />
                </div><!--.well-->

                <div class="clear"></div>
                <p>Текст сообщения: <span style="color:red;">*</span></p>
                <textarea id="txtDesc" rows="6" cols="48" name="txtDesc"></textarea>
                <input type="image" id="otpravitContact" src="images/otpravitContact.png">
                <input type="hidden" name="hdWhat" id="hdWhat" value="1"/>
            </form>
        </div><!--#uslugi-->

    </div><!--#detail-->
    <div id="rightbar">
        <?php
        include_once 'inc_search.php';
        include_once 'inc_special.php';
        ?>
    </div><!--#rightbar-->
    <div class="clear"></div>
</div><!--#items-->
<?php
include_once 'footer.php';
?>