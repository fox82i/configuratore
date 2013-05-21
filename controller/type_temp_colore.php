<?php
// list of printer types for specific manufacturer
	
	include("../include/dbconfig.inc.php");

	header("Content-type: text/xml");

	$motore_led = $_POST['mot'];//mot
	

	echo "<?xml version=\"1.0\" ?>\n";
	echo "<Colori>\n";
/*
	$select = "SELECT tipo_luce.id_tipo_luce, CONCAT_WS(  ' ', tipo_luce.temperatura_colore, tipo_luce.tipo_luce) as descrittivo 
			FROM anagrafica_barre_led,tipo_luce 
			WHERE anagrafica_barre_led.id_tipo_luce=tipo_luce.id_tipo_luce and anagrafica_barre_led.codice_motore_led='".$motore_led."' GROUP BY tipo_luce.id_tipo_luce
			;";*/
	$select = "SELECT tipo_luce.id_tipo_luce, tipo_luce.tipo_luce as descrittivo 
			FROM anagrafica_barre_led,tipo_luce 
			WHERE anagrafica_barre_led.id_tipo_luce=tipo_luce.id_tipo_luce and anagrafica_barre_led.codice_motore_led='".$motore_led."' 
			GROUP BY tipo_luce.id_tipo_luce
			ORDER BY tipo_luce.temperatura_colore;
			";
	
	try {
		foreach($dbh->query($select) as $row) {
			echo "<Colore>\n\t<id>".$row['id_tipo_luce']."</id>\n\t<name>".$row['descrittivo']."</name>\n</Colore>\n";
			//fwrite($fp, "man = ".$man." typ = ".$typ." model = ".$row['model_text']."\n");
		}
	}
	catch(PDOException $e) {
		echo $e->getMessage();
		die();
	}
	echo "</Colori>";
?>