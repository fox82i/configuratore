<?php
// ordini clienti
	include("../include/dbconfig.inc.php");
	
	
	header("Content-type: text/xml");
	echo "<?xml version=\"1.0\" ?>\n";
	echo "<ordini>\n";
	$select = "SELECT ordine_cliente FROM diba_produzione GROUP BY ordine_cliente";
	try {
		foreach($dbh->query($select) as $row) {
			echo "<ordine><codice>".$row['ordine_cliente']."</codice></ordine>\n";
		}
	}
	catch(PDOException $e) {
		echo $e->getMessage();
		die();
	}

	
	echo "</ordini>";
?>