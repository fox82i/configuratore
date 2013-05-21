<?php
	//motore led
	
	include("../include/dbconfig.inc.php");
	header("Content-type: text/xml");
	$nome_prodotto="";
	
	$nome_prodotto = $_POST['man'];//prodotto lineare

	$select = "SELECT motore_led.codice_motore_led, motore_led.descrizione_motore FROM motore_led,prodotto_lineare_motore_led WHERE prodotto_lineare_motore_led.prodotto_lineare = '".$nome_prodotto."' 
			and prodotto_lineare_motore_led.motore_led=motore_led.codice_motore_led ";
	

	echo "<?xml version=\"1.0\" ?>\n
			<MotoriLed>\n";
	try {
		foreach($dbh->query($select) as $row) {
			echo "<MotoreLed>\n\t<id>".$row['codice_motore_led']."</id>\n\t<name>".$row['descrizione_motore']."</name>\n</MotoreLed>\n";
		}
	}
	catch(PDOException $e) {
		echo $e->getMessage();
		die();
	}
		echo "</MotoriLed>";
?>