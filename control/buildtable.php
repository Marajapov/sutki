<script>
is_called = false;
function GenTable() {
	/*ntable = newTable();
	if (!(is_called)){
		document.getElementById('newtable').innerHTML = ntable;
		is_called = true;
	}
	else {
		oldvalue = document.getElementById('newtable').innerHTML;
		document.getElementById('newtable').innerHTML = ntable;
		alert (oldvalue);
	}*/
	document.getElementById('new_table').innerHTML += newTable ();

}
function newTable (){	
	var tb = document.getElementById("new_table");
	if (tb.style.display=="none") tb.style.display= "block";

	var cols = document.getElementById('cols').value;
	var rows = document.getElementById('rows').value;

	var table = '';
	
	table += "<table id='table_style' border='1' style='width:520px; margin-left:235px;'>";
	for (i = 1; i <= rows; i++) {
		table += "<tr>\n";
		for (t = 1; t <= cols; t++) {
			table += "<td style=' width:220px; border:1px solid #9C9C9C'>&nbsp;</td>\n";
		}
		table += "</tr>\n";
	}
	table += "</table>";
	return table;
}

function copytablevalues (){	
	document.getElementById("newtablehidden").value = document.getElementById("new_table").innerHTML;
}

</script>    

		<div id="myDiv">
        	<p class="star">Расписание </p>
        Строка : &minus;	<input id="rows" value="2" maxLength="4" size="10" name="rows" class="textbox" />
        Столбец : | 		<input id="cols" value="2" maxLength="4" size="10" name="cols" class="textbox" />
        					
                            <input type="button" value="Построить" onclick="GenTable();" />
<!--        <input type="hidden" name="hid" value="<? //=$flat_id; ?>"> -->
        	
            	<div id="new_table" style="display:none;" contenteditable="true">
          	
        		</div>
                <input type="hidden" name="newtablehidden" id="newtablehidden" />
  			
        </div> <!-- end of editable -->   