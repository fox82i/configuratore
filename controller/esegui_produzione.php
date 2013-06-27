<?php
		include("../include/dbconfig.inc.php");
		include ("supporto_produzione.php");

	if (isset($_POST['ordine_produzione'])){
		$ordine_produzione_selezionato=$_POST['ordine_produzione'];
		
		/*DATI FISSI LAVORAZIONE MECCANICA*/
		$profilo_alluminio=4300;
		$profilo_plastico=3000;
		/*FINE DATI FISSI LAVORAZIONE MECCANICA*/
		
		
		switch (count($ordine_produzione_selezionato)){
			case "1":// CASO UN ORDINE DI PRODUZIONE SELEZIONATO
				$e_val = explode("-", $ordine_produzione_selezionato[0]);  
				$ordine_produzione = $e_val[0]; 
				$riga_ordine= (int)$e_val[1];
				
				$diba_prod=esistenza_diba('diba_produzione',$ordine_produzione,$riga_ordine);
	
				echo "<p>Hai selezionato il seguente ordine cliente: <strong>".$ordine_produzione."</strong><br/>
						Riga ordine cliente selezionata: <strong>".$riga_ordine."</strong><br/>";
				
				$sql="SELECT richieste_ordini_produzione.*, CONCAT_WS(  ' ', tipo_luce.tipo_luce, tipo_luce.temperatura_colore) as descrittivo_luce ,(accessori.descrizione) as accessorio,motore_led.descrizione_motore
						FROM richieste_ordini_produzione, tipo_luce,accessori,motore_led
						WHERE numero_ordine_cliente='".$ordine_produzione."'
						AND riga_ordine_cliente='".$riga_ordine."'
						AND motore_led.codice_motore_led=richieste_ordini_produzione.motore_led
						AND richieste_ordini_produzione.id_tipo_luce=tipo_luce.id_tipo_luce
						AND accessori.id_accessorio=richieste_ordini_produzione.id_accessorio;";
						
				$select=$dbh->query($sql); //ESECUZIONE QUERY SU TABELLE RICHIESTE
				$rows=$select->fetchAll();
				$sql="";
				
				$sql="SELECT * FROM diba WHERE nome_prodotto='".$rows[0]['nome_prodotto']."' order by ordine ASC;";
				$select=$dbh->query($sql); // ESECUZIONE QUERY SU DISTINTA BASE
				$diba=$select->fetchAll();
				$sql="";
				
				//CONTROLLO ESISTENZA DIBA. Se non esite interrompo l'elaborazione
				if(count($diba)==0){
					echo "<p>DiBa inesistente per il prodotto selezionato...</p>";
					break;
				}
				
				/*ATTRIBUZIONE INGOMBRO FISSO PROFILI PLASTICI ED ALLUMINIO PER PRODOTTO -- da capire se mettere in mysql oppure no  */
				$ingombro_fisso_alluminio=0;
				$ingombro_fisso_plastico=0;
				
				switch ($rows[0]['nome_prodotto']){
					case "BALI":
						$ingombro_fisso_alluminio=4;
						$ingombro_fisso_plastico=49;
						break;	
					case "LUGANO":
						$ingombro_fisso_alluminio=4;
						$ingombro_fisso_plastico=4;
						break;
					case "MALINDI":
						$ingombro_fisso_alluminio=16;
						$ingombro_fisso_plastico=0;
						break;
				}
				/*FINE ATTRIBUZIONE INGOMBRO FISSO PROFILI PLASTICI ED ALLUMINIO  PER PRODOTTO*/
				
				foreach ($rows as $row){
					echo "<br /><strong>Data ordine cliente: </strong>".$row['data_inserimento']."<br /> 
					<strong>Nome prodotto: </strong>".$row['nome_prodotto']."<br />
					<strong>Lunghezza richiesta: </strong>".$row['lunghezza']."mm<br />
					<strong>Motore luce: </strong>".$row['descrizione_motore']."<br />					
					<strong>Colore luce: </strong>".$row['descrittivo_luce']."K<br />
					<strong>Accessorio: </strong>".$row['accessorio']."<br />					
					<strong>Quantit&agrave; da produrre: </strong>". $row['quantita']."<br />
					<strong>Codice PF finale: </strong>".$row['codice_pf_finale']."<br/>
					<strong>Riferimento ordine cliente: </strong>".$row['riferimento_cliente']
					;
					
				}
		
			foreach ($diba as $sub_riga){
				switch ($sub_riga['ordine']){
					case "10":
						/*SFRIDI VERGA ALLUMINIO*/	
						if ($_POST['tipo_view']=='old'){
							taglio_profili2($sub_riga['codice_componente'],$sub_riga['ordine'],$profilo_alluminio,$rows[0]['lunghezza'],$rows[0]['quantita'],$ingombro_fisso_alluminio,"Lavorazione meccanica verga alluminio","Pezzi verga alluminio",$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
						}else{
							taglio_profili($sub_riga['codice_componente'],$sub_riga['ordine'],$profilo_alluminio,$rows[0]['lunghezza'],$rows[0]['quantita'],$ingombro_fisso_alluminio,"Lavorazione meccanica verga alluminio","Pezzi verga alluminio",$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
						}
						break;
						/*FINE GESTIONE SFRIDI VERGA ALLUMINIO*/	
					
					case "11":
						/*GESTIONE SUPPORTO ALLUMINIO PER REEL*/
						if ($rows[0]['motore_led']=='A' or $rows[0]['motore_led']=='B'){
							if ($_POST['tipo_view']=='old'){
								supporto_reel($row['motore_led'],$sub_riga['codice_componente'],$sub_riga['ordine'],$profilo_alluminio,$rows[0]['area_utile'],$rows[0]['quantita'],"Lavorazione supporto alluminio REEL","Pezzi supprto alluminio",$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
								#taglio_profili2($sub_riga['codice_componente'],$sub_riga['ordine'],4300,$rows[0]['lunghezza'],$rows[0]['quantita'],$ingombro_fisso_alluminio,"Lavorazione supporto alluminio REEL","Pezzi supprto alluminio",$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
							}else{
								supporto_reel2($row['motore_led'],$sub_riga['codice_componente'],$sub_riga['ordine'],$profilo_alluminio,$rows[0]['area_utile'],$rows[0]['quantita'],"Lavorazione supporto alluminio REEL","Pezzi supprto alluminio",$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
								#taglio_profili($sub_riga['codice_componente'],$sub_riga['ordine'],4300,$rows[0]['lunghezza'],$rows[0]['quantita'],$ingombro_fisso_alluminio,"Lavorazione supporto alluminio REEL e sfridi","Pezzi supprto alluminio",$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
							}			
						}				
						break;
						/*FINE GESTIONE SUPPORTO ALLUMINIO PER REEL*/
				}
			}
			//		case "20":
						/*GESTIONE PROFILO PLASTICO */
						$select=$dbh->query("	SELECT regole_schermo.ordine,regole_schermo.codice_articolo_schermo,regole_schermo.descrizione_schermo
												FROM	regole_schermo,prodotto_lineare_schermo
												WHERE	regole_schermo.codice_schermo=prodotto_lineare_schermo.codice_schermo AND
														regole_schermo.nome_prodotto=prodotto_lineare_schermo.prodotto_lineare AND
														prodotto_lineare_schermo.prodotto_lineare='".$rows[0]['nome_prodotto']."' AND
														prodotto_lineare_schermo.codice_schermo='".$rows[0]['codice_schermo']."'
											");
						$schermo_plastico=$select->fetchAll();
						$select="";
						
						switch ($rows[0]['id_accessorio']){
							case "1"://NESSUN ACCESSORIO
							case "2"://TOUCH				
								if ($_POST['tipo_view']=='old'){
									taglio_profili2($schermo_plastico[0]['codice_articolo_schermo'],$schermo_plastico[0]['ordine'],$profilo_plastico,$rows[0]['lunghezza'],$rows[0]['quantita'],$ingombro_fisso_plastico,$schermo_plastico[0]['descrizione_schermo'],"Pezzi verga plastica",$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
								}else{					
									taglio_profili($schermo_plastico[0]['codice_articolo_schermo'],$schermo_plastico[0]['ordine'],$profilo_plastico,$rows[0]['lunghezza'],$rows[0]['quantita'],$ingombro_fisso_plastico,$schermo_plastico[0]['descrizione_schermo'],"Pezzi verga plastica",$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
								}
								break;
							case "3":
							/*SENSORE PEER*/
								if ($_POST['tipo_view']=='old'){
									taglio_profili2($schermo_plastico[0]['codice_articolo_schermo'],$schermo_plastico[0]['ordine'],$profilo_plastico,$rows[0]['lunghezza'],$rows[0]['quantita'],$ingombro_fisso_plastico,$schermo_plastico[0]['descrizione_schermo'],"Pezzi verga plastica",$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
								}else{						
									taglio_profili($schermo_plastico[0]['codice_articolo_schermo'],$schermo_plastico[0]['ordine'],$profilo_plastico,$rows[0]['lunghezza'],$rows[0]['quantita'],$ingombro_fisso_plastico,$schermo_plastico[0]['descrizione_schermo'],"Pezzi verga plastica",$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
								}
								break;
					
						}
						//break;
						/*FINE GESTIONE PROFILO PLASTICO*/
				//}
			//}
			
			
			
			echo "<br/> <br/>
				
			<table border=\"1\" id='lista-produzione'>
				<caption><strong>LISTA COMPONENTI</strong></caption>
				<thead>
					<tr>
						<th><strong>Posizione</strong></th>
						<th><strong>Materiale</strong></th>
						<th><strong>Descrizione</strong></th>
						<th><strong>Quantit&agrave; PZ</strong></th>
						<th><strong>Note di produzione/assemblaggio</strong></th>
						
					</tr>
				</thead>
				<tbody>
				
				";
			/*REGOLE MOLLE*/	
				$sql="SELECT ordine,codice_articolo_molle,descrittivo_molle,numero_molle FROM regole_molle WHERE nome_prodotto='".$rows[0]['nome_prodotto']."' and  da<='".$rows[0]['lunghezza']."' and a>='".$rows[0]['lunghezza']."';";				
				$select=$dbh->query($sql);
				
				$molle=$select->fetchAll();
				$sql="";
				if (count($molle)>0){//NON TUTTI I PRODOTTI HANNO LE MOLLE
					$numero_molle=$molle[0]['numero_molle']*$rows[0]['quantita'];		
					echo "<tr> 
							<td>".$molle[0]['ordine']."</td>			
							<td>".$molle[0]['codice_articolo_molle'] ."</td>			
							<td>".$molle[0]['descrittivo_molle'] ."</td>			
							<td>".$numero_molle."</td>			
							<td>".$molle[0]['numero_molle']." molle per singolo prodotto assemblato</td>			
						</tr> ";
					if (!$diba_prod){
						inserisci_diba('diba_produzione',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$molle[0]['ordine'],$molle[0]['codice_articolo_molle'],$molle[0]['descrittivo_molle'],'PZ',$numero_molle,date("Ymd"));
						inserisci_diba('diba_tecnica',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$molle[0]['ordine'],$molle[0]['codice_articolo_molle'],$molle[0]['descrittivo_molle'],'PZ',$molle[0]['numero_molle'],date("Ymd"));
					}
				}
			/*FINE REGOLE MOLLE*/	
			
			foreach ($diba as $sub_riga){
				switch ($sub_riga['ordine']){
					case "40":
					//TESTATE
						echo "<tr>
								<td>".$sub_riga['ordine']."</td>			
								<td>".$sub_riga['codice_componente']."</td>			
								<td>".$sub_riga['descrizione_di_massima_componente']."</td>			
								<td>".$sub_riga['quantita']*$rows[0]['quantita']."</td>			
								<td>".$sub_riga['quantita']." testate per singolo prodotto assemblato</td>			
							</tr> ";
				
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita']*$rows[0]['quantita'],date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita'],date("Ymd"));
						}
						break;
					case "41":
					//TESTATE SX LUGANO
						echo "<tr>
								<td>".$sub_riga['ordine']."</td>			
								<td>".$sub_riga['codice_componente']."</td>			
								<td>".$sub_riga['descrizione_di_massima_componente']."</td>			
								<td>".$sub_riga['quantita']*$rows[0]['quantita']."</td>			
								<td>".$sub_riga['quantita']." ".$sub_riga['descrizione_di_massima_componente']."</td>			
							</tr> ";
				
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita']*$rows[0]['quantita'],date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita'],date("Ymd"));
						}
						break;
					case "42":
						//TESTATE DX LUGANO
						echo "<tr>
								<td>".$sub_riga['ordine']."</td>			
								<td>".$sub_riga['codice_componente']."</td>			
								<td>".$sub_riga['descrizione_di_massima_componente']."</td>			
								<td>".$sub_riga['quantita']*$rows[0]['quantita']."</td>			
								<td>".$sub_riga['quantita']." ".$sub_riga['descrizione_di_massima_componente']."</td>			
							</tr> ";
				
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita']*$rows[0]['quantita'],date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita'],date("Ymd"));
						}
					
						break;
					case "50":
					//ETICHETTA LOGO TESTATA LS
						echo "<tr>
								<td>".$sub_riga['ordine']."</td>			
								<td>".$sub_riga['codice_componente']."</td>			
								<td>".$sub_riga['descrizione_di_massima_componente']."</td>			
								<td>".$sub_riga['quantita']*$rows[0]['quantita']."</td>			
								<td>".$sub_riga['quantita']." etichetta logo testata LS per singolo prodotto assemblato</td>			
							</tr> ";
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita']*$rows[0]['quantita'],date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita'],date("Ymd"));
						}	
						break;
					case "60":
					//FERMACAVO
						echo "<tr>
								<td>".$sub_riga['ordine']."</td>			
								<td>".$sub_riga['codice_componente']."</td>			
								<td>".$sub_riga['descrizione_di_massima_componente']."</td>			
								<td>".$sub_riga['quantita']*$rows[0]['quantita']."</td>			
								<td>".$sub_riga['quantita']." fermacavo per singolo prodotto assemblato</td>			
							</tr> ";				
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita']*$rows[0]['quantita'],date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita'],date("Ymd"));
						}
						break;
					case "70":
					//VITE FERMACAVO
						echo "<tr>
								<td>".$sub_riga['ordine']."</td>			
								<td>".$sub_riga['codice_componente']."</td>			
								<td>".$sub_riga['descrizione_di_massima_componente']."</td>			
								<td>".$sub_riga['quantita']*$rows[0]['quantita']."</td>			
								<td>".$sub_riga['quantita']." vite fermacavo per singolo prodotto assemblato</td>			
							</tr> ";				
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita']*$rows[0]['quantita'],date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita'],date("Ymd"));
						}
						break;
					case "71":
						//CONFEZIONE FISSAGGIO
						$conf_fissaggio="";
						$qta_conf_fissaggio="";
						echo "<tr>
								<td>".$sub_riga['ordine']."</td>			
								<td>".$sub_riga['codice_componente']."</td>			
								<td>".$sub_riga['descrizione_di_massima_componente']."</td>			
								";
								if ($rows[0]['lunghezza']<=1500){
									$conf_fissaggio=$sub_riga['quantita']*$rows[0]['quantita'];
									$qta_conf_fissaggio=$sub_riga['quantita'];
								}else{
									$conf_fissaggio=($sub_riga['quantita']*$rows[0]['quantita'])*2;
									$qta_conf_fissaggio=$sub_riga['quantita']*2;
								}
								
						echo "	<td>".$conf_fissaggio."</td>			
								<td>".$qta_conf_fissaggio." ".$sub_riga['descrizione_di_massima_componente']."</td>			
							</tr> ";
				
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$conf_fissaggio,date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$qta_conf_fissaggio,date("Ymd"));
						}
					
						break;
					case "72":
						//DIMA LUGANO GENEVE
						echo "<tr>
								<td>".$sub_riga['ordine']."</td>			
								<td>".$sub_riga['codice_componente']."</td>			
								<td>".$sub_riga['descrizione_di_massima_componente']."</td>			
								<td>".$sub_riga['quantita']*$rows[0]['quantita']."</td>			
								<td>".$sub_riga['quantita']." ".$sub_riga['descrizione_di_massima_componente']."</td>			
							</tr> ";
				
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita']*$rows[0]['quantita'],date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita'],date("Ymd"));
						}
					
						break;
				}
			}
			/*CONFEZIONE DI FISSAGGIO/MAGNETI*/
			switch ($rows[0]['nome_prodotto']){
				case "BALI":
					regole_sitema_fissaggio($rows[0]['nome_prodotto'],$rows[0]['codice_fissaggio'],$rows[0]['quantita'],$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
					break;
			}			
			/*FINE CONFEZIONE DI FISSAGGIO/MAGNETI*/
			
			
			
			//MOTORE LED
			motore_led($rows[0]['nome_prodotto'],$rows[0]['motore_led'],$rows[0]['id_tipo_luce'],$rows[0]['area_utile'],$rows[0]['quantita'],$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine,$rows[0]['codice_schermo']);
			
			
			//CAVO CONNESSIONE ACCESSORI			
			regole_accessori_fermacavo($rows[0]['nome_prodotto'],$rows[0]['id_accessorio'],$rows[0]['motore_led'],$rows[0]['quantita'],$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
			
			foreach ($diba as $sub_riga){
				switch ($sub_riga['ordine']){
					case "110":
					//ETICHETTA IMBALLO SINGOLO
						echo "<tr>
								<td>".$sub_riga['ordine']."</td>			
								<td>".$sub_riga['codice_componente']."</td>			
								<td>".$sub_riga['descrizione_di_massima_componente']."</td>			
								<td>".$sub_riga['quantita']*$rows[0]['quantita']."</td>			
								<td>".$sub_riga['quantita']." etichetta imballo singolo  per singolo imballo</td>			
							</tr> ";			
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita']*$rows[0]['quantita'],date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita'],date("Ymd"));
						}
						break;
				}
			}
			//ETICHETTA IMBALLO MULTIPLO
			regole_etichette_imballo_multiplo($rows[0]['nome_prodotto'],$rows[0]['quantita'],10,$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine); //10 è il coefficente di utilizzo
			
			foreach ($diba as $sub_riga){
				switch ($sub_riga['ordine']){
					case "130":
					//ETICHETTA TARGA ENEC
						echo "<tr>
								<td>".$sub_riga['ordine']."</td>			
								<td>".$sub_riga['codice_componente']."</td>			
								<td>".$sub_riga['descrizione_di_massima_componente']."</td>			
								<td>".$sub_riga['quantita']*$rows[0]['quantita']."</td>			
								<td>".$sub_riga['quantita']." ".$sub_riga['descrizione_di_massima_componente']." per singolo prodotto assemblato</td>			
							</tr> ";
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita']*$rows[0]['quantita'],date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita'],date("Ymd"));
						}
						break;
					case "131":
						//ETICHETTA 12VDC PER MALINDI
						echo "<tr>
								<td>".$sub_riga['ordine']."</td>			
								<td>".$sub_riga['codice_componente']."</td>			
								<td>".$sub_riga['descrizione_di_massima_componente']."</td>			
								<td>".$sub_riga['quantita']*$rows[0]['quantita']."</td>			
								<td>".$sub_riga['quantita']." ".$sub_riga['descrizione_di_massima_componente']." per singolo prodotto assemblato</td>			
							</tr> ";
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita']*$rows[0]['quantita'],date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita'],date("Ymd"));
						}
						break;
						
				# AL MOMENTO I PRODOTTI NON SONO CERTIFICATI
				/*	case "140":
						//ETICHETTA MARCHIO ETL
						echo "<tr>
								<td>".$sub_riga['ordine']."</td>			
								<td>".$sub_riga['codice_componente']."</td>			
								<td>".$sub_riga['descrizione_di_massima_componente']."</td>			
								<td>".$sub_riga['quantita']*$rows[0]['quantita']."</td>			
								<td>".$sub_riga['quantita']." ".$sub_riga['descrizione_di_massima_componente']." per singolo prodotto assemblato</td>			
							</tr> ";
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita']*$rows[0]['quantita'],date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita'],date("Ymd"));
						}	
						break;
					case "150":
						//ETICHETTA BANDIERA INCASSO ETL
						echo "<tr>
								<td>".$sub_riga['ordine']."</td>			
								<td>".$sub_riga['codice_componente']."</td>			
								<td>".$sub_riga['descrizione_di_massima_componente']."</td>			
								<td>".$sub_riga['quantita']*$rows[0]['quantita']."</td>			
								<td>".$sub_riga['quantita']." ".$sub_riga['descrizione_di_massima_componente']." per singolo prodotto assemblato</td>			
							</tr> ";
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita']*$rows[0]['quantita'],date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita'],date("Ymd"));
						}
						break;
				*/
					case "160":		
						//ETICHETTA BANDIERA PER CAVO ETL
						echo "<tr>
								<td>".$sub_riga['ordine']."</td>			
								<td>".$sub_riga['codice_componente']."</td>			
								<td>".$sub_riga['descrizione_di_massima_componente']."</td>			
								<td>".$sub_riga['quantita']*$rows[0]['quantita']."</td>			
								<td>".$sub_riga['quantita']." ".$sub_riga['descrizione_di_massima_componente']." per singolo prodotto assemblato</td>			
							</tr> ";
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita']*$rows[0]['quantita'],date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita'],date("Ymd"));
						}
						break;
					case "170":
						//ETICHETTA SELEZIONE COLORE
						echo "<tr>
								<td>".$sub_riga['ordine']."</td>			
								<td>".$sub_riga['codice_componente']."</td>			
								<td>".$sub_riga['descrizione_di_massima_componente']."</td>			
								<td>".$sub_riga['quantita']*$rows[0]['quantita']."</td>			
								<td>".$sub_riga['quantita']." ".$sub_riga['descrizione_di_massima_componente']." per singolo prodotto assemblato</td>			
							</tr> ";
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita']*$rows[0]['quantita'],date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$sub_riga['ordine'],$sub_riga['codice_componente'],utf8_encode(trim(addslashes($sub_riga['descrizione_di_massima_componente']))),$sub_riga['UM'],$sub_riga['quantita'],date("Ymd"));
						}
						break;
				}
			}
			//FOGLI ISTRUZIONE
			
			regole_fogli_istruzione($rows[0]['nome_prodotto'],$rows[0]['id_accessorio'],$rows[0]['quantita'],$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
			
			//IMBALLI
			regole_imballi($rows[0]['nome_prodotto'],$rows[0]['quantita'],$rows[0]['lunghezza'],$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
			
			//AGGIORNO LA TABELLA DI RICHIESTE DI PRODUZIONE PORTANDO IL VALORE AD 1
			$dbh->exec("UPDATE richieste_ordini_produzione SET processato=1 WHERE numero_ordine_cliente='".$e_val[0]."' and riga_ordine_cliente='".$e_val[1]."';");
		
			echo"</tbody>
				</table>";
			break;
			
		default: //PRODUZIONE DI PIU' RICHIESTE PERSONALIZZATE E/O RIGHE ORDINE MULTIPLE
			echo "<p>Hai selezionato i seguenti ordini di produzione: </p>";
			foreach($ordine_produzione_selezionato as $key => $value) {  
				$e_val = explode("-", $value);  
				//$riga_ordine = $e_val[1]; 
				//$ordine_cliente = $e_val[0];
				echo "Ordine cliente ".$e_val[0]." riga ordine cliente: ".$e_val[1]."<br/>";
			}
			break;
		}
	}else{
		echo "<p>Nessun ordine selezionato quindi nessuna produzione...</p>";
	}
	
?>