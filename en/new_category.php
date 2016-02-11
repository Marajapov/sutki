<?php

include_once 'DbConnect.php';

function createNewCategory() {
    if (isset($_POST["name"]) && $_POST["name"] != "") {
        // response array for json
        $response = array();
        $category = $_POST["name"];
        
        $db = new DbConnect();

        // mysql query
        $query = "INSERT INTO categories(name) VALUES('$category')";
        $result = mysql_query($query) or die(mysql_error());
        if ($result) {
            $response["error"] = false;
            $response["message"] = "Category created successfully!";
        } else {
            $response["error"] = true;
            $response["message"] = "Failed to create category!";
        }
    } else {
        $response["error"] = true;
        $response["message"] = "Category name is missing!";
    }
    
    // echo json response
    echo json_encode($response);
}

createNewCategory();
?>