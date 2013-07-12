<?php
/** Include PHPExcel */
	require_once '../Excel_Classes/PHPExcel.php';
	require_once '../include/dbconfig.inc.php';
	
	date_default_timezone_set('Europe/Rome');
	$nome_file=trim($_POST['nome_file']);
	$query_sql="";
	
	#creo il file in funzione del destinatario... Per CODUTTI qualche cosa in più
	if ($nome_file=="configurati_per_Codutti"){
		$query_sql="	SELECT 	richieste_ordini_produzione.data_inserimento,
								storico_richieste.codice_cliente,
								richieste_ordini_produzione.nome_prodotto,
								richieste_ordini_produzione.codice_pf_finale,
								motore_led.descrizione_motore as Motore_Led,
								richieste_ordini_produzione.lunghezza as lunghezza_barra,								
								richieste_ordini_produzione.potenza_barra_led,								
								tipo_luce.tipo_luce as Temperatura_colore,
								accessori.descrizione as Accessorio,
								schermo.descrizione_schermo as Schermo,
								richieste_ordini_produzione.quantita as Quantita_richiesta,
								listino_configurati.prezzo_configurato,
								listino_configurati.prezzo_minimo_configurato,
								listino_configurati.prezzo_non_configurato

						FROM 	richieste_ordini_produzione,tipo_luce,schermo,accessori,motore_led,storico_richieste,listino_configurati
						WHERE 	
								tipo_luce.id_tipo_luce=richieste_ordini_produzione.id_tipo_luce
							AND	motore_led.codice_motore_led=richieste_ordini_produzione.motore_led
							AND	storico_richieste.ordine_cliente=richieste_ordini_produzione.numero_ordine_cliente
							AND storico_richieste.riga_ordine_cliente=richieste_ordini_produzione.riga_ordine_cliente
							AND accessori.id_accessorio=richieste_ordini_produzione.id_accessorio
							AND richieste_ordini_produzione.codice_schermo=schermo.codice_schermo
							AND	listino_configurati.nome_prodotto=richieste_ordini_produzione.nome_prodotto
							AND listino_configurati.nome_prodotto=storico_richieste.nome_prodotto
							
							AND richieste_ordini_produzione.lunghezza>=listino_configurati.da
							AND richieste_ordini_produzione.lunghezza<=listino_configurati.a
							AND richieste_ordini_produzione.id_accessorio=listino_configurati.id_accessorio";
	}else{
		$query_sql="	SELECT 	richieste_ordini_produzione.data_inserimento,
								storico_richieste.codice_cliente,
								richieste_ordini_produzione.nome_prodotto,
								richieste_ordini_produzione.codice_pf_finale,								
								motore_led.descrizione_motore as Motore_Led,
								richieste_ordini_produzione.lunghezza as lunghezza_barra,								
								richieste_ordini_produzione.potenza_barra_led,								
								tipo_luce.tipo_luce as Temperatura_colore,
								accessori.descrizione as Accessorio,
								schermo.descrizione_schermo as Schermo,
								richieste_ordini_produzione.quantita as Quantita_richiesta
								
						FROM 	richieste_ordini_produzione,tipo_luce,schermo,accessori,motore_led,storico_richieste
						WHERE 	
								tipo_luce.id_tipo_luce=richieste_ordini_produzione.id_tipo_luce
							AND	motore_led.codice_motore_led=richieste_ordini_produzione.motore_led
							AND	storico_richieste.ordine_cliente=richieste_ordini_produzione.numero_ordine_cliente
							AND storico_richieste.riga_ordine_cliente=richieste_ordini_produzione.riga_ordine_cliente
							AND accessori.id_accessorio=richieste_ordini_produzione.id_accessorio
							AND richieste_ordini_produzione.codice_schermo=schermo.codice_schermo";
	}
		
	$sql=$dbh->query($query_sql);

	$sql->execute();

	# con FETCH_ASSOC elimino l'array di array dall'oggetto generato da PDO ==> evito di campi doppi
	$analisi=$sql->fetchAll(PDO::FETCH_ASSOC);
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	$objWorksheet=$objPHPExcel->getActiveSheet();

	$riga=1;
	$col='A';
	# PRIMA RIGA CON INTESTAZIONE DEI CAMPI QUERY
	foreach ($analisi[0] as $key => $val){
		$objWorksheet->setCellValue($col.$riga,$key);
		$col++;
	}
	# MI POSIZIONO SULLA SECONDA RIGA
	$riga=2;
	foreach($analisi as $valore){
		$col='A';
		foreach ($valore as $key => $val){
			$objWorksheet->setCellValue($col.$riga, $val);
			$col++;
		}
		$riga++;
		
	}
	
	# STATISTICHE DI FREQUENZA  DA METTERE IN UN SECONDO FOGLIO
	$sql=$dbh->query("
						SELECT 	storico_richieste.nome_prodotto,
								storico_richieste.lunghezza, 
								count(storico_richieste.lunghezza) as Frequenza_lunghezza,
								SUM(richieste_ordini_produzione.quantita) as QTA_richiesta
						FROM 	storico_richieste,richieste_ordini_produzione
						WHERE 	storico_richieste.ordine_cliente=richieste_ordini_produzione.numero_ordine_cliente
							AND storico_richieste.riga_ordine_cliente=richieste_ordini_produzione.riga_ordine_cliente
						GROUP BY richieste_ordini_produzione.lunghezza
						ORDER BY Frequenza_lunghezza DESC
					");
	
	$sql->execute();
	# con FETCH_ASSOC elimino l'array di array dall'oggetto generato da PDO ==> evito di campi doppi
	$statistiche=$sql->fetchAll(PDO::FETCH_ASSOC);
	
	#AUMENTO LE RIGHE COSI ACCODO LE STATISTICHE
	$riga=$riga+5;
	$col='A';
	# PRIMA RIGA CON INTESTAZIONE DEI CAMPI QUERY
	foreach ($statistiche[0] as $key => $val){
		$objWorksheet->setCellValue($col.$riga,$key);
		$col++;
	}
	#
	$riga=$riga+1;
	foreach($statistiche as $valore){
		$col='A';
		foreach ($valore as $key => $val){
			$objWorksheet->setCellValue($col.$riga, $val);
			$col++;
		}
		$riga++;
		
	}
	
	
	
	
					
					
					
	// Set document properties
	$objPHPExcel->getProperties()->setCreator("Alessandro Fornasier")
							 ->setLastModifiedBy("Alessandro Fornasier")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

	// Rename worksheet
	$objPHPExcel->getActiveSheet()->setTitle('Dati Configuratore');


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);


	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$nome_file.'.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');

?>