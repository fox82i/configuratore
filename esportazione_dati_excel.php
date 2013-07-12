<?php
include("include/dbconfig.inc.php");
			include ("Template/head.php");
			echo "
				<style>
					#loading{
						background: url('../images/loader64.gif') no-repeat;
						height:20px;
					}
				</style>";
			
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
							<h3>Esportazione dati in file Excel</h3>					
												
								<div class="inside">
									<p><strong>Questi dati devono essere inserite nel database etichette. Chiedere al tecnico la localizzazione del db etichette</strong></p>
									<form id="aForm2" method='POST' action='controller/generate_file_excel.php'>
												&nbsp;<label>
												<strong>Nome file Excel</strong>&nbsp;
													<input type="text" name="nome_file" id="nome_file" value="" maxlength="25" size="20" tabindex="10"  />
												</label>
												<br/><br/>
												<input type="submit" value="Downolad File">
										<!--	<input type="button" name="Send" value="Visualizza" onclick="javascript: formget(this.form, 'controller/generate_file_excel.php','output');" tabindex="20">-->
										</form>
									<div id="loading" style="display:none;"></div>	
									
		        				</div>  
						</div>
						<div class="box">
							<h3>Error server</h3>	
							<div class="inside">
							
								<div id="output"></div>
							</div>
						</div>
					</div>
					
						
					
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
	
