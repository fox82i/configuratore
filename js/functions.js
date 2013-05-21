
function getValue(elementname) {
	returnvalue = window.document.getElementById(elementname).value;
	//alert('value: '+ returnvalue);
	return returnvalue;
}

function resetValues() {
	var typeOption = new Option('Please select', '', false, false);
	var modelOption = new Option('Please select', '', false, false);
	window.document.getElementById('motore_led').options.length = 0;
	window.document.getElementById('motore_led').options.add(typeOption);
	window.document.getElementById('motore_led').disabled = true;		
	window.document.getElementById('temp_colore').options.length = 0;
	window.document.getElementById('temp_colore').options.add(modelOption);
	window.document.getElementById('temp_colore').disabled = true;
	window.document.getElementById('accessorio').options.length = 0;
	window.document.getElementById('accessorio').options.add(modelOption);
	window.document.getElementById('accessorio').disabled = true;
	window.document.getElementById('schermo').options.length = 0;
	window.document.getElementById('schermo').options.add(modelOption);
	window.document.getElementById('schermo').disabled = true;

}


function populateSistemaFissaggio(xmlindata) {
	var xmldata = xmlindata.getElementsByTagName('Fissaggio');
	if(xmldata.length <= 0) {
		
		return;
	}
	for(var i = 0; i < xmldata.length; i++) {
		var typeid = '';
		var typename = '';
		var x, y;
		x = xmlindata.getElementsByTagName('id')[i];
		y = x.childNodes[0];
		typeid = y.nodeValue;
		x = xmlindata.getElementsByTagName('name')[i];
		y = x.childNodes[0];
		typename = y.nodeValue;
		var newOption = new Option(typename, typeid, false, false);
		window.document.getElementById('fissaggio').options.add(newOption);
	}
	window.document.getElementById('fissaggio').disabled = false
}


function populateColoreSchermo(xmlindata) {
	var xmldata = xmlindata.getElementsByTagName('Colore_schermo');
	if(xmldata.length <= 0) {
		alert("Data Unavailable");
		return;
	}
	for(var i = 0; i < xmldata.length; i++) {
		var typeid = '';
		var typename = '';
		var x, y;
		x = xmlindata.getElementsByTagName('id')[i];
		y = x.childNodes[0];
		typeid = y.nodeValue;
		x = xmlindata.getElementsByTagName('name')[i];
		y = x.childNodes[0];
		typename = y.nodeValue;
		var newOption = new Option(typename, typeid, false, false);
		window.document.getElementById('schermo').options.add(newOption);
	}
	window.document.getElementById('schermo').disabled = false
}

function populateProdotti(xmlindata) {
	var xmldata = xmlindata.getElementsByTagName('Prodotto');
	if(xmldata.length <= 0) { // check for data
		alert("Data Unavailable");
		return;
	}	
	for(var i = 0; i < xmldata.length; i++) {
		var manname = '';
		var manid='';
		var x, y;
		
		x = xmlindata.getElementsByTagName('name')[i]; // get product name
		y = x.childNodes[0];
		manname = y.nodeValue;
		var newOption = new Option(manname, manname,false, false); //costruzione della stringa da dare in output alla select 
		window.document.getElementById('nome_prodotto').options.add(newOption);
	}
}
function populateOrdiniClienti(xmlindata) {
	var xmldata = xmlindata.getElementsByTagName('ordine');
	if(xmldata.length <= 0) { // check for data
		alert("Data Unavailable");
		return;
	}	
	for(var i = 0; i < xmldata.length; i++) {
		var manname = '';
		var manid='';
		var x, y;
		
		x = xmlindata.getElementsByTagName('codice')[i]; // get product name
		y = x.childNodes[0];
		manname = y.nodeValue;
		var newOption = new Option(manname, manname,false, false); //costruzione della stringa da dare in output alla select 
		window.document.getElementById('ordine_cliente').options.add(newOption);
	}
}

function populateMotoreLed(xmlindata) {
	var xmldata = xmlindata.getElementsByTagName('MotoreLed');
	if(xmldata.length <= 0) {
	alert("Data Unavailable");
		return;
	}
	window.document.getElementById('motore_led').options.length = 0;
	var firstOption = new Option('Please select', '', false, false);
	window.document.getElementById('motore_led').options.add(firstOption);
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
		window.document.getElementById('motore_led').options.add(newOption);
	}
	window.document.getElementById('motore_led').disabled = false;
}

function populateTempColore(xmlindata) {
	var xmldata = xmlindata.getElementsByTagName('Colore');
	if(xmldata.length <= 0) {
		alert("Data Unavailable");
		return;
	}
	window.document.getElementById('temp_colore').options.length = 0;
	var firstOption = new Option('Please select', '', false, false);
	window.document.getElementById('temp_colore').options.add(firstOption);
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
		window.document.getElementById('temp_colore').options.add(newOption);
	}
	window.document.getElementById('temp_colore').disabled = false;
}

function populateAccessori(xmlindata) {
	var xmldata = xmlindata.getElementsByTagName('Accessorio');
	if(xmldata.length <= 0) {
		alert("Data Unavailable");
		return;
	}
	window.document.getElementById('accessorio').options.length = 0;
	var firstOption = new Option('Please select', '', false, false);
	window.document.getElementById('accessorio').options.add(firstOption);
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
		window.document.getElementById('accessorio').options.add(newOption);
	}
	window.document.getElementById('accessorio').disabled = false;
}
function populateOrdiniClienti(xmlindata) {
	var xmldata = xmlindata.getElementsByTagName('ordine');
	if(xmldata.length <= 0) { // check for data
		alert("Data Unavailable");
		return;
	}	
	for(var i = 0; i < xmldata.length; i++) {
		var manname = '';
		var manid='';
		var x, y;
		
		x = xmlindata.getElementsByTagName('codice')[i]; // get product name
		y = x.childNodes[0];
		manname = y.nodeValue;
		var newOption = new Option(manname, manname,false, false); //costruzione della stringa da dare in output alla select 
		window.document.getElementById('ordine_cliente').options.add(newOption);
	}
}
function populateRigaOrdine(xmlindata) {
	var xmldata = xmlindata.getElementsByTagName('Riga');
	if(xmldata.length <= 0) { // check for data
		alert("Data Unavailable");
		return;
	}	
	for(var i = 0; i < xmldata.length; i++) {
		var manname = '';
		var manid='';
		var x, y;
		
		x = xmlindata.getElementsByTagName('valore')[i]; // get riga ordine
		y = x.childNodes[0];
		manname = y.nodeValue;
		var newOption = new Option(manname, manname,false, false); //costruzione della stringa da dare in output alla select 
		window.document.getElementById('riga_ordine_cliente').options.add(newOption);
	}
}