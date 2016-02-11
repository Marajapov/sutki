<? 
if (isset($_POST['table_submit'])){
	$rows = $_POST['rows'];
	$cols = $_POST['cols'];
}
?>

<!DOCTYPE HTML>
<html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
      td{
         border:1px none; padding:5;border-collapse:collapse;
      }
   </style>
<script>
function GenTable() {
	var tb = document.getElementById("newtable");
	if (tb.style.display=="none") tb.style.display= "block";
	
	
	self.onerror = null

	var cols = document.getElementById('cols').value;
	var rows = document.getElementById('rows').value;

	var table = '';
	
	table += '<table>';
	for (i = 1; i <= rows; i++) {
		table += "<tr>\n";
		for (t = 1; t <= cols; t++) {
			table += "<td>";
			table += "<input name='gencol_"+i+"_"+t+"'>";
			table += "</td>\n";
		}
		
		table += "</tr>\n";
	}
	table += "</table>";
	
	document.getElementById('newtable').innerHTML += table;
}
function my_new_table(){
		alert("a");
}
</script>
</head>
	<body>    
		<div id="myDiv" contenteditable="true">
        	<p class="star">Расписание </p>
        Строка : &minus;	<input id="rows" value="2" maxLength="4" size="10" name="rows" class="textbox" />
        Столбец : | 		<input id="cols" value="2" maxLength="4" size="10" name="cols" class="textbox" />
        					
                            <input type="button" value="Построить" onclick="GenTable();" />
        <form action="" method="post" onSubmit="my_new_table()">
        <input type="hidden" name="hid" value="">
        	<span id="newtable" style="display:none;">
 <input style="float:right; margin-right:320px; width:120px;" type="submit" id="sbt" name="table_submit" value="Save"/>
        	</span>
        </form>
  		
        </div> <!-- end of editable -->   
	</body>
</html>