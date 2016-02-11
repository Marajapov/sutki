<?php
    if(isset($GLOBALS['HTTP_RAW_POST_DATA']) == TRUE){
		if($_POST['cat_id']){
		
		$xml = PHP_EOL;
		
			$postid = $_POST['cat_id'];
			$mysql = mysql_connect('50.62.209.110:3306', 'android_user', 'abakan123');
			mysql_select_db('usena_android');
			mysql_query ( "set character_set_client='utf8'" );
			mysql_query ( "set character_set_results='utf8'" );
			mysql_query ( "set collation_connection='utf8_unicode_ci'" );
			/*
			$response = array();
			$response["products"] = array();*/
			
			$table = mysql_query("SELECT * FROM products WHERE cat_id ='".$postid."'");
			while($row = mysql_fetch_array($table)){
				/*$tmp = array();
				$tmp["product_id"] = $row["product_id"];
				$tmp["product_name"] = $row["product_name"];
				$tmp["product_price"] = $row["product_price"];
				$tmp["product_place"] = $row["product_place"];
				
				array_push($response["products"], $tmp);
				
				header('Content-Type: application/json');
				
				echo json_encode($response);*/
				echo $row['product_id'];
				echo "Name: ".$row['product_name'].$xml."Price: ".$row['product_price'].$xml."Address: ".$row['product_place'].$xml.$xml;
			}
		}else{
			echo "not posted";
		}
    }else{
        echo $HTTP_RAW_POST_DATA;
    }
?>