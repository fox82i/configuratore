<?php

	include("../include/dbconfig.inc.php");


	$nome_prodotto=$_POST['nome_prodotto'];
	$motore_led=$_POST['motore_led'];
	$temperatura_colore=$_POST['temp_colore'];
	$accessorio=$_POST['accessorio'];
	if (isset($_POST['schermo'])){
		$colore_schermo=$_POST['schermo'];
	}
	if (isset($_POST['fissaggio'])){
		$sistema_fissaggio=$_POST['fissaggio'];
	}
	$lunghezza=(int)trim($_POST['lung_prod']);
	$quantita=(int)trim($_POST['quantita']);
	$codice_cliente=trim($_POST['codice_cliente']);
	$ordine_cliente=trim($_POST['ordine_cliente']);
	$riga_ordine_cliente=(int)trim($_POST['riga_ordine_cliente']);
	$data_ordine=$_POST['data_ordine'];
	
	$sql=$dbh->query("SELECT * FROM richieste_ordini_produzione WHERE numero_ordine_cliente='".$ordine_cliente."' and riga_ordine_cliente='".$riga_ordine_cliente."';");
	$sql->execute();
	$ordine=$sql->fetchAll();
	
	if (count($ordine)>0){ //controllo se esiste già un ordine con riga a sistema
		echo "<p><strong>Ordine ".$ordine_cliente." con riga ".$riga_ordine_cliente." gi&agrave; inserito a sistema!</strong></p>";
		echo "<p> I dati dell'ordine presente a sistema sono :<br/>
			data inserimento: ".$ordine[0]['data_inserimento']."<br/>
			prodotto richiesto: ".$ordine[0]['nome_prodotto']."<br/>
			lunghezza richiesta: ".$ordine[0]['lunghezza']."<br/><br/>
			
			<strong style=\"color: red;\">I dati non sono stati salvati</strong>
			</p>";
	}else{
	
	
	$sql=$dbh->query("SELECT nome_prodotto,lunghezza_minima_accettata,lunghezza_massima_accettata FROM prodotti_lineari WHERE nome_prodotto='".$nome_prodotto."' GROUP BY codice_articolo;");
	$sql->execute();
	$res=$sql->fetchAll();
	$sql="";

	
	if ($lunghezza >= $res['0']['lunghezza_minima_accettata'] and $lunghezza<=$res['0']['lunghezza_massima_accettata']){
	
	
		/*CONTROLLO SE LA RICHIESTA E' GIA' STATA FATTA PER QUEL CLIENTE*/
		
		$richiesta_effettuata= "SELECT * FROM storico_richieste WHERE nome_prodotto='".$nome_prodotto."' and 
																	motore_led='".$motore_led."' and
																	id_tipo_luce='".$temperatura_colore."' and
																	id_accessorio='".$accessorio."'
																	and lunghezza='".$lunghezza."'	
																	and data_richiesta=(SELECT Max(data_richiesta) AS MaxDidata FROM storico_richieste)																	
																LIMIT 1";
		$sql=$dbh->query($richiesta_effettuata);
		$res1=$sql->fetchAll();
		$sql="";
		
		switch(count($res1)){
			case "0"://caso nuovo inserimento
				echo "<p><strong>Nuovo prodotto</strong></p>";
				$dbh->exec("INSERT INTO storico_richieste (nome_prodotto,motore_led,id_tipo_luce,id_accessorio,lunghezza,codice_cliente,data_richiesta,ordine_cliente,riga_ordine_cliente) VALUES ('".$nome_prodotto."','".$motore_led."','".$temperatura_colore."','".$accessorio."','".$lunghezza."','".$codice_cliente."','".$data_ordine."','".$ordine_cliente."','".$riga_ordine_cliente."');");
				break;
				
			case "1"://caso inserimento già effettuato
				
				$sql=$dbh->query("SELECT * FROM storico_richieste WHERE nome_prodotto='".$nome_prodotto."' and 
																	motore_led='".$motore_led."' and
																	id_tipo_luce='".$temperatura_colore."' and
																	id_accessorio='".$accessorio."'
																	and lunghezza='".$lunghezza."'
																	and codice_cliente='".$codice_cliente."'
																	and data_richiesta=(SELECT Max(data_richiesta) AS MaxDidata FROM storico_richieste)
																	LIMIT 1");
				$rows=$sql->fetchAll();
				
				if (count($rows)>0){ //se il cliente ha già fatto questa richiesta compare un msg
					echo "<p><strong> Il cliente ".$codice_cliente." ha gi&agrave; effettuato una richista uguale in data ".$rows[0]['data_richiesta']."</strong></p>";
					$dbh->exec("INSERT INTO storico_richieste (nome_prodotto,motore_led,id_tipo_luce,id_accessorio,lunghezza,codice_cliente,data_richiesta,ordine_cliente,riga_ordine_cliente) VALUES('".$nome_prodotto."','".$motore_led."','".$temperatura_colore."','".$accessorio."','".$lunghezza."','".$codice_cliente."','".$data_ordine."','".$ordine_cliente."','".$riga_ordine_cliente."');");
				}else{		//se un altro cliente ha già fatto la stessa richiesta	
					echo "<p>Prodotto gi&agrave; richiesto, <strong>con le stesse caratteristiche</strong>, dal cliente ".$res1[0]['codice_cliente']." in data ".$res1[0]['data_richiesta']." </p>";
					$dbh->exec("INSERT INTO storico_richieste (nome_prodotto,motore_led,id_tipo_luce,id_accessorio,lunghezza,codice_cliente,data_richiesta,ordine_cliente,riga_ordine_cliente) VALUES('".$nome_prodotto."','".$motore_led."','".$temperatura_colore."','".$accessorio."','".$lunghezza."','".$codice_cliente."','".$data_ordine."','".$ordine_cliente."','".$riga_ordine_cliente."');");
				}
				break;
			default:
				echo "<p>PROBLEMI -- magari la query di selezione ha fatto qualche errore...</p>";
				break;
		}
	
		/*FINE CONTROLLO SE UN PRODOTTO ESISTE*/

		$sql="";
	
		
	
		/*ESTRAGGO IL CODICE PF FINALE IN BASE ALLA LUNGHEZZA PRODOTTO*/
		$caratteristiche_prodotto="SELECT * FROM prodotti_lineari WHERE nome_prodotto='".$nome_prodotto."' AND ".$lunghezza." >=da and ".$lunghezza."<=a GROUP BY codice_articolo;";	
		$sql=$dbh->prepare($caratteristiche_prodotto);
		$sql->execute();
		$res=$sql->fetchAll();
		$sql="";
		
		$codice_PF=$res['0']['codice_articolo'];
		
		/*ESTRAGGO INGOMBRO TECNICO IN BASE ALLA TRIADE: NOME_PRODOTTO, MOTORE_LED, ACCESSORIO*/
		$ingombro_tecnico="SELECT ingombri_tecnici.ingombro,accessori.descrizione, accessori.descrizione_breve
												  FROM ingombri_tecnici,accessori WHERE ingombri_tecnici.prodotto_lineare='".$nome_prodotto."' AND 
																						ingombri_tecnici.motore_led='".$motore_led."' AND 
																						ingombri_tecnici.id_accessorio='".$accessorio."' AND 
																						accessori.id_accessorio=ingombri_tecnici.id_accessorio;";
		
		$sql=$dbh->prepare($ingombro_tecnico);
		$sql->execute();
		$LU=$sql->fetchAll();
		$sql="";
		
		
		$area_utile=($lunghezza - $LU[0]['ingombro'] ); // l'ingombro fisso delle testate è già compreso del campo $LU[0]['ingombro']
		if ($LU[0]['descrizione_breve']=='N.A.'){
			$descrizione_breve_accessorio="";
		}else{
			$descrizione_breve_accessorio=$LU[0]['descrizione_breve'];
		}
		
		if ($LU[0]['descrizione']=="NESSUNO"){
			$descrizione_lunga_accessorio="";
		}else{		
			$descrizione_lunga_accessorio=$LU[0]['descrizione'];
		}
		
		/*SELEZIONO LE BARRE LED IN BASE AL NOME DEL PRODOTTO, MOTORE LED, LE LENTI E SISTEMA DI FISSAGGIO */
		$codice_fissaggio="";
		$descrizione_fissaggio="";
		$controllo_fissaggio=0;
		if ($motore_led=='HE' or $motore_led=='LN' or $motore_led=='PL'){
			
			
			if (!empty($sistema_fissaggio) or $sistema_fissaggio<>""){
				$select="SELECT anagrafica_barre_led.codice_barra_led,
							anagrafica_barre_led.descrizione,
							anagrafica_barre_led.tensione_alimentazione,
							anagrafica_barre_led.numero_led,
							anagrafica_barre_led.potenza,
							anagrafica_barre_led.potenza_a_modulo,
							anagrafica_barre_led.lunghezza_barra,
							motore_led.descrizione_motore,
							tipo_luce.tipo_luce,tipo_luce.codifica_temperatura,
							schermo.descrizione_schermo,
							tipo_fissaggio.codice_fissaggio,tipo_fissaggio.descrizione_fissaggio
						FROM anagrafica_barre_led,tipo_luce,motore_led, prodotto_lineare_motore_led,prodotto_lineare_schermo,schermo,tipo_fissaggio,regole_sistema_fissaggio
						WHERE  anagrafica_barre_led.codice_motore_led='".$motore_led."' 
						AND anagrafica_barre_led.id_tipo_luce='".$temperatura_colore."' 
						AND tipo_luce.id_tipo_luce=anagrafica_barre_led.id_tipo_luce
						AND anagrafica_barre_led.codice_motore_led=motore_led.codice_motore_led
						AND prodotto_lineare_motore_led.prodotto_lineare='".$nome_prodotto."'
						AND  prodotto_lineare_motore_led.motore_led=motore_led.codice_motore_led  
						AND anagrafica_barre_led.tensione_alimentazione='12'
						AND prodotto_lineare_schermo.prodotto_lineare='".$nome_prodotto."'
						AND prodotto_lineare_schermo.codice_schermo='".$colore_schermo."'
						AND prodotto_lineare_schermo.codice_schermo=schermo.codice_schermo
						AND regole_sistema_fissaggio.nome_prodotto='".$nome_prodotto."'
						AND regole_sistema_fissaggio.tipo_fissaggio=tipo_fissaggio.codice_fissaggio
						AND regole_sistema_fissaggio.tipo_fissaggio='".$sistema_fissaggio."'
						ORDER BY CAST(anagrafica_barre_led.lunghezza_barra as SIGNED) DESC;" ;
					$controllo_fissaggio=1;	
			}else{
				$select="SELECT anagrafica_barre_led.codice_barra_led,
							anagrafica_barre_led.descrizione,
							anagrafica_barre_led.tensione_alimentazione,
							anagrafica_barre_led.numero_led,
							anagrafica_barre_led.potenza,
							anagrafica_barre_led.potenza_a_modulo,
							anagrafica_barre_led.lunghezza_barra,
							motore_led.descrizione_motore,
							tipo_luce.tipo_luce,tipo_luce.codifica_temperatura,
							schermo.descrizione_schermo							
						FROM anagrafica_barre_led,tipo_luce,motore_led, prodotto_lineare_motore_led,prodotto_lineare_schermo,schermo
						WHERE  anagrafica_barre_led.codice_motore_led='".$motore_led."' 
						AND anagrafica_barre_led.id_tipo_luce='".$temperatura_colore."' 
						AND tipo_luce.id_tipo_luce=anagrafica_barre_led.id_tipo_luce
						AND anagrafica_barre_led.codice_motore_led=motore_led.codice_motore_led
						AND prodotto_lineare_motore_led.prodotto_lineare='".$nome_prodotto."'
						AND  prodotto_lineare_motore_led.motore_led=motore_led.codice_motore_led  
						AND anagrafica_barre_led.tensione_alimentazione='12'
						AND prodotto_lineare_schermo.prodotto_lineare='".$nome_prodotto."'
						AND prodotto_lineare_schermo.codice_schermo='".$colore_schermo."'
						AND prodotto_lineare_schermo.codice_schermo=schermo.codice_schermo
						ORDER BY CAST(anagrafica_barre_led.lunghezza_barra as SIGNED) DESC;" ;
			}
		}else{
			if (!empty($sistema_fissaggio) or $sistema_fissaggio<>""){
				$select="SELECT anagrafica_barre_led.codice_barra_led,
							anagrafica_barre_led.descrizione,
							anagrafica_barre_led.tensione_alimentazione,
							anagrafica_barre_led.numero_led,
							anagrafica_barre_led.potenza,
							anagrafica_barre_led.potenza_a_modulo,
							anagrafica_barre_led.lunghezza_barra,
							motore_led.descrizione_motore,
							tipo_luce.tipo_luce,tipo_luce.codifica_temperatura,
							schermo.descrizione_schermo,
							tipo_fissaggio.codice_fissaggio,tipo_fissaggio.descrizione_fissaggio
						FROM anagrafica_barre_led,tipo_luce,motore_led, prodotto_lineare_motore_led,prodotto_lineare_schermo,schermo,tipo_fissaggio,regole_sistema_fissaggio
						WHERE  anagrafica_barre_led.codice_motore_led='".$motore_led."' 
						AND anagrafica_barre_led.id_tipo_luce='".$temperatura_colore."' 
						AND tipo_luce.id_tipo_luce=anagrafica_barre_led.id_tipo_luce
						AND anagrafica_barre_led.codice_motore_led=motore_led.codice_motore_led
						AND prodotto_lineare_motore_led.prodotto_lineare='".$nome_prodotto."'
						AND  prodotto_lineare_motore_led.motore_led=motore_led.codice_motore_led  
						AND anagrafica_barre_led.tensione_alimentazione='12'
						AND prodotto_lineare_schermo.prodotto_lineare='".$nome_prodotto."'
						AND prodotto_lineare_schermo.codice_schermo='".$colore_schermo."'
						AND prodotto_lineare_schermo.codice_schermo=schermo.codice_schermo
						AND regole_sistema_fissaggio.nome_prodotto='".$nome_prodotto."'
						AND regole_sistema_fissaggio.tipo_fissaggio=tipo_fissaggio.codice_fissaggio
						AND regole_sistema_fissaggio.tipo_fissaggio='".$sistema_fissaggio."'
						ORDER BY CAST(anagrafica_barre_led.lunghezza_barra as SIGNED) DESC;" ;
				$controllo_fissaggio=1;	
			}else{
				$select="SELECT anagrafica_barre_led.codice_barra_led,
							anagrafica_barre_led.descrizione,
							anagrafica_barre_led.tensione_alimentazione,
							anagrafica_barre_led.numero_led,
							anagrafica_barre_led.potenza,
							anagrafica_barre_led.potenza_a_modulo,
							anagrafica_barre_led.lunghezza_barra,
							motore_led.descrizione_motore,
							tipo_luce.tipo_luce,tipo_luce.codifica_temperatura,
							schermo.descrizione_schermo							
						FROM anagrafica_barre_led,tipo_luce,motore_led, prodotto_lineare_motore_led,prodotto_lineare_schermo,schermo
						WHERE  anagrafica_barre_led.codice_motore_led='".$motore_led."' 
						AND anagrafica_barre_led.id_tipo_luce='".$temperatura_colore."' 
						AND tipo_luce.id_tipo_luce=anagrafica_barre_led.id_tipo_luce
						AND anagrafica_barre_led.codice_motore_led=motore_led.codice_motore_led
						AND prodotto_lineare_motore_led.prodotto_lineare='".$nome_prodotto."'
						AND  prodotto_lineare_motore_led.motore_led=motore_led.codice_motore_led  
						AND anagrafica_barre_led.tensione_alimentazione='12'
						AND prodotto_lineare_schermo.prodotto_lineare='".$nome_prodotto."'
						AND prodotto_lineare_schermo.codice_schermo='".$colore_schermo."'
						AND prodotto_lineare_schermo.codice_schermo=schermo.codice_schermo
						ORDER BY CAST(anagrafica_barre_led.lunghezza_barra as SIGNED) DESC;" ;
			}
		}
		$sql=$dbh->prepare($select);
		$sql->execute();
		$prod=$sql->fetchAll();
		
		//IN BASE ALLA CONDIZIONE ATTRIBUISCO LE DESCRIZIONI PER IL FISSAGGIO DELLA LAMPADA
		if ($controllo_fissaggio){
			$codice_fissaggio=$prod[0]['codice_fissaggio'];
			$descrizione_fissaggio=$prod[0]['descrizione_fissaggio'];
		}
		
		if ($prod){ // se il prodotto esiste
			switch($motore_led){//in base al tipo di motore ho calcoli differenti per il numero di barre led
			
				case "A": //strip REEL prima 60LED/M ex R0
					try {
						foreach($prod as $row) {
							//if ($row['lunghezza_barra']<=$area_utile){
								$numero_barre=floor($area_utile/50)*50;
								$calcolo_led=floor($area_utile/50);
								$num_led=($calcolo_led*$row['numero_led']);
								$potenza=Round(((int)$calcolo_led* $row['potenza_a_modulo']),1);
							//	$parte_decimale=(($area_utile/50)- floor($area_utile/50));
							
								echo "<p>Codice articolo prodotto configurato: ".return_temporary_code_MICHELON($ordine_cliente,$riga_ordine_cliente)."</p>";
								
								echo "<p><strong>IL PRODOTTO &Egrave; FATTIBILE</strong></p>
										<strong>I dati tecnici del prodotto sono riferiti per 1 prodotto: </strong><br/>
										CODICE PRODOTTO: ".$codice_PF." <br />
										Potenza: ".$potenza."W <br />
										Tensione: ".$row['tensione_alimentazione']."V <br />
										Numero led: ".$num_led." <br />
										Lunghezza REEL: ".$numero_barre."mm <br />
										Descrittivo breve: ".$nome_prodotto." ".$motore_led." ".$descrizione_breve_accessorio." ".$codice_fissaggio." ".$lunghezza." ".$row['codifica_temperatura']." ".$potenza."W ".$row['tensione_alimentazione']."V ".$colore_schermo." <br />
										Descrittivo lungo: ".$nome_prodotto." ".$motore_led." ".$descrizione_lunga_accessorio." ".$descrizione_fissaggio." ".$lunghezza."mm ".$row['tipo_luce']." ".$potenza."W ".$row['tensione_alimentazione']."VDC SCHERMO ".$row['descrizione_schermo']."<br />
										";					
												
							//$area_utile=$parte_decimale*50;
							//}
							$descrittivo_pf=$nome_prodotto." ".$motore_led." ".$descrizione_lunga_accessorio." ".$descrizione_fissaggio." ".$lunghezza."mm ".$row['tipo_luce']." ".$potenza."W ".$row['tensione_alimentazione']."VDC SCHERMO ".$row['descrizione_schermo'];
							$descrittivo_pf_breve=$nome_prodotto." ".$motore_led." ".$descrizione_breve_accessorio." ".$codice_fissaggio." ".$lunghezza." ".$row['codifica_temperatura']." ".$potenza."W ".$row['tensione_alimentazione']."V ".$colore_schermo;
						}
					}
					catch(PDOException $e) {
						echo $e->getMessage();
						die();
					}
					//AL MOMENTO DELL'INSERIMENTO IL CODICE PF FINALE è STATO SOSTITUITO CON UN CODICE PF FITTIZIO IN FUNZIONE DELLE LOGICIE DI PRODUZIONE. Per riprisitare il valore mettere la variabile $codice_PF
					if($dbh->exec("INSERT INTO richieste_ordini_produzione (data_inserimento,numero_ordine_cliente,riga_ordine_cliente,nome_prodotto,motore_led,id_tipo_luce,id_accessorio,lunghezza,codice_schermo,area_utile,codice_fissaggio,quantita,codice_pf_finale,descrizione_pf,descrizione_pf_breve,processato) 
																	VALUES('".$data_ordine."','".$ordine_cliente."','".$riga_ordine_cliente."','".$nome_prodotto."','".$motore_led."','".$temperatura_colore."','".$accessorio."','".$lunghezza."','".$colore_schermo."','".$area_utile."','".$sistema_fissaggio."','".$quantita."','".return_temporary_code_MICHELON($ordine_cliente,$riga_ordine_cliente)."','".$descrittivo_pf."','".$descrittivo_pf_breve."','0')")){
						echo "<br /><p style=\"color: red;\"><strong>Richiesta di produzione inserita</strong></p>";
					}else{
						echo "<br /><p style=\"color: red;\"><strong>>Problemi dell'inserire la richiesta di produzione per questo prodotto personalizzato</strong></p>";
					}
						
					break;
				case "B"://strip REEL prima 120LED/M ex R1
					try {
						foreach($prod as $row) {
							//if ($row['lunghezza_barra']<=$area_utile){								
								//ATTENZIONE: La 'potenza a modulo' per queste reel è di 0,24. Dato taroccato in anagrafica per questioni commerciali, vedi Biancotto-Falcier-Codutti. Basta modificare valore in anagrafica per ritornare allo stato inziale
								$numero_barre=floor($area_utile/25)*25;
								$calcolo_led=floor($area_utile/25);
								$num_led=($calcolo_led*$row['numero_led']);
								$potenza=Round(((int)$calcolo_led* $row['potenza_a_modulo']),1);
							
							//	$parte_decimale=(($area_utile/25)- floor($area_utile/25));
								echo "<p>Codice articolo prodotto configurato: ".return_temporary_code_MICHELON($ordine_cliente,$riga_ordine_cliente)."</p>";
								
								echo "<p><strong>IL PRODOTTO &Egrave; FATTIBILE</strong></p>
										<strong>I dati tecnici del prodotto sono riferiti per 1 prodotto: </strong><br/>
										CODICE PRODOTTO: ".$codice_PF." <br />
										Potenza: ".$potenza."W <br />
										Tensione: ".$row['tensione_alimentazione']."V <br />
										Numero led: ".$num_led." <br />
										Lunghezza REEL: ".$numero_barre."mm <br />
										Descrittivo breve: ".$nome_prodotto." ".$motore_led." ".$descrizione_breve_accessorio." ".$codice_fissaggio." ".$lunghezza." ".$row['codifica_temperatura']." ".$potenza."W ".$row['tensione_alimentazione']."V ".$colore_schermo." <br />
										Descrittivo lungo: ".$nome_prodotto." ".$motore_led." ".$descrizione_lunga_accessorio." ".$descrizione_fissaggio." ".$lunghezza."mm ".$row['tipo_luce']." ".$potenza."W ".$row['tensione_alimentazione']."VDC SCHERMO ".$row['descrizione_schermo']."<br />
										";
							
							//	$area_utile=$parte_decimale*25;
							//}
							$descrittivo_pf=$nome_prodotto." ".$motore_led." ".$descrizione_lunga_accessorio." ".$descrizione_fissaggio." ".$lunghezza."mm ".$row['tipo_luce']." ".$potenza."W ".$row['tensione_alimentazione']."VDC SCHERMO ".$row['descrizione_schermo'];
							$descrittivo_pf_breve=$nome_prodotto." ".$motore_led." ".$descrizione_breve_accessorio." ".$codice_fissaggio." ".$lunghezza." ".$row['codifica_temperatura']." ".$potenza."W ".$row['tensione_alimentazione']."V ".$colore_schermo;
						}
						
					}
					catch(PDOException $e) {
						echo $e->getMessage();
						die();
					}
					//AL MOMENTO DELL'INSERIMENTO IL CODICE PF FINALE è STATO SOSTITUITO CON UN CODICE PF FITTIZIO IN FUNZIONE DELLE LOGICIE DI PRODUZIONE. Per riprisitare il valore mettere la variabile $codice_PF
					if($dbh->exec("INSERT INTO richieste_ordini_produzione (data_inserimento,numero_ordine_cliente,riga_ordine_cliente,nome_prodotto,motore_led,id_tipo_luce,id_accessorio,lunghezza,codice_schermo,area_utile,codice_fissaggio,quantita,codice_pf_finale,descrizione_pf,descrizione_pf_breve,processato) 
																	VALUES('".$data_ordine."','".$ordine_cliente."','".$riga_ordine_cliente."','".$nome_prodotto."','".$motore_led."','".$temperatura_colore."','".$accessorio."','".$lunghezza."','".$colore_schermo."','".$area_utile."','".$sistema_fissaggio."','".$quantita."','".return_temporary_code_MICHELON($ordine_cliente,$riga_ordine_cliente)."','".$descrittivo_pf."','".$descrittivo_pf_breve."','0')")){
							echo "<br /><p style=\"color: red;\"><strong>Richiesta di produzione inserita</strong></p>";
					}else{
						echo "<br /><p style=\"color: red;\"><strong>>Problemi dell'inserire la richiesta di produzione per questo prodotto personalizzato</strong></p>";
					}
					break;
				default://caso per le barre rigide
				
					$num_led=0;
					$potenza=0;
					try {
						$area_utile_produzione=$area_utile; //mi serve per evitare che vado a memorizzare la parte rimanente e non l'intera area
						foreach($prod as $row) {
							if ($row['lunghezza_barra']<=$area_utile){
								$numero_barre=floor($area_utile/$row['lunghezza_barra']);
								$parte_decimale=(($area_utile/$row['lunghezza_barra'])- floor($area_utile/$row['lunghezza_barra']));
								$num_led=$num_led +($numero_barre*$row['numero_led']);
								$potenza=$potenza  + Round(($numero_barre* $row['potenza']),1);
							//		echo $row['codice_barra_led']." - " .$row['descrizione']." - Numero led: ". $row['numero_led']." - ". $row['potenza']."W - ".$row['lunghezza_barra']."mm - Numero di barrette: ".$numero_barre."<br />";
								$area_utile=$parte_decimale*$row['lunghezza_barra'];
							}
						}
						echo "<p>Codice articolo prodotto configurato: ".return_temporary_code_MICHELON($ordine_cliente,$riga_ordine_cliente)."</p>";
						
						echo "<p><strong>IL PRODOTTO &Egrave; FATTIBILE</strong></p>
										<strong>I dati tecnici del prodotto sono riferiti per 1 prodotto: </strong><br/>
										CODICE PRODOTTO: ".$codice_PF." <br />
										Potenza: ".$potenza."W <br />
										Tensione: ".$row['tensione_alimentazione']."V <br />
										Numero led: ".$num_led." <br />									
										Descrittivo breve: ".$nome_prodotto." ".$motore_led." ".$descrizione_breve_accessorio." ".$codice_fissaggio." ".$lunghezza." ".$row['codifica_temperatura']." ".$potenza."W ".$row['tensione_alimentazione']."V ".$colore_schermo." <br />
										Descrittivo lungo: ".$nome_prodotto." ".$motore_led." ".$descrizione_lunga_accessorio." ".$descrizione_fissaggio." ".$lunghezza."mm ".$row['tipo_luce']." ".$potenza."W ".$row['tensione_alimentazione']."VDC SCHERMO ".$row['descrizione_schermo']."<br />
										";			
						$descrittivo_pf=$nome_prodotto." ".$motore_led." ".$descrizione_lunga_accessorio." ".$descrizione_fissaggio." ".$lunghezza."mm ".$row['tipo_luce']." ".$potenza."W ".$row['tensione_alimentazione']."VDC SCHERMO ".$row['descrizione_schermo'];
						$descrittivo_pf_breve=$nome_prodotto." ".$motore_led." ".$descrizione_breve_accessorio." ".$codice_fissaggio." ".$lunghezza." ".$row['codifica_temperatura']." ".$potenza."W ".$row['tensione_alimentazione']."V ".$colore_schermo;
					}
					catch(PDOException $e) {
						echo $e->getMessage();
						die();
					}
					//AL MOMENTO DELL'INSERIMENTO IL CODICE PF FINALE è STATO SOSTITUITO CON UN CODICE PF FITTIZIO IN FUNZIONE DELLE LOGICIE DI PRODUZIONE. Per riprisitare il valore mettere la variabile $codice_PF
					if($dbh->exec("INSERT INTO richieste_ordini_produzione (data_inserimento,numero_ordine_cliente,riga_ordine_cliente,nome_prodotto,motore_led,id_tipo_luce,id_accessorio,lunghezza,codice_schermo,area_utile,codice_fissaggio,quantita,codice_pf_finale,descrizione_pf,descrizione_pf_breve,processato) 
																	VALUES('".$data_ordine."','".$ordine_cliente."','".$riga_ordine_cliente."','".$nome_prodotto."','".$motore_led."','".$temperatura_colore."','".$accessorio."','".$lunghezza."','".$colore_schermo."','".$area_utile."','".$sistema_fissaggio."','".$quantita."','".return_temporary_code_MICHELON($ordine_cliente,$riga_ordine_cliente)."','".$descrittivo_pf."','".$descrittivo_pf_breve."','0')")){
						echo "<br /><p style=\"color: red;\"><strong>Richiesta di produzione inserita</strong></p>";
					}else{
						echo "<br /><p style=\"color: red;\"><strong>>Problemi dell'inserire la richiesta di produzione per questo prodotto personalizzato</strong></p>";
					}
					break;
			}		
		}else{
			echo "<p><strong>NON FATTIBILE</strong> - Nessuna barra led associata</p>";
		}
		
	}else{	
		switch(true){ //ATENZIONE: SWITCH CON POSSIBILITA' DI FORMULE NELLA CONTEMPLAZIONE DEL CASO
			case ($lunghezza< $res['0']['lunghezza_minima_accettata']):
				echo "<p><strong>NON FATTIBILE</strong> - Lunghezza inferiore del minimo consentito per il prodotto ".$nome_prodotto.". Il minimo consentito &egrave; di: ".$res['0']['lunghezza_minima_accettata']."mm</p>";
				break;
			case ($lunghezza> $res['0']['lunghezza_massima_accettata']):
				echo "<p><strong>NON FATTIBILE</strong> - Lunghezza superione del massimo consentito per il prodotto ".$nome_prodotto.". Il massimo consentito &egrave; di: ".$res['0']['lunghezza_massima_accettata']."mm</p>";
				break;
		}
		
	}
	}
	function return_temporary_code($ordine_cliente,$riga_ordine){
		if(strlen((string)$riga_ordine)<3){
			return "CAMC.".$ordine_cliente."0".$riga_ordine;
		}else{
			return "CAMC.".$ordine_cliente.$riga_ordine;
		}
	}
	function return_temporary_code_ZANNESE($ordine_cliente,$riga_ordine){
		if(strlen((string)$riga_ordine)<3){
			return "C.ON.".$ordine_cliente."R.0".$riga_ordine;
		}else{
			return "C.ON.".$ordine_cliente."R.".$riga_ordine;
		}
	}
	function return_temporary_code_MICHELON($ordine_cliente,$riga_ordine){
		
		if(strlen((string)$riga_ordine)<3){
			return "C.".$ordine_cliente.".0".$riga_ordine;
		}else{
			return "C.".$ordine_cliente.".".$riga_ordine;
		}
	}
	
	
	
?>