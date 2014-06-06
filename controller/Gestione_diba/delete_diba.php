<?php

	include("../../include/dbconfig.inc.php");

	
	$codice_PF=$_REQUEST['codice_PF'];
	$ordine_cliente=$_REQUEST['ordine_cliente'];
	$riga_ordine=$_REQUEST['riga_ordine'];
	
	//cancello la diba dalla tabella di produzione
	$query1="	DELETE
				FROM diba_produzione
				WHERE codice_PF_finale='".$codice_PF."';";
	//cancello la diba dalla tabella tecnica
	$query2="	DELETE
				FROM diba_tecnica
				WHERE codice_PF_finale='".$codice_PF."';";
		
	//risetto il valore a 0 per rieseguire la produzione
	$query3="	UPDATE richieste_ordini_produzione
				SET processato=0
				WHERE codice_pf_finale='".$codice_PF."';";
	
	try{
	
		$dbh->beginTransaction();	
		
		#$query=$dbh->prepare($query1);
		if($dbh->exec($query1)){
			#$dbh->commit();
		#	$query=$dbh->prepare($query3);
	
			if($dbh->exec($query2)){
				#$dbh->commit();
				#$query=$dbh->prepare($query2);				
				if($dbh->exec($query3)){
					$dbh->commit();					
					echo json_encode(array('success'=>true));  					
				}else{						
					echo json_encode(array('success'=>false,'errorMsg'=>"Valore processato non aggiornato per questo ordine cliente:".$ordine_cliente." e riga ".$riga_ordine));  
				}
			}else{
				echo json_encode(array('success'=>false,'errorMsg'=>"Diba tecnica non cancellata per questo ordine cliente: ".$ordine_cliente." e riga ".$riga_ordine));  
			}
		}else{
			echo json_encode(array('success'=>false,'errorMsg'=>"Diba produzione non cancellata per questo ordine cliente: ".$ordine_cliente." e riga ".$riga_ordine));  
		}
	}catch(Exception $e){
		$dbh->rollBack();	
		echo json_encode(array('success'=>false,'errorMsg'=>$e->getMessage()));  
	}
?>