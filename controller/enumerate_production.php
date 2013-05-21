<?php

	
	$select=$dbh->query("	SELECT (numero_ordine_cliente) as Ordine_cliente, (riga_ordine_cliente)as Riga_ordine,(data_inserimento)as Data_ordine, nome_prodotto 
							FROM richieste_ordini_produzione WHERE processato=0 
							ORDER BY CAST(numero_ordine_cliente as SIGNED) asc, riga_ordine_cliente ASC;");
	$res=$select->fetchAll();
	
	if (count($res)>0){
		echo"
			<form id=\"aForm2\">
			<label>
			Seleziona il tipo di visualizzazione ordini lavorazione meccanica:<br/>
			<input type=\"radio\" name=\"tipo_view\" value=\"old\" checked> Ordine produzione attuale<br>
			<input type=\"radio\" name=\"tipo_view\" value=\"new\" > Ordine produzione nuovo<br>
			</label>
			<br/><br/>
			<table border=\"1\">
				<caption><strong> Lista richieste di produzione articoli personalizzati</strong></caption>
				<thead>
				<tr>	
					<th>Seleziona ordine</th>
					<th>Odine Cliente</th>
					<th>Riga Odine Cliente</th>
					<th>Data Ordine</th>
					<th>Nome Prodotto</th>
					
				</tr>
				</thead>
				<tbody>
			";
			foreach ($res as $row){
				echo "<tr>";
				echo "<td><input type=\"checkbox\" name=\"ordine_produzione[]\" value='".$row['Ordine_cliente']."-".$row['Riga_ordine']."' ></td>
						<td>".$row['Ordine_cliente']."</td>
						<td>".$row['Riga_ordine']."</td>
						<td>".$row['Data_ordine']."</td>
						<td>".$row['nome_prodotto']."</td>";
				echo "</tr>";
			}
		echo"	</tbody>
				</table>
				<input type=\"button\" name=\"Send\" value=\"Send\" onclick=\"javascript: formget(this.form, 'controller/esegui_produzione.php','output');\">
				</form>
		
		";
	}else{
		echo "<p><strong>No ordini da processare in produzione</strong> </p>";
	}
?>