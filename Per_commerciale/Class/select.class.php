<?php	

class PrezzoProdottoConfigurabile
{
	
	protected $conn;
	
		public function __construct()
		{
			$this->DbConnect();
		}
	
		protected function DbConnect()
		{
			//include "../include/dbconfig.inc.php";
			global $dbh;
			// connect using PDO
			try { // attempt to create a connection to database
				$dbh = new PDO("mysql:host=localhost;dbname=configuratore", 'ale', 'claudias82!');
				$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				return TRUE;
			}
			catch(PDOException $e) { // if it fails, we echo the error and die.
				echo $e->getMessage();
				die();
			}
				
			
		}
		public function ShowProdotti()
		{
			global $dbh;
			
			$select = "SELECT nome_prodotto FROM prodotti_lineari WHERE obsoleta='0' GROUP BY nome_prodotto";
			
			
			$prodotti = '<option value="0">Scegli...</option>';
			try {
				foreach($dbh->query($select) as $row) {				
					$prodotti .= '<option value="' . $row['nome_prodotto'] . '">' . utf8_encode($row['nome_prodotto']) . '</option>';
				}
			}
			catch(PDOException $e) {
				echo $e->getMessage();
				die();
			}	
			return $prodotti;
		}
		
		public function showMotoreLed()
		{
			global $dbh;
			$nome_prodotto = $_POST['prodotto_lineare'];//prodotto lineare

			$select = "SELECT motore_led.codice_motore_led, motore_led.descrizione_motore FROM motore_led,prodotto_lineare_motore_led WHERE prodotto_lineare_motore_led.prodotto_lineare = '".$nome_prodotto."' 
						and prodotto_lineare_motore_led.motore_led=motore_led.codice_motore_led ";
	
			$motore_led='<option value="0">Scegli...</option>';
			try {
				foreach($dbh->query($select) as $row) {
				
					$motore_led .='<option value="' . $row['codice_motore_led'] . '">' . utf8_encode($row['descrizione_motore']) . '</option>';
				}
			}
			catch(PDOException $e) {
				echo $e->getMessage();
				die();
			}
			return $motore_led;
		}
		
		public function showTemperaturaLuce()
		{
			global $dbh;
			$motore_led=$_POST['motore_led'];
			
			$select = "SELECT tipo_luce.id_tipo_luce, tipo_luce.tipo_luce as descrittivo 
			FROM anagrafica_barre_led,tipo_luce 
			WHERE anagrafica_barre_led.id_tipo_luce=tipo_luce.id_tipo_luce and anagrafica_barre_led.codice_motore_led='".$motore_led."' 
			GROUP BY tipo_luce.id_tipo_luce
			ORDER BY tipo_luce.temperatura_colore;
			";
			
			$temperaturaLuce='<option value="0">scegli...</option>';
			
			try {
				foreach($dbh->query($select) as $row) {				
					$temperaturaLuce .='<option value="' . $row['id_tipo_luce'] . '">' . utf8_encode($row['descrittivo']) . '</option>\n';
				}
			}
			catch(PDOException $e) {
				echo $e->getMessage();
				die();
			}
			return $temperaturaLuce;
			
		}
		
		public function showAccessorio()
		{
			global $dbh;
			$nome_prodotto=$_POST['accessorio'];
			
			$select = "SELECT accessori.id_accessorio,accessori.descrizione FROM accessori,prodotto_lineare_accessori 
				WHERE prodotto_lineare_accessori.prodotto_lineare='".$nome_prodotto."' and accessori.id_accessorio=prodotto_lineare_accessori.id_accessorio";
	
			$accessorio='<option value="0">scegli...</option>';
			try {
				foreach($dbh->query($select) as $row) {					
					$accessorio .='<option value="' . $row['id_accessorio'] . '">' . utf8_encode($row['descrizione']) . '</option>\n';
				}
			}
			catch(PDOException $e) {
				echo $e->getMessage();
				die();
			}
			return $accessorio;
		}
		
		public function showSchermo()
		{
			global $dbh;
			$nome_prodotto=$_POST['schermo'];
			
			$select = "	SELECT schermo.codice_schermo, schermo.descrizione_schermo 
				FROM schermo, prodotto_lineare_schermo
				WHERE 	prodotto_lineare_schermo.prodotto_lineare='".$nome_prodotto."' AND
						prodotto_lineare_schermo.codice_schermo=schermo.codice_schermo;";
	
			$schermo='<option value="0">Scegli...</option>';
			
			try {
				foreach($dbh->query($select) as $row) {					
					$schermo .='<option value="' . $row['codice_schermo'] . '">' . utf8_encode($row['descrizione_schermo']) . '</option>\n';
				}
			}
			catch(PDOException $e) {
				echo $e->getMessage();
				die();
			}
			return $schermo;
		}
		
		public function showSistemaFissaggio()
		{
			global $dbh;
			$nome_prodotto=$_POST['fissaggio'];
			
			$select = "	SELECT tipo_fissaggio.codice_fissaggio,tipo_fissaggio.descrizione_fissaggio
						FROM tipo_fissaggio,regole_sistema_fissaggio
						WHERE regole_sistema_fissaggio.nome_prodotto='".$nome_prodotto."' AND
								regole_sistema_fissaggio.tipo_fissaggio=tipo_fissaggio.codice_fissaggio
						GROUP BY tipo_fissaggio.codice_fissaggio";
			
			$fissaggio='<option value="0">Scegli...</option>';
			
			try {
				foreach($dbh->query($select) as $row) {
					
					$fissaggio .='<option value="' . $row['codice_fissaggio'] . '">' . utf8_encode($row['descrizione_fissaggio']) . '</option>\n';
				}
			}
			catch(PDOException $e) {
				echo $e->getMessage();
				die();
			}
				
			return $fissaggio;
		}
		
		
		
		public function showPrezzoProdotto()
		{
			global $dbh;
			$dati_prezzo=$_POST['dato_per_prezzo'];
			$prodotto_ok=array();
			
			#definizione dei prezzi per i magneti prodotto BALI
			$prezzo_magnete_std=1.4;
			$prezzo_magnete_min=1.2;
			
			$dati_prodotto=array();
			$response="";
			$dati_prodotto=preg_split("/\|/",$dati_prezzo);
			
			$prodotto_ok=$this->prodotto_fattibile($dati_prodotto[0],(int)$dati_prodotto[2]);
			
			switch ($prodotto_ok['error']){
				#misura minore del minimo
				case 0:
					$response="
									<h2 style=\"color:red;\">Lunghezza prodotto non consentita!! </h2>
									<p> Hai scelto una misura che &egrave; minore di quella attualmente consentita. <br/>
										La misura minima &egrave; di: ".$prodotto_ok['misura_consentita']."mm
								";
					return $response;
					break;
					
				#misura maggiore della massima
				case 1:
					$response="
									<h2 style=\"color:red;\">Lunghezza prodotto non consentita!! </h2>
									<p> Hai scelto una misura che &egrave; maggiore di quella attualmente consentita. <br/>
										La misura massima &egrave; di: ".$prodotto_ok['misura_consentita']."mm
								";
					return $response;
					break;
					
				#caso normale
				case 2:
					if ($dati_prodotto[0]<>"BALI"){			
						$select="
								SELECT nome_prodotto as Prodotto, prezzo_configurato as Prezzo_Consigliato, prezzo_minimo_configurato as Prezzo_Minimo
								FROM listino_configurati
								WHERE nome_prodotto='".$dati_prodotto[0]."' and id_accessorio='".$dati_prodotto[1]."' and '".$dati_prodotto[2]."'>=da and '".$dati_prodotto[2]."'<=a
							";
					}else{
						#in funzione del tipo di supporto BALI
						if ($dati_prodotto[3]=='ST'){
							$select="
								SELECT 	listino_configurati.nome_prodotto as Prodotto, listino_configurati.prezzo_configurato as Prezzo_Consigliato, listino_configurati.prezzo_minimo_configurato as Prezzo_Minimo
								FROM 	listino_configurati,regole_sistema_fissaggio
								WHERE 	listino_configurati.nome_prodotto='".$dati_prodotto[0]."'
									AND	listino_configurati.id_accessorio='".$dati_prodotto[1]."' 
									AND '".$dati_prodotto[2]."'>=listino_configurati.da 
									AND '".$dati_prodotto[2]."'<=listino_configurati.a
									AND listino_configurati.nome_prodotto=regole_sistema_fissaggio.nome_prodotto
									AND regole_sistema_fissaggio.tipo_fissaggio='".$dati_prodotto[3]."'
									AND '".$dati_prodotto[2]."'>= regole_sistema_fissaggio.da
									AND '".$dati_prodotto[2]."'<= regole_sistema_fissaggio.a
							";
						}else{
							$select="
								SELECT 	listino_configurati.nome_prodotto as Prodotto, 
										(listino_configurati.prezzo_configurato+(regole_sistema_fissaggio.qta* ".$prezzo_magnete_std." )) as Prezzo_Consigliato, 
										(listino_configurati.prezzo_minimo_configurato+(regole_sistema_fissaggio.qta* ".$prezzo_magnete_min.")) as Prezzo_Minimo
								FROM 	listino_configurati,regole_sistema_fissaggio
								WHERE 	listino_configurati.nome_prodotto='".$dati_prodotto[0]."'
									AND	listino_configurati.id_accessorio='".$dati_prodotto[1]."' 
									AND '".$dati_prodotto[2]."'>=listino_configurati.da 
									AND '".$dati_prodotto[2]."'<=listino_configurati.a
									AND listino_configurati.nome_prodotto=regole_sistema_fissaggio.nome_prodotto
									AND regole_sistema_fissaggio.tipo_fissaggio='".$dati_prodotto[3]."'
									AND '".$dati_prodotto[2]."'>= regole_sistema_fissaggio.da
									AND '".$dati_prodotto[2]."'<= regole_sistema_fissaggio.a
									";
						}
					}
			
					$query=$dbh->query($select);
					$res=$query->fetchAll();
			
					if (count($res)>0){
						$response=
							"
								<h2 style=\"color:green;\">Prezzo consigliato ". number_format($res[0]['Prezzo_Consigliato'],2,',','')."&euro; </h2>
								<h2 style=\"color:red;\">Prezzo speciale ".number_format($res[0]['Prezzo_Minimo'],2,',','')."&euro; </h2>
							";
						return $response;
					}else{
					
						return "<h2 style=\"color:red;\">Lampada non fattibile</h2>
								<p> L'accessorio TOUCH pu&ograve; essere montato su lampade la cui lunghezza massima &egrave; di: 1500mm</p>
								";
					}
					break;
			
				
			}
		
		}
		private function prodotto_fattibile($nome_prodotto,$misura)
		{
		
			global $dbh;
			$res=array();
			
			$select="	SELECT nome_prodotto,da,a
						FROM prodotti_lineari
						WHERE nome_prodotto='".$nome_prodotto."' and obsoleta=0	
					";
					
			$query=$dbh->query($select);
			$misure_prodotto=$query->fetchAll();
			
			switch (true){
			
				case ($misura>=$misure_prodotto[0]['da'] and $misura<=$misure_prodotto[0]['a']):
					$res=array('error'=>'2','misura_consentita'=>'OK');
					return $res;
					break;
					
				case $misura<$misure_prodotto[0]['a']:
					$res=array('error'=>'0','misura_consentita'=>$misure_prodotto[0]['da']);
					return $res;
					break;
					
				case $misura>$misure_prodotto[0]['da']:
					$res=array('error'=>'1','misura_consentita'=>$misure_prodotto[0]['a']);
					return $res;					
					break;
				
				
			}
		}
		
		
}

?>