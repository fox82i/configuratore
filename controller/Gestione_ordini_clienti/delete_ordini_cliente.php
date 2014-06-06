<?php

	include("../../include/dbconfig.inc.php");

	$ordine_cliente=$_REQUEST['ordine_cliente'];
	$riga_ordine=$_REQUEST['riga_ordine'];
	
	//cancello le info dallo storico, altrimenti "inquino" i dati statistici
	$query1="	DELETE
				FROM storico_richieste
				WHERE 	ordine_cliente='".$ordine_cliente."'
					AND riga_ordine_cliente='".$riga_ordine."';";
	
	//cancello la richiesta di produzione
	$query2="	DELETE
				FROM richieste_ordini_produzione
				WHERE 	numero_ordine_cliente='".$ordine_cliente."'
					AND riga_ordine_cliente='".$riga_ordine."';";
	
	try{
	
		$dbh->beginTransaction();	
		
		if($dbh->exec($query1)){
			if($dbh->exec($query2)){
				$dbh->commit();					
				echo json_encode(array('success'=>true));  					
			}else{
				echo json_encode(array('success'=>false,'errorMsg'=>"Richiesta di produzione non eliminata per questo ordine cliente: ".$ordine_cliente." e riga ".$riga_ordine));  
			}
		}else{
			echo json_encode(array('success'=>false,'errorMsg'=>"Storico richieste non cancellato per questo ordine cliente: ".$ordine_cliente." e riga ".$riga_ordine));  
		}
	
	}catch(Exception $e){
		$dbh->rollBack();	
		echo json_encode(array('success'=>false,'errorMsg'=>$e->getMessage()));  
	}
?>