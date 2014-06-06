<?php
	include("../include/dbconfig.inc.php");
	
	include("supporto_produzione.php");
	
	$ordine_cliente=$_POST['ordine_cliente'];
	$riga_ordine_cliente=$_POST['riga_ordine_cliente'];
	if($_POST['tipo_view']=='tecnica'){
	
		$select=$dbh->query("	SELECT * 
								FROM diba_tecnica
								WHERE ordine_cliente='".$ordine_cliente."' and riga_ordine_cliente='".$riga_ordine_cliente."'
								ORDER BY posizione_diba ASC;");
		$res=$select->fetchAll();
	
		$select_articolo=$dbh->query("	SELECT codice_pf_finale,descrizione_pf,descrizione_pf_breve ,quantita
										FROM richieste_ordini_produzione 
										WHERE numero_ordine_cliente='".$ordine_cliente."' 
										AND	 riga_ordine_cliente='".$riga_ordine_cliente."';");
										
		$articolo=$select_articolo->fetchAll();
	
		if (count($res)>0){
			echo"
				<p>
					<strong>Codice articolo:</strong> ".$articolo[0]['codice_pf_finale']." <br/>
					<strong>Descrizione articolo breve:</strong> ".$articolo[0]['descrizione_pf_breve']." <br/>
					<strong>Descrizione articolo estesa:</strong> ".$articolo[0]['descrizione_pf']." <br/>
					<strong>Quanti&agrave; ordinata:</strong> ".$articolo[0]['quantita']."
				</p>
				<table border=\"1\">
					<caption><strong> DiBa tecnica per 1 pezzo </strong></caption>
					<thead>
						<tr>	
							<th>Posizione Diba</th>
							<th>Codice componente</th>
							<th>Descrizione componente</th>	
							<th>UM</th>
							<th>Quantit&agrave;</th>					
						</tr>
					</thead>
					<tbody>
			";
			foreach ($res as $row){
				echo "<tr>";
				echo "
						<td>".$row['posizione_diba']."</td>
						<td>".$row['codice_componente']."</td>
						<td>".$row['descrizione_componente']."</td>
						<td>".$row['UM']."</td>
						<td>".$row['qta']."</td>";
				echo "</tr>";
			}
			echo"	</tbody>
				</table>
				";
		}else{
			echo "<p><strong>Nessuna DiBa tecnica selezionata</strong> </p>";
		}
	}else{ //DIBA PRODUZIONE
		$select=$dbh->query("	SELECT * 
								FROM diba_produzione 
								WHERE ordine_cliente='".$ordine_cliente."' and riga_ordine_cliente='".$riga_ordine_cliente."'
								ORDER BY posizione_diba ASC;");
		$res=$select->fetchAll();
	
		$select_articolo=$dbh->query("	SELECT codice_pf_finale,descrizione_pf,descrizione_pf_breve ,quantita
										FROM richieste_ordini_produzione 
										WHERE numero_ordine_cliente='".$ordine_cliente."' 
										AND	 riga_ordine_cliente='".$riga_ordine_cliente."';");
		$articolo=$select_articolo->fetchAll();
	
		if (count($res)>0){
			echo"
				<p>
					<strong>Codice articolo:</strong> ".$articolo[0]['codice_pf_finale']." <br/>
					<strong>Descrizione articolo breve:</strong> ".$articolo[0]['descrizione_pf_breve']." <br/>
					<strong>Descrizione articolo estesa:</strong> ".$articolo[0]['descrizione_pf']." <br/>
					<strong>Quanti&agrave; ordinata:</strong> ".$articolo[0]['quantita']."
				</p>
				<table border=\"1\">
					<caption><strong> DiBa produzione totale </strong></caption>
					<thead>
						<tr>	
							
							<th>Codice componente</th>		
							<th>Quantit&agrave;</th>	
							<th>UM</th>
							<th>T</th>
							<th>O</th>				
						</tr>
					</thead>
					<tbody>
			";
			foreach ($res as $row){
				echo "<tr>";
				echo "
						
						<td>".$row['codice_componente']."</td>		
						<td>".$row['qta']."</td>
						<td>".$row['UM']."</td>
						<td>L</td>
						<td>0010</td>
						";
				echo "</tr>";
			}
			echo"	</tbody>
				</table>
				";
		}else{
			echo "<p><strong>Nessuna DiBa di produzione selezionata</strong> </p>";
		}
		
	}
?>