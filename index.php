<?php
			include ("Template/head.php");
			include("include/dbconfig.inc.php");
			echo "
					
					<script type=\"text/javascript\" language=\"javascript\">
					<script type=\"text/javascript\" src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js\"></script>
					<script type=\"text/javascript\">
		$(function() {
			if ($.browser.msie && $.browser.version.substr(0,1)<7)
			{
			$('li').has('ul').mouseover(function(){
				$(this).children('ul').css('visibility','visible');
				}).mouseout(function(){
				$(this).children('ul').css('visibility','hidden');
				})
			}

			/* Mobile */
				$('#menu-wrap').prepend('<div id=\"menu-trigger\">Menu</div>');		
				$('#menu-trigger').on('click', function(){
										$('#menu').slideToggle();
										});

			// iPad
				var isiPad = navigator.userAgent.match(/iPad/i) != null;
				if (isiPad) $('#menu ul').addClass('no-transition');      
			});          


				function init() {
					doAjax('controller/man_list.php', '', 'populateProdotti', 'post', '1');
				}
				</script>
				<style>
					#loading{
						background: url('images/loader64.gif') no-repeat;
						height:20px;
					}
				</style>";
				
			include ("Template/chiudi_head.php");
			return_title("Configuratore prodotti lineari - Pagina principale");
			//http://buffernow.com/2012/08/cascading-dropdown-ajax/
			//include("include/dbconfig.inc.php");

	?>
	
	<body onLoad="init();">
	
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
                        <h2>Configuratore prodotti lineari led</h2>
                        <span class="breadcrumb"><a href="#">Home</a> &raquo; <a href="#">Dashboard</a> </span>
                </div>
                <div id="content">
					<div id="content-container">
                        <div class="box"> <!-- primo box: per la prima tabella e sua visualizzazione-->
							<h3>Selezione parametri di configurazione</h3>					
								<div class="inside">
								<p> <strong>Attenzione:</strong> le caselle di selezione si attivano a cascata in base alla selezione precedente. 
								Le selezioni appaiono in ordine sequenziale</p>
								<form id="aForm2">
									
												&nbsp;<strong>Nome prodotto:</strong>&nbsp;
													<select name="nome_prodotto" id="nome_prodotto" onChange="resetValues();doAjax('controller/type_motore_led.php', 'man='+getValue('nome_prodotto'), 'populateMotoreLed', 'post', '1')" tabindex="10">
														<option value="">Please select:</option>
													</select>&nbsp;
												<strong>Motore led: </strong>&nbsp;
												<select name="motore_led" id="motore_led" disabled="disabled" onChange="doAjax('controller/type_temp_colore.php', 'mot='+getValue('motore_led'), 'populateTempColore', 'post', '1')" tabindex="20" >
													<option value="">Please select:</option>
												</select>&nbsp;								
												<strong>Temperatura Luce: </strong>&nbsp;
												<select name="temp_colore" id="temp_colore" disabled="disabled" onChange="doAjax('controller/type_accessorio.php', 'man='+getValue('nome_prodotto'), 'populateAccessori', 'post', '1')" tabindex="30" >
													<option value="">Please select:</option>
												</select>&nbsp;
									
												<strong>Accessorio </strong>&nbsp;
												<select name="accessorio" id="accessorio" disabled="disabled" tabindex="40" onChange="doAjax('controller/type_schermo.php', 'man='+getValue('nome_prodotto'), 'populateColoreSchermo', 'post', '1')">
													<option value="">Please select:</option>
												</select>&nbsp;									
												
												
												<strong>Colore Schermo </strong>&nbsp;
												<select name="schermo" id="schermo" disabled="disabled" tabindex="50" onChange="doAjax('controller/type_fissaggio.php', 'man='+getValue('nome_prodotto'), 'populateSistemaFissaggio', 'post', '1')">
													<option value="">Please select:</option>
												</select>&nbsp;
												
												<strong>Sistema fissaggio </strong>&nbsp;
												<select name="fissaggio" id="fissaggio" disabled="disabled" tabindex="60">
													<option value="">Please select:</option>
												</select>&nbsp;
									
												<label><strong>Lunghezza prodotto:</strong> (mm)<br />
													<input type="text" name="lung_prod" id="lung_prod" value="" size="4" tabindex="70"  />
												</label>
												<label><strong>Quantit&agrave; di vendita:</strong><br />
													<input type="text" name="quantita" id="quantita" value="" size="4" tabindex="80"  />
												</label>
												<label><strong>Codice cliente:</strong> <br />
													<input type="text" name="codice_cliente" id="codice_cliente" value="" size="7" tabindex="90"  />
												</label>
												<label><strong>Numero ordine cliente:</strong> (ad es: 4001012 == numero a 7 cifre)<br />
													<input type="text" name="ordine_cliente" id="ordine_cliente" value="" maxlength="7" size="7" tabindex="100"  />
												</label>
												<label><strong>Riga ordine cliente:</strong> (ad es: 10 si riferisce alla riga ordine 1)<br />
													<input type="text" name="riga_ordine_cliente" id="riga_ordine_cliente" value="" maxlength="3" size="3" tabindex="110"  />
												</label>
												
												<label><strong>Riferimento ordine cliente:</strong><br /><br />												
													<textarea name="riferimento_ordine_cliente" id="riferimento_ordine_cliente" type="text" cols="10"  maxlength="255" size="3" tabindex="120"></textarea>
												</label>
												
												<label><strong>Data inserimento ordine:</strong><br />
												<input type="text" name="data_ordine" id="data_ordine" value=<?php echo date("Y-m-d")?> size="10" tabindex="130"  />
											<!--	<input type="date" name="bday"> -->
												</label>
									
										<!--<input type="reset" value="Clear Selected" name="Clear">-->
									<input type="button" name="Send" value="Send" onclick="javascript: formget(this.form, 'controller/elabora_richiesta.php','output2');" tabindex="140">
								</form>
									
								<br />****** SERVER RESPONSE ******<br /><br />
								
									<div id="loading" style="display:none;"></div>	
									<div id="output"></div>
									<div id="output2" style="color: blue;"> </div>
							</div>	
						</div>
                    </div> <!--chiude il primo box: serve per fare la linea si stile di divisione-->
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
