<?php

	function taglio_profili($materiale,$posizione_distinta,$lunghezza_verga,$lunghezza_prodotto_cliente,$quantita,$ingombro_fisso,$descrittivo_profilo,$descrittivo_colonna,$diba_prod,$pf_finale,$ordine_cliente,$riga_ordine){
		$taglio=($lunghezza_prodotto_cliente-$ingombro_fisso);
		$numero_schermi_per_verga=floor($lunghezza_verga/$taglio);
		$numero_schermi_per_verga_aggiuntiva=0;
		$sfrido_per_verga_aggiuntiva=0;
		$pezzi=round((($lunghezza_prodotto_cliente-$ingombro_fisso)/$lunghezza_verga)*$quantita,2);
			
		if ($numero_schermi_per_verga>=$quantita){ //CASO IN CUI con una verga produco quanto richiesto
			$numero_verghe=1;
			$numero_schermi_per_verga=$quantita;
			$sfrido_per_verga=$lunghezza_verga-($numero_schermi_per_verga*$taglio);
			echo "<br/><table border=\"1\">
					<caption><strong>".$descrittivo_profilo."	</strong></caption>
						<thead>
							<tr>
								<th>Posizione</th>
								<th>Materiale</th>
								<th>".$descrittivo_colonna." </th>
								<th>Numero profili per verga </th>									
								<th>Lunghezza profilo (mm)</th>
								<th>Sfrido (mm)</th>								
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>".$posizione_distinta."</td>
								<td>".$materiale."</td>	
								<td>".$numero_verghe."</td>
								<td>".$numero_schermi_per_verga."</td>
								<td>".$taglio."</td>
								<td>".$sfrido_per_verga."</td>
							</tr>	
						</tbody>
						</table>";		
			if (!$diba_prod){
				//se al posto dei pezzi voglio mettere il numero esatto di verghe decommentare la riga sucessiva e commentare la riga dei pezzi
				#inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'PZ',$numero_verghe,date("Ymd"));
				inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'PZV',$pezzi,date("Ymd"));
				inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'MM',$taglio,date("Ymd"));
			}
		}else{								
			$numero_verghe=round(($quantita/$numero_schermi_per_verga),0);
			$sfrido_per_verga=$lunghezza_verga-($numero_schermi_per_verga*$taglio);
						
			if (($numero_verghe*$numero_schermi_per_verga)>$quantita){
				$numero_verghe=floor($quantita/$numero_schermi_per_verga);
				$verga_aggiuntiva=1;
				
				$numero_schermi_per_verga_aggiuntiva=$quantita-($numero_verghe*$numero_schermi_per_verga);
				$sfrido_per_verga_aggiuntiva=$lunghezza_verga-($taglio*$numero_schermi_per_verga_aggiuntiva);
				echo "<br/><table border=\"1\">
						<caption><strong>".$descrittivo_profilo."	</strong></caption>
							<thead>
								<tr>
									<th>Posizione</th>
									<th>Materiale</th>
									<th>".$descrittivo_colonna." </th>
									<th>Numero profili per verga </th>									
									<th>Lunghezza profilo (mm)</th>
									<th>Sfrido (mm)</th>
									
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>".$posizione_distinta."</td>
									<td>".$materiale."</td>	
									<td>".$numero_verghe."</td>
									<td>".$numero_schermi_per_verga."</td>
									<td>".$taglio."</td>
									<td>".$sfrido_per_verga."</td>
								</tr>	";
							echo "<tr>
									<td>".$posizione_distinta."</td>
									<td>".$materiale."</td>	
									<td>".$verga_aggiuntiva."</td>
									<td>".$numero_schermi_per_verga_aggiuntiva."</td>
									<td>".$taglio."</td>
									<td>".$sfrido_per_verga_aggiuntiva."</td>
								</tr>	";
								echo"</tbody>
						</table>";
				if (!$diba_prod){
					//se al posto dei pezzi voglio mettere il numero esatto di verghe decommentare la riga sucessiva e commentare la riga dei pezzi
					#inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'PZ',$numero_verghe+$verga_aggiuntiva,date("Ymd"));
					inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'PZV',$pezzi,date("Ymd"));
					inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'MM',$taglio,date("Ymd"));
				}
			}else{
				echo "<br/><table border=\"1\">
					<caption><strong>".$descrittivo_profilo."	</strong></caption>
							<thead>
								<tr>
									<th>Posizione</th>
									<th>Materiale</th>
									<th>".$descrittivo_colonna." </th>
									<th>Numero profili per verga </th>									
									<th>Lunghezza profilo (mm)</th>
									<th>Sfrido (mm)</th>
									
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>".$posizione_distinta."</td>
									<td>".$materiale."</td>	
									<td>".$numero_verghe."</td>
									<td>".$numero_schermi_per_verga."</td>
									<td>".$taglio."</td>
									<td>".$sfrido_per_verga."</td>
								</tr>
							</tbody>
						</table>";	
						if (!$diba_prod){
							//se al posto dei pezzi voglio mettere il numero esatto di verghe decommentare la riga sucessiva e commentare la riga dei pezzi
							#inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'PZ',$numero_verghe,date("Ymd"));
							inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'PZV',$pezzi,date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'MM',$taglio,date("Ymd"));
						}
				}
			}
	}
	function taglio_profili2($materiale,$posizione_distinta,$lunghezza_profilo,$lunghezza_prodotto_cliente,$quantita,$ingombro_fisso,$descrittivo_profilo,$descrittivo_colonna,$diba_prod,$pf_finale,$ordine_cliente,$riga_ordine){
		
		$pezzi=round((($lunghezza_prodotto_cliente-$ingombro_fisso)/$lunghezza_profilo)*$quantita,2);
		$taglio=($lunghezza_prodotto_cliente-$ingombro_fisso);
		
		echo "<br/><table border=\"1\">
						<caption><strong>".$descrittivo_profilo."	</strong></caption>
							<thead>
								<tr>
									<th>Posizione</td>
									<th>Materiale</td>
									<th>".$descrittivo_colonna." </td>									
									<th>Numero profili</td>
									<th>Lunghezza profilo (mm)</td>
								
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>".$posizione_distinta."</td>
									<td>".$materiale."</td>									
									<td>".$pezzi."</td>
									<td>".$quantita."</td>
									<td>".$taglio."</td>
								</tr>
							</tbody>
						</table>";
			if (!$diba_prod){
				// se si vuole far comparire in distinta i pezzi al posto dei MM allora aporre PZ al posto di MM e poi mettere la formula: round(($pezzi/$quantita),3)
				inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'PZV',$pezzi,date("Ymd"));
				inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'MM',$taglio,date("Ymd"));
			}
	}	
	//visualizzo ordine di produzione in pezzi
	function supporto_reel($motore_led,$materiale,$posizione_distinta,$lunghezza_profilo,$area_utile,$quantita,$descrittivo_profilo,$descrittivo_colonna,$diba_prod,$pf_finale,$ordine_cliente,$riga_ordine){
		$taglio=0;
		$pezzi=0;
		
		switch ($motore_led){//IN FUNZIONE DEL MOTORE LED DETERMINO TAGLIO E PEZZI
			case "A":
				$taglio=floor($area_utile/50)*50;
				$pezzi=round(($taglio*$quantita)/$lunghezza_profilo,2);
				break;
			case "B":
				$taglio=floor($area_utile/25)*25;
				$pezzi=round(($taglio*$quantita)/$lunghezza_profilo,2);
				break;
			case "C":
				$taglio=floor($area_utile/27.8)*27.8;
				$pezzi=round(($taglio*$quantita)/$lunghezza_profilo,2);
				break;
			default:
				$taglio=-1;
				$pezzi=-1;
				break;
		}
		echo "<br/><table border=\"1\">
						<caption><strong>".$descrittivo_profilo."	</strong></caption>
							<thead>
								<tr>
									<th>Posizione</td>
									<th>Materiale</td>
									<th>".$descrittivo_colonna." </td>									
									<th>Numero profili</td>
									<th>Lunghezza profilo (mm)</td>
								
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>".$posizione_distinta."</td>
									<td>".$materiale."</td>									
									<td>".$pezzi."</td>
									<td>".$quantita."</td>
									<td>".$taglio."</td>
								</tr>
							</tbody>
						</table>";
		if (!$diba_prod){				
				inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'PZV',$pezzi,date("Ymd"));
				inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'MM',$taglio,date("Ymd"));
		}
	}
	//visualizzo ordine produzione nuovo e non in pezzi
	function supporto_reel2($motore_led,$materiale,$posizione_distinta,$lunghezza_verga,$area_utile,$quantita,$descrittivo_profilo,$descrittivo_colonna,$diba_prod,$pf_finale,$ordine_cliente,$riga_ordine){
		$taglio=0;
		$pezzi=0;
		
		switch ($motore_led){//IN FUNZIONE DEL MOTORE LED DETERMINO TAGLIO E PEZZI
			case "A":
				$taglio=floor($area_utile/50)*50;
				$pezzi=round(($taglio*$quantita)/$lunghezza_verga,2);
				break;
			case "B":
				$taglio=floor($area_utile/25)*25;
				$pezzi=round(($taglio*$quantita)/$lunghezza_verga,2);
				break;
			case "C":
				$taglio=floor($area_utile/27.8)*27.8;
				$pezzi=round(($taglio*$quantita)/$lunghezza_verga,2);
				break;
			default:
				$taglio=-1;
				$pezzi=-1;
				break;
		}
		
		
		$numero_schermi_per_verga=floor($lunghezza_verga/$taglio);
		$numero_schermi_per_verga_aggiuntiva=0;
		$sfrido_per_verga_aggiuntiva=0;
			
		if ($numero_schermi_per_verga>=$quantita){ //CASO IN CUI con una verga produco quanto richiesto
			$numero_verghe=1;
			$numero_schermi_per_verga=$quantita;
			$sfrido_per_verga=$lunghezza_verga-($numero_schermi_per_verga*$taglio);
			echo "<br/><table border=\"1\">
					<caption><strong>".$descrittivo_profilo."	</strong></caption>
						<thead>
							<tr>
								<th>Posizione</th>
								<th>Materiale</th>
								<th>".$descrittivo_colonna." </th>
								<th>Numero profili per verga </th>									
								<th>Lunghezza profilo (mm)</th>
								<th>Sfrido (mm)</th>								
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>".$posizione_distinta."</td>
								<td>".$materiale."</td>	
								<td>".$numero_verghe."</td>
								<td>".$numero_schermi_per_verga."</td>
								<td>".$taglio."</td>
								<td>".$sfrido_per_verga."</td>
							</tr>	
						</tbody>
						</table>";		
			if (!$diba_prod){
				inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'PZV',$pezzi,date("Ymd"));
				inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'MM',$taglio,date("Ymd"));
			}
		}else{								
			$numero_verghe=round(($quantita/$numero_schermi_per_verga),0);
			$sfrido_per_verga=$lunghezza_verga-($numero_schermi_per_verga*$taglio);
						
			if (($numero_verghe*$numero_schermi_per_verga)>$quantita){
				$numero_verghe=floor($quantita/$numero_schermi_per_verga);
				$verga_aggiuntiva=1;
				
				$numero_schermi_per_verga_aggiuntiva=$quantita-($numero_verghe*$numero_schermi_per_verga);
				$sfrido_per_verga_aggiuntiva=$lunghezza_verga-($taglio*$numero_schermi_per_verga_aggiuntiva);
				echo "<br/><table border=\"1\">
						<caption><strong>".$descrittivo_profilo."	</strong></caption>
							<thead>
								<tr>
									<th>Posizione</th>
									<th>Materiale</th>
									<th>".$descrittivo_colonna." </th>
									<th>Numero profili per verga </th>									
									<th>Lunghezza profilo (mm)</th>
									<th>Sfrido (mm)</th>
									
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>".$posizione_distinta."</td>
									<td>".$materiale."</td>	
									<td>".$numero_verghe."</td>
									<td>".$numero_schermi_per_verga."</td>
									<td>".$taglio."</td>
									<td>".$sfrido_per_verga."</td>
								</tr>	";
							echo "<tr>
									<td>".$posizione_distinta."</td>
									<td>".$materiale."</td>	
									<td>".$verga_aggiuntiva."</td>
									<td>".$numero_schermi_per_verga_aggiuntiva."</td>
									<td>".$taglio."</td>
									<td>".$sfrido_per_verga_aggiuntiva."</td>
								</tr>	";
								echo"</tbody>
						</table>";
				if (!$diba_prod){
					inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'PZV',$pezzi,date("Ymd"));
					inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'MM',$taglio,date("Ymd"));
				}
			}else{
				echo "<br/><table border=\"1\">
					<caption><strong>".$descrittivo_profilo."	</strong></caption>
							<thead>
								<tr>
									<th>Posizione</th>
									<th>Materiale</th>
									<th>".$descrittivo_colonna." </th>
									<th>Numero profili per verga </th>									
									<th>Lunghezza profilo (mm)</th>
									<th>Sfrido (mm)</th>
									
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>".$posizione_distinta."</td>
									<td>".$materiale."</td>	
									<td>".$numero_verghe."</td>
									<td>".$numero_schermi_per_verga."</td>
									<td>".$taglio."</td>
									<td>".$sfrido_per_verga."</td>
								</tr>
							</tbody>
						</table>";	
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'PZV',$pezzi,date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$posizione_distinta,$materiale,$descrittivo_profilo,'MM',$taglio,date("Ymd"));
						}
				}
			}
	}
	
	
	function motore_led($nome_prodotto,$motore_led,$temperatura_colore,$area_utile,$quantita,$diba_prod,$pf_finale,$ordine_cliente,$riga_ordine,$colore_schermo){
		global $dbh;
		
		if ($motore_led=='HE' or $motore_led=='LN' or $motore_led=='PL'){
			$select="SELECT anagrafica_barre_led.codice_barra_led,
							anagrafica_barre_led.descrizione,
							anagrafica_barre_led.tensione_alimentazione,
							anagrafica_barre_led.numero_led,
							anagrafica_barre_led.potenza,
							anagrafica_barre_led.potenza_a_modulo,
							anagrafica_barre_led.lunghezza_barra,
							motore_led.descrizione_motore,
							tipo_luce.tipo_luce,tipo_luce.codifica_temperatura,
							schermo.descrizione_schermo
				FROM anagrafica_barre_led,prodotti_lineari,tipo_luce,motore_led, prodotto_lineare_motore_led,prodotto_lineare_schermo,schermo
				WHERE  anagrafica_barre_led.codice_motore_led='".$motore_led."' 
				AND motore_led.codice_motore_led='".$motore_led."'
				AND anagrafica_barre_led.id_tipo_luce='".$temperatura_colore."' 
				AND tipo_luce.id_tipo_luce=anagrafica_barre_led.id_tipo_luce
				AND anagrafica_barre_led.codice_motore_led=motore_led.codice_motore_led
				AND prodotti_lineari.nome_prodotto='".$nome_prodotto."'
				AND  prodotto_lineare_motore_led.motore_led=motore_led.codice_motore_led  
				AND prodotti_lineari.lente=anagrafica_barre_led.lente	
				AND anagrafica_barre_led.tensione_alimentazione='12'
				AND prodotto_lineare_schermo.prodotto_lineare='".$nome_prodotto."'
				AND prodotto_lineare_schermo.codice_schermo='".$colore_schermo."'
				AND anagrafica_barre_led.blocco='0'
				AND prodotto_lineare_schermo.codice_schermo=schermo.codice_schermo
				ORDER BY CAST(anagrafica_barre_led.lunghezza_barra as SIGNED) DESC;" ;
		}else{
			$select="SELECT anagrafica_barre_led.codice_barra_led,
							anagrafica_barre_led.descrizione,
							anagrafica_barre_led.tensione_alimentazione,
							anagrafica_barre_led.numero_led,
							anagrafica_barre_led.potenza,
							anagrafica_barre_led.potenza_a_modulo,
							anagrafica_barre_led.lunghezza_barra,
							motore_led.descrizione_motore,
							tipo_luce.tipo_luce,tipo_luce.codifica_temperatura,
							schermo.descrizione_schermo
				FROM anagrafica_barre_led,tipo_luce,motore_led, prodotto_lineare_motore_led,prodotto_lineare_schermo,schermo
				WHERE  anagrafica_barre_led.codice_motore_led='".$motore_led."' 
				AND anagrafica_barre_led.id_tipo_luce='".$temperatura_colore."' 
				AND tipo_luce.id_tipo_luce=anagrafica_barre_led.id_tipo_luce
				AND anagrafica_barre_led.codice_motore_led=motore_led.codice_motore_led
				AND prodotto_lineare_motore_led.prodotto_lineare='".$nome_prodotto."'
				AND  prodotto_lineare_motore_led.motore_led=motore_led.codice_motore_led  
				AND anagrafica_barre_led.tensione_alimentazione='12'
				AND prodotto_lineare_schermo.prodotto_lineare='".$nome_prodotto."'
				AND prodotto_lineare_schermo.codice_schermo='".$colore_schermo."'
				AND prodotto_lineare_schermo.codice_schermo=schermo.codice_schermo
				AND anagrafica_barre_led.blocco='0'
				ORDER BY CAST(anagrafica_barre_led.lunghezza_barra as SIGNED) DESC;" ;
		}
		$sql=$dbh->prepare($select);
		$sql->execute();
		$prod=$sql->fetchAll();
		
		
			switch($motore_led){//in base al tipo di motore ho calcoli differenti per il numero di barre led
			
				case "A": //strip REEL prima 60LED/M ex R0
					foreach($prod as $row) {
						$numero_barre=floor($area_utile/50)*50;
						$pezzi=round(($numero_barre*$quantita)/$row['lunghezza_barra'],2);
						echo "<tr>
								<td>80</td>
								<td>".$row['codice_barra_led']."</td>
								<td>".$row['descrizione']."</td>
								<td>".$pezzi."</td>
								<td>".$quantita. " strip reel da ". $numero_barre."mm</td>
							 </tr>";
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,'80',$row['codice_barra_led'],$row['descrizione'],'PZV',$pezzi,date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,'80',$row['codice_barra_led'],$row['descrizione'],'MM',$numero_barre,date("Ymd"));
						}							 
					}							
					break;
				case "B"://strip REEL prima 120LED/M ex R1
					foreach($prod as $row) {
						$numero_barre=floor($area_utile/25)*25;
						$pezzi=round(($numero_barre*$quantita)/$row['lunghezza_barra'],2);
						echo "<tr>
								<td>80</td>
								<td>".$row['codice_barra_led']."</td>
								<td>".$row['descrizione']."</td>
								<td>".$pezzi."</td>
								<td>".$quantita. " strip reel da ". $numero_barre."mm</td>
							</tr>";
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,'80',$row['codice_barra_led'],$row['descrizione'],'PZV',$pezzi,date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,'80',$row['codice_barra_led'],$row['descrizione'],'MM',$numero_barre,date("Ymd"));
						}
					}
					break;
				case "C"://strip REEL prima 108LED/M
					foreach($prod as $row) {
						$numero_barre=floor($area_utile/27.8)*27.8;
						$pezzi=round(($numero_barre*$quantita)/$row['lunghezza_barra'],2);
						echo "<tr>
								<td>80</td>
								<td>".$row['codice_barra_led']."</td>
								<td>".$row['descrizione']."</td>
								<td>".$pezzi."</td>
								<td>".$quantita. " strip reel da ". $numero_barre."mm</td>
							</tr>";
						if (!$diba_prod){
							inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,'80',$row['codice_barra_led'],$row['descrizione'],'PZV',$pezzi,date("Ymd"));
							inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,'80',$row['codice_barra_led'],$row['descrizione'],'MM',$numero_barre,date("Ymd"));
						}
					}
					break;
				default://caso per le barre rigide
				
					try {			
						foreach($prod as $row) {
							if ($row['lunghezza_barra']<=$area_utile){
								echo "<tr>
										<td>80</td>";
								echo "<td>".$row['codice_barra_led']."</td>
									<td>".$row['descrizione']."</td>";
									$numero_barre=floor($area_utile/$row['lunghezza_barra']);
								echo "<td>".$numero_barre *$quantita."</td>";
								echo "<td>".$numero_barre." barre led da ".$row['lunghezza_barra']."mm per singolo prodotto assemblato</td>";
								
								$parte_decimale=(($area_utile/$row['lunghezza_barra'])- floor($area_utile/$row['lunghezza_barra']));
								//echo $row['codice_barra_led']." - " .$row['descrizione']." - Numero di barrette: ".$numero_barre."<br />";
								$area_utile=$parte_decimale*$row['lunghezza_barra'];
								echo "</tr>";
								if (!$diba_prod){
									inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,'80',$row['codice_barra_led'],$row['descrizione'],'PZ',$numero_barre*$quantita,date("Ymd"));
									inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,'80',$row['codice_barra_led'],$row['descrizione'],'PZ',$numero_barre,date("Ymd"));
								}
							}
						}						
					}
					catch(PDOException $e) {
						echo $e->getMessage();
						die();
					}								
			}		
	}
	function regole_sitema_fissaggio($nome_prodotto,$codice_fissaggio,$quantita,$diba_prod,$pf_finale,$ordine_cliente,$riga_ordine,$lunghezza){
		global $dbh;
		
		$sql=$dbh->query("	SELECT * 
							FROM regole_sistema_fissaggio 
							WHERE nome_prodotto='".$nome_prodotto."' 
							AND tipo_fissaggio='".$codice_fissaggio."'
							AND ".$lunghezza.">=da
							AND ".$lunghezza."<=a
							; ");
		$fissaggi=$sql->fetchAll();
		
		foreach ($fissaggi as $fissaggio){
			echo "<tr>
					<td>".$fissaggio['ordine']."</td>
					<td>".$fissaggio['codice_articolo_fissaggio']."</td>
					<td>".$fissaggio['descrizione_articolo_fissaggio']."</td>
					<td>".$fissaggio['QTA']*$quantita."</td>
					<td>".$fissaggio['QTA']." ".$fissaggio['descrizione_articolo_fissaggio']." per singolo prodotto assemblato</td>
				</tr>";
		
			if (!$diba_prod){
				inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$fissaggio['ordine'],$fissaggio['codice_articolo_fissaggio'],$fissaggio['descrizione_articolo_fissaggio'],$fissaggio['UM'],$fissaggio['QTA']*$quantita,date("Ymd"));
				inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$fissaggio['ordine'],$fissaggio['codice_articolo_fissaggio'],$fissaggio['descrizione_articolo_fissaggio'],$fissaggio['UM'],$fissaggio['QTA'],date("Ymd"));
			}
		}	
	}
	
	function regole_fogli_istruzione($nome_prodotto,$accessorio,$quantita,$diba_prod,$pf_finale,$ordine_cliente,$riga_ordine){
		global $dbh;
		$select="SELECT * FROM regole_fogli_istruzione WHERE nome_prodotto='".$nome_prodotto."' and id_accessorio='".$accessorio."' ORDER BY ordine ASC;";
		
		$sql=$dbh->prepare($select);
		$sql->execute();
		$fogli_istruzione=$sql->fetchAll();
		foreach ($fogli_istruzione as $foglio){
			echo "<tr>
					<td>".$foglio['ordine']."</td>
					<td>".$foglio['codice_articolo_foglio_istruzione']."</td>
					<td>foglio istruzione</td>
					<td>".$foglio['quantita']*$quantita."</td>
					<td>".$foglio['quantita']." foglio istruzione per singolo prodotto imballato</td>
				</tr>";
			if (!$diba_prod){
				inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$foglio['ordine'],$foglio['codice_articolo_foglio_istruzione'],'Foglio istruzione',$foglio['UM'],$foglio['quantita']*$quantita,date("Ymd"));
				inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$foglio['ordine'],$foglio['codice_articolo_foglio_istruzione'],'Foglio istruzione',$foglio['UM'],$foglio['quantita'],date("Ymd"));
			}
		}
	}
	function regole_accessori_fermacavo ($nome_prodotto,$accessorio,$motore_led,$quantita,$diba_prod,$pf_finale,$ordine_cliente,$riga_ordine){
		$row="";
		global $dbh;
		switch ($accessorio){
			case "1"://NESSUN ACCESSORIO
					switch ($motore_led){
						case "L":
						case "X":
						case "A":
						case "B":
						case "C":
						case "H":
						case "P":
							$sql=$dbh->query("SELECT * FROM regole_cavo_connessione WHERE nome_prodotto='".$nome_prodotto."' and id_accessorio='".$accessorio."' and codice_motore_led='".$motore_led."';");
							$row=$sql->fetchAll();
							echo"<tr>
									<td>".$row[0]['ordine']."</td>
									<td>".$row[0]['codice_articolo_cavo_connessione']."</td>								
									<td> Cavo di connessione </td>
									<td>".($quantita*$row[0]['quantita'])."</td>
									<td>".$row[0]['quantita']." cavo  per singola lampada assemblata </td>
								</tr>";
								if (!$diba_prod){
									inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$row[0]['ordine'],$row[0]['codice_articolo_cavo_connessione'],'Cavo di connessione',$row[0]['UM'],$row[0]['quantita']*$quantita,date("Ymd"));
									inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$row[0]['ordine'],$row[0]['codice_articolo_cavo_connessione'],'Cavo di connessione',$row[0]['UM'],$row[0]['quantita'],date("Ymd"));
								}
							break;
						case "V":
							$sql=$dbh->query("SELECT * FROM regole_cavo_connessione WHERE nome_prodotto='".$nome_prodotto."' and id_accessorio='".$accessorio."' and codice_motore_led='".$motore_led."' ORDER BY ordine ASC;");
							$rows=$sql->fetchAll();
							foreach ($rows as $row){
								echo"<tr>
									<td>".$row['ordine']."</td>
									<td>".$row['codice_articolo_cavo_connessione']."</td>								
									<td> Cavo di connessione </td>
									<td>".($quantita*$row['quantita'])."</td>
									<td>".$row['quantita']." cavo  per singola lampada assemblata </td>
								</tr>";
								if (!$diba_prod){
									inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$row['ordine'],$row['codice_articolo_cavo_connessione'],'Cavo di connessione',$row['UM'],$quantita*$row['quantita'],date("Ymd"));
									inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$row['ordine'],$row['codice_articolo_cavo_connessione'],'Cavo di connessione',$row['UM'],$row['quantita'],date("Ymd"));
								}
							}
					}				
				break;
			case "2"://ACCESSORIO TOUCH
				switch ($motore_led){
					case "L":
					case "H":
					case "P":
					case "A":
					case "B":
					case "C":
						$sql=$dbh->query("SELECT * FROM regole_accessori WHERE nome_prodotto='".$nome_prodotto."' and id_accessorio='".$accessorio."' and codice_motore_led='".$motore_led."';");
						$row=$sql->fetchAll();
							echo"<tr>
									<td>".$row[0]['ordine']."</td>";
									if ($row[0]['codice_articolo_accessorio']=='N.A'){
										echo "<td><strong>Codice articolo non ancora disponibile</strong></td>
												<td> Accessorio TOUCH non disponibile</td>
												<td>0</td>
												<td> Nessuna istruzione in quanto il codice manca</td>
											</tr>";
										if (!$diba_prod){
											inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$row[0]['ordine'],$row[0]['codice_articolo_accessorio'],'Accessorio TOUCH non disponibile','PZ',0,date("Ymd"));
											inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$row[0]['ordine'],$row[0]['codice_articolo_accessorio'],'Accessorio TOUCH non disponibile','PZ',0,date("Ymd"));
										}
									}else{
										
										echo"<td>".$row[0]['codice_articolo_accessorio']."</td>								
											<td> Accessorio TOUCH </td>
											<td>".($quantita*$row[0]['quantita'])."</td>
											<td>".$row[0]['quantita']." accessorio TOUCH  per singola lampada assemblata </td>
										</tr>";
										if (!$diba_prod){
											inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$row[0]['ordine'],$row[0]['codice_articolo_accessorio'],'Accessorio TOUCH',$row[0]['UM'],($quantita*$row[0]['quantita']),date("Ymd"));
											inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$row[0]['ordine'],$row[0]['codice_articolo_accessorio'],'Accessorio TOUCH',$row[0]['UM'],$row[0]['quantita'],date("Ymd"));
										}
									}	
							break;
					
					
				}
				break;
			case "3"://ACCESSORIO PIR SENSOR
				$sql=$dbh->query("SELECT * FROM regole_accessori WHERE nome_prodotto='".$nome_prodotto."' and id_accessorio='".$accessorio."' and codice_motore_led='".$motore_led."' ORDER BY ordine;");
				$rows=$sql->fetchAll();
				
				foreach ($rows as $row){
					echo"<tr>
								<td>".$row['ordine']."</td>";
									if ($row['codice_articolo_accessorio']=='N.A'){
										echo "<td><strong>Codice articolo non ancora disponibile</strong></td>
												<td> Accessorio TOUCH non disponibile</td>
												<td>0</td>
												<td> Nessuna istruzione in quanto il codice manca</td>
											</tr>";
											if (!$diba_prod){
												inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$row['ordine'],$row[0]['codice_articolo_accessorio'],'Accessorio TOUCH non disponibile','PZ',0,date("Ymd"));
										}
									}else{
										
										echo"<td>".$row['codice_articolo_accessorio']."</td>";
											
											if ($row['UM']=='MM'){
												echo "
													<td> Accessorio GUAINA per LENTE</td>
													<td>".$quantita."</td>
													<td>".$row['quantita']."mm di GUAINA per singola lampada assemblata. Totale guaina da prelevare:".($row['quantita']*$quantita)."mm </td>
												</tr>";	
												if (!$diba_prod){
													inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$row['ordine'],$row['codice_articolo_accessorio'],'Accessorio GUAINA per LENTE','PZ',$row['quantita']*$quantita,date("Ymd"));
													inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$row['ordine'],$row['codice_articolo_accessorio'],'Accessorio GUAINA per LENTE',$row['UM'],$row['quantita'],date("Ymd"));
												}
											}else{
											
											echo" <td> Accessorio PIR SENSOR</td>
												<td>".($quantita*$row['quantita'])."</td>
												<td>".$row['quantita']." accessorio PIR SENSOR per singola lampada assemblata </td>
												</tr>";
												if (!$diba_prod){
													inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$row['ordine'],$row['codice_articolo_accessorio'],'Accessorio GUAINA per LENTE','PZ',$row['quantita']*$quantita,date("Ymd"));
													inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$row['ordine'],$row['codice_articolo_accessorio'],'Accessorio GUAINA per LENTE','PZ',$row['quantita'],date("Ymd"));
												}
											}
								}	
				}
				break;
		}
	}
	
	function regole_etichette_imballo_multiplo($nome_prodotto,$quantita,$coefficente_utilizzo,$diba_prod,$pf_finale,$ordine_cliente,$riga_ordine){
		global $dbh;
		if ($quantita>5){
			$select=$dbh->query("SELECT * FROM diba WHERE ordine='120'");
			$row=$select->fetchAll();
			
			//$etichette_multiple=round($coefficente_utilizzo/$quantita,0);
			$etichette_multiple=round($quantita/$coefficente_utilizzo,0);
			
			echo"<tr>
					<td>".$row[0]['ordine']."</td>
					<td>".$row[0]['codice_componente']."</td>
					<td>".$row[0]['descrizione_di_massima_componente']."</td>
					<td>".$etichette_multiple."</td>
					<td>".$row[0]['quantita']." etichetta  per singolo imballo multiplo </td>
				</tr>";
				if (!$diba_prod){
					inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$row[0]['ordine'],$row[0]['codice_componente'],$row[0]['descrizione_di_massima_componente'],'PZ',$etichette_multiple,date("Ymd"));
					inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$row[0]['ordine'],$row[0]['codice_componente'],$row[0]['descrizione_di_massima_componente'],'PZ',$row[0]['quantita'],date("Ymd"));
				}
			
		}
	}
	
	function regole_imballi($nome_prodotto,$quantita,$lunghezza,$diba_prod,$pf_finale,$ordine_cliente,$riga_ordine){
		global $dbh;
		//modificata la selezione in quanto il nome del prodotto non serve. Ogni prodotto configurabile ha quel set di imballi
		#$select="SELECT * FROM regole_imballi WHERE nome_prodotto='".$nome_prodotto."' and da<='".$lunghezza."' and a>='".$lunghezza."' ORDER BY ordine ASC;";
		$select="SELECT * FROM regole_imballi WHERE da<='".$lunghezza."' and a>='".$lunghezza."' ORDER BY ordine ASC;";
		
		$sql=$dbh->prepare($select);
		$sql->execute();
		$imballo=$sql->fetchAll();
		if ($lunghezza <=1550){
			if ($quantita<=5){
			echo "<tr>
					<td>".$imballo[0]['ordine']."</td>
					<td>".$imballo[0]['codice_articolo_imballo']."</td>
					<td>Imballo singolo</td>
					<td>".$imballo[0]['quantita']*$quantita."</td>
					<td>".$imballo[0]['quantita']." imballo per singolo prodotto assemblato misure: da ".$imballo[0]['da']."mm a ".$imballo[0]['a']."mm</td>
				</tr>";
				if (!$diba_prod){
					inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$imballo[0]['ordine'],$imballo[0]['codice_articolo_imballo'],"Imballo singolo misure: da ".$imballo[0]['da']."mm a ".$imballo[0]['a']."mm",'PZ',$imballo[0]['quantita']*$quantita,date("Ymd"));
					inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$imballo[0]['ordine'],$imballo[0]['codice_articolo_imballo'],"Imballo singolo misure: da ".$imballo[0]['da']."mm a ".$imballo[0]['a']."mm",'PZ',$imballo[0]['quantita'],date("Ymd"));
				}
			}else{
			//$scatole_multiple=round($imballo[1]['coefficente_utilizzo']/$quantita,0);
				$scatole_multiple=round($quantita/$imballo[1]['coefficente_utilizzo'],0);
				echo "<tr>
					<td>".$imballo[0]['ordine']."</td>
					<td>".$imballo[0]['codice_articolo_imballo']."</td>
					<td>".$imballo[0]['descrizione_imballo']."</td>
					<td>".$imballo[0]['quantita']*$quantita."</td>
					<td>".$imballo[0]['quantita']." imballo per singolo prodotto assemblato misure: da ".$imballo[0]['da']."mm a ".$imballo[0]['a']."mm</td>
					
				</tr>
				<tr>
					<td>".$imballo[1]['ordine']."</td>
					<td>".$imballo[1]['codice_articolo_imballo']."</td>
					<td>".$imballo[1]['descrizione_imballo']."</td>
					<td>".$scatole_multiple."</td>
					<td>".$imballo[1]['coefficente_utilizzo']." lampade  per singolo imballo multiplo </td>
				</tr>";
				
				if (!$diba_prod){
					inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$imballo[0]['ordine'],$imballo[0]['codice_articolo_imballo'],"Imballo singolo misure: da ".$imballo[0]['da']."mm a ".$imballo[0]['a']."mm",'PZ',$imballo[0]['quantita']*$quantita,date("Ymd"));
					inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$imballo[0]['ordine'],$imballo[0]['codice_articolo_imballo'],"Imballo singolo misure: da ".$imballo[0]['da']."mm a ".$imballo[0]['a']."mm",'PZ',$imballo[0]['quantita'],date("Ymd"));
					inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$imballo[1]['ordine'],$imballo[1]['codice_articolo_imballo'],"Imballo multiplo",'PZ',$scatole_multiple,date("Ymd"));
					inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$imballo[1]['ordine'],$imballo[1]['codice_articolo_imballo'],"Imballo multiplo",'PZ',$scatole_multiple,date("Ymd"));
				}	
			}
		}else{
			foreach ($imballo as $scatola){
				echo"	<tr>
							<td>".$scatola['ordine']."</td>
							<td>".$scatola['codice_articolo_imballo']."</td>
							<td>".$scatola['descrizione_imballo']."</td>
							<td>".$scatola['quantita']*$quantita."</td>
							<td>".$scatola['quantita']." ".$scatola['descrizione_imballo']." </td>
						</tr>";
				if (!$diba_prod){
					inserisci_diba('diba_produzione',$ordine_cliente,$riga_ordine,$pf_finale,$scatola['ordine'],$scatola['codice_articolo_imballo'],$scatola['descrizione_imballo'],$scatola['UM'],$scatola['quantita']*$quantita,date("Ymd"));
					inserisci_diba('diba_tecnica',$ordine_cliente,$riga_ordine,$pf_finale,$scatola['ordine'],$scatola['codice_articolo_imballo'],$scatola['descrizione_imballo'],$scatola['UM'],$scatola['quantita'],date("Ymd"));
				}
			
			}
		}
	}
	
	function esistenza_diba_produzione($ordine_cliente,$riga_ordine_cliente){
		global $dbh;
		/*CONTROLLO SE PER QUESTO ORDINE E RIGA ESISTA UNA DIBA DI PRODUZIONE*/
				$select=$dbh->query("SELECT ordine_cliente,riga_ordine_cliente FROM diba_produzione WHERE ordine_cliente='".$ordine_cliente ."' and riga_ordine_cliente='".$riga_ordine_cliente."' GROUP BY ordine_cliente,riga_ordine_cliente;");
				$row=$select->fetchAll();
		
				if (count($row)==1){
					return true;
				}else{
					return false;
				}
				
	}
	function esistenza_diba($nome_tabella,$ordine_cliente,$riga_ordine_cliente){
		global $dbh;
		/*CONTROLLO SE PER QUESTO ORDINE E RIGA ESISTA UNA DIBA DI PRODUZIONE O TECNICA IN FUNZIONE DI QUELLO CHE SCELGO*/
				$select=$dbh->query("SELECT ordine_cliente,riga_ordine_cliente FROM ".$nome_tabella." WHERE ordine_cliente='".$ordine_cliente ."' and riga_ordine_cliente='".$riga_ordine_cliente."' GROUP BY ordine_cliente,riga_ordine_cliente;");
				$row=$select->fetchAll();
		
				if (count($row)==1){
					return true;
				}else{
					return false;
				}
				
	}
	
	function inserisci_diba($nome_tabella,$ordine_cliente,$riga_ordine_cliente,$codice_pf_finale,$posizione_diba,$codice_componente,$descrizione_componente,$UM,$qta,$data_inserimento){
		global $dbh;
		
		$dbh->exec("INSERT INTO ".$nome_tabella." (ordine_cliente,riga_ordine_cliente,codice_PF_finale,posizione_diba,codice_componente,descrizione_componente,UM,qta,data_inserimento)
					VALUES('".$ordine_cliente."','".$riga_ordine_cliente."','".$codice_pf_finale."','".$posizione_diba."','".$codice_componente."','".$descrizione_componente."','".$UM."','".$qta."','".$data_inserimento."')");
	}
	
	
	function return_temporary_code($ordine_cliente,$riga_ordine){
		if(strlen((string)$riga_ordine)<3){
			return "C.".$ordine_cliente.".0".$riga_ordine;
		}else{
			return "C.".$ordine_cliente.".".$riga_ordine;
		}
	}
	
	
?>