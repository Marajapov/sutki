<?php

#** get request from GET or POST or give them default value*****************************
  function get_request($name,$defaultvalue = '')
{
    if(isset($_POST[$name])){
        return $_POST[$name];
        }
    else if(isset($_GET[$name])){
        return $_GET[$name];
        }else{
        return $defaultvalue;
        }
}
#** get extension *******************************************************************************
    function getExtension($str)
    {
        $i = strrpos($str, ".");
        if (!$i) return "";
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }      
    
# Redirect browser using the header function
function redirect($location, $type="header") {
    if ($type == "header") {
        header("Location: ".$location);
    } else {
        echo "<script type='text/javascript'>document.location.href='".$location."'</script>\n";
    }
}


#**Delete files picture or ??*****************************************************************************************************
function deleteFile($file_path)
    {
    if ($file_path!= "")
        {
        if (file_exists($file_path)) unlink($file_path);
        }
        
    }


function checkSubFiles($table="",$where="",$r1=""){
    global $db;
    $name="";
                    $row = $db->select($table,$where);
                    if($row[0][$r1]>0){
                       $name=1;
                    }else{
                        $name=0;
                    }
                   
      return $name;
}

function countSubFiles($table="",$where="",$r1=""){
     global $db;
     $count=0;
     $count = $db->select_count($table,$where);
      return $count;
}


#** Redirect browser with custom message*************************************************************************
function GotoURLMsg($url,$seconds,$msg){
     global $lang;
    $strOut=$strOut."<div align='center'><meta http-equiv=\"Refresh\" content='".$seconds."; URL=".$url."'>";
    $strOut=$strOut."<br>";
    $strOut=$strOut.$msg;
    $strOut=$strOut."<br><a href='".$url."'>if not redirect auto  click here</a>";
    $strOut=$strOut."<br></div>";
    return $strOut;
}

?>
