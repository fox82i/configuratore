<?php
	include ("Template/head2.php");
	include("include/dbconfig.inc.php");
	
	echo "
			<link rel=\"stylesheet\" type=\"text/css\" href=\"js/crud_jquery/themes/metro/easyui.css\">  
          	<link rel=\"stylesheet\" type=\"text/css\" href=\"js/crud_jquery/themes/icon.css\">  
            
            <script type=\"text/javascript\" src=\"js/crud_jquery/jquery-1.10.1.js\"></script>  
            <script type=\"text/javascript\" src=\"js/crud_jquery/jquery.easyui.min.js\"></script>           
			<script type=\"text/javascript\" src=\"js/crud_jquery/plugins/datagrid/datagrid-detailview.js\"></script>
            
			<script type=\"text/javascript\" language=\"javascript\">
						
			function deleteResult(){  //multiple select
				var rows = $('#dg').datagrid('getSelections');  
                if (rows){  
                $.messager.confirm('Confirm','Sei sicuro di voler eliminare?',function(r){  
                    if (r){
						for (var i=0; i<rows.length; i++)	{
							$.post('controller/Gestione_ordini_clienti/delete_ordini_cliente.php',{													
													ordine_cliente:rows[i].numero_ordine_cliente,
													riga_ordine:rows[i].riga_ordine_cliente													
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
					
					ordine: $('#ordine').val()
				});
			}
		</script>
		";
	
	include ("Template/chiudi_head.php");
	return_title("Configuratore prodotti lineari - Gestione DiBa");
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
                        <h2>Eliminazione ordine cliente</h2>
                        <span class="breadcrumb"><a href="#">Home</a> &raquo; <a href="#">Dashboard</a> </span>
                </div>
                <div id="content">
					<div id="content-container">
                        <div class="box"> <!-- primo box: per la prima tabella e sua visualizzazione-->
							
							<h3>Tabella riassuntiva</h3>					
								<div class="inside">
									<p><strong>Se non si trova l'ordine vuol dire che &egrave; stata creata la diba.<br/> Eliminare prima tutte le diba associate all'ordine e poi eliminare l'ordine</strong></p>
									<table id="dg" title="Ordini clienti" class="easyui-datagrid" style="width:auto;height:auto"  										
										toolbar="#toolbar" pagination="true"   iconCls="icon-search"
										url="controller/Gestione_ordini_clienti/enumerate_ordini_clienti.php" 
										singleSelect="multiple" >  
										<thead frozen="true">  
											<tr>					
												<th field="selezionato"  checkbox="true" ></td>
											</tr>
										</thead>
										<thead>  
											<tr>
												<th field="data_inserimento" width="100" sortable="true" resizable="false" >Data inserimento ordine</th>  
												<th field="numero_ordine_cliente" width="100" sortable="true" >Ordine cliente</th>
												<th field="riga_ordine_cliente" width="80" align="center" sortable="true">Riga ordine</th>
												<th field="codice_PF_finale" align="center" sortable="true" resizable="false" >Codice articolo</th>  
												<th field="quantita" align="center" resizable="false" >Quantita richiesta </th>  
												<th field="descrizione_pf_breve" width="350" >Descrizione breve articolo</th>  														
											</tr>  
										</thead>  
									</table>  
									<div id="toolbar">       																						
										<span>Ordine cliente:</span>  
										<input id="ordine" style="line-height:15px;border:1px solid #ccc">  
										<a href="#" class="easyui-linkbutton" plain="true" onclick="doSearch()">Search</a>  
										<br/>
										<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cut" plain="true" onclick="deleteResult()">Elimina Ordine Cliente</a>  
										
		        					</div>  
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>