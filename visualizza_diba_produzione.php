<?php
			include("include/dbconfig.inc.php");
			include ("Template/head.php");
			echo "<script type=\"text/javascript\" language=\"javascript\">
				function init() {
					doAjax('controller/enumerate_ordini.php', '', 'populateOrdiniClienti', 'post', '1');
				}
				</script>
				<style>
					#loading{
						background: url('../images/loader64.gif') no-repeat;
						height:20px;
					}
				</style>";
			include ("Template/chiudi_head.php");
			return_title("Configuratore prodotti lineari - Visualizza DIBA Tecnica");
			//http://buffernow.com/2012/08/cascading-dropdown-ajax/
	?>
	
	<body onLoad="init();" >

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
                        <h2 id="titolo-pagina">Distinta base tecnica/produzione</h2>
                        <span class="breadcrumb" id="percorso"><a href="#">Home</a> &raquo; <a href="#">Dashboard</a> </span>
                </div>
                <div id="content">
					<div id="content-container">
                        <div class="box" id="elenco-ordini"> <!-- primo box: per la prima tabella e sua visualizzazione-->
							<h3>Parametri di selezione DiBa</h3>					
								<div class="inside">
										<form id="aForm2">
												&nbsp;<label>
													Seleziona il tipo di diba da visualizzare<br/>
														<input type="radio" name="tipo_view" value="produzione" checked>Diba Produzione <br/>
														<input type="radio" name="tipo_view" value="tecnica" >Diba Tecnica <br/>
												</label>&nbsp;
												<strong>Ordine cliente</strong>&nbsp;
													<select name="ordine_cliente" id="ordine_cliente" onChange="doAjax('controller/type_riga_ordine.php', 'man='+getValue('ordine_cliente'), 'populateRigaOrdine', 'post', '1')" tabindex="10">
														<option value="">Please select:</option>
													</select>&nbsp;
												<strong>Riga ordine cliente </strong>&nbsp;
												<select name="riga_ordine_cliente" id="riga_ordine_cliente"   tabindex="20" >
													<option value="">Please select:</option>
												</select>&nbsp;		
											<input type="button" name="Send" value="Visualizza" onclick="javascript: formget(this.form, 'controller/enumerate_diba_produzione.php','result');">
										</form>
									<div id="loading" style="display:none;"></div>	
									<div id="output"> </div>
								</div>
						</div> <!--chiude il primo box: serve per fare la linea si stile di divisione-->
						
						
						 <div class="box"> <!-- secondo box: per la prima tabella e sua visualizzazione-->
							<h3>DISTINTA BASE</h3>					
								<div class="inside" >
									<div id='result'></div>
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
	