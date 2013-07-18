<?php
include("include/dbconfig.inc.php");
			include ("Template/head2.php");
			echo "
			<link rel=\"stylesheet\" type=\"text/css\" href=\"js/crud_jquery/themes/default/easyui.css\">  
          	<link rel=\"stylesheet\" type=\"text/css\" href=\"js/crud_jquery/themes/icon.css\">  
            <link rel=\"stylesheet\" type=\"text/css\" href=\"js/crud_jquery/demo/demo.css\">  
            <script type=\"text/javascript\" src=\"js/crud_jquery/jquery-1.8.0.min.js\"></script>  
            <script type=\"text/javascript\" src=\"js/crud_jquery/jquery.easyui.min.js\"></script>           
			<script type=\"text/javascript\" src=\"js/crud_jquery/plugins/datagrid/datagrid-detailview.js\"></script>
			
			<script type=\"text/javascript\" language=\"javascript\">
			function doSearch(){
				$('#dg').datagrid('load',{
					
					codice_articolo: $('#codice_articolo').val()
				});
			}
			
			
			
			function Data_into_Excel(){
			
				var rows = $('#dg').datagrid('getSelections'); 
				
				if (rows.length){
					getFile('controller/esporta_dati_selezionati_excel.php.php',getParameters($('#dg').datagrid('getSelections')));
				}else{
					alert ('No rows selected');
				}
			}

			function getParameters(parameters){
			
					var dati= new Array();
				
					for (var i=0; i<parameters.length; i++){
						dati[i]=parameters[i].codice_pf_finale + \"|\" + parameters[i].motore_led + \"|\" + parameters[i].tipo_di_touch_led + \"|\" + parameters[i].lunghezza + \"|\" + parameters[i].Temperatura_colore + \"|\" + parameters[i].tensione_alimentazione + \"|\" + parameters[i].potenza_barra_led + \"|\" + parameters[i].K_abbreviato ;
					}
					return dati;
			
			}
			
			
			function getFile(address,parameters){
				
				$.messager.progress({text:'Processing. Please wait...'});
				$.post(address,
						parameters,
							function(data){
								$.messager.progress('close');
								if(isNaN(data)==false){
									//javascript:window.location='getFile.php?p='+data;
									$('#dg').datagrid('reload'); 
								} else {
									$.messager.alert('ERROR',data);
								}
							}	
						);
			
			}
			function exportData_into_Excel_old(){
				var rows = $('#dg').datagrid('getSelections'); 
				
				if (rows.length>0){
					var dati= new Array();
				
					for (var i=0; i<rows.length; i++){
						dati[i]=rows[i].codice_pf_finale + \"|\" + rows[i].motore_led + \"|\" + rows[i].tipo_di_touch_led + \"|\" + rows[i].lunghezza + \"|\" + rows[i].Temperatura_colore + \"|\" + rows[i].tensione_alimentazione + \"|\" + rows[i].potenza_barra_led + \"|\" + rows[i].K_abbreviato ;
					}
					$.post('controller/esporta_dati_selezionati_excel.php',
							dati_riga:dati,
											function(result){  
														if (result.success){  															
															$('#dg').datagrid('reload');    // reload the user data  
															alert('Dati correttamente esportati');
															
														} else {  
															$.messager.show({   // show error message  
																			title: 'Error',  
																			msg: result.errorMsg  
																			});  
														}  
													},'json');  
				}else{
					alert('Nessuna riga selezionata');
				}
				
			}
			
			</script>
			";
			
			
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
										<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-ok" plain="true" onclick="Data_into_Excel()">Esporta  in Excel</a>  
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
	
