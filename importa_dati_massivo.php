<?php

	
		include ("Template/head.php");
		include ("Template/chiudi_head.php");
		return_title("Venduto Gruppo - Strumenti di importazione dati - USA");
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
                        <h2>Popolamento DB - Importazione dati da file excel </h2>
                        <span class="breadcrumb"><a href="#">Home</a> &raquo; <a href="#">Dashboard</a> </span>
                </div>
                <div id="content">
					<div id="content-container">
						<div class="box"> <!-- primo box-->
							<h3>Importa file excel prodotti LED</h3>
								<div class="inside">
										
									<p><strong> Leggenda - memo</strong><br/>
									Prima di importare i file excel seguire le seguenti indicazioni:<br/>
									1. il formato del file deve essere di tipo .xls ovvero file excel versione 97-2003. I dati contenuti devono essere di tipo testo <br/>
									2. il nome del file deve essere <strong>ELENCO_MOTORI_LED_LINEARI.xls </strong>e le schede devono apparire nel seguente modo:
										<ul>
											<li> "anagrafica_barra_led" ==> scheda con i dati anagrafci delle barre led </li>
											<li> "tipo_luce" ==> scheda con i tipi di temperatura e colore luce </li>
											<li> "motore_led" ==> scheda con i nomi dei motori led disponibili </li>
											<li> "prodotti_lineari" ==> elenco dei prodotti venduti a catalogo </li>
											<li> "accessori" ==> scheda con tutti i possibili accessori presenti nei prodotti lineari </li>
											<li> "prodotto_lineare_motore_led" ==> scheda con l'associazione prodotto lineare motore led </li>
											<li> "prodotto_lineare_accessori" ==> scheda con l'associazione prodotto lineare ed accessori possibili</li>
											<li> "esclusioni" ==> scheda con l'associazione prodotto lineare e barre led non applicabili</li>
											<li> "ingombro_new" ==> scheda con l'associazione prodotto lineare, barre led, accessorio e relativo ingombro tecnico</li>
										</ul>
									<br>
									3. rispettare l'ordine delle colonne cos&igrave; come rispecchiato in mysql;<Br/>
									
									<br/><br/>
									<script type="text/javascript" src="js/upload.js"></script><br/>
									<div id="ifrm"></div>
									<form id="uploadform" action="controller/uploader.php" method="post" enctype="multipart/form-data" target="uploadframe" onsubmit="uploading(this.form); return false">
										<input type="file" class="file_up" name="file_up[]" multiple="multiple"/>
										<input type="submit" value="UPLOAD" id="sub" />
									</form>
									
									<!--<button onclick="add_upload('uploadform'); return false;">New upload box</button>-->

								</div>	
                        </div> <!--chiude il primo box: serve per fare la linea si stile di divisione-->
                        <div class="box"> <!-- secondo box: per la prima tabella e sua visualizzazione-->
							<h3>Elabora dati</h3>
								<div class="inside">
									<form id="aForm2">
										<label><strong>Selezionare dati da importare in myslq </strong></label>
										<select  name="opzioni">
											<option>Tipo luce</option>
											<option>Motori led</option>
											<option>Accessori</option>
											<option>Prodotti lineari</option>
											<option>Anagrafica barre led</option>
											<option>Prodotti - motori led</option>
											<option>Prodotti - accessori</option>
											<option>Esclusioni barre led su prodotti</option>
											<option>Ingombri</option>
											<option>Clienti</option>
											<option>Distinta base</option>
											<option>Regole molle</option>
											<option>Regole accessori</option>
											<option>Regole cavo connessione</option>
											<option>Regole fogli istruzioni</option>
											<option>Regole imballi</option>
											
										</select>
										<input type="button" name="Send" value="Send" onclick="javascript: formget(this.form, 'controller/importa_dati_prodotti_lineari.php','output');">
										<!--<input type="reset" value="Clear Selected" name="Clear">-->
									</form>
									
									<br />****** SERVER RESPONSE ******<br /><br />
									<div id="output" style="color: blue;"> </div>
								</div>
                        </div> <!--chiude il secondo box: serve per fare la linea si stile di divisione-->
					</div><!-- /content container-->
				</div> <!-- /content -->
			
			</div>  <!-- /main -->
		</div> <!-- /wrapper -->
	</body>
</html>


	
	
	
	
	
	
	
	