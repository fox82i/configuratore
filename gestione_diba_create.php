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
			
			
			$(function(){
								$('#dg').datagrid({  
    								view: detailview,  
    								detailFormatter:function(index,row){  
        							return '<div style=\"padding:2px\"><table id=\"ddv-' + index + '\"></table></div>';  
    							},  
   								onExpandRow: function(index,row){  
        							$('#ddv-'+index).datagrid({  
            								url:'controller/Gestione_diba/subgrid_diba.php?codice_PF='+row.codice_PF_finale,              							
            								singleSelect:true,  
            								rownumbers:true,  
            								loadMsg:'',  	
            								height:'auto',
											
            									columns:[[  

                										{field:'posizione_diba',title:'Posizione',width:'60'},  
                										{field:'codice_componente',title:'Codice componente',width:'120'},  
                										{field:'descrizione_componente',title:'Descrizione componente',width:'300'},
                										{field:'UM',title:'UM',width:'30'},
                										{field:'qta',title:'QTA',width:'40'}

            									]],  
            									onResize:function(){  
                									$('#dg').datagrid('fixDetailRowHeight',index);  
            									},  
            									onLoadSuccess:function(){  
                									setTimeout(function(){  
                    								$('#dg').datagrid('fixDetailRowHeight',index);  
                									},0);  
            									}  
        									});  
        							$('#dg').datagrid('fixDetailRowHeight',index);  
    							}  
								});  
								});
			
			function deleteResult(){  //multiple select
				var rows = $('#dg').datagrid('getSelections');  
                if (rows){  
                $.messager.confirm('Confirm','Sei sicuro di voler eliminare questa distinta?',function(r){  
                    if (r){
						for (var i=0; i<rows.length; i++)	{
							$.post('controller/Gestione_diba/delete_diba.php',{
													codice_PF:rows[i].codice_PF_finale,
													ordine_cliente:rows[i].ordine_cliente,
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
					codice_PF: $('#codice_PF').val(),
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
                        <h2>Elimina Diba create</h2>
                        <span class="breadcrumb"><a href="#">Home</a> &raquo; <a href="#">Dashboard</a> </span>
                </div>
                <div id="content">
					<div id="content-container">
                        <div class="box"> <!-- primo box: per la prima tabella e sua visualizzazione-->
							<h3>Tabella riassuntiva</h3>					
								<div class="inside">
								
									<table id="dg" title="DiBa Tecnica" class="easyui-datagrid" style="width:auto;height:auto"  										
										toolbar="#toolbar" pagination="true"   iconCls="icon-search"
										url="controller/Gestione_diba/enumerate_diba.php" 
										singleSelect="multiple" >  
										<thead frozen="true">  
											<tr>					
												<th field="selezionato"  checkbox="true" ></td>
											</tr>
										</thead>
										<thead>  
											<tr>
												<th field="codice_PF_finale" width="100" sortable="true" resizable="false" >Codice articolo</th>  
												<th field="descrizione_pf_breve" width="350" sortable="true">Descrizione breve articolo</th>  														
												<th field="ordine_cliente" width="100" sortable="true" >Ordine cliente</th>
												<th field="riga_ordine_cliente" width="80" align="center" sortable="true">Riga ordine</th>
														
											</tr>  
										</thead>  
									</table>  
									<div id="toolbar">       												
										<span>Codice aritcolo:</span>  
										<input id="codice_PF" style="line-height:15px;border:1px solid #ccc">  
										<span>Ordine cliente:</span>  
										<input id="ordine" style="line-height:15px;border:1px solid #ccc">  
										<a href="#" class="easyui-linkbutton" plain="true" onclick="doSearch()">Search</a>  
										<br/>
										<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cut" plain="true" onclick="deleteResult()">Elimina DiBa</a>  
										
		        					</div>  
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>