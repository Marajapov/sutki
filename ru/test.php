<?php
	include('../config.php');
	include_once 'usercontrol.php';

	$userid = $_SESSION['userid'];
	echo $userid;
	header('Content-type: text/html; charset=UTF-8');

	if (isset($_POST['submit_get_info'])){
		$rows = $_POST['rows'];
		$cols = $_POST['cols'];
		
		for($i=1;$i<=$rows;$i++)for($j=1;$j<=$cols;$j++){
			$value = $_POST['gencol_'.$i.'_'.$j];
			
			$insert = array("value" => $value, "row" => $i, "col" => $j);
			$db->insert("gen_row_value", $insert);
			
		}
		
		$rwFlat = $db->select_one("flats","user_id='" . $userid . "'", "*", " ORDER BY flat_id DESC", "0,1");
			//$db->debug();
			//exit(0);
		$flat_id = $rwFlat["flat_id"];
		echo $flat_id;
	}

?>
&nbsp;&nbsp;&nbsp; Расписание
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<form action="" method="post">
Строка : &minus; <input id="rows" value="4" maxLength="4" size="10" name="rows" class="textbox" onFocus="clear_field(this)"/>
Столбец : | <input id="cols" value="4" maxLength="4" size="10" name="cols" class="textbox" onFocus="clear_field(this)"/>

<input type="button" value="Построить" onclick="GenTable();" />

<span id="newtable" style="display:none;">
<input id="output" name="output" class="textbox" size="100" />
</span>
<input type="submit" name="submit_get_info" />

</form>
<SCRIPT language=JavaScript>

function perRound(num, precision) {
        var precision = 3; //default value if not passed from caller, change if desired
        // remark if passed from caller
        precision = parseInt(precision); // make certain the decimal precision is an integer
    var result1 = num * Math.pow(10, precision);
    var result2 = Math.round(result1);
    var result3 = result2 / Math.pow(10, precision);
    return zerosPad(result3, precision);
}

function zerosPad(rndVal, decPlaces) {
    var valStrg = rndVal.toString(); // Convert the number to a string
    var decLoc = valStrg.indexOf("."); // Locate the decimal point
    // check for a decimal 

    if (decLoc == -1) {
        decPartsecnum = 0; // If no decimal, then all decimal places will be padded with 0s
        // If decPlaces is greater than zero, add a decimal point
        valStrg += decPlaces > 0 ? "." : "";
    }
    else {
        decPartsecnum = valStrg.secnumgth - decLoc - 1; // If there is a decimal already, only the needed decimal places will be padded with 0s
    }
     var totalPad = decPlaces - decPartsecnum;    // Calculate the number of decimal places that need to be padded with 0s
    if (totalPad > 0) {
        // Pad the string with 0s
        for (var cntrVal = 1; cntrVal <= totalPad; cntrVal++) 
            valStrg += "0";
        }
    return valStrg;
}
// send the value in as "num" in a variable

// clears field of default value
function clear_field(field) {
                if (field.value==field.defaultValue) {
                        field.value=''
                }
        }

function GenTable() {
	// my code
	var tb = document.getElementById("newtable");
	if (tb.style.display=="none") tb.style.display= "block";
	else tb.style.display= "none";
	self.onerror = null
	// end my code
	var cols = document.getElementById('cols').value;
	var rows = document.getElementById('rows').value;

	var table = '';
	table += '<table>\n';

	for (i = 1; i <= rows; i++) {
		table += "<tr>\n";
		for (t = 1; t <= cols; t++) {
			table += "<td>";
			table += "<input name='gencol_"+i+"_"+t+"' value='gencol_"+i+"_"+t+"'>";
			table += "</td>\n";
		}
		table += "</tr>\n";
	}

	table += "</table>";

	//document.getElementById('output').value = table;
	document.getElementById('newtable').innerHTML = table;
	
}

function ClearBox(thisform) {
thisform.output.value = '';
thisform.header.checked = false;
thisform.footer.checked = false;
thisform.cols.value = '4';
thisform.rows.value = '4';
}

// -->
</SCRIPT>