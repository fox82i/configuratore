<?php
// prodotti lineari
	include("../include/dbconfig.inc.php");
	
	
	header("Content-type: text/xml");
	echo "<?xml version=\"1.0\" ?>\n";
	echo "<prodotti>\n";
	$select = "SELECT nome_prodotto FROM prodotti_lineari WHERE obsoleta='0' GROUP BY nome_prodotto";
	try {
		foreach($dbh->query($select) as $row) {
			echo "<Prodotto><name>".$row['nome_prodotto']."</name>\n</Prodotto>\n";
		}
	}
	catch(PDOException $e) {
		echo $e->getMessage();
		die();
	}

	
	echo "</prodotti>";
?>