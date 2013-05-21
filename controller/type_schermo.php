<?php
	//motore led
	
	include("../include/dbconfig.inc.php");
	header("Content-type: text/xml");
	$nome_prodotto="";
	
	$nome_prodotto = $_POST['man'];//prodotto lineare

	$select = "	SELECT schermo.codice_schermo, schermo.descrizione_schermo 
				FROM schermo, prodotto_lineare_schermo
				WHERE 	prodotto_lineare_schermo.prodotto_lineare='".$nome_prodotto."' AND
						prodotto_lineare_schermo.codice_schermo=schermo.codice_schermo;";
	

	echo "<?xml version=\"1.0\" ?>\n
			<Schermi>\n";
	try {
		foreach($dbh->query($select) as $row) {
			echo "<Colore_schermo>\n\t<id>".$row['codice_schermo']."</id>\n\t<name>".$row['descrizione_schermo']."</name>\n</Colore_schermo>\n";
		}
	}
	catch(PDOException $e) {
		echo $e->getMessage();
		die();
	}
		echo "</Schermi>";
?>