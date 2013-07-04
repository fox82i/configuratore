<?php
	include("../include/dbconfig.inc.php");
	
	$page=isset($_POST['page']) ? intval($_POST['page']): 1;
	$rows=isset($_POST['rows']) ? intval($_POST['rows']): 10;
	$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'codice_pf_finale';  
	$order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';  
	
	$codice_articolo = isset($_POST['codice_articolo']) ? ($_POST['codice_articolo']) : '';
	
	$offset=($page-1)*$rows;
	$crud=array();
	$results=array();	
	
	#stringa where per la ricerca di prodotti specifici
	$where_ricerca = "richieste_ordini_produzione.codice_pf_finale like '%$codice_articolo%' ";
	
	
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
							AND ".$where_ricerca.";
							
						
					 ");
	$sql->execute();
	$result=$sql->fetchAll();
	
	$results["total"]=count($result);
	
	$sql="";
	$sql=$dbh->query("	
						SELECT 	richieste_ordini_produzione.codice_pf_finale,
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
								AND ".$where_ricerca."
						
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