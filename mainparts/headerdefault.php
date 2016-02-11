<link rel="stylesheet" href="/ru/style/reset.css" type="text/css" />
    <link rel="stylesheet" href="/ru/style/style.css" type="text/css" />
	<link href="/ru/style/jquery-ui-1.10.1.custom.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="/ru/style/dropdown.css" />
    <link type="text/css" rel="stylesheet" href="/ru/style/issykkul.css" />
    
	<script src="/ru/js/jquery-1.9.1.js"></script>
	<script src="/ru/js/jquery-ui-1.10.1.custom.js"></script>
	<script type="text/javascript" src="/ru/js/dropdown.js"></script>
    <script src="/ru/js/tooltipScript.js" type="text/javascript"></script>

    <script>
  	$(function() {
    $( "#datepicker" ).datepicker({
      	showOn: "button",
      	buttonImage: "/ru/images/clend.png",
      	buttonImageOnly: true,
	  	changeMonth: true,
      	changeYear: true
    	});
  	});
  
    $(function() {
    $( "#datepickers" ).datepickers({
      	showOn: "button",
      	buttonImage: "/ru/images/clend2.png",
      	buttonImageOnly: true,
	   	changeMonth: true,
      	changeYear: true
    	});
  	});
  	</script>  

	<script type="text/javascript">
    //<![CDATA[
    function ShowHide(){
    $("#slidingDiv").animate({"height": "toggle"}, { duration: 1000 });
    }
    //]]>
    </script>
    <script type="text/javascript">
	function ShowHide1(){
	$("#popup").animate({"opacity": "toggle" }, { duration: 1000 });
	$("#mask").animate({"opacity": "toggle"}, {duration:300});
	}
	</script>