<?php
			include ("Template/head.php");
			include("include/dbconfig.inc.php");
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
									<?php
										include("include/dbconfig.inc.php");
										include ('controller/enumerate_production.php');
									?>
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