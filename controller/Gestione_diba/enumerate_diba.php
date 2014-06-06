<?php
	include("../../include/dbconfig.inc.php");
	
	$page=isset($_POST['page']) ? intval($_POST['page']): 1;
	$rows=isset($_POST['rows']) ? intval($_POST['rows']): 10;
	$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'codice_PF_finale';  
	$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';  
	
	
	
	$codice_PF_finale = isset($_POST['codice_PF']) ? ($_POST['codice_PF']) : '';
	$ordine_cliente = isset($_POST['ordine']) ? ($_POST['ordine']) : '';
	
	$offset=($page-1)*$rows;
	$crud=array();
	$results=array();	
	
	#stringa where per la ricerca di prodotti specifici
	$where_ricerca = "diba_tecnica.codice_PF_finale like '%$codice_PF_finale%' and diba_tecnica.ordine_cliente like '%$ordine_cliente%' ";
	
	
	$sql=$dbh->query("	SELECT 	diba_tecnica.codice_PF_finale,
								richieste_ordini_produzione.descrizione_pf_breve,
								diba_tecnica.ordine_cliente,
								diba_tecnica.riga_ordine_cliente
						FROM 	diba_tecnica,richieste_ordini_produzione
						WHERE 	richieste_ordini_produzione.codice_pf_finale =diba_tecnica.codice_pf_finale
							AND	".$where_ricerca."
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
							AND	".$where_ricerca."
						GROUP BY diba_tecnica.codice_PF_finale
						ORDER BY diba_tecnica.".$sort." ".$order.", diba_tecnica.riga_ordine_cliente asc
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