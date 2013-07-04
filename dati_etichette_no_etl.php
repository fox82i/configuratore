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
										pagination="true"   iconCls="icon-search" toolbar="#toolbar" singleSelect="true"
										url="controller/enumerate_dati_etichetta_no_etl.php" >  
										<thead>  
											<tr>
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
	
