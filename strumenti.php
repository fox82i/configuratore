<?php
		include("include/dbconfig.inc.php");
		include ("Template/head.php");
		include ("Template/chiudi_head.php");
		return_title("Configuratore prodotti lineari - Strumenti di importazione dati");
	?>
	
	<body>

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
                        <h2>Stato tabelle database</h2>
                        <span class="breadcrumb"><a href="#">Home</a> &raquo; <a href="#">Dashboard</a> </span>
                </div>
                <div id="content">
					<div id="content-container">
                        <div class="box"> <!-- primo box: per la prima tabella e sua visualizzazione-->
							<h3>Situazione dati</h3>
								<div class="inside">
									<div class="table">
										<h6>Stato attuale delle tabelle:</h6><br/>
										<?php
											
											include("utility/excel_import_utility.php");
											
										?>
										
									</div>
								</div>
                        </div> <!--chiude il primo box: serve per fare la linea si stile di divisione-->
					</div><!-- /content container-->
				</div> <!-- /content -->
			</div>  <!-- /main -->
		</div> <!-- /wrapper -->
	</body>
</html>


