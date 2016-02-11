<?
if ($flat_id > 0) {
            for ($i = 1; $i < 11; $i++) {
                $strPic = $_FILES['photo' . $i];
				
				$current_image=$_FILES['photo' . $i]['name'];
				$extension = substr(strrchr($current_image, '.'), 1);
				if (($extension!= "jpg") && ($extension != "jpeg") && ($extension != "gif") && ($extension != "png") && ($extension != "bmp")) continue;
				if ($_FILES['photo' . $i]["size"] > 500*1024) continue;
				
                if (isset($strPic)) {
                    $handle = new Upload($strPic);
                    if ($handle->uploaded) {
                        $time = time();
                        $handle->image_resize = true;
                        $handle->image_ratio_y = true;
                        $handle->image_x = 800;
                        $handle->file_new_name_body = $time;
                        $handle->Process('../images/big/');
                        if ($handle->processed) {
                            $photo_url = $handle->file_dst_name;
                        } else {
                            continue;
                        }

                        $handle->image_resize = true;
						$handle->image_ratio_crop = true;
                        $handle->image_x = 230;
                        $handle->image_y = 170;
                        $handle->file_new_name_body = $time;
                        $handle->Process('../images/thu/');
                        if ($handle->processed) {
                            $photo_url = $handle->file_dst_name;
                        } else {
							@unlink('../images/big/'.$time);
							continue;
                        }

                        $insert = array(
                            "flat_id" => $flat_id,
                            "image_url" => $photo_url
                        );
						if ($room && $room['room_id']>0) $insert["room_id"] = $room['room_id'];
                        $db->insert(DB_PREFIX . "photos", $insert);
					}
                }
            }
}
?>