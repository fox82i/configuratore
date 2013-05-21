<?php
	include '../Excel/reader.php';
	include '../Utility/excel_import_utility.php';
	
	if(isset($_POST['opzioni'])){
		$options = $_POST['opzioni'];
		mysql_connect ("localhost","root","i19691982!D");
		mysql_select_db ("configuratore");
	
		switch($options){
			
			
			case "Clienti":
				if (file_exists ('../Upload_file/elenco_clienti.xls')){
					if (mysql_num_rows(mysql_query("SELECT * FROM clienti ;"))>0){
						if (!mysql_query("DELETE FROM clienti ;")){
							echo " Error on delete data....<br/>";
							break;
						}
					}
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('../Upload_file/elenco_clienti.xls');
					$numero_righe=0;
					$values=array();
					
					$query=mysql_query("select column_name from information_schema.columns where table_name='clienti';");
					
					while ($rows = mysql_fetch_assoc($query)) {  //costruisco l'elenco dei campi tabella per la query di inserimento
						$campi_tabella[]=$rows['column_name'];
					}
                    
					for ($i =2; $i <= $data->sheets[0]['numRows']; $i++) { //La prima riga sono le intestazioni dei campi
						if(empty($data->sheets[0]['cells'][$i][1]) or ($data->sheets[0]['cells'][$i][1])==""){
							break;
						}  
						for($j=1;$j<=$data->sheets[0]['numCols'];$j++){
							if(empty($data->sheets[0]['cells'][$i][$j]) or $data->sheets[0]['cells'][$i][$j]==""){
								$values[]="";
							}else{
								$values[]=utf8_encode(trim(addslashes($data->sheets[0]['cells'][$i][$j])));
							}
						}
						$query="insert into clienti (" . implode(', ', $campi_tabella) .") VALUES ('" . implode("', '",$values). "');";
						if (!mysql_query($query)){
							echo $query." ===> NON INSERITA <br/>";
						}else{
							$numero_righe++;
						}
						$query="";
						$values=array();
						
						
					}
					echo "Numero righe importate: ".$numero_righe."<br/><br/>";
				}else{	
					echo "</p><strong>Il file Elenco_clienti.xls non e&grave; presente nel server! Provare ad importarlo nuovamente</strong></p>";
				}
				mysql_close();
				break;
				
				case "Distinta base":
				if (file_exists ('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls')){
					if (mysql_num_rows(mysql_query("SELECT * FROM diba ;"))>0){
						if (!mysql_query("DELETE FROM diba ;")){
							echo " Error on delete data....<br/>";
							break;
						}
					}
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls');
					$numero_righe=0;
					$values=array();
					$query=mysql_query("select column_name from information_schema.columns where table_name='diba';");
					
					while ($rows = mysql_fetch_assoc($query)) {  //costruisco l'elenco dei campi tabella per la query di inserimento
						$campi_tabella[]=$rows['column_name'];
					}
					for ($i =2; $i <= $data->sheets[10]['numRows']; $i++) { //La prima riga sono le intestazioni dei campi
						if(empty($data->sheets[10]['cells'][$i][1]) or ($data->sheets[10]['cells'][$i][1])==""){
							break;
						}
						for($j=1;$j<=$data->sheets[10]['numCols'];$j++){
							if(empty($data->sheets[10]['cells'][$i][$j]) or $data->sheets[10]['cells'][$i][$j]==""){
								$values[]="";
							}else{
								$values[]=utf8_encode(trim(addslashes($data->sheets[10]['cells'][$i][$j])));
							}
						}
						$values[]=date("Ymd");
						
						$query="insert into diba (" . implode(', ', $campi_tabella) .") VALUES ('" . implode("', '",$values). "');";
						if (!mysql_query($query)){
							echo $query." ===> NON INSERITA <br/>";
						}else{
							$numero_righe++;
						}
						$query="";
						$values=array();
						
						
					}
					echo "Numero righe importate: ".$numero_righe."<br/><br/>";
				}else{	
					echo "</p><strong>Il file ELENCO_MOTORI_LED_LINEARI.xls non e&grave; presente nel server! Provare ad importarlo nuovamente</strong></p>";
				}
				mysql_close();
				break;	
				
			case "Regole molle":
				if (file_exists ('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls')){
					if (mysql_num_rows(mysql_query("SELECT * FROM regole_molle ;"))>0){
						if (!mysql_query("DELETE FROM regole_molle ;")){
							echo " Error on delete data....<br/>";
							break;
						}
					}
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls');
					$numero_righe=0;
					$values=array();
					$query=mysql_query("select column_name from information_schema.columns where table_name='regole_molle';");
					
					while ($rows = mysql_fetch_assoc($query)) {  //costruisco l'elenco dei campi tabella per la query di inserimento
						$campi_tabella[]=$rows['column_name'];
					}
					for ($i =2; $i <= $data->sheets[11]['numRows']; $i++) { //La prima riga sono le intestazioni dei campi
						if(empty($data->sheets[11]['cells'][$i][1]) or ($data->sheets[11]['cells'][$i][1])==""){
							break;
						}
						for($j=1;$j<=$data->sheets[11]['numCols'];$j++){
							if(empty($data->sheets[11]['cells'][$i][$j]) or $data->sheets[11]['cells'][$i][$j]==""){
								$values[]="";
							}else{
								$values[]=utf8_encode(trim(addslashes($data->sheets[11]['cells'][$i][$j])));
							}
						}
						$values[]=date("Ymd");
						
						$query="insert into regole_molle (" . implode(', ', $campi_tabella) .") VALUES ('" . implode("', '",$values). "');";
						if (!mysql_query($query)){
							echo $query." ===> NON INSERITA <br/>";
						}else{
							$numero_righe++;
						}
						$query="";
						$values=array();
						
						
					}
					echo "Numero righe importate: ".$numero_righe."<br/><br/>";
				}else{	
					echo "</p><strong>Il file ELENCO_MOTORI_LED_LINEARI.xls non e&grave; presente nel server! Provare ad importarlo nuovamente</strong></p>";
				}
				mysql_close();
				break;	
					
			case "Regole accessori":
				if (file_exists ('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls')){
					if (mysql_num_rows(mysql_query("SELECT * FROM regole_accessori ;"))>0){
						if (!mysql_query("DELETE FROM regole_accessori ;")){
							echo " Error on delete data....<br/>";
							break;
						}
					}
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls');
					$numero_righe=0;
					$values=array();
					$query=mysql_query("select column_name from information_schema.columns where table_name='regole_accessori';");
					
					while ($rows = mysql_fetch_assoc($query)) {  //costruisco l'elenco dei campi tabella per la query di inserimento
						$campi_tabella[]=$rows['column_name'];
					}
					for ($i =2; $i <= $data->sheets[12]['numRows']; $i++) { //La prima riga sono le intestazioni dei campi
						if(empty($data->sheets[12]['cells'][$i][1]) or ($data->sheets[12]['cells'][$i][1])==""){
							break;
						}
						for($j=1;$j<=$data->sheets[12]['numCols'];$j++){
							if(empty($data->sheets[12]['cells'][$i][$j]) or $data->sheets[12]['cells'][$i][$j]==""){
								$values[]="";
							}else{
								$values[]=utf8_encode(trim(addslashes($data->sheets[12]['cells'][$i][$j])));
							}
						}
						$values[]=date("Ymd");
						
						$query="insert into regole_accessori (" . implode(', ', $campi_tabella) .") VALUES ('" . implode("', '",$values). "');";
						if (!mysql_query($query)){
							echo $query." ===> NON INSERITA <br/>";
						}else{
							$numero_righe++;
						}
						$query="";
						$values=array();
						
						
					}
					echo "Numero righe importate: ".$numero_righe."<br/><br/>";
				}else{	
					echo "</p><strong>Il file ELENCO_MOTORI_LED_LINEARI.xls non e&grave; presente nel server! Provare ad importarlo nuovamente</strong></p>";
				}
				mysql_close();
				break;	
			case "Regole cavo connessione":
				if (file_exists ('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls')){
					if (mysql_num_rows(mysql_query("SELECT * FROM regole_cavo_connessione ;"))>0){
						if (!mysql_query("DELETE FROM regole_cavo_connessione ;")){
							echo " Error on delete data....<br/>";
							break;
						}
					}
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls');
					$numero_righe=0;
					$values=array();
					$query=mysql_query("select column_name from information_schema.columns where table_name='regole_cavo_connessione';");
					
					while ($rows = mysql_fetch_assoc($query)) {  //costruisco l'elenco dei campi tabella per la query di inserimento
						$campi_tabella[]=$rows['column_name'];
					}
					for ($i =2; $i <= $data->sheets[13]['numRows']; $i++) { //La prima riga sono le intestazioni dei campi
						if(empty($data->sheets[13]['cells'][$i][1]) or ($data->sheets[13]['cells'][$i][1])==""){
							break;
						}
						for($j=1;$j<=$data->sheets[13]['numCols'];$j++){
							if(empty($data->sheets[13]['cells'][$i][$j]) or $data->sheets[13]['cells'][$i][$j]==""){
								$values[]="";
							}else{
								$values[]=utf8_encode(trim(addslashes($data->sheets[13]['cells'][$i][$j])));
							}
						}
						$values[]=date("Ymd");
						
						$query="insert into regole_cavo_connessione (" . implode(', ', $campi_tabella) .") VALUES ('" . implode("', '",$values). "');";
						if (!mysql_query($query)){
							echo $query." ===> NON INSERITA <br/>";
						}else{
							$numero_righe++;
						}
						$query="";
						$values=array();
						
						
					}
					echo "Numero righe importate: ".$numero_righe."<br/><br/>";
				}else{	
					echo "</p><strong>Il file ELENCO_MOTORI_LED_LINEARI.xls non e&grave; presente nel server! Provare ad importarlo nuovamente</strong></p>";
				}
				mysql_close();
				break;	
				
			case "Regole fogli istruzioni":
				if (file_exists ('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls')){
					if (mysql_num_rows(mysql_query("SELECT * FROM regole_fogli_istruzione ;"))>0){
						if (!mysql_query("DELETE FROM regole_fogli_istruzione ;")){
							echo " Error on delete data....<br/>";
							break;
						}
					}
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls');
					$numero_righe=0;
					$values=array();
					$query=mysql_query("select column_name from information_schema.columns where table_name='regole_fogli_istruzione';");
					
					while ($rows = mysql_fetch_assoc($query)) {  //costruisco l'elenco dei campi tabella per la query di inserimento
						$campi_tabella[]=$rows['column_name'];
					}
					for ($i =2; $i <= $data->sheets[14]['numRows']; $i++) { //La prima riga sono le intestazioni dei campi
						if(empty($data->sheets[14]['cells'][$i][1]) or ($data->sheets[14]['cells'][$i][1])==""){
							break;
						}
						for($j=1;$j<=$data->sheets[14]['numCols'];$j++){
							if(empty($data->sheets[14]['cells'][$i][$j]) or $data->sheets[14]['cells'][$i][$j]==""){
								$values[]="";
							}else{
								$values[]=utf8_encode(trim(addslashes($data->sheets[14]['cells'][$i][$j])));
							}
						}
						$values[]=date("Ymd");
						
						$query="insert into regole_fogli_istruzione (" . implode(', ', $campi_tabella) .") VALUES ('" . implode("', '",$values). "');";
						if (!mysql_query($query)){
							echo $query." ===> NON INSERITA <br/>";
						}else{
							$numero_righe++;
						}
						$query="";
						$values=array();
						
						
					}
					echo "Numero righe importate: ".$numero_righe."<br/><br/>";
				}else{	
					echo "</p><strong>Il file ELENCO_MOTORI_LED_LINEARI.xls non e&grave; presente nel server! Provare ad importarlo nuovamente</strong></p>";
				}
				mysql_close();
				break;
				
			case "Regole imballi":
				if (file_exists ('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls')){
					if (mysql_num_rows(mysql_query("SELECT * FROM regole_imballi ;"))>0){
						if (!mysql_query("DELETE FROM regole_imballi ;")){
							echo " Error on delete data....<br/>";
							break;
						}
					}
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls');
					$numero_righe=0;
					$values=array();
					$query=mysql_query("select column_name from information_schema.columns where table_name='regole_imballi';");
					
					while ($rows = mysql_fetch_assoc($query)) {  //costruisco l'elenco dei campi tabella per la query di inserimento
						$campi_tabella[]=$rows['column_name'];
					}
					for ($i =2; $i <= $data->sheets[15]['numRows']; $i++) { //La prima riga sono le intestazioni dei campi
						if(empty($data->sheets[15]['cells'][$i][1]) or ($data->sheets[15]['cells'][$i][1])==""){
							break;
						}
						for($j=1;$j<=$data->sheets[15]['numCols'];$j++){
							if(empty($data->sheets[15]['cells'][$i][$j]) or $data->sheets[15]['cells'][$i][$j]==""){
								$values[]="";
							}else{
								$values[]=utf8_encode(trim(addslashes($data->sheets[15]['cells'][$i][$j])));
							}
						}
						$values[]=date("Ymd");
						
						$query="insert into regole_imballi (" . implode(', ', $campi_tabella) .") VALUES ('" . implode("', '",$values). "');";
						if (!mysql_query($query)){
							echo $query." ===> NON INSERITA <br/>";
						}else{
							$numero_righe++;
						}
						$query="";
						$values=array();
						
						
					}
					echo "Numero righe importate: ".$numero_righe."<br/><br/>";
				}else{	
					echo "</p><strong>Il file ELENCO_MOTORI_LED_LINEARI.xls non e&grave; presente nel server! Provare ad importarlo nuovamente</strong></p>";
				}
				mysql_close();
				break;
				
			case "Anagrafica barre led":
				
				/*CONTROLLO SE IL FILE � STATO CORRETTAMENTE IMPORTATO O ESISTE*/
				if (file_exists ('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls')){
					if (mysql_num_rows(mysql_query("SELECT * FROM anagrafica_barre_led ;"))>0){
						if (!mysql_query("DELETE FROM anagrafica_barre_led ;")){
							echo " Error on delete data....<br/>";
							break;
						}
					}
				
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls');
					$numero_righe=0;
					$values=array();
                                        
                    $query=mysql_query("select column_name from information_schema.columns where table_name='anagrafica_barre_led';");
					
					while ($rows = mysql_fetch_assoc($query)) {  //costruisco l'elenco dei campi tabella per la query di inserimento
						$campi_tabella[]=$rows['column_name'];
					}
                                        
					for ($i =2; $i <= $data->sheets[4]['numRows']; $i++) { //La prima riga sono le intestazioni dei campi
						if(empty($data->sheets[4]['cells'][$i][1]) or ($data->sheets[4]['cells'][$i][1])==""){
							break;
						}
						for($j=1;$j<=$data->sheets[4]['numCols'];$j++){
							if(empty($data->sheets[4]['cells'][$i][$j]) or $data->sheets[4]['cells'][$i][$j]==""){
								$values[]="";
							}else{
								$values[]=utf8_encode(trim(addslashes($data->sheets[4]['cells'][$i][$j])));
							}
						}
			
						$query="insert into anagrafica_barre_led (" . implode(', ', $campi_tabella) .") VALUES ('" . implode("', '",$values). "');";
						if (!mysql_query($query)){
							echo $query." ===> NON INSERITA <br/>";
						}else{
							$numero_righe++;
						}
						$query="";
						$values=array();
						
						
					}
					echo "Numero righe importate: ".$numero_righe."<br/><br/>";
				}else{	
					echo "</p><strong>Il file ELENCO_MOTORI_LED_LINEARI.xls non e&grave; presente nel server! Provare ad importarlo nuovamente</strong></p>";
				}
				break;
				mysql_close();
				
				
			case "Tipo luce":
				
				/*CONTROLLO SE IL FILE � STATO CORRETTAMENTE IMPORTATO O ESISTE*/
				if (file_exists ('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls')){
					if (mysql_num_rows(mysql_query("SELECT * FROM tipo_luce ;"))>0){		
						if (!mysql_query("DELETE FROM tipo_luce ;")){
							echo " Error on delete data....<br/>";
							break;
						}
						mysql_query("ALTER TABLE tipo_luce AUTO_INCREMENT = 1");//resetto il contatore a 1
					}
				
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls');
					$numero_righe=0;
					$values=array();
                                        
					for ($i =2; $i <= $data->sheets[0]['numRows']; $i++) { //La prima riga sono le intestazioni dei campi
						if(empty($data->sheets[0]['cells'][$i][1]) or ($data->sheets[0]['cells'][$i][1])==""){
							break;
						}
						for($j=1;$j<$data->sheets[0]['numCols'];$j++){
							if(empty($data->sheets[0]['cells'][$i][$j]) or $data->sheets[0]['cells'][$i][$j]==""){
								$values[]="";
							}else{
								$values[]=utf8_encode(trim(addslashes($data->sheets[0]['cells'][$i][$j])));
							}
						}
			
						$query="insert into tipo_luce (tipo_luce,temperatura_colore) VALUES ('" . implode("', '",$values). "');";
						if (!mysql_query($query)){
							echo $query." ===> NON INSERITA <br/>";
						}else{
							$numero_righe++;
						}
						$query="";
						$values=array();
						
						
					}
					echo "Numero righe importate: ".$numero_righe."<br/><br/>";
				}else{	
					echo "</p><strong>Il file ELENCO_MOTORI_LED_LINEARI.xls non e&grave; presente nel server! Provare ad importarlo nuovamente</strong></p>";
				}
				mysql_close();
				break;
				
			case "Motori led":
				
				/*CONTROLLO SE IL FILE � STATO CORRETTAMENTE IMPORTATO O ESISTE*/
				if (file_exists ('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls')){
					if (mysql_num_rows(mysql_query("SELECT * FROM motore_led ;"))>0){		
						if (!mysql_query("DELETE FROM motore_led ;")){
							echo " Error on delete data....<br/>";
							break;
						}					
					}
					$query=mysql_query("select column_name from information_schema.columns where table_name='motore_led';");
					
					while ($rows = mysql_fetch_assoc($query)) {  //costruisco l'elenco dei campi tabella per la query di inserimento
						$campi_tabella[]=$rows['column_name'];
					}
					
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls');
					$numero_righe=0;
					$values=array();
                                        
					for ($i =2; $i <= $data->sheets[1]['numRows']; $i++) { //La prima riga sono le intestazioni dei campi
						if(empty($data->sheets[1]['cells'][$i][1]) or ($data->sheets[1]['cells'][$i][1])==""){
							break;
						}
						for($j=1;$j<=$data->sheets[1]['numCols'];$j++){
							if(empty($data->sheets[1]['cells'][$i][$j]) or $data->sheets[1]['cells'][$i][$j]==""){
								$values[]="";
							}else{
								$values[]=utf8_encode(trim(addslashes($data->sheets[1]['cells'][$i][$j])));
								
							}
						}
						$values[]=date("Ymd");
						
						$query="insert into motore_led (" . implode(', ', $campi_tabella) .") VALUES ('" . implode("', '",$values). "');";
						if (!mysql_query($query)){
							echo $query." ===> NON INSERITA <br/>";
						}else{
							$numero_righe++;
						}
						$query="";
						$values=array();
						
						
					}
					echo "Numero righe importate: ".$numero_righe."<br/><br/>";
				}else{	
					echo "</p><strong>Il file ELENCO_MOTORI_LED_LINEARI.xls non e&grave; presente nel server! Provare ad importarlo nuovamente</strong></p>";
				}
				mysql_close();
				break;	
				
			case "Accessori":
				
				/*CONTROLLO SE IL FILE � STATO CORRETTAMENTE IMPORTATO O ESISTE*/
				if (file_exists ('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls')){
					if (mysql_num_rows(mysql_query("SELECT * FROM accessori ;"))>0){		
						if (!mysql_query("DELETE FROM accessori ;")){
							echo " Error on delete data....<br/>";
							break;
						}
						mysql_query("ALTER TABLE accessori AUTO_INCREMENT = 1");//resetto il contatore a 1
					}
				
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls');
					$numero_righe=0;
					$values=array();
                                        
					for ($i =2; $i <= $data->sheets[2]['numRows']; $i++) { //La prima riga sono le intestazioni dei campi
						if(empty($data->sheets[2]['cells'][$i][1]) or ($data->sheets[0]['cells'][$i][1])==""){
							break;
						}
						for($j=2;$j<=$data->sheets[2]['numCols'];$j++){//prima colonna id auto incrementale
							if(empty($data->sheets[2]['cells'][$i][$j]) or $data->sheets[2]['cells'][$i][$j]==""){
								$values[]="";
							}else{
								$values[]=utf8_encode(trim(addslashes($data->sheets[2]['cells'][$i][$j])));
							}
						}
			
						$query="insert into accessori (descrizione,descrizione_breve) VALUES ('" . implode("', '",$values). "');";
						if (!mysql_query($query)){
							echo $query." ===> NON INSERITA <br/>";
						}else{
							$numero_righe++;
						}
						$query="";
						$values=array();
						
						
					}
					echo "Numero righe importate: ".$numero_righe."<br/><br/>";
				}else{	
					echo "</p><strong>Il file ELENCO_MOTORI_LED_LINEARI.xls non e&grave; presente nel server! Provare ad importarlo nuovamente</strong></p>";
				}
				mysql_close();
				break;
				
			case "Prodotti lineari":
				
				/*CONTROLLO SE IL FILE � STATO CORRETTAMENTE IMPORTATO O ESISTE*/
				if (file_exists ('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls')){
					if (mysql_num_rows(mysql_query("SELECT * FROM prodotti_lineari ;"))>0){
						if (!mysql_query("DELETE FROM prodotti_lineari ;")){
							echo " Error on delete data....<br/>";
							break;
						}
					}
				
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls');
					$numero_righe=0;
					$values=array();
                                        
                    $query=mysql_query("select column_name from information_schema.columns where table_name='prodotti_lineari';");
					
					while ($rows = mysql_fetch_assoc($query)) {  //costruisco l'elenco dei campi tabella per la query di inserimento
						$campi_tabella[]=$rows['column_name'];
					}
                                        
					for ($i =2; $i <= $data->sheets[3]['numRows']; $i++) { //La prima riga sono le intestazioni dei campi
						if(empty($data->sheets[3]['cells'][$i][1]) or ($data->sheets[3]['cells'][$i][1])==""){
							break;
						}
						for($j=1;$j<=$data->sheets[3]['numCols'];$j++){
							if(empty($data->sheets[3]['cells'][$i][$j]) or $data->sheets[3]['cells'][$i][$j]==""){
								$values[]="";
							}else{
								$values[]=utf8_encode(trim(addslashes($data->sheets[3]['cells'][$i][$j])));
							}
						}
						$values[]=date("Ymd");
						
						$query="insert into prodotti_lineari (" . implode(', ', $campi_tabella) .") VALUES ('" . implode("', '",$values). "');";
						if (!mysql_query($query)){
							echo $query." ===> NON INSERITA <br/>";
						}else{
							$numero_righe++;
						}
						$query="";
						$values=array();
						
						
					}
					echo "Numero righe importate: ".$numero_righe."<br/><br/>";
				}else{	
					echo "</p><strong>Il file ELENCO_MOTORI_LED_LINEARI.xls non e&grave; presente nel server! Provare ad importarlo nuovamente</strong></p>";
				}
				break;
				mysql_close();	
				
			case "Prodotti - motori led":
				
				/*CONTROLLO SE IL FILE � STATO CORRETTAMENTE IMPORTATO O ESISTE*/
				if (file_exists ('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls')){
					if (mysql_num_rows(mysql_query("SELECT * FROM prodotto_lineare_motore_led ;"))>0){
						if (!mysql_query("DELETE FROM prodotto_lineare_motore_led ;")){
							echo " Error on delete data....<br/>";
							break;
						}
					}
				
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls');
					$numero_righe=0;
					$values=array();
                                        
                    $query=mysql_query("select column_name from information_schema.columns where table_name='prodotto_lineare_motore_led';");
					
					while ($rows = mysql_fetch_assoc($query)) {  //costruisco l'elenco dei campi tabella per la query di inserimento
						$campi_tabella[]=$rows['column_name'];
					}
                                        
					for ($i =2; $i <= $data->sheets[5]['numRows']; $i++) { //La prima riga sono le intestazioni dei campi
						if(empty($data->sheets[5]['cells'][$i][1]) or ($data->sheets[5]['cells'][$i][1])==""){
							break;
						}
						for($j=1;$j<=$data->sheets[5]['numCols'];$j++){
							if(empty($data->sheets[5]['cells'][$i][$j]) or $data->sheets[5]['cells'][$i][$j]==""){
								$values[]="";
							}else{
								$values[]=utf8_encode(trim(addslashes($data->sheets[5]['cells'][$i][$j])));
							}
						}
						$values[]=date("Ymd");
						
						$query="insert into prodotto_lineare_motore_led (" . implode(', ', $campi_tabella) .") VALUES ('" . implode("', '",$values). "');";
						if (!mysql_query($query)){
							echo $query." ===> NON INSERITA <br/>";
						}else{
							$numero_righe++;
						}
						$query="";
						$values=array();
						
						
					}
					echo "Numero righe importate: ".$numero_righe."<br/><br/>";
				}else{	
					echo "</p><strong>Il file ELENCO_MOTORI_LED_LINEARI.xls non e&grave; presente nel server! Provare ad importarlo nuovamente</strong></p>";
				}
				break;
				mysql_close();	
			
			case "Prodotti - accessori":
				
				/*CONTROLLO SE IL FILE � STATO CORRETTAMENTE IMPORTATO O ESISTE*/
				if (file_exists ('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls')){
					if (mysql_num_rows(mysql_query("SELECT * FROM prodotto_lineare_accessori ;"))>0){
						if (!mysql_query("DELETE FROM prodotto_lineare_accessori ;")){
							echo " Error on delete data....<br/>";
							break;
						}
					}
				
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls');
					$numero_righe=0;
					$values=array();
                                        
                    $query=mysql_query("select column_name from information_schema.columns where table_name='prodotto_lineare_accessori';");
					
					while ($rows = mysql_fetch_assoc($query)) {  //costruisco l'elenco dei campi tabella per la query di inserimento
						$campi_tabella[]=$rows['column_name'];
					}
                                        
					for ($i =2; $i <= $data->sheets[6]['numRows']; $i++) { //La prima riga sono le intestazioni dei campi
						if(empty($data->sheets[6]['cells'][$i][1]) or ($data->sheets[6]['cells'][$i][1])==""){
							break;
						}
						for($j=1;$j<=$data->sheets[6]['numCols'];$j++){
							if(empty($data->sheets[6]['cells'][$i][$j]) or $data->sheets[6]['cells'][$i][$j]==""){
								$values[]="";
							}else{
								$values[]=utf8_encode(trim(addslashes($data->sheets[6]['cells'][$i][$j])));
							}
						}
						$values[]=date("Ymd");
						
						$query="insert into prodotto_lineare_accessori (" . implode(', ', $campi_tabella) .") VALUES ('" . implode("', '",$values). "');";
						if (!mysql_query($query)){
							echo $query." ===> NON INSERITA <br/>";
						}else{
							$numero_righe++;
						}
						$query="";
						$values=array();
						
						
					}
					echo "Numero righe importate: ".$numero_righe."<br/><br/>";
				}else{	
					echo "</p><strong>Il file ELENCO_MOTORI_LED_LINEARI.xls non e&grave; presente nel server! Provare ad importarlo nuovamente</strong></p>";
				}
				break;
				mysql_close();	
			
			case "Esclusioni barre led su prodotti":
				
				/*CONTROLLO SE IL FILE � STATO CORRETTAMENTE IMPORTATO O ESISTE*/
				if (file_exists ('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls')){
					if (mysql_num_rows(mysql_query("SELECT * FROM  esclusioni_barra_led_prodotto_lineare ;"))>0){
						if (!mysql_query("DELETE FROM  esclusioni_barra_led_prodotto_lineare ;")){
							echo " Error on delete data....<br/>";
							break;
						}
					}
				
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls');
					$numero_righe=0;
					$values=array();
                                        
                    $query=mysql_query("select column_name from information_schema.columns where table_name=' esclusioni_barra_led_prodotto_lineare';");
					
					while ($rows = mysql_fetch_assoc($query)) {  //costruisco l'elenco dei campi tabella per la query di inserimento
						$campi_tabella[]=$rows['column_name'];
					}
                                        
					for ($i =2; $i <= $data->sheets[7]['numRows']; $i++) { //La prima riga sono le intestazioni dei campi
						if(empty($data->sheets[7]['cells'][$i][1]) or ($data->sheets[7]['cells'][$i][1])==""){
							break;
						}
						for($j=1;$j<=$data->sheets[7]['numCols'];$j++){
							if(empty($data->sheets[7]['cells'][$i][$j]) or $data->sheets[7]['cells'][$i][$j]==""){
								$values[]="";
							}else{
								$values[]=utf8_encode(trim(addslashes($data->sheets[7]['cells'][$i][$j])));
							}
						}
						$values[]=date("Ymd");
						
						$query="insert into  esclusioni_barra_led_prodotto_lineare (" . implode(', ', $campi_tabella) .") VALUES ('" . implode("', '",$values). "');";
						if (!mysql_query($query)){
							echo $query." ===> NON INSERITA <br/>";
						}else{
							$numero_righe++;
						}
						$query="";
						$values=array();
						
						
					}
					echo "Numero righe importate: ".$numero_righe."<br/><br/>";
				}else{	
					echo "</p><strong>Il file ELENCO_MOTORI_LED_LINEARI.xls non e&grave; presente nel server! Provare ad importarlo nuovamente</strong></p>";
				}
				break;
				mysql_close();	
			
			case "Ingombri":
				
				/*CONTROLLO SE IL FILE � STATO CORRETTAMENTE IMPORTATO O ESISTE*/
				if (file_exists ('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls')){
					if (mysql_num_rows(mysql_query("SELECT * FROM  ingombri_tecnici ;"))>0){
						if (!mysql_query("DELETE FROM  ingombri_tecnici ;")){
							echo " Error on delete data....<br/>";
							break;
						}
					}
				
					$data = new Spreadsheet_Excel_Reader();
					$data->setOutputEncoding('CP1251');
					$data->read('../Upload_file/ELENCO_MOTORI_LED_LINEARI.xls');
					$numero_righe=0;
					$values=array();
                                        
                    $query=mysql_query("select column_name from information_schema.columns where table_name=' ingombri_tecnici';");
					
					while ($rows = mysql_fetch_assoc($query)) {  //costruisco l'elenco dei campi tabella per la query di inserimento
						$campi_tabella[]=$rows['column_name'];
					}
                                        
					for ($i =2; $i <= $data->sheets[8]['numRows']; $i++) { //La prima riga sono le intestazioni dei campi
						if(empty($data->sheets[8]['cells'][$i][1]) or ($data->sheets[8]['cells'][$i][1])==""){
							break;
						}
						for($j=1;$j<=$data->sheets[8]['numCols'];$j++){
							if(empty($data->sheets[8]['cells'][$i][$j]) or $data->sheets[8]['cells'][$i][$j]==""){
								$values[]="";
							}else{
								$values[]=utf8_encode(trim(addslashes($data->sheets[8]['cells'][$i][$j])));
							}
						}
						$values[]=date("Ymd");
						
						$query="insert into  ingombri_tecnici (" . implode(', ', $campi_tabella) .") VALUES ('" . implode("', '",$values). "');";
						if (!mysql_query($query)){
							echo $query." ===> NON INSERITA <br/>";
						}else{
							$numero_righe++;
						}
						$query="";
						$values=array();
						
						
					}
					echo "Numero righe importate: ".$numero_righe."<br/><br/>";
				}else{	
					echo "</p><strong>Il file ELENCO_MOTORI_LED_LINEARI.xls non e&grave; presente nel server! Provare ad importarlo nuovamente</strong></p>";
				}
				break;
				mysql_close();	
			
			default:
				echo "function not implemented yet... please take a time!";
				mysql_close();
				break;
		}
		
	}else{
		echo "<p>Nothing selected soo nothing to do....</p>";
	
	}
	
	
?>