<?php
require_once 'header.php';

global $action, $isWhat, $edit;
$edit = false;
$action = get_request('a');
$error = "";
switch ($action) {
    case "add":
        $isWhat = "add";
        $form_action = "?a=add";
        break;
    case "update":
        $isWhat = "update";
        $form_action = "?a=add";
        break;
     default:
        $isWhat = "";
        $form_action = "?a=add";
        break;
        break;
}




// ADD NEW INSERT*****************************************************************************************************************
if ($isWhat == "add") {
    $error = "";

    //if ($_POST['user_full_name'] == "")
    //   $error.="<b>Haber başlığı boş!</b><br>";
    // if($_POST['cbxregion']=="") $error.="<b>Region ID not selected!</b><br>";

    if ($error == "") {
        $user_name = $_POST['user_name'];
        $user_full_name = $_POST['user_full_name'];
        $user_mail = $_POST['user_mail'];
        $photo_date = time();
        $photo_sube = setSube($_POST['sube1'], $_POST['sube2']);
        $photo_lang = setLang($_POST['lang1'], $_POST['lang2']);
        $photo_status = ($_POST['status'] == "1") ? 1 : 0;
        for ($i = 1; $i < 6; $i++) {
            $strPic = $_FILES['photo' . $i];
            if (isset($strPic)) {
                $handle = new Upload($strPic);
                if ($handle->uploaded) {
                    $handle->image_resize = true;
                    $handle->image_ratio_y = true;
                    $handle->image_x = 600;
                    $handle->file_new_name_body = time();
                    
                    $handle->Process('../userfiles/galeri/'.$user_name);
                    if ($handle->processed) {
                        $photo_url = 'userfiles/galeri/'.$user_name.'/' . $handle->file_dst_name;
                    } else {
                        $error.=$handle->error . '';
                    }
                $photo_date = time();
                $insert = array(
                    "user_name" => $user_name,
                    "user_full_name" => $user_full_name,
                    "user_mail" => $user_mail,
                    "photo_url" => $photo_url,
                    "photo_date" => $photo_date,
                    "photo_lang" => $photo_lang,
                    "photo_status" => $photo_status,
                    "photo_sube" => $photo_sube
                );
                $db->insert(DB_PREFIX."users", $insert);
              }
           }
        }
        //$db->debug();
    }
}

//UPDATE*********************************************************************************************************
if ($isWhat == "update") {
    $error = "";
    $isPass=false;
    $user_id = get_request('user_id');
  
        $user_name = $_POST['user_name'];       
        $user_password1 = $_POST['user_password1'];
        $user_password2 = $_POST['user_password2'];
        
        if ($_POST['user_name'] == "") $error.="<b>Kullanıcı adı boş olamaz!</b><br>";
        if($user_password1!="" && $user_password2!=$user_password1) $error="Şifre ve şifre tekrarı farklı.<br>";
        if($user_password1!="" && $user_password2==$user_password1) $isPass=true;
     
        if ($error == "") {  
          if($isPass==true){
              $user_pass=md5($user_password1);
            $update = array(               
                    "user_password" => $user_pass                  
            );
        } 
        $int=$db->update(DB_PREFIX."users", $update, "user_id = " . $user_id);
        if($int==1){
            $error="Completed";
        }
    }   
}

if ($error != ""){
   echo '<div class="msgerror" style="color:red; font-weight:bold;">' . $error . '</div>';   
} 
         //echo $_SESSION['userid'];
        $rw = $db->select_one(DB_PREFIX."users", "user_id=".$_SESSION['userid']);
    if($rw["user_id"]>0){   
?>
<form action="?a=update" method="post"  name="addnewsform">
    <div id="addformcontainer" class="addformcontainer" style="width: 500px; display: block;">
        <div style="padding: 5px; background: #ccc; margin: 0px 0px 5px 0px"><b>UPDATE</b></div>
        <div style="padding: 5px">
            <table cellspacing="2" style="width: 880px;"> 
           <!-- <tr><td width="120">Ad Soyad:</td>
                    <td><input type="text" size="50" name="user_full_name"  value="<?php echo $rw["user_full_name"]; ?>"/></td></tr> 
                 <tr><td width="120">E-Posta:</td>
                    <td><input type="text" size="50" name="user_mail"  value="<?php echo $rw["user_mail"]; ?>"/></td></tr> -->                                  
                <tr><td width="120">Username:</td>
                    <td><input size="50" name="user_name2" disabled="disabled"  value="<?php echo $rw["user_name"];?>"/>
                    <input type="hidden" name="user_name" value="<?php echo $rw["user_name"];?>"/>
                    </td></tr>
                    
                 <tr><td width="120">Old Password:</td>
                    <td><input type="password" size="50" name="user_password"  value="admin123"/></td></tr>
               
                <tr><td width="120">New Passowrd:</td>
                    <td><input type="password" size="50" name="user_password1"/> </td></tr>
                    
                <tr><td width="120">New Passowrd:</td>
                    <td><input type="password" size="50" name="user_password2"/></td></tr>
                    
               
            </table>
            <div style="text-align: right"><input type="submit" value=" Обновить "/></div>
        </div>
    </div>
    <input type="hidden" name="user_id" value="<?php echo $_SESSION['userid'];?>">
</form>  
<?php
    }
require_once 'footer.php';
?>