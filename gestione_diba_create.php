<?php
	include ("Template/head2.php");
	include("include/dbconfig.inc.php");
	
	echo "
			<link rel=\"stylesheet\" type=\"text/css\" href=\"js/crud_jquery/themes/default/easyui.css\">  
          	<link rel=\"stylesheet\" type=\"text/css\" href=\"js/crud_jquery/themes/icon.css\">  
            <link rel=\"stylesheet\" type=\"text/css\" href=\"js/crud_jquery/demo/demo.css\">  
            <script type=\"text/javascript\" src=\"js/crud_jquery/jquery-1.8.0.min.js\"></script>  
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
                        <h2>Gestione Diba create</h2>
                        <span class="breadcrumb"><a href="#">Home</a> &raquo; <a href="#">Dashboard</a> </span>
                </div>
                <div id="content">
					<div id="content-container">
                        <div class="box"> <!-- primo box: per la prima tabella e sua visualizzazione-->
							<h3>Tabella riassuntiva</h3>					
								<div class="inside">
								
									<table id="dg" title="DiBa Tecnica" class="easyui-datagrid" style="width:auto;height:auto"  										
										toolbar="#toolbar" pagination="true"  
										url="controller/Gestione_diba/enumerate_diba.php" 
										singleSelect="multiple" >  
										<thead frozen="true">  
											<tr>					
												<th field="selezionato" checkbox="true"></td>
											</tr>
										</thead>
										<thead>  
											<tr>
												<th field="codice_PF_finale" width="100">Codice articolo</th>  
												<th field="descrizione_pf_breve" width="350">Descrizione breve articolo</th>  														
												<th field="ordine_cliente" width="100">Ordine cliente</th>
												<th field="riga_ordine_cliente" width="80" align="center">Riga ordine</th>
														
											</tr>  
										</thead>  
									</table>  
									<div id="toolbar">       												
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