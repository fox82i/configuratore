<?php
/** Include PHPExcel */
	require_once '../Excel_Classes/PHPExcel.php';
	require_once '../include/dbconfig.inc.php';
	#$nome_file=trim($_POST['nome_file']));
	
	$nome_file='prova';
	
	$sql=$dbh->query("	SELECT 	richieste_ordini_produzione.codice_pf_finale,
								richieste_ordini_produzione.motore_led,
								(CASE id_accessorio WHEN 1 THEN '' WHEN 2 THEN 'D' WHEN 3 THEN 'S' END) as  tipo_di_touch_led,
								richieste_ordini_produzione.tensione_alimentazione,
								richieste_ordini_produzione.potenza_barra_led,
								richieste_ordini_produzione.lunghezza,
								tipo_luce.tipo_luce as Temperatura_colore,
								left(tipo_luce.codifica_temperatura,1)as K_abbreviato 
						FROM 	richieste_ordini_produzione,tipo_luce 
						WHERE 	
								tipo_luce.id_tipo_luce=richieste_ordini_produzione.id_tipo_luce
					");

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
	#
	$riga=2;
	foreach($analisi as $valore){
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
	$objPHPExcel->getActiveSheet()->setTitle('Dati Etichette');


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);


	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$nome_file.'.xlsx"');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');

?>