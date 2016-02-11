<?php
include_once 'header.php';
$error = "";
$id = 0;
if (isset($_REQUEST['id'])){
	$id = (int)$_REQUEST['id'];
}
if ($id==0) redirect("index.php?action=noflat", "js");

$tmpflashname = (isset($_POST["oldflash"]))?$_POST["oldflash"]:"";
$flashname = "";

if (isset($_POST['id'])){
	
	if(isset($_FILES['flash_tour'])){
		$flashname = $id."_".generatecode()."_".$_FILES["flash_tour"]["name"];
		$targetPathFolder = $_SERVER['DOCUMENT_ROOT'].'/flashtour/'.$flashname;		
		if(move_uploaded_file($_FILES['flash_tour']['tmp_name'],$targetPathFolder)){
			$update = array("flashtour" => $flashname);
			if ($db->update(DB_PREFIX . "flats", $update, "flat_id = " . $id))
				{if ($tmpflashname!="")	@unlink('../flashtour/'.$tmpflashname);}
			else $error = "Ошибка: база данных";
		}
		else $error ="Ошибка: файл загрузка";
	}
	else $error ="Ошибка: файл загрузка -> flashtour";
}

$flat = $db->select_one("flats","flat_id='".$id."'");
if (!$flat) redirect("index.php?action=noflat", "js");
$title = $flat['name_ru'];

?>


<div class="main_border">   

			<h2 class="maintitle"><?=$id;?>. <?=$title;?></h2>
            <div class="clear"></div>
            <?php if ($error) {?>
            
            <div class="error">Обнаружены ошибки</div><div class="clear"></div>
               <div class="panelError">     
                    <div class="well">
						<?=$error;?>                    
                  </div>
                </div>
            <div class="clear"></div>
            <? } else if (isset($_POST['id'])) {?>

               <div class="success">     
                    <div class="well">
                    
Данные успешно сохранены
						               
                  </div>
                </div>
            <div class="clear"></div>
            
			<? } ?>
                <form action="object.php" method="post" enctype="multipart/form-data" name="addnew" id="addnew">
                    <input type="hidden" name="id" value="<?=$id;?>"/>

                    <p class="textRed">Онлайн 3D Тур (720-477)</p>
                    <? if ($flat['flashtour']=="") {?>
                        <div class="well">Отсутствует онлайн тура</div><div class="clear"></div>
						<? }else {?>
                    <div class="well"><embed src="../flashtour/<?=$flat['flashtour'];?>" width="720px" height="477px" /><br/></div><div class="clear"></div>
                    <?  }?>
                    <div class="well">
                                      
                        <input type="file" class="longtitude" name="flash_tour" id="flash_tour"> 
                        <? if ($flat['flashtour']!="") {?><input type="hidden" name="oldflash" value="<?=$flat['flashtour'];?>"/><? } ?>
                    </div><!--.well--> 
                    <div class="clear"></div>
                    
                    <hr/>
                    <input type="image" id="dobavitkv" src="../images/sitetools/send.png">              
</form>

</div><!--end main_border-->

<?php
include_once 'footer.php';
function generatecode()
{
	$str = "a,b,c,d,e,f,g,h,i,k,l,m,o,n,p,q,r,s,t,u,v,w,x,y,z,0,1,2,3,4,5,6,7,8,9";
	$bir = explode(",",$str);
	$randcode = "";
	for($c=0; $c<8; $c++)
		$randcode .= $bir[rand(0,count($bir)-1)];
	return $randcode;
}
?>