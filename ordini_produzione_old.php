<?php
			include ("Template/head.php");
			include("include/dbconfig.inc.php");
			echo "	
							<link rel=\"stylesheet\" type=\"text/css\" href=\"js/crud_jquery/themes/default/easyui.css\">  
          					<link rel=\"stylesheet\" type=\"text/css\" href=\"js/crud_jquery/themes/icon.css\">  
            				<link rel=\"stylesheet\" type=\"text/css\" href=\"js/crud_jquery/demo/demo.css\">  
            				<script type=\"text/javascript\" src=\"js/crud_jquery/jquery-1.8.0.min.js\"></script>  
            				<script type=\"text/javascript\" src=\"js/crud_jquery/jquery.easyui.min.js\"></script>
            				
            				<script type=\"text/javascript\" src=\"js/crud_jquery/plugins/datagrid/datagrid-detailview.js\"></script>
               
							<script type=\"text/javascript\" language=\"javascript\">
							
							function addNewProduction(){  //multiple select
								var rows = $('#dg').datagrid('getSelections');  
								
								if (rows){  
									$.messager.confirm('Confirm','Sei sicuro di voler creare l\'ordine di produzione ?',function(r){  
									if (r){
										for (var i=0; i<rows.length; i++)	{
											
											$.post( 'controller/esegui_produzione.php',{	
														numero_ordine_cliente:rows[i].numero_ordine_cliente,
														riga_ordine_cliente:rows[i].riga_ordine_cliente
														},function(result){  
															if (result.success){  
																$('#dg').datagrid('reload');    // reload the user data  
															} else {  
																$.messager.show({   // show error message  
																				title: 'Error',  
																				msg: result.errorMsg  
																				});  
															}  
														},'json');  
							}
	                    }  
	                });  
	            }
			}
							function doSearch(){
									$('#dg').datagrid('load',{
									numero_ordine_cliente_to_find: $('#numero_ordine_cliente_to_find').val(),
									
								});
							}
							</script>
							";
							
			include ("Template/chiudi_head.php");
				
			return_title("Configuratore prodotti lineari - Lista ordini di produzione");
			//http://buffernow.com/2012/08/cascading-dropdown-ajax/
	?>
	
	<body >

		<div id="wrapper">
			
        	<?php	
				include ("Template/header.php");
				/*include ("Template/navigation.php");
					return_navigation("index.php");
				include ("Template/Sub_nav/sub_nav_home.php");
					return_sub_nav_home("index.php");
			*/
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
                        <h2 id="titolo-pagina">Lista richieste di produzione</h2>
                        <span class="breadcrumb" id="percorso"><a href="#">Home</a> &raquo; <a href="#">Dashboard</a> </span>
                </div>
                <div id="content">
					<div id="content-container">
                        <div class="box" id="elenco-ordini"> <!-- primo box: per la prima tabella e sua visualizzazione-->
							<h3>Selezione gli ordini di produzione</h3>					
								<div class="inside">
									<div class="table">
											<table id="dg" title="Ordini per prodotti configurati" class="easyui-datagrid" style="width:auto;height:auto"  
											url="controller/enumerate_production.php"	 toolbar="#toolbar"	iconCls="icon-search"									
											pagination="true" 
											 singleSelect="false" >  
										<thead frozen="true">  
											<tr>
												<th field="selezionato" checkbox="true"></td>
												<th field="numero_ordine_cliente" width="auto" sortable="true" >Ordine cliente</th>
												<th field="riga_ordine_cliente" width="auto" sortable="true" >Riga ordine</th>
										</thead>  
										<thead>  
											<tr>	
												<th field="data_inserimento" width="auto">Data ordine</th>  
												<th field="nome_prodotto" width="auto" sortable="true" >Nome prodotto</th>
												<th field="descrizione_pf" width="auto" >Descrizione prodotto</th>  
												
											</tr>  
										</thead>  
									</table>  
									<div id="toolbar">       												
										<span>Ordine cliente:</span>  
										<input id="numero_ordine_cliente_to_find" style="line-height:15px;border:1px solid #ccc">  										 
										<a href="#" class="easyui-linkbutton" plain="true" onclick="doSearch()">Search</a>  
										<br/>
										<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" plain="true" onclick="addNewProduction()">Esegui produzione</a> 
										
		        					</div>  
								</div>
							</div>
						</div> <!--chiude il primo box: serve per fare la linea si stile di divisione-->
						
						
						 <div class="box"> <!-- secondo box: per la prima tabella e sua visualizzazione-->
							<h3>DIBA ordine di produzione</h3>					
								<div class="inside" >
									<div id='output'></div>
								</div>
						</div> <!--chiude il secondo box: serve per fare la linea si stile di divisione-->
						
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