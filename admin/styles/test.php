<p class="star">Расписание </p>
Строка : &minus; <input id="rows" value="4" maxLength="4" size="10" name="rows" class="textbox" onFocus="clear_field(this)"/>
Столбец : | <input id="cols" value="4" maxLength="4" size="10" name="cols" class="textbox" onFocus="clear_field(this)"/>

<input type="button" value="Построить" onclick="GenTable();" />

<span id="newtable" style="display:none;">
<input id="output" name="output" class="textbox" size="100" />
</span>
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
	table += '<table style="margin-left:225px;">\n';

	for (i = 1; i <= rows; i++) {
		table += "<tr>\n";
		for (t = 1; t <= cols; t++) {
			table += "<td style='border:none; padding:0;'>";
			table += "<input name='gencol_"+i+"_"+t+"'>";
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



//////////////////////////////////////////

 <?  $rw_flat = $db->select_one("tables", "flat_id='" . $flat_id . "'", "*", "", "");
						$tableid = $rw_flat['table_id'];
					$cr = 1; ?>
                    
                    <table style="margin-left:235px;">
                    	<tr>
                        <? $cells = $db->select("cells","table_id='".$tableid."'", "*", "", ""); 
							foreach($cells as $cell){
								if($cr < $cell['row']){
									echo "</tr> <tr>";	
									$cr = $cell['row'];
								}
									echo "<td style='border:none;'>
											<input name='table_value".$cell['id']."' value='".$cell['value']."' />
										   </td>";
									
							}
						?>
                        	
                        </tr>
                    </table>