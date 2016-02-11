<?php
	include_once '../config.php';
	session_start();
	if (isset($_POST['author'])&&isset($_POST["captcha"])&&$_POST["captcha"]!=""&&$_SESSION["code"]==$_POST["captcha"]){
		
		echo "ss";
		$author = getpost('author');
		
		$flat_id = (int)getpost('flat');
		echo "dd2";
		$review = getpost('review');
		echo "dd1";
		$comment = getpost('comment');
		echo "ss4";
		$flat = $db->select_one("flats", "flat_id='".$flat_id."'");
		echo "ss3";
		if (!$flat) redirect('index.php?r=obj',js);
		$user = $flat['user_id'];
		echo "ss2";
		$insert = array(
				"user_id" => $user,
				"flat_id" => $flat_id,
				"name" => $author,
				"description" => $comment,
				"review" => $review
      );
	  if ($db->insert("comments", $insert)) {
		redirect('detail.php?r=cmnt&id='.$flat_id,"js");
		}
	  else redirect('detail.php?r=ncmnt&id='.$flat_id,"js");
	}else
    {
        die("Wrong Code Entered");
    }
?>