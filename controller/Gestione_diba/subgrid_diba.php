<?php
	include($_SERVER['DOCUMENT_ROOT']."/configuratore/include/dbconfig.inc.php");

	$codice_PF=$_REQUEST["codice_PF"];
	
		$items=array();

		if ($query=$dbh->query("SELECT 	posizione_diba,
										codice_componente,
										descrizione_componente,
										UM,
										qta
								FROM 	diba_tecnica
								WHERE 	codice_PF_finale='".$codice_PF."'
								ORDER BY posizione_diba ASC;
								")){
										$query->execute();
										$diba=$query->fetchAll();
										foreach ($diba as $row) {
											array_push($items, $row);
										}
										echo json_encode($items);

								}
?>