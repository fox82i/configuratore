<?php
	//motore led
	
	include("../include/dbconfig.inc.php");
	header("Content-type: text/xml");
	
	if (isset($_POST['man'])){
		
		$ordine_cliente = $_POST['man'];//ordine cliente
	
		$select = "SELECT riga_ordine_cliente  FROM diba_produzione WHERE ordine_cliente = '".$ordine_cliente."' GROUP BY riga_ordine_cliente  ORDER BY riga_ordine_cliente ASC";
	

		echo "<?xml version=\"1.0\" ?>\n
				<Righe>\n";
		try {
			foreach($dbh->query($select) as $row) {
				echo "<Riga><valore>".$row['riga_ordine_cliente']."</valore></Riga>\n";
			}
		}
		catch(PDOException $e) {
			echo $e->getMessage();
			die();
		}
		echo "</Righe>";
		}else{
			echo "<?xml version=\"1.0\" ?>\n
				<Righe>\n
				<Riga><valore>Nessun valore</valore></Riga>\n
				</Righe>";
			}
		
	
?>