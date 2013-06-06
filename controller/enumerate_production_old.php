<?php
	include("../include/dbconfig.inc.php");
   	
	$page=isset($_POST['page']) ? intval($_POST['page']): 1;
	$rows=isset($_POST['rows']) ? intval($_POST['rows']): 10;

	$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'numero_ordine_cliente';  
	$order = isset($_POST['order']) ? strval($_POST['order']) : 'ASC';  

	# nella seconda parte del confronto ci andrebbe mysql_real_escape_string da trovare un metodo con PDO migliore
	$numero_ordine_cliente_to_find = isset($_POST['numero_ordine_cliente_to_find']) ? ($_POST['numero_ordine_cliente_to_find']) : '';
	
	
	
	$offset=($page-1)*$rows;
	$crud=array();
	$results=array();	
	
	#stringa where per la ricerca di prodotti specifici
	$where_ricerca = "numero_ordine_cliente like '$numero_ordine_cliente_to_find%' ";
	

	$sql=$dbh->query("	SELECT 	numero_ordine_cliente , 
								riga_ordine_cliente,
								data_inserimento,
								nome_prodotto 
						FROM richieste_ordini_produzione							
						WHERE processato=0 and ".$where_ricerca."	
					 ");
	$sql->execute();
	$result=$sql->fetchAll();
	
	$results["total"]=count($result);
	
	$sql="";
	$sql=$dbh->query("	SELECT 	numero_ordine_cliente, 
								riga_ordine_cliente,
								data_inserimento, 
								nome_prodotto,
								descrizione_pf
						FROM richieste_ordini_produzione							
						WHERE processato=0 and ".$where_ricerca."	
						ORDER BY ".$sort." ".$order." , riga_ordine_cliente ASC					
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