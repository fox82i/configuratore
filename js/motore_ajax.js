		//var divid = 'output';
		var loadingmessage = 'Processing...';
			function AJAX(){
				var xmlHttp;	
				try{
					xmlHttp=new XMLHttpRequest(); // Firefox, Opera 8.0+, Safari
					return xmlHttp;
				}catch (e){
					try{
						xmlHttp=new ActiveXObject("Msxml2.XMLHTTP"); // Internet Explorer
						return xmlHttp;
					}catch (e){
						try{
							xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
							return xmlHttp;
						}catch (e){
							alert("Your browser does not support AJAX!");
							return false;
						}
					}
				} 
			}

			function formget(f, url,divid) {
				var poststr = getFormValues(f);
				postData(url, poststr,divid);
			}
 
			function postData(url, parameters,divid){
				var xmlHttp = AJAX();
				xmlHttp.onreadystatechange =  function(){
					if(xmlHttp.readyState > 0 && xmlHttp.readyState < 4){
						document.getElementById(divid).innerHTML=loadingmessage;
					}
					if (xmlHttp.readyState == 4) {
						document.getElementById(divid).innerHTML=xmlHttp.responseText;
					}

				}
				xmlHttp.open("POST", url, true);
				xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			//	xmlHttp.setRequestHeader("Content-length", parameters.length);
			//	xmlHttp.setRequestHeader("Connection", "close");
				xmlHttp.send(parameters);
			}
			
			function getFormValues(fobj){
				var str = "";
				var valueArr = null;
				var val = "";
				var cmd = "";
				for(var i = 0;i < fobj.elements.length;i++){
					switch(fobj.elements[i].type){
						case "text":
						case "hidden":
							str += fobj.elements[i].name + "=" + escape(fobj.elements[i].value) + "&";
							break;
						case "textarea":
							str += fobj.elements[i].name + "=" + escape(fobj.elements[i].value) + "&";
							break;
						case "select-one":
							str += fobj.elements[i].name + "=" + fobj.elements[i].options[fobj.elements[i].selectedIndex].value + "&";
							break;
						case "select-multiple":
							str += fobj.elements[i].name + "=" + fobj.elements[i].options[fobj.elements[i].selectedIndex].value + "&";
							break;
						case "checkbox":
							if(fobj.elements[i].checked == true){
								str += fobj.elements[i].name + "=" + fobj.elements[i].value + "&";
							}
							break;
						case "radio":
							if(fobj.elements[i].checked == true){
									str += fobj.elements[i].name + "=" + fobj.elements[i].value + "&";
							}
							break;
					}

				}
				str = str.substr(0,(str.length - 1));
				return str;
			}