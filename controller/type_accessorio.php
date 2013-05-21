<?php
// list of printer types for specific manufacturer
	include("../include/dbconfig.inc.php");
	
	header("Content-type: text/xml");

	$nome_prodotto = $_POST['man'];//man

	echo "<?xml version=\"1.0\" ?>\n";
	echo "<Accessori>\n";
	$select = "SELECT accessori.id_accessorio,accessori.descrizione FROM accessori,prodotto_lineare_accessori 
				WHERE prodotto_lineare_accessori.prodotto_lineare='".$nome_prodotto."' and accessori.id_accessorio=prodotto_lineare_accessori.id_accessorio";
	
	try {
		foreach($dbh->query($select) as $row) {
			echo "<Accessorio>\n\t<id>".$row['id_accessorio']."</id>\n\t<name>".$row['descrizione']."</name>\n</Accessorio>\n";
		}
	}
	catch(PDOException $e) {
		echo $e->getMessage();
		die();
	}
	
	echo "</Accessori>";
?>