<?php
include("include/dbconfig.inc.php");
			include ("Template/head2.php");
			echo "
			<link rel=\"stylesheet\" type=\"text/css\" href=\"js/crud_jquery/themes/metro/easyui.css\">  
          	<link rel=\"stylesheet\" type=\"text/css\" href=\"js/crud_jquery/themes/icon.css\">  
            <link rel=\"stylesheet\" type=\"text/css\" href=\"js/crud_jquery/metro/easyui.css\">  
            <script type=\"text/javascript\" src=\"js/crud_jquery/jquery-1.10.1.js\"></script>  
            <script type=\"text/javascript\" src=\"js/crud_jquery/jquery.easyui.min.js\"></script>           
			<!--<script type=\"text/javascript\" src=\"js/crud_jquery/plugins/datagrid/datagrid-detailview.js\"></script>-->
			
			<script type=\"text/javascript\" language=\"javascript\">
			
			function doSearch(){
				$('#dg').datagrid('load',{
					
					codice_articolo: $('#codice_articolo').val()
				});
			}
			
			
			

			function getParameters(parameters){
					//var array_associativo=new Array(\"Codice pf finale\",\"Tipo di barra LED\",\"Tipo di touch led\",\"Lunghezza lampada\",\"Temperatura colore\",\"Tensione alimentazione\",\"Potenza barra led\",\"K abbreviato\");
					var dati= new Array();
					
					
					for (var i=0; i<parameters.length; i++){
						//dati[i]= parameters[i].codice_pf_finale + \"|\" + parameters[i].motore_led + \"|\" + parameters[i].tipo_di_touch_led + \"|\" + parameters[i].lunghezza + \"|\" + parameters[i].Temperatura_colore + \"|\" + parameters[i].tensione_alimentazione + \"|\" + parameters[i].potenza_barra_led + \"|\" + parameters[i].K_abbreviato + \"|\" ;
						 dati[i]= {
							'codice_pf':parameters[i].codice_pf_finale,
							'motore_led': parameters[i].motore_led,
							'tipo_touch': parameters[i].tipo_di_touch_led,
							'lunghezza': parameters[i].lunghezza,
							'temp_colore':parameters[i].Temperatura_colore,
							'tensione': parameters[i].tensione_alimentazione,
							'potenza': parameters[i].potenza_barra_led,
							'k': parameters[i].K_abbreviato
						}
					}
					
					return dati;
			
			}
			
			
			
			
		function php_serialize(obj){
			var string = '';

			if (typeof(obj) == 'object') {
				if (obj instanceof Array) {
					string = 'a:';
					tmpstring = '';
					count = 0;
					for (var key in obj) {
						tmpstring += php_serialize(key);
						tmpstring += php_serialize(obj[key]);
						count++;
				}
				string += count + ':{';
				string += tmpstring;
				string += '}';
			} else if (obj instanceof Object) {
				classname = obj.toString();

				if (classname == '[object Object]') {
					classname = 'StdClass';
				}

				string = 'O:' + classname.length + ':\"' + classname + '\":';
				tmpstring = '';
				count = 0;
				for (var key in obj) {
					tmpstring += php_serialize(key);
						if (obj[key]) {
							tmpstring += php_serialize(obj[key]);
						} else {
							tmpstring += php_serialize('');
						}
					count++;
				}
				string += count + ':{' + tmpstring + '}';
			
			}} else {
				switch (typeof(obj)) {
					case 'number':
						if (obj - Math.floor(obj) != 0) {
							string += 'd:' + obj + ';';
						} else {
							string += 'i:' + obj + ';';
						}
						break;
					case 'string':
						string += 's:' + obj.length + ':\"' + obj + '\";';
						break;
					case 'boolean':
						if (obj) {
							string += 'b:1;';
						} else {
							string += 'b:0;';
						}
						break;
				}
			}

			return string;
		}
			function post(URL, PARAMS) {
				var temp=document.createElement('form');
				var opt=document.createElement('textarea');
				temp.action=URL;
				temp.method='POST';
				temp.style.display='none';
				//for(var x in PARAMS) {
					//var opt=document.createElement('hiddenfield');
					//opt.name=x;
					//opt.value=PARAMS[x];
					//temp.appendChild(opt);
				//}
				opt.name='dati_excel';
				opt.value=PARAMS;
				temp.appendChild(opt);
				document.body.appendChild(temp);
				temp.submit();
				return temp;
			}

			function exportData_into_Excel(){
				var dati_excel= new Array();
				var rows = $('#dg').datagrid('getSelections'); 
				
				
				if (rows.length>0){
						
					//javascript:window.location='controller/esporta_dati_selezionati_excel.php?dati_excel='+JSON.stringify(getParameters(rows));
					//window.location con metodo POST
					//codifico l'array associativo in un JSON vettore... lato PHP devo fare la decodifica
					post('controller/esporta_dati_selezionati_excel.php',JSON.stringify(getParameters(rows)));
				}else{
					
					var rows = $('#dg').datagrid('getData'); 
					alert(JSON.stringify(rows));
					post('controller/esporta_dati_selezionati_excel.php',JSON.stringify(rows));
				}
				
			}
			</script>
			";
		#cambiare richiesta da get a post con windows.location
		#http://www.webdeveloper.com/forum/showthread.php?81472-window-location-POST-request
			
			include ("Template/chiudi_head.php");
			return_title("Configuratore prodotti lineari - Dati etichette no ETL");
			//http://buffernow.com/2012/08/cascading-dropdown-ajax/
?>

	<body >

		<div id="wrapper">
			
					
        	<?php	
				include ("Template/header.php");
				
				include 'Build_menu/function.inc.php';
				$query = $dbh->query("SELECT * FROM menu_sito;");
				$rows=$query->fetchAll();
				foreach($rows as $row){
					$menu_array[$row['id']] = array('name' => $row['name'],'parent' => $row['parent'],'link'=>$row['link']);
				}
				echo "<div id='menu_sito'>";
				generate_menu(0);
				echo "</div>";
			?>
				<div id="main">
                <div id="main-header">
                        <h2 id="titolo-pagina">Dati per etichette di produzione</h2>
                        <span class="breadcrumb" id="percorso"><a href="#">Home</a> &raquo; <a href="#">Dashboard</a> </span>
                </div>
                <div id="content">
					<div id="content-container">
					
						 <div class="box"> 
							<h3>Etichette</h3>					
												
								<div class="inside">
									<p><strong>Questi dati devono essere inserite nel database etichette. Chiedere al tecnico la localizzazione del db etichette</strong></p>
									
									<table id="dg" title="Dati etichette no ETL" class="easyui-datagrid" style="width:auto;height:auto"  										
										pagination="true"   iconCls="icon-search" toolbar="#toolbar" 
										url="controller/enumerate_dati_etichetta_no_etl.php" singleSelect="multiple"  >  
										<thead frozen="true">  
											<tr>					
												<th field="selezionato"  checkbox="true" ></td>
											</tr>
										</thead>
										<thead>  
											<tr>
												
												<th field="data_inserimento"  width="100" sortable="true" resizable="false" >Data inserimento</th>  
												<th field="nome_prodotto"  width="100" sortable="true" resizable="false" >Prodotto</th>  
												<th field="codice_pf_finale"  width="100" sortable="true" resizable="false" >Codice pf finale</th>  
												<th field="motore_led" width="110"  >Tipo di barra LED</th>
												<th field="tipo_di_touch_led" width="100" >Tipo di touch led</th>
												<th field="lunghezza" width="130"  >Lunghezza lampada</th>  	
												<th field="Temperatura_colore"  width="130">Temperatura colore</th>  
												<th field="tensione_alimentazione"  width="150" >Tensione alimentazione</th>  
												<th field="potenza_barra_led" width="120">Potenza barra led</th>  		
												<th field="K_abbreviato" width="100" >K abbreviato</th>  														
											</tr>  
										</thead>  
									</table>  
									<div id="toolbar">       																						
										<span>Codice articolo:</span>  
										<input id="codice_articolo" style="line-height:15px;border:1px solid #ccc">  
										<a href="#" class="easyui-linkbutton" plain="true" onclick="doSearch()">Search</a>  
										<br/>
										
											<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="exportData_into_Excel()">Esporta  in Excel</a>  
										
		        					</div>  
									</div>
									</div>
					
						
					</div><!-- /content container-->
				</div> <!-- /content -->
				
		<?php
				
				echo "<!-- footer -->";
				include ("Template/footer.php");
				echo "<!-- fine footer -->";
			?>
			</div>  <!-- /main -->
		</div> <!-- /wrapper -->
	</body>
</html>
	
