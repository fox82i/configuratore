<?php
		include("../include/dbconfig.inc.php");
		include ("supporto_produzione.php");

	if (isset($_POST['ordine_produzione'])){
		$ordine_produzione_selezionato=$_POST['ordine_produzione'];
		
		
		$profilo_alluminio=4300;
		$profilo_plastico=3000;
		$numero_verghe=0;
		$verga_aggiuntiva=0;
		$sfrido_per_verga=0;
		$sfrido_singola_verga=0;
		$numero_barre_per_verga=0;
		
		
		
		switch (count($ordine_produzione_selezionato)){
			case "1":// CASO UN ORDINE DI PRODUZIONE SELEZIONATO
				$e_val = explode("-", $ordine_produzione_selezionato[0]);  
				$ordine_produzione = $e_val[0]; 
				$riga_ordine= (int)$e_val[1];
				
				$diba_prod=esistenza_diba_produzione($ordine_produzione,$riga_ordine);
	
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
				
				$sql="SELECT * FROM diba WHERE nome_prodotto='".$rows[0]['nome_prodotto']."';";
				$select=$dbh->query($sql); // ESECUZIONE QUERY SU DISTINTA BASE
				$diba=$select->fetchAll();
				$sql="";
				
				//CONTROLLO ESISTENZA DIBA. Se non esite interrompo l'elaborazione
				if(count($diba)==0){
					echo "<p>DiBa inesistente per il prodotto selezionato...</p>";
					break;
				}
				
				foreach ($rows as $row){
					echo "<br /><strong>Data ordine cliente: </strong>".$row['data_inserimento']."<br /> 
					<strong>Nome prodotto: </strong>".$row['nome_prodotto']."<br />
					<strong>Lunghezza richiesta: </strong>".$row['lunghezza']."mm<br />
					<strong>Motore luce: </strong>".$row['descrizione_motore']."<br />					
					<strong>Colore luce: </strong>".$row['descrittivo_luce']."K<br />
					<strong>Accessorio: </strong>".$row['accessorio']."<br />					
					<strong>Quantit&agrave; da produrre: </strong>". $row['quantita']."<br />
					<strong>Codice PF finale: </strong>".$row['codice_pf_finale'];
				}
		
			
			/*SFRIDI VERGA ALLUMINIO*/	
			if ($_POST['tipo_view']=='old'){
				taglio_profili2($diba[0]['codice_componente'],$diba[0]['ordine'],$profilo_alluminio,$rows[0]['lunghezza'],$rows[0]['quantita'],16,"Lavorazione meccanica verga alluminio","Pezzi verga alluminio",$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
			}else{
				taglio_profili($diba[0]['codice_componente'],$diba[0]['ordine'],$profilo_alluminio,$rows[0]['lunghezza'],$rows[0]['quantita'],16,"Lavorazione meccanica verga alluminio","Pezzi verga alluminio",$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
			}
			/*FINE GESTIONE SFRIDI VERGA ALLUMINIO*/	
			
			/*GESTIONE SUPPORTO ALLUMINIO PER REEL*/
			if ($rows[0]['motore_led']=='R0' or $rows[0]['motore_led']=='R1'){
				if ($_POST['tipo_view']=='old'){
					taglio_profili2($diba[13]['codice_componente'],$diba[13]['ordine'],4300,$rows[0]['lunghezza'],$rows[0]['quantita'],16,"Lavorazione supporto alluminio REEL","Pezzi supprto alluminio",$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
				}else{
					taglio_profili($diba[13]['codice_componente'],$diba[13]['ordine'],4300,$rows[0]['lunghezza'],$rows[0]['quantita'],16,"Lavorazione supporto alluminio REEL e sfridi","Pezzi supprto alluminio",$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
				}			
			}
			
			
			/*FINE GESTIONE SUPPORTO ALLUMINIO PER REEL*/
			
			
			/*GESTIONE PROFILO PLASTICO */
			switch ($rows[0]['id_accessorio']){
				case "1":
				case "2":
				
					if ($_POST['tipo_view']=='old'){
						taglio_profili2($diba[1]['codice_componente'],$diba[1]['ordine'],$profilo_plastico,$rows[0]['lunghezza'],$rows[0]['quantita'],57,"Lavorazione verga plastica","Pezzi verga plastica",$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
					}else{
					
						taglio_profili($diba[1]['codice_componente'],$diba[1]['ordine'],$profilo_plastico,$rows[0]['lunghezza'],$rows[0]['quantita'],57,"Lavorazione verga plastica","Pezzi verga plastica",$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
					}
					break;
				case "3":
				
					if ($_POST['tipo_view']=='old'){
						taglio_profili2($diba[1]['codice_componente'],$diba[1]['ordine'],$profilo_plastico,$rows[0]['lunghezza'],$rows[0]['quantita'],65,"Lavorazione verga plastica","Pezzi verga plastica",$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
					}else{
					
						taglio_profili($diba[1]['codice_componente'],$diba[1]['ordine'],$profilo_plastico,$rows[0]['lunghezza'],$rows[0]['quantita'],65,"Lavorazione verga plastica","Pezzi verga plastica",$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
					}
					break;
					
			}
			/*FINE GESTIONE PROFILO PLASTICO*/
			
			/*REGOLE MOLLE*/	
				$sql="SELECT ordine,codice_articolo_molle,numero_molle FROM regole_molle WHERE nome_prodotto='".$rows[0]['nome_prodotto']."' and  da<='".$rows[0]['lunghezza']."' and a>='".$rows[0]['lunghezza']."';";				
				$select=$dbh->query($sql);
				
				$molle=$select->fetchAll();
				$sql="";
				
				$numero_molle=$molle[0]['numero_molle']*$rows[0]['quantita'];
				
			/*FINE REGOLE MOLLE*/	
			
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
			
				//MOLLE
			echo "<tr> 
				<td>".$molle[0]['ordine']."</td>			
				<td>".$molle[0]['codice_articolo_molle'] ."</td>			
				<td>Molle</td>			
				<td>".$numero_molle."</td>			
				<td>".$molle[0]['numero_molle']." molle per singolo prodotto assemblato</td>			
				</tr> ";
			if (!$diba_prod){
				inserisci_diba_produzione($ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$molle[0]['ordine'],$molle[0]['codice_articolo_molle'],'Molle','PZ',$molle[0]['numero_molle'],date("Ymd"));
			}
				
				//TESTATE
			echo "<tr>
				<td>".$diba[2]['ordine']."</td>			
				<td>".$diba[2]['codice_componente']."</td>			
				<td>".$diba[2]['descrizione_di_massima_componente']."</td>			
				<td>".$diba[2]['quantita']*$rows[0]['quantita']."</td>			
				<td>".$diba[2]['quantita']." testate per singolo prodotto assemblato</td>			
				</tr> ";
				
			if (!$diba_prod){
				inserisci_diba_produzione($ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$diba[2]['ordine'],$diba[2]['codice_componente'],$diba[2]['descrizione_di_massima_componente'],'PZ',$diba[2]['quantita'],date("Ymd"));
			}	

			//ETICHETTA LOGO TESTATA LS
			echo "<tr>
				<td>".$diba[3]['ordine']."</td>			
				<td>".$diba[3]['codice_componente']."</td>			
				<td>".$diba[3]['descrizione_di_massima_componente']."</td>			
				<td>".$diba[3]['quantita']*$rows[0]['quantita']."</td>			
				<td>".$diba[3]['quantita']." etichetta logo testata LS per singolo prodotto assemblato</td>			
				</tr> ";
			if (!$diba_prod){
				inserisci_diba_produzione($ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$diba[3]['ordine'],$diba[3]['codice_componente'],$diba[3]['descrizione_di_massima_componente'],'PZ',$diba[3]['quantita'],date("Ymd"));
			}	
				
			//FERMACAVO
			echo "<tr>
				<td>".$diba[4]['ordine']."</td>			
				<td>".$diba[4]['codice_componente']."</td>			
				<td>".$diba[4]['descrizione_di_massima_componente']."</td>			
				<td>".$diba[4]['quantita']*$rows[0]['quantita']."</td>			
				<td>".$diba[4]['quantita']." fermacavo per singolo prodotto assemblato</td>			
				</tr> ";
				
			if (!$diba_prod){
				inserisci_diba_produzione($ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$diba[4]['ordine'],$diba[4]['codice_componente'],$diba[4]['descrizione_di_massima_componente'],'PZ',$diba[4]['quantita'],date("Ymd"));
			}
			//VITE FERMACAVO
			echo "<tr>
				<td>".$diba[5]['ordine']."</td>			
				<td>".$diba[5]['codice_componente']."</td>			
				<td>".$diba[5]['descrizione_di_massima_componente']."</td>			
				<td>".$diba[5]['quantita']*$rows[0]['quantita']."</td>			
				<td>".$diba[5]['quantita']." vite fermacavo per singolo prodotto assemblato</td>			
				</tr> ";
				
			if (!$diba_prod){
				inserisci_diba_produzione($ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$diba[5]['ordine'],$diba[5]['codice_componente'],$diba[5]['descrizione_di_massima_componente'],'PZ',$diba[5]['quantita'],date("Ymd"));
			}
			
			//MOTORE LED
			motore_led($rows[0]['nome_prodotto'],$rows[0]['motore_led'],$rows[0]['id_tipo_luce'],$rows[0]['area_utile'],$rows[0]['quantita'],$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
			
			
			//CAVO CONNESSIONE ACCESSORI
			
			regole_accessori_fermacavo($rows[0]['nome_prodotto'],$rows[0]['id_accessorio'],$rows[0]['motore_led'],$rows[0]['quantita'],$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
			
			//ETICHETTA IMBALLO SINGOLO
				echo "<tr>
				<td>".$diba[6]['ordine']."</td>			
				<td>".$diba[6]['codice_componente']."</td>			
				<td>".$diba[6]['descrizione_di_massima_componente']."</td>			
				<td>".$diba[6]['quantita']*$rows[0]['quantita']."</td>			
				<td>".$diba[6]['quantita']." etichetta imballo singolo  per singolo imballo</td>			
				</tr> ";
			
			if (!$diba_prod){
				inserisci_diba_produzione($ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$diba[6]['ordine'],$diba[6]['codice_componente'],$diba[6]['descrizione_di_massima_componente'],'PZ',$diba[6]['quantita'],date("Ymd"));
			}
			//ETICHETTA IMBALLO MULTIPLO
			regole_etichette_imballo_multiplo($rows[0]['nome_prodotto'],$rows[0]['quantita'],10,$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine); //10 è il coefficente di utilizzo
			
			//ETICHETTA TARGA ENEC
				echo "<tr>
				<td>".$diba[8]['ordine']."</td>			
				<td>".$diba[8]['codice_componente']."</td>			
				<td>".$diba[8]['descrizione_di_massima_componente']."</td>			
				<td>".$diba[8]['quantita']*$rows[0]['quantita']."</td>			
				<td>".$diba[8]['quantita']." etichetta dati di targa (ENEC) per singolo prodotto assemblato</td>			
				</tr> ";
			if (!$diba_prod){
				inserisci_diba_produzione($ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$diba[8]['ordine'],$diba[8]['codice_componente'],$diba[8]['descrizione_di_massima_componente'],'PZ',$diba[8]['quantita'],date("Ymd"));
			}	
			
			//ETICHETTA MARCHIO ETL
				echo "<tr>
				<td>".$diba[9]['ordine']."</td>			
				<td>".$diba[9]['codice_componente']."</td>			
				<td>".$diba[9]['descrizione_di_massima_componente']."</td>			
				<td>".$diba[9]['quantita']*$rows[0]['quantita']."</td>			
				<td>".$diba[9]['quantita']." etichetta marchio ETL per singolo prodotto assemblato</td>			
				</tr> ";
			if (!$diba_prod){
				inserisci_diba_produzione($ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$diba[9]['ordine'],$diba[9]['codice_componente'],$diba[9]['descrizione_di_massima_componente'],'PZ',$diba[9]['quantita'],date("Ymd"));
			}	
			//ETICHETTA BANDIERA INCASSO ETL
				echo "<tr>
				<td>".$diba[10]['ordine']."</td>			
				<td>".$diba[10]['codice_componente']."</td>			
				<td>".$diba[10]['descrizione_di_massima_componente']."</td>			
				<td>".$diba[10]['quantita']*$rows[0]['quantita']."</td>			
				<td>".$diba[10]['quantita']." etichetta bandiera incasso ETL per singolo prodotto assemblato</td>			
				</tr> ";
			if (!$diba_prod){
				inserisci_diba_produzione($ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$diba[10]['ordine'],$diba[10]['codice_componente'],$diba[10]['descrizione_di_massima_componente'],'PZ',$diba[10]['quantita'],date("Ymd"));
			}
			//ETICHETTA BANDIERA PER CAVO ETL
				echo "<tr>
				<td>".$diba[11]['ordine']."</td>			
				<td>".$diba[11]['codice_componente']."</td>			
				<td>".$diba[11]['descrizione_di_massima_componente']."</td>			
				<td>".$diba[11]['quantita']*$rows[0]['quantita']."</td>			
				<td>".$diba[11]['quantita']." etichetta bandiera per cavo ETL per singolo prodotto assemblato</td>			
				</tr> ";
			if (!$diba_prod){
				inserisci_diba_produzione($ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$diba[11]['ordine'],$diba[11]['codice_componente'],$diba[11]['descrizione_di_massima_componente'],'PZ',$diba[11]['quantita'],date("Ymd"));
			}
			//ETICHETTA SELEZIONE COLORE
				echo "<tr>
				<td>".$diba[12]['ordine']."</td>			
				<td>".$diba[12]['codice_componente']."</td>			
				<td>".$diba[12]['descrizione_di_massima_componente']."</td>			
				<td>".$diba[12]['quantita']*$rows[0]['quantita']."</td>			
				<td>".$diba[12]['quantita']." etichetta selezione colore per singolo prodotto assemblato</td>			
				</tr> ";
			if (!$diba_prod){
				inserisci_diba_produzione($ordine_produzione,$riga_ordine,$rows[0]['codice_pf_finale'],$diba[12]['ordine'],$diba[12]['codice_componente'],$diba[12]['descrizione_di_massima_componente'],'PZ',$diba[12]['quantita'],date("Ymd"));
			}
			//FOGLI ISTRUZIONE
			
			regole_fogli_istruzione($rows[0]['nome_prodotto'],$rows[0]['id_accessorio'],$rows[0]['quantita'],$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
			
			//IMBALLI
			regole_imballi($rows[0]['nome_prodotto'],$rows[0]['quantita'],$rows[0]['lunghezza'],$diba_prod,$rows[0]['codice_pf_finale'],$ordine_produzione,$riga_ordine);
			
			//AGGIORNO LA TABELLA DI RICHIESTE DI PRODUZIONE PORTANDO IL VALORE AD 1
			$dbh->exec("UPDATE richieste_ordini_produzione SET processato=1 WHERE numero_ordine_cliente='".$e_val[0]."' and riga_ordine_cliente='".$e_val[1]."';");
		
		echo"	</tbody>
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