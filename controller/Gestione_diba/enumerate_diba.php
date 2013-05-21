<?php
	include($_SERVER['DOCUMENT_ROOT']."/configuratore/include/dbconfig.inc.php");
	
	$page=isset($_POST['page']) ? intval($_POST['page']): 1;
	$rows=isset($_POST['rows']) ? intval($_POST['rows']): 10;
	
	$offset=($page-1)*$rows;
	$crud=array();
	$results=array();	
	
	$sql=$dbh->query("	SELECT 	diba_tecnica.codice_PF_finale,
								richieste_ordini_produzione.descrizione_pf_breve,
								diba_tecnica.ordine_cliente,
								diba_tecnica.riga_ordine_cliente
						FROM 	diba_tecnica,richieste_ordini_produzione
						WHERE 	richieste_ordini_produzione.codice_pf_finale =diba_tecnica.codice_pf_finale
						GROUP BY diba_tecnica.codice_PF_finale
					 ");
	$sql->execute();
	$result=$sql->fetchAll();
	
	$results["total"]=count($result);
	
	$sql="";
	$sql=$dbh->query("	SELECT 	diba_tecnica.codice_PF_finale,
								richieste_ordini_produzione.descrizione_pf_breve,
								diba_tecnica.ordine_cliente,
								diba_tecnica.riga_ordine_cliente
						FROM 	diba_tecnica,richieste_ordini_produzione
						WHERE 	richieste_ordini_produzione.codice_pf_finale =diba_tecnica.codice_pf_finale
						GROUP BY diba_tecnica.codice_PF_finale
						LIMIT  ".$offset.",".$rows.";
					 ");
	$sql->execute();
	$analisi=$sql->fetchAll();
	
	
	foreach($analisi as $row){
	
		array_push($crud, $row);  
	}  
	$results["rows"]=$crud;
	
	echo json_encode($results);  
?>