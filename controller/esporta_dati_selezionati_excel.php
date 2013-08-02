<?php
	#$dati=$_REQUEST['dati_riga'];
	
	require_once '../Excel_Classes/PHPExcel.php';
	date_default_timezone_set('Europe/Rome');
	
	#decodifico il vettore JSON
	$dati= json_decode($_REQUEST['dati_excel']);
	
	//$dati_prodotto = preg_split("/\|/",$dati);
	//	print_r($dati);
	
	
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	$objWorksheet=$objPHPExcel->getActiveSheet();
	
	$riga=1;
	$col='A';
	
	//intestazioni di colonna: Non sapendo quante colonne vengono passate generalizzo l'estrazione delle intestazioni
	foreach ($dati[0] as $key => $val){
		$objWorksheet->setCellValue($col.$riga,$key);
		$col++;
	}
	# MI POSIZIONO SULLA SECONDA RIGA
	$riga=2;
	foreach($dati as $valore){
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
	$objPHPExcel->getActiveSheet()->setTitle('Dati etichette');


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);


	// Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename=dati_etichette.xlsx');
	header('Cache-Control: max-age=0');

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	
	
?>