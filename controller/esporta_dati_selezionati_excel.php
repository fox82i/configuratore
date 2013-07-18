<?php
	#$dati=$_REQUEST['dati_riga'];
	
	require_once '../Excel_Classes/PHPExcel.php';
	date_default_timezone_set('Europe/Rome');
	
	
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	$objWorksheet=$objPHPExcel->getActiveSheet();
	
	//intestazioni di colonna
	$objWorksheet->setCellValue('A1','Codice pf finale');
	$objWorksheet->setCellValue('B1','Tipo di barra LED');
	$objWorksheet->setCellValue('C1','Tipo di touch led');
	$objWorksheet->setCellValue('D1','Lunghezza lampada');
	$objWorksheet->setCellValue('E1','Temperatura colore');
	$objWorksheet->setCellValue('F1','Tensione alimentazione');
	$objWorksheet->setCellValue('G1','Potenza barra led');
	$objWorksheet->setCellValue('H1','K abbreviato');
	
	
	
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