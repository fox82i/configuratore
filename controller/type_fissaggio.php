<?php
	//motore led
	
	include("../include/dbconfig.inc.php");
	header("Content-type: text/xml");
	$nome_prodotto="";
	
	$nome_prodotto = $_POST['man'];//prodotto lineare

	
		$select = "	SELECT regole_sistema_fissaggio.tipo_fissaggio,tipo_fissaggio.descrizione_fissaggio
					FROM tipo_fissaggio,regole_sistema_fissaggio
					WHERE regole_sistema_fissaggio.nome_prodotto='".$nome_prodotto."' AND
						regole_sistema_fissaggio.tipo_fissaggio=tipo_fissaggio.codice_fissaggio
					GROUP BY regole_sistema_fissaggio.tipo_fissaggio";
	

	echo "<?xml version=\"1.0\" ?>\n
			<Fissaggi>\n";
	try {
		foreach($dbh->query($select) as $row) {
			echo "<Fissaggio>\n\t<id>".$row['tipo_fissaggio']."</id>\n\t<name>".$row['descrizione_fissaggio']."</name>\n</Fissaggio>\n";
		}
	}
	catch(PDOException $e) {
		echo $e->getMessage();
		die();
	}
		echo "</Fissaggi>";
?>