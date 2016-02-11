<?
if ($image_url['error'] <= 0) {
            $handle = new Upload($image_url);
            $newname = time();
            if ($handle->uploaded) {
                
				$handle->image_resize = true;
                $handle->image_ratio_y = true;
                $handle->image_x = 800;
                $handle->file_new_name_body = $newname;
                //$path=substr(date("d.m.Y"),3,2);
                $handle->Process('../images/big/');
                if ($handle->processed) {
                    $pic1 = $handle->file_dst_name;
                } else {
                    $error.=$handle->error . '';
                }
				
				if ($error == "") {
					$handle->image_resize = true;
					//$handle->image_ratio_y = true;
					$handle->image_x = 455;
					$handle->image_y = 276;
					$handle->file_new_name_body = $newname;
					//$path=substr(date("d.m.Y"),3,2);
					$handle->Process('../images/mainimg/');
					if ($handle->processed) {
						$pic1 = $handle->file_dst_name;
					} else {
						$error.=$handle->error . '';
					}
				}
				if ($error == "") {
					$handle->image_resize = true;
					//$handle->image_ratio_y = true;
					$handle->image_ratio_crop = true;
					$handle->image_x = 230;
					$handle->image_y = 170;
					$handle->file_new_name_body = $newname;
					//$path=substr(date("d.m.Y"),3,2);
					$handle->Process('../images/thu/');
					if ($handle->processed) {
						$pic1 = $handle->file_dst_name;
					} else {
						$error.=$handle->error . '';
					}
				}
            }	else $error="<b>Главное фото отсутствует!</b><br>";
        }	else $error="<b>Главное фото отсутствует!</b><br>";
?>