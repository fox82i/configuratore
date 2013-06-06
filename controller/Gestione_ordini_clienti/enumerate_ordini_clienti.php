<?php
	include($_SERVER['DOCUMENT_ROOT']."/configuratore/include/dbconfig.inc.php");
	
	$page=isset($_POST['page']) ? intval($_POST['page']): 1;
	$rows=isset($_POST['rows']) ? intval($_POST['rows']): 10;
	$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'data_inserimento';  
	$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';  
	
	$ordine_cliente = isset($_POST['ordine']) ? ($_POST['ordine']) : '';
	
	$offset=($page-1)*$rows;
	$crud=array();
	$results=array();	
	
	#stringa where per la ricerca di prodotti specifici
	$where_ricerca = "numero_ordine_cliente like '%$ordine_cliente%' ";
	
	
	$sql=$dbh->query("	SELECT 	*
						FROM 	richieste_ordini_produzione
						WHERE 	".$where_ricerca."
							AND processato=0;
						
					 ");
	$sql->execute();
	$result=$sql->fetchAll();
	
	$results["total"]=count($result);
	
	$sql="";
	$sql=$dbh->query("	SELECT 	data_inserimento,
								numero_ordine_cliente,
								riga_ordine_cliente,
								codice_PF_finale,
								descrizione_pf_breve
						FROM 	richieste_ordini_produzione
						WHERE 	".$where_ricerca."
							AND processato=0
						ORDER BY ".$sort." ".$order."
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