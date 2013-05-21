function getValue(elementname) {
	returnvalue = window.document.getElementById(elementname).value;
	//alert('value: '+returnvalue);
	return returnvalue;
}

function resetValues() {
	var typeOption = new Option('Please select', '', false, false);
	var modelOption = new Option('Please select', '', false, false);
	window.document.getElementById('printertype').options.length = 0;
	window.document.getElementById('printertype').options.add(typeOption);
	window.document.getElementById('printertype').disabled = true;		
	window.document.getElementById('printermodel').options.length = 0;
	window.document.getElementById('printermodel').options.add(modelOption);
	window.document.getElementById('printermodel').disabled = true;

}

function populateComp(xmlindata) {
	var xmldata = xmlindata.getElementsByTagName('Company');
	if(xmldata.length <= 0) { // check for data
		alert("Data Unavailable");
		return;
	}	
	for(var i = 0; i < xmldata.length; i++) {
		var manid = '';
		var manname = '';
		var x, y;
		x = xmlindata.getElementsByTagName('id')[i]; // get manufacturer id
		y = x.childNodes[0];
		manid = y.nodeValue;
		x = xmlindata.getElementsByTagName('name')[i]; // get manufacturer name
		y = x.childNodes[0];
		manname = y.nodeValue;
		var newOption = new Option(manname, manid, false, false);
		window.document.getElementById('manufacturer').options.add(newOption);
	}
}

function populateType(xmlindata) {
	var xmldata = xmlindata.getElementsByTagName('Printertype');
	if(xmldata.length <= 0) {
	alert("Data Unavailable");
		return;
	}
	window.document.getElementById('printertype').options.length = 0;
	var firstOption = new Option('Please select', '', false, false);
	window.document.getElementById('printertype').options.add(firstOption);
	for(var i = 0; i < xmldata.length; i++) {
		var typeid = '';
		var typename = '';
		var x, y;
		x = xmlindata.getElementsByTagName('id')[i]; // get type id
		y = x.childNodes[0];
		typeid = y.nodeValue;
		x = xmlindata.getElementsByTagName('name')[i];
		y = x.childNodes[0];
		typename = y.nodeValue;
		var newOption = new Option(typename, typeid, false, false);
		window.document.getElementById('printertype').options.add(newOption);
	}
	window.document.getElementById('printertype').disabled = false;
}

function populateModel(xmlindata) {
	var xmldata = xmlindata.getElementsByTagName('Printermodel');
	if(xmldata.length <= 0) {
		alert("Data Unavailable");
		return;
	}
	window.document.getElementById('printermodel').options.length = 0;
	var firstOption = new Option('Please select', '', false, false);
	window.document.getElementById('printermodel').options.add(firstOption);
	for(var i = 0; i < xmldata.length; i++) {
		var typeid = '';
		var typename = '';
		var x, y;
		x = xmlindata.getElementsByTagName('id')[i]; // get type id
		y = x.childNodes[0];
		typeid = y.nodeValue;
		x = xmlindata.getElementsByTagName('name')[i];
		y = x.childNodes[0];
		typename = y.nodeValue;
		var newOption = new Option(typename, typeid, false, false);
		window.document.getElementById('printermodel').options.add(newOption);
	}
	window.document.getElementById('printermodel').disabled = false;
}
