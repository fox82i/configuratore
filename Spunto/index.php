<html>
<head>
<title>Buffer Now | Cacaded Select Box</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<script language="JavaScript" src="myminiAJAX.js"></script>
<script language="JavaScript" src="functions.js"></script>
<script language="JavaScript">
function init() {
		doAjax('man_list.php', '', 'populateComp', 'post', '1');
		
	}
	
function showOutput(){
alert("This Is Your Model Id: "+getValue('printermodel'));
}
	</script>
	<style>
	#loading{
	background:url('loader64.gif') no-repeat;
	height: 63px;
	}
	</style>
</head>

<body onLoad="init();">
<p>
<b>Manufacturer:</b>&nbsp;<select name="manufacturer" id="manufacturer" onChange="resetValues();doAjax('type_list.php', 'man='+getValue('manufacturer'), 'populateType', 'post', '1')">
<option value="">Please select:</option></select>&nbsp;
<b>Printer type: </b>&nbsp;<select name="printertype" id="printertype" disabled="disabled" onChange="doAjax('model_list.php', 'man='+getValue('manufacturer')+'&typ='+getValue('printertype'), 'populateModel', 'post', '1')">
<option value="">Please select:</option></select>&nbsp;
<b>Printer model:</b>&nbsp;<select name="printermodel" id="printermodel" disabled="disabled" onChange="showOutput();">
<option value="">Please select:</option></select>
</p>
<div id="loading" style="display: none;"></div>
<div id="output"></div>
</body>
</html>