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
    case "del":
        $isWhat = "del";
        $form_action = "?a=add";
        break;
    default:
        $isWhat = "";
        $form_action = "?a=add";
        break;
        break;
}
$status = 0;

// DELETE************************************************************************************************************************
if ($isWhat == "del") {
    $photo_id = $_GET['id'];
    $estate_id = get_request('cid');
    $rw = $db->select_one(DB_PREFIX . "photos", "photo_id=" . $photo_id, "*");
    if ($rw["image_url"] != "") {
        deleteFile("../media/thumb/" . $rw["image_url"]);
        deleteFile("../media/open/" . $rw["image_url"]);
    }
    $db->delete(DB_PREFIX . "photos", "photo_id = " . $photo_id);
    //redirect("flats.php", "js");
    redirect("estates.php#".$estate_id, "js");
}

// ADD NEW INSERT*****************************************************************************************************************
if ($isWhat == "add") {
    $error = "";
    $estate_id = get_request('id');
    if ($error == "") {
        for ($i = 1; $i < 6; $i++) {
            $strPic = $_FILES['photo' . $i];
            if (isset($strPic)) {
                $handle = new Upload($strPic);
                if ($handle->uploaded) {
                    $time = time();
                    $handle->image_resize = true;
                    $handle->image_ratio_y = true;
                    $handle->image_x = 800;
                    $handle->file_new_name_body = $time;
                    $handle->image_watermark = '../media/logo.png';
                    $handle->image_watermark_x = 240;
                    $handle->image_watermark_y = 150;
                    $handle->image_watermark_no_zoom_in = true;
                    $handle->Process('../media/big/');
                    if ($handle->processed) {
                        $photo_url = $handle->file_dst_name;
                    } else {
                        $error .= $handle->error . '';
                    }

                    $handle->image_resize = true;
                    $handle->image_x = 110;
                    $handle->image_y = 80;
                    $handle->file_new_name_body = $time;                  
                    $handle->Process('../media/thumb/');
                    if ($handle->processed) {
                        $photo_url = $handle->file_dst_name;
                    } else {
                        $error.=$handle->error . '';
                    }

                    $insert = array(
                        "estate_id" => $estate_id,
                        "image_url" => $photo_url
                    );
                    $db->insert(DB_PREFIX . "photos", $insert);
                }
            }
        }
        redirect("estates.php#".$estate_id, "js");
    }
}


if ($error != "")
    echo '<div class="msgerror">' . $error . '</div>';
?>


<input type="hidden" id="hdID">
<?php

require_once 'footer.php';
?>