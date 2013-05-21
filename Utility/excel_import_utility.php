<?php
	array_walk_recursive($_POST, 'sanitizeVariables'); 
	array_walk_recursive($_GET, 'sanitizeVariables'); 

	// sanitization 
	function sanitizeVariables(&$item, $key) { 
		if (!is_array($item)) { 
        // undoing 'magic_quotes_gpc = On' directive 
        if (get_magic_quotes_gpc()) 
            $item = stripcslashes($item); 
        
			$item = sanitizeText($item); 
		} 
	}	 
	function return_ultimo_inserimento($tabella){
		$query=mysql_query("SELECT data_importazione_dati FROM ".$tabella." where sorgente_dati='SAP' limit 1,1");
		if (mysql_num_rows($query)>0){
			$valore=mysql_fetch_assoc($query);
			return $valore['data_importazione_dati'];			
		}else{
			return "No data";
		}
		 
	}
// does the actual 'html' and 'sql' sanitization. customize if you want. 
	function sanitizeText($text) { 
		$text = str_replace("<", "&lt;", $text); 
		$text = str_replace(">", "&gt;", $text); 
		$text = str_replace("\"", "&quot;", $text); 
		$text = str_replace("'", "&#039;", $text); 
    
		// it is recommended to replace 'addslashes' with 'mysql_real_escape_string' or whatever db specific fucntion used for escaping. However 'mysql_real_escape_string' is slower because it has to connect to mysql. 
		$text = addslashes($text); 

		return $text; 
	} 

	// export POST variables as GLOBALS. remove if you want 
	//foreach (array_keys($_POST) as $ehsanKey) 
		//$GLOBALS[$ehsanKey] = $_POST[$ehsanKey]; 

	// export GET variables as GLOBALS. remove if you want 
	//foreach (array_keys($_GET) as $ehsanKey) { 
		//$GLOBALS[$ehsanKey] = $_GET[$ehsanKey]; 
	//} 

	// preventing the key used above for iteration from getting into globals (in case  'register_globals = On') 
	unset($ehsanKey); 

	// the reverse function of 'sanitizeText'. you may use it in pages which need the original data (e.g. for an HTML editor) 
	function unsanitizeText($text) { 
		$text =  stripcslashes($text); 
		$text = str_replace("&#039;", "'", $text); 
		$text = str_replace("&gt;", ">", $text); 
		$text = str_replace("&quot;", "\"", $text);    
		$text = str_replace("&lt;", "<", $text); 
        return $text; 
}	 


	//ritorna una data in formato aaaammgg dato un formato es: mmggaaaa con il separatore per riconoscere come vengono separati gli elementi di una data
	//quindi in php $data=return_date_aammgg($_POST['data'],"mmggaaaa","/");
	function return_date_aaammgg($mydate,$format_date,$separatore){ 
		switch ($separatore){//in base al separatore
			case "/":
				switch ($format_date){ //in base al formato data appena letto
					case "mmggaaaa":
						list($m, $d, $y) = preg_split('/\//', $mydate);
						$mydate = sprintf('%4d%02d%02d', $y, $m, $d);
						return $mydate;
						break;
					case "ggmmaaaa":
						list($d, $m, $y) = preg_split('/\//', $mydate);
						$mydate = sprintf('%4d%02d%02d', $y, $m, $d);
						return $mydate;
						break;
				}
				break;
			case ".":
				switch ($format_date){
					case "mmggaaaa":
						list($m, $d, $y) = preg_split('/\./', $mydate);
						$mydate = sprintf('%4d%02d%02d', $y, $m, $d);
						return $mydate;
						break;
					case "ggmmaaaa":
						list($d, $m, $y) = preg_split('/\./', $mydate);
						$mydate = sprintf('%4d%02d%02d', $y, $m, $d);
						return $mydate;
						break;
				}
			break;
		}
	}
	// Returns the year as an offset since 1900, negative for years before
	// data nel formato aaaammgg , poi "anno" o "mese" o "giorno" in base a quello che serve
	
	function spezza_data_aaaammgg($data,$parte_data){
		switch ($parte_data){
			case "anno":				
				return date("Y",strtotime($data));
				break;
			case "giorno":
				return date("d",strtotime($data));//j per giorni senza lo 0 (zero)
				break;
			case "mese":
				return date("m",strtotime($data)); //n per mesi senza lo 0 (zero) 
				break;
			case "mese esteso":
				setlocale(LC_TIME, 'ita', 'it_IT');
				//return date("F",strtotime($data));
				return strftime("%B",strtotime($data));//nome mese esteso in italiano
				
				break;
		}
	}
	
	function calcola_trimestre($mydate){
	
		$anno=date("Y",strtotime($mydate));
		$mese=date("m",strtotime($mydate));
		$giorno=date("d",strtotime($mydate));
		$ts = mktime(0,0,0,$mese,$giorno,$anno);
		
		return ceil(date("m", $ts)/3);
		
	}

	//la data deve essere nel formato aaaammgg
	function calcola_condovnw ($data){
	
		$oggi=date("Ymd");
		$mese=date("m",strtotime($oggi)); //n per mesi senza lo 0 (zero) 
		$anno=date("Y",strtotime($oggi));   
		$giorno=date("d",strtotime($oggi));//j per giorni senza lo 0 (zero)
		
		$primo_giorno_del_mese=date('Ymd', mktime(0, 0, 0, $mese, 1, $anno));
		$ultimo_giorno_del_mese=date('Ymt', mktime(0, 0, 0, $mese, 1, $anno));
		$primo_giorno_mese_precedente=date('Ymd', mktime(0, 0, 0, $mese-1, 1, $anno));
		$ultimo_giorno_mese_precedente=date('Ymt', mktime(0, 0, 0, $mese-1, 1, $anno));
		$primo_giorno_mese_successivo=date('Ymd', mktime(0, 0, 0, $mese+1, 1, $anno));
		$ultimo_giorno_mese_successivo= date('Ymt', mktime(0, 0, 0, $mese+1, 1, $anno));
		$ultimo_giorno_due_mesi_successivi=date('Ymt', mktime(0, 0, 0, $mese+2, 1, $anno));
		
		$mese_data=date("m",strtotime($data));
		
		if(($data>=$primo_giorno_del_mese)and($mese_data=$mese) and ($oggi>=$data)and ($data<$ultimo_giorno_del_mese)){
			return "MESE CORRENTE";
		}elseif (($data>=$primo_giorno_del_mese) and ($mese_data=$mese)and($data>$oggi) and ($data<=$ultimo_giorno_del_mese)){
			return "FINE MESE";
		}elseif (($data>$oggi)and($data>=$primo_giorno_mese_successivo)and($data<=$ultimo_giorno_mese_successivo)){
			return "MESE SUCCESSIVO";
		}elseif (($data>$oggi)and ($data>$ultimo_giorno_mese_successivo)and($data<=$ultimo_giorno_due_mesi_successivi)){
			return "DUE MESI SUCCESSIVI";
		}elseif(($data>$oggi)and($data>$ultimo_giorno_due_mesi_successivi)){
			return "FUTURO";
		}elseif	(($data<=$ultimo_giorno_mese_precedente)and($data>=$primo_giorno_mese_precedente)){
			return "MESE SCORSO";
		}elseif(($data<$primo_giorno_mese_precedente)){
			return "STORICO";
		}else{
			return "ERRORE";
		}
	
		
	}
	function formatinr($input){  
			$dec = "";  
			$pos = strpos($input, ",");
			$len_stringa=strlen($input);
			$num_dec=($len_stringa-$pos);
			if ($pos === false){  
				//no decimals     
			} else {  
				//decimals  
				//$dec = substr(round(substr($input,$pos),2),1);  
				$dec = str_replace(",",".",substr($input,$pos,$num_dec));  
				$input = substr($input,0,$pos);  
			} 
			$num=str_replace(".",",",$input);
		
			return $num . $dec;  	
			
	}  

	function numdec($n,$d) {
		return number_format($n, $d, '.', ' ');
	}
	
?>